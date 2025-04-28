const editButton = document.getElementById('edit-profile-btn');
const editProfileForm = document.getElementById('edit-profile-form');
const profilePhotos = document.querySelectorAll('.profile-photo');
const bioText = document.getElementById('bio-text');


editButton.addEventListener('click', () => {

    if (editProfileForm.classList.contains('d-none')){
        editProfileForm.classList.remove('d-none');
    } else {
        editProfileForm.classList.add('d-none');
    }
});

editProfileForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(editProfileForm);

    fetch(editProfileForm.action, {
        method: 'POST',
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert(data.message);
                editProfileForm.classList.add('d-none');
                 
                location.reload();

                // Actualizar el contenido del perfil con los nuevos datos sin recargar la página
                // bioText.textContent = formData.get('bio') || bioText.textContent;
                // if (data.profile_photo_updated) {
                //     profilePhotos.forEach((photo) => {
                //         photo.src = '/../../../public/assets/images/profiles/' + data.user_id + '.' + data.profile_photo_type || photo.src;
                //     });
                // }
                
            } else {
                alert(data.error || 'Error al actualizar el perfil');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Error al actualizar el perfil');
        });
});