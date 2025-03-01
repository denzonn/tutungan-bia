<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Pastikan PHPMailer sudah terinstal via Composer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Pastikan semua field terisi
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        die("Harap isi semua bidang!");
    }

    // Konfigurasi PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Konfigurasi SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Gunakan SMTP Gmail
        $mail->SMTPAuth   = true;
        $mail->Username   = 'emailanda@gmail.com'; // Ganti dengan email pengirim
        $mail->Password   = 'passwordemail'; // Ganti dengan password/email app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Pengirim & Penerima
        $mail->setFrom($email, $name);
        $mail->addAddress('denson753@gmail.com', 'Denson');

        // Konten Email
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "<strong>Nama:</strong> $name <br>
                          <strong>Email:</strong> $email <br>
                          <strong>Pesan:</strong><br>$message";

        $mail->send();
        echo "Pesan berhasil dikirim!";
    } catch (Exception $e) {
        echo "Pesan gagal dikirim. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Akses ditolak!";
}
?>
