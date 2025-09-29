<div class="row">
  <div class="col-lg-10 mx-auto">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="h4">Plans</h2>
      <a href="#" class="btn btn-sm btn-primary disabled">Add Plan</a>
    </div>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr><th>Name</th><th>Speed</th><th>Price</th><th></th></tr>
        </thead>
        <tbody>
        <?php foreach ($plans as $p): ?>
          <tr>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= (int)$p['speed_mbps'] ?> Mbps</td>
            <td>$<?= number_format(((int)$p['price_cents'])/100, 2) ?></td>
            <td><a class="btn btn-sm btn-outline-secondary disabled" href="#">Edit</a></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


