<?php
require_once("../config/db.php");
require_once("../includes/session.php");

requireAdmin();

$db = new \Connexion();
$conn = $db->CNXbase();


// 🔹 AJOUTER PRODUIT
if (isset($_POST['action']) && $_POST['action'] == "ajouter") {

    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $description = $_POST['description'];

    // IMAGE
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $image);

    $stmt = $conn->prepare("INSERT INTO produits (nom, description, prix, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $description, $prix, $image]);

    header("Location: liste.php");
}


// 🔹 MODIFIER PRODUIT
if (isset($_POST['action']) && $_POST['action'] == "modifier") {

    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE produits SET nom=?, description=?, prix=? WHERE id=?");
    $stmt->execute([$nom, $description, $prix, $id]);

    header("Location: liste.php");
}


// 🔹 SUPPRIMER PRODUIT
if (isset($_GET['id'])) {

    $stmt = $conn->prepare("DELETE FROM produits WHERE id=?");
    $stmt->execute([$_GET['id']]);

    header("Location: liste.php");
}
?>