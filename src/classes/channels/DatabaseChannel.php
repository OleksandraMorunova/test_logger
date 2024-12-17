<?php

namespace Om\TestLogger;

use Exception;
use Om\TestLogger\ChannelAbstract;
use PDO;

class DatabaseChannel extends ChannelAbstract
{
    protected \PDO $pdo;
    protected string $dsn;
    protected ?string $username = null;
    protected ?string $password = null;

    protected string $sql;
    protected string $binding = ':log_message';

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->pdo = new PDO(dsn: $this->dsn, username: $this->username, password: $this->password);
    }

    /**
     * @throws Exception
     */
    public function send(string $message): void
    {
        $stmt = $this->pdo->prepare($this->sql);

        try {
            $this->pdo->beginTransaction();
            $stmt->execute([$this->binding => $message]);

            $this->pdo->commit();
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollback();
            }

            throw new Exception("Database error: " . $e->getMessage(), 0, $e);
        }
    }
}