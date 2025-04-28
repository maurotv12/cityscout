document.addEventListener('DOMContentLoaded', function () {
    const notificationDropdown = document.getElementById('notificationDropdown');
    const notificationCount = document.getElementById('notificationCount');
    const notificationMenu = document.querySelector('.dropdown-menu');
    const noNotifications = document.getElementById('noNotifications');

    // Cargar notificaciones al abrir el dropdown
    notificationDropdown.addEventListener('click', function () {
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
                                    <p class="mb-0">${notification.content}</p>
                                    <small class="text-muted">${new Date(notification.created_at).toLocaleString()}</small>
                                </div>
                            `;
                            notificationItem.addEventListener('click', () => markAsRead(notification.id));
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
    });

    // Marcar notificación como leída
    function markAsRead(notificationId) {
        fetch('/notifications/read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ notification_id: notificationId }),
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
            default:
                return 'bi-info-circle';
        }
    }
});