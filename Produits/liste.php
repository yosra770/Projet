<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once("../config/db.php");
$connexion = new Connexion();
$conn = $connexion->CNXbase();

$categorie = $_GET['cat'] ?? null;
$style = $_GET['style'] ?? null;

// Détermination du titre de la page
$titre = "Notre Collection";
if ($categorie) { $titre = ucfirst($categorie); }

$query = "SELECT * FROM produits";
$params = [];

if ($categorie && $style) {
    $query .= " WHERE categorie = ? AND style = ?";
    $params = [$categorie, $style];
} elseif ($categorie) {
    $query .= " WHERE categorie = ?";
    $params = [$categorie];
}

$stmt = $conn->prepare($query);
$stmt->execute($params);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

$favoris = $_SESSION['favoris'] ?? [];
?>

<?php include("../includes/header.php"); ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:wght@300;400;600&display=swap');

    body { background-color: #F8F7F4; font-family: 'Inter', sans-serif; }
    h2 { font-family: 'Playfair Display', serif; font-size: 40px; margin-bottom: 50px; }

    /* Conteneur Produit */
    .product-card { position: relative; overflow: hidden; margin-bottom: 40px; transition: 0.3s; }
    
    .img-wrapper { overflow: hidden; background: #EEE; }
    .img-wrapper img { width: 100%; height: 400px; object-fit: cover; transition: transform 0.6s ease; }
    .product-card:hover .img-wrapper img { transform: scale(1.05); }

    .card-body { padding: 20px 0; text-align: left; }
    .product-name { font-family: 'Playfair Display', serif; font-size: 18px; margin-bottom: 5px; color: #1A1A1A; }
    .product-price { font-size: 14px; color: #888; letter-spacing: 1px; }

    /* Bouton Fav */
    .btn-fav { position: absolute; top: 15px; right: 15px; z-index: 2; background: rgba(255,255,255,0.8); border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; text-decoration: none; backdrop-filter: blur(5px); }
    .btn-fav:hover { background: #fff; }

    /* Bouton Voir Détail caché au repos */
    .btn-detail { display: inline-block; margin-top: 10px; font-size: 12px; text-transform: uppercase; letter-spacing: 2px; color: #1A1A1A; border-bottom: 1px solid #1A1A1A; text-decoration: none; }
</style>

<div class="container mt-5">

    <h2><?= htmlspecialchars($titre) ?></h2>

    <div class="row">
        <?php foreach ($produits as $p): ?>
            <div class="col-md-4 col-lg-3">
                <div class="product-card">
                    
                    <a href="../favoris/toggle.php?id=<?= $p['id'] ?>" class="btn-fav">
                        <?= isset($favoris[$p['id']]) ? "❤️" : "🤍" ?>
                    </a>

                    <div class="img-wrapper">
                        <a href="detail.php?id=<?= $p['id'] ?>">
                            <img src="../assets/images/<?= $p['image'] ?>" alt="<?= $p['nom'] ?>">
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="product-name"><?= htmlspecialchars($p['nom']) ?></div>
                        <div class="product-price"><?= number_format($p['prix'], 2, ',', ' ') ?> DT</div>
                        <a href="detail.php?id=<?= $p['id'] ?>" class="btn-detail">Show Model</a>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include("../includes/footer.php"); ?>