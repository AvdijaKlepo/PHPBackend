<?php

use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
use App\Database\Database;
use App\Controller\ProductController;

// Autoload files
require_once __DIR__ . '/../vendor/autoload.php';

// Load configuration
$config = require __DIR__ . '/../config/config.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight requests (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('HTTP/1.1 204 No Content');
    exit();
}


// Initialize database connection
$database = new Database($config['database']);
$conn = $database->connect();


// Define routes
$dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $r) {
    $r->post('/index.php/graphql', [ProductController::class, 'handleGraphQL']);
});

// Fetch the request method and URI
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Dispatch the request
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        // Handle 404 Not Found
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        // Handle 405 Method Not Allowed
        $allowedMethods = $routeInfo[1];
        header("HTTP/1.0 405 Method Not Allowed");
        echo "405 Method Not Allowed. Allowed methods: " . implode(', ', $allowedMethods);
        break;
    case Dispatcher::FOUND:
        // Handle route
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // Call the handler and pass the database connection
        $response = call_user_func($handler, $vars, $conn);
        echo $response;
        break;
}