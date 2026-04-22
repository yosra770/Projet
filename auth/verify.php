<?php
session_start();
require_once("../config/db.php");

$connexion = new Connexion();
$conn = $connexion->CNXbase();

$token = $_GET['token'] ?? null;

if (!$token) {
    die("Token manquant");
}

// chercher user dans pending_users
$stmt = $conn->prepare("SELECT * FROM pending_users WHERE token = ?");
$stmt->execute([$token]);

$user = $stmt->fetch();

if ($user) {

    // créer utilisateur final
    $insert = $conn->prepare("
        INSERT INTO utilisateur
        (nom, prenom, email, password, sexe, date_naissance, role, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, 1)
    ");

    $insert->execute([
        $user['nom'],
        $user['prenom'],
        $user['email'],
        $user['password'],
        $user['sexe'],
        $user['date_naissance'],
        $user['role']
    ]);

    // supprimer pending
    $delete = $conn->prepare("DELETE FROM pending_users WHERE id = ?");
    $delete->execute([$user['id']]);

    // 🔥 AUTO LOGIN (SESSION)
    $_SESSION['user'] = [
        'nom' => $user['nom'],
        'prenom' => $user['prenom'],
        'email' => $user['email'],
        'role' => $user['role']
    ];

    // message + redirection
    header("Location: ../index.php");
    exit();

} else {
    echo "❌ Lien invalide ou expiré";
}
?>