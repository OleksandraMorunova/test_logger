<?php

namespace Om\TestLogger\Classes\Channels;

use Om\TestLogger\Classes\ChannelAbstract;

class EmailChannel extends ChannelAbstract
{
    protected string $email_to;
    protected string $subject = 'Logging';

    public function send(string $message): void
    {
        mail($this->email_to,$this->subject, $message);
    }
}