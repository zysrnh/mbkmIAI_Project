<?php
/**
 * Frontend Module for Displaying Program MBKM Details
 */

if (!defined('cms-KONTEN')) {
    Header("Location: ../index.php");
    exit;
}

global $koneksi_db, $tengah;

$slug = isset($_GET['id']) ? cleantext($_GET['id']) : '';

// Cari data berdasarkan slug (atau ID jika abang mau)
$res = $koneksi_db->sql_query("SELECT * FROM `mod_program` WHERE `slug`='$slug' OR `id`='$slug' LIMIT 1");
$data = $koneksi_db->sql_fetchrow($res);

if (!$data) {
    $tengah .= '<div class="container" style="padding:100px 0; text-align:center;">
        <h2 style="color:#306238; font-weight:800;">Waduh, Halaman Tidak Ditemukan!</h2>
        <p>Mungkin abang belum input datanya di admin atau linknya salah.</p>
        <a href="index.php" class="btn btn-primary" style="margin-top:20px;">Kembali ke Beranda</a>
    </div>';
} else {
    // --- Layout Mewah Akademik ---
    
    // 1. Hero / Header Halaman
    $tengah .= '
    <div class="modern-hero-area" style="background: linear-gradient(135deg, #1e4d27 0%, #306238 100%); padding: 90px 0 50px; color: white; position: relative; overflow: hidden;">
        <div style="position: absolute; inset: 0; opacity: 0.1; background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="container" style="position: relative; z-index: 2; text-align: center;">
            <div style="text-transform: uppercase; letter-spacing: 4px; font-size: 11px; font-weight: 700; color: #9EBB97; margin-bottom: 15px;">Program Merdeka Belajar</div>
            <h1 style="font-size: clamp(2rem, 5vw, 3.8rem); font-weight: 900; margin: 0; color: #fff; letter-spacing: -2px; line-height: 1.1;">'.htmlspecialchars($data['judul']).'</h1>
        </div>
    </div>';

    // 2. Konten Utama
    $tengah .= '
    <div style="background: #f4f7f6; padding: 0 0 100px;">
        <div class="container" style="margin-top: -80px; position: relative; z-index: 10;">
            <div class="row">
                <div class="col-md-8">
                    <div style="background: #fff; border-radius: 30px; box-shadow: 0 40px 100px rgba(0,0,0,0.1); overflow: hidden; border: 1px solid rgba(0,0,0,0.05);">';
    
    // Tampilkan Gambar Utama jika ada
    if ($data['gambar']) {
        $tengah .= '<div style="width: 100%; height: 450px; overflow: hidden; border-bottom: 1px solid #f0f0f0;">
            <img src="images/pages/'.$data['gambar'].'" style="width: 100%; height: 100%; object-fit: cover; display: block;">
        </div>';
    }

    // Tampilkan Isi
    $tengah .= '
                        <div style="padding: 60px 70px;">
                            <div class="program-body" style="line-height: 1.9; color: #333; font-size: 17px; font-family: \'Inter\', sans-serif;">
                                <style>
                                    .program-body h1, .program-body h2 { color: #1e4d27; font-weight: 800; margin-top: 50px; margin-bottom: 25px; font-family: "Playfair Display", serif; border-left: 6px solid #306238; padding-left: 20px; text-transform: none; line-height: 1.2; }
                                    .program-body h3 { color: #306238; font-weight: 700; margin-top: 35px; text-transform: none; }
                                    .program-body p { margin-bottom: 25px; text-align: justify; }
                                    .program-body ul, .program-body ol { margin-bottom: 30px; padding-left: 25px; }
                                    .program-body li { margin-bottom: 15px; }
                                    .program-body b, .program-body strong { color: #000; font-weight: 700; }
                                    @media (max-width: 768px) {
                                        .program-body { font-size: 16px; }
                                        [style*="padding: 60px 80px"] { padding: 30px 20px !important; }
                                        [style*="height: 500px"] { height: 300px !important; }
                                    }
                                </style>
                                '.$data['isi'].'
                            </div>
                            
                            <div style="margin-top: 60px; padding-top: 30px; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                                <div style="font-size: 13px; color: #999; font-style: italic;">Pembaruan terakhir: '.date("d F Y", strtotime($data['tgl_update'])).'</div>
                                <a href="index.php" class="btn-back" style="color: #306238; font-weight: 700; text-decoration: none; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                                    Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="modern-sidebar" style="margin-top:0 !important;">';
                        ob_start();
                        include "plugin/berita.php";
                        modul(1);
                        blok(1);
                        $tengah .= ob_get_contents();
                        ob_end_clean();
    $tengah .= '
                    </div>
                </div>
            </div>
        </div>
    </div>';
}

echo $tengah;
?>
