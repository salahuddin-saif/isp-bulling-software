<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Plan;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;

final class AdminController extends Controller
{
    public function index(): void
    {
        require_auth();
        require_admin();
        $this->view('admin/index');
    }

    public function plans(): void
    {
        require_auth();
        require_admin();
        $plans = (new Plan())->all();
        $this->view('admin/plans', ['plans' => $plans]);
    }
}


