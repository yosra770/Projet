<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once("../config/db.php");

if (!isset($_SESSION['user']['id'])) { header("Location: ../auth/login.php"); exit; }

$connexion = new Connexion();
$conn = $connexion->CNXbase();

$user_id = $_SESSION['user']['id'];

$stmt = $conn->prepare("SELECT * FROM utilisateur WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM commandes WHERE user_id = ? ORDER BY date_commande DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalOrders = count($orders);
$totalSpent = array_sum(array_column($orders, 'total'));
?>

<?php include("../includes/header.php"); ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;600&display=swap');

    body { background-color: #F8F7F4; font-family: 'Inter', sans-serif; }
    h2, h4 { font-family: 'Playfair Display', serif; }

    .dashboard-container { margin-top: 100px; margin-bottom: 100px; }
    .panel { background: #fff; padding: 40px; border: 1px solid #E5E0D8; height: 100%; }

    /* Avatar */
    .avatar { width: 80px; height: 80px; background: #1A1A1A; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; border-radius: 50%; margin-bottom: 20px; }

    /* Stats */
    .stat-box { text-align: center; padding: 20px 0; border: 1px solid #F0ECE4; }
    .stat-val { font-size: 24px; font-weight: 700; display: block; }
    .stat-label { font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #888; }

    /* Liens Action */
    .action-link { display: block; padding: 15px 0; border-bottom: 1px solid #F0ECE4; text-decoration: none; color: #1A1A1A; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; transition: 0.3s; }
    .action-link:hover { color: #555; padding-left: 10px; }

    /* Liste Commandes */
    .order-row { display: flex; align-items: center; padding: 25px 0; border-bottom: 1px solid #E5E0D8; }
    .order-info { flex: 1; }
    .order-date { font-size: 12px; color: #888; }
    .order-price { font-weight: 600; font-size: 16px; }
    .btn-action { font-size: 11px; padding: 8px 15px; border: 1px solid #1A1A1A; color: #1A1A1A; text-decoration: none; margin-left: 10px; text-transform: uppercase; }
    .btn-action:hover { background: #1A1A1A; color: #fff; }
</style>

<div class="container dashboard-container">
    <div class="row">
        <div class="col-lg-4">
            <div class="panel">
                <div class="avatar"><?= strtoupper(substr($user['nom'], 0, 1)) ?></div>
                <h4><?= htmlspecialchars($user['nom']) ?></h4>
                <p style="color:#666; font-size: 14px;"><?= htmlspecialchars($user['email']) ?></p>
                
                <div class="row mt-4 mb-4">
                    <div class="col-6 stat-box">
                        <span class="stat-val"><?= $totalOrders ?></span>
                        <span class="stat-label">Commandes</span>
                    </div>
                    <div class="col-6 stat-box">
                        <span class="stat-val"><?= number_format($totalSpent, 0) ?></span>
                        <span class="stat-label">DT Dépensés</span>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="edit_profile.php" class="action-link">Modifier profil</a>
                    <a href="change_password.php" class="action-link">Changer mot de passe</a>
                    <a href="../auth/logout.php" class="action-link" style="color: #a00;">Déconnexion</a>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="panel">
                <h4 class="mb-4">Historique des commandes</h4>
                
                <?php if (empty($orders)): ?>
                    <p style="color:#888;">Aucune commande pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="order-row">
                            <div class="order-info">
                                <div><b>#<?= $order['id'] ?></b></div>
                                <div class="order-date"><?= date('d M Y', strtotime($order['date_commande'])) ?></div>
                            </div>
                            <div class="order-price text-end">
                                <?= number_format($order['total'], 2) ?> DT
                            </div>
                            <div class="text-end">
                                <a href="order_details.php?id=<?= $order['id'] ?>" class="btn-action">Détails</a>
                                <a href="invoice.php?id=<?= $order['id'] ?>" class="btn-action">Facture</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>