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

    protected bool $auth = false;
    protected string $secure = PHPMailer::ENCRYPTION_SMTPS;

    protected string $username;
    protected string $password;
    protected string $subject = 'Logging';

    protected PHPMailer $mailer;

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->mailer = new PHPMailer(true);

        $this->mailer->isSMTP();
        $this->mailer->Host = $this->host;
        $this->mailer->SMTPAuth = $this->auth;
        $this->mailer->Username = $this->username;
        $this->mailer->Password = $this->password;
        $this->mailer->SMTPSecure = $this->secure;
        $this->mailer->Port = $this->port;

        $this->mailer->setFrom($this->email_from, $this->name_from);
        $this->mailer->addAddress($this->email_to, $this->name_recipient);

        $this->mailer->isHTML(false);
        $this->mailer->Subject = $this->subject;

    }

    /**
     * @throws Exception
     */
    public function send(string $message): void
    {
        try {
            $this->mailer->Body = $message;
            $this->mailer->send();
        } catch (Exception $e) {
            throw new Exception("Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}");
        }
    }
}