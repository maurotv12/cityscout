<!-- Modal Chat -->
<div class="modal fade" id="interestsModal" tabindex="-1" aria-labelledby="interestsModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-link  interests-back-btn " aria-label="Atras" onclick="returnInterestsList()">
                    <i class="bi bi-arrow-left-circle-fill"></i>
                </button>

                <h1 class="modal-title fs-5" id="createPostsModalLabel">Temas de Interés</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fixed-height-modal">
                <div class="container h-100">
                    <div class="row h-100">
                        <!-- interests options -->
                        <div class="col-md-12 mb-4 mb-md-0 scrollable-col ">
                            <div class="interests-container d-none">
                                <span>Selecciona al menos tres de tus intereses</span>

                                <div class="d-flex flex-wrap justify-content-center mt-3 gap-2">
                                    <button type="button" class="btn btn-dark rounded-pill">amor</button>
                                    <button type="button" class="btn btn-light rounded-pill">paisajes</button>
                                    <button type="button" class="btn btn-light rounded-pill">comida</button>
                                    <button type="button" class="btn btn-dark rounded-pill">bailar</button>
                                    <button type="button" class="btn btn-dark rounded-pill">cine</button>
                                    <button type="button" class="btn btn-light rounded-pill">natación</button>
                                    <button type="button" class="btn btn-light rounded-pill">viajar</button>
                                    <button type="button" class="btn btn-dark rounded-pill">amor</button>
                                    <button type="button" class="btn btn-light rounded-pill">paisajes</button>
                                    <button type="button" class="btn btn-light rounded-pill">comida</button>
                                    <button type="button" class="btn btn-dark rounded-pill">bailar</button>
                                    <button type="button" class="btn btn-dark rounded-pill">cine</button>
                                    <button type="button" class="btn btn-light rounded-pill">natación</button>
                                    <button type="button" class="btn btn-light rounded-pill">viajar</button>
                                    <button type="button" class="btn btn-light rounded-pill">comida</button>
                                    <button type="button" class="btn btn-dark rounded-pill">bailar</button>
                                    <button type="button" class="btn btn-dark rounded-pill">cine</button>
                                    <button type="button" class="btn btn-light rounded-pill">natación</button>
                                    <button type="button" class="btn btn-light rounded-pill">viajar</button>
                                </div>
                            </div>

                            <div class="suggestions-container ">
                                <div class="col-12 d-flex align-items-center border-0 justify-content-between mb-3">
                                    <div class="d-flex align-items-center">
                                        <img src="/assets/images/profiles/${user.id}.${user.profile_photo_type}"
                                            onerror="this.src='/assets/images/user-default.png';"
                                            alt="${user.username}"
                                            class="rounded-circle me-2"
                                            style="width: 70px; height: 70px; object-fit: cover;">
                                        <div class="d-grid">
                                            <a href="/profile/${user.id}" class="text-decoration-none text-body">
                                                Mauricio Andres Muñoz
                                            </a>
                                            <small class="">@mauricioamz 200 seguidores</small>
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-primary rounded-pill me-2">amor</span>
                                                <span class="badge bg-primary rounded-pill me-2">cine</span>
                                                <span class="badge bg-primary rounded-pill me-2">viajar</span>
                                            </div>
                                        </div>

                                    </div>
                                    <button id="follow-btn"
                                        class="btn btn-sm me-2 <?= true ? 'btn-primary' : 'btn-outline-primary' ?>"
                                        data-user-id=""
                                        onclick="">
                                        <?= false ? 'Dejar de seguir' : 'Seguir' ?>
                                    </button>
                                </div>

                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Continuar</button>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/interests.js"></script>

