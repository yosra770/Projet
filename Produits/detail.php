
<?php
session_start(); // 🔥 OBLIGATOIRE

require_once("../config/db.php");

$connexion = new Connexion();
$conn = $connexion->CNXbase();

$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM produits WHERE id = ?");
$stmt->execute([$id]);

$produit = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produit) {
    die("Produit introuvable");
}

// pointures selon catégorie
$pointures = [];

if ($produit['categorie'] == 'men') {
    $pointures = range(40, 46);
} elseif ($produit['categorie'] == 'women') {
    $pointures = range(36, 42);
} elseif ($produit['categorie'] == 'kids') {
    $pointures = range(28, 35);
}

// favoris
$favoris = $_SESSION['favoris'] ?? [];
$isFav = isset($favoris[$produit['id']]);
?>

<?php include("../includes/header.php"); ?>

<div class="container mt-5 product-wrapper">

    <div class="row product-box">

        <!-- IMAGE -->
        <div class="col-md-6 product-image">
            <img src="../assets/images/<?= $produit['image'] ?>" class="img-fluid">

            <!-- ❤️ FAVORIS -->
            <a href="../favoris/toggle.php?id=<?= $produit['id'] ?>" class="btn-fav">
                <?= $isFav ? "❤️" : "🤍" ?>
            </a>
        </div>

        <!-- INFO -->
        <div class="col-md-6 product-info">

            <h2><?= $produit['nom'] ?></h2>

            <div class="price"><?= $produit['prix'] ?> DT</div>

            <p class="desc"><?= $produit['description'] ?></p>
            <div class="stock-status mt-2">

<?php
$stock = $produit['stock'] ?? 0;
?>

<?php if ($stock > 10): ?>
    <span class="badge bg-success">In Stock</span>

<?php elseif ($stock > 0): ?>
    <span class="badge bg-warning text-dark">
        Only <?= $stock ?> left
    </span>

<?php else: ?>
    <span class="badge bg-danger">Out of Stock</span>
<?php endif; ?>

</div>

            <!-- FORMULAIRE UNIQUE -->
            <form method="POST" action="../panier/add.php">

                <input type="hidden" name="id" value="<?= $produit['id'] ?>">

                <!-- SIZE -->
                <label>Size</label>
                <select name="taille" class="form-control mb-3" required>
                    <option value="">Select size</option>
                    <?php foreach ($pointures as $t): ?>
                        <option value="<?= $t ?>"><?= $t ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- COLOR -->
                <label>Color</label>
                <select name="couleur" class="form-control mb-3" required>
                    <option value="">Select color</option>
                    <option value="Noir">Black</option>
                    <option value="Blanc">White</option>
                    <option value="Rouge">Red</option>
                    <option value="Bleu">Blue</option>
                </select>

                <button class="btn-buy w-100">
                    🛒 Add to Cart
                </button>

            </form>

        </div>

    </div>

</div>

<?php include("../includes/footer.php"); ?>