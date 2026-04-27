<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once("../config/db.php");
$connexion = new Connexion();
$conn = $connexion->CNXbase();
$panier = $_SESSION['panier'] ?? [];
$user = $_SESSION['user'] ?? null;
$total = 0;
$cart_details = []; 

// Calcul panier
if (!empty($panier)) {
    foreach ($panier as $index => $item) {
        if (!isset($item['id'])) continue;
        $stmt = $conn->prepare("SELECT * FROM produits WHERE id = ?");
        $stmt->execute([(int)$item['id']]);
        $produit = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$produit) continue;
        $qty = $item['qty'] ?? 1;
        if ($qty > $produit['stock']) { $qty = $produit['stock']; $_SESSION['panier'][$index]['qty'] = $qty; }
        $subtotal = $produit['prix'] * $qty;
        $total += $subtotal;
        $cart_details[] = ['index' => $index, 'item' => $item, 'produit' => $produit, 'qty' => $qty, 'subtotal' => $subtotal];
    }
}

// Simulation produits recommandés
$recos = $conn->query("SELECT * FROM produits LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);

function formatPrice($price) { return number_format($price, 2, ',', ' ') . ' DT'; }
?>

<?php include("../includes/header.php"); ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:wght@300;400;600&display=swap');
    
    body { background-color: #F8F7F4; color: #1A1A1A; font-family: 'Inter', sans-serif; }
    h1, h4 { font-family: 'Playfair Display', serif; }

    /* Cartes & Containers */
    .elegant-card { background: #FFFFFF; border: 1px solid #E5E0D8; padding: 40px; }
    
    .item-card {
        display: flex; gap: 24px; padding: 24px 0; border-bottom: 1px solid #E5E0D8;
    }
    
    /* Boutons */
    .btn-qty { width: 35px; height: 35px; border: 1px solid #C5C0B8; display: flex; align-items: center; justify-content: center; text-decoration: none; color: #1A1A1A; transition: 0.3s; }
    .btn-qty:hover { background: #1A1A1A; color: #FFFFFF; }

    .btn-checkout { background: #1A1A1A; color: #FFFFFF; padding: 20px; text-align: center; display: block; text-decoration: none; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; transition: 0.3s; }
    .btn-checkout:hover { background: #333; letter-spacing: 4px; }

    /* Cross-sell */
    .reco-card { background: #fff; border: 1px solid #E5E0D8; padding: 15px; transition: 0.3s; }
    .reco-card:hover { border-color: #1A1A1A; }
</style>

<div class="container py-5" style="max-width: 1100px; margin-top: 50px;">
    
    <?php if (empty($cart_details)): ?>
        <div class="elegant-card text-center py-5">
            <h2 style="font-family: 'Playfair Display'; margin-bottom: 20px;">Votre panier est vide</h2>
            <a href="../index.php" style="color: #1A1A1A; text-decoration: underline;">Découvrir la collection</a>
        </div>
    <?php else: ?>

    <h1 style="font-size: 48px; margin-bottom: 50px;">Votre Panier</h1>

    <div class="row g-5">
        <div class="col-lg-8">
            <div class="elegant-card">
                <?php foreach ($cart_details as $data): ?>
                <div class="item-card">
                    <img src="<?= $data['produit']['image'] ?>" style="width:120px; height:150px; object-fit:cover;">
                    <div style="flex:1;">
                        <h5 style="font-weight:600; margin-bottom: 5px;"><?= htmlspecialchars($data['produit']['nom']) ?></h5>
                        <p style="font-size:13px; color:#888; margin-bottom:15px;"><?= $data['item']['taille'] ?> • <?= $data['item']['couleur'] ?></p>
                        <div class="d-flex align-items-center gap-3">
                            <a href="update_qty.php?index=<?= $data['index'] ?>&action=minus" class="btn-qty">-</a>
                            <span style="font-weight:600;"><?= $data['qty'] ?></span>
                            <a href="update_qty.php?index=<?= $data['index'] ?>&action=plus" class="btn-qty">+</a>
                        </div>
                    </div>
                    <div class="text-end">
                        <div style="font-weight:600; margin-bottom:10px;"><?= formatPrice($data['subtotal']) ?></div>
                        <a href="delete.php?index=<?= $data['index'] ?>" style="color:#A00; font-size:11px; text-decoration:underline;">Supprimer</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-5">
                <h4 style="margin-bottom: 20px;">Complétez votre look</h4>
                <div class="row g-3">
                    <?php foreach ($recos as $r): ?>
                    <div class="col-4">
                        <div class="reco-card">
                            <img src="<?= $r['image'] ?>" style="width:100%; height:150px; object-fit:cover; margin-bottom:10px;">
                            <h6 style="font-size:14px;"><?= $r['nom'] ?></h6>
                            <p style="font-size:12px; color:#888;"><?= formatPrice($r['prix']) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="elegant-card" style="position:sticky; top:100px;">
                <h4 style="margin-bottom:25px; font-size: 22px;">Résumé</h4>
                
                <div class="d-flex justify-content-between mb-3 text-muted">
                    <span>Sous-total</span>
                    <span><?= formatPrice($total) ?></span>
                </div>
                <div class="d-flex justify-content-between mb-4 text-muted">
                    <span>Livraison</span>
                    <span style="color:#1A1A1A; font-weight:600;">Gratuit</span>
                </div>

                <div style="border-top:1px solid #E5E0D8; padding: 25px 0; margin-bottom:10px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span style="font-weight:600; font-size: 1.2rem;">Total</span>
                        <span style="font-size:28px; font-weight:700;"><?= formatPrice($total) ?></span>
                    </div>
                </div>

                <?php if ($user): ?>
                    <a href="../Produits/checkout.php" class="btn-checkout">Valider la commande</a>
                <?php else: ?>
                    
                    <button onclick="showAuthMessage()" class="btn-checkout w-100 border-0">Payer maintenant</button>
                <?php endif; ?>

                <div class="mt-4" style="font-size: 12px; color: #888; line-height: 2;">
                    <p>✓ Paiement crypté SSL</p>
                    <p>✓ Retours gratuits sous 30 jours</p>
                    <p>✓ Livraison suivie par Aramex</p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
function showAuthMessage() { 
    alert("Veuillez vous connecter pour finaliser votre commande."); 
    window.location.href = "../auth/login.php"; 
}
</script>

<?php include("../includes/footer.php"); ?>