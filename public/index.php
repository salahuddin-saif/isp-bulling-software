<?php
declare(strict_types=1);

// Bootstrap
require_once __DIR__ . '/../src/bootstrap.php';

use App\Core\Router;

$router = new Router();

// Web routes
require_once __DIR__ . '/../routes/web.php';

// Dispatch
$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');


