<?php
session_start();

if (isset($_GET['index'])) {
    $index = (int) $_GET['index'];

    if (isset($_SESSION['panier'][$index])) {
        unset($_SESSION['panier'][$index]);
        $_SESSION['panier'] = array_values($_SESSION['panier']); // réindex
    }
}

header("Location: afficher.php");
exit();