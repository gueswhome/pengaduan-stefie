<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

$alert = "";
$alertType = "";
$alertMsg = "";

if (isset($_POST['simpan'])) {
    $nis   = $_POST['nis'];
    $nama  = $_POST['nama'];
    $kelas = $_POST['kelas'];

    $cek = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$nis'");

    if (mysqli_num_rows($cek) > 0) {
        $alert = "showAlert";
        $alertType = "error";
        $alertMsg = "NIS sudah terdaftar!";
    } else {
       mysqli_query($conn, "
    INSERT INTO siswa (nis, nama, kelas, password)
    VALUES ('$nis', '$nama', '$kelas', NULL)
");

        $alert = "showAlert";
        $alertType = "success";
        $alertMsg = "Siswa berhasil ditambahkan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Siswa</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
        }

        .card {
            width: 400px;
            background: white;
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            margin: 80px auto;
        }

        /* BUTTON KEMBALI MODERN */
        .btn-kembali {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            padding: 10px 16px;
            border-radius: 12px;
            background: linear-gradient(135deg, #e0e7ff, #f8fafc);
            color: #334155;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .btn-kembali span {
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .btn-kembali:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            background: linear-gradient(135deg, #c7d2fe, #e0f2fe);
        }

        .btn-kembali:hover span {
            transform: translateX(-4px);
        }

        h3 {
            text-align: center;
            margin-bottom: 25px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            outline: none;
        }

        input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 2px rgba(99,102,241,0.2);
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79,70,229,0.4);
        }
    </style>
</head>
<body>

<div class="card">

    <!-- BUTTON KEMBALI -->
    <a href="../admin/dashboard.php" class="btn-kembali">
        <span>←</span> Kembali ke Dashboard
    </a>

    <h3>Tambah Data Siswa</h3>

    <form method="POST">
        <input type="text" name="nis" placeholder="NIS" required>
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <input type="text" name="kelas" placeholder="Kelas" required>
        <button name="simpan">Simpan</button>
    </form>
</div>

<script>
<?php if ($alert == "showAlert") { ?>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: '<?= $alertType ?>',
        title: '<?= $alertMsg ?>',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
<?php } ?>
</script>

</body>
</html>
