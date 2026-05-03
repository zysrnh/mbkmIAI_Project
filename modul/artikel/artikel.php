<?php
if (!defined('cms-KOMPONEN')) {
    Header("Location: ../index.php");
    exit;
}

global $koneksi_db, $tengah;

$_GET['aksi'] = !isset($_GET['aksi']) ? null : $_GET['aksi'];
$_GET['id']   = !isset($_GET['id'])   ? null : int_filter($_GET['id']);
$topik_id     = isset($_GET['topik']) ? int_filter($_GET['topik']) : 0;

$tengah .= '
<style>
@import url("https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap");

.pd-wrap, .pd-wrap * { box-sizing: border-box; }
.pd-wrap { font-family: "Plus Jakarta Sans", sans-serif; background: #F4F6F4; padding-bottom: 80px; }

/* HERO */
.pd-hero {
    background: linear-gradient(rgba(15, 45, 28, 0.88), rgba(27, 67, 50, 0.85)), url("images/Assets/KampusAtas.png");
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    padding: 70px 0 100px;
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
    max-width: 1280px; margin: -70px auto 0; padding: 0 24px;
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 24px; align-items: start; position: relative; z-index: 5;
}
@media (max-width: 991px) {
    .pd-body { grid-template-columns: 1fr; margin-top: -40px; }
}

/* MAIN CARD */
.pd-card {
    background: #fff; border-radius: 6px;
    box-shadow: 0 6px 32px rgba(27,67,50,.09);
    overflow: hidden; border: 1px solid #e8ede9;
}

/* LIST BERITA */
.news-item {
    display: flex; gap: 20px; padding: 22px 24px;
    border-bottom: 1px solid #f0f4f1;
    transition: background .18s; text-decoration: none !important; color: inherit;
}
.news-item:last-child { border-bottom: none; }
.news-item:hover { background: #f9fbf9; }
.news-img {
    width: 200px; min-width: 200px; height: 140px;
    border-radius: 8px; overflow: hidden; background: #eee; flex-shrink: 0;
}
.news-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
.news-cont { flex: 1; min-width: 0; display: flex; flex-direction: column; justify-content: center; }
.news-meta { font-size: 10.5px; font-weight: 700; color: #2D6A4F; text-transform: uppercase; margin-bottom: 8px; }
.news-ttl { font-size: 17px; font-weight: 800; color: #1B4332; margin: 0 0 9px; line-height: 1.35; }
.news-desc {
    font-size: 13.5px; color: #666; line-height: 1.65; margin-bottom: 12px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.news-read { font-size: 12px; font-weight: 700; color: #1B4332; }

@media (max-width: 600px) {
    .news-item { flex-direction: column; }
    .news-img { width: 100%; min-width: 100%; height: 170px; }
}

/* DETAIL ARTIKEL */
.art-cover-wrap { width: 100%; display: block; cursor: zoom-in; border-bottom: 1px solid #e8ede9; background: #f8faf9; }
.art-cover { width: 100%; max-height: 460px; object-fit: cover; display: block; transition: opacity .2s; }
.art-cover:hover { opacity: .92; }

#art-lightbox {
    position: fixed; inset: 0; background: rgba(0,0,0,.9); z-index: 99999;
    display: none; align-items: center; justify-content: center; padding: 40px; cursor: zoom-out;
}
#art-lightbox:target { display: flex; }
#art-lightbox img { max-width: 100%; max-height: 100%; border-radius: 6px; box-shadow: 0 0 50px rgba(0,0,0,0.5); }

.art-body { padding: 48px 56px 44px; }
@media (max-width: 768px) { .art-body { padding: 24px 20px 28px; } }

.art-meta {
    display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
    font-size: 11px; font-weight: 700; color: #2D6A4F;
    text-transform: uppercase; letter-spacing: .5px;
    margin-bottom: 24px; padding-bottom: 18px; border-bottom: 1px solid #f0f4f1;
}

.art-rich { font-size: 15.5px; line-height: 1.88; color: #333; }
.art-rich p { margin-bottom: 16px !important; text-align: justify !important; }
.art-rich h1, .art-rich h2 {
    font-family: "Plus Jakarta Sans", sans-serif !important;
    font-size: 19px !important; font-weight: 800 !important; color: #1B4332 !important;
    margin: 38px 0 14px !important; padding-left: 16px !important;
    border-left: 4px solid #2D6A4F !important; line-height: 1.3 !important; text-transform: none !important; letter-spacing: -.2px !important;
}
.art-rich h3 { font-family: "Plus Jakarta Sans", sans-serif !important; font-size: 15.5px !important; font-weight: 700 !important; color: #2D6A4F !important; margin: 26px 0 10px !important; text-transform: none !important; }
.art-rich ul, .art-rich ol { padding-left: 20px !important; margin-bottom: 18px !important; }
.art-rich li { margin-bottom: 8px !important; }
.art-rich ul li::marker { color: #2D6A4F; }
.art-rich b, .art-rich strong { color: #1B4332 !important; font-weight: 700 !important; }
.art-rich img { max-width: 100% !important; border-radius: 6px !important; margin: 12px 0 !important; }

/* FOOTER / BACK BUTTON */
.pd-footer {
    margin-top: 44px; padding-top: 20px; border-top: 1px solid #edf2ea;
    display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;
}
.art-back {
    display: inline-flex; align-items: center; gap: 7px;
    background: #1B4332; color: #fff !important;
    padding: 9px 20px; border-radius: 7px;
    font-size: 13px; font-weight: 700; text-decoration: none !important;
    transition: background .22s, transform .22s;
}
.art-back:hover { background: #2D6A4F; transform: translateX(-2px); }

/* SIDEBAR */
.pd-sidebar { display: flex; flex-direction: column; gap: 18px; }

/* Styling plugin CMS biar sinkron */
.modern-sidebar { gap: 0 !important; }
.sidebar-section {
    border-radius: 6px !important;
    overflow: hidden !important;
    border: 1px solid #e8ede9 !important;
    box-shadow: 0 4px 14px rgba(27,67,50,.07) !important;
    margin-bottom: 18px !important;
    background: #fff !important;
}
.sidebar-header {
    background: #1B4332 !important;
    color: #fff !important;
    padding: 12px 18px !important;
    font-family: "Plus Jakarta Sans", sans-serif !important;
    font-size: 11.5px !important; font-weight: 800 !important; letter-spacing: 1.8px !important;
    text-transform: uppercase !important;
}
</style>';

// ARSIP / LIST
if ($_GET['aksi'] == "arsip" || $_GET['aksi'] == "") {
    $hasil      = $koneksi_db->sql_query("SELECT * FROM topik WHERE id=$topik_id");
    $topik_data = $koneksi_db->sql_fetchrow($hasil);
    $rubrik     = $topik_data ? $topik_data['topik'] : 'Berita Kampus';

    $tengah .= '
    <div class="pd-wrap">
      <div class="pd-hero">
        <div class="pd-hero-in">
          <div class="pd-eyebrow"><span></span>Berita Terkini</div>
          <h1>'.htmlspecialchars($rubrik).'</h1>
        </div>
      </div>
      <div class="pd-body">
        <div class="pd-card">';

    $limit  = 10;
    $offset = isset($_GET['offset']) ? int_filter($_GET['offset']) : 0;
    $totals = $koneksi_db->sql_query("SELECT id FROM artikel WHERE publikasi=1 AND topik=$topik_id");
    $jumlah = $koneksi_db->sql_numrows($totals);

    if ($jumlah > 0) {
        $q = $koneksi_db->sql_query("SELECT * FROM artikel WHERE publikasi=1 AND topik=$topik_id ORDER BY id DESC LIMIT $offset, $limit");
        while ($ar = $koneksi_db->sql_fetchrow($q)) {
            $url_judul = str_replace(" ", "-", $ar['judul']);
            $img       = !empty($ar['gambar']) ? 'images/artikel/'.$ar['gambar'] : 'images/default-news.jpg';
            $tengah   .= '
            <a href="artikel/'.$ar['id'].'/'.$url_judul.'.html" class="news-item">
                <div class="news-img"><img src="'.$img.'" alt="'.htmlspecialchars($ar['judul']).'"></div>
                <div class="news-cont">
                    <div class="news-meta">📅 '.datetimess($ar['tgl']).'</div>
                    <h2 class="news-ttl">'.$ar['judul'].'</h2>
                    <div class="news-desc">'.limitTXT(strip_tags($ar['konten']), 160).'</div>
                    <div class="news-read">Baca Selengkapnya →</div>
                </div>
            </a>';
        }

        if ($jumlah > $limit) {
            include_once 'modul/function.php';
            $a   = new paging($limit);
            $pg  = isset($_GET['pg'])  ? int_filter($_GET['pg'])  : 1;
            $stg = isset($_GET['stg']) ? int_filter($_GET['stg']) : 1;
            $tengah .= '<div style="padding:20px 24px; border-top:1px solid #f0f4f1; text-align:center;">';
            $tengah .= $a->getPaging6($jumlah, $pg, $stg, $topik_id, $rubrik);
            $tengah .= '</div>';
        }
    } else {
        $tengah .= '<div style="padding:80px 40px; text-align:center; color:#888;">Belum ada berita di kategori ini.</div>';
    }

    $tengah .= '
        </div><!-- /pd-card -->

        <!-- SIDEBAR -->
        <div class="pd-sidebar">';
    
    /* Render Plugins CMS */
    ob_start();
    include "plugin/berita.php";
    modul(1);
    blok(1);
    $sidebar_content = ob_get_clean();

    if (!empty(trim($sidebar_content))) {
        $tengah .= $sidebar_content;
    } else {
        $tengah .= '<div class="sidebar-section">
                    <div class="sidebar-header">Berita Lainnya</div>';
        $q_p = $koneksi_db->sql_query("SELECT judul, id FROM artikel WHERE publikasi=1 ORDER BY id DESC LIMIT 5");
        while($p = $koneksi_db->sql_fetchrow($q_p)) {
            $url_judul = str_replace(" ", "-", $p['judul']);
            $tengah .= '<a href="artikel/'.$p['id'].'/'.$url_judul.'.html" style="display:block;padding:10px 15px;text-decoration:none;color:#333;border-bottom:1px solid #f0f0f0;font-size:13px;line-height:1.4;">'.$p['judul'].'</a>';
        }
        $tengah .= '</div>';
    }

    $tengah .= '
        </div><!-- /pd-sidebar -->
      </div><!-- /pd-body -->
    </div><!-- /pd-wrap -->';
}

// LIHAT DETAIL
if ($_GET['aksi'] == "lihat") {
    $id    = int_filter($_GET['id']);
    $hasil = $koneksi_db->sql_query("SELECT * FROM artikel WHERE id='$id' AND publikasi=1");
    $data  = $koneksi_db->sql_fetchrow($hasil);

    if (!$data) { Header("Location: index.php"); exit; }

    $tengah .= '
    <div class="pd-wrap">
      <div class="pd-hero">
        <div class="pd-hero-in">
          <div class="pd-eyebrow"><span></span>Detail Berita</div>
          <h1>'.htmlspecialchars($data['judul']).'</h1>
        </div>
      </div>
      <div class="pd-body">
        <div class="pd-card">';

    if (!empty($data['gambar'])) {
        $img_path = 'images/artikel/'.htmlspecialchars($data['gambar']);
        $tengah  .= '
        <a href="#art-lightbox" class="art-cover-wrap" title="Klik untuk lihat gambar penuh">
          <img src="'.$img_path.'" class="art-cover" alt="'.htmlspecialchars($data['judul']).'">
        </a>
        <div id="art-lightbox" onclick="location.hash=\'#\'">
          <img src="'.$img_path.'" alt="Full Preview">
        </div>';
    }

    $tengah .= '
          <div class="art-body">
            <div class="art-meta">
              <span>📅 '.datetimess($data['tgl']).'</span>
              <span style="color:#dde;">|</span>
              <span>👁 '.$data['hits'].' views</span>
            </div>
            <div class="art-rich">'.$data['konten'].'</div>
            <div class="pd-footer">
              <span class="pd-update"></span>
              <a href="javascript:history.back()" class="art-back">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                </svg>
                Kembali
              </a>
            </div>
          </div>
        </div><!-- /pd-card -->

        <!-- SIDEBAR -->
        <div class="pd-sidebar">';
    
    /* Render Plugins CMS */
    ob_start();
    include "plugin/berita.php";
    modul(1);
    blok(1);
    $sidebar_content = ob_get_clean();

    if (!empty(trim($sidebar_content))) {
        $tengah .= $sidebar_content;
    } else {
        $tengah .= '<div class="sidebar-section">
                    <div class="sidebar-header">Berita Lainnya</div>';
        $q_p = $koneksi_db->sql_query("SELECT judul, id FROM artikel WHERE publikasi=1 ORDER BY id DESC LIMIT 5");
        while($p = $koneksi_db->sql_fetchrow($q_p)) {
            $url_judul = str_replace(" ", "-", $p['judul']);
            $tengah .= '<a href="artikel/'.$p['id'].'/'.$url_judul.'.html" style="display:block;padding:10px 15px;text-decoration:none;color:#333;border-bottom:1px solid #f0f0f0;font-size:13px;line-height:1.4;">'.$p['judul'].'</a>';
        }
        $tengah .= '</div>';
    }

    $tengah .= '
        </div><!-- /pd-sidebar -->
      </div><!-- /pd-body -->
    </div><!-- /pd-wrap -->';
}

echo $tengah;
?>