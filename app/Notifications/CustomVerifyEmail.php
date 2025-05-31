<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CustomVerifyEmail extends VerifyEmailBase
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        $sent = $this->sendPHPMailer($notifiable, $verificationUrl);

        if ($sent) {
            return (new MailMessage)
                ->subject('Verification Email Sent')
                ->line('A verification email has been sent.');
        }

        return (new MailMessage)
            ->line('Failed to send verification email.');
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(config('auth.verification.expire', 60)),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );
    }

    protected function sendPHPMailer($user, $url)
    {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gujarat.gov.in';
            $mail->SMTPAuth = false;
            $mail->Port = 25;
            $mail->SMTPAutoTLS = false;
            $mail->SMTPSecure = false;

            $mail->setFrom('noreply-govtawasallot@gujarat.gov.in', 'Govt Allotment Portal');
            $mail->addAddress($user->email, $user->name);

            $mail->isHTML(true);
            $mail->Subject = 'Verify Your Email Address';
            $mail->Body = "
                <p>Dear {$user->name},</p>
                <p>Please verify your email by clicking the link below:</p>
                <p><a href=\"$url\">Verify Email</a></p>";

            $mail->AltBody = "Verify your email by visiting this link: $url";

            $mail->send();

            return true;
        } catch (Exception $e) {
            \Log::error('PHPMailer error: ' . $mail->ErrorInfo);
            return false;
        }
    }
}
