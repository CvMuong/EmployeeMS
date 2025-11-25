<?php 
class Department {
    public static function all() {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM departments ORDER BY name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT 8 FROM departments WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}