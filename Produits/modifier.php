<?php
include("../includes/session.php");
require_once("../Produits/traitement.php");

requireAdmin();

$id = $_GET['id'];

$p = new produit();
$res = $p->getProduit($id);
$produit = $res->fetch();
?>

<h2>Modifier produit</h2>

<form method="POST" action="traitement.php">
    <input type="hidden" name="id" value="<?= $produit['id'] ?>">

    Nom: <input type="text" name="nom" value="<?= $produit['nom'] ?>"><br>
    Prix: <input type="text" name="prix" value="<?= $produit['prix'] ?>"><br>

    Description:
    <textarea name="description"><?= $produit['description'] ?></textarea><br>

    <button type="submit" name="action" value="modifier">Modifier</button>
</form>