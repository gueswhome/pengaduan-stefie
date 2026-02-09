<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['nis'])) {
    header("Location: ../index.php");
    exit;
}

// ambil jenis pengaduan
$jenis = mysqli_query($conn, "SELECT * FROM jenis_pengaduan ORDER BY nama ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card p-4 shadow-sm">
        <h5 class="fw-bold mb-3">Buat Pengaduan</h5>

        <form action="simpan_pengaduan.php" method="POST" enctype="multipart/form-data">


            <div class="mb-3">
                <label class="form-label">Jenis Pengaduan</label>
                <select name="jenis_id" class="form-select" required>
                    <option value="">-- Pilih Jenis --</option>
                    <?php while ($j = mysqli_fetch_assoc($jenis)): ?>
                        <option value="<?= $j['id']; ?>">
                            <?= htmlspecialchars($j['nama']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

    

      
            <div class="mb-3">
                <label class="form-label">Isi Pengaduan</label>
                <textarea name="isi_pengaduan" rows="4" class="form-control" required></textarea>
            </div>

            
            <div class="mb-3">
                <label class="form-label">Foto Pendukung (opsional)</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
                <small class="text-muted">Boleh dikosongkan</small>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary">Kirim</button>
                <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
            </div>

        </form>
    </div>
</div>

</body>
</html>
