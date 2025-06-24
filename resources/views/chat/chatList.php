<!-- Modal Chat -->
<div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-link d-none chat-back-btn" aria-label="Atras" onclick="returnChatList()">
                    <i class="bi bi-arrow-left-circle-fill"></i>
                </button>

                <h1 class="modal-title fs-5" id="createPostsModalLabel">Chats</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fixed-height-modal">
                <div class="container h-100">
                    <div class="row h-100">
                        <!-- Chat List -->
                        <div class="col-md-12 mb-4 mb-md-0 scrollable-col container-chat-list">
                            <div class="card chat-list">
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Chat Messages -->
                        <div class="col-md-12 " class="d-none " id="container-chat-messages">
                            <div class="row chat-messages scrollable-row">
                                <ul class="list-unstyled">

                                </ul>
                            </div>
                            <div class="row border-top pt-3">
                                <div class="col-10">
                                    <div data-mdb-input-init class="form-outline">
                                        <textarea class="form-control text-area-mssg " id="textAreaExample2" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn1 btn-info btn-rounded float-end"><i class="bi bi-send"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/chat.js"></script>