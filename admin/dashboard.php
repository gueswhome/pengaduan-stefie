<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

include '../config/koneksi.php';

$querySiswa = mysqli_query($conn, "SELECT COUNT(*) AS total FROM siswa");
$totalSiswa = mysqli_fetch_assoc($querySiswa)['total'];

$queryPengaduan = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pengaduan");
$totalPengaduan = mysqli_fetch_assoc($queryPengaduan)['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f9fafb;
        }
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: #1f2937;
            color: #fff;
            position: fixed;
            padding: 20px;
        }
        .sidebar h4 {
            font-weight: 700;
            margin-bottom: 30px;
        }
        .sidebar a {
            display: block;
            padding: 12px 15px;
            color: #d1d5db;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 8px;
        }
        .sidebar a.active,
        .sidebar a:hover {
            background: #374151;
            color: #fff;
        }
        .main {
            margin-left: 260px;
            padding: 30px;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            transition: 0.2s;
        }
        .card:hover {
            transform: translateY(-3px);
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4>Admin Panel</h4>
    <a href="dashboard.php" class="active">Dashboard</a>
    <a href="pengaduan_masuk.php">Pengaduan Masuk</a>
    <a href="tambah_siswa.php">Tambah Siswa</a>
    <a href="../auth/logout.php">Logout</a>
</div>

<div class="main">
    <div class="topbar">
        <h5>Dashboard</h5>
        <span class="text-muted">Halo, Admin 👋</span>
    </div>

    <div class="row g-4 align-items-stretch">

   
      <div class="col-md-4">
    <a href="data_siswa.php" class="text-decoration-none text-dark">
        <div class="card p-4 h-100">
            <h6>Total Siswa</h6>
            <p class="fs-3 fw-bold mt-2"><?= $totalSiswa ?></p>
            <small class="text-muted">Klik untuk lihat daftar siswa</small>
        </div>
    </a>
</div>


    
        <div class="col-md-4">
            <a href="pengaduan_masuk.php" class="text-decoration-none text-dark">
                <div class="card p-4 h-100">
                    <h6>Pengaduan Masuk</h6>
                    <p class="fs-3 fw-bold mt-2"><?= $totalPengaduan ?></p>
                    <small class="text-muted">Laporan dari siswa</small>
                </div>
            </a>
        </div>

     
        <div class="col-md-4">
    <div class="card p-4 h-100 d-flex flex-column">
        <h6>Aksi Cepat</h6>

        <a href="tambah_siswa.php" class="btn btn-primary mb-2">
            + Tambah Siswa
        </a>

        <a href="tambah_jenis_pengaduan.php" class="btn btn-outline-primary">
            + Tambah Jenis Pengaduan
        </a>
    </div>
</div>

        

    </div>
</div>

</body>
</html>
