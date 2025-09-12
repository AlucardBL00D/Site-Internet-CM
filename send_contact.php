
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$ip_file = __DIR__ . '/ip_block.txt';
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$now = time();
$block_duration = 300; // 5 minutes

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');
    $honeypot = $_POST['website'] ?? '';

    // Protection honeypot
    if (!empty($honeypot)) {
        echo 'Spam détecté.';
        exit;
    }

    // Vérifier blocage IP
    if (file_exists($ip_file)) {
        $lines = file($ip_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            list($logged_ip, $timestamp) = explode('|', $line);
            if ($logged_ip === $ip && ($now - (int)$timestamp) < $block_duration) {
                echo 'Veuillez attendre 5 minutes entre chaque envoi.';
                exit;
            }
        }
    }

    // Validation email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Adresse email invalide.';
        exit;
    }

    // Filtrage contenu
    $forbidden = ['http://', 'https://', 'viagra', 'casino', 'bitcoin'];
    foreach ($forbidden as $word) {
        if (stripos($message, $word) !== false) {
            echo 'Message non autorisé.';
            exit;
        }
    }

    // Configuration PHPMailer
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 2; // Affiche les erreurs SMTP détaillées
    $mail->Debugoutput = 'html';
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'contact.catherine.messier.inc@gmail.com'; // <-- à remplacer par ton adresse Gmail
        $mail->Password = 'qxyskttnndwsogmq'; // <-- à remplacer par ton mot de passe d'application Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('contact.catherine.messier.inc@gmail.com', $name); // Utilise ton adresse Gmail ici
        $mail->addAddress('siphafire.archambault.1259@gmail.com'); // Destinataire
        $mail->Subject = 'Nouveau message du site web';
        $mail->Body = "Nom: $name\nEmail: $email\nMessage:\n$message";

        $mail->send();
        file_put_contents($ip_file, "$ip|$now\n", FILE_APPEND | LOCK_EX);
        echo 'Votre message a été envoyé avec succès.';
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi : {$mail->ErrorInfo}";
    }
} else {
    echo 'Méthode non autorisée.';
}
?>
