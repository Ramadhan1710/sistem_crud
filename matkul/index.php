<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../header.php';

$stmt = $pdo->query('SELECT * FROM matkul ORDER BY kode_matkul DESC');
$rows = $stmt->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <div class="card-body p-0">
    <div class="margin-bottom: 100px">
        <a href="../index.php" class="btn btn-primary me-4">
            <i class="bi bi-arrow-left-circle me-2" ></i> Kembali
        </a>
       <h2>
    Data Mata Kuliah
    </h2>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0"></table>
        </div>
</div> <div style="margin-bottom: 100px;"></div>
  <a class="btn btn-primary" href="create.php">
    <i class="bi bi-plus-circle me-2"></i>Tambah Matkul
  </a>
</div>

<div class="card">
  <div class="card-body">
    <?php if (empty($rows)): ?>
      <div class="text-center py-5">
        <i class="bi bi-inbox" style="font-size: 4rem; color: var(--bs-secondary);"></i>
        <p class="text-muted mt-3">Belum ada data mata kuliah</p>
        <a href="create.php" class="btn btn-primary">
          <i class="bi bi-plus-circle me-2"></i>Tambah Matkul Pertama
        </a>
      </div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th><i class="bi bi-hash me-2"></i>Kode Matkul</th>
              <th><i class="bi bi-book me-2"></i>Nama Mata Kuliah</th>
              <th><i class="bi bi-calculator me-2"></i>SKS</th>
              <th class="text-center" style="width: 200px;"><i class="bi bi-gear me-2"></i>Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($rows as $r): ?>
            <tr>
              <td>
                <span class="badge bg-primary"><?=htmlspecialchars($r['kode_matkul'])?></span>
              </td>
              <td><strong><?=htmlspecialchars($r['nama'])?></strong></td>
              <td>
                <span class="badge bg-info text-dark"><?=htmlspecialchars($r['sks'])?> SKS</span>
              </td>
              <td class="text-center">
                <a class="btn btn-sm btn-outline-primary" href="edit.php?kode_matkul=<?=urlencode($r['kode_matkul'])?>">
                  <i class="bi bi-pencil"></i> Edit
                </a>
                <a class="btn btn-sm btn-outline-danger" href="delete.php?kode_matkul=<?=urlencode($r['kode_matkul'])?>" onclick="return confirm('Yakin hapus mata kuliah ini?')">
                  <i class="bi bi-trash"></i> Hapus
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      
      <div class="mt-3 text-muted">
        <small>
          <i class="bi bi-info-circle me-1"></i>
          Total: <strong><?=count($rows)?></strong> mata kuliah
        </small>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php require_once __DIR__ . '/../footer.php'; ?>
