<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top shadow-sm">
  <div class="container-fluid">

    <!-- Boton del side Panel -->
    <button class="btn btn-primary me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
      ☰ Menú
    </button>

    <a class="navbar-brand" href="/"><i class="bi bi-house-door-fill"></i></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse me-auto w-auto" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      </ul>

      <?php if (isset($_SESSION['user'])): ?>

        <form class="d-flex mx-auto position-relative" role="search">
          <input class="form-control text-center" type="search" placeholder="Buscar" aria-label="Search">
          <button class="btn btn-link position-absolute" type="submit"><i class="bi bi-search"></i></button>
        </form>

        <a class="nav-link me-3" href="#"><i class="bi bi-bell"></i></a>

        <div class="d-flex align-items-center ms-3">
          <a class="nav-link p-0 d-flex align-items-center me-3" href="/profile/<?= $_SESSION['user']['id'] ?>">
            <img
              src="<?= $_SESSION['id']['profile_photo'] ?? '/assets/images/user-default.png' ?>"
              alt="Perfil"
              class="rounded-circle"
              style="width: 40px; height: 40px; object-fit: cover;">
            <span class="ms-2"><?= htmlspecialchars($_SESSION['user']['username']) ?></span>
          </a>


        </div>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- Incluir el Side Panel -->
<?php include __DIR__ . '/sidePanel.php'; ?>