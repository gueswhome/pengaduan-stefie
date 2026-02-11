<?php
session_start();
date_default_timezone_set('Asia/Makassar');

if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

include '../config/koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: pengaduan_masuk.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

$query = mysqli_query($conn, "
    SELECT 
        pengaduan.*,
        siswa.nama,
        siswa.kelas,
        jenis_pengaduan.jenis_pengaduan_baru AS nama_jenis
    FROM pengaduan
    JOIN siswa ON pengaduan.nis = siswa.nis
    LEFT JOIN jenis_pengaduan ON pengaduan.jenis_id = jenis_pengaduan.id
    WHERE pengaduan.id = '$id'
    LIMIT 1
");


$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: pengaduan_masuk.php");
    exit;
}


if ($data['status'] === 'belum') {

    $now = date('Y-m-d H:i:s');

    mysqli_query($conn, "
        UPDATE pengaduan
        SET status = 'terbaca',
            dibaca_at = '$now'
        WHERE id = '$id'
    ");

 
   $query = mysqli_query($conn, "
    SELECT 
        pengaduan.*,
        siswa.nama,
        siswa.kelas,
        jenis_pengaduan.jenis_pengaduan_baru AS nama_jenis
    FROM pengaduan
    JOIN siswa ON pengaduan.nis = siswa.nis
    LEFT JOIN jenis_pengaduan ON pengaduan.jenis_id = jenis_pengaduan.id
    WHERE pengaduan.id = '$id'
    LIMIT 1
");


    $data = mysqli_fetch_assoc($query);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Pengaduan</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:#f9fafb; }
.card {
    border-radius:18px;
    box-shadow:0 10px 30px rgba(0,0,0,0.06);
}
.img-detail {
    max-width:180px;
    cursor:pointer;
    border-radius:12px;
    transition:.3s;
}
.img-detail:hover {
    transform:scale(1.05);
    box-shadow:0 8px 20px rgba(0,0,0,0.15);
}
.img-modal { width:100%; border-radius:14px; }
th { width:220px; }
</style>
</head>

<body>
<div class="container py-5">
<div class="card p-4">
<h4 class="mb-4">📄 Detail Pengaduan</h4>

<table class="table table-borderless">
<tr><th>NIS</th><td><?= htmlspecialchars($data['nis']) ?></td></tr>
<tr><th>Nama Siswa</th><td><?= htmlspecialchars($data['nama']) ?></td></tr>
<tr><th>Kelas</th><td><?= htmlspecialchars($data['kelas']) ?></td></tr>
<tr><th>Jenis Pengaduan</th><td><?= htmlspecialchars($data['nama_jenis'] ?? '-') ?></td></tr>
<tr><th>Isi Pengaduan</th><td><?= nl2br(htmlspecialchars($data['isi_pengaduan'])) ?></td></tr>

<tr>
<th>Foto Bukti (Siswa)</th>
<td>
<?php if (!empty($data['foto'])): ?>
<img src="../uploads/<?= htmlspecialchars($data['foto']) ?>"
     class="img-detail"
     data-bs-toggle="modal"
     data-bs-target="#modalFotoSiswa">

<div class="modal fade" id="modalFotoSiswa">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">📷 Bukti dari Siswa</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body text-center">
<img src="../uploads/<?= htmlspecialchars($data['foto']) ?>" class="img-modal">
</div>
</div>
</div>
</div>
<?php else: ?>
<span class="text-muted">Tidak ada foto</span>
<?php endif; ?>
</td>
</tr>

<tr>
<th>Bukti Penyelesaian</th>
<td>
<?php if ($data['status'] === 'selesai' && !empty($data['bukti_selesai'])): ?>
<img src="../uploads/bukti/<?= htmlspecialchars($data['bukti_selesai']) ?>"
     class="img-detail"
     data-bs-toggle="modal"
     data-bs-target="#modalBuktiAdmin">

<div class="modal fade" id="modalBuktiAdmin">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">✅ Bukti Penyelesaian Admin</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body text-center">
<img src="../uploads/bukti/<?= htmlspecialchars($data['bukti_selesai']) ?>" class="img-modal">
</div>
</div>
</div>
</div>
<?php else: ?>
<span class="text-muted fst-italic">Bukti penyelesaian belum diupload</span>
<?php endif; ?>
</td>
</tr>

<tr><th>Dikirim Pada</th><td><?= date('d M Y H:i', strtotime($data['created_at'])) ?></td></tr>

<tr>
<th>Status</th>
<td>
<?php if ($data['status'] === 'belum'): ?>
<span class="badge bg-secondary">Belum Dibaca</span>
<?php elseif ($data['status'] === 'terbaca'): ?>
<span class="badge bg-primary">Sudah Dibaca</span>
<?php else: ?>
<span class="badge bg-success">Selesai</span>
<?php endif; ?>
</td>
</tr>

<tr><th>Dibaca Pada</th>
<td><?= $data['dibaca_at'] ? date('d M Y H:i', strtotime($data['dibaca_at'])) : '-' ?></td></tr>

<tr><th>Selesai Pada</th>
<td><?= $data['selesai_at'] ? date('d M Y H:i', strtotime($data['selesai_at'])) : '-' ?></td></tr>
</table>

<div class="mt-4">
    <?php 
    $kembali = $_SERVER['HTTP_REFERER'] ?? 'pengaduan_masuk.php';
    ?>
    <a href="<?= htmlspecialchars($kembali) ?>" class="btn btn-secondary">Kembali</a>

    <?php if ($data['status'] !== 'selesai'): ?>
        <a href="upload_bukti.php?id=<?= $data['id'] ?>&redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="btn btn-success">
    ✔ Upload Bukti & Selesaikan
</a>
    <?php endif; ?>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

