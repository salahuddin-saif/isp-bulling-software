<?php
declare(strict_types=1);

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\AdminController;
use App\Controllers\PaymentController;

/** @var Router $router */

$router->get('/', [HomeController::class, 'index']);
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);
$router->get('/admin/plans', [AdminController::class, 'plans']);

// Payments
$router->get('/pay/{id}', [PaymentController::class, 'pay']);
$router->get('/payment/success/{id}', [PaymentController::class, 'success']);
$router->post('/webhook/stripe', [PaymentController::class, 'webhookStripe']);

// Auth
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->post('/logout', [AuthController::class, 'logout']);


