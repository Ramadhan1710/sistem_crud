<?php
require_once __DIR__ . '/../config/db.php';

// Fungsi untuk generate NIDN otomatis (opsional)
function generateNIDN($pdo) {
    $prefix = 'D'; // Awalan untuk dosen
    $stmt = $pdo->query("SELECT nidn FROM dosen WHERE nidn LIKE '$prefix%' ORDER BY nidn DESC LIMIT 1");
    $lastNIDN = $stmt->fetchColumn();

    if ($lastNIDN) {
        $lastNumber = (int)substr($lastNIDN, 1); // Ambil angka setelah huruf D
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1;
    }

    // Format: D + 4 digit angka, contoh D0001
    return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nidn = $_POST['nidn'] ?: generateNIDN($pdo); // Bisa manual atau otomatis
    $nama = $_POST['nama'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';

    if ($nama && $gender) {
        try {
            $stmt = $pdo->prepare('INSERT INTO dosen (nidn, nama, gender, no_hp) VALUES (?, ?, ?, ?)');
            $stmt->execute([$nidn, $nama, $gender, $no_hp]);
            header('Location: index.php?status=sukses');
            exit;
        } catch (PDOException $e) {
            $error = "Gagal menyimpan data: " . $e->getMessage();
        }
    } else {
        $error = "Harap isi semua kolom yang wajib diisi.";
    }
}

require_once __DIR__ . '/../header.php';

// Preview NIDN otomatis berikutnya
$nextNIDN = generateNIDN($pdo);
?>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="d-flex align-items-center mb-4">
      <a href="index.php" class="btn btn-primary me-4">
        <i class="bi bi-arrow-left"></i>
      </a>
      <h2>
        Tambah Dosen
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
          NIDN akan di-generate otomatis: <strong><?= $nextNIDN ?></strong>
        </div>

        <form method="post">
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-hash me-2"></i>NIDN</label>
            <input class="form-control" name="nidn" placeholder="Kosongkan untuk otomatis (contoh: <?= $nextNIDN ?>)">
          </div>

          <div class="mb-3">
            <label class="form-label"><i class="bi bi-person me-2"></i>Nama Lengkap</label>
            <input class="form-control" name="nama" placeholder="Masukkan nama lengkap" required autofocus>
          </div>

          <div class="mb-3">
            <label class="form-label"><i class="bi bi-gender-ambiguous me-2"></i>Gender</label>
            <select class="form-select" name="gender" required>
              <option value="">-- Pilih Gender --</option>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>

          <div class="mb-4">
            <label class="form-label"><i class="bi bi-telephone me-2"></i>No HP</label>
            <input class="form-control" name="no_hp" placeholder="Contoh: 081234567890">
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