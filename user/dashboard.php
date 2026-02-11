<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['nis'])) {
    header("Location: ../index.php");
    exit;
}

$nis = $_SESSION['nis'];

$pengaduan = mysqli_query($conn, "
    SELECT 
        pengaduan.id,
        pengaduan.nis,
        pengaduan.status,
        pengaduan.created_at,
        siswa.nama,
        siswa.kelas,
        jenis_pengaduan.jenis_pengaduan_baru AS jenis_nama
    FROM pengaduan
    JOIN siswa 
        ON pengaduan.nis = siswa.nis
    LEFT JOIN jenis_pengaduan 
        ON pengaduan.jenis_id = jenis_pengaduan.id
    WHERE pengaduan.nis='$nis'
    ORDER BY pengaduan.created_at DESC
");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f9fafb;
            font-family: 'Inter', sans-serif;
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,.05);
        }
        .badge-belum { background:#6b7280; }
        .badge-terbaca { background:#3b82f6; }
        .badge-selesai { background:#10b981; }
    </style>
</head>
<body>


<div class="container py-5">


    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                Selamat datang, <?= htmlspecialchars($_SESSION['nama']); ?>
            </h4>
            <small class="text-muted">Berikut riwayat pengaduanmu</small>
        </div>
        <a href="../auth/logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
    </div>


    <div class="alert alert-info">
        Pengaduan hanya dapat di hapus oleh <strong>Admin</strong>.
    </div>


    <a href="pengaduan.php" class="btn btn-primary mb-4">
        + Buat Pengaduan
    </a>

  
    <div class="card p-4">
        <h6 class="fw-semibold mb-3">History Pengaduan</h6>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="text-muted">
                    <tr>
                        <th>Jenis Pengaduan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                <?php if (mysqli_num_rows($pengaduan) == 0): ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Belum ada pengaduan
                        </td>
                    </tr>
                <?php endif; ?>

                <?php while ($row = mysqli_fetch_assoc($pengaduan)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['jenis_nama']); ?></td>
                        <td>
                            <?php if ($row['status'] == 'belum'): ?>
                                <span class="badge badge-belum">Belum Dibaca</span>
                            <?php elseif ($row['status'] == 'terbaca'): ?>
                                <span class="badge badge-terbaca">Sudah Dibaca</span>
                            <?php elseif ($row['status'] == 'selesai'): ?>
                                <span class="badge badge-selesai">Sudah Dilaksanakan</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d M Y', strtotime($row['created_at'])); ?></td>
                       <td class="d-flex gap-1">
    <a href="detail_pengaduan.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-primary">
        Lihat
    </a>

    <?php if($row['status'] != 'selesai'): // cuma bisa edit jika belum selesai ?>
        <a href="edit_pengaduan.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-warning">
            Edit
        </a>
    <?php endif; ?>
</td>

                    </tr>
                <?php endwhile; ?>

                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>
