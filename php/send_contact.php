<?php

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$ip_file = __DIR__ . '/../ip_block.txt';
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$now = time();
$block_duration = 120; // 2 minutes

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');
    $honeypot = $_POST['website'] ?? '';

    if (!empty($honeypot)) {
        echo 'Spam détecté.';
        exit;
    }

    if (file_exists($ip_file)) {
        $lines = file($ip_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            list($logged_ip, $timestamp) = explode('|', $line);
            if ($logged_ip === $ip && ($now - (int)$timestamp) < $block_duration) {
                echo 'Veuillez attendre 2 minutes entre chaque envoi.';
                exit;
            }
        }
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Adresse email invalide.';
        exit;
    }

    $forbidden = ['http://', 'https://', 'viagra', 'casino', 'bitcoin'];
    foreach ($forbidden as $word) {
        if (stripos($message, $word) !== false) {
            echo 'Message non autorisé.';
            exit;
        }
    }

    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 0;
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'contact.catherine.messier.inc@gmail.com';
        $mail->Password = 'qxyskttnndwsogmq';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('contact.catherine.messier.inc@gmail.com', 'Site Internet Catherine MESSIER Designer & Finition INC.');
        $mail->addAddress('catherine_messier@hotmail.com'); # Remplacez par l'adresse email Cible
        $mail->Subject = 'Nouveau message du site web Catherine MESSIER Designer & Finition INC.';
        $mail->Body = "Nom: $name\nEmail: $email\nMessage:\n$message";

        $mail->send();
        file_put_contents($ip_file, "$ip|$now\n", FILE_APPEND | LOCK_EX);
        echo 'Votre message a été envoyé avec succès.';
    } catch (Exception $e) {
        echo 'Une erreur est survenue lors de l\'envoi du message.';
    }
} else {
    echo 'Méthode non autorisée.';
}
?>
