<?php
ob_start();
$messages = [];
?>

<?php include __DIR__ . '/list.php'; ?>

<?php
// Guardar el contenido generado en $content
$content = ob_get_clean();

// Incluir el layout principal
include __DIR__ . '/../layout/main.php';
?>