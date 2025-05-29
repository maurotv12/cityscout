let selectedInterests = [];
let allInterests = [];
let currentUserId = null;

// Utilidad para obtener el usuario logueado (puedes ajustar esto según tu backend)
function getCurrentUserId() {
    // Si tienes el id en una variable global, úsala. Si no, puedes obtenerlo de un atributo data en el body o similar.
    return window.currentUserId || null;
}

// Mostrar intereses al abrir el modal
function renderInterests(data) {
    const container = document.querySelector('.interests-container .interests-btns');
    container.innerHTML = '';
    data.interests.forEach(interest => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'btn rounded-pill interest-btn mb-2' + (data.userInterests.includes(interest.id) ? ' btn-dark' : ' btn-light');
        btn.textContent = interest.name;
        btn.dataset.id = interest.id;
        btn.onclick = () => toggleInterest(btn, interest.id);
        container.appendChild(btn);
    });
    selectedInterests = data.userInterests;
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
    const continueBtn = document.querySelector('#interestsModal #continue-btn');
    continueBtn.disabled = selectedInterests.length < 3;
}

// Mostrar/ocultar contenedores y botón atrás
function showInterestsContainer() {
    document.querySelector('.interests-container').classList.remove('d-none');
    document.querySelector('.suggestions-container').classList.add('d-none');
    document.querySelector('.interests-back-btn').classList.add('d-none');
    // Restaurar botón a "Continuar" y funcionalidad original
    const continueBtn = document.querySelector('#interestsModal #continue-btn');
    continueBtn.textContent = 'Continuar';
    continueBtn.onclick = onContinue;
}
function showSuggestionsContainer() {
    document.querySelector('.interests-container').classList.add('d-none');
    document.querySelector('.suggestions-container').classList.remove('d-none');
    document.querySelector('.interests-back-btn').classList.remove('d-none');
    // Cambiar botón a "Terminar" y funcionalidad para cerrar el modal
    const continueBtn = document.querySelector('#interestsModal #continue-btn');
    continueBtn.textContent = 'Terminar';
    continueBtn.onclick = function() {
        // Cerrar modal Bootstrap 5
        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('interestsModal'));
        modal.hide();
         // Espera a que el modal termine de ocultarse antes de recargar
        document.getElementById('interestsModal').addEventListener('hidden.bs.modal', function handler() {
            location.reload();
            // Remueve el listener para evitar recargas múltiples
            this.removeEventListener('hidden.bs.modal', handler);
        });
    };
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
                    <a href="/@${user.username}" class="text-decoration-none text-body fw-bold">
                        ${user.fullname}
                    </a>
                    <small class="text-muted">@${user.username} • ${user.followersCount} seguidores</small>
                    <div class="d-flex align-items-center flex-wrap mt-1">
                        ${user.interests.map(interest => `<span class="badge bg-primary rounded-pill me-2 mb-1">${interest}</span>`).join('')}
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
    // Guardar intereses seleccionados en el backend
    fetch('/user/interests', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ interests: selectedInterests })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showSuggestionsContainer();
            // Obtener usuarios recomendados
            fetch(`/user/recommendations`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Ordenar por cantidad de intereses en común (mayor a menor)
                        const users = data.usersWithSimilarInterests.sort((a, b) => b.interests.length - a.interests.length);
                        renderSuggestions(users);
                    }
                });
        } else {
            alert(data.message || 'Error al guardar intereses');
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
                renderInterests(data);
                showInterestsContainer();
                updateContinueBtn();
            }
        });

    // Botón continuar
    const continueBtn = document.querySelector('#interestsModal .modal-footer .btn-continue');
    continueBtn.addEventListener('click', onContinue);

    // Botón atrás
    document.querySelector('.interests-back-btn').addEventListener('click', returnInterestsList);
});