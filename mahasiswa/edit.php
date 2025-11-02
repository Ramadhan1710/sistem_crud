<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../header.php';

$nim = $_GET['nim'] ?? null;
if (!$nim) { header('Location: index.php'); exit; }

$dosen = $pdo->query('SELECT nidn, nama FROM dosen ORDER BY nama')->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';
    $nidn = $_POST['nidn'] ?: null;
    $stmt = $pdo->prepare('UPDATE mahasiswa SET nama=?, gender=?, no_hp=?, nidn=? WHERE nim=?');
    $stmt->execute([$nama, $gender, $no_hp, $nidn, $nim]);
    header('Location: index.php'); exit;
}

$stmt = $pdo->prepare('SELECT * FROM mahasiswa WHERE nim = ?');
$stmt->execute([$nim]);
$row = $stmt->fetch();
if (!$row) { echo '<div class="alert alert-danger">Mahasiswa tidak ditemukan</div>'; require_once __DIR__ . '/../footer.php'; exit; }
?>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="d-flex align-items-center mb-4">
      <a href="index.php" class="btn btn-primary me-4">
        <i class="bi bi-arrow-left"></i>
      </a>
      <h2>
        Edit Mahasiswa
      </h2>
    </div>
    
    <div class="card">
      <div class="card-body p-4">
        <form method="post">
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-hash me-2"></i>NIM</label>
            <input class="form-control" value="<?=htmlspecialchars($row['nim'])?>" disabled>
            <small class="text-muted">NIM tidak dapat diubah</small>
          </div>
          
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-person me-2"></i>Nama Lengkap</label>
            <input class="form-control" name="nama" value="<?=htmlspecialchars($row['nama'])?>" placeholder="Masukkan nama lengkap" required>
          </div>
          
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-gender-ambiguous me-2"></i>Gender</label>
            <select class="form-select" name="gender">
              <option value="">-- Pilih Gender --</option>
              <option value="L" <?=($row['gender']=='L'?'selected':'')?>>Laki-laki</option>
              <option value="P" <?=($row['gender']=='P'?'selected':'')?>>Perempuan</option>
            </select>
          </div>
          
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-telephone me-2"></i>No HP</label>
            <input class="form-control" name="no_hp" value="<?=htmlspecialchars($row['no_hp'])?>" placeholder="Contoh: 081234567890">
          </div>
          
          <div class="mb-4">
            <label class="form-label"><i class="bi bi-person-badge me-2"></i>Dosen Pembimbing</label>
            <select name="nidn" class="form-select">
              <option value="">-- Pilih Dosen (Opsional) --</option>
              <?php foreach ($dosen as $d): ?>
                <option value="<?=htmlspecialchars($d['nidn'])?>" <?=($row['nidn']==$d['nidn']?'selected':'')?>><?=htmlspecialchars($d['nama'])?></option>
              <?php endforeach; ?>
            </select>
          </div>
          
          <div class="d-flex gap-2">
            <button class="btn btn-outline-primary px-4">
              <i class="bi bi-save me-2"></i>Simpan Perubahan
            </button>
            <a class="btn btn-primary px-4" href="index.php">
              <i class="bi bi-x-circle me-2"></i>Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../footer.php'; ?>
