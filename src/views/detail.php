<?php
$pageTitle = "Detail — $table #{$record[$model->getPrimaryKey()]}";
require __DIR__ . '/partials/header.php';
?>

<div class="card mb-4">
  <div class="card-body">
    <h3 class="card-title mb-3">
      <?= htmlspecialchars($table) ?> Details
      <small class="text-muted">#<?= htmlspecialchars($record[$model->getPrimaryKey()]) ?></small>
    </h3>
    <table class="table table-borderless">
      <tbody>
        <?php foreach ($record as $col => $val): ?>
          <tr>
            <th class="w-25"><?= htmlspecialchars($col) ?></th>
            <td><?= htmlspecialchars($val) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <a href="javascript:history.back()" class="btn btn-secondary">← Back to Results</a>
  </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>