
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
    <?php foreach($messages as $message): ?>
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
                <img src="/public/img/default-user.jpg"
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