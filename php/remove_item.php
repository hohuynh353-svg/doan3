<?php
session_start();
$index = $_GET['index'] ?? -1;

if (isset($_SESSION['donhang'][$index])) {
    unset($_SESSION['donhang'][$index]);
    $_SESSION['donhang'] = array_values($_SESSION['donhang']); // Reindex lại
}

header('Location: donhang.php'); // QUAY VỀ donhang.php (chứ không phải checkout)
exit;
