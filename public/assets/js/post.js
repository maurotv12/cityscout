document.addEventListener('DOMContentLoaded', function () {
    const commentsModal = document.getElementById('commentsModal');
    const modalBody = commentsModal.querySelector('.comments');

    commentsModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Botón que activó el modal
        const postId = button.getAttribute('data-post-id'); // Obtener el ID del post

        // Limpiar el contenido del modal
        modalBody.innerHTML = '<p>Cargando comentarios...</p>';

        // Hacer una solicitud AJAX para obtener los comentarios
        fetch(`/post/${postId}/comments`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Generar el HTML de los comentarios
                    let commentsHtml = '';
                    data.comments.forEach(comment => {
                        commentsHtml += `
                            <div class="row d-flex justify-content-center mb-2">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-start align-items-center">
                                                <img class="rounded-circle shadow-1-strong me-3"
                                                    src="${comment.user.profile_photo ?? '/assets/images/user-default.png'}" alt="avatar" width="40" height="40" />
                                                <div>
                                                    <h6 class="fw-bold text-primary mb-1">${comment.user.fullname}</h6>
                                                    <p class="text-muted small mb-0">
                                                        ${comment.created_at}
                                                    </p>
                                                </div>
                                            </div>
                                            <p class="mt-3">${comment.comment}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    modalBody.innerHTML = commentsHtml;
                } else {
                    modalBody.innerHTML = '<p>No se pudieron cargar los comentarios1.</p>';
                }
            })
            .catch(error => {
                console.error('Error al cargar los comentarios:', error);
                modalBody.innerHTML = '<p>Error al cargar los comentarios2.</p>';
            });
    
        });
});