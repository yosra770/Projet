<?php
require_once("../../config/db.php");

$db = new \Connexion();
$conn = $db->CNXbase();

$conn->prepare("DELETE FROM utilisateur WHERE id=?")->execute([$_GET['id']]);

header("Location: ../produits/liste.php");
?>