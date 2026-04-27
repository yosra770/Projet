<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int)($_POST['id'] ?? 0);
    $taille = trim($_POST['taille'] ?? '');
    $couleur = trim($_POST['couleur'] ?? '');

    if ($id <= 0 || $taille === '' || $couleur === '') {
        die("❌ Données invalides");
    }

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    $found = false;

    // 🔥 si produit existe déjà → +1 qty
    foreach ($_SESSION['panier'] as &$item) {
        if ($item['id'] == $id &&
            $item['taille'] == $taille &&
            $item['couleur'] == $couleur) {

            $item['qty'] = ($item['qty'] ?? 1) + 1;
            $found = true;
            break;
        }
    }

    // 🔥 sinon nouveau produit
    if (!$found) {
        $_SESSION['panier'][] = [
            'id' => $id,
            'qty' => 1,
            'taille' => $taille,
            'couleur' => $couleur
        ];
    }

    // 🔥 compteur global panier
    $_SESSION['cart_count'] = array_sum(array_column($_SESSION['panier'], 'qty'));

   header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
    exit();
}