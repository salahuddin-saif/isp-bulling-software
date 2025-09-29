<?php use function csrf_token; ?>
<div class="row">
  <div class="col-md-6 mx-auto">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h2 class="h4 mb-3">Create account</h2>
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" action="/register">
          <input type="hidden" name="_token" value="<?= csrf_token() ?>">
          <div class="mb-3">
            <label class="form-label">Full name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
          </div>
          <button class="btn btn-primary w-100">Register</button>
        </form>
      </div>
    </div>
  </div>
</div>


