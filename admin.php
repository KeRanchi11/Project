<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';

function compressImage($source, $destination, $quality) {
    $info = getimagesize($source);
    if ($info['mime'] == 'image/jpeg') 
        $image = imagecreatefromjpeg($source);
    elseif ($info['mime'] == 'image/png') 
        $image = imagecreatefrompng($source);
    elseif ($info['mime'] == 'image/gif') 
        $image = imagecreatefromgif($source);
    else 
        return false;
    
    imagejpeg($image, $destination, $quality);
    return $destination;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['images'])) {
    $category = $_POST['category'];
    $api_key = "NZg78FyBQkRNnVdlB8ph9mcRpKn2rZjL"; // کلید API TinyPNG

    foreach ($_FILES['images']['name'] as $key => $filename) {
        $filename = basename($filename);
        $target = "uploads/" . $filename;

        // **جلوگیری از آپلود فایل تکراری**
        if (file_exists($target)) {
            echo "<p style='color:red;'>فایل {$filename} از قبل وجود دارد!</p>";
            continue;
        }

        // **ارسال تصویر به TinyPNG برای فشرده‌سازی**
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.tinify.com/shrink");
        curl_setopt($ch, CURLOPT_USERPWD, "api:" . $api_key);
        curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($_FILES['images']['tmp_name'][$key]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (isset($response["output"]["url"])) {
            file_put_contents($target, file_get_contents($response["output"]["url"]));
        } else {
            // **اگر فشرده‌سازی با TinyPNG موفق نبود، از روش محلی استفاده کن**
            move_uploaded_file($_FILES['images']['tmp_name'][$key], $target);
            compressImage($target, $target, 75);
        }

        // ذخیره در دیتابیس
        $stmt = $conn->prepare("INSERT INTO images (filename, category) VALUES (?, ?)");
        $stmt->bind_param("ss", $filename, $category);
        $stmt->execute();
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("SELECT filename FROM images WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $filename = $row['filename'];
    $file_path = "uploads/" . $filename;
    
    if (file_exists($file_path)) {
        unlink($file_path);
    }

    $stmt = $conn->prepare("DELETE FROM images WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header('Location: admin.php');
    exit;
}

$result = $conn->query("SELECT * FROM images ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin-panel.css">
</head>
<body>

<h1>Admin Panel</h1>

<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="admin.php">Admin</a></li>
        <li><a href="logout.php" class="logout-button">Logout</a></li>
    </ul>
    <img src="Logo/Asset 1.png" alt="Logo" class="logo">
</nav>

<form method="POST" enctype="multipart/form-data">
    <input type="file" multiple accept="image/png, image/gif, image/jpeg" name="images[]" required>
    <select name="category">
        <option value="chanelium">Chanelium</option>
        <option value="Neon">Neon</option>
        <option value="Steel">Steel</option>
        <option value="Plastic">Plastic</option>
        <option value="LightBox">LightBox</option>
        <option value="Others">Others</option>
    </select>
    <button type="submit">Upload</button>
</form>

<div class="gallery">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="image">
            <img src="uploads/<?= $row['filename'] ?>" alt="<?= $row['filename'] ?>">
        </div>
        <a href="admin.php?delete=<?= $row['id'] ?>" class="delete">Delete</a>
    <?php endwhile; ?>
</div>

</body>
</html>
