<?php
require_once("../config/db.php");

$conn = (new Connexion())->CNXbase();

$token = $_POST['token'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

/* check token */
$stmt = $conn->prepare("SELECT id FROM utilisateur WHERE reset_token = ?");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    die("❌ Token invalid");
}

/* update password */
$stmt = $conn->prepare("
    UPDATE utilisateur
    SET password = ?, reset_token = NULL
    WHERE reset_token = ?
");

$stmt->execute([$password, $token]);

echo "✅ Password updated successfully";