<?php

use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
use App\Database\Database;
use App\Controller\ProductController;
use Dotenv\Dotenv;


require_once __DIR__ . '/../vendor/autoload.php';


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('HTTP/1.1 204 No Content');
    exit();
}


$database = new Database([
    'host' => $_ENV['DB_HOST'],
    'db_name' => $_ENV['DB_NAME'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD']
]);

$conn = $database->connect();


$dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $r) {
    $r->post('/index.php/graphql', [ProductController::class, 'handleGraphQL']);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];


$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:

        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:

        $allowedMethods = $routeInfo[1];
        header("HTTP/1.0 405 Method Not Allowed");
        echo "405 Method Not Allowed. Allowed methods: " . implode(', ', $allowedMethods);
        break;
    case Dispatcher::FOUND:

        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $response = call_user_func($handler, $vars, $conn);
        echo $response;
        break;
}
