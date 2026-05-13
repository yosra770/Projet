<?php
session_start();
require_once("../config/db.php");

$connexion = new Connexion();
$conn = $connexion->CNXbase();

$panier = $_SESSION['panier'] ?? [];

if (empty($panier)) {
    die("Panier vide");
}


$total = 0;

/* =========================
   1. CALCUL TOTAL FIABLE
========================= */
foreach ($panier as $item) {

    $stmt = $conn->prepare("SELECT prix FROM produits WHERE id = ?");
    $stmt->execute([$item['id']]);
// ==========================
// CHECK USER
// ==========================
if (!isset($_SESSION['user']['id'])) {
    die("You must be logged in");
}
//recupère l'id de l'utilisateur connecté
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

// Récupère l'ID de la commande créée
$commande_id = $conn->lastInsertId();

//  si lastInsertId bug
if (!$commande_id) {
    //récupère dernier ID de la table commandes
    $commande_id = $conn->query("SELECT MAX(id) FROM commandes")->fetchColumn();
}

// ==========================
// 2. LOOP PANIER
// ==========================
$total = 0;
//parcourt chaque produit panier
foreach ($panier as $item) {
    //skip si ID absent.
    if (!isset($item['id'])) continue;

    $stmt = $conn->prepare("SELECT * FROM produits WHERE id = ?");
    $stmt->execute([(int)$item['id']]);
    //fetch(PDO::FETCH_ASSOC) retourne un tableau associatif du produit ou false si non trouvé

    $p = $stmt->fetch(PDO::FETCH_ASSOC);
    //ignore produit supprimé.
    if (!$p) continue;

    $qty = (int)($item['qty'] ?? 1);

    $total += (float)$p['prix'] * $qty;
}

/* DEBUG (IMPORTANT TEMPORAIRE) */
// echo $total; exit;

/* =========================
   2. INSERT COMMANDE
========================= */
$stmt = $conn->prepare("
INSERT INTO commandes 
(user_id, date_commande, status, total)
VALUES (?, NOW(), 'en attente', ?)
");

$user_id = $_SESSION['user']['id'] ?? 1;

$stmt->execute([$user_id, $total]);

$order_id = $conn->lastInsertId();

/* =========================
   3. INSERT DETAILS
========================= */
foreach ($panier as $item) {

    $stmt = $conn->prepare("SELECT prix FROM produits WHERE id = ?");
    $stmt->execute([$item['id']]);
    $p = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$p) continue;

    $qty = (int)$item['qty'];

    $stmt = $conn->prepare("
        INSERT INTO commande_details 
        (commande_id, produit_id, quantite, prix, taille, couleur)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $order_id,
        $item['id'],
        $qty,
        $p['prix'],
        $item['taille'],
        $item['couleur']
    ]);
}

/* =========================
   4. VIDE PANIER
========================= */
unset($_SESSION['panier']);

/* =========================
   5. REDIRECTION
========================= */
header("Location: success.php?id=" . $order_id);
exit;
?>