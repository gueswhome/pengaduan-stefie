<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

include '../config/koneksi.php';

// TAMBAH DATA
if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    mysqli_query($conn, "INSERT INTO jenis_pengaduan (nama) VALUES ('$nama')");
    header("Location: tambah_jenis_pengaduan.php?status=tambah");
    exit;
}

// AMBIL DATA
$data = mysqli_query($conn, "SELECT * FROM jenis_pengaduan ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Jenis Pengaduan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: #f9fafb;
        }
        .card {
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- FORM TAMBAH -->
            <div class="card p-4 mb-4">
                <h5 class="mb-3">Tambah Jenis Pengaduan</h5>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Jenis Pengaduan</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Perundungan" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="dashboard.php" class="btn btn-secondary">Dashboard</a>
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>

            <!-- TABEL DATA -->
            <div class="card p-4">
                <h5 class="mb-3">Daftar Jenis Pengaduan</h5>

                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th width="10%">No</th>
                            <th>Nama Jenis</th>
                            <th width="25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($data)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td>
                                <a href="edit_jenis_pengaduan.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <button class="btn btn-danger btn-sm" onclick="hapusData(<?= $row['id'] ?>)">Hapus</button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- SWEETALERT HAPUS -->
<script>
function hapusData(id) {
    Swal.fire({
        title: 'Yakin?',
        text: 'Data jenis pengaduan akan dihapus!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'hapus_jenis_pengaduan.php?id=' + id;
        }
    });
}
</script>

<!-- SWEETALERT STATUS -->
<?php if (isset($_GET['status'])) { ?>
<script>
<?php if ($_GET['status'] == 'tambah') { ?>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: 'Jenis pengaduan berhasil ditambahkan',
    timer: 2000,
    showConfirmButton: false
});
<?php } elseif ($_GET['status'] == 'edit') { ?>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: 'Jenis pengaduan berhasil diperbarui',
    timer: 2000,
    showConfirmButton: false
});
<?php } elseif ($_GET['status'] == 'hapus') { ?>
Swal.fire({
    icon: 'success',
    title: 'Dihapus!',
    text: 'Jenis pengaduan berhasil dihapus',
    timer: 2000,
    showConfirmButton: false
});
<?php } ?>
</script>
<?php } ?>

</body>
</html>
