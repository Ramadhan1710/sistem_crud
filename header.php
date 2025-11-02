<?php
$base_url = "http://localhost/sistem_crud/";
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prodi Sistem Informasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: #002952; 
            --card-shadow: 0 4px 6px rgba(0,0,0,0.07);
            --hover-shadow: 0 8px 16px rgba(0,0,0,0.12);
        }
        body {
            background: whitesmoke; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: #002952;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            color: white !important;
            font-weight: 600;
            font-size: 1.5rem;
        }
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            transition: all 0.3s;
            padding: 0.5rem 1rem !important;
            border-radius: 6px;
        }
        .nav-link:hover {
            color: white !important;
            background: rgba(255,255,255,0.15);
        }
        .sidebar {
            width: 250px; 
            position: fixed;
            top: 56px;
            left: 0;
            bottom: 0;
            background-color: #002952;
            padding-top: 20px;
            z-index: 1000;
        }
        .sidebar .nav-link {
            color: #ccc;
            padding: 12px 15px;
            font-weight: 500;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background-color: #495057; 
            border-left: 5px solid #0d6efd; 
        }
        #main-content-wrapper {
            margin-left: 250px; 
            padding: 20px;
            min-height: calc(100vh - 56px); 
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="<?= $base_url ?>index.php">
            Prodi Sistem Informasi
        </a>
    </div>
</nav>

<div class="sidebar">
    <ul class="nav flex-column">

        <li class="nav-item">
            <a class="nav-link <?php echo (isset($active_page) && $active_page == 'dashboard' ? 'active' : ''); ?>" 
               href="<?= $base_url ?>index.php">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo (isset($active_page) && $active_page == 'dosen' ? 'active' : ''); ?>" 
               href="<?= $base_url ?>dosen/index.php">
                <i class="fas fa-user-tie me-2"></i> Dosen
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo (isset($active_page) && $active_page == 'mahasiswa' ? 'active' : ''); ?>" 
               href="<?= $base_url ?>mahasiswa/index.php">
                <i class="fas fa-user-graduate me-2"></i> Mahasiswa
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo (isset($active_page) && $active_page == 'matkul' ? 'active' : ''); ?>" 
               href="<?= $base_url ?>matkul/index.php">
                <i class="fas fa-book me-2"></i> Mata Kuliah
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo (isset($active_page) && $active_page == 'krs' ? 'active' : ''); ?>" 
               href="<?= $base_url ?>krs/index.php">
                <i class="fas fa-list me-2"></i> KRS
            </a>
        </li>

    </ul>
</div>

<div id="main-content-wrapper"> 
    <div class="container-fluid"></div>
    <div class="container">
