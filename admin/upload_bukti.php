<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

include '../config/koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: pengaduan_masuk.php");
    exit;
}

$id = $_GET['id'];

$query = mysqli_query($conn, "
    SELECT id, status, bukti_selesai 
    FROM pengaduan 
    WHERE id='$id'
    LIMIT 1
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: pengaduan_masuk.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Bukti Selesai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .img-thumb {
            width: 180px;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.3s;
        }
        .img-thumb:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,.15);
        }
        .img-modal {
            width: 100%;
            border-radius: 14px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow rounded-4">
        <div class="card-body">

            <h5 class="mb-4">📸 Upload Bukti Penyelesaian</h5>

            <!-- JIKA BUKTI SUDAH ADA -->
            <?php if (!empty($data['bukti_selesai'])): ?>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Bukti yang sudah diupload</label><br>

                    <img 
                        src="../uploads/bukti/<?= htmlspecialchars($data['bukti_selesai']) ?>"
                        class="img-thumb"
                        data-bs-toggle="modal"
                        data-bs-target="#modalBukti"
                    >

                    <div class="text-muted small mt-2">
                        Pengaduan ini sudah diselesaikan
                    </div>
                </div>

                <!-- MODAL -->
                <div class="modal fade" id="modalBukti" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 rounded-4">
                            <div class="modal-header">
                                <h5 class="modal-title">✅ Bukti Penyelesaian</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img 
                                    src="../uploads/bukti/<?= htmlspecialchars($data['bukti_selesai']) ?>"
                                    class="img-modal"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <a href="pengaduan_masuk.php" class="btn btn-secondary mt-3">
                    Kembali
                </a>

            <!-- JIKA BUKTI BELUM ADA -->
            <?php else: ?>

                <form action="proses_upload_bukti.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $id ?>">

                    <div class="mb-3">
                        <label class="form-label">Foto Bukti</label>
                        <input 
                            type="file" 
                            name="bukti" 
                            class="form-control" 
                            accept="image/*"
                            required
                        >
                        <div class="text-muted small mt-1">
                            JPG / PNG / JPEG
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        ✔ Simpan & Tandai Selesai
                    </button>

                    <a href="pengaduan_masuk.php" class="btn btn-secondary">
                        Batal
                    </a>
                </form>

            <?php endif; ?>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
