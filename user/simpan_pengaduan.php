<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['nis'])) {
    header("Location: ../index.php");
    exit;
}

$nis        = $_SESSION['nis'];
$jenis_id  = $_POST['jenis_id'];
$judul     = htmlspecialchars($_POST['judul']);
$isi       = htmlspecialchars($_POST['isi_pengaduan']);
$status    = 'belum';

$foto = null;


if (!empty($_FILES['foto']['name'])) {
    $folder = "../uploads/";
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $foto = time() . "_" . rand(100,999) . "." . $ext;

    move_uploaded_file($_FILES['foto']['tmp_name'], $folder . $foto);
}


$query = mysqli_query($conn, "
    INSERT INTO pengaduan 
    (nis, jenis_id, isi_pengaduan, foto, status, created_at)
    VALUES
    ('$nis', '$jenis_id', '$isi', '$foto', '$status', NOW())
");

if ($query) {
    header("Location: dashboard.php?success=1");
} else {
    echo "Gagal menyimpan pengaduan";
}
