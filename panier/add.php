<?php
session_start();
require_once("../config/db.php");

$connexion = new Connexion();
$conn = $connexion->CNXbase();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int)($_POST['id'] ?? 0);
    $taille = trim($_POST['taille'] ?? '');
    $couleur = trim($_POST['couleur'] ?? '');

    if ($id <= 0 || $taille === '' || $couleur === '') {
        die("Données invalides");
    }

    // 🔥 1. récupérer stock réel en DB
    $stmt = $conn->prepare("
        SELECT stock 
        FROM produit_variantes 
        WHERE produit_id = ? 
        AND taille = ? 
        AND couleur = ?
        LIMIT 1
    ");

    $stmt->execute([$id, $taille, $couleur]);
    $variant = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$variant) {
        die("Combinaison inexistante");
    }

    $stock_dispo = (int)$variant['stock'];

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    $current_qty = 0;

    foreach ($_SESSION['panier'] as $item) {
        if ($item['id'] == $id &&
            $item['taille'] == $taille &&
            $item['couleur'] == $couleur) {
            $current_qty = $item['qty'];
            break;
        }
    }

    // 🔥 2. BLOQUER SI STOCK DEPASSE
    if ($current_qty + 1 > $stock_dispo) {

    $_SESSION['error'] = "❌ Stock insuffisant pour cette taille et couleur";

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

    // 🔥 3. ajouter / update panier
    $found = false;

    foreach ($_SESSION['panier'] as &$item) {
        if ($item['id'] == $id &&
            $item['taille'] == $taille &&
            $item['couleur'] == $couleur) {

            $item['qty']++;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['panier'][] = [
            'id' => $id,
            'qty' => 1,
            'taille' => $taille,
            'couleur' => $couleur
        ];
    }

    $_SESSION['cart_count'] = array_sum(array_column($_SESSION['panier'], 'qty'));

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}