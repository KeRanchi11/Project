<?php
include 'db.php';
$result = $conn->query("SELECT * FROM images ORDER BY id DESC");

// دریافت تمام دسته‌بندی‌های منحصر به فرد از دیتابیس
$categories = $conn->query("SELECT DISTINCT category FROM images");
?>

<!DOCTYPE html>
<html>
<head>
    <title>تابلو سازی ملکی</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        <div class="image-container" data-category="<?= $row['category'] ?>">
            <div class="image">
                <img src="uploads/<?= $row['filename'] ?>" alt="<?= $row['filename'] ?>" onclick="openModal('<?= $row['filename'] ?>')">
            </div>
            <div class="category-name"><?= ucfirst($row['category']) ?></div>
        </div>
    <?php endwhile; ?>
</div>

    <!-- مودال بزرگ‌نمایی -->
    <div id="modal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="modalImg" class="modal-content">
    </div>

    <!-- فوتر -->
    <footer>
        <div class="footer-content">
            <!-- ستون سمت چپ: اطلاعات تماس -->
            <div class="footer-column contact-info">
                <h3>Contact Information</h3>
                <p><i class="fas fa-phone"></i> 0916778198</p>
                <p><i class="fas fa-map-marker-alt"></i> خیابان مطهری بین نظامی و شیخ بهایی</p>
            </div>

            <!-- ستون وسط: منوی ناوبری -->
            <div class="footer-column footer-navigation">
                <h3>Navigation</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="admin.php">AdminPanel</a></li>
                </ul>
            </div>

            <!-- ستون سمت راست: لوگو -->
            <div class="footer-column footer-logo">
                <img src="Logo/Asset 1.png" alt="Logo">
            </div>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>