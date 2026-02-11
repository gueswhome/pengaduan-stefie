<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current = basename($_SERVER['PHP_SELF']);
?>

<style>

/* Sidebar modern sesuai desain */
.sidebar{
    width:260px;
    min-height:100vh;
    background:linear-gradient(180deg,#1f2937,#111827);
    color:#fff;
    position:fixed;
    padding:25px 20px;
    border-radius:0 20px 20px 0;
}

.sidebar h4{
    font-weight:700;
    margin-bottom:40px;
    font-size:1.6rem;
    letter-spacing:1px;
}

.sidebar a{
    display:flex;
    align-items:center;
    padding:14px 18px;
    color:#d1d5db;
    text-decoration:none;
    border-radius:12px;
    margin-bottom:10px;
    font-weight:500;
    transition:0.3s;
    position:relative;
}

.sidebar a i{
    margin-right:12px;
    font-size:1.1rem;
}

.sidebar a::before{
    content:'';
    position:absolute;
    left:0;
    width:5px;
    height:100%;
    border-radius:8px 0 0 8px;
    background:transparent;
    transition:0.3s;
}

.sidebar a.active::before,
.sidebar a:hover::before{
    background:linear-gradient(180deg,#4ade80,#16a34a);
}

.sidebar a.active,
.sidebar a:hover{
    color:#fff;
    background:rgba(255,255,255,0.05);
}

.menu-title{
    font-size:12px;
    color:#9ca3af;
    margin-top:20px;
    margin-bottom:10px;
    text-transform:uppercase;
    letter-spacing:1px;
}

</style>


<div class="sidebar">

    <h4>
        <i class="fas fa-shield-alt"></i>
        Admin Panel
    </h4>


    <!-- DASHBOARD -->
    <a href="dashboard.php"
       class="<?= $current == 'dashboard.php' ? 'active' : '' ?>">
        <i class="fas fa-home"></i>
        Dashboard
    </a>


    <!-- MENU PENGADUAN -->
    <div class="menu-title">
        Menu Pengaduan
    </div>


    <a href="pengaduan_masuk.php"
       class="<?= $current == 'pengaduan_masuk.php' ? 'active' : '' ?>">
        <i class="fas fa-inbox"></i>
        Pengaduan Masuk
    </a>


    <a href="pengaduan_dilihat.php"
       class="<?= $current == 'pengaduan_dilihat.php' ? 'active' : '' ?>">
        <i class="fas fa-eye"></i>
        Pengaduan Dilihat
    </a>


    <a href="pengaduan_selesai.php"
       class="<?= $current == 'pengaduan_selesai.php' ? 'active' : '' ?>">
        <i class="fas fa-check-circle"></i>
        Pengaduan Selesai
    </a>


    <!-- MENU SISWA -->
    <div class="menu-title">
        Menu Siswa
    </div>


    <a href="tambah_siswa.php"
       class="<?= $current == 'tambah_siswa.php' ? 'active' : '' ?>">
        <i class="fas fa-user-plus"></i>
        Tambah Siswa
    </a>




    <!-- LOGOUT -->
    <div class="menu-title">
        Sistem
    </div>

    <a href="../auth/logout.php">
        <i class="fas fa-sign-out-alt"></i>
        Logout
    </a>

</div>
