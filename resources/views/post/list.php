<div class="row">
    <?php foreach ($posts as $post) { ?>
        <div class="card mb-3 mr-3 col-lg-4 p-3 col-sm-12 col-md-6">
            <img 
                src="/assets/images/posts/<?=$post['file_name'].'.'.$post['type'] ?>" 
                class="card-img-top post-image" 
                alt="...">
            <div class="card-body">
                <h5 class="card-title">
                    <img
                        src="<?= file_exists(__DIR__ . '/../../../public/assets/images/profiles/' . $post['user']['id'] . '.' . $post['user']['profile_photo_type'])
                                    ? '/assets/images/profiles/' . $post['user']['id'] . '.' . $post['user']['profile_photo_type']
                                    : '/assets/images/user-default.png' ?>"
                        alt="avatar"
                        width="30"
                        height="30"
                        class="rounded-circle profile-photo">
                    <?= htmlspecialchars($post['user']['username']) ?>
                </h5>
                <p class="card-text"><?= htmlspecialchars($post['caption']) ?></p>
                <p class="card-text"><strong><?= $post['comment_count'] ?></strong> comentarios</p>
                <p class="card-text"><strong><?= count($post['likes']) ?></strong> likes</p>
                <button 
                    class="btn btn-primary like-btn" 
                    data-post-id="<?= $post['id'] ?>"
                    data-post-liked-by-logged="<?= in_array($_SESSION['user']['id'], array_column($post['likes'], 'user_id')) ? 'true' : 'false' ?>">
                    <i class="bi bi-hand-thumbs-up"></i>
                </button>
                <!-- Botón para abrir el modal con el ID del post -->
                <a href="#"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#commentsModal"
                    data-post-id="<?= $post['id'] ?>"
                    data-post-username="<?= htmlspecialchars($post['user']['username']) ?>"
                    data-post-userId="<?= htmlspecialchars($post['user']['id']) ?>"
                    data-post-route="/assets/images/posts/<?= $post['file_name'].'.'.$post['type'] ?>"
                    data-post-caption="<?= htmlspecialchars($post['caption']) ?>">
                    <i class="bi bi-chat-heart-fill"> Abrir y ver comentarios</i>
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
                <h1 class="modal-title fs-5 modal-post-username" id="commentsModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <!-- Imagen y descripción -->
                        <div class="col-lg-6 col-md-12">
                            <div class="card col-12 mb-3">
                                <img class="card-img-top modal-post-image" alt="...">
                                <div class="card-body">
                                    <p class="card-text modal-post-caption"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Comentarios con scroll -->
                        <div class="col-lg-6 col-md-12">
                            <!-- Campo para nuevo comentario -->
                            <div class="modal-footer">
                                <div class="card-footer border-0 col-12" style="background-color: #f8f9fa;">
                                    <div class="d-flex flex-start w-100">
                                        <img class="rounded-circle shadow-1-strong me-3 profile-photo"
                                            src="<?= file_exists(__DIR__ . '/../../../public/assets/images/profiles/' . $_SESSION['user']['id'] . '.' . $_SESSION['user']['profile_photo_type'])
                                                        ? '/assets/images/profiles/' . $_SESSION['user']['id'] . '.' . $_SESSION['user']['profile_photo_type']
                                                        : '/assets/images/user-default.png' ?>"

                                            alt="avatar" width="40"
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
<script src="/assets/js/likes.js"></script>