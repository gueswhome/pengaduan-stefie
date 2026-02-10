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

// cek pengaduan TERAKHIR
$qpengaduan = mysqli_query($conn, "
    SELECT status 
    FROM pengaduan 
    WHERE nis='$nis'
    ORDER BY id DESC
    LIMIT 1
");

if (mysqli_num_rows($qpengaduan) > 0) {
    $p = mysqli_fetch_assoc($qpengaduan);

    // 🔒 FIX UTAMA: trim + lowercase
    $status = strtolower(trim($p['status']));

 $map = [
    'masuk' => [
        'Masuk',
        'color:#ca8a04;font-weight:600;'
    ],
    'dilihat' => [
        'Dilihat',
        'color:#2563eb;font-weight:600;'
    ],
    'terbaca' => [ // ⬅️ TAMBAHAN INI
        'Dilihat',
        'color:#2563eb;font-weight:600;'
    ],
    'selesai' => [
        'Selesai',
        'color:#be185d;font-weight:600;'
    ],
];



    if (isset($map[$status])) {
        [$text, $style] = $map[$status];
    } else {
        $text  = ucfirst($status);
        $style = 'color:#6b7280;font-weight:600;';
    }

    $_SESSION['error'] = "
        Data siswa tidak bisa dihapus karena masih memiliki pengaduan
        <span style='$style'>($text)</span>
    ";

    header("Location: data_siswa.php");
    exit;
}

// ✅ TIDAK ADA PENGADUAN → BOLEH HAPUS
mysqli_query($conn, "DELETE FROM siswa WHERE id='$id'");
$_SESSION['success'] = "Data siswa berhasil dihapus";

header("Location: data_siswa.php");
exit;
