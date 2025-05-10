function toggleLike(button, postId) {
    const isLiked = button.getAttribute('data-post-liked-by-logged') === 'true';
    button.disabled = true; // Desactivar el botón mientras se procesa la solicitud

    // Enviar solicitud al servidor para dar o quitar like
    fetch(`/post/${postId}/like`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ like: !isLiked }), // Enviar true si no está "liked", false si ya lo está
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Alternar el estado del botón
                if (isLiked) {
                    button.setAttribute('data-post-liked-by-logged', 'false');
                    button.innerHTML = '<i class="bi bi-hand-thumbs-up"></i>';
                } else {
                    button.setAttribute('data-post-liked-by-logged', 'true');
                    button.innerHTML = '<i class="bi bi-hand-thumbs-up-fill"></i>';
                }

                // Actualizar el contador de likes
                const likeCountElement = button.closest('.card-text').querySelector('.like-count strong');
                const currentCount = parseInt(likeCountElement.textContent, 10);
                likeCountElement.textContent = isLiked ? currentCount - 1 : currentCount + 1;
            } else {
                alert('Error al actualizar el like.');
            }
        })
        .catch(error => {
            console.error('Error al actualizar el like:', error);
            alert('Error al actualizar el like.');
        })
        .finally(() => {
            button.disabled = false; // Reactivar el botón después de la solicitud
        });
}



document.addEventListener('DOMContentLoaded', function () {
    const likeButtons = document.querySelectorAll('.like-btn');
    validateLikes();

    function validateLikes() {
        likeButtons.forEach(button => {
            const isLiked = button.getAttribute('data-post-liked-by-logged') === 'true';
            
            if (isLiked) {
                button.classList.add('btn-success');
                button.innerHTML = '<i class="bi bi-hand-thumbs-up-fill"></i>';
            }
        });
    }

   
});