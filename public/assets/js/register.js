document.addEventListener('DOMContentLoaded', function () {
    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');
    const registerButton = document.querySelector('button[type="submit"]');
    let usernameValid = false;
    let emailValid = false;

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
            registerButton.disabled = !(usernameValid && emailValid);
        });
    }

    usernameInput.addEventListener('input', function () {
        validateInput(usernameInput, 'username', (isValid) => usernameValid = isValid);
    });

    emailInput.addEventListener('input', function () {
        validateInput(emailInput, 'email', (isValid) => emailValid = isValid);
    });
});