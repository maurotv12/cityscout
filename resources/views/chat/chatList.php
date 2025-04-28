<!-- Modal Chat -->
<div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createPostsModalLabel">Chat</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fixed-height-modal">
                <div class="container h-100">
                    <div class="row h-100">
                        <!-- Chat List -->
                        <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0 scrollable-col">
                            <div class="card chat-list">
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                        <li class="p-2 border-bottom bg-body-tertiary">
                                            <a href="#!" class="d-flex justify-content-between">
                                                <div class="d-flex flex-row">
                                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-8.webp" alt="avatar" class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                                                    <div class="pt-1">
                                                        <p class="fw-bold mb-0">John Doe</p>
                                                        <p class="small text-muted">Hello, Are you there?</p>
                                                    </div>
                                                </div>
                                                <div class="pt-1">
                                                    <p class="small text-muted mb-1">Just now</p>
                                                    <span class="badge bg-danger float-end">1</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Chat Messages -->
                        <div class="col-md-6 col-lg-7 col-xl-8">
                            <div class="row scrollable-row">
                                <ul class="list-unstyled">
                                    <li class="d-flex justify-content-between mb-4">
                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar" class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between p-3">
                                                <p class="fw-bold mb-0">Brad Pitt</p>
                                                <p class="text-muted small mb-0"><i class="far fa-clock"></i> 12 mins ago</p>
                                            </div>
                                            <div class="card-body">
                                                <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex justify-content-between mb-4">
                                        <div class="card w-100">
                                            <div class="card-header d-flex justify-content-between p-3">
                                                <p class="fw-bold mb-0">Lara Croft</p>
                                                <p class="text-muted small mb-0"><i class="far fa-clock"></i> 13 mins ago</p>
                                            </div>
                                            <div class="card-body">
                                                <p class="mb-0">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                                            </div>
                                        </div>
                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-5.webp" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60">
                                    </li>
                                </ul>
                            </div>
                            <div class="row border-top pt-3">
                                <div class="col-10">
                                    <div data-mdb-input-init class="form-outline">
                                        <textarea class="form-control bg-body-tertiary" id="textAreaExample2" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-rounded float-end">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
