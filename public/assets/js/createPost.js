document.addEventListener('DOMContentLoaded', function () {
    const createPostForm = document.getElementById('createPostForm');

    createPostForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(createPostForm);

        fetch('/post/store', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    createPostForm.reset();
                    const modal = bootstrap.Modal.getInstance(document.getElementById('createPostModal'));
                    modal.hide();
                    // Opcional: Recargar la página o actualizar el feed dinámicamente
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al crear la publicación.');
            });
    });
});