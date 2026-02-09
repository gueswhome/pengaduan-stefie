<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['nis'])) {
    header("Location: ../index.php");
    exit;
}

$id  = $_GET['id'] ?? '';
$nis = $_SESSION['nis'];

$query = mysqli_query($conn, "
    SELECT 
        pengaduan.*,
        jenis_pengaduan.nama AS jenis_nama
    FROM pengaduan
    JOIN jenis_pengaduan ON pengaduan.jenis_id = jenis_pengaduan.id
    WHERE pengaduan.id='$id' AND pengaduan.nis='$nis'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan');history.back();</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f9fafb;
            font-family: 'Inter', sans-serif;
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,.05);
        }
        .badge-belum { background:#9ca3af; }
        .badge-terbaca { background:#3b82f6; }
        .badge-selesai { background:#10b981; }

        .foto-thumb {
            width: 180px;
            height: 180px;
            object-fit: cover;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,.15);
        }
        .foto-thumb:hover {
            transform: scale(1.05);
        }
        .foto-modal {
            width: 100%;
            border-radius: 14px;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <a href="dashboard.php" class="btn btn-outline-secondary mb-4">
        ← Kembali
    </a>

    <div class="card p-4">

        <h4 class="fw-bold mb-3">📄 Detail Pengaduan</h4>

        <table class="table table-borderless">
            <tr>
                <th width="200">Jenis Pengaduan</th>
                <td><?= htmlspecialchars($data['jenis_nama']); ?></td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    <?php if ($data['status'] == 'belum'): ?>
                        <span class="badge badge-belum">Belum Dibaca</span>
                    <?php elseif ($data['status'] == 'terbaca'): ?>
                        <span class="badge badge-terbaca">Sedang Diproses</span>
                    <?php else: ?>
                        <span class="badge badge-selesai">Sudah Dilaksanakan</span>
                    <?php endif; ?>
                </td>
            </tr>

            <tr>
                <th>Dikirim Pada</th>
                <td><?= date('d M Y H:i', strtotime($data['created_at'])); ?></td>
            </tr>

            <tr>
                <th>Dibaca Pada</th>
                <td><?= $data['dibaca_at'] ? date('d M Y H:i', strtotime($data['dibaca_at'])) : '-' ?></td>
            </tr>

            <tr>
                <th>Selesai Pada</th>
                <td><?= $data['selesai_at'] ? date('d M Y H:i', strtotime($data['selesai_at'])) : '-' ?></td>
            </tr>
        </table>

        <hr>

        <h6 class="fw-semibold">Isi Pengaduan</h6>
        <p style="white-space:pre-line;">
            <?= htmlspecialchars($data['isi_pengaduan']); ?>
        </p>

    
        <?php if (!empty($data['foto'])): ?>
            <hr>
            <h6 class="fw-semibold">Foto Pendukung</h6>
            <img 
                src="../uploads/<?= htmlspecialchars($data['foto']); ?>" 
                class="foto-thumb mt-2"
                data-bs-toggle="modal"
                data-bs-target="#modalFotoLaporan"
            >
        <?php else: ?>
            <hr>
            <p class="text-muted fst-italic">Tidak ada foto pendukung</p>
        <?php endif; ?>

   
        <?php if ($data['status'] == 'selesai'): ?>
            <hr>
            <h6 class="fw-semibold text-success">📸 Bukti Penyelesaian dari Admin</h6>

            <?php if (!empty($data['bukti_selesai'])): ?>
                <img 
                    src="../uploads/bukti/<?= htmlspecialchars($data['bukti_selesai']) ?>" 
                    class="foto-thumb mt-2"
                    data-bs-toggle="modal"
                    data-bs-target="#modalBuktiSelesai"
                >
            <?php else: ?>
                <p class="text-muted fst-italic">
                    Bukti penyelesaian belum diupload oleh admin.
                </p>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</div>


<div class="modal fade" id="modalFotoLaporan" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 rounded-4">
      <div class="modal-header">
        <h5 class="modal-title">📷 Foto Pendukung</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img src="../uploads/<?= htmlspecialchars($data['foto']); ?>" class="foto-modal">
      </div>
    </div>
  </div>
</div>


<?php if (!empty($data['bukti_selesai'])): ?>
<div class="modal fade" id="modalBuktiSelesai" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 rounded-4">
      <div class="modal-header">
        <h5 class="modal-title">✅ Bukti Penyelesaian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img src="../uploads/bukti/<?= htmlspecialchars($data['bukti_selesai']); ?>" class="foto-modal">
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
