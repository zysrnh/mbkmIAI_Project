<?php
global $koneksi_db;
?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');

/* ══════════════════════════════════════════
   TOP BAR — slide up on scroll
══════════════════════════════════════════ */
.top-bar {
    width: 100%;
    background: #1B4332;
    color: rgba(255,255,255,0.82);
    font-size: 12px;
    font-weight: 500;
    font-family: 'Plus Jakarta Sans', sans-serif;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding: 0 5%;
    gap: 24px;
    position: fixed;
    top: 0; left: 0;
    z-index: 100000;
    transition: transform 0.35s cubic-bezier(.4,0,.2,1),
                opacity   0.35s cubic-bezier(.4,0,.2,1);
    will-change: transform;
}
/* Hidden state (on scroll) */
.top-bar.tb-hidden {
    transform: translateY(-100%);
    opacity: 0;
    pointer-events: none;
}
.top-bar-item {
    display: flex;
    align-items: center;
    gap: 7px;
    white-space: nowrap;
}
.top-bar-item i {
    font-size: 11px;
    color: rgba(255,255,255,0.55);
}
.top-bar-divider {
    width: 1px;
    height: 14px;
    background: rgba(255,255,255,0.18);
}
@media (max-width: 600px) {
    .top-bar { justify-content: center; padding: 0 16px; gap: 16px; font-size: 11px; }
    .top-bar-item:first-child { display: none; }
}

/* ══════════════════════════════════════════
   STICKY NAVBAR
   — starts below top-bar (top: 36px)
   — when top-bar hides, slides up to top: 0
══════════════════════════════════════════ */
header.custom-header-main {
    position: fixed;
    width: 100%;
    top: 36px; /* flush under top-bar */
    left: 0;
    z-index: 99999;
    background: #FFFFFF;
    box-shadow: 0 2px 20px rgba(0,0,0,0.08);
    transition: top 0.35s cubic-bezier(.4,0,.2,1),
                box-shadow 0.3s ease;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
/* When top-bar is hidden, navbar moves to top */
header.custom-header-main.nav-top {
    top: 0;
    box-shadow: 0 4px 28px rgba(0,0,0,0.13);
}

.header-wrapper { width: 100%; }
.custom-navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 5%;
    background: #FFFFFF;
}

/* ── LOGO ── */
.navbar-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none !important;
    flex-shrink: 0;
}
.navbar-brand img { height: 44px; width: auto; }
.brand-text-wrap { display: flex; flex-direction: column; }
.brand-name {
    font-weight: 800;
    font-size: 17px;
    line-height: 1.15;
    color: #1B4332;
    letter-spacing: -0.4px;
}
.brand-sub {
    font-size: 7.5px;
    opacity: 0.75;
    letter-spacing: 1.3px;
    color: #2D6A4F;
    text-transform: uppercase;
    font-weight: 600;
}

/* ── NAV LINKS ── */
.nav-links {
    list-style: none;
    display: flex;
    gap: 4px;
    margin: 0; padding: 0;
    align-items: center;
}
.nav-links > li { position: relative; }

/* Base nav link */
.nav-links > li > a {
    color: #1B4332;
    text-decoration: none !important;
    font-size: 13.5px;
    font-weight: 600;
    padding: 8px 14px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: background 0.22s, color 0.22s;
    white-space: nowrap;
}
.nav-links > li > a:hover,
.nav-links > li > a:focus {
    background: rgba(27,67,50,0.07);
    color: #1B4332;
    text-decoration: none;
}
/* Active page indicator */
.nav-links > li > a.active-link {
    color: #1B4332;
    background: rgba(27,67,50,0.08);
}

/* Chevron icon */
.nav-links > li > a .fa-angle-down {
    font-size: 11px;
    opacity: 0.6;
    transition: transform 0.25s;
}
.nav-links > li:hover > a .fa-angle-down {
    transform: rotate(180deg);
}

/* ── DESKTOP DROPDOWN ── */
@media (min-width: 992px) {
    .nav-links .dropdown-menu {
        display: block;
        visibility: hidden;
        opacity: 0;
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        background: #fff;
        min-width: 230px;
        border-radius: 14px;
        padding: 8px;
        box-shadow: 0 12px 40px rgba(0,0,0,0.14), 0 0 0 1px rgba(0,0,0,0.05);
        transition: opacity 0.22s cubic-bezier(.4,0,.2,1),
                    transform 0.22s cubic-bezier(.4,0,.2,1),
                    visibility 0.22s;
        transform: translateY(6px);
        pointer-events: none;
    }
    /* Small arrow tip */
    .nav-links .dropdown-menu::before {
        content: '';
        position: absolute;
        top: -6px;
        right: 22px;
        width: 12px; height: 12px;
        background: #fff;
        border-left: 1px solid rgba(0,0,0,0.05);
        border-top: 1px solid rgba(0,0,0,0.05);
        transform: rotate(45deg);
        border-radius: 2px 0 0 0;
    }
    .nav-links > li:hover .dropdown-menu,
    .nav-links > li:focus-within .dropdown-menu {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
        pointer-events: all;
    }
    .nav-links .dropdown-menu a {
        color: #333 !important;
        padding: 9px 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        font-size: 13px;
        border-radius: 8px;
        transition: background 0.18s, color 0.18s;
        text-decoration: none !important;
    }
    .nav-links .dropdown-menu a:hover {
        background: rgba(27,67,50,0.07);
        color: #1B4332 !important;
        text-decoration: none;
    }
    /* Divider inside dropdown if needed */
    .nav-links .dropdown-menu .drop-divider {
        height: 1px;
        background: rgba(0,0,0,0.06);
        margin: 6px 8px;
    }
}

/* ── CTA BUTTON (LOGIN/DAFTAR) ── */
.nav-cta > a {
    background: #1B4332 !important;
    color: #FFFFFF !important;
    padding: 9px 22px !important;
    border-radius: 30px !important;
    font-size: 12.5px !important;
    font-weight: 800 !important;
    letter-spacing: 0.2px;
    transition: background 0.25s, transform 0.2s !important;
    border: 2px solid #1B4332 !important;
}
.nav-cta > a:hover {
    background: #2D6A4F !important;
    border-color: #2D6A4F !important;
    transform: translateY(-1px);
}
.nav-cta .dropdown-menu a {
    font-size: 13px !important;
    font-weight: 600 !important;
}

/* ── HAMBURGER ── */
.nav-hamb {
    display: none;
    background: none;
    border: 1.5px solid rgba(27,67,50,0.2);
    color: #1B4332;
    font-size: 18px;
    cursor: pointer;
    padding: 7px 10px;
    border-radius: 8px;
    transition: background 0.2s;
}
.nav-hamb:hover { background: rgba(27,67,50,0.07); }

/* ── RESPONSIVE MOBILE ── */
@media (max-width: 991px) {
    .custom-navbar { padding: 12px 20px; }
    .nav-hamb { display: block; }
    .nav-links {
        position: absolute;
        top: 100%; left: 0;
        width: 100%;
        background: #FFFFFF;
        flex-direction: column;
        gap: 0;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        align-items: flex-start;
    }
    .nav-links.active { max-height: 800px; padding-bottom: 16px; }
    .nav-links > li { width: 100%; border-bottom: 1px solid rgba(0,0,0,0.05); }
    .nav-links > li > a { padding: 14px 24px; border-radius: 0; font-size: 14px; }
    .nav-links > li > a:hover { background: rgba(27,67,50,0.05); }

    /* Mobile dropdown */
    .nav-links .dropdown-menu {
        position: static !important;
        background: #f7faf8 !important;
        display: none;
        visibility: visible !important;
        opacity: 1 !important;
        transform: none !important;
        padding: 4px 0 10px 0 !important;
        min-width: 100% !important;
        box-shadow: none !important;
        border-radius: 0 !important;
    }
    .nav-links .dropdown-menu::before { display: none; }
    .nav-links .dropdown-menu.mob-active { display: block !important; }
    .nav-links .dropdown-menu a {
        color: #2D6A4F !important;
        padding: 11px 36px !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        border-radius: 0 !important;
    }
    .nav-links .dropdown-menu a:hover { background: rgba(27,67,50,0.07) !important; }

    /* CTA button mobile */
    .nav-cta > a {
        margin: 8px 20px !important;
        display: inline-block !important;
        border-radius: 30px !important;
        padding: 10px 24px !important;
        width: auto !important;
    }
    .nav-cta { border-bottom: none !important; }

    .top-bar { font-size: 11px; }
}

/* ══════════════════════════════════════════
   GLOBAL CONTENT OFFSET
   Total = topbar (36px) + navbar (~65px) = 101px
   When top-bar hidden → just navbar height (~65px)
══════════════════════════════════════════ */
#main-content-area,
.element-size-67,
.page-content-wrap {
    margin-top: 101px !important;
}
/* Hero section (landing page) — no top margin, it has its own padding-top */
.modern-hero-area,
.custom-hero {
    margin-top: 0 !important;
    padding-top: 172px !important; /* 36 topbar + 65 navbar + 71 breathing room */
}
.modern-sidebar { margin-top: 30px !important; }

/* Sidebar styling kept from original */
.sidebar-section h4, .sidebar-section h3 { margin: 0; color: #1B4332; font-weight: 700; }
.sidebar-section table { width: 100% !important; border-collapse: separate; border-spacing: 2px; }
.sidebar-section td { text-align: center; padding: 5px; font-size: 12px; border-radius: 4px; border: 1px solid #f0f0f0; }
.sidebar-section .today,
.sidebar-section td[style*="background-color: rgb(255, 102, 0)"] { background: #1B4332 !important; color: #fff !important; font-weight: 800; border: none; }
.sidebar-section a[style*="background-color: rgb(59, 130, 246)"],
.sidebar-section a[style*="background-color: #3b82f6"] { background: #1B4332 !important; box-shadow: 0 4px 15px rgba(30,77,39,0.3); }
.sidebar-section .info-badge,
.sidebar-section span[style*="background-color: #1d4ed8"] { background: #2D6A4F !important; }
</style>

<!-- ══════════════════════════════════════
     TOP BAR
══════════════════════════════════════ -->
<div class="top-bar" id="topBar">
    <div class="top-bar-item">
        <i class="fa fa-phone"></i>
        <span>Telp. 08119081122</span>
    </div>
    <div class="top-bar-divider"></div>
    <div class="top-bar-item">
        <i class="fa fa-envelope"></i>
        <span>Email : info@iaipibandung.ac.id</span>
    </div>
</div>

<!-- ══════════════════════════════════════
     STICKY NAVBAR
══════════════════════════════════════ -->
<header class="custom-header-main" id="mainHeader">
    <div class="header-wrapper">
        <div class="custom-navbar">

            <!-- Logo -->
            <a href="index.php" class="navbar-brand">
                <img src="images/Assets/LogoIAI.png" alt="Logo IAI">
                <div class="brand-text-wrap">
                    <div class="brand-name">MBKM IAI PI BANDUNG</div>
                    <div class="brand-sub">Institut Agama Islam Persis Bandung</div>
                </div>
            </a>

            <!-- Hamburger (mobile) -->
            <button class="nav-hamb" onclick="toggleMnu()" aria-label="Menu">
                <i class="fa fa-bars" id="hambIcon"></i>
            </button>

            <!-- Nav Links -->
            <ul class="nav-links" id="mainMnu">

                <li>
                    <a href="index.php">Beranda</a>
                </li>

                <li>
                    <a href="javascript:void(0)" onclick="toggleDrop(this)">
                        Program <i class="fa fa-angle-down"></i>
                    </a>
                    <div class="dropdown-menu">
                        <?php
                        $res_prog = $koneksi_db->sql_query("SELECT judul, slug FROM mod_program ORDER BY id ASC");
                        if ($koneksi_db->sql_numrows($res_prog) > 0) {
                            while($row_prog = $koneksi_db->sql_fetchrow($res_prog)) {
                                echo '<a href="index.php?pilih=program&modul=yes&id='.htmlspecialchars($row_prog['slug']).'">'.htmlspecialchars($row_prog['judul']).'</a>';
                            }
                        } else {
                            echo '<a href="#">Pertukaran Mahasiswa</a>';
                            echo '<a href="#">Magang</a>';
                        }
                        ?>
                    </div>
                </li>

                <li><a href="#">Tim</a></li>
                <li><a href="kategori/1/Berita-Kampus.html">Berita</a></li>

                <?php if (isset($_SESSION['UserName']) && !empty($_SESSION['UserName'])): ?>
                <li class="nav-cta">
                    <a href="dashboard.php">DASHBOARD</a>
                </li>
                <?php else: ?>
                <li class="nav-cta has-drop">
                    <a href="javascript:void(0)" onclick="toggleDrop(this)">
                        LOGIN / DAFTAR <i class="fa fa-angle-down"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a href="login.php"><i class="fa fa-sign-in" style="width:16px;opacity:.6;"></i> Masuk (Login)</a>
                        <div class="drop-divider"></div>
                        <a href="register.php" style="color:#1B4332 !important; font-weight:700 !important;">
                            <i class="fa fa-user-plus" style="width:16px;opacity:.6;"></i> Daftar Akun
                        </a>
                    </div>
                </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</header>

<script>
(function() {
    var topBar    = document.getElementById('topBar');
    var header    = document.getElementById('mainHeader');
    var topBarH   = 36; // px — matches CSS height
    var lastY     = 0;
    var ticking   = false;

    function onScroll() {
        lastY = window.pageYOffset;
        if (!ticking) {
            requestAnimationFrame(update);
            ticking = true;
        }
    }

    function update() {
        ticking = false;
        if (lastY > topBarH) {
            // Top bar hidden, navbar slides to top
            topBar.classList.add('tb-hidden');
            header.classList.add('nav-top');
        } else {
            // Top bar visible, navbar sits below it
            topBar.classList.remove('tb-hidden');
            header.classList.remove('nav-top');
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    update(); // run once on load
})();

/* ── Mobile menu toggle ── */
function toggleMnu() {
    var menu = document.getElementById('mainMnu');
    var icon = document.getElementById('hambIcon');
    var open = menu.classList.toggle('active');
    icon.className = open ? 'fa fa-times' : 'fa fa-bars';
}

/* ── Mobile dropdown toggle ── */
function toggleDrop(el) {
    if (window.innerWidth < 992) {
        var drop = el.nextElementSibling;
        if (drop && drop.classList.contains('dropdown-menu')) {
            drop.classList.toggle('mob-active');
            var icon = el.querySelector('.fa-angle-down');
            if (icon) icon.style.transform = drop.classList.contains('mob-active') ? 'rotate(180deg)' : '';
        }
    }
}

/* Close mobile menu on outside click */
document.addEventListener('click', function(e) {
    var menu   = document.getElementById('mainMnu');
    var hamb   = document.querySelector('.nav-hamb');
    if (menu && menu.classList.contains('active')) {
        if (!menu.contains(e.target) && !hamb.contains(e.target)) {
            menu.classList.remove('active');
            document.getElementById('hambIcon').className = 'fa fa-bars';
        }
    }
});
</script>