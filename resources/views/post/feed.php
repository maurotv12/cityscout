<?php
ob_start();
$messages = [];
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