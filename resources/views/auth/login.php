
<?php
ob_start();
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>

<form action="/login" method="POST">

    <div class="container h-100">
        <div class="row d-flex justify-content-center  h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="card-body p-md-5 mx-md-4">

                                <div class="text-center">
                                    <img src="/assets/images/logo.png"
                                        style="width: 185px;" alt="logo">
                                    <h3 class="mt-1 mb-5 pb-1">FOCUZ</h3>
                                </div>

                                <form>
                                    <p>Por favor ingresa a tu cuenta</p>

                                    <div data-mdb-input-init class="form-outline ">
                                        <input type="text" id="inputUser" class="form-control" required name="userName" />
                                        <label class="form-label" for="inputUser">Nombre de Usuario</label>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="password" id="inputPassword" class="form-control" required name="password" />
                                        <label class="form-label" for="inputPassword">Contraseña</label>
                                    </div>

                                    <div class="text-center pt-1 mb-5 pb-1">
                                        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="button">Ingresar</button>
                                        <a class="text-muted" href="#!">Olvidaste tu contraseña?</a>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center ">
                                        <p class="mb-0 me-2">No tienes una cuenta?</p>
                                        <a href="register" class="btn btn-primary btn-block gradient-custom-2">Regístrate</a>
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