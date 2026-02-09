<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['nis'])) {
    header("Location: ../index.php");
    exit;
}

$id = $_GET['id'];
$nis = $_SESSION['nis'];

mysqli_query($conn, "
    DELETE FROM pengaduan 
    WHERE id='$id' AND nis='$nis'
");

header("Location: dashboard.php");
