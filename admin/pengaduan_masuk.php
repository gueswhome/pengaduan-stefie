<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

include '../config/koneksi.php';

$query = mysqli_query($conn, "
    SELECT 
        pengaduan.id,
        pengaduan.nis,
        pengaduan.status,
        pengaduan.created_at,
        siswa.nama,
        siswa.kelas,
        jenis_pengaduan.nama AS jenis_pengaduan
    FROM pengaduan
    JOIN siswa ON pengaduan.nis = siswa.nis
    LEFT JOIN jenis_pengaduan ON pengaduan.jenis_id = jenis_pengaduan.id
    ORDER BY pengaduan.created_at DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaduan Masuk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

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
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        .table td, .table th {
            vertical-align: middle;
            white-space: nowrap;
        }
        .text-wrap-custom {
            max-width: 220px;
            white-space: normal;
            word-wrap: break-word;
        }
        .action-btns a {
            margin: 2px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4>Admin Panel</h4>
    <a href="dashboard.php">Dashboard</a>
    <a href="pengaduan_masuk.php" class="active">Pengaduan Masuk</a>
    <a href="tambah_siswa.php">Tambah Siswa</a>
    <a href="../auth/logout.php">Logout</a>
</div>

<div class="main">
    <h5 class="mb-4">Pengaduan Masuk</h5>

    <div class="card p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jenis Pengaduan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nis']) ?></td>

                        <td class="text-wrap-custom">
                            <?= htmlspecialchars($row['nama']) ?>
                        </td>

                        <td><?= htmlspecialchars($row['kelas']) ?></td>

                        <td class="text-wrap-custom">
                            <?= htmlspecialchars($row['jenis_pengaduan'] ?? '-') ?>
                        </td>

                        <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>

                        <td>
                            <?php if ($row['status'] == 'belum'): ?>
                                <span class="badge bg-secondary">Belum Dibaca</span>
                            <?php elseif ($row['status'] == 'terbaca'): ?>
                                <span class="badge bg-primary">Sudah Dibaca</span>
                            <?php else: ?>
                                <span class="badge bg-success">Selesai</span>
                            <?php endif; ?>
                        </td>

                        <td class="action-btns">
                            <a href="detail_pengaduan.php?id=<?= $row['id'] ?>" 
                               class="btn btn-sm btn-info text-white"
                               title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>

                            <?php if ($row['status'] != 'selesai'): ?>
                                <a href="upload_bukti.php?id=<?= $row['id'] ?>" 
   class="btn btn-sm btn-success"
   title="Upload Bukti Selesai">
    <i class="bi bi-check-circle"></i>
</a>

                            <?php else: ?>
                                <button class="btn btn-sm btn-success" disabled>
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            <?php endif; ?>

                            <a href="hapus_pengaduan.php?id=<?= $row['id'] ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Yakin ingin menghapus pengaduan ini?')"
                               title="Hapus">
                                <i class="bi bi-trash"></i>
                            </a>
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
