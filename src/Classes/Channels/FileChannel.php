<?php

namespace Om\TestLogger\Classes\Channels;

use Om\TestLogger\Classes\ChannelAbstract;

class FileChannel extends ChannelAbstract
{
    protected string $file_to;
    protected $resource;

    public function __construct(array $config)
    {
        parent::__construct($config);

        $dir = pathinfo($config['file_to'], PATHINFO_DIRNAME);
        if(!is_dir($dir)) {
            mkdir($dir);
        }

        $this->resource = fopen($this->file_to, 'a+');
    }

    public function __destruct()
    {
        fclose($this->resource);
    }

    public function send(string $message): void
    {
        fwrite($this->resource, $message . PHP_EOL);
    }
}