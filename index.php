<?php
include 'config/koneksi.php';

// Ambil data guru & jenis pengaduan
$query = mysqli_query(
    $conn,
    "SELECT * FROM jenis_pengaduan ORDER BY id DESC"
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaduan SMK Wira Harapan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="inex.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

</head>

<body>

<div class="overlay">
 <nav id="navbar" class="navbar navbar-expand-lg navbar-dark navbar-custom px-4">
    <div class="container-fluid">

        <a class="navbar-brand d-flex align-items-center gap-2" href="#">
            <img
                src="https://yayasanharapanbali.or.id/wp-content/uploads/2024/12/logo-harapan-new-150x150.png"
                alt="Logo Yayasan Harapan Bali"
                style="height:40px; width:auto;"
            >
            <span class="fw-semibold">SMK Wira Harapan</span>
        </a>

    </div>
</nav>



    <div class="hero">
        <div class="text-center">
            <h1 class="display-4 fw-bold mb-3">Pengaduan SMK Wira Harapan</h1>
            <p class="lead mb-4">Sampaikan laporan dan keluhan dengan mudah dan aman</p>

            <button
                type="button"
                class="btn btn-primary px-5 py-2 shadow rounded-pill btn-masuk"
                data-bs-toggle="modal"
                data-bs-target="#loginModal">
                Masuk
            </button>
        </div>
    </div>
</div>

<section class="card-section" id="pengaduan">
    <h2 class="section-title">Guru Penanggung Jawab Pengaduan</h2>

    <div class="card-wrapper">

        <?php if (mysqli_num_rows($query) > 0) { ?>
    <?php while ($row = mysqli_fetch_assoc($query)) { ?>

        <?php
        if (!empty($row['foto_guru'])) {
            $foto = str_starts_with($row['foto_guru'], 'http')
                ? $row['foto_guru']
                : "uploads/guru/" . $row['foto_guru'];
        } else {
            $foto = "assets/img/default.png";
        }
        ?>

        <div class="card-custom">
            <div class="card-top">
                <img src="<?= $foto ?>" alt="Foto Guru">
            </div>
            <div class="card-body">
                <h5><?= htmlspecialchars($row['nama_guru']) ?></h5>
                <p><?= htmlspecialchars($row['jenis_pengaduan_baru']) ?></p>
            </div>
        </div>

    <?php } ?>
<?php } else { ?>
    <p class="text-center text-muted">Belum ada data pengaduan.</p>
<?php } ?>


    </div>
</section>

<section class="vision-mission" id="visi-misi">
    <div class="vision-box">
        <h3>VISI</h3>
        <p>“Berkualitas dan Berdaya Saing Global”</p>
    </div>

    <div class="mission-box">
        <h3>MISI</h3>
        <ul>
            <li>Meningkatkan profesionalisme pendidik dan kependidikan</li>
            <li>Mewujudkan sikap jujur dan berkarakter Pancasila</li>
            <li>Memfasilitasi sarana sesuai perkembangan teknologi</li>
            <li>Memberikan pelayanan pendidikan yang bersahaja</li>
            <li>Membangun jejaring nasional & internasional</li>
            <li>Pendidikan berbudaya & ramah lingkungan</li>
            <li>Tata kelola berintegritas</li>
        </ul>
    </div>
</section>

<script>
window.addEventListener('scroll', () => {
    document.getElementById('navbar')
        .classList.toggle('navbar-scrolled', window.scrollY > 50);
});
</script>

<!-- MODAL LOGIN -->
<div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">

            <div class="modal-header border-0 text-center">
                <h5 class="modal-title w-100 fw-bold">Masukkan NIS Anda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="auth/cek_nis.php" method="POST">
                <div class="modal-body px-4 pb-4 text-center">
                    <p class="text-muted mb-3">Gunakan NIS untuk melanjutkan</p>

                    <div class="mb-4">
                        <input
                            type="text"
                            name="nis"
                            class="form-control form-control-lg text-center"
                            placeholder="Contoh: 3789"
                            required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill">
                        Masuk
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<footer class="footer">
    <div class="container">
        <div class="row">

            <div class="col-md-4 mb-4">
                <h5>SMKS Wira Harapan</h5>
                <p>Sekolah berkomitmen mencetak generasi berdaya saing global.</p>
            </div>

            <div class="col-md-4 mb-4">
                <h5>Menu</h5>
                <ul>
                    <li><a href="#">Beranda</a></li>
                    <li><a href="#pengaduan">Pengaduan</a></li>
                    <li><a href="#visi-misi">Visi & Misi</a></li>
                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</a></li>
                </ul>
            </div>

            <div class="col-md-4 mb-4">
                <h5>Kontak</h5>
                <ul>
                    <li>Kabupaten Badung, Bali</li>
                    <li>Email: info@smkwiraharapan.sch.id</li>
                    <li>Telp: (0361) XXXXXXX</li>
                </ul>
            </div>

        </div>

        <div class="footer-bottom">
            © 2026 SMKS Wira Harapan. All rights reserved.
        </div>
    </div>
</footer>

</body>
</html>
