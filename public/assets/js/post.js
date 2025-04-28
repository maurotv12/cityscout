document.addEventListener('DOMContentLoaded', function () {
    const commentsModal = document.getElementById('commentsModal');
    const modalBody = commentsModal.querySelector('.comments');
    const editCaptionBtn = document.getElementById('edit-caption-btn');
    const editCaptionForm = document.getElementById('edit-caption-form');
    const newCaptionInput = document.getElementById('new-caption');
    const cancelEditCaptionBtn = document.getElementById('cancel-edit-caption');


    commentsModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Botón que activó el modal
        const postId = button.getAttribute('data-post-id'); // Obtener el ID del post
        const postCaption = button.getAttribute('data-post-caption'); // Obtener la caption del post

        const postUsername = button.getAttribute('data-post-username'); // Obtener el username del post
        const postUserId = button.getAttribute('data-post-userId'); // Obtener el username del post
        const postRoute = button.getAttribute('data-post-route'); // Obtener la ruta del post
        const postType = button.getAttribute('data-post-type'); // Obtener el tipo del post

        const modalMedia = commentsModal.querySelector('.modal-media'); // Obtener el contenedor de la media del modal
        const modalPostUsername = commentsModal.querySelector('.modal-post-username');// Obtener el contenedor del username del modal
        const modalPostCaption = commentsModal.querySelector('.modal-post-caption'); 

        // const modalPostImage = commentsModal.querySelector('.modal-post-image');


        modalPostUsername.innerHTML = `<a href="/profile/${postUserId}">${postUsername}</a>`;
        modalPostCaption.innerHTML = postCaption;
        // modalPostImage.setAttribute('src', postRoute);
        modalMedia.innerHTML = '';

        // Renderizar dinámicamente imagen o video
        if (postType === 'mp4') {
            // Renderizar video
            const video = document.createElement('video');
            video.setAttribute('controls', '');
            video.setAttribute('style', 'width: 100%; max-height: 400px; object-fit: cover;');
            const source = document.createElement('source');
            source.setAttribute('src', postRoute);
            source.setAttribute('type', 'video/mp4');
            video.appendChild(source);
            modalMedia.appendChild(video);
        } else {
            // Renderizar imagen
            const img = document.createElement('img');
            img.setAttribute('src', postRoute);
            img.setAttribute('alt', 'Post Media');
            img.setAttribute('style', 'width: 100%; max-height: 400px; object-fit: cover;');
            modalMedia.appendChild(img);
        }

        // Actualizar el contenido del modal de comentarios
        // Limpiar el contenido del modal de comentarios
        modalPostCaption.textContent = postCaption;
        newCaptionInput.value = postCaption;

        // Mostrar el botón de editar y ocultar el formulario
        editCaptionBtn.classList.remove('d-none');
        editCaptionForm.classList.add('d-none');

        // Limpiar el contenido del modal de comentarios
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
                    modalBody.innerHTML = '<p>' + data.message + '</p>';
                }
            })
            .catch(error => {
                console.error('Error al cargar los comentarios:', error);
                modalBody.innerHTML = '<p>Error al cargar los comentarios.</p>';
            });
    });


    // Mostrar el formulario de edición al hacer clic en "Editar descripción"
    editCaptionBtn.addEventListener('click', () => {
        editCaptionBtn.classList.add('d-none');
        editCaptionForm.classList.remove('d-none');
    });

    // Cancelar la edición
    cancelEditCaptionBtn.addEventListener('click', () => {
        editCaptionForm.classList.add('d-none');
        editCaptionBtn.classList.remove('d-none');
    });

    // Manejar el envío del formulario para actualizar el caption
    editCaptionForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const postId = commentsModal.querySelector('[data-post-id]').getAttribute('data-post-id');
        const newCaption = newCaptionInput.value;

        fetch(`/post/${postId}/update-caption`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                caption: newCaption
            }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    modalPostCaption.textContent = newCaption;
                    editCaptionForm.classList.add('d-none');
                    editCaptionBtn.classList.remove('d-none');
                    alert('Descripción actualizada correctamente.');
                } else {
                    alert('Error al actualizar la descripción.');
                }
            })
            .catch(error => {
                console.error('Error al actualizar la descripción:', error);
                alert('Error al actualizar la descripción.');
            });
    });
});