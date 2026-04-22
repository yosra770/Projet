<?php
require_once("../Produits/traitement.php");

$p = new produit();
$p->supprimerProduit($_GET['id']);

header("Location: liste.php");
?>