<?php
$pageTitle = 'Search';
require __DIR__ . '/partials/header.php';
?>

<div class="card">
  <div class="card-body">
    <h2 class="card-title mb-4">Search Records</h2>
    <form method="get" action="index.php">
      <input type="hidden" name="action" value="search">

      <div class="mb-3">
        <label for="table-select" class="form-label">Table</label>
        <select class="form-select" name="table" id="table-select" required>
          <option value="" selected disabled>— Select table —</option>
          <?php foreach($tables as $name => $fields): ?>
            <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div id="criteria-container" class="row gy-3">
        <!-- JS injects up to 5 search fields here -->
      </div>

      <button type="submit" class="btn btn-primary mt-4">Search</button>
    </form>
  </div>
</div>

<script>
  const tables = <?= json_encode($tables) ?>;
  const container = document.getElementById('criteria-container');
  document.getElementById('table-select').addEventListener('change', e => {
    container.innerHTML = '';
    let cols = tables[e.target.value] || [];
    cols.slice(0,5).forEach(col => {
      let colId = col.replace(/\s+/g,'_');
      let div = document.createElement('div');
      div.className = 'col-md-6';
      div.innerHTML = `
        <label for="${colId}" class="form-label">${col}</label>
        <input 
          type="text" 
          class="form-control" 
          id="${colId}" 
          name="criteria[${col}]" 
          placeholder="Enter ${col}"
        />`;
      container.appendChild(div);
    });
  });
</script>

<?php require __DIR__ . '/partials/footer.php'; ?>