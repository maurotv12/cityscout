let searchTimeout;

function searchUsers(query) {
    const resultsContainer = document.getElementById('search-results');

    // Limpiar resultados si no hay texto
    if (!query.trim()) {
        resultsContainer.innerHTML = '';
        resultsContainer.classList.add('d-none');
        return;
    }

    // Cancelar solicitudes anteriores
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }

    // Esperar 300ms antes de realizar la solicitud
    searchTimeout = setTimeout(() => {
        fetch(`/search/users?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar resultados
                    resultsContainer.innerHTML = data.users.map(user => `
                        <li class="list-group-item d-flex align-items-center border-0 ">
                            <img src="/assets/images/profiles/${user.id}.${user.profile_photo_type}" 
                                 onerror="this.src='/assets/images/user-default.png';" 
                                 alt="${user.username}" 
                                 class="rounded-circle me-2" 
                                 style="width: 30px; height: 30px; object-fit: cover;">
                            <a href="/@${user.username}" class="text-decoration-none text-body">
                                ${user.fullname} (@${user.username})
                            </a>
                        </li>
                    `).join('');
                    resultsContainer.classList.remove('d-none');
                } else {
                    resultsContainer.innerHTML = '<li class="list-group-item text-muted">No se encontraron usuarios.</li>';
                    resultsContainer.classList.remove('d-none');
                }
            })
            .catch(error => {
                console.error('Error al buscar usuarios:', error);
                resultsContainer.innerHTML = '<li class="list-group-item text-danger">Error al buscar usuarios.</li>';
                resultsContainer.classList.remove('d-none');
            });
    }, 300);
}

