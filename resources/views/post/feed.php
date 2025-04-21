<?php
ob_start();
$messages = [];
?>

<div class="row">
    <?php for ($i = 0; $i < 50; $i++): ?>
        <div class="card mb-3 mr-3 col-lg-4 p-3 col-sm-12 col-md-6">
            <img src="https://png.pngtree.com/background/20250124/original/pngtree-beautiful-natural-scenery-picture-image_15750499.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Mauricio</h5>
                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore...</p>
                <a href="#" class="btn btn-primary">Me gusta</a>
                <a href="#" class="btn btn-success">Te gusta</a>
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#commentsModal">Comentarios</a>
            </div>
        </div>
    <?php endfor; ?>
</div>

<!-- Modal Comments -->
<div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="commentsModalLabel">Mauricio</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <!-- Imagen y descripción -->
                        <div class="col-lg-6 col-md-12">
                            <div class="card col-12 mb-3">
                                <img src="https://png.pngtree.com/background/20250124/original/pngtree-beautiful-natural-scenery-picture-image_15750499.jpg" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Comentarios con scroll -->
                        <div class="col-lg-6 col-md-12">
                            <!-- Campo para nuevo comentario -->
                            <div class="modal-footer">
                                <div class="card-footer border-0 col-12" style="background-color: #f8f9fa;">
                                    <div class="d-flex flex-start w-100">
                                        <img class="rounded-circle shadow-1-strong me-3"
                                            src="<?= $_SESSION['user']['profile_photo'] ?? '/assets/images/user-default.png' ?>" alt="avatar" width="40"
                                            height="40" />
                                        <div class="form-outline w-100">
                                            <textarea class="form-control" rows="2" style="background: #fff;"></textarea>
                                        </div>
                                    </div>
                                    <div class="float-end mt-2 pt-1">
                                        <button type="button" class="btn btn-primary btn-sm">Agregar comentario</button>
                                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Contenedor scrolleable de comentarios -->
                            <div style="max-height: 300px; overflow-y: auto; overflow-x: hidden;">
                                <?php for ($i = 0; $i < 10; $i++): ?>
                                    <div class="row d-flex justify-content-center mb-2">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex flex-start align-items-center">
                                                        <img class="rounded-circle shadow-1-strong me-3"
                                                            src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(19).webp" alt="avatar" width="40"
                                                            height="40" />
                                                        <div>
                                                            <h6 class="fw-bold text-primary mb-1">Lily Coleman</h6>
                                                            <p class="text-muted small mb-0">
                                                                Shared publicly - Jan 2020
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <p class="mt-3">
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore...
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>




<?php
// Guardar el contenido generado en $content
$content = ob_get_clean();

// Incluir el layout principal
include __DIR__ . '/../layout/main.php';
?>