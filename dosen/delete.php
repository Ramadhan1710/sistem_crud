<?php
require_once __DIR__ . '/../config/db.php';
$nidn = $_GET['nidn'] ?? null;
if ($nidn) {
    $stmt = $pdo->prepare('DELETE FROM dosen WHERE nidn = ?');
    $stmt->execute([$nidn]);
}
header('Location: index.php');
exit;
