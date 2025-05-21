let followButton;

function formatNumber(count) {
    if (typeof count !== 'number' || isNaN(count)) {
        return 'N/A'; // Manejar casos no numéricos o inválidos
    }

    const absCount = Math.abs(count); // Asegurar que sea positivo para el formateo

    // Configuración de formato para diferentes rangos
    if (absCount < 10000) {
        // Ej: 123, 9.876
        return count.toLocaleString('es-ES');
    } else if (absCount < 1000000) {
        // Ej: 10,5 mil, 123,4 mil (K para miles)
        const formatted = new Intl.NumberFormat('es-ES', {
            minimumFractionDigits: 1,
            maximumFractionDigits: 1,
        }).format(count / 1000);
        return formatted + ' mil'; // O 'K' si prefieres una abreviación más universal
    } else if (absCount < 1000000000) { // Hasta 999.9 millones
        // Ej: 1,2 mill, 123,4 mill (M para millones)
        const formatted = new Intl.NumberFormat('es-ES', {
            minimumFractionDigits: 1,
            maximumFractionDigits: 1,
        }).format(count / 1000000);
        return formatted + ' mill.'; // O 'M'
    } else { // Más de mil millones (B para billones)
        // Ej: 1,2 mil mill. (B para billones)
        const formatted = new Intl.NumberFormat('es-ES', {
            minimumFractionDigits: 1,
            maximumFractionDigits: 1,
        }).format(count / 1000000000);
        return formatted + ' mil mill.'; // O 'B'
    }
}

// function formatNumber(number) {
//     if (number < 10000) {
//         // Mostrar números completos con punto de mil
//         return number.toLocaleString('es-ES');
//     } else if (number < 1000000) {
//         // Mostrar abreviación en miles (ejemplo: 10,4 mil, 100,4 mil)
//         let miles = Math.floor(number / 100) / 10; // Truncar a 1 decimal
//         return miles.toString().replace('.', ',') + ' mil';
//     } else {
//         // Mostrar abreviación en millones (ejemplo: 8,4 mill)
//         let millones = Math.floor(number / 100000) / 10; // Truncar a 1 decimal
//         return millones.toString().replace('.', ',') + ' mill';
//     }
// }




// // formatear números
// function formatNumber(number) {
//     if (number < 10000) {
//         // Mostrar números completos con punto de mil
//         return number.toLocaleString('es-ES');
//     } else if (number < 100000) {
//         // Mostrar abreviación en miles (ejemplo: 10,5 mil)
//         return (number / 1000).toFixed(1).replace('.', ',') + ' mil';
//     } else if (number < 1000000) {
//         // Mostrar abreviación en miles (ejemplo: 100,5 mil)
//         return (number / 1000).toFixed(1).replace('.', ',') + ' mil';
//     } else {
//         // Mostrar abreviación en millones (ejemplo: 1,2 mill)
//         return (number / 1000000).toFixed(1).replace('.', ',') + ' mill';
//     }
// }

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