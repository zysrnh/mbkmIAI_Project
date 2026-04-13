<?php
global $koneksi_db;
echo '
<style>
/* Custom Navbar Styling */
header.custom-header-main {
    position: absolute;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 1000;
}
.header-wrapper {
    width: 100%;
}
.custom-navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 50px;
    background: transparent;
}
.custom-navbar .logo-left {
    color: #fff;
    font-size: 20px;
    font-weight: bold;
    display: flex;
    flex-direction: column;
    text-transform: uppercase;
    text-decoration: none;
}
.custom-navbar .logo-left:hover {
    color: #fff;
    text-decoration: none;
}
.custom-navbar .logo-left span {
    font-size: 11px;
    font-weight: normal;
    text-transform: none;
    letter-spacing: 0.5px;
}
.custom-navbar .nav-links {
    list-style: none;
    display: flex;
    margin: 0;
    padding: 0;
    align-items: center;
}
.custom-navbar .nav-links li {
    margin: 0 15px;
    position: relative;
    padding: 10px 0;
}
.custom-navbar .nav-links a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    font-size: 15px;
    transition: color 0.3s ease;
}
.custom-navbar .nav-links a:hover {
    color: #ffcc00;
}
.custom-navbar .nav-links .dropdown-menu {
    display: block;
    visibility: hidden;
    opacity: 0;
    position: absolute;
    top: 100%;
    left: 0;
    background: #fff;
    min-width: 280px;
    border-radius: 8px;
    padding: 10px 0;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    transform: translateY(10px);
}
.custom-navbar .nav-links li:hover .dropdown-menu {
    visibility: visible;
    opacity: 1;
    transform: translateY(0);
}
.custom-navbar .nav-links .dropdown-menu a {
    color: #333;
    padding: 10px 20px;
    display: block;
    font-size: 14px;
    font-weight: 400;
}
.custom-navbar .nav-links .dropdown-menu a:hover {
    background: #f8f9fa;
    color: #0d47a1;
}
.dikti-logo {
    display: flex;
    align-items: center;
}
</style>
<div class="header-wrapper">
    <div class="custom-navbar">
        <a href="index.php" class="logo-left">
            MBKM IAI PI Bandung
            <span>Institut Agama Islam Persis Bandung</span>
        </a>
        <ul class="nav-links">
            <li><a href="index.php" style="color: #ffcc00;">Beranda</a></li>
            <li>
                <a href="#">Program <i class="fa fa-angle-down"></i></a>
                <div class="dropdown-menu">
                    <a href="#">Pertukaran Mahasiswa</a>
                    <a href="#">Magang</a>
                    <a href="#">Kampus Mengajar/Asistensi Mengajar</a>
                    <a href="#">Penelitian/Riset</a>
                    <a href="#">Proyek Kemanusiaan/Bela Negara</a>
                    <a href="#">Studi/Proyek Independent</a>
                    <a href="#">Kegiatan Wirausaha</a>
                    <a href="#">Membangun Desa/KKNT</a>
                </div>
            </li>
            <li><a href="#">Tim</a></li>
            <li><a href="#">Berita</a></li>
            <li><a href="#">SIM MBKM</a></li>
            <li><a href="#">Tautan</a></li>
            <li><a href="#"><i class="fa fa-globe"></i></a></li>
            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
';

// Tambahkan tombol Dashboard jika admin login
if (isset($_SESSION['LevelAkses']) && $_SESSION['LevelAkses'] === 'Administrator') {
    echo '
            <li>
                <a href="admin.html" style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.3);padding:8px 18px;border-radius:30px;font-size:13px;font-weight:700;display:inline-flex;align-items:center;gap:6px;transition:all .3s">
                    <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                    Dashboard
                </a>
            </li>';
}

echo '
        </ul>

    </div>
</div>
';
?>
