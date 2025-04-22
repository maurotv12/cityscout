<?php
ob_start();
$messages = [];
?>



<div class="container py-5">
    <div class="row align-items-center">
      <div class="col-md-4 text-center">
        <img src="ruta/a/tu-imagen.jpg" alt="Foto de perfil" class="profile-img mb-3">
      </div>
      <div class="col-md-8">
        <div class="d-flex align-items-center mb-3">
          <span class="username me-3">elmundook</span>
          <button class="btn btn-outline-secondary btn-sm me-2">Editar perfil</button>
          <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-gear"></i></button>
        </div>
        <div class="mb-3">
          <span><strong>1,012</strong> publicaciones</span>
          <span class="ms-4"><strong>9,572</strong> seguidores</span>
          <span class="ms-4"><strong>719</strong> seguidos</span>
        </div>
        <div class="bio">
          <strong>BO SALDAÑA</strong><br>
          Iquiteño, Peruano, y Viajero 🌍<br>
          Freelance Travel Writer (ES/EN)<br>
          Gastronomía en <a href="#">@bosaldana</a> 🍴<br>
          <strong>Ahora:</strong> En breve 🇮🇳<br>
          <a href="https://elmundook.com/que-es-priority-pass-viajar-sin-estres" target="_blank">elmundook.com/que-es-priority-pass-viajar-sin-estres</a>
        </div>
      </div>
    </div>
  </div>

<?php
// Guardar el contenido generado en $content
$content = ob_get_clean();

// Incluir el layout principal
include __DIR__ . '/../layout/main.php';
?>