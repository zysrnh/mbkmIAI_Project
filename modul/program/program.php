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
    <div style="background: linear-gradient(135deg, #1e4d27 0%, #306238 100%); padding: 120px 0 60px; color: white; position: relative; overflow: hidden;">
        <div style="position: absolute; inset: 0; opacity: 0.1; background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="container" style="position: relative; z-index: 2;">
            <div style="text-transform: uppercase; letter-spacing: 2px; font-size: 13px; font-weight: 700; color: #9EBB97; margin-bottom: 10px;">Program Merdeka Belajar</div>
            <h1 style="font-size: 42px; font-weight: 900; margin: 0; color: #fff; letter-spacing: -1px;">'.htmlspecialchars($data['judul']).'</h1>
        </div>
    </div>';

    // 2. Konten Utama
    $tengah .= '
    <div style="background: #fdfdfd; padding: 60px 0;">
        <div class="container">
            <div class="row">
                <div class="col-md-9" style="margin: 0 auto;">
                    <div style="background: #fff; border-radius: 20px; box-shadow: 0 15px 50px rgba(0,0,0,0.05); padding: 50px; border: 1px solid rgba(0,0,0,0.03);">
                        ';
    
    // Tampilkan Gambar Utama jika ada
    if ($data['gambar']) {
        $tengah .= '<div style="margin-bottom: 40px; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <img src="images/pages/'.$data['gambar'].'" style="width: 100%; height: auto; display: block;">
        </div>';
    }

    // Tampilkan Isi (Render HTML dari editor)
    $tengah .= '
                        <div class="program-body" style="line-height: 1.8; color: #444; font-size: 16px;">
                            <style>
                                .program-body h2 { color: #1e4d27; font-weight: 800; margin-top: 40px; margin-bottom: 20px; font-family: "Playfair Display", serif; border-left: 4px solid #306238; padding-left: 20px; }
                                .program-body h3 { color: #306238; font-weight: 700; margin-top: 30px; }
                                .program-body p { margin-bottom: 25px; text-align: justify; }
                                .program-body ul, .program-body ol { margin-bottom: 30px; padding-left: 20px; }
                                .program-body li { margin-bottom: 12px; }
                                .program-body b, .program-body strong { color: #111; }
                            </style>
                            '.$data['isi'].'
                        </div>
                        
                        <hr style="margin: 50px 0; opacity: 0.1;">
                        
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="font-size: 13px; color: #aaa;">Terakhir diperbarui: '.date("d F Y", strtotime($data['tgl_update'])).'</div>
                            <a href="index.php" style="color: #306238; font-weight: 700; text-decoration: none; font-size: 14px;">&larr; Kembali ke Beranda</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';
}

echo $tengah;
?>
