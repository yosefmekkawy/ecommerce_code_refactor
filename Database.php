<?php
class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        $this->conn = new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '');
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
