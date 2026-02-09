<?php
$conn = mysqli_connect("localhost", "root", "", "pengaduan_sekolah");

if (!$conn) {
    die("Koneksi database gagal");
}

mysqli_query($conn, "SET time_zone = '+08:00'");
?>
