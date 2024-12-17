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
    protected string $name_from = 'From Name';
    protected string $name_recipient = 'Recipient Name';

    protected string $host;
    protected string $port;
    protected string $secure = PHPMailer::ENCRYPTION_SMTPS;

    protected string $username;
    protected string $password;
    protected string $subject = 'Logging';

    public function send(string $message): void
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $this->host;
            $mail->SMTPAuth = true;
            $mail->Username = $this->username;
            $mail->Password = $this->password;
            $mail->SMTPSecure = $this->secure;
            $mail->Port = $this->port;

            $mail->setFrom($this->email_from, $this->name_from);
            $mail->addAddress($this->email_to, $this->name_recipient);

            $mail->isHTML(false);
            $mail->Subject = $this->subject;
            $mail->Body = $message;
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}