<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

include '../config/koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: pengaduan_masuk.php");
    exit;
}

$id = $_GET['id'];

// hapus data
mysqli_query($conn, "DELETE FROM pengaduan WHERE id='$id'");

// kembali ke list
header("Location: pengaduan_masuk.php");
exit;
