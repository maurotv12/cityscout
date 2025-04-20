<?php 
ob_start(); 
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>

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

<?php if ($error): ?>
  <div class="alert alert-danger mt-3"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/main.php';
?>
