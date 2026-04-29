<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../config/db.php");

if (!isset($_SESSION['user']['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$connexion = new Connexion();
$conn = $connexion->CNXbase();

$user_id = $_SESSION['user']['id'];

// 🔥 GET USER INFO
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// 🔥 GET ORDERS
$stmt = $conn->prepare("
    SELECT * FROM commandes 
    WHERE user_id = ?
    ORDER BY date_commande DESC
");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../includes/header.php"); ?>

<div class="container" style="margin-top:120px;">

<div class="row g-4">

<!-- LEFT PROFILE -->
<div class="col-lg-4">

<div style="
    background:#fff;
    border-radius:20px;
    padding:25px;
    border:1px solid #eee;
    box-shadow:0 20px 60px rgba(0,0,0,0.05);
">

    <h4 style="font-weight:900;">👤 My Profile</h4>

    <hr>

    <p><b>Name:</b><br><?= htmlspecialchars($user['nom']) ?></p>

    <p><b>Email:</b><br><?= htmlspecialchars($user['email']) ?></p>

    <?php if(!empty($user['tel'])): ?>
    <p><b>Phone:</b><br><?= htmlspecialchars($user['tel']) ?></p>
    <?php endif; ?>

    <a href="../auth/logout.php" class="btn btn-outline-dark w-100 mt-3">
        Logout
    </a>

</div>

</div>

<!-- RIGHT ORDERS -->
<div class="col-lg-8">

<div style="
    background:#fff;
    border-radius:20px;
    padding:25px;
    border:1px solid #eee;
    box-shadow:0 20px 60px rgba(0,0,0,0.05);
">

    <h4 style="font-weight:900;">🛍 My Orders</h4>

    <hr>

    <?php if (empty($orders)): ?>

        <p style="color:#777;">No orders yet.</p>

    <?php else: ?>

        <?php foreach($orders as $order): ?>

        <div style="
            border:1px solid #eee;
            padding:15px;
            border-radius:14px;
            margin-bottom:12px;
        ">

            <div style="display:flex;justify-content:space-between;">

                <div>
                    <b>Order #<?= $order['id'] ?></b><br>
                    <span style="font-size:12px;color:#777;">
                        <?= $order['date_commande'] ?>
                    </span>
                </div>

                <div style="text-align:right;">
                    <b><?= $order['total'] ?> DT</b><br>

                    <?php if ($order['status'] == 'en attente'): ?>
                        <span class="badge bg-warning text-dark">Pending</span>
                    <?php elseif ($order['status'] == 'livré'): ?>
                        <span class="badge bg-success">Delivered</span>
                    <?php else: ?>
                        <span class="badge bg-secondary"><?= $order['status'] ?></span>
                    <?php endif; ?>
                </div>

            </div>

            <div class="mt-2">
                <a href="../Produits/success.php?id=<?= $order['id'] ?>"
                   style="font-size:13px;">
                   View details →
                </a>
            </div>

        </div>

        <?php endforeach; ?>

    <?php endif; ?>

</div>

</div>

</div>

</div>

<?php include("../includes/footer.php"); ?>