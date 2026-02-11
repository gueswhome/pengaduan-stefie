<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

include "../config/koneksi.php";

$query = mysqli_query($conn, "
    SELECT 
        pengaduan.id,
        pengaduan.nis,
        pengaduan.status,
        pengaduan.created_at,
        siswa.nama,
        siswa.kelas,
        jenis_pengaduan.jenis_pengaduan_baru AS jenis_pengaduan
    FROM pengaduan
    JOIN siswa 
        ON pengaduan.nis = siswa.nis
    LEFT JOIN jenis_pengaduan 
        ON pengaduan.jenis_id = jenis_pengaduan.id
    WHERE pengaduan.status = 'selesai'
    ORDER BY pengaduan.created_at DESC
");

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Pengaduan Selesai</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>

body{
    font-family:'Inter',sans-serif;
    background:#f1f5f9;
}

.main{
    margin-left:260px;
    padding:30px;
}

.page-header{
    display:flex;
    align-items:center;
    gap:15px;
    background:white;
    padding:18px 22px;
    border-radius:14px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
    margin-bottom:25px;
}

/* DEFAULT (boleh biru / netral) */
.page-header .icon{
    width:45px;
    height:45px;
    border-radius:12px;
    background:linear-gradient(135deg,#3b82f6,#2563eb);
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:20px;
}


.page-header.selesai .icon{
    background:linear-gradient(135deg,#ec4899,#db2777);
}


.page-header .title{
    font-size:18px;
    font-weight:600;
    margin:0;
}

.card{
    border:none;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}

.table td,
.table th{
    vertical-align:middle;
}

.text-wrap-custom{
    max-width:220px;
    word-wrap:break-word;
}

.action-btns a{
    margin:2px;
}

</style>

</head>

<body>

<?php include "sidebar.php"; ?>

<div class="main">

  <div class="page-header selesai">


        <div class="icon">
            <i class="bi bi-check-circle"></i>
        </div>

        <h1 class="title">
            Pengaduan Selesai
        </h1>

    </div>


    <div class="card p-4">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jenis Pengaduan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>

                </thead>


                <tbody>

                <?php $no=1; while($row=mysqli_fetch_assoc($query)): ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td><?= htmlspecialchars($row['nis']) ?></td>

                    <td class="text-wrap-custom">
                        <?= htmlspecialchars($row['nama']) ?>
                    </td>

                    <td><?= htmlspecialchars($row['kelas']) ?></td>

                    <td class="text-wrap-custom">
                        <?= htmlspecialchars($row['jenis_pengaduan'] ?? '-') ?>
                    </td>

                    <td>
                        <?= date('d M Y', strtotime($row['created_at'])) ?>
                    </td>

                    <td>
                        <span class="badge bg-success">
                            Selesai
                        </span>
                    </td>

                    <td class="action-btns">

                        <a href="detail_pengaduan.php?id=<?= $row['id'] ?>"
                           class="btn btn-sm btn-info text-white">
                           <i class="bi bi-eye"></i>
                        </a>

                        <button class="btn btn-sm btn-success" disabled>
                           <i class="bi bi-check-circle"></i>
                        </button>

                      <a href="hapus_pengaduan.php?id=<?= $row['id'] ?>&from=selesai"
   class="btn btn-sm btn-danger"
   onclick="return confirm('Yakin ingin menghapus pengaduan ini?')">
   <i class="bi bi-trash"></i>
</a>


                    </td>

                </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <?php if (isset($_SESSION['success'])): ?>
    <script>
    Swal.fire({
      toast: true,
      position: 'top-end',
      icon: 'success',
      title: '<?= $_SESSION['success'] ?>',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true
    });
    </script>
    <?php unset($_SESSION['success']); endif; ?>

</body>
</html>
