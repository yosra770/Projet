<?php
require_once("../config/db.php");

$conn = (new Connexion())->CNXbase();
$query = $_GET['q'] ?? '';

$stmt = $conn->prepare("
    SELECT * FROM produits 
    WHERE nom LIKE ? 
       OR description LIKE ?
       OR categorie LIKE ?
       OR style LIKE ?
");

$search = "%$query%";
$stmt->execute([$search, $search, $search, $search]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../includes/header.php"); ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:wght@300;400;600&display=swap');

    body { background-color: #F8F7F4; font-family: 'Inter', sans-serif; color: #1A1A1A; }
    
    .search-header { margin-top: 150px; margin-bottom: 60px; text-align: center; }
    .search-header span { text-transform: uppercase; letter-spacing: 2px; font-size: 12px; color: #888; }
    .search-header h2 { font-family: 'Playfair Display', serif; font-size: 42px; margin-top: 10px; }
    .query-text { font-style: italic; color: #555; }

    /* Grille de résultats */
    .results-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
        gap: 30px; 
        margin-bottom: 100px; 
    }

    .product-item { 
        background: #fff; 
        border: 1px solid #E5E0D8; 
        padding: 20px; 
        transition: all 0.4s ease;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .product-item:hover { 
        border-color: #1A1A1A;
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .img-container {
        background: #F9F9F9;
        margin-bottom: 20px;
        overflow: hidden;
        height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .img-container img {
        max-width: 100%;
        height: auto;
        mix-blend-mode: multiply; /* Idéal si vos images ont un fond blanc */
    }

    .product-meta { text-align: center; }
    .product-category { 
        font-size: 10px; 
        text-transform: uppercase; 
        letter-spacing: 1.5px; 
        color: #aaa; 
        margin-bottom: 8px; 
        display: block;
    }

    .product-name { 
        font-family: 'Playfair Display', serif; 
        font-size: 18px; 
        margin-bottom: 10px; 
        font-weight: 700;
    }

    .product-price { 
        font-weight: 600; 
        font-size: 15px; 
        color: #1A1A1A; 
    }

    .no-results {
        text-align: center;
        padding: 100px 0;
    }
    .no-results h3 { font-family: 'Playfair Display', serif; margin-bottom: 20px; }
</style>

<div class="container">
    <div class="search-header">
        <span>Résultats de recherche</span>
        <h2>“<span class="query-text"><?= htmlspecialchars($query) ?></span>”</h2>
        <p class="mt-3 text-muted"><?= count($results) ?> article(s) trouvé(s)</p>
    </div>

    <?php if (empty($results)): ?>
        <div class="no-results">
            <h3>Aucun trésor trouvé</h3>
            <p>Nous n'avons pas trouvé de correspondance pour votre recherche. <br>Essayez avec d'autres mots-clés ou explorez nos nouveautés.</p>
            <a href="liste.php" class="btn btn-dark mt-4 px-5 py-3 rounded-0">Voir toute la collection</a>
        </div>
    <?php else: ?>

    <div class="results-grid">
        <?php foreach ($results as $p): ?>
            <a href="detail.php?id=<?= $p['id'] ?>" class="product-item">
                <div class="img-container">
                    <!-- Assurez-vous que le chemin vers vos images est correct -->
                    <img src="../assets/images/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['nom']) ?>">
                </div>
                
                <div class="product-meta">
                    <span class="product-category"><?= htmlspecialchars($p['categorie']) ?> — <?= htmlspecialchars($p['style']) ?></span>
                    <div class="product-name"><?= htmlspecialchars($p['nom']) ?></div>
                    <div class="product-price"><?= number_format($p['prix'], 0) ?> DT</div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <?php endif; ?>
</div>

<?php include("../includes/footer.php"); ?>