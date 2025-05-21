<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top shadow-sm">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    
    <!-- Botón del Side Panel -->
    <?php if (isset($_SESSION['user'])): ?>
      <div class="d-flex align-items-center flex-shrink-0">
        <button class="btn  me-3 d-none d-lg-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
          ☰ <span class="ms-2">Menú</span>
        </button>
        <button class="btn  me-3 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
          ☰
        </button>
        <a class="navbar-brand d-flex align-items-center" href="/">
          <img src="/assets/images/logo.png" alt="Logo" class="logo-img">
        </a>
      </div>
    <?php endif; ?>

   <!-- Dropdown de Notificaciones y Foto de Perfil -->
   <?php if (isset($_SESSION['user'])): ?>
      <div class="d-flex align-items-center flex-shrink-0">
        <!-- Notificaciones -->
        <div class="dropdown me-3">
          <button class="btn position-relative" style="width: 40px; height: 40px; object-fit: cover;" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-bell"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationCount">
              0
            </span>
          </button>
          
          <ul 
            class="dropdown-menu dropdown-menu-end notifications-dropdown"
            aria-labelledby="notificationDropdown" 
            style="max-height: 300px; overflow-y: auto;">
            <li 
              class="dropdown-item text-center text-000000muted" 
              id="noNotifications">No hay notificaciones
            </li>
          </ul>
        </div>
           <!-- Foto de perfil -->
          <a class="nav-link p-0 d-flex align-items-center" href="/profile/<?= $_SESSION['user']['id'] ?>">
          <img
            src="<?= file_exists(__DIR__ . '/../../../public/assets/images/profiles/' . $_SESSION['user']['id'] . '.' . $_SESSION['user']['profile_photo_type'])
                    ? '/assets/images/profiles/' . $_SESSION['user']['id'] . '.' . $_SESSION['user']['profile_photo_type']
                    : '/assets/images/user-default.png' ?>"
            alt="Perfil"
            class="rounded-circle profile-photo"
            style="width: 40px; height: 40px; object-fit: cover;">
              <!--mostrar el nombre del usuario opcional -->
            <!-- <span class="ms-2"><?= htmlspecialchars($_SESSION['user']['username']) ?></span> -->
          </a>
        </div>
      <?php endif; ?>
    
  </div>
</nav>

<!-- Incluir el Side Panel -->
<?php include __DIR__ . '/sidePanel.php'; ?>
<script src="/assets/js/notifications.js"></script>