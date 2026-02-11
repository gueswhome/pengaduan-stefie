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
    $jenis_pengaduan_baru = mysqli_real_escape_string($conn, $_POST['jenis_pengaduan_baru']);
    $nama_guru = mysqli_real_escape_string($conn, $_POST['nama_guru']);

    $update_foto = "";


    if (!empty($_FILES['foto_guru']['name'])) {

       
        if (!empty($row['foto_guru']) && !str_starts_with($row['foto_guru'], 'http')) {
            if (file_exists("../uploads/guru/" . $row['foto_guru'])) {
                unlink("../uploads/guru/" . $row['foto_guru']);
            }
        }

        $ext = pathinfo($_FILES['foto_guru']['name'], PATHINFO_EXTENSION);
        $foto_baru = time() . '_' . rand(100,999) . '.' . $ext;

        move_uploaded_file(
            $_FILES['foto_guru']['tmp_name'],
            "../uploads/guru/" . $foto_baru
        );

        $update_foto = ", foto_guru='$foto_baru'";


    } elseif (!empty($_POST['foto_guru_link'])) {

        $link = mysqli_real_escape_string($conn, $_POST['foto_guru_link']);
        $update_foto = ", foto_guru='$link'";
    }

    mysqli_query($conn, "
        UPDATE jenis_pengaduan SET
            jenis_pengaduan_baru='$jenis_pengaduan_baru',
            nama_guru='$nama_guru'
            $update_foto
        WHERE id='$id'
    ");

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
            <div class="card p-4 rounded-4 shadow-sm">
                <h5 class="mb-3">Edit Jenis Pengaduan</h5>

                <form method="POST" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label class="form-label">Nama Jenis Pengaduan</label>
                        <input type="text"
                               name="jenis_pengaduan_baru"
                               class="form-control"
                               value="<?= htmlspecialchars($row['jenis_pengaduan_baru']) ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Guru Penanggung Jawab</label>
                        <input type="text"
                               name="nama_guru"
                               class="form-control"
                               value="<?= htmlspecialchars($row['nama_guru']) ?>">
                    </div>

                    <!-- FOTO -->
                    <div class="mb-3">
                        <label class="form-label">Foto Guru</label><br>

                        <?php
                        if (!empty($row['foto_guru'])) {
                            $foto = str_starts_with($row['foto_guru'], 'http')
                                ? $row['foto_guru']
                                : "../uploads/guru/" . $row['foto_guru'];
                        } else {
                            $foto = "../assets/img/default.png";
                        }
                        ?>

                        <img src="<?= $foto ?>"
                             width="80"
                             height="80"
                             class="rounded mb-2"
                             style="object-fit:cover;"><br>

                        <input type="file" name="foto_guru" class="form-control mb-2" accept="image/*">

                        <input type="url"
                               name="foto_guru_link"
                               class="form-control"
                               placeholder="Atau masukkan link foto (https://...)">

                        <small class="text-muted">
                            Upload file ATAU isi link (pilih salah satu)
                        </small>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="tambah_jenis_pengaduan.php" class="btn btn-secondary">← Kembali</a>
                        <button name="update" class="btn btn-primary">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
