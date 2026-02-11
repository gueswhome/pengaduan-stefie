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

mysqli_query($conn, "DELETE FROM jenis_pengaduan WHERE id='$id'");

header("Location: tambah_jenis_pengaduan.php?status=hapus");
exit;
