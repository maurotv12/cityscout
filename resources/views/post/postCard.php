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
        <a href="#" class="btn btn-primary like-btn" data-post-id="<?= $post['id'] ?>"><i class="bi bi-hand-thumbs-up"></i></a>
        <a href="#" class="btn btn-success unlike-btn" data-post-id="<?= $post['id'] ?>"><i class="bi bi-hand-thumbs-up"></i></a>
        <a href="#" 
           class="btn btn-primary" 
           data-bs-toggle="modal" 
           data-bs-target="#commentsModal" 
           data-post-id="<?= $post['id'] ?>">
           <i class="bi bi-chat-heart-fill"></i>
        </a>
    </div>
</div>

<!-- Incluir lo siguiente en el list, ponerlo en la parte superior -->
<div class="row">
    <?php foreach ($posts as $post) { ?>
        <?php include __DIR__ . '/post-card.php'; ?>
    <?php } ?>
</div>

<!-- y esto al final del list e incluir en el profile.php -->

<script src="/assets/js/post.js"></script>
