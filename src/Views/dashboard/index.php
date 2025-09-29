<?php $user = current_user(); ?>
<div class="row">
  <div class="col-lg-10 mx-auto">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="h4">Dashboard</h2>
      <div>
        <span class="badge bg-<?= ($user && $user['status']==='active')?'success':'secondary' ?>">Status: <?= htmlspecialchars($user['status'] ?? 'guest') ?></span>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-body">
        <h3 class="h5 mb-3">Invoices</h3>
        <div class="table-responsive">
          <table class="table table-sm align-middle">
            <thead><tr><th>ID</th><th>Amount</th><th>Status</th><th>Due</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($invoices as $inv): ?>
              <tr>
                <td>#<?= (int)$inv['id'] ?></td>
                <td>$<?= number_format(((int)$inv['amount_cents'])/100, 2) ?></td>
                <td><?= htmlspecialchars($inv['status']) ?></td>
                <td><?= htmlspecialchars($inv['due_date']) ?></td>
                <td>
                  <?php if ($inv['status'] === 'pending'): ?>
                    <a class="btn btn-primary btn-sm" href="/pay/<?= (int)$inv['id'] ?>">Pay</a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


