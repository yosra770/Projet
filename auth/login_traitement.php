<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../config/db.php");

$connexion = new Connexion();
$conn = $connexion->CNXbase();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['error'] = "❌ Email introuvable";
        header("Location: login.php");
        exit();
    }

    if ($user['status'] == 0) {
        $_SESSION['error'] = "❌ Compte non activé";
        header("Location: login.php");
        exit();
    }

    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = "❌ Mot de passe incorrect";
        header("Location: login.php");
        exit();
    }

    $_SESSION['user'] = [
        'id' => $user['id'],
        'nom' => $user['nom'],
        'prenom' => $user['prenom'],
        'email' => $user['email'],
        'role' => $user['role']
    ];

    if ($user['role'] === 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../index.php");
    }

    exit();
}
?>