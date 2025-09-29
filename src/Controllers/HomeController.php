<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Plan;

final class HomeController extends Controller
{
    public function index(): void
    {
        $plans = (new Plan())->all();
        $this->view('home', ['plans' => $plans]);
    }
}


