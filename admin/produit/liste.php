<?php
require_once("../../config/db.php");
require_once("../../includes/session.php");

requireAdmin();

$db = new \Connexion();
$conn = $db->CNXbase();

$produits = $conn->query("SELECT * FROM produits")->fetchAll();
?>

<h2>Liste Produits (Admin)</h2>

<a href="ajouter.php">Ajouter Produit</a><br><br>

<?php foreach ($produits as $p): ?>
    <p>
        <?= $p['nom'] ?> - <?= $p['prix'] ?> TND

        <a href="../../Produits/modifier.php?id=<?= $p['id'] ?>">Modifier</a>
        <a href="../../Produits/supprimer.php?id=<?= $p['id'] ?>">Supprimer</a>
    </p>
<?php endforeach; ?>