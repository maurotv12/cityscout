<?php
// views/chatList.php

// Supongamos que ya tienes $messages definido desde tu controlador o lógica previa

// Iniciar un buffer para capturar el HTML del body
ob_start();
$_SESSION['user'] = [
    'name' => 'Mauricio',
];
?>

<h1>Listado de mensajes</h1>

<ul>
    <?php foreach($messages as $message): ?>
        <li>
            <a href="/chats/<?= $message['id'] ?>">
                <?= htmlspecialchars($message['message']) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<?php
// Guardar el contenido generado en $content
$content = ob_get_clean();

// Incluir el layout principal
include __DIR__ . '/../layout/main.php';
?>