<?php
session_start();

// vider toutes les variables de session
$_SESSION = [];

// détruire la session
session_destroy();

// rediriger vers login ou home
header("Location: login.php");
exit();
?>