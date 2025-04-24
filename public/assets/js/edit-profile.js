const editButton = document.getElementById('edit-profile-btn');
const saveButton = document.getElementById('save-bio-btn');
const bioText = document.getElementById('bio-text');
const bioTextarea = document.getElementById('bio-textarea');
const bioForm = document.getElementById('bio-form');

editButton.addEventListener('click', () => {
    // Mostrar el textarea y ocultar el texto
    bioTextarea.value = bioText.innerHTML.replace(/<br>/g, '\n'); // Convertir <br> a saltos de línea
    bioText.classList.add('d-none');
    bioTextarea.classList.remove('d-none');
    saveButton.classList.remove('d-none');
});

saveButton.addEventListener('click', (e) => {
    e.preventDefault(); // Evitar el envío del formulario

    // Obtener el valor del textarea
    const bio = bioTextarea.value;

    // Enviar la biografía al servidor mediante fetch
    fetch(bioForm.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ bio }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Actualizar el texto de la biografía
                bioText.innerHTML = bio.replace(/\n/g, '<br>'); // Convertir saltos de línea a <br>
                bioTextarea.classList.add('d-none');
                bioText.classList.remove('d-none');
                saveButton.classList.add('d-none');
            } else {
                alert('Error al actualizar la biografía i');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Error al actualizar la biografía');
        });
});