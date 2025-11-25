<?php 
class Middleware {
    public static function requireLogin() {
        if (!isset($_SESSION['user'])) {
            header('Location: ?route=login');
            exit;
        }
    }

    public static function requireRole($role) {
        self::requireLogin();

        if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== $role) {
            http_response_code(403);
            echo "<h1>403 - Bạn không có quyền truy cập này!</h1>";
            exit;
        }
    }

    public static function flash() {
        if (!empty($_SESSION['flash'])) {
            $f = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $f;
        }
        return null;
    }
}
?>