<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../config/db.php");

$connexion = new Connexion();
$conn = $connexion->CNXbase();

$favoris = $_SESSION['favoris'] ?? [];

$produits = [];

if (!empty($favoris)) {

    $ids = array_keys($favoris);

    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $stmt = $conn->prepare("SELECT * FROM produits WHERE id IN ($placeholders)");
    $stmt->execute($ids);

    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<?php include("../includes/header.php"); ?>

<div class="container mt-5">

    <h2>❤️ My Wishlist</h2>

    <?php if (empty($produits)): ?>

        <div class="text-center mt-5">
            <h3>❤️ Your favorites list is empty</h3>
            <p class="text-muted">Start adding your favorite sneakers now!</p>

            <a href="/web2/projet/produits/liste.php" class="btn btn-dark mt-3">
                🛍️ Browse products
            </a>
        </div>

    <?php else: ?>

        <div class="row">

            <?php foreach ($produits as $p): ?>

                <div class="col-md-3 mb-3">

                    <div class="card p-2 shadow-sm">

                        <img src="../assets/images/<?= $p['image'] ?>" class="img-fluid">

                        <h5 class="mt-2"><?= $p['nom'] ?></h5>

                        <p><?= $p['prix'] ?> DT</p>

                        <div class="d-flex justify-content-between">

                            <a href="../produits/detail.php?id=<?= $p['id'] ?>" class="btn btn-dark btn-sm">
                                View
                            </a>

                            <a href="../favoris/toggle.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm">
                                Remove
                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>

<?php include("../includes/footer.php"); ?>