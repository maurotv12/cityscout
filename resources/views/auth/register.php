<?php
ob_start();
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>

<form method="POST" action="/register" enctype="multipart/form-data">

  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black register-card" style="min-height: 80vh;">
          <div class="row g-0">
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4">¡Registrate y comienza a crear momentos inolvidables!</h4>
                <p class="lg mb-0">Comparte tu mundo en imágenes, conecta con quienes comparten tu visión y deja que cada publicación revele tu esencia. Bienvenido al lugar donde tus recuerdos cobran vida y las historias se convierten en inspiración...</p>
              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center">
              <div class="card-body p-md-4 mx-md-3 w-100">
                <div class="text-center">
                  <img src="/assets/images/logo.png"
                    class="login-logo"
                    alt="logo">
                  <h3 class="mt-1 mb-4 pb-1">FOCUZ</h3>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" id="fullname" class="form-control register-input" required name="fullname" placeholder="Nombre completo" />
                  <label class="form-label" for="floatingInput">Nombre completo *</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" id="username" class="form-control register-input" required name="username" placeholder="Nombre de usuario" />
                  <label class="form-label" for="floatingInput">Nombre de usuario *</label>
                  <small class="form-text text-danger" style="display:none;"></small>
                </div>
                <div class="form-floating mb-3">
                  <input type="email" id="email" class="form-control register-input" required name="email" placeholder="Correo" />
                  <label class="form-label" for="email">Correo *</label>
                  <small class="form-text text-danger" style="display:none;"></small>
                </div>
                <div class="form-floating mb-3">
                  <input type="password" id="password" class="form-control register-input" required name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Contraseña" />
                  <label class="form-label" for="password">Contraseña *</label>
                  <p><small class="mt-1 mb-2 pb-1">La contraseña debe tener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número.</small></p>
                </div>
                <div class="form-floating mb-3">
                  <input type="date" id="birth_date" class="form-control register-input" required name="birth_date" min="<?php echo date('Y-m-d', strtotime('-100 years')); ?>" max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" />
                  <label class="form-label" for="birth">Fecha de nacimiento *</label>
                </div>
                <div class="d-flex align-items-center justify-content-center">
                  <p class="mb-0 me-2">¡Estas a solo un paso de crear tu cuenta!</p>
                  <button type="submit" id="register-button" class="btn btn-primary btn-block gradient-custom-2 ms-2">Registrarme</button>
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