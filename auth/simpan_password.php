<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['nis'])) {
    header("Location: ../index.php");
    exit;
}

$password   = $_POST['password'];
$konfirmasi = $_POST['konfirmasi'];

if ($password !== $konfirmasi) {
    echo "<script>
        alert('Konfirmasi password tidak sama!');
        window.location.href='buat_password.php';
    </script>";
    exit;
}

// ENKRIPSI PASSWORD
$hash = password_hash($password, PASSWORD_DEFAULT);

// SIMPAN KE DATABASE
$nis = $_SESSION['nis'];
mysqli_query($conn, "UPDATE siswa SET password='$hash' WHERE nis='$nis'");

// setelah sukses → arahkan ke login
echo "<script>
    alert('Password berhasil dibuat. Silakan login.');
    window.location.href='login_siswa.php';
</script>";
