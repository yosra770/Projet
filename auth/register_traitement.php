<?php
session_start();
require_once("../config/db.php");
require_once("../vendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$connexion = new Connexion();
$conn = $connexion->CNXbase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $passwordRaw = $_POST['password'];
    $date = $_POST['date_naissance'];
    $sexe = $_POST['sexe'];

    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email invalide";
    }

    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).{6,}$/", $passwordRaw)) {
        $errors['password'] = "Min 6 caractères avec lettres + chiffres";
    }

    $check = $conn->prepare("SELECT id FROM utilisateur WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        $errors['email'] = "Email déjà utilisé";
    }

    $minDate = date('Y-m-d', strtotime('-5 years'));
    $today = date('Y-m-d');

    if ($date > $today) {
        $errors['date_naissance'] = "Date invalide";
    }

    if ($date > $minDate) {
        $errors['date_naissance'] = "Tu dois avoir au moins 5 ans";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;
        header("Location: register_form.php");
        exit();
    }

    $password = password_hash($passwordRaw, PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(50));

    $stmt = $conn->prepare("
        INSERT INTO pending_users
        (nom, prenom, email, password, sexe, date_naissance, role, token)
        VALUES
        (:nom, :prenom, :email, :password, :sexe, :date, :role, :token)
    ");

    $stmt->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'password' => $password,
        'sexe' => $sexe,
        'date' => $date,
        'role' => 'user',
        'token' => $token
    ]);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->Username = 'yousraderbel30600@gmail.com';
        $mail->Password = 'uubbemgtrymjvzba';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('yousraderbel30600@gmail.com', 'Shoes Store');
        $mail->addAddress($email, $prenom . " " . $nom);

        $link = "http://localhost/web2/projet/auth/verify.php?token=$token";

        $mail->isHTML(true);
        $mail->Subject = "Activation de ton compte";

        $mail->Body = "
            <h2>Bonjour $prenom</h2>
            <p>Clique ici pour activer ton compte :</p>
            <a href='$link' style='padding:10px;background:orange;color:white;text-decoration:none;border-radius:5px;'>
                Activer mon compte
            </a>
        ";

        $mail->send();

    } catch (Exception $e) {
        die("Erreur email : " . $mail->ErrorInfo);
    }

    $_SESSION['success'] = "Un email de confirmation a été envoyé, vérifie votre email s'il vous plaît.";

    header("Location: register_form.php");
    exit();
}
?>