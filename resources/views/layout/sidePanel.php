<!-- Side Panel -->
<link rel="stylesheet" href="/assets/css/style.css"> 
<link rel="stylesheet" href="/assets/css/side-panel.css">

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
  <div class="offcanvas-body  d-flex flex-column align-items-center">
    <ul class="nav flex-column">
      <li class="nav-item border-0">
        <a class="nav-link  d-flex  align-items-center icon-lg" aria-current="page" href="/"><i class="bi bi-house-fill"></i></a>
      </li>
      <li class="nav-item border-0">
        <a class="nav-link d-flex  align-items-center icon-lg" href="#" data-bs-toggle="modal" data-bs-target="#chatModal"><i class="bi bi-wechat"></i></a>
      </li>
      <li class="nav-item border-0">
        <a class="nav-link d-flex  align-items-center icon-lg" href="#" data-bs-toggle="modal" data-bs-target="#createPostModal"><i class="bi bi-upload"></i></a>
      </li>
       <li class="nav-item border-0">
        <a class="nav-link d-flex  align-items-center icon-lg" href="#" data-bs-toggle="modal" data-bs-target="#interestsModal"><i class="bi bi-person-plus-fill"></i></a>
      </li>
      <li class="nav-item">
        <!-- Botón de logout -->
        <a href="/logout" class="btn btn-outline-danger btn-sm  mt-5 rounded-pill ">Cerrar sesión</a>
      </li>
    </ul>
  </div>
</div>


