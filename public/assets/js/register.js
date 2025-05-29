document.addEventListener('DOMContentLoaded', function () {
    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');
    const registerButton = document.getElementById('register-button');

    const usernameFeedback = document.querySelector('#username + small');
    const emailFeedback = document.querySelector('#email + small');

    let usernameValid = false;
    let emailValid = false;

    function checkAvailability(field, value) {
        return fetch(`/check-availability?field=${field}&value=${encodeURIComponent(value)}`)
            .then(response => response.json())
            .catch(() => ({ success: false, message: 'Error al verificar.' }));
    }

    function validateInput(input, field, feedbackElement, setValidFlag) {
        const value = input.value.trim();
        if (!value) {
            feedbackElement.textContent = `${field === 'username' ? 'Nombre de usuario' : 'Correo'} no puede estar vacío.`;
            feedbackElement.style.display = 'block';
            setValidFlag(false);
            updateButtonState();
            return;
        }

        checkAvailability(field, value).then(data => {
            if (!data.success) {
                feedbackElement.textContent = data.message;
                feedbackElement.style.display = 'block';
                setValidFlag(false);
            } else {
                feedbackElement.textContent = '';
                feedbackElement.style.display = 'none';
                setValidFlag(true);
            }
            updateButtonState();
        });
    }

    function updateButtonState() {
        registerButton.disabled = !(usernameValid && emailValid);
    }

    usernameInput.addEventListener('input', () => {
        validateInput(usernameInput, 'username', usernameFeedback, (isValid) => { usernameValid = isValid; });
    });

    emailInput.addEventListener('input', () => {
        validateInput(emailInput, 'email', emailFeedback, (isValid) => { emailValid = isValid; });
    });

    registerButton.disabled = true;
});

