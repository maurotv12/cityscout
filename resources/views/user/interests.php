<!-- Modal Chat -->
<div class="modal fade" id="interestsModal" tabindex="-1" aria-labelledby="interestsModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-link  interests-back-btn " aria-label="Atras" onclick="returnInterestsList()">
                    <i class="bi bi-arrow-left-circle-fill"></i>
                </button>

                <h1 class="modal-title fs-5" id="createPostsModalLabel">Conecta con más personas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fixed-height-modal">
                <div class="container h-100">
                    <div class="row h-100">

                        <div class="col-md-12 mb-4 mb-md-0 scrollable-col ">
                            <!-- Opciones de intereses -->
                            <div class="interests-container ">
                                <small>¡Selecciona al menos tres de tus intereses para conectar con más personas!</small>

                                <div class="interests-btns d-flex flex-wrap justify-content-center mt-3 gap-2">
                                    <!-- Interests Renderizado con JS -->
                                </div>
                            </div>
                            <!-- Sugerencias de usuarios -->
                            <div class="suggestions-container ">
                                <!-- Suggestions Renderizado con JS -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="continue-btn" class="btn btn1 btn-primary btn-continue">Continuar</button>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/interests.js"></script>