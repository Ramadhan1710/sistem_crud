<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../header.php';

$nidn = $_GET['nidn'] ?? null;
if (!$nidn) { header('Location: index.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';
    $stmt = $pdo->prepare('UPDATE dosen SET nama=?, gender=?, no_hp=? WHERE nidn=?');
    $stmt->execute([$nama, $gender, $no_hp, $nidn]);
    header('Location: index.php'); exit;
}

$stmt = $pdo->prepare('SELECT * FROM dosen WHERE nidn = ?');
$stmt->execute([$nidn]);
$row = $stmt->fetch();
if (!$row) { 
    echo '<div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-2"></i>Dosen tidak ditemukan</div>'; 
    require_once __DIR__ . '/../footer.php'; 
    exit; 
}
?>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="d-flex align-items-center mb-4">
      <a href="index.php" class="btn btn-primary me-4">
        <i class="bi bi-arrow-left"></i>
      </a>
      <h2>
        Edit Dosen
      </h2>
    </div>
    
    <div class="card">
      <div class="card-body p-4">
        <form method="post">
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-hash me-2"></i>NIDN</label>
            <input class="form-control" value="<?=htmlspecialchars($row['nidn'])?>" disabled>
            <small class="text-muted">NIDN tidak dapat diubah</small>
          </div>
          
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-person me-2"></i>Nama Lengkap</label>
            <input class="form-control" name="nama" value="<?=htmlspecialchars($row['nama'])?>" required>
          </div>
          
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-gender-ambiguous me-2"></i>Gender</label>
            <select class="form-select" name="gender">
              <option value="L" <?=($row['gender']=='L'?'selected':'')?>>Laki-laki</option>
              <option value="P" <?=($row['gender']=='P'?'selected':'')?>>Perempuan</option>
            </select>
          </div>
          
          <div class="mb-4">
            <label class="form-label"><i class="bi bi-telephone me-2"></i>No HP</label>
            <input class="form-control" name="no_hp" value="<?=htmlspecialchars($row['no_hp'])?>">
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
