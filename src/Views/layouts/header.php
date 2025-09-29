<?php use function app_url; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ISP Billing</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { padding-bottom: 60px; }
  </style>
  <link rel="icon" href="data:,">
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
      <a class="navbar-brand" href="<?= app_url('/') ?>">ISP Billing</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample" aria-controls="navbarsExample" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarsExample">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <?php if (!empty($_SESSION['user_id'])): ?>
            <li class="nav-item"><a class="nav-link" href="<?= app_url('/dashboard') ?>">Dashboard</a></li>
            <li class="nav-item">
              <form method="post" action="<?= app_url('/logout') ?>" class="d-inline">
                <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                <button class="btn btn-link nav-link" type="submit">Logout</button>
              </form>
            </li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="<?= app_url('/login') ?>">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= app_url('/register') ?>">Register</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
  <main class="container mt-4">


