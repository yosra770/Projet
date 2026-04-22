<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

function sendMail($to, $name, $subject, $body)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        // 🔥 TON EMAIL GMAIL
        $mail->Username = 'tonemail@gmail.com';

        // 🔥 MOT DE PASSE D’APPLICATION (pas ton mot de passe normal)
        $mail->Password = 'xxxx xxxx xxxx xxxx';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // DESTINATAIRE
        $mail->setFrom('tonemail@gmail.com', 'Projet Shoes');
        $mail->addAddress($to, $name);

        // CONTENU
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}
?>