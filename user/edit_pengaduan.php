<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['nis'])) {
    header("Location: ../index.php");
    exit;
}

$nis = $_SESSION['nis'];
$id = $_GET['id'] ?? '';

// Ambil data pengaduan
$query = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id='$id' AND nis='$nis'");
if(mysqli_num_rows($query) == 0){
    die("Pengaduan tidak ditemukan atau tidak bisa diedit.");
}
$data = mysqli_fetch_assoc($query);

// Inisialisasi variabel untuk form
$isi_pengaduan = $data['isi_pengaduan'] ?? '';
$jenis_id_selected = $data['jenis_id'] ?? '';
$error = '';
$success = false;

// Proses submit edit
if(isset($_POST['submit'])){
    $jenis_id = $_POST['jenis_id'] ?? '';
    $isi_pengaduan = $_POST['isi_pengaduan'] ?? '';

    // jika ada foto baru
    $foto_sql = '';
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){
        $foto_name = time() . '_' . basename($_FILES['foto']['name']);
        $foto_tmp = $_FILES['foto']['tmp_name'];

        if(move_uploaded_file($foto_tmp, "../uploads/$foto_name")){
            if(!empty($data['foto']) && file_exists("../uploads/".$data['foto'])){
                @unlink("../uploads/".$data['foto']);
            }
            $foto_sql = ", foto='$foto_name'";
        } else {
            $error = "Gagal mengupload foto.";
        }
    }

    // update database jika tidak ada error
    if(empty($error)){
        $update = mysqli_query($conn, "
            UPDATE pengaduan 
            SET jenis_id='$jenis_id', isi_pengaduan='$isi_pengaduan' $foto_sql
            WHERE id='$id' AND nis='$nis'
        ");

        if($update){
            $success = true; // tanda sukses
        } else {
            $error = "Gagal mengupdate pengaduan.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container py-5">
    <h4>Edit Pengaduan</h4>

    <?php if(!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Jenis Pengaduan</label>
            <select name="jenis_id" class="form-control">
                <?php
                $jenis = mysqli_query($conn, "SELECT * FROM jenis_pengaduan");
                while($j = mysqli_fetch_assoc($jenis)):
                ?>
                <option value="<?= $j['id']; ?>" <?= $j['id']==$jenis_id_selected?'selected':''; ?>>
                    <?= htmlspecialchars($j['jenis_pengaduan_baru']); ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Isi Pengaduan</label>
            <textarea name="isi_pengaduan" class="form-control" rows="5"><?= htmlspecialchars($isi_pengaduan); ?></textarea>
        </div>

        <div class="mb-3">
            <label>Foto (opsional)</label><br>
            <?php if(!empty($data['foto']) && file_exists("../uploads/".$data['foto'])): ?>
                <img src="../uploads/<?= htmlspecialchars($data['foto']); ?>" alt="" width="100"><br>
            <?php endif; ?>
            <input type="file" name="foto" class="form-control mt-1">
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Update</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php if($success): ?>
<script>
// SweetAlert2 toast notif di pojok kanan atas
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: 'Pengaduan berhasil diperbarui!',
    showConfirmButton: false,
    timer: 2500,
    timerProgressBar: true
}).then(() => {
    // redirect ke dashboard setelah notif
    window.location.href = 'dashboard.php';
});
</script>
<?php endif; ?>

</body>
</html>
