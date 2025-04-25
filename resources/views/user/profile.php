<?php
ob_start();
$messages = [];
?>


<div class="container pb-5">
    <div class="row align-items-center">
        <div class="col-md-4 text-center">
            <img
                src="<?= $user['profile_photo'] ? 'data:image/jpeg;base64,'.base64_encode($user['profile_photo']) : '/assets/images/user-default.png' ?>"
                alt="Perfil"
                class="rounded-circle"
                style="width: 200px; height: 200px; object-fit: cover;">
        </div>
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-3">
                <span class="username me-3"><?php echo $user['username'] ?></span>
                <?php if ($_SESSION['user']['id'] == $user['id']): ?>
                    <button id="edit-profile-btn" class="btn btn-outline-secondary btn-sm me-2">Editar perfil</button>
                <?php endif; ?>
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
<script src="/assets/js/post.js"></script>
<script src="/assets/js/likes.js"></script>