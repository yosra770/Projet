
<?php
session_start(); // 🔥 OBLIGATOIRE

require_once("../config/db.php");

$connexion = new Connexion();
$conn = $connexion->CNXbase();

$categorie = $_GET['cat'] ?? null;
$style = $_GET['style'] ?? null;

if ($categorie && $style) {
    $stmt = $conn->prepare("SELECT * FROM produits WHERE categorie = ? AND style = ?");
    $stmt->execute([$categorie, $style]);
} elseif ($categorie) {
    $stmt = $conn->prepare("SELECT * FROM produits WHERE categorie = ?");
    $stmt->execute([$categorie]);
} else {
    $stmt = $conn->prepare("SELECT * FROM produits");
    $stmt->execute();
}

$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

$favoris = $_SESSION['favoris'] ?? [];
?>

<?php include("../includes/header.php"); ?>

<div class="container mt-5">

    <h2 class="mb-4">Nos Produits</h2>

    <div class="row">

        <?php foreach ($produits as $p): ?>

            <?php
            $isFav = isset($favoris[$p['id']]);
            ?>

            <div class="col-md-3 mb-4">

                <div class="card shadow position-relative">

                    <!-- ❤️ FAVORIS -->
                    <a href="../favoris/toggle.php?id=<?= $p['id'] ?>" 
                       class="btn btn-light btn-sm position-absolute top-0 end-0 m-2">
                        <?= $isFav ? "❤️" : "🤍" ?>
                    </a>

                    <img src="../assets/images/<?= $p['image'] ?>" class="card-img-top" style="height:200px; object-fit:cover;">

                    <div class="card-body text-center">

                        <h5><?= $p['nom'] ?></h5>
                        <p><?= $p['prix'] ?> DT</p>

                        <a href="detail.php?id=<?= $p['id'] ?>" class="btn btn-dark btn-sm">
                            Voir détail
                        </a>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>
</div>

<?php include("../includes/footer.php"); ?>