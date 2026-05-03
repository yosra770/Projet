<?php
session_start();
require_once("../config/db.php");

$conn = (new Connexion())->CNXbase();

$email = trim($_POST['email']);

/* 1. check email */
$stmt = $conn->prepare("SELECT * FROM utilisateur WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['error'] = "❌ Email introuvable";
    header("Location: forgot_password.php");
    exit();
}

/* 2. generate token */
$token = bin2hex(random_bytes(32));

$stmt = $conn->prepare("UPDATE utilisateur SET reset_token=? WHERE id=?");
$stmt->execute([$token, $user['id']]);

/* 3. reset link */
$link = "http://localhost/web2/projet/auth/reset_password.php?token=$token";

/* 4. PHPMailer */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'yousraderbel30600@gmail.com';
    $mail->Password = 'uubbemgtrymjvzba';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('yousraderbel30600@gmail.com', 'Maison NYA');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Reset Password';

    $mail->Body = "
        <h3>Reset your password</h3>
        <p>Click below:</p>

        <a href='$link'
           style='display:inline-block;padding:12px 20px;background:black;color:white;text-decoration:none;border-radius:6px;'>
           Reset Password
        </a>
    ";

    $mail->send();

    $_SESSION['success'] = "📧 Email envoyé ! Vérifie ta boîte.";

} catch (Exception $e) {
    $_SESSION['error'] = "❌ Erreur email: " . $mail->ErrorInfo;
}

header("Location: forgot_password.php");
exit();