<!-- layout/main.php -->
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Focuz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css"> 
    <?php include_once __DIR__ . '/header.php'; ?>
</head>

<body>
    <?php  if (isset($_SESSION['user'])) include_once __DIR__ . '/sidePanel.php'; ?>

    <main class="container mt-4"> 
        <?= $content ?? '' ?> 
    </main>

    <?php include_once __DIR__ . '/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>