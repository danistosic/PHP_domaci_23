


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="upload-container">
        <h2>Upload Profile Images</h2>
        <form method="POST" action="upload.php" enctype="multipart/form-data">
            <input type="file" name="profileImage[]" multiple />
            <input type="submit" value="Upload" />
        </form>
    </div>
</body>
</html>

