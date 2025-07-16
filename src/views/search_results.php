<?php
$pageTitle = "Results — $table";
require __DIR__ . '/partials/header.php';

$used = array_filter($_GET['criteria'] ?? [], fn($v) => trim($v) !== '');
$cols = array_keys($used);
array_unshift($cols, $model->getPrimaryKey()); 
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Results for <?= htmlspecialchars($table) ?></h2>
  <a href="index.php" class="btn btn-outline-secondary">← New Search</a>
</div>

<?php if (empty($results)): ?>
  <div class="alert alert-warning">No records found.</div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <?php foreach ($cols as $col): ?>
            <th scope="col"><?= htmlspecialchars($col) ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($results as $row): ?>
          <tr onclick="location.href='?action=view&table=<?= urlencode($table) ?>&id=<?= urlencode($row[$model->getPrimaryKey()]) ?>';" style="cursor:pointer;">
            <?php foreach ($cols as $col): ?>
              <td><?= htmlspecialchars($row[$col] ?? '') ?></td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/partials/footer.php'; ?>