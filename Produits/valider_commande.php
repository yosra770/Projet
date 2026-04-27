<?php
session_start();

require_once("../config/db.php");

$connexion = new Connexion();
$conn = $connexion->CNXbase();

// 🔥 DEBUG MODE (garde pour tester)
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$panier = $_SESSION['panier'] ?? [];

// ==========================
// CHECK PANIER
// ==========================
if (empty($panier)) {
    die("Cart is empty");
}

// ==========================
// CHECK USER
// ==========================
if (!isset($_SESSION['user']['id'])) {
    die("You must be logged in");
}

$user_id = (int) $_SESSION['user']['id'];

// ==========================
// 1. INSERT ORDER
// ==========================
$stmt = $conn->prepare("
    INSERT INTO commandes
    (user_id, date_commande, status, total)
    VALUES (?, NOW(), 'en attente', 0)
");

$stmt->execute([$user_id]);

// 🔥 FIX ULTRA IMPORTANT
$commande_id = $conn->lastInsertId();

// fallback si lastInsertId bug
if (!$commande_id) {
    $commande_id = $conn->query("SELECT MAX(id) FROM commandes")->fetchColumn();
}

// ==========================
// 2. LOOP PANIER
// ==========================
$total = 0;

foreach ($panier as $item) {

    if (!isset($item['id'])) continue;

    $stmt = $conn->prepare("SELECT * FROM produits WHERE id = ?");
    $stmt->execute([(int)$item['id']]);
    $p = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$p) continue;

    $qty = (int)($item['qty'] ?? 1);

    // STOCK CHECK
    if ($qty > (int)$p['stock']) {
        $qty = (int)$p['stock'];
    }

    if ($qty <= 0) continue;

    $subtotal = $p['prix'] * $qty;
    $total += $subtotal;

    $taille = $item['taille'] ?? '';
    $couleur = $item['couleur'] ?? '';

    // ==========================
    // INSERT DETAILS
    // ==========================
    $stmt = $conn->prepare("
        INSERT INTO commande_details
        (commande_id, produit_id, quantite, prix, subtotal, taille, couleur)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $commande_id,
        $p['id'],
        $qty,
        $p['prix'],
        $subtotal,
        $taille,
        $couleur
    ]);

    // UPDATE STOCK
    $stmt = $conn->prepare("
        UPDATE produits SET stock = stock - ? WHERE id = ?
    ");

    $stmt->execute([$qty, $p['id']]);
}

// ==========================
// 3. UPDATE TOTAL
// ==========================
$stmt = $conn->prepare("
    UPDATE commandes SET total = ? WHERE id = ?
");

$stmt->execute([$total, $commande_id]);

// ==========================
// 4. CLEAR CART
// ==========================
unset($_SESSION['panier']);

// ==========================
// 5. REDIRECT
// ==========================
header("Location: ../Produits/success.php?id=".$commande_id);
exit;
?>
<?php include("../includes/footer.php"); ?>