<?php
/**
 * Frontend Module — Program MBKM Detail (v2)
 * - Border radius lebih kecil (10px)
 * - Gambar artikel proporsional aspect-ratio 4:3
 * - Konten lebih lebar (grid 1fr 320px)
 */

if (!defined('cms-KONTEN')) {
    Header("Location: ../index.php");
    exit;
}

global $koneksi_db, $tengah;

$slug = isset($_GET['id']) ? cleantext($_GET['id']) : '';

$res  = $koneksi_db->sql_query("SELECT * FROM `mod_program` WHERE `slug`='$slug' OR `id`='$slug' LIMIT 1");
$data = $koneksi_db->sql_fetchrow($res);

if (!$data) {
    $tengah .= '
    <div style="padding:120px 20px; text-align:center; font-family:\'Plus Jakarta Sans\',sans-serif;">
        <h2 style="color:#1B4332;font-weight:900;font-size:24px;margin:0 0 10px;">Halaman Tidak Ditemukan</h2>
        <p style="color:#5a6b5c;font-size:15px;margin:0 0 28px;">Data program belum tersedia atau link tidak valid.</p>
        <a href="index.php" style="display:inline-flex;align-items:center;gap:8px;background:#1B4332;color:#fff;
           padding:12px 28px;border-radius:8px;text-decoration:none;font-weight:700;font-size:14px;
           font-family:\'Plus Jakarta Sans\',sans-serif;">Kembali ke Beranda</a>
    </div>';
} else {

$tengah .= '
<style>
@import url("https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap");

.pd-wrap, .pd-wrap * { box-sizing: border-box; }
.pd-wrap { font-family: "Plus Jakarta Sans", sans-serif; background: #F4F6F4; padding-bottom: 80px; }

/* HERO */
.pd-hero {
    background: linear-gradient(140deg, #0f2d1c 0%, #1B4332 60%, #2D6A4F 100%);
    padding: 48px 0 80px;
    position: relative; overflow: hidden; text-align: center; color: #fff;
}
.pd-hero::before {
    content: ""; position: absolute; inset: 0;
    background-image: radial-gradient(rgba(255,255,255,.055) 1px, transparent 1px);
    background-size: 26px 26px;
}
.pd-hero-in { position: relative; z-index: 2; max-width: 860px; margin: 0 auto; padding: 0 20px; }
.pd-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,.10); border: 1px solid rgba(255,255,255,.18);
    padding: 5px 18px; border-radius: 6px;
    font-size: 10px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase;
    color: rgba(255,255,255,.8); margin-bottom: 18px;
}
.pd-eyebrow span { width: 5px; height: 5px; border-radius: 50%; background: #a8d5b5; display: inline-block; }
.pd-hero h1 {
    font-size: clamp(1.8rem, 4vw, 2.9rem); font-weight: 900;
    letter-spacing: -1.2px; line-height: 1.1; color: #fff; margin: 0;
}

/* LAYOUT */
.pd-body {
    max-width: 1280px; margin: -44px auto 0; padding: 0 24px;
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 24px; align-items: start; position: relative; z-index: 5;
}
@media (max-width: 991px) {
    .pd-body { grid-template-columns: 1fr; margin-top: -30px; }
}

/* MAIN CARD */
.pd-card {
    background: #fff; border-radius: 6px;
    box-shadow: 0 6px 32px rgba(27,67,50,.09);
    overflow: hidden; border: 1px solid #e8ede9;
}
.pd-cover { width: 100%; height: 360px; object-fit: cover; display: block; }
@media (max-width: 768px) { .pd-cover { height: 220px; } }
.pd-body-pad { padding: 48px 56px 44px; }
@media (max-width: 768px) { .pd-body-pad { padding: 24px 20px 28px; } }

/* RICH TEXT */
.pd-rich { font-size: 15.5px; line-height: 1.88; color: #333; }
.pd-rich h1, .pd-rich h2 {
    font-family: "Plus Jakarta Sans", sans-serif !important;
    font-size: 19px !important; font-weight: 800 !important;
    color: #1B4332 !important; margin: 38px 0 14px !important;
    padding-left: 16px !important; border-left: 4px solid #2D6A4F !important;
    line-height: 1.3 !important; text-transform: none !important; letter-spacing: -.2px !important;
}
.pd-rich h3 {
    font-family: "Plus Jakarta Sans", sans-serif !important;
    font-size: 15.5px !important; font-weight: 700 !important;
    color: #2D6A4F !important; margin: 26px 0 10px !important; text-transform: none !important;
}
.pd-rich p { margin-bottom: 16px !important; text-align: justify !important; }
.pd-rich ul, .pd-rich ol { padding-left: 20px !important; margin-bottom: 18px !important; }
.pd-rich li { margin-bottom: 8px !important; }
.pd-rich ul li::marker { color: #2D6A4F; }
.pd-rich b, .pd-rich strong { color: #1B4332 !important; font-weight: 700 !important; }
.pd-rich img { max-width: 100% !important; border-radius: 8px !important; margin: 12px 0 !important; }

/* FOOTER */
.pd-footer {
    margin-top: 44px; padding-top: 20px; border-top: 1px solid #edf2ea;
    display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;
}
.pd-update { font-size: 12px; color: #9aab9c; font-style: italic; }
.pd-back {
    display: inline-flex; align-items: center; gap: 7px;
    background: #1B4332; color: #fff !important;
    padding: 9px 20px; border-radius: 7px;
    font-size: 13px; font-weight: 700; text-decoration: none !important;
    transition: background .22s, transform .22s;
}
.pd-back:hover { background: #2D6A4F; transform: translateX(-2px); }

/* SIDEBAR */
.pd-sidebar { display: flex; flex-direction: column; gap: 18px; }
.pd-sb-card {
    background: #fff; border-radius: 6px;
    border: 1px solid #e8ede9; box-shadow: 0 4px 14px rgba(27,67,50,.07); overflow: hidden;
}
.pd-sb-head {
    background: #1B4332; padding: 12px 16px;
    display: flex; align-items: center; gap: 9px;
}
.pd-sb-head h4 {
    margin: 0; font-size: 11.5px; font-weight: 800;
    color: #fff; text-transform: uppercase; letter-spacing: 1.8px;
    font-family: "Plus Jakarta Sans", sans-serif;
}

/* Artikel rows */
.pd-art-row {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 12px 14px; border-bottom: 1px solid #f0f5f2;
    text-decoration: none !important; transition: background .16s;
}
.pd-art-row:last-child { border-bottom: none; }
.pd-art-row:hover { background: #f5faf7; }

/* Thumbnail — aspect ratio 4:3, tidak crop distorsi */
.pd-art-thumb {
    width: 72px; flex-shrink: 0; border-radius: 6px; overflow: hidden;
    aspect-ratio: 4/3; background: #e8ede9;
    display: flex; align-items: center; justify-content: center;
}
.pd-art-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.pd-art-thumb-ph {
    width: 100%; height: 100%;
    background: linear-gradient(135deg, #1B4332, #2D6A4F);
    display: flex; align-items: center; justify-content: center;
}
.pd-art-thumb-ph svg { width: 20px; height: 20px; fill: rgba(255,255,255,.35); }

.pd-art-text { flex: 1; min-width: 0; }
.pd-art-ttl {
    font-size: 12.5px; font-weight: 700; color: #212529;
    line-height: 1.4; margin: 0 0 5px;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}
.pd-art-row:hover .pd-art-ttl { color: #1B4332; }
.pd-art-meta { font-size: 10.5px; color: #9aab9c; display: flex; gap: 8px; flex-wrap: wrap; }

/* Program list */
.pd-prog-row {
    display: flex; align-items: center; gap: 10px;
    padding: 11px 16px; border-bottom: 1px solid #f0f5f2;
    text-decoration: none !important;
    font-size: 13px; font-weight: 600; color: #333;
    transition: background .16s, color .16s;
    font-family: "Plus Jakarta Sans", sans-serif;
}
.pd-prog-row:last-child { border-bottom: none; }
.pd-prog-row:hover { background: #f5faf7; color: #1B4332; }
.pd-prog-row.is-active { background: #edf7f1; color: #1B4332; font-weight: 800; }
.pd-prog-dot { width: 7px; height: 7px; border-radius: 50%; background: #2D6A4F; flex-shrink: 0; }
.pd-prog-row.is-active .pd-prog-dot { background: #1B4332; }

/* Sidebar section dari plugin CMS — sesuaikan gaya agar match */
.sidebar-section {
    border-radius: 6px !important;
    overflow: visible !important;
    border: 1px solid #e8ede9 !important;
    box-shadow: 0 4px 14px rgba(27,67,50,.07) !important;
    margin-bottom: 18px !important;
}
.sidebar-header {
    border-radius: 6px 6px 0 0 !important;
    font-family: "Plus Jakarta Sans", sans-serif !important;
    font-size: 11.5px !important; font-weight: 800 !important; letter-spacing: 1.8px !important;
}
</style>';

/* HERO */
$tengah .= '
<div class="pd-wrap">
  <div class="pd-hero">
    <div class="pd-hero-in">
      <div class="pd-eyebrow"><span></span>Program Merdeka Belajar</div>
      <h1>'.htmlspecialchars($data['judul']).'</h1>
    </div>
  </div>

  <div class="pd-body">

    <!-- MAIN CONTENT -->
    <div class="pd-card">';

if (!empty($data['gambar'])) {
    $tengah .= '<img src="images/pages/'.htmlspecialchars($data['gambar']).'" class="pd-cover" alt="'.htmlspecialchars($data['judul']).'">';
}

$tengah .= '
      <div class="pd-body-pad">
        <div class="pd-rich">'.$data['isi'].'</div>
        <div class="pd-footer">
          <span class="pd-update">Pembaruan terakhir: '.date("d F Y", strtotime($data['tgl_update'])).'</span>
          <a href="index.php" class="pd-back">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </svg>
            Kembali ke Beranda
          </a>
        </div>
      </div>
    </div>

    <!-- SIDEBAR -->
    <div class="pd-sidebar">';

/* Artikel Terkini */
$tengah .= '
      <div class="pd-sb-card">
        <div class="pd-sb-head">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="rgba(255,255,255,.7)">
            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/>
          </svg>
          <h4>Artikel Terkini</h4>
        </div>';

$q_art = $koneksi_db->sql_query("SELECT * FROM `artikel` WHERE publikasi=1 ORDER BY `id` DESC LIMIT 4");
while ($ar = $koneksi_db->sql_fetchrow($q_art)) {
    $url_art = trim(preg_replace('/-+/','-',preg_replace('/[^A-Za-z0-9\-]/','',str_replace(' ','-',$ar[1]))),'-');
    if (empty($url_art)) $url_art = 'artikel-'.$ar[0];
    $na  = catch_that_image($ar[2]);
    $tgl = datetimess($ar[5]);

    $tengah .= '<a class="pd-art-row" href="artikel/'.$ar[0].'/'.$url_art.'.html">';
    $tengah .= '<div class="pd-art-thumb">';
    if ($na) {
        $tengah .= '<img src="'.htmlspecialchars($na).'" alt="'.htmlspecialchars($ar[1]).'">';
    } elseif (!empty($ar['gambar'])) {
        $tengah .= '<img src="images/artikel/'.htmlspecialchars($ar['gambar']).'" alt="'.htmlspecialchars($ar[1]).'">';
    } else {
        $tengah .= '<div class="pd-art-thumb-ph"><svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z"/></svg></div>';
    }
    $tengah .= '</div>';
    $tengah .= '<div class="pd-art-text">
        <div class="pd-art-ttl">'.htmlspecialchars($ar[1]).'</div>
        <div class="pd-art-meta">
          <span>📅 '.$tgl.'</span>
          <span>👁 '.$ar[9].'</span>
        </div>
      </div></a>';
}
$tengah .= '</div>'; /* /artikel */

/* Program Lainnya */
$tengah .= '
      <div class="pd-sb-card">
        <div class="pd-sb-head">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="rgba(255,255,255,.7)">
            <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zm0 12.08L5.21 11 12 7.08 18.79 11 12 15.08zM1 17l11 6 11-6v-2L12 21 1 15v2z"/>
          </svg>
          <h4>Program Lainnya</h4>
        </div>';

$q_prog = $koneksi_db->sql_query("SELECT id, judul, slug FROM mod_program ORDER BY id ASC LIMIT 10");
while ($pr = $koneksi_db->sql_fetchrow($q_prog)) {
    $cls = ($pr['slug'] === $slug || $pr['id'] == $slug) ? 'pd-prog-row is-active' : 'pd-prog-row';
    $tengah .= '<a href="index.php?pilih=program&modul=yes&id='.htmlspecialchars($pr['slug']).'" class="'.$cls.'">
        <span class="pd-prog-dot"></span>
        '.htmlspecialchars($pr['judul']).'
    </a>';
}
$tengah .= '</div>'; /* /program */

/* Plugin bawaan CMS — render langsung tanpa card wrapper agar tombol tetap bisa diklik */
ob_start();
include "plugin/berita.php";
modul(1);
blok(1);
$tengah .= ob_get_clean();

$tengah .= '
    </div><!-- /sidebar -->
  </div><!-- /pd-body -->
</div><!-- /pd-wrap -->';

} // end else

echo $tengah;
?>