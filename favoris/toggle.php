<?php
session_start();

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: ../produits/liste.php");
    exit();
}

if (!isset($_SESSION['favoris'])) {
    $_SESSION['favoris'] = [];
}

// toggle
if (isset($_SESSION['favoris'][$id])) {
    unset($_SESSION['favoris'][$id]); // remove
} else {
    $_SESSION['favoris'][$id] = true; // add
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();