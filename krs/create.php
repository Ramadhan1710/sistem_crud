<?php
require_once __DIR__ . '/../config/db.php';

$error = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $nim = $_POST['nim'] ?? '';
   $kode_matkul = $_POST['kode_matkul'] ?? '';

   $check = $pdo->prepare('SELECT COUNT(*) FROM krs WHERE nim = ? AND kode_matkul = ?');
   $check->execute([$nim, $kode_matkul]);

   if ($check->fetchColumn() > 0) {

      $mhs = $pdo->prepare('SELECT nama FROM mahasiswa WHERE nim = ?');
      $mhs->execute([$nim]);
      $namaMhs = $mhs->fetchColumn();

      $mtk = $pdo->prepare('SELECT nama FROM matkul WHERE kode_matkul = ?');
      $mtk->execute([$kode_matkul]);
      $namaMatkul = $mtk->fetchColumn();

      $error = "Mahasiswa <strong>$namaMhs</strong> sudah terdaftar di mata kuliah <strong>$namaMatkul</strong>!";
   } else {
      $stmt = $pdo->prepare('INSERT INTO krs (nim, kode_matkul) VALUES (?, ?)');
      $stmt->execute([$nim, $kode_matkul]);
      header('Location: index.php');
      exit;
   }
}

require_once __DIR__ . '/../header.php';

$mahasiswa = $pdo->query('SELECT nim, nama FROM mahasiswa ORDER BY nama')->fetchAll();
$matkul = $pdo->query('SELECT kode_matkul, nama, sks FROM matkul ORDER BY nama')->fetchAll();
?>

<div class="row justify-content-center">
   <div class="col-lg-8">
      <div class="d-flex align-items-center mb-4">
         <a href="index.php" class="btn btn-primary me-4">
            <i class="bi bi-arrow-left"></i>
         </a>
         <h2>
            Tambah KRS
         </h2>
      </div>

      <div class="card">
         <div class="card-body p-4">
            <?php if ($error): ?>
               <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <i class="bi bi-exclamation-triangle-fill me-2"></i>
                  <?= $error ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>
            <?php endif; ?>

            <form method="post">
               <div class="mb-3">
                  <label class="form-label"><i class="bi bi-person me-2"></i>Mahasiswa</label>
                  <select name="nim" class="form-select" required>
                     <option value="">-- Pilih Mahasiswa --</option>
                     <?php foreach ($mahasiswa as $m): ?>
                        <option value="<?= htmlspecialchars($m['nim']) ?>"><?= htmlspecialchars($m['nama']) ?> (<?= htmlspecialchars($m['nim']) ?>)</option>
                     <?php endforeach; ?>
                  </select>
               </div>

               <div class="mb-4">
                  <label class="form-label"><i class="bi bi-book me-2"></i>Mata Kuliah</label>
                  <select name="kode_matkul" class="form-select" required>
                     <option value="">-- Pilih Mata Kuliah --</option>
                     <?php foreach ($matkul as $t): ?>
                        <option value="<?= htmlspecialchars($t['kode_matkul']) ?>"><?= htmlspecialchars($t['nama']) ?> (<?= htmlspecialchars($t['sks']) ?> SKS)</option>
                     <?php endforeach; ?>
                  </select>
               </div>

               <div class="alert alert-info">
                  <i class="bi bi-info-circle me-2"></i>
                  <small>KRS akan otomatis mendapatkan kode unik setelah disimpan</small>
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