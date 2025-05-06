<div class="row">
    <?php foreach ($posts as $post) { ?>
        <div class="card mb-3 mr-3 col-lg-4 p-3 col-sm-12 col-md-6" card-post-id="<?= $post['id'] ?>">
            <?php if ($post['type'] === 'mp4'): ?>
                <!-- Renderizar video si el archivo es un video -->
                <video
                    class="card-img-top post-video <?= $post['is_blurred'] ? 'blurred' : '' ?>" 
                    controls
                    style="max-height: 300px; object-fit: cover;">
                    <source src="/assets/images/posts/<?= $post['file_name'] . '.' . $post['type'] ?>" type="video/mp4">
                    Tu navegador no soporta la reproducción de videos.
                </video>
            <?php else: ?>
                <!-- Renderizar imagen si el archivo no es un video -->
                <img
                    src="/assets/images/posts/<?= $post['file_name'] . '.' . $post['type'] ?>"
                    class="card-img-top post-image <?= $post['is_blurred'] ? 'blurred' : '' ?>"
                    alt="...">
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title">
                    <a href="/profile/<?= htmlspecialchars($post['user']['id']) ?>" class="text-decoration-none text-body">
                        <img
                            src="<?= file_exists(__DIR__ . '/../../../public/assets/images/profiles/' . $post['user']['id'] . '.' . $post['user']['profile_photo_type'])
                                        ? '/assets/images/profiles/' . $post['user']['id'] . '.' . $post['user']['profile_photo_type']
                                        : '/assets/images/user-default.png' ?>"
                            alt="avatar"
                            width="30"
                            height="30"
                            class="rounded-circle profile-photo">
                    </a>
                    <a href="/profile/<?= htmlspecialchars($post['user']['id']) ?>" class="text-decoration-none text-body">
                        <?= htmlspecialchars($post['user']['fullname']) ?>
                    </a>
                </h5>
                <p class="card-text" card-post-caption="<?= $post['id'] ?>"><?= htmlspecialchars($post['caption']) ?></p>
                <p class="card-text"><strong><?= $post['comment_count'] ?></strong> comentarios</p>
                <p class="card-text"><strong><?= count($post['likes']) ?></strong> likes</p>
                <p class="card-text"><small class="text-muted"><?= date('d/m/Y H:i', strtotime($post['created_at'])) ?></small></p>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="div">
                        <!-- Botón para dar like al post -->
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
                            data-post-route="/assets/images/posts/<?= $post['file_name'] . '.' . $post['type'] ?>"
                            data-post-caption="<?= htmlspecialchars($post['caption']) ?>"
                            data-post-type="<?= $post['type'] ?>">
                            <i class="bi bi-chat-heart-fill"> Abrir y ver comentarios</i>
                        </a>
                    </div>
                    <!-- Botón para eliminar el post -->        
                    <?php if ($_SESSION['user']['id'] === $post['user']['id']) { ?>
                        <button
                            class="btn btn-danger delete-post-btn"
                            data-post-id="<?= $post['id'] ?>"
                            data-post-userId="<?= htmlspecialchars($post['user']['id']) ?>"
                            onclick="deletePost(<?= $post['id'] ?>)">
                            <i class="bi bi-trash"></i>
                        </button>
                    <?php } ?>
                    <!-- Botón para editar blur del post -->
                    <?php if ($_SESSION['user']['id'] === $post['user']['id']) { ?>
                        <button
                            class="btn btn-warning toggle-blur-btn"
                            onclick="toggleBlur(<?= $post['id'] ?>, <?= $post['is_blurred'] ? 'true' : 'false' ?>)"
                            data-post-id="<?= $post['id'] ?>"
                            data-is-blurred="<?= $post['is_blurred'] ?>">
                            <?= $post['is_blurred'] ? '<i class="bi bi-file-lock"></i>' : '<i class="bi bi-file-lock-fill"></i>' ?> <!--iconos de blur para post, coinciden con el js-->
                        </button>
                    <?php } ?>
                </div>
                <!--<button class="btn btn-danger delete-post-btn" data-post-id="${post.id}"><i class="bi bi-trash3"></i></button>-->
            </div>
        </div>
    <?php } ?>
</div>

<!-- Modal Comments -->
<div class="modal fade data-post-id" data-post-id id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <span></span>
                <h1 class="modal-title fs-5 modal-post-username" id="commentsModalLabel"></h1></span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <!-- Imagen o video y descripción -->
                        <div class="col-lg-6 col-md-12">
                            <div class="card col-12 mb-3">
                                <!-- Renderizar dinámicamente imagen o video -->
                                <div class="modal-media">
                                    <!-- Este contenedor será actualizado dinámicamente con JS -->
                                </div>
                                <div class="card-body">
                                    <p class="card-text modal-post-caption"></p>
                                    <!-- Botón para editar el caption -->
                                    <button id="edit-caption-btn" class="btn btn-sm btn-outline-primary mt-2" onclick="showEditCaptionForm()">Editar descripción</button>
                                    <!-- Formulario para editar el caption -->
                                    <form id="edit-caption-form" class="d-none mt-2" method="POST" action="/post/update-caption">
                                        <textarea class="form-control" id="new-caption" rows="2"></textarea>
                                        <button type="submit" class="btn btn-primary btn-sm mt-2">Guardar</button>
                                        <button type="button" id="cancel-edit-caption" class="btn btn-secondary btn-sm mt-2">Cancelar</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Comentarios con scroll -->
                        <div class="col-lg-6 col-md-12">
                            <!-- Campo para nuevo comentario -->
                            <div class="modal-body">
                                <form class="row g-3" id="add-comment-form">
                                    <div class="card-footer border-0 col-12" style="background-color: #f8f9fa;">
                                        <div class="d-flex flex-start w-100">
                                            <img class="rounded-circle shadow-1-strong me-3 profile-photo"
                                                src="<?= file_exists(__DIR__ . '/../../../public/assets/images/profiles/' . $_SESSION['user']['id'] . '.' . $_SESSION['user']['profile_photo_type'])
                                                            ? '/assets/images/profiles/' . $_SESSION['user']['id'] . '.' . $_SESSION['user']['profile_photo_type']
                                                            : '/assets/images/user-default.png' ?>"
                                                alt="avatar" width="40"
                                                height="40" />
                                            <div class="form-outline w-100">
                                                <textarea class="form-control w-100" id="comment-textarea" rows="2" style="background: #fff;"></textarea>
                                            </div>
                                        </div>
                                        <div class="float-end mt-2 pt-1">
                                            <button type="submit" class="btn btn-primary btn-sm">Agregar comentario</button>
                                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Contenedor scrolleable de comentarios -->
                            <div class="comments" style="max-height: 673px; overflow-y: auto; overflow-x: hidden;">
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