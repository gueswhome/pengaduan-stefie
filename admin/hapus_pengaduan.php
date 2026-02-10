<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

include '../config/koneksi.php';

$id   = $_GET['id'] ?? '';
$from = $_GET['from'] ?? 'masuk';

if (!$id) {
    header("Location: pengaduan_masuk.php");
    exit;
}

/* hapus data (sementara masih delete keras) */
mysqli_query($conn, "DELETE FROM pengaduan WHERE id='$id'");

/* session buat SweetAlert */
$_SESSION['success'] = "Pengaduan berhasil dihapus";

/* redirect BALIK ke halaman asal */
switch ($from) {
    case 'dilihat':
        header("Location: pengaduan_dilihat.php");
        break;

    case 'selesai':
        header("Location: pengaduan_selesai.php");
        break;

    default:
        header("Location: pengaduan_masuk.php");
}

exit;
