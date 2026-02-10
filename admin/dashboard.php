<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

include '../config/koneksi.php';

// total siswa
$totalSiswa = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM siswa"))['total'];

// belum
$totalMasuk = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM pengaduan WHERE status='belum'"))['total'];

// terbaca
$totalDilihat = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM pengaduan WHERE status='terbaca'"))['total'];

// selesai
$totalSelesai = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM pengaduan WHERE status='selesai'"))['total'];

?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Dashboard Admin</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<!-- Font Awesome (untuk sidebar) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<!-- Font Inter -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">


<style>

body{
    font-family:'Inter',sans-serif;
    background:#f3f4f6;
}

/* main content */
.main{
    margin-left:260px;
    padding:30px;
}

/* card dashboard */
.card-box{
    border-radius:20px;
    padding:25px;
    color:white;
    position:relative;
    overflow:hidden;
    text-decoration:none;
    display:block;
    transition:0.3s;
}

.card-box:hover{
    transform:translateY(-5px);
}

.card-box i.bg-icon{
    position:absolute;
    right:20px;
    top:20px;
    font-size:60px;
    opacity:0.2;
}

/* colors */
.green{
    background:linear-gradient(135deg,#22c55e,#16a34a);
}

.yellow{
    background:linear-gradient(135deg,#facc15,#eab308);
}

.blue{
    background:linear-gradient(135deg,#3b82f6,#2563eb);
}

.pink{
    background:linear-gradient(135deg,#ec4899,#db2777);
}

/* action card */
.card-action{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

</style>

</head>
<body>


<!-- Sidebar -->
<?php include 'sidebar.php'; ?>


<!-- Main Content -->
<div class="main">

<div class="d-flex justify-content-between align-items-center mb-4">

<h4 class="fw-semibold">Dashboard</h4>

<div class="fw-medium">
    Halo, Admin 👋
</div>

</div>


<div class="row g-4">

<!-- total siswa -->
<div class="col-md-3">

<a href="data_siswa.php" class="card-box green">

<i class="bi bi-people bg-icon"></i>

<h6>Total Siswa</h6>

<h2><?= $totalSiswa ?></h2>

<small>Lihat daftar siswa</small>

</a>

</div>


<!-- pengaduan masuk -->
<div class="col-md-3">
<a href="pengaduan_masuk.php" class="card-box yellow">
<i class="bi bi-envelope bg-icon"></i>
<h6>Pengaduan Masuk</h6>
<h2><?= $totalMasuk ?></h2>
<small>Belum dibaca</small>
</a>
</div>


<!-- pengaduan dilihat -->
<div class="col-md-3">
<a href="pengaduan_dilihat.php" class="card-box blue">
<i class="bi bi-eye bg-icon"></i>
<h6>Pengaduan Dilihat</h6>
<h2><?= $totalDilihat ?></h2>
<small>Sudah dibaca</small>
</a>
</div>


<!-- pengaduan selesai -->
<div class="col-md-3">
<a href="pengaduan_selesai.php" class="card-box pink">
<i class="bi bi-check-circle bg-icon"></i>
<h6>Pengaduan Selesai</h6>
<h2><?= $totalSelesai ?></h2>
<small>Sudah selesai</small>
</a>
</div>



<!-- aksi cepat -->
<div class="col-md-4">

<div class="card-action">

<h6 class="mb-3">Aksi Cepat</h6>

<a href="tambah_siswa.php" class="btn btn-primary w-100 mb-2">

<i class="bi bi-person-plus"></i>
Tambah Siswa

</a>

<a href="tambah_jenis_pengaduan.php" class="btn btn-outline-primary w-100">

<i class="bi bi-plus-circle"></i>
Tambah Jenis Pengaduan

</a>

</div>

</div>


</div>

</div>


</body>
</html>
