<?php
ob_start();
$messages = [];
?>


<div class="container py-5">
    <div class="row align-items-center">
        <div class="col-md-4 text-center">
            <img src="ruta/a/tu-imagen.jpg" alt="Foto de perfil" class="profile-img mb-3">
        </div>
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-3">
                <span class="username me-3"><?php echo $user['username'] ?></span>
                <button id="edit-profile-btn" class="btn btn-outline-secondary btn-sm me-2">Editar perfil</button>
                <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-gear"></i></button>
            </div>
            <div class="mb-3">
                <span><strong>1,012</strong> publicaciones</span>
                <span class="ms-4"><strong>9,572</strong> seguidores</span>
                <span class="ms-4"><strong>719</strong> seguidos</span>
            </div>
            <div class="bio">
                <form id="bio-form" method="POST" action="/user/update-bio/<?php echo $user['id']; ?>">
                    <strong>BO SALDAÑA</strong><br>
                    <span id="bio-text"><?php echo nl2br(htmlspecialchars($user['bio'] ?? '')); ?></span>
                    <textarea id="bio-textarea" name="bio" class="form-control d-none" rows="5"></textarea>
                    <button id="save-bio-btn" type="submit" class="btn btn-primary btn-sm d-none mt-2">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../post/list.php'; ?>

<?php
// Guardar el contenido generado en $content
$content = ob_get_clean();

// Incluir el layout principal
include __DIR__ . '/../layout/main.php';
?>

<script src="/assets/js/edit-profile.js"></script>
<script src="/assets/js/bio.js"></script>
<script src="/assets/js/post.js"></script>
<script src="/assets/js/likes.js"></script>