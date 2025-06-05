<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/ProductController.php';

$dotenv = parse_ini_file(__DIR__ . '/.env');
foreach ($dotenv as $key => $value) {
    putenv("$key=$value");
}

header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
header("Access-Control-Max-Age: 3600");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_method = $_SERVER['REQUEST_METHOD'];

$productController = new ProductController();

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_method = $_SERVER['REQUEST_METHOD'];

$request_path = explode('?', $request_uri)[0];

if ($request_path === '/productos' || $request_path === '/productos/') {
    switch ($request_method) {
        case 'GET':
            $productController->getAll();
            break;
        case 'POST':
            $productController->create();
            break;
        default:
            header('HTTP/1.1 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
    }
} elseif (preg_match('#^/productos/(\d+)/?$#', $request_path, $matches)) {
    $id = $matches[1];
    switch ($request_method) {
        case 'GET':
            $productController->getById($id);
            break;
        case 'PUT':
            $productController->update($id);
            break;
        case 'DELETE':
            $productController->delete($id);
            break;
        default:
            header('HTTP/1.1 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
    }
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(['error' => 'Endpoint no encontrado']);
}

http_response_code(404);
echo json_encode(['error' => 'Endpoint no encontrado']);