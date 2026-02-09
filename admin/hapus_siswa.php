<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

include '../config/koneksi.php';

$id = $_GET['id'] ?? '';

if ($id) {
    mysqli_query($conn, "DELETE FROM siswa WHERE id='$id'");
    
    $_SESSION['success'] = "Data siswa berhasil dihapus";
}

header("Location: data_siswa.php");
exit;
