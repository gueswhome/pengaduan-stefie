<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

include '../config/koneksi.php';

// TAMBAH DATA
if (isset($_POST['simpan'])) {

    $nama_pengaduan = mysqli_real_escape_string($conn, $_POST['nama_pengaduan']);
    $nama_guru = mysqli_real_escape_string($conn, $_POST['nama_guru']);

    $foto_guru = "";

    $file_foto = $_FILES['foto_guru']['name'];
    $link_foto = $_POST['foto_guru_link'];


    // PRIORITAS 1: UPLOAD FILE
    if (!empty($file_foto)) {

        $ext = pathinfo($file_foto, PATHINFO_EXTENSION);
        $namaFile = time() . '_' . rand(100,999) . '.' . $ext;

        move_uploaded_file(
            $_FILES['foto_guru']['tmp_name'],
            "../uploads/guru/" . $namaFile
        );

        $foto_guru = $namaFile;

    // PRIORITAS 2: LINK FOTO
    } elseif (!empty($link_foto)) {

        $foto_guru = mysqli_real_escape_string(
            $conn,
            $link_foto
        );
    }

    // SIMPAN DATA KE DATABASE
    mysqli_query($conn,
        "INSERT INTO jenis_pengaduan 
        (jenis_pengaduan_baru, nama_guru, foto_guru)
        VALUES 
        ('$nama_pengaduan', '$nama_guru', '$foto_guru')"
    );

    header("Location: tambah_jenis_pengaduan.php?status=tambah");
    exit;
}



// AMBIL DATA
$data = mysqli_query($conn, "SELECT * FROM jenis_pengaduan ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Jenis Pengaduan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: #f4f6f9;
        }
        .card {
            border-radius: 18px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .form-control {
            border-radius: 12px;
        }
        .btn {
            border-radius: 12px;
            padding: 8px 16px;
        }
        .table thead th {
            font-weight: 600;
            background: #f8fafc;
        }
        .badge-guru {
            background: #eef2ff;
            color: #4338ca;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <!-- HEADER -->
            <div class="mb-4">
                <h4 class="fw-bold mb-1">Manajemen Jenis Pengaduan</h4>
                <p class="text-muted mb-0">Kelola jenis pengaduan dan guru penanggung jawab</p>
            </div>

         <!-- FORM -->
<div class="card p-4 mb-4">
    <h6 class="fw-semibold mb-3">Tambah Jenis Pengaduan</h6>

        <form method="POST" enctype="multipart/form-data" id="formTambah">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jenis Pengaduan</label>
                <input
                    type="text"
                    name="nama_pengaduan"
                    class="form-control"
                    placeholder="Contoh: Pengaduan Akademik & Nilai"
                    required
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Guru Penanggung Jawab</label>
                <input
                    type="text"
                    name="nama_guru"
                    class="form-control"
                    placeholder="Contoh: Timoti Adri Mahendra Putra, S.Kom., M.Kom"
                    required
                >
            </div>

            <!-- FOTO GURU -->
           <div class="col-md-12 mb-3">
    <label class="form-label">Foto Guru</label>

    <input
        type="file"
        name="foto_guru"
        class="form-control mb-2"
        accept="image/*"
    >

    <input
        type="url"
        name="foto_guru_link"
        class="form-control"
        placeholder="Atau masukkan link foto (https://...)"
    >

    <small class="text-muted">
        Bisa upload file ATAU pakai link (pilih salah satu)
    </small>
</div>

        </div>

        <div class="d-flex justify-content-between mt-2">
            <a href="dashboard.php" class="btn btn-light border">← Dashboard</a>
            <button type="submit" name="simpan" class="btn btn-primary">
                Simpan Data
            </button>
        </div>
    </form>
</div>

          <!-- TABEL -->
<div class="card p-4">
    <h6 class="fw-semibold mb-3">Daftar Jenis Pengaduan</h6>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">Foto</th>
                    <th>Jenis Pengaduan</th>
                    <th>Guru Penanggung Jawab</th>
                    <th width="20%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($data)) { ?>
                <tr>
                    <td><?= $no++ ?></td>

                    <!-- FOTO -->
                <td>
<?php
if (!empty($row['foto_guru'])) {
    $foto = str_starts_with($row['foto_guru'], 'http')
        ? $row['foto_guru']
        : "../uploads/guru/" . $row['foto_guru'];
} else {
    $foto = "../assets/img/default.png";
}
?>
    <img
        src="<?= $foto ?>"
        width="45"
        height="45"
        class="rounded-circle object-fit-cover border"
    >
</td>


                    <td class="fw-medium">
                        <?= htmlspecialchars($row['jenis_pengaduan_baru']) ?>
                    </td>

                    <td>
                        <?php if (!empty($row['nama_guru'])) { ?>
                            <span class="badge bg-primary">
                                <?= htmlspecialchars($row['nama_guru']) ?>
                            </span>
                        <?php } else { ?>
                            <span class="text-muted">Belum ditentukan</span>
                        <?php } ?>
                    </td>

                    <td class="text-center">
                        <a href="edit_jenis_pengaduan.php?id=<?= $row['id'] ?>"
                           class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm"
                                onclick="hapusData(<?= $row['id'] ?>)">
                            Hapus
                        </button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>


        </div>
    </div>
</div>


<script>
//hapus data
function hapusData(id) {
    Swal.fire({
        title: 'Yakin?',
        text: 'Data ini akan dihapus permanen',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'hapus_jenis_pengaduan.php?id=' + id;
        }
    });
}

//notif berhasil tambah/edit
<?php if (isset($_GET['status'])): ?>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: 'Data berhasil diproses',
    timer: 1800,
    showConfirmButton: false
});
<?php endif; ?>
</script>

<script>
// tangkap form
const form = document.getElementById('formTambah');

form.addEventListener('submit', function(e) {
    const fileFoto = document.querySelector('input[name="foto_guru"]').files[0];
    const linkFoto = document.querySelector('input[name="foto_guru_link"]').value.trim();

    if (fileFoto && linkFoto) {
        e.preventDefault(); // batalkan submit
        Swal.fire({
            icon: 'warning',
            title: 'Oops!',
            text: 'Anda memasukkan 2 foto sekaligus. Pilih salah satu saja (file ATAU link).',
            confirmButtonColor: '#f59e0b'
        });
        return false;
    }
});
</script>


</body>
</html>
