const editButton = document.getElementById('edit-profile-btn');
const editProfileForm = document.getElementById('edit-profile-form');
const profilePhotos = document.querySelectorAll('.profile-photo');
const bioText = document.getElementById('bio-text');


if (editButton) editButton.addEventListener('click', () => {

    if (editProfileForm.classList.contains('d-none')) {
        editProfileForm.classList.remove('d-none');
    } else {
        editProfileForm.classList.add('d-none');
    }
});

if (editProfileForm) editProfileForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(editProfileForm);

    fetch(editProfileForm.action, {
        method: 'POST',
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Perfil actualizado!',
                    text: data.message || 'Los cambios se guardaron correctamente.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    editProfileForm.classList.add('d-none');
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.error || 'Error al actualizar el perfil',
                    confirmButtonText: 'Aceptar'
                });
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al actualizar el perfil',
                confirmButtonText: 'Aceptar'
            });
        });
});

document.addEventListener('DOMContentLoaded', function () {
    const usernameInput = document.getElementById('username');
    const saveButton = document.getElementById('save-changes-btn');
    let usernameValid = true;

    // Función para verificar disponibilidad en la base de datos
    function checkAvailability(field, value, callback) {
        if (!value.trim()) {
            callback({ success: false, message: `${field} no puede estar vacío.` });
            return;
        }

        fetch(`/check-availability?field=${field}&value=${encodeURIComponent(value)}`)
            .then(response => response.json())
            .then(data => callback(data))
            .catch(error => console.error('Error:', error));
    }

    // Función para validar el campo de entrada
    function validateInput(input, field, setValidFlag) {
        const feedback = input.nextElementSibling || document.createElement('small');
        feedback.classList.add('form-text', 'text-danger');
        input.parentNode.appendChild(feedback);

        checkAvailability(field, input.value, function (data) {
            if (!data.success) {
                feedback.textContent = data.message;
                setValidFlag(false);
            } else {
                feedback.textContent = '';
                setValidFlag(true);
            }
            saveButton.disabled = !usernameValid; // Deshabilitar botón si no es válido
        });
    }

    // Evento para verificar el nombre de usuario en tiempo real
    if (usernameInput) usernameInput.addEventListener('input', function () {
        validateInput(usernameInput, 'username', (isValid) => usernameValid = isValid);
    });
    // Deshabilitar el botón al cargar la página si el nombre de usuario no es válido
    if (saveButton) saveButton.disabled = !usernameValid;
});