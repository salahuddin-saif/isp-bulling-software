<?php
declare(strict_types=1);

// Autoload (PSR-4 manual)
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/';
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }
    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Load helpers
require_once __DIR__ . '/helpers.php';

// Load env
App\Core\Env::load(__DIR__ . '/../.env');

// Start session
App\Core\Session::start();


