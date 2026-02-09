<?php
session_start();
include '../config/koneksi.php';

$nis      = $_POST['nis'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$nis'");
$data  = mysqli_fetch_assoc($query);

if ($data) {
    // cek password hash
    if (password_verify($password, $data['password'])) {

        $_SESSION['siswa'] = true;
        $_SESSION['nis']   = $data['nis'];
        $_SESSION['nama']  = $data['nama'];

        header("Location: ../user/dashboard.php");
        exit;
    }
}

// kalau gagal
echo "<script>
    alert('NIS atau Password salah!');
    window.location.href='login_siswa.php';
</script>";
