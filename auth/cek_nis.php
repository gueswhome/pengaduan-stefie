<?php
session_start();
include '../config/koneksi.php';

$nis = $_POST['nis'] ?? '';

if ($nis == '') {
    header("Location: ../index.php");
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM siswa WHERE nis = '$nis'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>
        alert('NIS tidak terdaftar!');
        window.location.href='../index.php';
    </script>";
    exit;
}

// simpan NIS dulu
$_SESSION['nis'] = $data['nis'];

// CEK PASSWORD
if ($data['password'] == NULL || $data['password'] == '') {
    // belum pernah buat password
    header("Location: buat_password.php");
} else {
    // sudah punya password
    header("Location: login_siswa.php");
}
exit;
