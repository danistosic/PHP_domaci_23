<?php 

require_once "models/Images.php";

$image = new Images();

$imageSize = $_FILES['profileImage']['size'];
if (!$image->isValidSize($imageSize)) {
    die("Slika je prevelika!");
}

$imageType = pathinfo($_FILES['profileImage']['name'], flags: PATHINFO_EXTENSION);
if (!$image->isValidExtension($imageType)) {
    die("Nije dobra extenzija slike");
}

list($width, $height) = getimagesize($_FILES['profileImage']['tmp_name']);
if (!$image->isValidProportions($width, $height)) {
    die("Slika je preširoka ili previsoka!");
}


$randomName = $image->generateRandomName(extension: 'jpg');
if (!is_dir('./uploads')) {
    mkdir('./uploads', 0755, true);
}
$image->upload($_FILES['profileImage']['tmp_name'], $randomName, destination: "uploads");

exit();

// Povezivanje s bazom
$connection = mysqli_connect("localhost", "root", "", "php23");

if (!isset($_FILES['profileImage'])) {
    die("Niste proslijedili profilnu sliku!");
}

// PROVJERA VELICINE SLIKE
$imageSize = $_FILES['profileImage']['size']; // 907 kb = 907.000 bytes
$maxFileSize = 2 * 1024 * 1024; // 2 MB (u bajtovima)

if ($imageSize > $maxFileSize) {
    die("Slika je prevelika!");
}

// Slika može biti maksimalno 1920 širine i 1024 visine
list($width, $height) = getimagesize($_FILES['profileImage']['tmp_name']);

if ($width > 1920 || $height > 1024) {
    var_dump($width, $height);
    die("Maksimalna širina slike može biti 1920px, a maksimalna visina 1024px");
}


// PROVJERA EXTENZIJE
$allowedExtensions = ["jpg", "jpeg", "png", "gif"];

$imageType = pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);

if (!in_array($imageType, $allowedExtensions)) {
    die("Format slike nije dobar, mora biti: " . implode(', ', $allowedExtensions));
}


// GENERIRANJE IMENA SLIKE
$imageName = time() . "." . $imageType; // npr. 1730645687.png

$finalPath = "./uploads/$imageName";    // primjer: uploads/1730645687.png
$tmpFileName = $_FILES['profileImage']['tmp_name'];

// Ako folder "uploads" ne postoji, napravi ga
if (!is_dir('./uploads')) {
    mkdir('./uploads', 0755, true);
}

// PREMJEŠTANJE IZ TMP U UPLOADS
$imageUploaded = move_uploaded_file($tmpFileName, $finalPath);

if ($imageUploaded) {
    // Sprema ime slike u bazu
    $imageName = $connection->real_escape_string($imageName);
    $query = "INSERT INTO images (image) VALUES ('$imageName')";
    $connection->query($query);

    die("✅ Uspješno ste dodali sliku!");
} else {
    die("⚠️ Neuspješno uploadovanje slike!");
}

echo "✅ Slika je dobra, možeš nastaviti s uploadom!";



?>

/**
 * 
 * 1. Dodaje je u TMP folder (privremeni folder na serveru)
 *   'tmp_name' => string 'D:\Wampp\tmp\php9703.tmp'
 * 
 * 2. Provjeriti tip slike (da li je png, jpg...)
 * 3. Da li je slika preko x megabajta
 * 4. Promjeniti ime slike 
 * 
 * 5. Pomjeri sliku iz TMP u neki nas folder
 */
