<?php

namespace App\Utils;

use PDO;

class DBConnection
{
    private string $host = 'localhost';
    private string $db_name = 'seproject';
    private string $username = 'root';
    private string $password = 'Admin123';
    private $conn = null;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}