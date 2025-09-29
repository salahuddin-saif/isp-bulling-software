<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Invoice;

final class DashboardController extends Controller
{
    public function index(): void
    {
        require_auth();
        $invoices = (new Invoice())->forUser((int)($_SESSION['user_id'] ?? 0));
        $this->view('dashboard/index', [
            'invoices' => $invoices,
        ]);
    }
}


