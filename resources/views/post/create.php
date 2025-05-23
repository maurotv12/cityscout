<!-- Modal create Posts -->
<!-- <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostsModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-md modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createPostsModalLabel">Crear Publicación</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createPostForm" enctype="multipart/form-data" action="/post/store" method="POST">
                    <div class="mb-3">
                        <label for="formFileMultiple" class="form-label">Elige tus imágenes o videos</label>
                        <input class="form-control" id="files" type="file" id="formFileMultiple" name="files[]" multiple accept=".jpg,.jpeg,.png,.mp4" required>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" id="caption" name="caption" rows="3" placeholder="Escribe una descripción..." required></textarea>
                    </div>
                    <div class="float-end mt-2 pt-1">
                        <button type="submit" class="btn btn-primary btn-sm">Publicar</button>
                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> -->

<div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostsModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-md modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createPostsModalLabel">
                    <i class="bi bi-plus-square"></i> Crear Publicación
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createPostForm" enctype="multipart/form-data" action="/post/store" method="POST">
                    <div class="mb-3 d-flex justify-content-center align-items-center">
                        <!-- Input file oculto -->
                        <input
                            type="file"
                            id="files"
                            name="files[]"
                            multiple
                            accept=".jpg,.jpeg,.png,.mp4"
                            style="display: none;"
                            required>

                        <!-- Icono personalizado como botón -->
                        <label for="files" style="cursor: pointer;">
                            <i class="bi bi-upload fs-3 text-primary"> <small class="ms-2">Subir Publicación</small></i>
                        </label>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" id="caption" name="caption" rows="3" placeholder="Escribe una descripción..." required></textarea>
                    </div>
                    <div class="float-end mt-2 pt-1">
                        <button type="submit" class="btn btn-primary btn-sm">Publicar</button>
                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/createPost.js"></script>