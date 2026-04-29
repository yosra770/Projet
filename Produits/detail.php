<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once("../config/db.php");
$connexion = new Connexion();
$conn = $connexion->CNXbase();

$id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT * FROM produits WHERE id = ?");
$stmt->execute([$id]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produit) { die("Produit introuvable"); }

// Logique tailles
$pointures = ($produit['categorie'] == 'men') ? range(40, 46) : (($produit['categorie'] == 'women') ? range(36, 42) : range(28, 35));

$favoris = $_SESSION['favoris'] ?? [];
$isFav = isset($favoris[$produit['id']]);
?>

<?php include("../includes/header.php"); ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;600&display=swap');

    body { background-color: #F8F7F4; font-family: 'Inter', sans-serif; }
    h1, h2 { font-family: 'Playfair Display', serif; }

    /* Layout */
    .product-container { background: #fff; padding: 40px; border: 1px solid #E5E0D8; margin-top: 60px; }
    
    /* Image */
    .img-main { width: 100%; border-radius: 4px; }
    
    /* Swatches & Sizes */
    .option-label { font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #888; margin-bottom: 10px; display: block; }
    
    .size-group { display: flex; gap: 10px; margin-bottom: 20px; }
    .size-option { display: none; }
    .size-label { padding: 10px 15px; border: 1px solid #E5E0D8; cursor: pointer; transition: 0.3s; }
    .size-option:checked + .size-label { background: #1A1A1A; color: #fff; border-color: #1A1A1A; }
    
    .color-group { display: flex; gap: 10px; margin-bottom: 30px; }
    .color-swatch { width: 30px; height: 30px; border-radius: 50%; cursor: pointer; border: 2px solid transparent; }
    .color-input:checked + .color-swatch { border-color: #1A1A1A; outline: 2px solid #fff; outline-offset: -4px; }
    
    /* Button */
    .btn-buy { background: #1A1A1A; color: #fff; padding: 18px; text-transform: uppercase; font-weight: 600; letter-spacing: 2px; border: none; width: 100%; }
    .btn-buy:hover { background: #333; }
</style>

<div class="container product-container">
    <div class="row">
        <div class="col-md-6">
            <div style="position:relative;">
                <img src="../assets/images/<?= $produit['image'] ?>" class="img-main">
                <a href="../favoris/toggle.php?id=<?= $produit['id'] ?>" style="position:absolute; top:20px; right:20px; font-size:24px; text-decoration:none;">
                    <?= $isFav ? "❤️" : "🤍" ?>
                </a>
            </div>
        </div>

        <div class="col-md-5 offset-md-1">
            <h2 style="font-size: 3rem; margin-bottom: 10px;"><?= $produit['nom'] ?></h2>
            <div style="font-size: 1.5rem; margin-bottom: 20px;"><?= $produit['prix'] ?> DT</div>
            <p style="color:#666; line-height: 1.8; margin-bottom: 30px;"><?= $produit['description'] ?></p>

            <form method="POST" action="../panier/add.php">
                <input type="hidden" name="id" value="<?= $produit['id'] ?>">

                <span class="option-label">Taille</span>
                <div class="size-group">
                    <?php foreach ($pointures as $t): ?>
                        <input type="radio" name="taille" value="<?= $t ?>" id="size-<?= $t ?>" class="size-option" required>
                        <label for="size-<?= $t ?>" class="size-label"><?= $t ?></label>
                    <?php endforeach; ?>
                </div>

                <span class="option-label">Couleur</span>
                <div class="color-group">
                    <?php 
                    $colors = ['Noir' => '#000000', 'Blanc' => '#e0e0e0', 'Rouge' => '#A00', 'Bleu' => '#2a5298'];
                    foreach ($colors as $name => $hex): ?>
                        <input type="radio" name="couleur" value="<?= $name ?>" id="col-<?= $name ?>" class="d-none color-input" required>
                        <label for="col-<?= $name ?>" class="color-swatch" style="background:<?= $hex ?>;"></label>
                    <?php endforeach; ?>
                </div>

                <button class="btn-buy">🛒 Ajouter au panier</button>
            </form>

            <div class="mt-4" style="border-top: 1px solid #E5E0D8; padding-top: 20px; font-size: 12px; color: #888;">
                <p>✓ Expédition sous 24h</p>
                <p>✓ Satisfait ou remboursé sous 30 jours</p>
                <p>✓ Paiement sécurisé SSL</p>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>