<?php
ini_set('display_errors', 1);
require_once __DIR__ . '/../app/core/bootstrap.php';

Router::add('login', 'AuthController', 'showLogin');
Router::add('login/submit', 'AuthController', 'login');
Router::add('logout', 'AuthController', 'logout');

Router::add('employees/index', 'EmployeeController', 'index');
Router::add('employees/create', 'EmployeeController', 'create');
Router::add('employees/edit', 'EmployeeController', 'edit');
Router::add('employees/delete', 'EmployeeController', 'delete');
Router::add('employees/show', 'EmployeeController', 'show');
Router::add('employees/profile', 'EmployeeController', 'profile');

Router::add('api/employees', 'ApiController', 'employees');

Router::dispatch();
