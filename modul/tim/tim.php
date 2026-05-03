<?php
if (!defined('cms-KONTEN')) {
    Header("Location: ../../index.php");
    exit;
}
global $koneksi_db, $tengah;

// Check if there is an ID/Slug for detail view
$slug = isset($_GET['id']) ? cleantext($_GET['id']) : '';

// --- CSS STYLING ---
$style = '
<style>
@import url("https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap");

.tim-wrap { font-family: "Plus Jakarta Sans", sans-serif; background: #f8faf9; min-height: 500px; padding-bottom: 60px; }

/* HERO AREA */
.tim-hero {
    background: linear-gradient(rgba(15, 45, 28, 0.88), rgba(27, 67, 50, 0.85)), url("images/Assets/KampusAtas.png");
    background-size: cover; background-position: center; padding: 140px 0 80px; text-align: center; color: #fff;
}
.tim-hero h1 { font-size: 38px; font-weight: 900; margin: 0; letter-spacing: -1px; color: #ffffff !important; }
.tim-eyebrow { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; color: rgba(255,255,255,0.7); margin-bottom: 10px; }

.tim-container {
    max-width: 1100px; margin: -40px auto 0; padding: 0 20px; position: relative; z-index: 10;
}

/* Grid */
.tim-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 25px;
}

/* Card */
.tim-card {
    background: #fff; border-radius: 12px; padding: 30px 20px; text-align: center; text-decoration: none; color: inherit;
    transition: transform 0.3s, box-shadow 0.3s; display: flex; flex-direction: column; align-items: center;
    border: 1px solid #edf2ef; box-shadow: 0 10px 30px rgba(27,67,50,0.05);
}
.tim-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(27,67,50,0.1); border-color: #d1e0d7; }

/* Square Image */
.tim-img {
    width: 180px; height: 180px; object-fit: cover; border-radius: 12px; margin-bottom: 20px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08); border: 4px solid #fff;
}

.tim-name { font-size: 18px; font-weight: 800; color: #1b4332; margin-bottom: 6px; }
.tim-role { font-size: 13px; font-weight: 700; color: #2d6a4f; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px; }
.tim-instansi { font-size: 12px; color: #666; }

/* Detail View */
.tim-detail-card {
    background: #fff; border-radius: 20px; padding: 50px; max-width: 800px; margin: 0 auto;
    box-shadow: 0 15px 50px rgba(0,0,0,0.05); border: 1px solid #edf2ef; display: flex; gap: 40px; align-items: center;
}
@media (max-width: 768px) { .tim-detail-card { flex-direction: column; padding: 30px; text-align: center; } }

.tim-detail-img {
    width: 280px; height: 280px; object-fit: cover; border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 6px solid #fff;
}
.tim-detail-info h2 { font-size: 32px; font-weight: 900; color: #1b4332; margin-bottom: 10px; }
.tim-detail-info .role { font-size: 18px; font-weight: 700; color: #2d6a4f; margin-bottom: 5px; }
.tim-detail-info .inst { font-size: 15px; color: #666; margin-bottom: 25px; }

.tim-detail-wa {
    display: inline-flex; align-items: center; gap: 10px; background: #25D366; color: #fff;
    padding: 12px 25px; border-radius: 30px; text-decoration: none; font-weight: 800; font-size: 14px;
    transition: transform 0.2s, box-shadow 0.2s;
}
.tim-detail-wa:hover { transform: scale(1.05); box-shadow: 0 8px 20px rgba(37,211,102,0.3); }
.tim-detail-wa svg { width: 20px; height: 20px; fill: currentColor; }

.tim-back-btn {
    display: inline-flex; align-items: center; gap: 8px; margin-top: 30px;
    color: #2d6a4f; text-decoration: none; font-weight: 700; font-size: 14px;
}
.tim-back-btn:hover { color: #1b4332; }
</style>
';

$tengah .= $style;

if (empty($slug)) {
    // LIST VIEW
    $tengah .= '<div class="tim-wrap">';
    $tengah .= '<div class="tim-hero">
                    <div class="tim-eyebrow">Merdeka Belajar Kampus Merdeka</div>
                    <h1>Tim MBKM</h1>
                </div>';
    $tengah .= '<div class="tim-container">';
    $tengah .= '<div class="tim-grid">';
    
    $q = $koneksi_db->sql_query("SELECT * FROM mod_tim ORDER BY urutan ASC, id DESC");
    if ($koneksi_db->sql_numrows($q) > 0) {
        while ($row = $koneksi_db->sql_fetchrow($q)) {
            $img = !empty($row['foto']) ? 'images/pages/'.$row['foto'] : 'images/no-image.jpg';
            $link_id = !empty($row['slug']) ? $row['slug'] : $row['id'];
            $tengah .= '
            <a href="index.php?pilih=tim&modul=yes&id='.$link_id.'" class="tim-card">
                <img src="'.$img.'" class="tim-img" alt="'.$row['nama'].'">
                <div class="tim-role">'.$row['jabatan'].'</div>
                <div class="tim-name">'.$row['nama'].'</div>
                '.(!empty($row['instansi']) ? '<div class="tim-instansi">'.$row['instansi'].'</div>' : '').'
            </a>';
        }
    } else {
        $tengah .= '<div style="text-align:center; grid-column: 1/-1; padding: 100px 0; color: #888;">Belum ada anggota tim.</div>';
    }
    
    $tengah .= '</div></div></div>';

} else {
    // DETAIL VIEW
    $where = is_numeric($slug) ? "id='$slug'" : "slug='$slug'";
    $q = $koneksi_db->sql_query("SELECT * FROM mod_tim WHERE $where LIMIT 1");
    if ($koneksi_db->sql_numrows($q) > 0) {
        $row = $koneksi_db->sql_fetchrow($q);
        $img = !empty($row['foto']) ? 'images/pages/'.$row['foto'] : 'images/no-image.jpg';
        
        $tengah .= '<div class="tim-wrap">';
        $tengah .= '<div class="tim-hero">
                        <div class="tim-eyebrow">Profil Anggota Tim</div>
                        <h1>Detail Personil</h1>
                    </div>';
        $tengah .= '<div class="tim-container" style="margin-top: -60px;">';
        $tengah .= '<div class="tim-detail-card">';
        
        $tengah .= '<img src="'.$img.'" class="tim-detail-img" alt="'.$row['nama'].'">';
        $tengah .= '<div class="tim-detail-info">
                        <div class="role">'.$row['jabatan'].'</div>
                        <h2>'.$row['nama'].'</h2>
                        <div class="inst">'.$row['instansi'].'</div>';
        
        if (!empty($row['whatsapp'])) {
            $wa = preg_replace('/[^0-9]/', '', $row['whatsapp']);
            if (substr($wa, 0, 1) == '0') $wa = '62' . substr($wa, 1);
            
            $tengah .= '<a href="https://wa.me/'.$wa.'" target="_blank" class="tim-detail-wa" title="Hubungi via WhatsApp">
                <svg viewBox="0 0 24 24"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 6.46 17.5 2 12.04 2M12.05 19.83C10.55 19.83 9.12 19.42 7.87 18.68L7.58 18.51L4.45 19.33L5.28 16.28L5.09 15.98C4.28 14.7 3.84 13.2 3.84 11.66C3.84 7.14 7.53 3.45 12.05 3.45C16.57 3.45 20.26 7.14 20.26 11.66C20.26 16.18 16.57 19.83 12.05 19.83M16.56 14.54C16.31 14.41 15.09 13.82 14.86 13.73C14.64 13.64 14.47 13.6 14.31 13.86C14.14 14.1 13.68 14.66 13.53 14.83C13.39 15 13.23 15.02 12.98 14.9C12.73 14.77 11.93 14.51 10.98 13.67C10.23 13 9.72 12.18 9.57 11.93C9.43 11.68 9.56 11.54 9.68 11.42C9.79 11.31 9.93 11.14 10.05 10.99C10.18 10.85 10.22 10.74 10.31 10.58C10.39 10.42 10.35 10.28 10.29 10.15C10.23 10.02 9.73 8.78 9.53 8.27C9.33 7.78 9.13 7.84 8.98 7.83C8.84 7.83 8.67 7.82 8.51 7.82C8.35 7.82 8.08 7.88 7.85 8.13C7.62 8.38 6.98 8.98 6.98 10.19C6.98 11.41 7.89 12.58 8.01 12.75C8.13 12.91 9.75 15.42 12.26 16.5C12.86 16.76 13.33 16.91 13.69 17.03C14.29 17.22 14.83 17.19 15.26 17.12C15.74 17.04 16.77 16.49 16.98 15.89C17.19 15.29 17.19 14.78 17.12 14.66C17.05 14.54 16.88 14.47 16.63 14.34Z"/></svg>
                Chat WhatsApp
            </a>';
        }
        
        $tengah .= '</div></div>';
        $tengah .= '<center><a href="index.php?pilih=tim&modul=yes" class="tim-back-btn">← Kembali ke Daftar Tim</a></center>';
        $tengah .= '</div></div>';
    } else {
        $tengah .= '<div class="tim-wrap"><div class="tim-hero"><h1>Oops!</h1></div><div class="tim-container"><div style="text-align:center; padding:50px; background:#fff; border-radius:12px;">Data tidak ditemukan.</div></div></div>';
    }
}

echo $tengah;
?>
