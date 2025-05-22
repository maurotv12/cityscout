let followButton;

// Función para alternar el estado de seguir/dejar de seguir
// y actualizar el contador de seguidores
function toggleFollow(userId) {
    fetch(`/profile/${userId}/follow`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.following) {
                followButton.classList.remove('btn-outline-primary');
                followButton.classList.add('btn-primary');
                followButton.textContent = 'Dejar de seguir';
            } else {
                followButton.classList.remove('btn-primary');
                followButton.classList.add('btn-outline-primary');
                followButton.textContent = 'Seguir';
            }

            const followersCount = document.getElementById('followers-count');
            followersCount.textContent = (data.followersCount);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    followButton = document.getElementById('follow-btn');
  });