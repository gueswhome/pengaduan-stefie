<?php
session_start();
include "../config/koneksi.php";

$username = $_POST['username'];
$password = md5($_POST['password']);

$query = mysqli_query($conn, "SELECT * FROM admin 
    WHERE username='$username' AND password='$password'");

if (mysqli_num_rows($query) > 0) {
    $_SESSION['admin'] = $username;
    header("Location: ../admin/dashboard.php");
    exit;
} else {
    echo "<script>alert('Login gagal'); window.location='login_admin.php';</script>";
}
?>
