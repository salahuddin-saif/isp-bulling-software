<?php
declare(strict_types=1);

namespace App\Core;

final class View
{
    public static function render(string $template, array $data = []): void
    {
        $viewPath = __DIR__ . '/../Views/' . $template . '.php';
        if (!is_file($viewPath)) {
            http_response_code(500);
            echo 'View not found: ' . htmlspecialchars($template);
            return;
        }
        extract($data, EXTR_SKIP);
        include __DIR__ . '/../Views/layouts/header.php';
        include $viewPath;
        include __DIR__ . '/../Views/layouts/footer.php';
    }
}


