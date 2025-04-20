<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Focuz</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse me-auto" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      </ul>

      <?php if (isset($_SESSION['user'])): ?>
        <a class="nav-link me-3" href="#">Notificaciones</a>

        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>

        <div class="d-flex align-items-center ms-3">
          <a class="nav-link p-0 d-flex align-items-center me-3" href="/profile/<?= $_SESSION['user']['id'] ?>">
            <img 
              src="<?= $_SESSION['user']['avatar'] ?? '/images/default-avatar.jpg' ?>" 
              alt="Perfil" 
              class="rounded-circle" 
              style="width: 40px; height: 40px; object-fit: cover;"
            >
            <span class="ms-2"><?= htmlspecialchars($_SESSION['user']['username']) ?></span>
          </a>

          <!-- Botón de logout -->
          <a href="/logout" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</nav>
