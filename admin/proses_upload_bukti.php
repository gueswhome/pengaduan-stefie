<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

if (!isset($_POST['id'])) {
    header("Location: pengaduan_masuk.php");
    exit;
}

$id = $_POST['id'];

if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] == 0) {

    // pastikan folder ada
    $folder = "../uploads/bukti/";
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $namaAsli = $_FILES['bukti']['name'];
    $tmp      = $_FILES['bukti']['tmp_name'];

    $namaFile = time() . "_" . $namaAsli;
    $path     = $folder . $namaFile;

    if (move_uploaded_file($tmp, $path)) {

        mysqli_query($conn, "
            UPDATE pengaduan SET
                bukti_selesai = '$namaFile',
                status = 'selesai',
                selesai_at = NOW()
            WHERE id = '$id'
        ");

        $redirect = $_POST['redirect'] ?? "detail_pengaduan.php?id=$id";

header("Location: $redirect");
exit;

    } else {
        echo "<script>alert('Upload gagal');history.back();</script>";
    }

} else {
    echo "<script>alert('Tidak ada file dipilih');history.back();</script>";
}
