<?php include("../includes/header.php"); ?>


<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}require_once("../config/db.php");
$connexion = new Connexion();
$conn = $connexion->CNXbase();

$order_id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM commandes WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) { die("Commande introuvable."); }

$stmt = $conn->prepare("SELECT cd.*, p.nom, p.image FROM commande_details cd JOIN produits p ON cd.produit_id = p.id WHERE cd.commande_id = ?");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

function formatPrice($price) { return number_format($price, 2, ',', ' ') . ' DT'; }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commande Confirmée | Votre Maison</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { background-color: #F7F4EF; color: #1A1A1A; font-family: 'Inter', sans-serif; line-height: 1.6; }
        h1, h2, h3, h4 { font-family: 'Playfair Display', serif; }
        
        .success-container { max-width: 700px; margin: 80px auto; background: #fff; padding: 60px; border: 1px solid #E5E0D8; box-shadow: 0 20px 40px rgba(0,0,0,0.05); }
        
        .checkmark-circle { width: 80px; height: 80px; border-radius: 50%; background: #F7F4EF; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
        
        .order-meta { display: flex; justify-content: space-between; border-bottom: 1px solid #E5E0D8; padding-bottom: 20px; margin-bottom: 20px; font-size: 14px; }
        
        .item-row { display: flex; align-items: center; gap: 15px; margin-bottom: 15px; }
        .item-img { width: 60px; height: 60px; object-fit: cover; border: 1px solid #E5E0D8; }
        
        .total-box { background: #F7F4EF; padding: 20px; text-align: right; font-size: 1.2rem; font-weight: 600; margin-top: 30px; }
        
        .btn-black { background: #1A1A1A; color: #fff; padding: 15px 30px; text-decoration: none; display: inline-block; transition: 0.3s; text-transform: uppercase; letter-spacing: 2px; font-size: 12px; }
        .btn-black:hover { background: #333; color: #fff; }
        
        .step-box { border-left: 2px solid #E5E0D8; padding-left: 20px; margin: 30px 0; }
    </style>
</head>
<body>

<div class="container">
    <div class="success-container">
        <div class="checkmark-circle">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>

        <h1 class="text-center">Merci pour votre confiance</h1>
        <p class="text-center" style="color:#666;">Votre commande #<?= $order['id'] ?> a été enregistrée avec succès.</p>

        <div class="order-meta mt-5">
            <div><strong>Date</strong><br><?= date('d M Y', strtotime($order['date_commande'])) ?></div>
            <div><strong>Statut</strong><br><span style="color:#28a745;">Préparation</span></div>
            <div><strong>Total</strong><br><?= formatPrice($order['total']) ?></div>
        </div>

        <div class="step-box">
            <h4 style="font-size: 16px;">Prochaines étapes</h4>
            <p style="font-size: 13px; color:#666;">
                Un conseiller prendra contact avec vous par téléphone sous peu pour confirmer les détails de votre livraison. Vous recevrez également un email récapitulatif.
            </p>
        </div>

        <h4 style="margin-top:30px; font-size: 18px;">Détails de la commande</h4>
        <?php foreach($items as $item): ?>
            <div class="item-row">
                <img src="<?= $item['image'] ?>" class="item-img">
                <div style="flex:1;">
                    <div style="font-weight:600;"><?= $item['nom'] ?></div>
                    <div style="font-size:12px; color:#888;">Quantité: <?= $item['quantite'] ?></div>
                </div>
                <div style="font-weight:600;"><?= formatPrice($item['prix'] * $item['quantite']) ?></div>
            </div>
        <?php endforeach; ?>

        <div class="total-box">
            Total TTC: <?= formatPrice($order['total']) ?>
        </div>

        <div class="text-center mt-5">
            <a href="../index.php" class="btn-black">Retour à la collection</a>
        </div>
    </div>
</div>

</body>
</html>
<?php include("../includes/footer.php"); ?>