<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;
use PDO;

abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = DB::pdo();
    }
}


