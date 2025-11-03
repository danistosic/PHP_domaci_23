<?php

require_once "models/DB.php";

$db = new DB();


$connection = mysqli_connect(hostname: "localhost", username: "root", password: "", database: "php23");

$data = $connection->query(query: "SELECT * FROM images");

?>

<html>

<head>
</head>

<body>
    <?php foreach($data as $image): ?>
        <img width="100px" height="auto" src="uploads/<?= $image['image'] ?>" />
    <?php endforeach; ?>
</body>

</html>

