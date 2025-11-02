<?php
require_once __DIR__ . '/../config/db.php';

// Fungsi untuk generate NIM otomatis
function generateNIM($pdo) {
    $tahun = date('Y');
    $kode_prodi = '01'; // Bisa disesuaikan per program studi
    
    // Cari NIM terakhir dengan prefix tahun+prodi yang sama
    $prefix = $tahun . $kode_prodi;
    $stmt = $pdo->prepare("SELECT nim FROM mahasiswa WHERE nim LIKE ? ORDER BY nim DESC LIMIT 1");
    $stmt->execute([$prefix . '%']);
    $lastNIM = $stmt->fetchColumn();
    
    if ($lastNIM) {
        // Ambil 4 digit terakhir, tambah 1
        $lastNumber = (int)substr($lastNIM, -4);
        $newNumber = $lastNumber + 1;
    } else {
        // NIM pertama untuk tahun ini
        $newNumber = 1;
    }
    
    // Format: TAHUN(4) + PRODI(2) + URUT(4) = 10 digit
    return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = generateNIM($pdo); // Auto-generate NIM
    $nama = $_POST['nama'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';
    $nidn = $_POST['nidn'] ?: null;

    $stmt = $pdo->prepare('INSERT INTO mahasiswa (nim, nama, gender, no_hp, nidn) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$nim, $nama, $gender, $no_hp, $nidn]);
    header('Location: index.php'); exit;
}

require_once __DIR__ . '/../header.php';

$dosen = $pdo->query('SELECT nidn, nama FROM dosen ORDER BY nama')->fetchAll();

// Preview NIM yang akan digenerate
$nextNIM = generateNIM($pdo);
?>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="d-flex align-items-center mb-4">
      <a href="index.php" class="btn btn-primary me-4">
        <i class="bi bi-arrow-left"></i>
      </a>
      <h2>
        Tambah Mahasiswa
      </h2>
    </div>
    
    <div class="card">
      <div class="card-body p-4">
        <div class="alert alert-info">
          <i class="bi bi-info-circle me-2"></i>
          NIM akan di-generate otomatis: <strong><?= $nextNIM ?></strong>
        </div>
        
        <form method="post">
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-person me-2"></i>Nama Lengkap</label>
            <input class="form-control" name="nama" placeholder="Masukkan nama lengkap" required autofocus>
          </div>
          
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-gender-ambiguous me-2"></i>Gender</label>
            <select class="form-select" name="gender">
              <option value="">-- Pilih Gender --</option>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
          
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-telephone me-2"></i>No HP</label>
            <input class="form-control" name="no_hp" placeholder="Contoh: 081234567890">
          </div>
          
          <div class="mb-4">
            <label class="form-label"><i class="bi bi-person-badge me-2"></i>Dosen Pembimbing</label>
            <select name="nidn" class="form-select">
              <option value="">-- Pilih Dosen (Opsional) --</option>
              <?php foreach ($dosen as $d): ?>
                <option value="<?=htmlspecialchars($d['nidn'])?>"><?=htmlspecialchars($d['nama'])?></option>
              <?php endforeach; ?>
            </select>
          </div>
          
          <div class="d-flex gap-2">
            <button class="btn btn-primary px-4">
              <i class="bi bi-save me-2"></i>Simpan
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
