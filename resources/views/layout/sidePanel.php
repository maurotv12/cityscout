<!-- Botón para abrir el panel -->
<button class="btn btn-primary m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
  ☰ Menú
</button>

<!-- Side Panel -->
<div class="offcanvas offcanvas-start sidebar-custom" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
  <div class="offcanvas-header">
    <a href="/" style="text-decoration: none; color: inherit;">
      <h5 class="offcanvas-title" id="sidebarMenuLabel" >Focuz</h5>
    </a>  
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
    </ul>
  </div>
</div>