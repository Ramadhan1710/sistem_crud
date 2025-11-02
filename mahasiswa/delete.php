<?php
require_once __DIR__ . '/../config/db.php';
$nim = $_GET['nim'] ?? null;
if ($nim) {
    $stmt = $pdo->prepare('DELETE FROM mahasiswa WHERE nim = ?');
    $stmt->execute([$nim]);
}
header('Location: index.php'); exit;
