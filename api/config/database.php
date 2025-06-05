<?php
class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        $host = getenv('DB_HOST') ?: 'mysql';
        $dbname = getenv('DB_NAME') ?: 'productos_db';
        $username = getenv('DB_USER') ?: 'root';
        $password = getenv('DB_PASS') ?: 'password';
        
        try {
            $this->connection = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $username,
                $password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }
}