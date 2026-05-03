<?php
session_start();
require_once("../config/db.php");

if (!isset($_SESSION['user']['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$conn = (new Connexion())->CNXbase();

$user_id = $_SESSION['user']['id'];
$new_email = trim($_POST['email']);
$password = $_POST['password'];

// récupérer user
$stmt = $conn->prepare("SELECT * FROM utilisateur WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// vérifier mot de passe
if (!password_verify($password, $user['password'])) {
    $_SESSION['error'] = "❌ Incorrect password";
    header("Location: edit_profile.php");
    exit;
}

// vérifier si email existe déjà
$stmt = $conn->prepare("SELECT id FROM utilisateur WHERE email = ? AND id != ?");
$stmt->execute([$new_email, $user_id]);

if ($stmt->fetch()) {
    $_SESSION['error'] = "❌ Email already used";
    header("Location: edit_profile.php");
    exit;
}

// update email
$stmt = $conn->prepare("UPDATE utilisateur SET email = ? WHERE id = ?");
$stmt->execute([$new_email, $user_id]);

// update session
$_SESSION['user']['email'] = $new_email;

$_SESSION['success'] = "✅ Email updated successfully";
header("Location: edit_profile.php");
exit;