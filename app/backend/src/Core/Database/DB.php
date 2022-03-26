<?php

namespace Nathan\Kabum\Core\Database;

use PDO;

class DB
{
    private static DB $instance;

    private $connection;

    public function __construct(string $host, int $port, string $database, string $user, string $password)
    {
        try {
            $this->connection = new PDO("mysql:host={$host};port={$port};dbname={$database}", $user, $password);
        } catch (\PDOException $exception) {
            throw new \Exception("Database connection failed. Reason: {$exception->getMessage()}");
        }

        self::$instance = $this;
    }

    public function __destruct()
    {
        $this->connection = null;
    }

    public function query(string $query, array $params = []): QueryResult
    {
        $this->statement = $this->connection->prepare($query);

        try {
            if ($this->statement && $this->statement->execute($params)) {
                $rows = [];

                while ($row = $this->statement->fetch(\PDO::FETCH_ASSOC)) {
                    $rows[] = $row;
                }

                return new QueryResult(
                    row: $rows[0] ?? [],
                    rows: $rows,
                    num_rows: $this->statement->rowCount()
                );
            }
        } catch (\PDOException $exception) {
            throw new \Exception("Database query failed. Reason: {$exception->getMessage()}");
        }

        return new QueryResult();
    }

    public function getLastInsertId()
    {
        return $this->connection->lastInsertId();
    }

    /**
     * Singleton
     */
    public static function getInstance(): DB
    {
        if (self::$instance === null) {
            throw new \Exception("Database not initialized.");
        }

        return self::$instance;
    }
}
