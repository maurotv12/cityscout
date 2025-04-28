document.addEventListener('DOMContentLoaded', function () {
    const chatList = document.querySelector('.chat-list ul');
    const chatMessages = document.querySelector('.scrollable-row ul');
    const chatModal = document.getElementById('chatModal');
    const messageInput = document.getElementById('textAreaExample2');
    const sendButton = document.querySelector('.btn-info');
    let currentChatWithId = null;

    // Cargar lista de chats al abrir el modal
    chatModal.addEventListener('show.bs.modal', function () {
        fetch('/chats')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    chatList.innerHTML = '';
                    data.chats.forEach(chat => {
                        const chatItem = document.createElement('li');
                        chatItem.classList.add('p-2', 'border-bottom', 'bg-body-tertiary');
                        chatItem.innerHTML = `
                            <a href="#!" class="d-flex justify-content-between" data-chat-with-id="${chat.user_id}">
                                <div class="d-flex flex-row">
                                    <img src="${chat.profile_photo}" alt="avatar" class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
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
                            currentChatWithId = this.getAttribute('data-chat-with-id');
                            loadMessages(currentChatWithId);
                        });
                    });
                }
            });
    });

    // Cargar mensajes de un chat
    function loadMessages(chatWithId) {
        fetch(`/chats/${chatWithId}/messages`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    chatMessages.innerHTML = '';
                    data.messages.forEach(message => {
                        const messageItem = document.createElement('li');
                        messageItem.classList.add('d-flex', 'justify-content-between', 'mb-4');
                        messageItem.innerHTML = `
                            <div class="card ${message.sender_id == currentChatWithId ? 'w-100' : ''}">
                                <div class="card-body">
                                    <p class="mb-0">${message.message}</p>
                                </div>
                            </div>
                        `;
                        chatMessages.appendChild(messageItem);
                    });

                    // Marcar mensajes como leídos
                    fetch(`/chats/${chatWithId}/read`, { method: 'POST' });
                }
            });
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