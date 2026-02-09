<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

include '../config/koneksi.php';

$id = $_GET['id'] ?? '';

// ambil data siswa
$query = mysqli_query($conn, "SELECT * FROM siswa WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: data_siswa.php");
    exit;
}

// proses update
if (isset($_POST['update'])) {
    $nis   = mysqli_real_escape_string($conn, $_POST['nis']);
    $nama  = mysqli_real_escape_string($conn, $_POST['nama']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);

    mysqli_query($conn, "
        UPDATE siswa SET
            nis   = '$nis',
            nama  = '$nama',
            kelas = '$kelas'
        WHERE id = '$id'
    ");

    // 🔥 INI YANG PENTING
    $_SESSION['success'] = "Data siswa berhasil diperbarui";

    header("Location: data_siswa.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <h5 class="mb-4">✏️ Edit Data Siswa</h5>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">NIS</label>
                    <input type="text" name="nis" class="form-control"
                           value="<?= htmlspecialchars($data['nis']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control"
                           value="<?= htmlspecialchars($data['nama']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <input type="text" name="kelas" class="form-control"
                           value="<?= htmlspecialchars($data['kelas']) ?>" required>
                </div>

                <div class="d-flex gap-2">
                    <a href="data_siswa.php" class="btn btn-secondary">Batal</a>
                    <button type="submit" name="update" class="btn btn-success">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
