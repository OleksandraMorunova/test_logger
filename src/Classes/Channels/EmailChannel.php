<?php

namespace Om\TestLogger\Classes\Channels;

use Exception;
use Om\TestLogger\Classes\ChannelAbstract;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class EmailChannel extends ChannelAbstract
{
    protected string $email_to;
    protected string $email_from;

    protected string $host;
    protected string $post;

    protected string $username;
    protected string $password;
    protected string $subject = 'Logging';

    public function send(string $message): void
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $this->host; // Your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = $this->username; // Your Mailtrap username
            $mail->Password = $this->password; // Your Mailtrap password
            $mail->SMTPSecure = 'tls';
            $mail->Port = $this->post;

            $mail->setFrom($this->email_from, 'From Name');
            $mail->addAddress($this->email_to, 'Recipient Name');

            $mail->isHTML(false);
            $mail->Subject = $this->subject;
            $mail->Body = $message;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}