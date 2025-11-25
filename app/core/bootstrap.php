<?php 
session_start();

require_once __DIR__ . '/env.php';
loadEnv(__DIR__ . '/../../.env');

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/View.php';
require_once __DIR__ . '/../helpers/upload.php';
require_once __DIR__ . '/../helpers/csrf.php';
require_once __DIR__ . '/Middleware.php';
require_once __DIR__ . '/Validator.php';

foreach (glob(__DIR__ . '/../controllers/*.php') as $file) {
    require_once $file;
}

foreach (glob(__DIR__ . '/../models/*.php') as $file) {
    require_once $file;
}
?>