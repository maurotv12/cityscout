document.addEventListener('DOMContentLoaded', function () {
    const createPostForm = document.getElementById('createPostForm');
    const filesInput = document.getElementById('files');

    createPostForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const files = filesInput.files;
        let pendingVideos = 0;
        let invalid = false;

        // Validar videos antes de enviar
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const ext = file.name.split('.').pop().toLowerCase();
            if (['mp4'].includes(ext)) {
                pendingVideos++;
                const url = URL.createObjectURL(file);
                const video = document.createElement('video');
                video.preload = 'metadata';
                video.src = url;
                video.onloadedmetadata = function () {
                    URL.revokeObjectURL(url);
                    // Validar duración
                    if (video.duration > 600) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Duración excedida',
                            text: `El video "${file.name}" supera los 10 minutos.`,
                        });
                        invalid = true;
                    }
                    // Validar resolución
                    if (video.videoWidth > 1920 || video.videoHeight > 1080) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Resolución excedida',
                            text: `El video "${file.name}" supera la resolución Full HD (1920x1080).`,
                        });
                        invalid = true;
                    }
                    pendingVideos--;
                    if (pendingVideos === 0 && !invalid) {
                        submitForm();
                    }
                };
                video.onerror = function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: `No se pudo leer el video "${file.name}".`,
                    });
                    invalid = true;
                    pendingVideos--;
                    if (pendingVideos === 0 && !invalid) {
                        submitForm();
                    }
                };
            }
        }

        // Si no hay videos, enviar el formulario directamente
        if (pendingVideos === 0 && !invalid) {
            submitForm();
        }

        function submitForm() {
            const formData = new FormData(createPostForm);
            fetch('/post/store', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Publicación creada!',
                            text: data.message,
                        });
                        createPostForm.reset();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('createPostModal'));
                        modal.hide();
                        // Opcional: Recargar la página o actualizar el feed dinámicamente
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al crear la publicación.',
                    });
                });
        }
    });
});

