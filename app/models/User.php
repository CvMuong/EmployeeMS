<?php
class User {
    public static function findByUsername($username) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :u LIMIT 1");
        $stmt->execute([':u'=>$username]); return $stmt->fetch();
    }
    public static function find($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id'=>$id]); return $stmt->fetch();
    }
}
