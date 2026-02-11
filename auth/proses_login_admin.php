<?php
session_start();
include "../config/koneksi.php";

// Ambil input dari form
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = $_POST['password'];

// Ambil data admin dari database
$query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");

if (mysqli_num_rows($query) === 1) {
    $admin = mysqli_fetch_assoc($query);

    // Cek password
    if (password_verify($password, $admin['password'])) {
        // Simpan session sebagai array ✅
        $_SESSION['admin'] = [
            'id' => $admin['id'],
            'username' => $admin['username'],
            'nama' => $admin['nama'],
            'role' => $admin['role'] // 'super' atau 'admin'
        ];

        // Redirect ke dashboard
        header("Location: ../admin/dashboard.php");
        exit;
    } else {
        // Password salah
        echo "<script>alert('Password salah'); window.location='login_admin.php';</script>";
        exit;
    }
} else {
    // Username tidak ditemukan
    echo "<script>alert('Username tidak ditemukan'); window.location='login_admin.php';</script>";
    exit;
}
?>
