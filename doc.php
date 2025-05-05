<script>
    document.addEventListener('DOMContentLoaded', function() {
        const commentsModal = document.getElementById('commentsModal');
        const modalBody = commentsModal.querySelector('.comments');
        const modalPostCaption = commentsModal.querySelector('.modal-post-caption');
        const editCaptionBtn = document.getElementById('edit-caption-btn');
        const editCaptionForm = document.getElementById('edit-caption-form');
        const newCaptionInput = document.getElementById('new-caption');
        const cancelEditCaptionBtn = document.getElementById('cancel-edit-caption');

        commentsModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const postId = button.getAttribute('data-post-id');
            const postCaption = button.getAttribute('data-post-caption');

            modalPostCaption.textContent = postCaption;
            newCaptionInput.value = postCaption;

            // Mostrar el botón de editar y ocultar el formulario
            editCaptionBtn.classList.remove('d-none');
            editCaptionForm.classList.add('d-none');

            // Limpiar el contenido del modal de comentarios
            modalBody.innerHTML = '<p>Cargando comentarios...</p>';

            // Hacer una solicitud AJAX para obtener los comentarios
            fetch(`/post/${postId}/comments`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let commentsHtml = '';
                        data.comments.forEach(comment => {
                            commentsHtml += `
                            <div class="row d-flex justify-content-center mb-2">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-start align-items-center">
                                                <img class="rounded-circle shadow-1-strong me-3"
                                                    src="${comment.user.profile_photo ?? '/assets/images/user-default.png'}" alt="avatar" width="40" height="40" />
                                                <div>
                                                    <h6 class="fw-bold text-primary mb-1">${comment.user.fullname}</h6>
                                                    <p class="text-muted small mb-0">
                                                        ${comment.created_at}
                                                    </p>
                                                </div>
                                            </div>
                                            <p class="mt-3">${comment.comment}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        });
                        modalBody.innerHTML = commentsHtml;
                    } else {
                        modalBody.innerHTML = '<p>' + data.message + '</p>';
                    }
                })
                .catch(error => {
                    console.error('Error al cargar los comentarios:', error);
                    modalBody.innerHTML = '<p>Error al cargar los comentarios.</p>';
                });
        });

        // Mostrar el formulario de edición al hacer clic en "Editar descripción"
        editCaptionBtn.addEventListener('click', () => {
            editCaptionBtn.classList.add('d-none');
            editCaptionForm.classList.remove('d-none');
        });

        // Cancelar la edición
        cancelEditCaptionBtn.addEventListener('click', () => {
            editCaptionForm.classList.add('d-none');
            editCaptionBtn.classList.remove('d-none');
        });

        // Manejar el envío del formulario para actualizar el caption
        editCaptionForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const postId = commentsModal.querySelector('[data-post-id]').getAttribute('data-post-id');
            const newCaption = newCaptionInput.value;

            fetch(`/post/${postId}/update-caption`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        caption: newCaption
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        modalPostCaption.textContent = newCaption;
                        editCaptionForm.classList.add('d-none');
                        editCaptionBtn.classList.remove('d-none');
                        alert('Descripción actualizada correctamente.');
                    } else {
                        alert('Error al actualizar la descripción.');
                    }
                })
                .catch(error => {
                    console.error('Error al actualizar la descripción:', error);
                    alert('Error al actualizar la descripción.');
                });
        });
    });
</script>







CARD POST

<div class="row">
    <?php foreach ($posts as $post) { ?>
        <div class="card mb-3 mr-3 col-lg-4 p-3 col-sm-12 col-md-6">
            <img
                src="/assets/images/posts/<?= $post['file_name'] . '.' . $post['type'] ?>"
                class="card-img-top post-image"
                alt="...">
            <div class="card-body">
                <h5 class="card-title">
                    <img
                        src="<?= file_exists(__DIR__ . '/../../../public/assets/images/profiles/' . $post['user']['id'] . '.' . $post['user']['profile_photo_type'])
                                    ? '/assets/images/profiles/' . $post['user']['id'] . '.' . $post['user']['profile_photo_type']
                                    : '/assets/images/user-default.png' ?>"
                        alt="avatar"
                        width="30"
                        height="30"
                        class="rounded-circle profile-photo">
                    <?= htmlspecialchars($post['user']['username']) ?>
                </h5>
                <p class="card-text"><?= htmlspecialchars($post['caption']) ?></p>
                <p class="card-text"><strong><?= $post['comment_count'] ?></strong> comentarios</p>
                <p class="card-text"><strong><?= count($post['likes']) ?></strong> likes</p>
                <button
                    class="btn btn-primary like-btn"
                    data-post-id="<?= $post['id'] ?>"
                    data-post-liked-by-logged="<?= in_array($_SESSION['user']['id'], array_column($post['likes'], 'user_id')) ? 'true' : 'false' ?>">
                    <i class="bi bi-hand-thumbs-up"></i>
                </button>
                <!-- Botón para abrir el modal con el ID del post -->
                <a href="#"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#commentsModal"
                    data-post-id="<?= $post['id'] ?>"
                    data-post-username="<?= htmlspecialchars($post['user']['username']) ?>"
                    data-post-userId="<?= htmlspecialchars($post['user']['id']) ?>"
                    data-post-route="/assets/images/posts/<?= $post['file_name'] . '.' . $post['type'] ?>"
                    data-post-caption="<?= htmlspecialchars($post['caption']) ?>">
                    <i class="bi bi-chat-heart-fill"> Abrir y ver comentarios</i>
                </a>
            </div>
        </div>
    <?php } ?>
</div>






CHAT
<?php
// views/chatList.php

// Supongamos que ya tienes $messages definido desde tu controlador o lógica previa

// Iniciar un buffer para capturar el HTML del body
ob_start();
$_SESSION['user'] = [
    'name' => 'Mauricio',
];
?>

<h1>Listado de mensajes</h1>

<ul>
    <?php foreach ($messages as $message): ?>
        <li>
            <a href="/chats/<?= $message['id'] ?>">
                <?= htmlspecialchars($message['message']) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<?php
// Guardar el contenido generado en $content
$content = ob_get_clean();

// Incluir el layout principal
include __DIR__ . '/../layout/main.php';
?>

CHAT






REGISTER
<?php
ob_start();
?>

<div class="container perfil-usuario">
    <div class="row">
        <!-- Foto de perfil -->
        <div class="col-md-4 text-center">
            <?php if (!empty($user['profile_photo'])): ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($user['profile_photo']) ?>"
                    alt="Foto de perfil"
                    class="img-fluid rounded-circle mb-3"
                    style="width: 150px; height: 150px; object-fit: cover;">
            <?php else: ?>
                <img src="/public/img/user-default.png"
                    alt="Foto de perfil por defecto"
                    class="img-fluid rounded-circle mb-3"
                    style="width: 150px; height: 150px; object-fit: cover;">
            <?php endif; ?>
        </div>

        <!-- Info del usuario -->
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">@<?= htmlspecialchars($user['username']) ?></h2>
                <?php if ($_SESSION['user']['id'] == $user['id']): ?>
                    <a href="/profile/<?= $user['id'] ?>/edit" class="btn btn-outline-primary btn-sm">Editar perfil</a>
                <?php endif; ?>
            </div>
            <p class="mb-1"><strong>Nombre completo:</strong> <?= htmlspecialchars($user['fullname']) ?></p>
            <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p class="mb-1"><strong>Fecha de nacimiento:</strong> <?= htmlspecialchars($user['birth_date']) ?></p>
        </div>
    </div>

    <!-- Galería de publicaciones (si implementas post más adelante) -->
    <hr class="my-4">
    <h4>Publicaciones</h4>
    <div class="row row-cols-2 row-cols-md-3 g-3">
        <!-- Ejemplo de imagen (reemplaza con tus posts si los conectas luego) -->
        <div class="col">
            <img src="/public/img/sample1.jpg" class="img-fluid rounded" alt="Publicación">
        </div>
        <div class="col">
            <img src="/public/img/sample2.jpg" class="img-fluid rounded" alt="Publicación">
        </div>
        <div class="col">
            <img src="/public/img/sample3.jpg" class="img-fluid rounded" alt="Publicación">
        </div>
        <!-- Agrega más publicaciones aquí dinámicamente -->
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/main.php';
?>
REGISTER





CARD POST
<div class="row">
    <?php foreach ($posts as $post) { ?>
        <div class="card mb-3 mr-3 col-lg-4 p-3 col-sm-12 col-md-6">
            <img src="data:image/jpeg;base64,<?= base64_encode($post['image']) ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">
                    <img src="<?= $post['profile_photo'] ?? '/assets/images/user-default.png' ?>" alt="avatar" width="30" height="30" class="rounded-circle">
                    <?= htmlspecialchars($post['username']) ?>
                </h5>
                <p class="card-text"><?= htmlspecialchars($post['caption']) ?></p>
                <p class="card-text"><strong><?= $post['comment_count'] ?></strong> comentarios</p>
                <p class="card-text"><strong><?= count($post['likes']) ?></strong> likes</p>
                <a href="#" class="btn btn-primary"><i class="bi bi-hand-thumbs-up"></i></a>
                <a href="#" class="btn btn-success"><i class="bi bi-hand-thumbs-up"></i></a>

                <a href="#"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#commentsModal"
                    data-post-id="<?= $post['id'] ?>">
                    <i class="bi bi-chat-heart-fill"></i>
                </a>
            </div>
        </div>
    <?php } ?>
</div>









<form class="row g-3" method="POST" action="/register" enctype="multipart/form-data">


    <div class="col-md-6">
        <label for="fullname" class="form-label">Nombre completo *</label>
        <input type="text" class="form-control" id="fullname" name="fullname" required>
    </div>


    <div class="col-md-6">
        <label for="username" class="form-label">Nombre de usuario *</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>


    <div class="col-md-6">
        <label for="email" class="form-label">Email *</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>



    <div class="col-md-6">
        <label for="password" class="form-label">Contraseña *</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>


    <div class="col-md-6">
        <label for="birth" class="form-label">Fecha de nacimiento *</label>
        <input type="date" class="form-control" id="birth" name="birth_date" required>
    </div>


    <div class="col-6">
        <label for="photo" class="form-label">Foto de perfil</label>
        <input type="file" class="form-control" id="photo" name="profile_photo" accept="image/*">
    </div>


    <div class="col-12">
        <button type="submit" class="btn btn-primary">Registrarme</button>
    </div>
</form>




// views/layout/main.php

<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top shadow-sm">
  <div class="container-fluid col-md-12 d-flex justify-content-between align-items-center">

    <!-- Botón del Side Panel -->
    <?php if (isset($_SESSION['user'])): ?>
      <div class="d-flex align-items-center">
        <button class="btn btn-primary me-2 d-none d-lg-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
          ☰ <span class="ms-2">Menú</span>
        </button>
        <button class="btn btn-primary me-2 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
          ☰
        </button>

        <!-- Logo junto al botón -->
        <a class="navbar-brand d-flex align-items-center me-3" href="/">
          <img src="/assets/images/logo.png" alt="Logo" class="logo-img" style="height: 40px;">
        </a>
      </div>
    <?php endif; ?>

    <!-- Buscador  -->
    <?php if (isset($_SESSION['user'])): ?>
      <form class="d-flex align-items-center position-relative mx-auto" role="search" style="max-width: 200px;">
        <input class="form-control text-center" type="search" placeholder="Buscar" aria-label="Search">
        <button class="btn btn-link position-absolute end-0 me-2" type="submit"><i class="bi bi-search"></i></button>
      </form>
    <?php endif; ?>

    <!-- Notificaciones + Foto de perfil -->
    <?php if (isset($_SESSION['user'])): ?>
      <div class="d-flex align-items-center">
        <!-- Notificaciones -->
        <div class="dropdown me-3">
          <button class="btn btn-secondary position-relative" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-bell"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationCount">
              0
            </span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="max-height: 300px; overflow-y: auto;">
            <li class="dropdown-item text-center text-muted" id="noNotifications">No hay notificaciones</li>
          </ul>
        </div>

        <!-- Foto de perfil -->
        <a class="nav-link p-0 d-flex align-items-center" href="/profile/<?= $_SESSION['user']['id'] ?>">
          <img
            src="<?= file_exists(__DIR__ . '/../../../public/assets/images/profiles/' . $_SESSION['user']['id'] . '.' . $_SESSION['user']['profile_photo_type'])
                    ? '/assets/images/profiles/' . $_SESSION['user']['id'] . '.' . $_SESSION['user']['profile_photo_type']
                    : '/assets/images/user-default.png' ?>"
            alt="Perfil"
            class="rounded-circle profile-photo"
            style="width: 40px; height: 40px; object-fit: cover;">
        </a>
      </div>
    <?php endif; ?>
  </div>
</nav>
