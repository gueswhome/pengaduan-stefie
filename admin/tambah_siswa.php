<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

$alert = "";
$alertType = "";
$alertMsg = "";

if (isset($_POST['simpan'])) {

    $nis   = mysqli_real_escape_string($conn, $_POST['nis']);
    $nama  = mysqli_real_escape_string($conn, $_POST['nama']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);

    $cek = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$nis'");

    if (mysqli_num_rows($cek) > 0) {

        $alert = "showAlert";
        $alertType = "error";
        $alertMsg = "NIS sudah terdaftar!";

    } else {

        mysqli_query($conn, "
            INSERT INTO siswa (nis, nama, kelas, password)
            VALUES ('$nis','$nama','$kelas',NULL)
        ");

        $alert = "showAlert";
        $alertType = "success";
        $alertMsg = "Siswa berhasil ditambahkan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Tambah Siswa</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

body{
    font-family:'Inter',sans-serif;
    background:#f1f5f9;
}

.main{
    margin-left:260px;
    padding:30px;
}

.page-header{
    display:flex;
    align-items:center;
    gap:15px;
    background:white;
    padding:18px 22px;
    border-radius:14px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
    margin-bottom:25px;
}

.page-header .icon{
    width:45px;
    height:45px;
    border-radius:12px;
    background:linear-gradient(135deg,#6366f1,#4f46e5);
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:20px;
}

.page-header .title{
    font-size:18px;
    font-weight:600;
    margin:0;
}

.card{
    border:none;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
    max-width:500px;
}

.form-control{
    border-radius:10px;
    padding:10px;
}

.btn-simpan{
    border-radius:10px;
    padding:10px;
    font-weight:600;
}

</style>

</head>

<body>

<?php include "sidebar.php"; ?>

<div class="main">

    <div class="page-header">

        <div class="icon">
            <i class="bi bi-person-plus"></i>
        </div>

        <h1 class="title">
            Tambah Data Siswa
        </h1>

    </div>


    <div class="card p-4">

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">NIS</label>
                <input type="text" name="nis" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control" required>
            </div>

            <button type="submit" name="simpan" class="btn btn-primary btn-simpan w-100">

                <i class="bi bi-save"></i>
                Simpan Data

            </button>

        </form>

    </div>

</div>


<script>

<?php if ($alert == "showAlert") { ?>

Swal.fire({
    toast:true,
    position:'top-end',
    icon:'<?= $alertType ?>',
    title:'<?= $alertMsg ?>',
    showConfirmButton:false,
    timer:3000,
    timerProgressBar:true
});

<?php } ?>

</script>

</body>
</html>
