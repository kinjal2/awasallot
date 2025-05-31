<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!function_exists('sendPHPMailerVerification')) {
    function sendPHPMailerVerification($user, $token)
    {
        require_once base_path('vendor/phpmailer/phpmailer/src/Exception.php');
        require_once base_path('vendor/phpmailer/phpmailer/src/PHPMailer.php');
        require_once base_path('vendor/phpmailer/phpmailer/src/SMTP.php');

        $mail = new PHPMailer(true);

        try {
            $verificationUrl = url('/verify-email/' . $token);

            $mail->isSMTP();
            $mail->Host = 'smtp.gujarat.gov.in';
            $mail->SMTPAuth = false;
            $mail->Port = 25;
            $mail->SMTPAutoTLS = false;
            $mail->SMTPSecure = false;

            $mail->setFrom('noreply-govtawasallot@gujarat.gov.in', 'Govt Allotment Portal');
            $mail->addAddress($user->email, $user->name);
            $mail->isHTML(true);
            $mail->Subject = 'Verify your email address';

            $mail->Body = "
                <html>
                <body>
                    <p>Dear {$user->name},</p>
                    <p>Click the link below to verify your email:</p>
                    <p><a href=\"$verificationUrl\">$verificationUrl</a></p>
                </body>
                </html>";
            $mail->AltBody = "Verify your email: $verificationUrl";

            $mail->send();
            return true;
        } catch (Exception $e) {
            \Log::error("PHPMailer Error: " . $mail->ErrorInfo);
            return false;
        }
    }
}
