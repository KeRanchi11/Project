<?php
session_start();
session_unset(); // حذف تمام متغیرهای سشن
session_destroy(); // نابود کردن سشن
header("Location: login.php"); // هدایت به صفحه لاگین
exit;
?>
