<?php
ob_start();
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>

<div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-10">
            <div class="card rounded-3 text-black login-card" style="min-height: 80vh;">
                <div class="row g-0">
                    <div class="col-lg-6 d-flex align-items-center">
                        <div class="card-body p-md-4 mx-md-3 w-100">
                            <div class="text-center">
                                <img src="/assets/images/logo.png"
                                    class="login-logo"
                                    alt="logo">
                                <h3 class="mt-1 mb-4 pb-1"></h3>
                            </div>
                            <form action="/login" method="POST" class="w-100">
                                <p class="mb-3">Por favor ingresa a tu cuenta</p>
                                <div class="form-floating mb-3">
                                    <input type="text" id="inputUser" class="form-control login-input" required name="userName" placeholder="Nombre de Usuario" />
                                    <label class="form-label" for="floatingInput">Nombre de Usuario</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" id="inputPassword" class="form-control login-input" required name="password" placeholder="Contraseña" />
                                    <label class="form-label" for="inputPassword">Contraseña</label>
                                </div>
                                <div class="text-center pt-1 mb-4 pb-1">
                                    <button type="submit" class="btn btn1 btn-primary btn-block fa-lg gradient-custom-2 ">Ingresar</button>
                                    <a class="text-muted" href="forgot-password">Olvidaste tu contraseña?</a>
                                </div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <p class="mb-0 me-2">No tienes una cuenta?</p>
                                    <a href="register" class="btn btn1 btn-primary btn-block gradient-custom-2 ms-2">Regístrate</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                        <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                            <h4 class="mb-4">¡Ingresa y comienza a crear momentos inolvidables!</h4>
                            <p class="lg mb-0">Comparte tu mundo en imágenes, conecta con quienes comparten tu visión y deja que cada publicación revele tu esencia. Bienvenido al lugar donde tus recuerdos cobran vida y las historias se convierten en inspiración...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();

include __DIR__ . '/../layout/main.php';
?>