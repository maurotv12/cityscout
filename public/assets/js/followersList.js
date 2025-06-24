document.addEventListener('DOMContentLoaded', function () {
    const followersLinks = document.querySelectorAll('.followers-link');
    const followingLinks = document.querySelectorAll('.following-link');
    const modal = new bootstrap.Modal(document.getElementById('followersModal'));
    const modalTitle = document.getElementById('followersModalLabel');
    const listContainer = document.getElementById('followers-list-container');

    // Obtén el username del usuario actual mostrado en la página
    const userId = window.profileId; // Debes definir esto en tu vista PHP

    let followers = [];
    let following = [];
    let currentUserId = window.currentUserId || null;

    // Función para cargar los datos desde el backend
    function loadFollowersList(callback) {
        fetch(`/${userId}/followers-list`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    followers = data.followers || [];
                    following = data.following || [];
                    currentUserId = data.user && data.user.id ? data.user.id : null;
                    if (typeof callback === 'function') callback();
                }
            });
    }

    followersLinks.forEach(el => {
        el.addEventListener('click', function () {
            loadFollowersList(function () {
                modalTitle.textContent = 'Seguidores';
                renderUsers(followers);
                modal.show();
            });
        });
    });

    followingLinks.forEach(el => {
        el.addEventListener('click', function () {
            loadFollowersList(function () {
                modalTitle.textContent = 'Seguidos';
                renderUsers(following);
                modal.show();
            });
        });
    });



    function renderUsers(users) {
        listContainer.innerHTML = '';
        if (!users.length) {
            listContainer.innerHTML = '<div class="text-center text-muted">No hay usuarios para mostrar.</div>';
            return;
        }
        users.forEach(user => {
            const isFollowing = !!user.is_following;
            const followBtnClass = isFollowing ? 'btn-primary' : 'btn-outline-primary';
            const followBtnText = isFollowing ? 'Dejar de seguir' : 'Seguir';

            const userHtml = `
                <div class="d-flex align-items-center justify-content-between border-0 mb-3">
                    <div class="d-flex align-items-center">
                        <img src="/assets/images/profiles/${user.id}.${user.profile_photo_type || 'png'}"
                            onerror="this.src='/assets/images/user-default.png';"
                            alt="${user.username}"
                            class="rounded-circle me-2"
                            style="width: 60px; height: 60px; object-fit: cover;">
                        <div class="d-grid">
                            <a href="/@${user.username}" class="text-decoration-none text-body fw-bold">
                                ${user.fullname}
                            </a>
                            <small class="text-muted">@${user.username}</small>
                        </div>
                    </div>
                    ${user.id !== currentUserId ? `
                    <button class="btn btn1 btn-sm ${followBtnClass} follow-btn" 
                        data-user-id="${user.id}" 
                        data-following="${isFollowing}">
                        ${followBtnText}
                    </button>
                    ` : ''}
                </div>
            `;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = userHtml;
            listContainer.appendChild(wrapper);

            // Botón seguir/dejar de seguir
            const followBtn = wrapper.querySelector('.follow-btn');
            if (followBtn) {
                followBtn.addEventListener('click', function () {
                    toggleFollow(this, user.id);
                });
            }


        });

    }

    function toggleFollow(btn, userId) {
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
});