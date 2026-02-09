<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

include '../config/koneksi.php';

// Total Siswa
$querySiswa = mysqli_query($conn, "SELECT COUNT(*) AS total FROM siswa");
$totalSiswa = mysqli_fetch_assoc($querySiswa)['total'];

// Total Pengaduan Berdasarkan Status
$queryMasuk = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pengaduan WHERE status='masuk'");
$totalMasuk = mysqli_fetch_assoc($queryMasuk)['total'];

$queryDilihat = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pengaduan WHERE status='dilihat'");
$totalDilihat = mysqli_fetch_assoc($queryDilihat)['total'];

$querySelesai = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pengaduan WHERE status='selesai'");
$totalSelesai = mysqli_fetch_assoc($querySelesai)['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f4f6f9;
        }

        /* Sidebar modern dengan gradien dan hover */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #1f2937, #111827);
            color: #fff;
            position: fixed;
            padding: 25px 20px;
            border-radius: 0 20px 20px 0;
        }
        .sidebar h4 {
            font-weight: 700;
            margin-bottom: 40px;
            font-size: 1.6rem;
            letter-spacing: 1px;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            padding: 14px 18px;
            color: #d1d5db;
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 10px;
            font-weight: 500;
            transition: 0.3s;
            position: relative;
        }
        .sidebar a i {
            margin-right: 12px;
            font-size: 1.1rem;
        }
        .sidebar a::before {
            content: '';
            position: absolute;
            left: 0;
            width: 5px;
            height: 100%;
            border-radius: 8px 0 0 8px;
            background: transparent;
            transition: 0.3s;
        }
        .sidebar a.active::before,
        .sidebar a:hover::before {
            background: linear-gradient(180deg, #4ade80, #16a34a);
        }
        .sidebar a.active,
        .sidebar a:hover {
            color: #fff;
            background: rgba(255,255,255,0.05);
        }

        /* Main content */
        .main {
            margin-left: 260px;
            padding: 30px;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            align-items: center;
        }
        .topbar h5 {
            font-weight: 600;
        }

        /* Cards modern */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.15);
        }
        .card h6 {
            font-weight: 600;
            margin-bottom: 10px;
        }
        .card .icon {
            font-size: 2.2rem;
            opacity: 0.15;
            position: absolute;
            top: 15px;
            right: 15px;
        }
        .card-total { background: linear-gradient(135deg, #4ade80, #16a34a); color: #fff; }
        .card-masuk { background: linear-gradient(135deg, #facc15, #eab308); color: #fff; }
        .card-dilihat { background: linear-gradient(135deg, #60a5fa, #2563eb); color: #fff; }
        .card-selesai { background: linear-gradient(135deg, #f472b6, #db2777); color: #fff; }

        .card p {
            font-size: 2rem;
            font-weight: 700;
        }

        /* Quick actions modern */
        .quick-actions {
            border-radius: 16px;
            padding: 25px;
            background: #fff;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .quick-actions:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.1);
        }
        .quick-actions h6 {
            font-weight: 600;
            margin-bottom: 20px;
        }
        .quick-actions .btn {
            width: 100%;
            margin-bottom: 12px;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4>Admin Panel</h4>
    <a href="dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
    <a href="pengaduan_masuk.php"><i class="fas fa-inbox"></i> Pengaduan Masuk</a>
    <a href="tambah_siswa.php"><i class="fas fa-user-plus"></i> Tambah Siswa</a>
    <a href="../auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main">
    <div class="topbar">
        <h5>Dashboard</h5>
        <span class="text-muted">Halo, Admin 👋</span>
    </div>

    <div class="row g-4 align-items-stretch">

        <!-- Total Siswa -->
        <div class="col-md-3">
            <a href="data_siswa.php" class="text-decoration-none">
                <div class="card card-total p-4 h-100 text-white">
                    <h6>Total Siswa</h6>
                    <p><?= $totalSiswa ?></p>
                    <i class="fas fa-users icon"></i>
                    <small>Lihat daftar siswa</small>
                </div>
            </a>
        </div>

        <!-- Pengaduan Masuk -->
        <div class="col-md-3">
            <a href="pengaduan_masuk.php" class="text-decoration-none">
                <div class="card card-masuk p-4 h-100 text-white">
                    <h6>Pengaduan Masuk</h6>
                    <p><?= $totalMasuk ?></p>
                    <i class="fas fa-envelope icon"></i>
                    <small>Belum dilihat</small>
                </div>
            </a>
        </div>

        <!-- Pengaduan Dilihat -->
        <div class="col-md-3">
            <a href="pengaduan_dilihat.php" class="text-decoration-none">
                <div class="card card-dilihat p-4 h-100 text-white">
                    <h6>Pengaduan Dilihat</h6>
                    <p><?= $totalDilihat ?></p>
                    <i class="fas fa-eye icon"></i>
                    <small>Sudah diperiksa</small>
                </div>
            </a>
        </div>

        <!-- Pengaduan Selesai -->
        <div class="col-md-3">
            <a href="pengaduan_selesai.php" class="text-decoration-none">
                <div class="card card-selesai p-4 h-100 text-white">
                    <h6>Pengaduan Selesai</h6>
                    <p><?= $totalSelesai ?></p>
                    <i class="fas fa-check icon"></i>
                    <small>Sudah ditindaklanjuti</small>
                </div>
            </a>
        </div>

    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="quick-actions">
                <h6>Aksi Cepat</h6>
                <a href="tambah_siswa.php" class="btn btn-primary"><i class="fas fa-user-plus"></i> Tambah Siswa</a>
                <a href="tambah_jenis_pengaduan.php" class="btn btn-outline-primary"><i class="fas fa-plus"></i> Tambah Jenis Pengaduan</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
