<link rel="stylesheet" href="/assets/css/login-register.css">
<?php
ob_start();
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>

<form method="POST" action="/register" enctype="multipart/form-data">

  <div class="container h-100">
    <div class="row d-flex justify-content-center  h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4">¡Registrate y comienza a crear momentos inolvidables!</h4>
                <p class="lg mb-0">Comparte tu mundo en imágenes, conecta con quienes comparten tu visión y deja que cada publicación revele tu esencia. Bienvenido al lugar donde tus recuerdos cobran vida y las historias se convierten en inspiración...</p>
              </div>
            </div>
              <div class="col-lg-6">
                <div class="card-body p-md-5 mx-md-4">

                  <div class="text-center">
                    <img src="/assets/images/logo.png"
                      style="width: 185px;" alt="logo">
                    <h3 class="mt-1 mb-5 pb-1">FOCUZ</h3>
                  </div>
                  
                  <div class="col-md-12">
                    <label class="form-label" for="fullname">Nombre completo *</label>
                    <input type="text" id="fullname" class="form-control" required name="fullname" />
                  </div>

                  <div class="col-md-12">
                    <label class="form-label" for="username">Nombre de usuario *</label>
                    <input type="text" id="username" class="form-control" required name="username" />
                    <small class="form-text text-danger" style="display:none;"></small> <!-- Mensaje de error -->
                  </div>

                  <div class="col-md-12">
                    <label class="form-label" for="email">Correo *</label>
                    <input type="email" id="email" class="form-control" required name="email" />
                    <small class="form-text text-danger" style="display:none;"></small> <!-- Mensaje de error -->
                  </div>

                  <div class="col-md-12">
                    <label class="form-label" for="password">Contraseña *</label>
                    <input type="password" id="password" class="form-control" required name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"/>
                    <p><small class="mt-1 mb-5 pb-1">La contraseña debe tener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número.</small></p>
                  </div>

                  <div class="col-md-12">
                    <label class="form-label" for="birth">Fecha de nacimiento *</label>
                    <input type="date" id="birth_date" class="form-control" required name="birth_date" min="<?php echo date('Y-m-d', strtotime('-100 years')); ?>" max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" />
                  </div>

                  <div class="d-flex align-items-center justify-content-center ">
                    <p class="mb-0 me-2">¡Estas a solo un paso de crear tu cuenta!</p>
                    <button type="submit" id="register-button" class="btn btn-primary btn-block gradient-custom-2">Registrarme</button>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>



</form>

<?php if ($error): ?>
  <div class="alert alert-danger mt-3"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  
  <?php
$content = ob_get_clean();
include __DIR__ . '/../layout/main.php';
?>

<script src="/assets/js/register.js"></script>
