document.addEventListener('DOMContentLoaded', function () {
    const notificationDropdown = document.getElementById('notificationDropdown');
    const notificationCount = document.getElementById('notificationCount');
    const notificationMenu = document.querySelector('.dropdown-menu');
    const noNotifications = document.getElementById('noNotifications');
    loadNotifications();

    setInterval(() => loadNotifications(), 3000);

    function loadNotifications() {
        fetch('/notifications')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notifications = data.notifications;

                    // Limpiar el menú
                    notificationMenu.innerHTML = '';

                    if (notifications.length > 0) {
                        notifications.forEach(notification => {
                            const notificationItem = document.createElement('li');
                            notificationItem.classList.add('dropdown-item', 'd-flex', 'align-items-start');
                            notificationItem.innerHTML = `
                                <i class="bi ${getNotificationIcon(notification.type)} me-2"></i>
                                <div>
                                    <span class="notification-fullname notification-extra">${notification.sender.fullname}</span>
                                    <span class="notification-username "> (${notification.sender.username}) </span>
                                    <span class="notification-content"> ${notification.content}</span>
                                    <br>
                                    <small class="text-muted ">${new Date(notification.created_at).toLocaleString()}</small>
                                </div>
                            `;
                            // Redirigir al perfil si es follower
                            if (notification.type === 'follower') {
                                notificationItem.style.cursor = 'pointer';
                                notificationItem.addEventListener('click', function () {
                                    window.location.href = `/@${notification.sender.username}`;
                                });
                            }

                            if (notification.type === 'message') {
                                notificationItem.style.cursor = 'pointer';
                                notificationItem.addEventListener('click', function () {
                                    // --- INICIO: Disparar modal de chat y cargar conversación ---
                                    const chatModal = document.getElementById('chatModal');
                                    const containerChatList = document.querySelector('.container-chat-list');
                                    const containerChatMessages = document.getElementById('container-chat-messages');
                                    const chatBackBtn = document.querySelector('.chat-back-btn');
                                    const messageInput = document.getElementById('textAreaExample2');
                                    let currentChatWithId = notification.sender.id;

                                    // Mostrar el modal
                                    const bsModal = new bootstrap.Modal(chatModal);
                                    bsModal.show();

                                    // Espera a que el modal esté completamente visible antes de manipular el DOM interno
                                    chatModal.addEventListener('shown.bs.modal', function handler() {
                                        // Mostrar solo la vista de mensajes
                                        containerChatList.classList.add('d-none');
                                        containerChatMessages.classList.remove('d-none');
                                        chatBackBtn.classList.remove('d-none');
                                        // Limpiar input
                                        if (messageInput) messageInput.value = '';
                                        // Cambiar título
                                        chatModal.querySelector('.modal-title').textContent = notification.sender.fullname || "Chat";
                                        // Cargar mensajes usando la función global de chat.js
                                        if (typeof loadMessages === "function") {
                                            loadMessages(currentChatWithId);
                                        }
                                        // Guardar el id del chat actual si es necesario
                                        window.currentChatWithId = currentChatWithId;
                                        // Remover el handler para evitar múltiples ejecuciones
                                        chatModal.removeEventListener('shown.bs.modal', handler);
                                    });
                                    // --- FIN: Disparar modal de chat y cargar conversación ---
                                });
                            }

                            // Abrir modal de comentarios si es like
                            if ((notification.type === 'like' || notification.type === 'comment') && notification.post && notification.post.id) {
                                notificationItem.style.cursor = 'pointer';
                                notificationItem.addEventListener('click', function () {
                                    const commentsModalEl = document.getElementById('commentsModal');
                                    // Guardar los datos en el modal para que post.js los use
                                    commentsModalEl._fromNotification = true;
                                    commentsModalEl._notif_postId = notification.post.id;
                                    commentsModalEl._notif_isBlurred = notification.post.is_blurred;
                                    commentsModalEl._notif_postCaption = notification.post.caption;
                                    commentsModalEl._notif_postUsername = notification.post.user.username;
                                    commentsModalEl._notif_postUserId = notification.post.user.id;
                                    commentsModalEl._notif_postRoute = `/assets/images/posts/${notification.post.file_name}.${notification.post.type}`;
                                    commentsModalEl._notif_postType = notification.post.type;

                                    // Mostrar el modal (esto disparará show.bs.modal y ejecutará la lógica especial)
                                    const commentsModal = new bootstrap.Modal(commentsModalEl);
                                    commentsModal.show();
                                });
                            }



                            notificationMenu.appendChild(notificationItem);
                        });

                        // Actualizar el contador de notificaciones
                        notificationCount.textContent = notifications.filter(n => n.is_read === 0).length;
                    } else {
                        // Mostrar mensaje de "No hay notificaciones"
                        notificationMenu.innerHTML = '<li class="dropdown-item text-center text-muted">No hay notificaciones</li>';
                        notificationCount.textContent = 0;
                    }
                }
            })
            .catch(error => {
                console.error('Error al cargar las notificaciones:', error);
            });
    }

    // Cargar notificaciones al abrir el dropdown
    notificationDropdown.addEventListener('click', function () {
        loadNotifications();
        markAsRead();
    });

    // Marcar notificación como leída
    function markAsRead() {
        fetch('/notifications/read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    notificationCount.textContent = Math.max(0, notificationCount.textContent - 1);
                }
            })
            .catch(error => {
                console.error('Error al marcar la notificación como leída:', error);
            });
    }

    // Obtener el ícono según el tipo de notificación
    function getNotificationIcon(type) {
        switch (type) {
            case 'like':
                return 'bi-hand-thumbs-up';
            case 'comment':
                return 'bi-chat-dots';
            case 'message':
                return 'bi-envelope';
            case 'follow':
                return 'bi-person-plus';
            default:
                return 'bi-info-circle';
        }
    }
});