<?php
session_start();

$index = $_GET['index'];
$action = $_GET['action'];

if (!isset($_SESSION['panier'][$index])) {
    header("Location: afficher.php");
    exit;
}

if ($action == "plus") {
    $_SESSION['panier'][$index]['qty']++;
}

if ($action == "minus") {
    $_SESSION['panier'][$index]['qty']--;

    if ($_SESSION['panier'][$index]['qty'] <= 0) {
        unset($_SESSION['panier'][$index]);
    }
}

header("Location: afficher.php");
exit;
?>