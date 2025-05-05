let containerChatList;
let containerChatMessages;

function returnChatList() {
    const chatBackBtn = document.querySelector('.chat-back-btn'); // Agrega la clase chat-back-btn
    chatModal.querySelector('.modal-title').textContent = "Chats";
    containerChatList.classList.remove('d-none');
    containerChatMessages.classList.add('d-none');
    chatBackBtn.classList.add('d-none'); // Oculta el botón de volver
}

document.addEventListener('DOMContentLoaded', function () {
    containerChatList = document.querySelector('.container-chat-list');
    containerChatMessages = document.getElementById('container-chat-messages');
    const chatList = document.querySelector('.chat-list ul');
    const chatMessages = document.querySelector('.chat-messages ul');
    const chatModal = document.getElementById('chatModal');
    const messageInput = document.getElementById('textAreaExample2');
    const sendButton = document.querySelector('.btn-info');
    let currentChatWithId = null;

    // Cargar lista de chats al abrir el modal
    chatModal.addEventListener('show.bs.modal', function () {
        loadChats();
    });

    // cerrar el modal y limpiar la lista de chats
    chatModal.addEventListener('hidden.bs.modal', function () {
        returnChatList();
        chatList.innerHTML = '';
        chatMessages.innerHTML = '';
        currentChatWithId = null;
        containerChatList.classList.remove('d-none');
        containerChatMessages.classList.add('d-none');
    });

    function loadChats() {
        fetch('/chats')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    chatList.innerHTML = '';
                    chatMessages.innerHTML = '';
                    data.chats.forEach(chat => {
                        const chatItem = document.createElement('li');
                        chatItem.classList.add('p-2', 'border-bottom', 'bg-body-tertiary');
                        chatItem.innerHTML = `
                            <a href="#!" class="d-flex justify-content-between" data-chat-with-id="${chat.user_id}">
                                <div class="d-flex flex-row">
                                    <img src="${chat.profile_photo}" alt="avatar" class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60" height="60">
                                    <div class="pt-1">
                                        <p class="fw-bold mb-0">${chat.fullname}</p>
                                        <p class="small text-muted">${chat.last_message_time}</p>
                                    </div>
                                </div>
                                <div class="pt-1">
                                    <span class="badge bg-danger float-end">${chat.unread_count}</span>
                                </div>
                            </a>
                        `;
                        chatList.appendChild(chatItem);

                        // Cargar mensajes al hacer clic en un chat
                        chatItem.querySelector('a').addEventListener('click', function () {
                            const chatBackBtn = document.querySelector('.chat-back-btn');
                            currentChatWithId = this.getAttribute('data-chat-with-id');
                            loadMessages(currentChatWithId);
                            chatModal.querySelector('.modal-title').textContent = chat.fullname;
                            chatModal.querySelector('.modal-body').scrollTop = 0;
                            containerChatList.classList.add('d-none');
                            containerChatMessages.classList.remove('d-none');
                            chatBackBtn.classList.remove('d-none');
                            let messageInterval = setInterval(() => loadMessages(currentChatWithId), 3000);

                            // Detener la actualización de mensajes al cerrar el modal o volver a la lista de chats
                            chatModal.addEventListener('hidden.bs.modal', function () {
                                clearInterval(messageInterval);
                            });

                            chatBackBtn.addEventListener('click', function () {
                                clearInterval(messageInterval);
                                loadChats();
                            });
                        });

                        
                    });
                }
            });
    }

    // Cargar mensajes de un chat
    function loadMessages(chatWithId) {
        fetch(`/chats/${chatWithId}/messages`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    chatMessages.innerHTML = '';
                    data.messages.forEach(message => {
                        addMesaggeToChat(message, chatWithId);
                    });

                    // Marcar mensajes como leídos
                    fetch(`/chats/${chatWithId}/read`, { method: 'POST' });
                }
            });
    }

    function addMesaggeToChat(message, chatWithId) {
        const messageItem = document.createElement('li');
        messageItem.classList.add('d-flex', 'justify-content-between', 'mb-4');
        const messageTime = new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const messageDate = new Date(message.created_at).toLocaleDateString([], { year: 'numeric', month: '2-digit', day: '2-digit' });
        const receivedMessageHTML = `
            <img src="${message.sender_profile_photo}" alt="avatar" class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
            <div class="card w-100">
                <div class="card-header d-flex justify-content-between p-3">
                    <p class="fw-bold mb-0">${message.sender_username}</p>
                    <p class="text-muted small mb-0"><i class="far fa-clock"></i>${messageDate} - ${messageTime}</p>
                </div>
                <div class="card-body">
                    <p class="mb-0">${message.message}</p>
                </div>
            </div>
        `;

        const sentMessageHTML = `
            <div class="card w-100">
                <div class="card-header d-flex justify-content-between p-3">
                    <p class="fw-bold mb-0">${message.sender_username}</p>
                    <p class="text-muted small mb-0"><i class="far fa-clock"></i>${messageDate} - ${messageTime}</p>
                </div>
                <div class="card-body">
                    <p class="mb-0">${message.message}</p>
                </div>
            </div>
            <img src="${message.sender_profile_photo}" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60">
        `;

        if (message.sender_id == chatWithId) {
            messageItem.innerHTML = receivedMessageHTML;
        } else {
            messageItem.innerHTML = sentMessageHTML;
        }

        chatMessages.appendChild(messageItem);
    }

    // Enviar mensaje
    sendButton.addEventListener('click', function () {
        const message = messageInput.value.trim();

        if (message && currentChatWithId) {
            fetch(`/chats/${currentChatWithId}/send`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        messageInput.value = '';
                        loadMessages(currentChatWithId);
                    }
                });
        }
    });
});