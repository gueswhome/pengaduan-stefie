<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaduan SMK Wira Harapan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html, body {
            overflow-x: hidden;
        }

        body {
            background: url('assets/img/bg.jpeg') no-repeat center center fixed;
            background-size: cover;
        }

        body.modal-open {
    padding-right: 0 !important;
}

     
        .overlay {
            min-height: 100vh;
            background: rgba(0,0,0,0.6);
            display: flex;
            flex-direction: column;
        }

      .hero {
    flex: 1;
    min-height: calc(100vh - 50px); /* tinggi layar dikurangi navbar */
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: white;
    padding: 0 15px;
}


        /* Navbar */
.navbar-custom {
    background: rgba(31, 41, 55, 0.6); 
    backdrop-filter: blur(8px);
    transition: background 0.3s ease;
}

.navbar-scrolled {
    background: #1f2937 !important; 
}

       
        section {
            padding: 90px 20px;
        }

        .section-title {
            font-weight: 700;
            margin-bottom: 50px;
            text-align: center;
        }

        
        .card-section {
            background: #f2f2f2;
            text-align: center;
        }

        .card-wrapper {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            max-width: 1300px;
            margin: auto;
        }

        .card-custom {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card-custom:hover {
            transform: translateY(-8px);
        }

        .card-top {
            background: #4a74f5;
            padding: 30px;
            display: flex;
            justify-content: center;
        }

        .card-top img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 3px solid white;
            object-fit: cover;
        }

        .card-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        
        .vision-mission {
            background: #ffffff;
        }

        .vision-box {
            max-width: 900px;
            margin: auto;
            text-align: center;
            margin-bottom: 70px;
        }

        .vision-box h3 {
            color: #4a74f5;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .vision-box p {
            font-size: 24px;
            font-weight: 600;
        }

        .mission-box {
            max-width: 900px;
            margin: auto;
        }

        .mission-box h3 {
            font-weight: 700;
            margin-bottom: 25px;
            text-align: center;
        }

        .mission-box ul {
            list-style: none;
            padding-left: 0;
        }

        .mission-box li {
            padding: 15px 0;
            border-bottom: 1px solid #e5e5e5;
            font-size: 16px;
        }

        .mission-box li:last-child {
            border-bottom: none;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .card-wrapper {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .card-wrapper {
                grid-template-columns: 1fr;
            }

            .vision-box p {
                font-size: 20px;
            }
        }

      
.footer {
    background: #1f2937;
    color: #e5e7eb;
    padding: 60px 20px 30px;
}

.footer h5 {
    font-weight: 600;
    margin-bottom: 15px;
    color: #ffffff;
}

.footer p,
.footer li {
    font-size: 14px;
    color: #d1d5db;
}

.footer ul {
    list-style: none;
    padding: 0;
}

.footer ul li {
    margin-bottom: 8px;
}

.footer a {
    color: #d1d5db;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer a:hover {
    color: #ffffff;
}

.footer-bottom {
    border-top: 1px solid rgba(255,255,255,0.1);
    margin-top: 40px;
    padding-top: 20px;
    text-align: center;
    font-size: 13px;
    color: #9ca3af;
}

.btn-masuk {
    background-color: #1e40af; 
    border: none;
}

.btn-masuk:hover {
    background-color: #1e3a8a; 
}


    </style>
</head>

<body>

<div class="overlay">
    <nav id="navbar" class="navbar navbar-expand-lg navbar-dark navbar-custom px-4">
        <a class="navbar-brand" href="#">SMK WIRA HARAPAN</a>
        <div class="ms-auto">
        </div>
    </nav>


    <div class="hero">
    <div class="text-center">

        <h1 class="display-4 fw-bold mb-3">
            Pengaduan SMK Wira Harapan
        </h1>

        <p class="lead mb-4">
            Sampaikan laporan dan keluhan dengan mudah dan aman
        </p>

 
    <button
    type="button"
    class="btn btn-primary px-5 py-2 shadow rounded-pill btn-masuk"
    data-bs-toggle="modal"
    data-bs-target="#loginModal">
    Masuk
</button>

    </div>
</div>

<section class="card-section" id="pengaduan">
    <h2 class="section-title">Guru Penanggung Jawab Pengaduan</h2>

    <div class="card-wrapper">
        <div class="card-custom">
            <div class="card-top">
                <img src="assets/img/timoty.jpg">
            </div>
            <div class="card-body">
                <h5>Timoti Adri Mahendra Putra, S.Kom., M.Kom</h5>
                <p>Pengaduan Akademik & Nilai</p>
            </div>
        </div>

        <div class="card-custom">
            <div class="card-top">
                <img src="assets/img/aryati.jpg">
            </div>
            <div class="card-body">
                <h5>Ni Luh Putu Aryati, SH., S.Pd</h5>
                <p>Pengaduan Disiplin Siswa</p>
            </div>
        </div>

        <div class="card-custom">
            <div class="card-top">
                <img src="assets/img/ari.jpg">
            </div>
            <div class="card-body">
                <h5>I Gede Ari Supriyanto, S.Pd</h5>
                <p>Kerusakan Sarana & Peralatan</p>
            </div>
        </div>

        <div class="card-custom">
            <div class="card-top">
                <img src="assets/img/tri.jpg">
            </div>
            <div class="card-body">
                <h5>Ni Komang Tri Jayanthi, S.Pd.Gr</h5>
                <p>Pengaduan Perundungan</p>
            </div>
        </div>
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
            <li>Meningkatkan profesionalisme pendidik dan kependidikan dalam pembelajaran abad 21 melalui pendekatan kompetensi 4C</li>
            <li>Mewujudkan sikap dan perilaku jujur, beriman, dan berkarakter Pancasila</li>
            <li>Memfasilitasi sarana dan prasarana sesuai perkembangan teknologi</li>
            <li>Memberikan pelayanan pendidikan yang bersahaja</li>
            <li>Membangun jejaring dalam lingkup nasional dan internasional</li>
            <li>Melaksanakan pendidikan berbudaya dan ramah lingkungan</li>
            <li>Mewujudkan tata kelola satuan pendidikan yang berintegritas</li>
        </ul>
    </div>
</section>

<script>
window.addEventListener('scroll', () => {
    document.getElementById('navbar')
        .classList.toggle('navbar-scrolled', window.scrollY > 50);
});
</script>

<div class="modal fade" id="loginModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">

      <div class="modal-header border-0 text-center">
        <h5 class="modal-title w-100 fw-bold">Masukkan NIS Anda</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="auth/cek_nis.php" method="POST">
        <div class="modal-body px-4 pb-4 text-center">

          <p class="text-muted mb-3">
            Gunakan NIS untuk melanjutkan ke pengaduan
          </p>

          <div class="mb-4">
            <input
              type="text"
              name="nis"
              class="form-control form-control-lg text-center"
              placeholder="Contoh: 3789"
              required
            >
          </div>

          <!-- BUTTON MASUK -->
          <button
            type="submit"
            class="btn btn-primary w-100 py-2 rounded-pill btn-masuk">
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
                <p>
                    SMKS Wira Harapan hadir sebagai lembaga pendidikan yang
                    berkomitmen mencetak generasi berkualitas dan berdaya saing global.
                </p>
            </div>

         
            <div class="col-md-4 mb-4">
                <h5>Menu</h5>
               <ul>
    <li><a href="#">Beranda</a></li>
    <li><a href="#pengaduan">Pengaduan</a></li>
    <li><a href="#visi-misi">Visi & Misi</a></li>
  <li>
  <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
    Masuk
  </a>
</li>


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
