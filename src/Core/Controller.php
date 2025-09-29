<?php
declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function view(string $template, array $data = []): void
    {
        View::render($template, $data);
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }

    protected function csrfCheck(): void
    {
        $token = $_POST['_token'] ?? '';
        if (!hash_equals(Session::get('_token', ''), $token)) {
            http_response_code(419);
            echo 'CSRF token mismatch';
            exit;
        }
    }
}


