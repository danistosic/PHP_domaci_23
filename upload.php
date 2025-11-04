<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "models/Images.php";

$image = new Images();
$_SESSION['imageErrors'] = []; // reset errors

foreach ($_FILES['profileImage']['name'] as $key => $file) {

    $imageSize = $_FILES['profileImage']['size'][$key];
    if (!$image->isValidSize($imageSize)) {
        $_SESSION['imageErrors'][] = "Image '{$file}' is too large!";
        continue;
    }

    $imgName = $_FILES['profileImage']['name'][$key];
    $imageType = pathinfo($imgName, PATHINFO_EXTENSION);
    if (!$image->isValidExtension($imageType)) {
        $_SESSION['imageErrors'][] = "Invalid file extension for '{$file}'.";
        continue;
    }

    $tmpName = $_FILES['profileImage']['tmp_name'][$key];
    list($width, $height) = getimagesize($tmpName);
    if (!$image->isValidProportion($width, $height)) {
        $_SESSION['imageErrors'][] = "Image '{$file}' dimensions are too large.";
        continue;
    }

    $randomName = $image->generateRandomName('jpg');

    if (!is_dir('./uploads')) {
        mkdir('./uploads', 0755, true);
    }

    $image->upload($tmpName, $randomName, 'uploads');
}

// redirect after upload
header("Location: images.php");
exit;


