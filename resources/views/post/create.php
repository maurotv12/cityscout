






<!-- Modal create Posts-->
<div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostsModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-md modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createPostsModalLabel">Mauricio</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <!-- Imagen y descripción -->
                        <div class="mb-3">
                            <label for="formFileMultiple" class="form-label">Elige tus imagenes y videos</label>
                            <input class="form-control" type="file" id="formFileMultiple" multiple>
                        </div>
                        <div class="modal-footer">
                            <div class="card-footer border-0 col-12" style="background-color: #f8f9fa;">
                                <div class="d-flex flex-start w-100">
                                    <img class="rounded-circle shadow-1-strong me-3"
                                        src="<?= $_SESSION['id']['profile_photo'] ?? '/assets/images/user-default.png' ?>" alt="avatar" width="40"
                                        height="40" />
                                    <div class="form-outline w-100">
                                        <textarea class="form-control" rows="2" style="background: #fff;"></textarea>
                                    </div>
                                </div>
                                <div class="float-end mt-2 pt-1">
                                    <button type="button submit" class="btn btn-primary btn-sm">Publicar</button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
</div>


