let selectedInterests = [];
let allInterests = [];
let currentUserId = null;

// Utilidad para obtener el usuario logueado (puedes ajustar esto según tu backend)
function getCurrentUserId() {
    // Si tienes el id en una variable global, úsala. Si no, puedes obtenerlo de un atributo data en el body o similar.
    return window.currentUserId || null;
}

// Mostrar intereses al abrir el modal
function renderInterests(interests) {
    const container = document.querySelector('.interests-container .d-flex.flex-wrap');
    container.innerHTML = '';
    interests.forEach(interest => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'btn btn-light rounded-pill interest-btn mb-2';
        btn.textContent = interest.name;
        btn.dataset.id = interest.id;
        btn.onclick = () => toggleInterest(btn, interest.id);
        container.appendChild(btn);
    });
}

// Alternar selección de intereses
function toggleInterest(btn, interestId) {
    const idx = selectedInterests.indexOf(interestId);
    if (idx === -1) {
        selectedInterests.push(interestId);
        btn.classList.remove('btn-light');
        btn.classList.add('btn-dark');
    } else {
        selectedInterests.splice(idx, 1);
        btn.classList.remove('btn-dark');
        btn.classList.add('btn-light');
    }
    updateContinueBtn();
}

// Habilitar o deshabilitar el botón continuar
function updateContinueBtn() {
    const continueBtn = document.querySelector('#interestsModal .modal-footer .btn-primary');
    continueBtn.disabled = selectedInterests.length < 3;
}

// Mostrar/ocultar contenedores y botón atrás
function showInterestsContainer() {
    document.querySelector('.interests-container').classList.remove('d-none');
    document.querySelector('.suggestions-container').classList.add('d-none');
    document.querySelector('.interests-back-btn').classList.add('d-none');
}
function showSuggestionsContainer() {
    document.querySelector('.interests-container').classList.add('d-none');
    document.querySelector('.suggestions-container').classList.remove('d-none');
    document.querySelector('.interests-back-btn').classList.remove('d-none');
}

// Botón atrás
function returnInterestsList() {
    showInterestsContainer();
}

// Renderizar usuarios sugeridos
function renderSuggestions(users) {
    const container = document.querySelector('.suggestions-container');
    container.innerHTML = '';
    if (!users.length) {
        container.innerHTML = '<div class="text-center text-muted">No se encontraron usuarios con intereses en común.</div>';
        return;
    }
    users.forEach(user => {
        // Intereses en común
        const commonInterests = user.interests.map(i => allInterests.find(ai => ai.id == i.interest_id)?.name).filter(Boolean);
        // Botón seguir/dejar de seguir
        const isFollowing = user.isFollowing || false;
        const followBtnClass = isFollowing ? 'btn-primary' : 'btn-outline-primary';
        const followBtnText = isFollowing ? 'Dejar de seguir' : 'Seguir';

        container.innerHTML += `
        <div class="col-12 d-flex align-items-center border-0 justify-content-between mb-3">
            <div class="d-flex align-items-center">
                <img src="/assets/images/profiles/${user.id}.${user.profile_photo_type || 'png'}"
                    onerror="this.src='/assets/images/user-default.png';"
                    alt="${user.username}"
                    class="rounded-circle me-2"
                    style="width: 70px; height: 70px; object-fit: cover;">
                <div class="d-grid">
                    <a href="/profile/${user.id}" class="text-decoration-none text-body fw-bold">
                        ${user.fullname}
                    </a>
                    <small class="text-muted">@${user.username} • ${user.followersCount} seguidores</small>
                    <div class="d-flex align-items-center flex-wrap mt-1">
                        ${commonInterests.map(name => `<span class="badge bg-primary rounded-pill me-2 mb-1">${name}</span>`).join('')}
                    </div>
                </div>
            </div>
            <button class="btn btn-sm ${followBtnClass} follow-btn" 
                data-user-id="${user.id}" 
                data-following="${isFollowing}">
                ${followBtnText}
            </button>
        </div>
        `;
    });

    // Asignar eventos a los botones de seguir
    container.querySelectorAll('.follow-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.dataset.userId;
            toggleFollowSuggestion(this, userId);
        });
    });
}

// Alternar seguir/dejar de seguir en sugerencias
function toggleFollowSuggestion(btn, userId) {
    fetch(`/profile/${userId}/follow`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            btn.classList.toggle('btn-primary', data.following);
            btn.classList.toggle('btn-outline-primary', !data.following);
            btn.textContent = data.following ? 'Dejar de seguir' : 'Seguir';
            btn.dataset.following = data.following;
        }
    });
}

// Al hacer clic en continuar, cargar sugerencias
function onContinue() {
    showSuggestionsContainer();
    // Obtener usuarios recomendados
    fetch(`/user/recommendations?interests=${selectedInterests.join(',')}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Ordenar por cantidad de intereses en común (mayor a menor)
                const users = data.usersWithSimilarInterests.sort((a, b) => b.interests.length - a.interests.length);
                renderSuggestions(users);
            }
        });
}

// Inicialización al abrir el modal
document.addEventListener('DOMContentLoaded', function () {
    // Cargar intereses
    fetch('/interests')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                allInterests = data.interests;
                renderInterests(allInterests);
                showInterestsContainer();
                updateContinueBtn();
            }
        });

    // Botón continuar
    const continueBtn = document.querySelector('#interestsModal .modal-footer .btn-primary');
    continueBtn.addEventListener('click', onContinue);

    // Botón atrás
    document.querySelector('.interests-back-btn').addEventListener('click', returnInterestsList);
});