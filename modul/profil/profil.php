<?php
if (!defined('cms-KONTEN')) {
    Header("Location: ../index.php");
    exit;
}

global $koneksi_db, $tengah;

// Tarik data profil dari database
$res = $koneksi_db->sql_query("SELECT * FROM `mod_data_profil` WHERE id='1'");
$data = $koneksi_db->sql_fetchrow($res);

if (!$data) {
    $tengah .= '<div class="container" style="padding:100px 0; text-align:center;">
        <h2 style="color:#306238; font-weight:800;">Data Profil Belum Diatur</h2>
        <p>Silakan atur profil di halaman admin.</p>
    </div>';
} else {
    // --- Tampilan Halaman Profil Mewah ---
    
    // Header Halaman yang Bersih
    $tengah .= '
    <div style="background: linear-gradient(135deg, #1e4d27 0%, #306238 100%); padding: 40px; border-radius: 20px; color: #fff; margin-bottom: 30px; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(30,77,39,0.15);">
        <div style="position: absolute; top:0; right: 0; opacity: 0.1;"><i class="fa fa-university" style="font-size: 150px;"></i></div>
        <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; opacity: 0.8; margin-bottom: 8px; font-weight: 700;">Profil Institusi</div>
        <h2 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 800; letter-spacing: -0.5px;">'.htmlspecialchars($data['nama']).'</h2>
    </div>';

    // Bungkus Konten Putih
    $tengah .= '<div style="background: #fff; border-radius: 20px; padding: 40px; box-shadow: 0 4px 25px rgba(0,0,0,0.04); border: 1px solid #f0f0f0;">';
    
    // Video Profil
    $vid_res = $koneksi_db->sql_query("SELECT * FROM `mod_data_video` ORDER BY id DESC LIMIT 1");
    $vid = $koneksi_db->sql_fetchrow($vid_res);
    if ($vid && !empty($vid['video'])) {
        $tengah .= '
        <div style="width: 100%; aspect-ratio: 16/9; background: #000; border-radius: 12px; overflow: hidden; margin-bottom: 35px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/'.$vid['video'].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>';
    }

    // Teks Sambutan
    $tengah .= '
    <div class="profil-body" style="line-height: 1.8; color: #444; font-size: 16px;">
        <style>
            .profil-body p { margin-bottom: 20px; text-align: justify; }
            .profil-body h2 { color: #1e4d27; font-weight: 800; margin-top: 30px; margin-bottom: 15px; }
        </style>
        '.$data['sambutan'].'
    </div>';

    $tengah .= '
    <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee;">
        <a href="index.php" style="color: #306238; font-weight: 700; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>';

    $tengah .= '</div>';
}

echo $tengah;
?>
