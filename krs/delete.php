<?php
require_once __DIR__ . '/../config/db.php';
$kode = $_GET['kode'] ?? null;
if ($kode) {
    $stmt = $pdo->prepare('DELETE FROM krs WHERE kode = ?');
    $stmt->execute([$kode]);
}
header('Location: index.php'); exit;
