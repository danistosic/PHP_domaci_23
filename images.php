<?php require_once "models/Images.php"; $img = new Images(); 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Images</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Uploaded Images</h1>

     <?php if (isset($_SESSION['imageErrors']) && !empty($_SESSION['imageErrors'])): ?>
        <div class="errors">
            <?php foreach ($_SESSION['imageErrors'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['imageErrors']); ?>
    <?php endif; ?>

    <div class="gallery">
        <?php foreach($img->getAllImages() as $image): ?>
            <img src="uploads/<?= htmlspecialchars($image['image']) ?>" alt="Uploaded image">
        <?php endforeach; ?>
    </div>
</body>
</html>



