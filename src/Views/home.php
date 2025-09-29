<div class="row">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h1 class="h3 mb-3">Welcome to ISP Billing</h1>
        <p class="text-muted">Choose a plan and register to get started.</p>
        <div class="row g-3 mt-3">
          <?php foreach (($plans ?? []) as $p): ?>
            <div class="col-md-6">
              <div class="border rounded p-3 h-100">
                <div class="d-flex justify-content-between align-items-center">
                  <h3 class="h5 mb-0"><?= htmlspecialchars($p['name']) ?></h3>
                  <strong>$<?= number_format(((int)$p['price_cents'])/100, 2) ?>/mo</strong>
                </div>
                <div class="text-muted small mt-1">Speed: <?= (int)$p['speed_mbps'] ?> Mbps</div>
                <?php if (!empty($p['description'])): ?>
                  <div class="mt-2"><?= nl2br(htmlspecialchars($p['description'])) ?></div>
                <?php endif; ?>
                <div class="mt-3">
                  <a class="btn btn-outline-primary btn-sm" href="/register">Select</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>


