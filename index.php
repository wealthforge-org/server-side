<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// ------------------------------
// TEMP ROUTER: use ?route=/Register
// ------------------------------

// Get route from query parameter
$request = $_GET['route'] ?? '/';

// Define available API endpoints
$apis = [
    '/Register' => ['controller' => 'auth_controller', 'method' => 'RegisterUser'],
    '/Login'    => ['controller' => 'Login_controller', 'method' => 'find_user'],
];

// Check if route exists
if (!isset($apis[$request])) {
    http_response_code(404);
    echo "404 Not Found";
    exit;
}

$controllerName = $apis[$request]['controller'];
$method = $apis[$request]['method'];

// Build controller file path
$controllerFile = __DIR__ . "/controller/{$controllerName}.php";

// Check if controller file exists
if (!file_exists($controllerFile)) {
    http_response_code(500);
    echo "Controller file not found: {$controllerFile}";
    exit;
}

// Include the controller
require_once $controllerFile;

// Automatically map filename to class name
// E.g., auth_controller => Register, Login_controller => Login
$className = null;
switch ($controllerName) {
    case 'auth_controller':
        $className = 'Register';
        break;
    case 'Login_controller':
        $className = 'Login';
        break;
    default:
        // fallback: convert snake_case to PascalCase
        $parts = explode('_', $controllerName);
        $className = '';
        foreach ($parts as $p) {
            $className .= ucfirst($p);
        }
}

// Check if class exists
if (!class_exists($className)) {
    http_response_code(500);
    echo "Controller class not found: {$className}";
    exit;
}

// Instantiate controller
$controller = new $className();

// Check if method exists
if (!method_exists($controller, $method)) {
    http_response_code(500);
    echo "Method {$method} not found in class {$className}";
    exit;
}

// Call the controller method
$controller->$method();
