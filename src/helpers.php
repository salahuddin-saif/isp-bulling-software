<?php
declare(strict_types=1);

use App\Core\Session;
use App\Core\Env;
use App\Models\User;

function csrf_token(): string
{
    $token = Session::get('_token');
    if (!$token) {
        $token = bin2hex(random_bytes(16));
        Session::put('_token', $token);
    }
    return $token;
}

function app_url(string $path = ''): string
{
    $base = rtrim(Env::get('APP_URL', ''), '/');
    $path = '/' . ltrim($path, '/');
    return $base . $path;
}

function current_user(): ?array
{
    $id = Session::get('user_id');
    if (!$id) {
        return null;
    }
    $user = (new User())->find((int)$id);
    return $user ?: null;
}

function require_auth(): void
{
    if (!Session::get('user_id')) {
        header('Location: /login');
        exit;
    }
}

function require_admin(): void
{
    if (Session::get('user_role') !== 'admin') {
        http_response_code(403);
        echo 'Forbidden';
        exit;
    }
}


