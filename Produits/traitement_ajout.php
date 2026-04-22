<?php
require_once("../config/db.php");

$conn = (new Connexion())->CNXbase();

$nom = $_POST['nom'];
$desc = $_POST['description'];
$prix = $_POST['prix'];

$image = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

move_uploaded_file($tmp, "../uploads/".$image);

$stmt = $conn->prepare("INSERT INTO produits (nom, description, prix, image)
VALUES (:nom, :description, :prix, :image)");

$stmt->execute([
    'nom' => $nom,
    'description' => $desc,
    'prix' => $prix,
    'image' => $image
]);

header("Location: liste.php");
?>