<?php
require_once("traitement_user.php");

$userObj = new User();

$id = $_GET['id'];
$userObj->deleteUser($id);

header("Location: liste.php");
?>