<?php
ob_start();
$messages = [];

?>
<div class="container py-4">
    <ul class="nav nav-tabs mb-3" id="followersTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="followers-tab" data-bs-toggle="tab" data-bs-target="#followers" type="button" role="tab" aria-controls="followers" aria-selected="true">
                Seguidores
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="following-tab" data-bs-toggle="tab" data-bs-target="#following" type="button" role="tab" aria-controls="following" aria-selected="false">
                Seguidos
            </button>
        </li>
    </ul>
    <div class="tab-content" id="followersTabContent">
        <!-- Seguidores -->
        <div class="tab-pane fade show active" id="followers" role="tabpanel" aria-labelledby="followers-tab">
            <?php if (empty($followers)) : ?>
                <p class="text-center text-muted">Sin seguidores.</p>
            <?php else : ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($followers as $follower) : ?>
                        <li class="list-group-item d-flex align-items-center">
                            <a href="/@<?= htmlspecialchars($follower['username']) ?>">
                                <img src="<?= file_exists(__DIR__ . '/../../../public/assets/images/profiles/' . $follower['id'] . '.' . $follower['profile_photo_type'])
                                                ? '/assets/images/profiles/' . $follower['id'] . '.' . $follower['profile_photo_type']
                                                : '/assets/images/user-default.png' ?>"
                                    alt="avatar"
                                    class="rounded-circle me-3"
                                    width="48" height="48"
                                    style="object-fit:cover;">
                            </a>
                            <div class="flex-grow-1">
                                <a href="/@<?= htmlspecialchars($follower['username']) ?>" class="fw-bold text-dark text-decoration-none">
                                    <?= htmlspecialchars($follower['fullname']) ?>
                                </a>
                                <div class="text-muted small">@<?= htmlspecialchars($follower['username']) ?></div>
                            </div>
                            <!-- Opcional: botón seguir/dejar de seguir -->
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <!-- Seguidos -->
        <div class="tab-pane fade" id="following" role="tabpanel" aria-labelledby="following-tab">
            <?php if (empty($following)) : ?>
                <p class="text-center text-muted">No sigue a nadie.</p>
            <?php else : ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($following as $followed) : ?>
                        <li class="list-group-item d-flex align-items-center">
                            <a href="/@<?= htmlspecialchars($followed['username']) ?>">
                                <img src="<?= file_exists(__DIR__ . '/../../../public/assets/images/profiles/' . $followed['id'] . '.' . $followed['profile_photo_type'])
                                                ? '/assets/images/profiles/' . $followed['id'] . '.' . $followed['profile_photo_type']
                                                : '/assets/images/user-default.png' ?>"
                                    alt="avatar"
                                    class="rounded-circle me-3"
                                    width="48" height="48"
                                    style="object-fit:cover;">
                            </a>
                            <div class="flex-grow-1">
                                <a href="/@<?= htmlspecialchars($followed['username']) ?>" class="fw-bold text-dark text-decoration-none">
                                    <?= htmlspecialchars($followed['fullname']) ?>
                                </a>
                                <div class="text-muted small">@<?= htmlspecialchars($followed['username']) ?></div>
                            </div>
                            <!-- Opcional: botón seguir/dejar de seguir -->
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>