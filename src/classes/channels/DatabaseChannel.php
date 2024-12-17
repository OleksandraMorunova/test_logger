<?php

namespace Om\TestLogger;

use Exception;
use Om\TestLogger\ChannelAbstract;
use PDO;

class DatabaseChannel extends ChannelAbstract
{
    protected \PDO $pdo;
    protected string $sql;
    protected string $binding = ':log_message';

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