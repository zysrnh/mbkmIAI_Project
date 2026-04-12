<?php
/*
 * Admin Dashboard - normal.php
 * Ditampilkan saat user mengakses admin.php tanpa parameter pilih.
 */

if (!defined('cms-KONTEN')) {
    header("Location: index.php");
    exit;
}

$is_admin = isset($_SESSION['LevelAkses']) && $_SESSION['LevelAkses'] == 'Administrator';
$userName = isset($_SESSION['UserName']) ? $_SESSION['UserName'] : 'Admin';

$tengah = ''; 

if ($is_admin) {
    // Bangun tampilan dashboard khusus admin
    $tengah .= '
    <style>
    /* Fullpage mode: Sembunyikan sidebar kanan, blog-left full-width */
    .blog-right             { display: none !important; }
    .col-sm-8.blog-left     { width: 100% !important; padding: 0 !important; }
    .blog-wrapper           { margin-top: 0 !important; background: transparent !important; padding: 0 !important; border:none!important; }
    
    .admin-dash {
        padding: 40px 20px;
        background: #f7f9f6;
        min-height: calc(100vh - 100px);
    }
    .admin-dash-header {
        background: linear-gradient(135deg, #306238 0%, #1e3d22 100%);
        border-radius: 20px;
        padding: 40px;
        color: #fff;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(48,98,56,0.2);
    }
    .admin-dash-header::before {
        content:""; position:absolute; right:-50px; top:-100px;
        width: 300px; height: 300px; border-radius: 50%;
        background: rgba(255,255,255,0.05);
    }
    .admin-dash-header h2 { font-size: 32px; font-weight: 800; margin: 0 0 10px; color: #fff; }
    .admin-dash-header p { font-size: 16px; opacity: 0.8; margin: 0; }
    
    .dash-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
    }
    
    .dash-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        text-decoration: none !important;
        display: flex;
        flex-direction: column;
        gap: 16px;
        border: 1px solid rgba(48,98,56,0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    .dash-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(48,98,56,0.12);
        border-color: rgba(48,98,56,0.3);
    }
    .dash-icon {
        width: 56px; height: 56px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        background: #e8f0e6; color: #306238;
    }
    .dash-icon svg { width: 28px; height: 28px; fill: currentColor; }
    
    .dash-card h3 { font-size: 18px; font-weight: 700; color: #1e2d20; margin: 0; }
    .dash-card p { font-size: 14px; color: #5a6b5c; margin: 0; line-height: 1.5; }
    
    .dash-card-footer {
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid #f0f0f0;
        display: flex; align-items: center; gap: 6px;
        color: #306238; font-weight: 600; font-size: 13px;
    }
    .dash-card-footer svg { width: 16px; height: 16px; fill: currentColor; transition: transform 0.2s;}
    .dash-card:hover .dash-card-footer svg { transform: translateX(4px); }
    </style>
    
    <div class="admin-dash">
        <div class="container">
            <div class="admin-dash-header">
                <h2>Selamat Datang, '.htmlspecialchars($userName).'!</h2>
                <p>Pusat kendali Sistem Informasi IAI PI Bandung.</p>
            </div>
            
            <div class="dash-grid">
                
                <!-- Quick Link Flipbook / Buku Panduan -->
                <a href="admin.php?pilih=flipbook&modul=yes" class="dash-card">
                    <div class="dash-icon" style="background:#306238; color:#fff;">
                        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                    <div>
                        <h3>Kelola Buku / Flipbook</h3>
                        <p>Upload, edit, dan kelola buku panduan MBKM berformat PDF dengan viewer interaktif 3D.</p>
                    </div>
                    <div class="dash-card-footer">
                        Buka Manajer Buku
                        <svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
                    </div>
                </a>
                
                <!-- Pengaturan Menu / Navigasi -->
                <a href="admin.php?pilih=admin_menu" class="dash-card">
                    <div class="dash-icon">
                        <svg viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
                    </div>
                    <div>
                        <h3>Menu Navigasi</h3>
                        <p>Atur struktur menu website utama dan atur tautan internal / eksternal.</p>
                    </div>
                    <div class="dash-card-footer">
                        Atur Navigasi
                        <svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
                    </div>
                </a>

                <!-- Pengguna -->
                <a href="admin.php?pilih=pengguna&modul=yes" class="dash-card">
                    <div class="dash-icon">
                        <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                    </div>
                    <div>
                        <h3>Pengelola Akun</h3>
                        <p>Tambah, edit, atau hapus akses akun administrator dan staff lainnya.</p>
                    </div>
                    <div class="dash-card-footer">
                        Kelola Akun
                        <svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
                    </div>
                </a>

            </div>
        </div>
    </div>
    ';
} else {
    // Tampilan default untuk selain admin
    $tengah .= '<div class="alert alert-info text-center" style="margin:40px;">Halaman statis normal.</div>';
}

echo $tengah;
?>