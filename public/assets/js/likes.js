document.addEventListener('DOMContentLoaded', function () {
    const likeButtons = document.querySelectorAll('.like-btn');
    const unlikeButtons = document.querySelectorAll('.unlike-btn');

    likeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.getAttribute('data-post-id');
            fetch(`/post/${postId}/like`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ like: true }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.classList.remove('btn-primary');
                        this.classList.add('btn-success');
                        this.textContent = 'Liked';
                    } else {
                        alert('Error al dar like');
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });

    unlikeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.getAttribute('data-post-id');
            fetch(`/post/${postId}/like`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ like: false }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.classList.remove('btn-success');
                        this.classList.add('btn-primary');
                        this.textContent = 'Like';
                    } else {
                        alert('Error al quitar like');
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
});


// document.addEventListener('DOMContentLoaded', function () {
//     const likeButtons = document.querySelectorAll('.like-btn');

//     likeButtons.forEach(button => {
//         button.addEventListener('click', function () {
//             const postId = this.getAttribute('data-post-id');
//             const isLiked = this.classList.contains('btn-primary'); // Azul indica que está "liked"

//             // Enviar solicitud al servidor para dar o quitar like
//             fetch(`/post/${postId}/like`, {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                 },
//                 body: JSON.stringify({ like: !isLiked }),
//             })
//                 .then(response => response.json())
//                 .then(data => {
//                     if (data.success) {
//                         // Cambiar el estado del botón
//                         if (isLiked) {
//                             this.classList.remove('btn-primary');
//                             this.classList.add('btn-success');
//                             this.textContent = 'Like';
//                         } else {
//                             this.classList.remove('btn-success');
//                             this.classList.add('btn-primary');
//                             this.textContent = 'Liked';
//                         }
//                     } else {
//                         alert('Error al actualizar el like');
//                     }
//                 })
//                 .catch(error => console.error('Error:', error));
//         });
//     });
// });