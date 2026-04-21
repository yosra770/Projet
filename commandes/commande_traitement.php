<?php
require_once("../config/db.php");
require_once("../includes/session.php");

requireLogin();

$db = new \Connexion();
$conn = $db->CNXbase();

$user_id = $_SESSION['user']['id'];

// créer commande
$stmt = $conn->prepare("INSERT INTO commandes (user_id) VALUES (?)");
$stmt->execute([$user_id]);

$commande_id = $conn->lastInsertId();

// ajouter produits
foreach ($_POST['produits'] as $produit_id => $qte) {

    $stmt = $conn->prepare("INSERT INTO commande_details (commande_id, produit_id, quantite) VALUES (?, ?, ?)");
    $stmt->execute([$commande_id, $produit_id, $qte]);
}

echo "Commande enregistrée avec succès";
?>