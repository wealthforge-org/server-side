<?php

$base_dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($request, $base_dir) === 0) {
    $request = substr($request, strlen($base_dir));
}


if ($request == '') {
    $request = '/';
}


$apis = [
    '/Register'           => ['controller' => 'auth_controller', 'method' => 'RegisterUser'],
    '/Login'              => ['controller' => 'Login_controller', 'method' => 'find_user'],
];

if (isset($apis[$request])) {
    $controller_name = $apis[$request]['controller'];
    $method = $apis[$request]['method'];
    require_once __DIR__ . "/controllers/{$controller_name}.php";

    $class_map = [
        'auth_controller'  => 'Register',
        'Login_controller' => 'Login',
    ];
    $class_name = $class_map[$controller_name] ?? $controller_name;

    $controller = new $class_name();
    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        echo "Error: Method {$method} not found in {$class_name}.";
    }
} else {
    echo "404 Not Found";
}