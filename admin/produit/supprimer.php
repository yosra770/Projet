<?php
require_once(__DIR__ . "/traitement.php");

$p = new produit();
$p->supprimerProduit($_GET['id']);

header("Location: liste.php");
?>