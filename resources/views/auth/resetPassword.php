<?php
ob_start();
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>
<div class="container mt-5">
    <h3>Restablecer contraseña</h3>
    <span class="mb-1"> Una contraseña segura contribuye a evitar el acceso no autorizado a tu cuenta.</span>
    <form method="POST" action="/reset-password">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <div class="mb-3">
            <label for="password" class="form-label">Nueva contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
            <small class="form-text text-muted">
                Mínimo 8 caracteres, una mayúscula, una minúscula y un número.
            </small>
        </div>
        <div class="mb-3">
            <label for="password2" class="form-label">Repite la nueva contraseña</label>
            <input type="password" class="form-control" id="password2" name="password2" required>
        </div>
        <button type="submit" class="btn btn-primary">Restablecer</button>
    </form>
    <?php if ($error): ?>
        <div class="alert alert-danger mt-3"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/main.php';
?>