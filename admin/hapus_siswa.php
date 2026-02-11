<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

include '../config/koneksi.php';

$id = $_GET['id'] ?? '';
if (!$id) {
    header("Location: data_siswa.php");
    exit;
}

// ambil NIS siswa
$qsiswa = mysqli_query($conn, "SELECT nis FROM siswa WHERE id='$id'");
$siswa  = mysqli_fetch_assoc($qsiswa);

if (!$siswa) {
    header("Location: data_siswa.php");
    exit;
}

$nis = $siswa['nis'];

// ambil semua pengaduan siswa
$qpengaduan = mysqli_query($conn, "
    SELECT status 
    FROM pengaduan 
    WHERE nis='$nis'
    ORDER BY id DESC
");

if (mysqli_num_rows($qpengaduan) > 0) {
    $statuses = [];
    
    // map status → teks + warna
    $map = [
        'masuk'    => ['Pengaduan Masuk', 'color:#ca8a04;font-weight:600;'], // kuning
        'belum'    => ['Pengaduan Masuk', 'color:#ca8a04;font-weight:600;'], // alias
        'dilihat'  => ['Dilihat', 'color:#2563eb;font-weight:600;'],        // biru
        'terbaca'  => ['Dilihat', 'color:#2563eb;font-weight:600;'],        // biru
        'selesai'  => ['Selesai', 'color:#16a34a;font-weight:600;'],        // hijau
    ];

    while ($p = mysqli_fetch_assoc($qpengaduan)) {
        $status_key = strtolower(trim($p['status']));
        if (isset($map[$status_key])) {
            $statuses[] = "<span style='{$map[$status_key][1]}'>({$map[$status_key][0]})</span>";
        } else {
            $statuses[] = "<span style='color:#6b7280;font-weight:600;'>(" . ucfirst($status_key) . ")</span>";
        }
    }


    $status_text = implode(' / ', array_reverse($statuses)); 


    $_SESSION['error'] = "
        Data siswa tidak bisa dihapus karena masih memiliki pengaduan
        $status_text
    ";

    header("Location: data_siswa.php");
    exit;
}


mysqli_query($conn, "DELETE FROM siswa WHERE id='$id'");
$_SESSION['success'] = "Data siswa berhasil dihapus";

header("Location: data_siswa.php");
exit;
