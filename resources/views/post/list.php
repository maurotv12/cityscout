



<div class="row">
    <?php foreach ($posts as $post) { ?>
        <div class="card mb-3 mr-3 col-lg-4 p-3 col-sm-12 col-md-6">
            <img src="data:image/jpeg;base64,<?= base64_encode($post['image']) ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">
                    <img src="<?= $post['profile_photo'] ?? '/assets/images/user-default.png' ?>" alt="avatar" width="30" height="30" class="rounded-circle">
                    <?= htmlspecialchars($post['username']) ?>
                </h5>
                <p class="card-text"><?= htmlspecialchars($post['caption']) ?></p>
                <p class="card-text"><strong><?= $post['comment_count'] ?></strong> comentarios</p>
                <p class="card-text"><strong><?= count($post['likes']) ?></strong> likes</p>
                <a href="#" class="btn btn-primary"><i class="bi bi-hand-thumbs-up"></i></a>
                <a href="#" class="btn btn-success"><i class="bi bi-hand-thumbs-up"></i></a>
            <!-- Botón para abrir el modal con el ID del post -->
                <a href="#" 
                   class="btn btn-primary" 
                   data-bs-toggle="modal" 
                   data-bs-target="#commentsModal" 
                   data-post-id="<?= $post['id'] ?>">
                   <i class="bi bi-chat-heart-fill"></i>
                </a>
            </div>
        </div>
    <?php } ?>
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
                            <div class="comments" style="max-height: 300px; overflow-y: auto; overflow-x: hidden;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="/assets/js/post.js"></script>