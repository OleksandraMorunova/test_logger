<?php

namespace Om\TestLogger;

class Logger implements LoggerInterface
{
    public array $channels = [
        'email' => [
            'class' => EmailChannel::class,
            'email_to' => 'test@test.com'
        ],
        'file' => [
            'class' => FileChannel::class,
            'file_to' => '/var/log/test.log'
        ],
    ];

    /**
     * @var ChannelAbstract[]
     */
    public array $initialize_channels;
    protected string $type;

    public function __construct(array $config)
    {
        foreach ($config as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * @throws \Exception
     */
    public function send(string $message): void
    {
        $class = $this->findLogger($this->type);
        $class->send($message);
    }

    /**
     * @throws \Exception
     */
    public function sendByLogger(string $message, string $loggerType): void
    {
        $class = $this->findLogger($loggerType);
        $class->send($message);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @throws \Exception
     */
    protected function initLogger(string $loggerType): ChannelAbstract
    {
        $loggerConfig = $this->channels[$loggerType] ?? null;

        if (!$loggerConfig) {
            throw new \Exception('Logger configuration not found: ' . $loggerType);
        }

        $className = $loggerConfig['class'] ?? null;

        if (!$className) {
            throw new \Exception('Logger class not found: ' . $loggerType);
        }

        unset($loggerConfig['class']);

        return new $className($loggerConfig);
    }

    /**
     * @throws \Exception
     */
    protected function findLogger(string $loggerType): ChannelAbstract
    {
        $this->initialize_channels[$loggerType] = $this->initialize_channels[$loggerType] ?? $this->initLogger($loggerType);
        return $this->initialize_channels[$loggerType];
    }
}