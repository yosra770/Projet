<?php
session_start();
include("../config/db.php");

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if($result->num_rows == 1){
    $user = $result->fetch_assoc();

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