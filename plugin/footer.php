<?php
global $koneksi_db;

// Query profil di awal supaya tersedia di brand col & contact col
$data = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM mod_data_profil LIMIT 1"));
if (!$data) $data = array();
?>
<style>
/* ============================================================
   FOOTER - COMPACT & CLEAN
   ============================================================ */
.classic-footer {
    background: #1B4332;
    color: #F8F9FA;
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    padding: 48px 0 0;
}
.footer-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
}
.footer-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr 1fr 1.2fr;
    gap: 32px;
    padding-bottom: 36px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}
@media (max-width: 992px) {
    .footer-grid { grid-template-columns: 1fr 1fr; gap: 28px; }
}
@media (max-width: 576px) {
    .footer-grid { grid-template-columns: 1fr; gap: 24px; }
    .classic-footer { padding: 36px 0 0; }
}
.footer-col h4 {
    font-size: 12px;
    font-weight: 800;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin: 0 0 16px;
    padding-bottom: 10px;
    position: relative;
}
.footer-col h4::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    width: 28px; height: 2px;
    background: #2D6A4F;
    border-radius: 1px;
}
.footer-brand-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
    text-decoration: none;
}
.footer-brand-logo img {
    height: 36px; width: auto;
    filter: brightness(0) invert(1);
    opacity: 0.9;
}
.footer-brand-name { font-size: 13px; font-weight: 800; color: #fff; line-height: 1.2; }
.footer-brand-sub { font-size: 9px; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 0.8px; font-weight: 500; }
.footer-col p { font-size: 12.5px; line-height: 1.75; color: rgba(221,229,205,0.7); margin: 0 0 16px; max-width: 260px; }
.footer-socials { display: flex; gap: 8px; margin-top: 4px; }
.social-icon-modern {
    width: 32px; height: 32px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.7);
    transition: background 0.2s, color 0.2s, border-color 0.2s;
    text-decoration: none;
}
.social-icon-modern:hover { background: #2D6A4F; border-color: #2D6A4F; color: #fff; }
.footer-links { list-style: none; padding: 0; margin: 0; }
.footer-links li { margin-bottom: 8px; }
.footer-links a {
    color: rgba(221,229,205,0.72);
    text-decoration: none;
    font-size: 12.5px;
    font-weight: 500;
    line-height: 1.4;
    transition: color 0.2s, padding-left 0.2s;
    display: inline-block;
}
.footer-links a:hover { color: #fff; padding-left: 4px; text-decoration: none; }
.footer-links-subhead {
    font-size: 10px; font-weight: 800;
    color: rgba(255,255,255,0.4);
    text-transform: uppercase; letter-spacing: 1.8px;
    margin: 18px 0 8px; display: block;
}
.footer-contact-item { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 12px; }
.fc-icon {
    width: 28px; height: 28px;
    background: rgba(45,106,79,0.35);
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; margin-top: 1px;
}
.fc-icon svg { fill: #a8d5b5; }
.fc-text { font-size: 12.5px; color: rgba(221,229,205,0.75); line-height: 1.55; font-weight: 500; }
.footer-bottom-wrap { border-top: 1px solid rgba(255,255,255,0.07); }
.footer-bottom {
    padding: 14px 24px;
    display: flex; align-items: center; justify-content: space-between;
    font-size: 11.5px; color: rgba(221,229,205,0.4);
    flex-wrap: wrap; gap: 8px;
    max-width: 1200px; margin: 0 auto;
}
.footer-bottom a { color: rgba(221,229,205,0.3); text-decoration: none; font-size: 11px; transition: color 0.2s; }
.footer-bottom a:hover { color: rgba(221,229,205,0.6); }
@media (max-width: 576px) { .footer-bottom { justify-content: center; text-align: center; } }
</style>

<footer class="classic-footer">
    <div class="footer-inner">
        <div class="footer-grid">

            <!-- Col 1: Brand -->
            <div class="footer-col">
                <a href="index.php" class="footer-brand-logo">
                    <img src="images/Assets/LogoIAI.png" alt="Logo IAI">
                    <div>
                        <div class="footer-brand-name">MBKM IAI PI BANDUNG</div>
                        <div class="footer-brand-sub">Institut Agama Islam Persis Bandung</div>
                    </div>
                </a>
                <p><?php echo !empty($data['slogan']) ? htmlspecialchars($data['slogan']) : 'Belajar Bebas, Berkarya Nyata.'; ?></p>
                <div class="footer-socials">
                    <a href="#" class="social-icon-modern" title="Facebook">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor"><path d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V15.39h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 3.39h-2.33v6.489C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z"/></svg>
                    </a>
                    <a href="#" class="social-icon-modern" title="Twitter/X">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor"><path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.05c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/></svg>
                    </a>
                    <a href="#" class="social-icon-modern" title="Instagram">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                    </a>
                    <a href="#" class="social-icon-modern" title="YouTube">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor"><path d="M21.582 7.186a2.506 2.506 0 0 0-1.762-1.773C18.254 5 12 5 12 5s-6.254 0-7.82.413A2.506 2.506 0 0 0 2.418 7.186 26.26 26.26 0 0 0 2 12a26.26 26.26 0 0 0 .418 4.814 2.506 2.506 0 0 0 1.762 1.773C5.746 19 12 19 12 19s6.254 0 7.82-.413a2.506 2.506 0 0 0 1.762-1.773A26.26 26.26 0 0 0 22 12a26.26 26.26 0 0 0-.418-4.814zM10 15V9l5.2 3-5.2 3z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Col 2 & 3: Dynamic menus from DB -->
            <?php
            $hasil3 = $koneksi_db->sql_query("SELECT * FROM menu2 WHERE published=1 ORDER BY ordering");
            $menus  = array();
            while ($dm = $koneksi_db->sql_fetchrow($hasil3)) {
                $menus[] = $dm;
            }

            if (!empty($menus)) {
                $half     = (int)ceil(count($menus) / 2);
                $col_sets = array(
                    array_slice($menus, 0, $half),
                    array_slice($menus, $half)
                );

                foreach ($col_sets as $col_menus) {
                    if (empty($col_menus)) continue;
                    echo '<div class="footer-col">';
                    $is_first = true;

                    foreach ($col_menus as $m) {
                        $idmenu = intval($m['id']);

                        // Get sub-menus
                        $subs_q = $koneksi_db->sql_query(
                            "SELECT * FROM submenu2 WHERE published='1' AND parent='".$idmenu."' ORDER BY ordering ASC"
                        );
                        $subs = array();
                        while ($sub = $koneksi_db->sql_fetchrow($subs_q)) {
                            $subs[] = $sub;
                        }

                        // Heading
                        if ($is_first) {
                            echo '<h4>'.htmlspecialchars($m['menu2']).'</h4>';
                        } else {
                            echo '<span class="footer-links-subhead">'.htmlspecialchars($m['menu2']).'</span>';
                        }

                        // Links
                        if (!empty($subs)) {
                            echo '<ul class="footer-links">';
                            foreach ($subs as $sub) {
                                $sub_url = !empty($sub['url']) ? $sub['url'] : '#';
                                echo '<li><a href="'.htmlspecialchars($sub_url).'">'.htmlspecialchars($sub['menu2']).'</a></li>';
                            }
                            echo '</ul>';
                        } else {
                            $m_url = !empty($m['url']) ? $m['url'] : '#';
                            echo '<ul class="footer-links">';
                            echo '<li><a href="'.htmlspecialchars($m_url).'">'.htmlspecialchars($m['menu2']).'</a></li>';
                            echo '</ul>';
                        }

                        $is_first = false;
                    }
                    echo '</div>'; // /footer-col
                }

            } else {
                // Fallback static menu
                echo '<div class="footer-col">
                    <h4>Tautan Cepat</h4>
                    <ul class="footer-links">
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="#">Program MBKM</a></li>
                        <li><a href="#">Tim Kami</a></li>
                        <li><a href="kategori/1/Berita-Kampus.html">Berita</a></li>
                        <li><a href="index.php?pilih=flipbook&modul=yes">Pedoman</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Program</h4>
                    <ul class="footer-links">
                        <li><a href="#">Pertukaran Mahasiswa</a></li>
                        <li><a href="#">Kampus Mengajar</a></li>
                        <li><a href="#">Magang (MSIB)</a></li>
                        <li><a href="#">Studi Independen</a></li>
                        <li><a href="#">KKNT</a></li>
                    </ul>
                </div>';
            }
            ?>

            <!-- Col 4: Contact -->
            <div class="footer-col">
                <h4>Kontak</h4>

                <div class="footer-contact-item">
                    <div class="fc-icon">
                        <svg viewBox="0 0 24 24" width="13" height="13"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                    </div>
                    <div class="fc-text"><?php echo !empty($data['alamat']) ? htmlspecialchars($data['alamat']) : 'Jl. Ciganitri No 2 Cipagalo Buahahbatu, Bandung'; ?></div>
                </div>

                <div class="footer-contact-item">
                    <div class="fc-icon">
                        <svg viewBox="0 0 24 24" width="13" height="13"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                    </div>
                    <div class="fc-text"><?php echo !empty($data['telp']) ? htmlspecialchars($data['telp']) : '62 811-9081-122'; ?></div>
                </div>

                <div class="footer-contact-item">
                    <div class="fc-icon">
                        <svg viewBox="0 0 24 24" width="13" height="13"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    </div>
                    <div class="fc-text"><?php echo !empty($data['email']) ? htmlspecialchars($data['email']) : 'info@iaipibandung.ac.id'; ?></div>
                </div>
            </div>

        </div><!-- /footer-grid -->
    </div><!-- /footer-inner -->

    <div class="footer-bottom-wrap">
        <div class="footer-bottom">
            <div>&copy; <?php echo date('Y'); ?> MBKM IAI PI Bandung. All rights reserved.</div>
            <div><a href="admin.html">Admin Portal</a></div>
        </div>
    </div>

</footer>