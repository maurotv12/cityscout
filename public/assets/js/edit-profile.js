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
                
            } else {
                alert(data.error || 'Error al actualizar el perfil');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Error al actualizar el perfil');
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
    usernameInput.addEventListener('input', function () {
        validateInput(usernameInput, 'username', (isValid) => usernameValid = isValid);
    });
    // Deshabilitar el botón al cargar la página si el nombre de usuario no es válido
    saveButton.disabled = !usernameValid;
});