let followButton;

// Función para formatear números
// Esta función formatea números para que se muestren de manera legible
function formatNumber(number) {
    if (number < 10000) {
        // Mostrar números completos con punto de mil
        return number.toLocaleString('es-ES');
    } else if (number < 100000) {
        // Mostrar abreviación en miles (ejemplo: 10,5 mil)
        return (number / 1000).toFixed(1).replace('.', ',') + ' mil';
    } else if (number < 1000000) {
        // Mostrar abreviación en miles (ejemplo: 100,5 mil)
        return (number / 1000).toFixed(1).replace('.', ',') + ' mil';
    } else {
        // Mostrar abreviación en millones (ejemplo: 1,2 mill)
        return (number / 1000000).toFixed(1).replace('.', ',') + ' mill';
    }
}

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
            followersCount.textContent = formatNumber(data.followersCount);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    followButton = document.getElementById('follow-btn');
    
   // Formatear los contadores al cargar la página
    const followersCountElement = document.getElementById('followers-count');
    const followedCountElement = document.getElementById('followed-count');

    if (followersCountElement) {
      const followersCount = parseInt(followersCountElement.getAttribute('data-count'), 10);
      followersCountElement.textContent = formatNumber(followersCount);
    }

    if (followedCountElement) {
      const followedCount = parseInt(followedCountElement.getAttribute('data-count'), 10);
      followedCountElement.textContent = formatNumber(followedCount);
    }
  });