<?php
session_start();
require_once("../config/db.php");

$connexion = new Connexion();
$conn = $connexion->CNXbase();

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $conn->prepare($sql);
$stmt->execute(['email' => $email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user){
    if(password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        header("Location: ../index.php");
    } else {
        echo "Mot de passe incorrect";
    }
} else {
    echo "Utilisateur introuvable";
}
?>