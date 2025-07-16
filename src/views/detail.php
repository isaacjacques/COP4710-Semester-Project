<?php
$pageTitle = "Detail — $table #{$record[$model->getPrimaryKey()]}";
$backUrl = $_SESSION['last_search_url'] ?? 'index.php';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>
    <?= htmlspecialchars($table) ?> Details
    <small class="text-muted">#<?= htmlspecialchars($record[$model->getPrimaryKey()]) ?></small>
  </h2>
  <div>
    <a
      href="index.php?action=edit&table=<?= urlencode($table) ?>&id=<?= urlencode($record[$model->getPrimaryKey()]) ?>"
      class="btn btn-warning me-2"
    >
      Edit
    </a>
    <a
      href="index.php?action=delete&table=<?= urlencode($table) ?>&id=<?= urlencode($record[$model->getPrimaryKey()]) ?>"
      class="btn btn-danger"
      onclick="return confirm('Are you sure you want to delete this record?');"
    >
      Delete
    </a>
  </div>
</div>

<div class="card">
  <div class="card-body">
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
    <a href="<?= htmlspecialchars($backUrl) ?>" class="btn btn-secondary">
      ← Back to Results
    </a>
  </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>