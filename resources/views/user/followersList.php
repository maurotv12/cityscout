<!-- Modal Seguidores/Seguidos -->
<div class="modal fade" id="followersModal" tabindex="-1" aria-labelledby="followersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="followersModalLabel">Seguidores</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div id="followers-list-container" class="list-group">
                    <!-- Lista de seguidores se cargará aquí con js-->
                    <?php if (empty($followers)): ?>
                        <p class="text-center">No tienes seguidores aún.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    window.profileUsername = "<?= htmlspecialchars($user['username']) ?>";
    window.followersData = <?= json_encode($followers ?? []) ?>;
    window.followingData = <?= json_encode($following ?? []) ?>;
    window.currentUserId = <?= isset($_SESSION['user']['id']) ? (int)$_SESSION['user']['id'] : 'null' ?>;
</script>

<script src="/assets/js/followersList.js"></script>