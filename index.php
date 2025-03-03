<?php
include 'db.php';
$result = $conn->query("SELECT * FROM images ORDER BY id DESC");

// دریافت تمام دسته‌بندی‌های منحصر به فرد از دیتابیس
$categories = $conn->query("SELECT DISTINCT category FROM images");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <h1>Maleki SignMaker</h1>
    <!-- منوی ناوبری -->
    <nav>
        <ul>
            <li><a href="index.php" class="<?= $current_page === 'index' ? 'active' : '' ?>">Home</a></li>
            <li><a href="admin.php" class="<?= $current_page === 'admin' ? 'active' : '' ?>">Admin</a></li>
        </ul>
        <img src="Logo/Asset 1.png" alt="Logo" class="logo">
    </nav>
    
    <!-- دکمه‌های فیلتر -->
    <div class="filter-buttons">
        <button onclick="filterImages('all')" class="active">All</button>
        <?php while ($category_row = $categories->fetch_assoc()): ?>
            <button onclick="filterImages('<?= $category_row['category'] ?>')">
                <?= ucfirst($category_row['category']) ?>
            </button>
        <?php endwhile; ?>
    </div>

    <!-- گالری عکس‌ها -->
    <div class="gallery">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="image" data-category="<?= $row['category'] ?>">
            <img src="uploads/<?= $row['filename'] ?>" alt="<?= $row['filename'] ?>" onclick="openModal('<?= $row['filename'] ?>')">
        </div>
    <?php endwhile; ?>
</div>

    <!-- مودال بزرگ‌نمایی -->
    <div id="modal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="modalImg" class="modal-content">
    </div>

    <script src="js/script.js"></script>
</body>
</html>