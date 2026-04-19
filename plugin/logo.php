<?php
global $koneksi_db;
?>
<style>
/* ── NAVBAR MAIN ── */
header.custom-header-main {
    position: fixed;
    width: 100%;
    top: 0; left: 0;
    z-index: 99999;
    background: #1e4d27; /* Ijo Tua Solid */
    box-shadow: 0 4px 30px rgba(0,0,0,0.15);
}
.header-wrapper { width: 100%; }
.custom-navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 5%;
    background: #1e4d27;
    transition: all 0.3s;
}

/* ── LOGO ── */
.logo-left {
    text-decoration: none !important;
    display: flex;
    flex-direction: column;
    color: #fff;
}
.logo-left strong {
    font-size: 20px;
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -0.2px;
}
.logo-left span {
    font-size: 8.5px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    opacity: 0.8;
}

/* ── NAV LINKS ── */
.nav-links {
    list-style: none;
    display: flex;
    gap: 25px;
    margin: 0; padding: 0;
    align-items: center;
}
.nav-links li { position: relative; }
.nav-links a {
    color: #fff;
    text-decoration: none !important;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s;
}
.nav-links a:hover { color: #ffcc00; }

/* ── TOGGLE MOBILE ── */
.nav-hamb {
    display: none;
    background: none;
    border: none;
    color: #fff;
    font-size: 24px;
    cursor: pointer;
    padding: 5px;
}

/* ── RESPONSIVE MOBILE ── */
@media (max-width: 991px) {
    .custom-navbar { padding: 12px 20px; background: rgba(0,0,0,0.5); backdrop-filter: blur(15px); }
    .nav-hamb { display: block; }
    
    .nav-links {
        position: absolute;
        top: 100%; left: 0;
        width: 100%;
        background: #306238;
        flex-direction: column;
        gap: 0;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        align-items: flex-start;
    }
    .nav-links.active { max-height: 800px; padding-bottom: 20px; }
    .nav-links li { width: 100%; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .nav-links a {
        display: block;
        padding: 16px 25px;
        width: 100%;
    }
    .nav-links .dropdown-menu {
        position: static !important;
        background: rgba(0,0,0,0.1) !important;
        display: none;
        visibility: visible !important;
        opacity: 1 !important;
        transform: none !important;
        padding: 0 0 10px 20px !important;
        min-width: 100% !important;
        box-shadow: none !important;
    }
    .nav-links .dropdown-menu.mob-active { display: block !important; }
    .nav-links .dropdown-menu a {
        color: rgba(255,255,255,0.8) !important;
        padding: 10px 25px !important;
    }
}

/* ── Desktop Dropdown ── */
@media (min-width: 992px) {
    .nav-links .dropdown-menu {
        display: block;
        visibility: hidden;
        opacity: 0;
        position: absolute;
        top: 100%; right: 0;
        background: #fff;
        min-width: 220px;
        border-radius: 12px;
        padding: 12px 0;
        box-shadow: 0 15px 45px rgba(0,0,0,0.2);
        transition: all 0.3s;
        transform: translateY(12px);
    }
    .nav-links li:hover .dropdown-menu {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
    }
    .nav-links .dropdown-menu a {
        color: #444 !important;
        padding: 10px 20px;
        display: block;
        font-weight: 500;
    }
    .nav-links .dropdown-menu a:hover { background: #f8f8f8; color: #306238 !important; }
}

/* ── FORCE MODERN SIDEBAR FIX ── */
.modern-sidebar, .sidebar-section:first-child { margin-top: 30px; } 
.sidebar-section h4, .sidebar-section h3 { margin: 0; color: #1e4d27; font-weight: 700; }
.sidebar-section table { width: 100% !important; border-collapse: separate; border-spacing: 2px; }

/* ── GLOBAL OFFSET (Biar konten gak ketutupan Navbar) ── */
#main-content-area, .element-size-67, .container { margin-top: 130px !important; }
.modern-hero-area { margin-top: 0 !important; }
.modern-sidebar { margin-top: 30px !important; }
.sidebar-section td { text-align: center; padding: 5px; font-size: 12px; border-radius: 4px; border: 1px solid #f0f0f0; }
.sidebar-section .today, .sidebar-section td[style*="background-color: rgb(255, 102, 0)"] { background: #1e4d27 !important; color: #fff !important; font-weight: 800; border: none; }
.sidebar-section a[style*="background-color: rgb(59, 130, 246)"], 
.sidebar-section a[style*="background-color: #3b82f6"] { background: #1e4d27 !important; box-shadow: 0 4px 15px rgba(30,77,39,0.3); }
.sidebar-section .info-badge, .sidebar-section span[style*="background-color: #1d4ed8"] { background: #306238 !important; }
</style>

<div class="header-wrapper">
    <div class="custom-navbar">
                <!-- Logo Area -->
                <a href="index.php" class="navbar-brand" style="display: flex; flex-direction: column; justify-content: center; height: 100%; text-decoration: none;">
                    <div style="font-weight: 800; font-size: 20px; line-height: 1.2; color: #fff; letter-spacing: -0.5px;">MBKM IAI PI BANDUNG</div>
                    <div style="font-size: 9px; opacity: 0.7; letter-spacing: 1.5px; color: #fff; text-transform: uppercase; font-weight: 600;">Institut Agama Islam Persis Bandung</div>
                </a>
        <button class="nav-hamb" onclick="toggleMnu()">
            <i class="fa fa-bars"></i>
        </button>

        <ul class="nav-links" id="mainMnu">
            <li><a href="index.php" style="color: #ffcc00;">Beranda</a></li>
            <li>
                <a href="javascript:void(0)" onclick="toggleDrop(this)">Program <i class="fa fa-angle-down"></i></a>
                <div class="dropdown-menu">
                    <?php
                    $res_prog = $koneksi_db->sql_query("SELECT judul, slug FROM mod_program ORDER BY id ASC");
                    if ($koneksi_db->sql_numrows($res_prog) > 0) {
                        while($row_prog = $koneksi_db->sql_fetchrow($res_prog)) {
                            echo '<a href="index.php?pilih=program&modul=yes&id='.$row_prog['slug'].'">'.$row_prog['judul'].'</a>';
                        }
                    } else {
                        echo '<a href="#">Pertukaran Mahasiswa</a>';
                        echo '<a href="#">Magang</a>';
                    }
                    ?>
                </div>
            </li>
            <li><a href="#">Tim</a></li>
            <li><a href="kategori/1/Berita Kampus.html">Berita</a></li>
            
            <?php if (isset($_SESSION['UserName']) && !empty($_SESSION['UserName'])): ?>
                <li>
                    <a href="dashboard.php" style="background:#ffcc00;color:#333;padding:10px 25px;border-radius:30px;font-size:12px;font-weight:800;text-align:center;">
                        DASHBOARD
                    </a>
                </li>
            <?php else: ?>
                <li class="has-drop">
                    <a href="javascript:void(0)" onclick="toggleDrop(this)" style="background:#ffcc00;color:#333;padding:10px 25px;border-radius:30px;font-size:12px;font-weight:800;text-align:center;">
                        LOGIN / DAFTAR <i class="fa fa-angle-down"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a href="login.php"><i class="fa fa-sign-in"></i> Masuk (Login)</a>
                        <a href="register.php" style="color:#2e7d32"><b><i class="fa fa-user-plus"></i> Daftar Akun</b></a>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<script>
function toggleMnu() {
    document.getElementById('mainMnu').classList.toggle('active');
}
function toggleDrop(el) {
    if (window.innerWidth < 992) {
        var drop = el.nextElementSibling;
        if (drop && drop.classList.contains('dropdown-menu')) {
            drop.classList.toggle('mob-active');
        }
    }
}
</script>
