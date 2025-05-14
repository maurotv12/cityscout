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



// document.addEventListener('DOMContentLoaded', function () {
//     const usernameInput = document.getElementById('username');
//     const emailInput = document.getElementById('email');
//     const registerButton = document.getElementById('register-button');
//     const usernameFeedback = usernameInput.nextElementSibling;
//     const emailFeedback = emailInput.nextElementSibling;

//     let usernameValid = false;
//     let emailValid = false;

//     function updateButtonState() {
//         registerButton.disabled = !(usernameValid && emailValid);
//     }

//     function checkAvailability(field, value) {
//         return new Promise((resolve) => {
//             if (!value.trim()) {
//                 resolve({ success: false, message: `${field === 'username' ? 'Nombre de usuario' : 'Correo'} no puede estar vacío.` });
//                 return;
//             }

//             fetch(`/check-availability?field=${field}&value=${encodeURIComponent(value)}`)
//                 .then(response => response.json())
//                 .then(data => resolve(data))
//                 .catch(() => {
//                     resolve({ success: false, message: 'Error al verificar.' });
//                 });
//         });
//     }

//     function validateInput(input, field, feedback, setValidFlag) {
//         checkAvailability(field, input.value).then(data => {
//             if (!data.success) {
//                 feedback.textContent = data.message;
//                 feedback.style.display = 'block';
//                 setValidFlag(false);
//             } else {
//                 feedback.textContent = '';
//                 feedback.style.display = 'none';
//                 setValidFlag(true);
//             }
//             updateButtonState();
//         });
//     }

//     usernameInput.addEventListener('input', function () {
//         validateInput(usernameInput, 'username', usernameFeedback, (isValid) => { usernameValid = isValid; });
//     });

//     emailInput.addEventListener('input', function () {
//         validateInput(emailInput, 'email', emailFeedback, (isValid) => { emailValid = isValid; });
//     });

//     // Inicia deshabilitado
//     registerButton.disabled = true;
// });






// document.addEventListener('DOMContentLoaded', function () {
//     const usernameInput = document.getElementById('username');
//     const emailInput = document.getElementById('email');
//     const registerButton = document.getElementById('register-button');
//     const usernameFeedback = usernameInput.nextElementSibling;
//     const emailFeedback = emailInput.nextElementSibling;

//     let usernameValid = false;
//     let emailValid = false;

//     function checkAvailability(field, value, callback) {
//         if (!value.trim()) {
//             callback({ success: false, message: `${field === 'username' ? 'Nombre de usuario' : 'Correo'} no puede estar vacío.` });
//             return;
//         }

//         fetch(`/check-availability?field=${field}&value=${encodeURIComponent(value)}`)
//             .then(response => response.json())
//             .then(data => callback(data))
//             .catch(error => {
//                 callback({ success: false, message: 'Error al verificar.' });
//                 console.error('Error:', error);
//             });
//     }

//     function validateInput(input, field, feedback, setValidFlag) {
//         checkAvailability(field, input.value, function (data) {
//             if (!data.success) {
//                 feedback.textContent = data.message;
//                 feedback.style.display = 'block';
//                 setValidFlag(false);
//             } else {
//                 feedback.textContent = '';
//                 feedback.style.display = 'none';
//                 setValidFlag(true);
//             }
//             registerButton.disabled = !(usernameValid && emailValid);
//         });
//     }

//     usernameInput.addEventListener('input', function () {
//         validateInput(usernameInput, 'username', usernameFeedback, (isValid) => { usernameValid = isValid; });
//     });

//     emailInput.addEventListener('input', function () {
//         validateInput(emailInput, 'email', emailFeedback, (isValid) => { emailValid = isValid; });
//     });

//     // Inicialmente deshabilitado
//     registerButton.disabled = true;
// });





// document.addEventListener('DOMContentLoaded', function () {
//     const usernameInput = document.getElementById('username');
//     const emailInput = document.getElementById('email');
//     const registerButton = document.getElementById('register-button');
//     let usernameValid = false;
//     let emailValid = false;

//     function checkAvailability(field, value, callback) {
//         if (!value.trim()) {
//             callback({ success: false, message: `${field} no puede estar vacío.` });
//             return;
//         }

//         fetch(`/check-availability?field=${field}&value=${encodeURIComponent(value)}`)
//             .then(response => response.json())
//             .then(data => callback(data))
//             .catch(error => console.error('Error:', error));
//     }

//     function validateInput(input, field, setValidFlag) {
//         const feedback = input.nextElementSibling || document.createElement('small');
//         feedback.classList.add('form-text', 'text-danger');
//         input.parentNode.appendChild(feedback);

//         checkAvailability(field, input.value, function (data) {
//             if (!data.success) {
//                 feedback.textContent = data.message;
//                 setValidFlag(false);
//             } else {
//                 feedback.textContent = '';
//                 setValidFlag(true);
//             }
//             registerButton.disabled = !(usernameValid && emailValid);
//         });
//     }

//     usernameInput.addEventListener('input', function () {
//         validateInput(usernameInput, 'username', (isValid) => usernameValid = isValid);
//     });

//     emailInput.addEventListener('input', function () {
//         validateInput(emailInput, 'email', (isValid) => emailValid = isValid);
//     });

//      registerButton.disabled = !(usernameValid && emailValid);
// });