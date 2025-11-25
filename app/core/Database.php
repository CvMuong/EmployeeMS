<?php 
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $dbhost = getenv('DB_HOST');
        $dbname = getenv('DB_NAME');
        $dbuser = getenv('DB_USER');
        $dbpass = getenv('DB_PASS');

        $dns = "mysql:host=$dbhost;dbname=$dbname;charset=utf8mb4";

        $this->pdo = new PDO($dns, $dbuser, $dbpass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public static function getInstance() {
        if (self::$instance === null) self::$instance = new Database();
        return self::$instance->pdo;
    }
}
?>