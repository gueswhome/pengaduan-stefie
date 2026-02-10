<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

include '../config/koneksi.php';

// ambil & hapus session sekali tampil
$success = $_SESSION['success'] ?? '';
$error   = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);

$search = $_GET['search'] ?? '';

$query = mysqli_query($conn, "
    SELECT * FROM siswa 
    WHERE nis   LIKE '%$search%'
       OR nama  LIKE '%$search%'
       OR kelas LIKE '%$search%'
    ORDER BY kelas, nama
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-sm rounded-4">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">📋 Data Siswa Terdaftar</h5>
                <a href="./dashboard.php" class="btn btn-secondary btn-sm">← Kembali</a>
            </div>

            <!-- ALERT SUCCESS -->
            <?php if (!empty($success)): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= htmlspecialchars($success) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- ALERT ERROR (HTML DIIZINKAN) -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- SEARCH -->
            <form method="GET" class="mb-3 d-flex gap-2">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari NIS / Nama / Kelas..."
                       value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-primary">Cari</button>
                <a href="./data_siswa.php" class="btn btn-secondary">Reset</a>
            </form>

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if (mysqli_num_rows($query) > 0): ?>
                        <?php $no = 1; ?>
                        <?php while ($s = mysqli_fetch_assoc($query)): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= htmlspecialchars($s['nis']) ?></td>
                                <td><?= htmlspecialchars($s['nama']) ?></td>
                                <td><?= htmlspecialchars($s['kelas']) ?></td>
                                <td class="text-center">
                                    <a href="./edit_siswa.php?id=<?= $s['id'] ?>"
                                       class="btn btn-warning btn-sm">Edit</a>

                                    <a href="./hapus_siswa.php?id=<?= $s['id'] ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin ingin menghapus siswa ini?')">
                                       Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Data siswa tidak ditemukan
                            </td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
