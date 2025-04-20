<?php
    ob_start(); 
    $error = $_SESSION['error'] ?? null;
    unset($_SESSION['error']);
?>

<form action="/login" method="POST">
    <div class="row mb-3">
        <label for="inputUser" class="col-sm-2 col-form-label">Usuario</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="inputUser" required name="userName">
    </div>
    </div>
    <div class="row mb-3">
        <label for="inputPassword" class="col-sm-2 col-form-label">Contraseña</label>
        <div class="col-sm-10">
            <input type="password" required name="password" class="form-control" id="inputPassword">
        </div>
    </div>
   
    <div class="row mb-3">
        <a href="#">¿Olvidaste tu contraseña?</a>
    </div>

  <button type="submit" class="btn btn-primary">Ingresar</button>
  
</form>

<?php if ($error): ?>
<div class="alert alert-danger">
    <?= htmlspecialchars($error) ?>
</div>
<?php endif; ?>

<?php
$content = ob_get_clean();

include __DIR__ . '/../layout/main.php';
?>