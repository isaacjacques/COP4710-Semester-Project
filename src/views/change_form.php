<?php
$pageTitle = isset($data[$model->getPrimaryKey()])
    ? "Edit {$table} #{$data[$model->getPrimaryKey()]}"
    : "Add New {$table}";
require __DIR__ . '/partials/header.php';
$pk = $model->getPrimaryKey();
$isEdit = isset($data[$pk]);
$actionUrl = $isEdit
    ? "index.php?action=update&table={$table}"
    : "index.php?action=create&table={$table}";
?>

<div class="card">
  <div class="card-body">
    <h2 class="card-title mb-4"><?= $pageTitle ?></h2>
    <?php if (!empty($errors['_general'])): ?>
      <div class="alert alert-danger">
        <?= htmlspecialchars($errors['_general']) ?>
      </div>
    <?php endif; ?>
    <form method="post" action="<?= $actionUrl ?>">
      <input type="hidden" name="table" value="<?= htmlspecialchars($table) ?>">
      <?php if ($isEdit): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($data[$pk]) ?>">
      <?php endif; ?>

      <?php foreach ($fields as $field): 
        $val   = $data[$field] ?? '';
        $err   = $errors[$field]  ?? '';
        $cls   = $err ? 'is-invalid' : '';
      ?>
        <div class="mb-3">
          <label for="<?= $field ?>" class="form-label"><?= $field ?></label>
          <input
            type="text"
            class="form-control <?= $cls ?>"
            id="<?= $field ?>"
            name="fields[<?= $field ?>]"
            value="<?= htmlspecialchars($val) ?>"
            required
            <?= $isEdit && $field === $pk ? 'readonly' : '' ?>
          >
          <?php if ($err): ?>
            <div class="invalid-feedback"><?= htmlspecialchars($err) ?></div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>

      <button type="submit" class="btn btn-success">
        <?= $isEdit ? 'Save Changes' : 'Create Record' ?>
      </button>
      <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>
<?php require __DIR__ . '/partials/footer.php'; ?>