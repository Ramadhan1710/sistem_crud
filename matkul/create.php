<?php
require_once __DIR__ . '/../config/db.php';

// Fungsi untuk generate kode mata kuliah otomatis
function generateKodeMatkul($pdo) {
    $prefix = 'MK';
    $stmt = $pdo->query("SELECT kode_matkul FROM matkul WHERE kode_matkul LIKE '$prefix%' ORDER BY kode_matkul DESC LIMIT 1");
    $lastKode = $stmt->fetchColumn();

    if ($lastKode) {
        $lastNumber = (int)substr($lastKode, 2);
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1;
    }

    return $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}

// Proses penyimpanan data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = $_POST['kode_matkul'] ?: generateKodeMatkul($pdo);
    $nama = $_POST['nama'] ?? '';
    $sks = (int)($_POST['sks'] ?? 0);

    if ($nama && $sks > 0) {
        try {
            $stmt = $pdo->prepare('INSERT INTO matkul (kode_matkul, nama, sks) VALUES (?, ?, ?)');
            $stmt->execute([$kode, $nama, $sks]);
            header('Location: index.php?status=sukses');
            exit;
        } catch (PDOException $e) {
            $error = "Gagal menyimpan data: " . $e->getMessage();
        }
    } else {
        $error = "Harap isi semua kolom dengan benar.";
    }
}

// Baru tampilkan HTML setelah semua logika PHP selesai
require_once __DIR__ . '/../header.php';
$nextKode = generateKodeMatkul($pdo);
?>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="d-flex align-items-center mb-4">
      <a href="index.php" class="btn btn-primary me-4">
        <i class="bi bi-arrow-left"></i>
      </a>
      <h2>
        Tambah Mata Kuliah
      </h2>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <div class="card">
      <div class="card-body p-4">
        <div class="alert alert-info">
          <i class="bi bi-info-circle me-2"></i>
          Kode Mata Kuliah akan di-generate otomatis: <strong><?= $nextKode ?></strong>
        </div>

        <form method="post">
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-hash me-2"></i>Kode Mata Kuliah</label>
            <input class="form-control" name="kode_matkul" placeholder="Kosongkan untuk otomatis (contoh: <?= $nextKode ?>)">
          </div>

          <div class="mb-3">
            <label class="form-label"><i class="bi bi-book me-2"></i>Nama Mata Kuliah</label>
            <input class="form-control" name="nama" placeholder="Masukkan nama mata kuliah" required>
          </div>

          <div class="mb-4">
            <label class="form-label"><i class="bi bi-calculator me-2"></i>SKS</label>
            <input class="form-control" name="sks" type="number" min="1" max="6" placeholder="Masukkan jumlah SKS" required>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
              <i class="bi bi-save me-2"></i>Simpan
            </button>
            <a href="index.php" class="btn btn-outline-secondary px-4">
              <i class="bi bi-x-circle me-2"></i>Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../footer.php'; ?>