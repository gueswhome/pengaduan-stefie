<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

include '../config/koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: tambah_jenis_pengaduan.php");
    exit;
}

$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM jenis_pengaduan WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

if (!$row) {
    header("Location: tambah_jenis_pengaduan.php");
    exit;
}


if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    mysqli_query($conn, "UPDATE jenis_pengaduan SET nama='$nama' WHERE id='$id'");

    header("Location: tambah_jenis_pengaduan.php?status=edit");
    exit;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Jenis Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 shadow-sm rounded-4">
                <h5 class="mb-3">Edit Jenis Pengaduan</h5>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Jenis Pengaduan</label>
                        <input 
                            type="text" 
                            name="nama" 
                            class="form-control" 
                            value="<?= htmlspecialchars($row['nama']) ?>" 
                            required
                        >
                    </div>

                    <button name="update" class="btn btn-primary">Update</button>
                    <a href="tambah_jenis_pengaduan.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
