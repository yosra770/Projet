<?php
session_start();

function requireLogin()
{
    if (!isset($_SESSION['utilisateur'])) {
        header("Location: ../auth/login.php");
        exit();
    }
}

function requireAdmin()
{
    if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] != 'admin') {
        header("Location: ../auth/login.php");
        exit();
    }
}
?>