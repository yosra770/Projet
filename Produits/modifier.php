<?php
include("../config/db.php");
include("../includes/session.php");

requireAdmin();

$db = new \Connexion();
$conn = $db->CNXbase();

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM produits WHERE id=?");
$stmt->execute([$id]);
$produit = $stmt->fetch();
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