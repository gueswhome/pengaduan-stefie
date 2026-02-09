<?php
session_start();
include '../config/koneksi.php';

// proteksi admin
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

// ambil data
$id = $_GET['id'] ?? '';
$status = $_GET['status'] ?? '';

// validasi status
$allowed_status = ['belum', 'terbaca', 'selesai'];
if (!in_array($status, $allowed_status)) {
    die('Status tidak valid');
}

// logic update + timestamp
if ($status == 'terbaca') {
    mysqli_query($conn, "
        UPDATE pengaduan 
        SET status='terbaca', dibaca_at = NOW()
        WHERE id='$id'
    ");
} 
elseif ($status == 'selesai') {
    mysqli_query($conn, "
        UPDATE pengaduan 
        SET status='selesai', selesai_at = NOW()
        WHERE id='$id'
    ");
} 
else {
    mysqli_query($conn, "
        UPDATE pengaduan 
        SET status='belum'
        WHERE id='$id'
    ");
}

// balik ke halaman sebelumnya
header("Location: pengaduan_masuk.php");
exit;
