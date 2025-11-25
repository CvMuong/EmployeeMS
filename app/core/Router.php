<?php
class Router {

    private static $routes = [];

    public static function add($path, $controller, $action) {
        self::$routes[$path] = ['controller' => $controller, 'action' => $action];
    }

    public static function dispatch() {
        $route = $_GET['route'] ?? 'login';

        if (!isset(self::$routes[$route])) {
            http_response_code(404);
            echo '404 not found';
            exit;
        }

        $ctrlName = self::$routes[$route]['controller'];
        $action = self::$routes[$route]['action'];

        $controller = new $ctrlName();
        $controller->$action();
    }
}
?>