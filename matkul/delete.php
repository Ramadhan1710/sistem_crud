<?php
require_once __DIR__ . '/../config/db.php';
$kode = $_GET['kode_matkul'] ?? null;
if ($kode) {
    $stmt = $pdo->prepare('DELETE FROM matkul WHERE kode_matkul = ?');
    $stmt->execute([$kode]);
}
header('Location: index.php'); exit;
