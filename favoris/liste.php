<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
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

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:wght@300;400;600&display=swap');

    body { background-color: #F8F7F4; font-family: 'Inter', sans-serif; color: #1A1A1A; }
    
    .wishlist-header { margin-top: 150px; margin-bottom: 60px; text-align: center; }
    .wishlist-header h2 { font-family: 'Playfair Display', serif; font-size: 42px; margin-bottom: 10px; }
    .wishlist-header p { color: #888; font-size: 14px; letter-spacing: 1px; text-transform: uppercase; }

    /* Grille de produits */
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 40px; margin-bottom: 100px; }
    
    .wish-card { background: transparent; border: none; transition: 0.4s; position: relative; }
    
    .image-wrapper { 
        background: #fff; 
        padding: 30px; 
        position: relative; 
        overflow: hidden; 
        border: 1px solid #E5E0D8; 
    }
    
    .wish-card img { width: 100%; height: auto; transition: 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
    .wish-card:hover img { transform: scale(1.08); }

    .wish-info { padding-top: 20px; text-align: center; }
    .wish-info h5 { font-family: 'Inter', sans-serif; font-weight: 600; font-size: 16px; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px; }
    .wish-info p { font-family: 'Playfair Display', serif; font-style: italic; color: #1A1A1A; font-size: 18px; }

    /* Boutons Hover */
    .wish-overlay { 
        position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
        background: rgba(255,255,255,0.8); display: flex; flex-direction: column; 
        align-items: center; justify-content: center; opacity: 0; transition: 0.3s;
    }
    .wish-card:hover .wish-overlay { opacity: 1; }

    .btn-wish { 
        width: 180px; padding: 12px; margin: 5px; font-size: 11px; 
        text-transform: uppercase; letter-spacing: 1.5px; border: none; 
        transition: 0.3s; text-decoration: none; text-align: center;
    }
    .btn-view { background: #1A1A1A; color: #fff; }
    .btn-remove { background: transparent; color: #a00; border: 1px solid #a00; }
    .btn-remove:hover { background: #a00; color: #fff; }

    /* Vide */
    .empty-state { padding: 100px 0; text-align: center; }
    .empty-state h3 { font-family: 'Playfair Display', serif; font-size: 32px; margin-bottom: 20px; }
    .btn-shop { background: #1A1A1A; color: #fff; padding: 15px 40px; text-decoration: none; display: inline-block; letter-spacing: 2px; font-size: 12px; }
</style>

<div class="container">
    <div class="wishlist-header">
        <h2>My Wishlist</h2>
        <p>Your favorite pieces carefully preserved</p>
        <div style="width: 40px; height: 1px; background: #1A1A1A; margin: 20px auto;"></div>
    </div>

    <?php if (empty($produits)): ?>
        <div class="empty-state">
            <h3>Your wishlist is still empty.</h3>
            <p class="text-muted mb-4">Let us tempt you with our latest collections of sneakers.</p>
            <a href="../produits/liste.php" class="btn-shop text-uppercase">Explore the shop</a>
        </div>
    <?php else: ?>
        <div class="product-grid">
            <?php foreach ($produits as $p): ?>
                <div class="wish-card">
                    <div class="image-wrapper">
                        <img src="../assets/images/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['nom']) ?>">
                        <div class="wish-overlay">
                            <a href="../produits/detail.php?id=<?= $p['id'] ?>" class="btn-wish btn-view">View Product</a>
                            <a href="../favoris/toggle.php?id=<?= $p['id'] ?>" class="btn-wish btn-remove">Remove</a>
                        </div>
                    </div>
                    <div class="wish-info">
                        <h5><?= htmlspecialchars($p['nom']) ?></h5>
                        <p><?= number_format($p['prix'], 0) ?> DT</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include("../includes/footer.php"); ?>