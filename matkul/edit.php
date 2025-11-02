<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../header.php';

$kode = $_GET['kode_matkul'] ?? null;
if (!$kode) { header('Location: index.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $sks = (int)($_POST['sks'] ?? 0);
    $stmt = $pdo->prepare('UPDATE matkul SET nama=?, sks=? WHERE kode_matkul=?');
    $stmt->execute([$nama, $sks, $kode]);
    header('Location: index.php'); exit;
}

$stmt = $pdo->prepare('SELECT * FROM matkul WHERE kode_matkul = ?');
$stmt->execute([$kode]);
$row = $stmt->fetch();
if (!$row) { echo '<div class="alert alert-danger">Matkul tidak ditemukan</div>'; require_once __DIR__ . '/../footer.php'; exit; }
?>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="d-flex align-items-center mb-4">
      <a href="index.php" class="btn btn-primary me-4">
        <i class="bi bi-arrow-left"></i>
      </a>
      <h2>
        Edit Mata Kuliah
      </h2>
    </div>
    
    <div class="card">
      <div class="card-body p-4">
        <form method="post">
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-hash me-2"></i>Kode Mata Kuliah</label>
            <input class="form-control" value="<?=htmlspecialchars($row['kode_matkul'])?>" disabled>
            <small class="text-muted">Kode mata kuliah tidak dapat diubah</small>
          </div>
          
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-book me-2"></i>Nama Mata Kuliah</label>
            <input class="form-control" name="nama" value="<?=htmlspecialchars($row['nama'])?>" placeholder="Masukkan nama mata kuliah" required>
          </div>
          
          <div class="mb-4">
            <label class="form-label"><i class="bi bi-calculator me-2"></i>SKS</label>
            <input class="form-control" name="sks" type="number" min="1" max="6" value="<?=htmlspecialchars($row['sks'])?>" placeholder="Masukkan jumlah SKS" required>
            <small class="text-muted">Jumlah Satuan Kredit Semester (1-6)</small>
          </div>
          
          <div class="d-flex gap-2">
            <button class="btn btn-primary px-4">
              <i class="bi bi-save me-2"></i>Simpan Perubahan
            </button>
            <a class="btn btn-outline-secondary px-4" href="index.php">
              <i class="bi bi-x-circle me-2"></i>Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../footer.php'; ?>
