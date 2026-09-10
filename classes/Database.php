<?php
declare(strict_types=1);

final class Database
{
    private static ?self $instance = null;
    private mysqli $connection;

    private function __construct()
    {
        mysqli_report(MYSQLI_REPORT_OFF);
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: '';
        $name = getenv('DB_NAME') ?: 'projects';
        $port = (int)(getenv('DB_PORT') ?: 3306);

        $connection = new mysqli($host, $user, $pass, $name, $port);
        if ($connection->connect_errno) {
            throw new RuntimeException('Database connection failed. Check MySQL/MariaDB and your database settings.');
        }
        $connection->set_charset('utf8mb4');
        $this->connection = $connection;
    }

    public static function getInstance(): self
    {
        return self::$instance ??= new self();
    }

    public function connection(): mysqli
    {
        return $this->connection;
    }

    public function transaction(callable $callback): mixed
    {
        $this->connection->begin_transaction();
        try {
            $result = $callback($this->connection);
            $this->connection->commit();
            return $result;
        } catch (Throwable $e) {
            $this->connection->rollback();
            throw $e;
        }
    }

    private function __clone() {}
}
