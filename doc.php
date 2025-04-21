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