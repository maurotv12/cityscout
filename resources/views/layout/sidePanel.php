

<!-- Side Panel -->
<div class="offcanvas offcanvas-start sidebar-custom" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
  <div class="offcanvas-header">
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100%;">
      <a href="/" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; align-items: center;">
        <img src="/assets/images/logo.png" alt="Logo" style="height: 40px; ">
        <h5 class="offcanvas-title" id="sidebarMenuLabel">Focuz</h5>
      </a>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
  </div>
  <div class="offcanvas-body p-0">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/">🏠 Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#chatModal">💬 Chats</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#createPostModal">➕ Crear Post</a>
      </li>

      <li class="nav-item">
        <!-- Botón de logout -->
        <a href="/logout" class="btn btn-outline-danger btn-sm ms-3 mt-5">Cerrar sesión</a>
      </li> 
    </ul>
  </div>
</div>


 