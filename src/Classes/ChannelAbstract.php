<?php

namespace Om\TestLogger\Classes;

abstract class ChannelAbstract
{
    public function __construct(array $config)
    {
        foreach ($config as $name => $value) {
            $this->$name = $value;
        }
    }
    public abstract function send(string $message): void;
}