<?php
require_once("../config/db.php");

$connexion = new Connexion();
$conn = $connexion->CNXbase();

$nom = $_POST['nom'];
$desc = $_POST['description'];
$prix = $_POST['prix'];

$image = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

move_uploaded_file($tmp, "../uploads/".$image);

$sql = "INSERT INTO produits (nom, description, prix, image)
        VALUES (:nom, :description, :prix, :image)";

$stmt = $conn->prepare($sql);

$stmt->execute([
    'nom' => $nom,
    'description' => $desc,
    'prix' => $prix,
    'image' => $image
]);

header("Location: liste.php");
?>