<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../header.php';

$stmt = $pdo->query('SELECT * FROM dosen');
$rows = $stmt->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
   <div class="card-body p-0">
    <div class="margin-bottom: 100px">
        <a href="..//index.php" class="btn btn-primary me-4">
            <i class="bi bi-arrow-left-circle me-2" ></i> Kembali
        </a>
       <h2>
    Data Dosen
    </h2>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover mb-0"></table>
        </div>
</div> <div style="margin-bottom: 100px;"></div>
  <a class="btn btn-primary" href="create.php">
    <i class="bi bi-plus-circle me-2"></i>Tambah Dosen
  </a>
</div>

<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th><i class="bi bi-hash me-2"></i>NIDN</th>
            <th><i class="bi bi-person me-2"></i>Nama</th>
            <th><i class="bi bi-gender-ambiguous me-2"></i>Gender</th>
            <th><i class="bi bi-telephone me-2"></i>No HP</th>
            <th class="text-center"><i class="bi bi-gear me-2"></i>Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php if (empty($rows)): ?>
          <tr><td colspan="5" class="text-center py-4 text-muted">
            <i class="bi bi-inbox display-4 d-block mb-2"></i>
            Belum ada data dosen
          </td></tr>
        <?php else: ?>
          <?php foreach ($rows as $r): ?>
            <tr>
              <td><span class="badge bg-secondary"><?=htmlspecialchars($r['nidn'])?></span></td>
              <td class="fw-semibold"><?=htmlspecialchars($r['nama'])?></td>
              <td><?=htmlspecialchars($r['gender'])?></td>
              <td><?=htmlspecialchars($r['no_hp'])?></td>
              <td class="text-center">
                <a class="btn btn-sm btn-outline-primary" href="edit.php?nidn=<?=urlencode($r['nidn'])?>">
                  <i class="bi bi-pencil-square"></i> Edit
                </a>
                <a class="btn btn-sm btn-outline-danger" href="delete.php?nidn=<?=urlencode($r['nidn'])?>" onclick="return confirm('Hapus dosen ini?')">
                  <i class="bi bi-trash"></i> Hapus
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../footer.php'; ?>
