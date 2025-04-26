document.addEventListener('DOMContentLoaded', function () {
    const likeButtons = document.querySelectorAll('.like-btn');

    likeButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault(); // Prevenir comportamiento predeterminado de recargar la pagina

            const postId = this.getAttribute('data-post-id'); // Obtener el ID del post del botón clicado
            const isLiked = this.classList.contains('btn-success'); // Verificar si ya está "liked"
            button.disabled = true;
            // Enviar solicitud al servidor para dar o quitar like
            fetch(`/post/${postId}/like`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ like: !isLiked }), // Enviar true si no está "liked", false si ya lo está
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Alternar el estado del botón clicado
                        if (isLiked) {
                            this.classList.remove('btn-success');
                            this.classList.add('btn-primary');
                            this.innerHTML = '<i class="bi bi-hand-thumbs-up"></i>';
                        } else {
                            this.classList.remove('btn-primary');
                            this.classList.add('btn-success');
                            this.innerHTML = '<i class="bi bi-hand-thumbs-up-fill"></i>';
                        }
                    } else {
                        alert('Error al actualizar el like');
                    }
                })
                .finally(() => {
                    button.disabled = false; // Reactiva el botón después de la petición
                })
                .catch(error => console.error('Error:', error));
        });
    });
});