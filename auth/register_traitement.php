<?php
require_once("../config/db.php");

$connexion = new Connexion();
$conn = $connexion->CNXbase();

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$date = $_POST['date_naissance'];
$sexe = $_POST['sexe'];

// upload image
$photo = $_FILES['photo']['name'];
$tmp = $_FILES['photo']['tmp_name'];
move_uploaded_file($tmp, "../uploads/".$photo);

$sql = "INSERT INTO users (nom, prenom, email, password, sexe, date_naissance, photo)
        VALUES (:nom, :prenom, :email, :password, :sexe, :date, :photo)";

$stmt = $conn->prepare($sql);

$stmt->execute([
    'nom' => $nom,
    'prenom' => $prenom,
    'email' => $email,
    'password' => $password,
    'sexe' => $sexe,
    'date' => $date,
    'photo' => $photo
]);

header("Location: login.php");
?>