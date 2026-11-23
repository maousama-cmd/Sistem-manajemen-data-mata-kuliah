<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'db_akademik';
    private $user = 'root';
    private $pass = '';

    public function getConnection(): PDO {
        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        return new PDO($dsn, $this->user, $this->pass, $options);
    }
}
