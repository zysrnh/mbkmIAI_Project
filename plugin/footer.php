<?php global $koneksi_db; ?>

<style>
/* ============================================================
   FOOTER — MBKM IAI PI Bandung
   Self-contained: wave tidak bergantung warna section di atas
   ============================================================ */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

/* ── Wrapper utama ── */
.footer-root {
    position: relative;
    margin-top: 0;
    font-family: 'Inter', sans-serif;
}

/* ── Wave: dark protrude ke atas, tanpa asumsi warna di atas ── */
.footer-wave-block {
    position: relative;
    height: 72px;
    overflow: hidden;
    background: transparent; /* tidak override warna section di atas */
}
.footer-wave-block svg {
    position: absolute;
    bottom: 0; left: 0;
    width: 100%; height: 100%;
    display: block;
}

/* ── Main body footer ── */
.footer-body {
    background: #1e2d20;
    padding: 48px 0 36px;
}

/* brand */
.f-icon-wrap {
    width: 42px; height: 42px;
    background: rgba(158,187,151,.13);
    border-radius: 10px;
    display: inline-flex; align-items: center; justify-content: center;
    margin-bottom: 14px;
}
.f-icon-wrap svg { width: 21px; height: 21px; fill: #9EBB97; }

.f-name {
    font-size: 15.5px; font-weight: 800;
    color: #DDE5CD; line-height: 1.3; margin: 0 0 3px;
}
.f-sub {
    display: block; font-size: 9px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 2.2px;
    color: #618D4F; margin-bottom: 14px;
}
.f-accent-line {
    width: 26px; height: 2px;
    background: #618D4F; border-radius: 1px;
    margin-bottom: 14px;
}
.f-desc {
    font-size: 12px; line-height: 1.85;
    color: rgba(221,229,205,.48); margin: 0 0 22px;
}

/* kontak */
.f-contacts { list-style: none; padding: 0; margin: 0; }
.f-contacts li {
    display: flex; gap: 9px; margin-bottom: 9px;
    font-size: 12px; color: rgba(221,229,205,.52);
    align-items: flex-start; line-height: 1.5;
}
.f-contacts li svg {
    width: 12px; height: 12px;
    fill: #618D4F; flex-shrink: 0; margin-top: 2px;
}

/* nav */
.f-nav-ttl {
    font-size: 9.5px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 2px;
    color: #9EBB97; margin: 0 0 12px;
    padding-bottom: 9px;
    border-bottom: 1px solid rgba(97,141,79,.16);
}
.f-links { list-style: none; padding: 0; margin: 0 0 22px; }
.f-links li { margin-bottom: 6px; }
.f-links li a {
    font-size: 12px; color: rgba(221,229,205,.48);
    text-decoration: none; display: block;
    transition: color .2s, padding-left .2s;
}
.f-links li a:hover { color: #9EBB97; text-decoration: none; padding-left: 5px; }

/* separator */
.footer-sep {
    border: none;
    border-top: 1px solid rgba(97,141,79,.10);
    margin: 0;
}

/* bottom bar */
.footer-bar {
    background: #131a13;
    padding: 13px 0;
}
.footer-bar-row {
    display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: 6px;
}
.f-copy {
    font-size: 11px; color: rgba(158,187,151,.38); margin: 0;
}
.f-copy strong { color: rgba(221,229,205,.55); font-weight: 600; }
.f-badge {
    font-size: 10.5px; color: rgba(158,187,151,.28); letter-spacing: .2px;
}

/* responsive */
@media (max-width: 767px) {
    .footer-body { padding: 32px 0 24px; }
    .f-col   { margin-bottom: 24px; }
    .footer-bar-row { flex-direction: column; align-items: flex-start; }
}
</style>

<!-- ============================================================
     FOOTER ROOT
     ============================================================ -->
<div class="footer-root">

    <!-- Wave protrude ke atas dari footer, independen warna di atasnya -->
    <div class="footer-wave-block">
        <svg viewBox="0 0 1440 72" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Fill #1e2d20: dark naik ke atas dengan kurva gentle -->
            <path d="M0,72 L0,52 C240,20 480,8 720,14 C960,20 1200,44 1440,52 L1440,72 Z" fill="#1e2d20"/>
        </svg>
    </div>

    <!-- FOOTER BODY -->
    <div class="footer-body">
        <div class="container">

            <?php
            $data  = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM mod_data_profil LIMIT 1"));
            $tahun = date('Y');
            ?>

            <div class="row">
                <!-- ── Brand + Kontak ── -->
                <div class="col-sm-3 col-xs-12 f-col" style="margin-bottom:32px; padding-right:20px;">
                    <div class="f-icon-wrap">
                        <svg viewBox="0 0 24 24"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zm0 12.08L5.21 11 12 7.08 18.79 11 12 15.08zM1 17l11 6 11-6v-2L12 21 1 15v2z"/></svg>
                    </div>
                    <div class="f-name"><?= !empty($data['nama']) ? htmlspecialchars($data['nama']) : 'MBKM IAI PI Bandung' ?></div>
                    <span class="f-sub">Merdeka Belajar Kampus Merdeka</span>
                    <div class="f-accent-line"></div>
                    <p class="f-desc">Menghadirkan pengalaman belajar autentik yang berdampak melalui 8 program MBKM resmi Kemdikbudristek RI.</p>
                    <ul class="f-contacts">
                        <?php if (!empty($data['alamat'])): ?>
                        <li><svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg><?= htmlspecialchars($data['alamat']) ?></li>
                        <?php endif; ?>
                        <?php if (!empty($data['telp'])): ?>
                        <li><svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>Telp. <?= htmlspecialchars($data['telp']) ?></li>
                        <?php endif; ?>
                        <?php if (!empty($data['email'])): ?>
                        <li><svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg><?= htmlspecialchars($data['email']) ?></li>
                        <?php endif; ?>
                        <?php if (!empty($data['slogan'])): ?>
                        <li><svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/></svg><?= htmlspecialchars($data['slogan']) ?></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- ── Kolom Nav dari Database ── -->
                <?php
                $hasil3 = $koneksi_db->sql_query("SELECT * FROM menu2 WHERE published=1 ORDER BY ordering");
                $menus  = [];
                while ($dm = $koneksi_db->sql_fetchrow($hasil3)) $menus[] = $dm;
                $total  = count($menus);
                // Max 3 kolom nav (@ col-sm-3)
                $per_col = max(1, ceil($total / 3));
                $chunks  = array_chunk($menus, $per_col);
                foreach ($chunks as $chunk):
                ?>
                <div class="col-sm-3 col-xs-6 f-col" style="margin-bottom:24px;">
                    <?php foreach ($chunk as $m):
                        $idmenu = $m['id'];
                        $hasSub = $koneksi_db->sql_numrows($koneksi_db->sql_query(
                            "SELECT id FROM submenu2 WHERE parent='".$idmenu."' AND published='1'"
                        )) > 0;
                    ?>
                    <div class="f-nav-ttl"><?= htmlspecialchars($m['menu2']) ?></div>
                    <?php if ($hasSub): ?>
                    <ul class="f-links">
                        <?php
                        $subs = $koneksi_db->sql_query(
                            "SELECT * FROM submenu2 WHERE published='1' AND parent='".$idmenu."' ORDER BY ordering ASC"
                        );
                        while ($sub = $koneksi_db->sql_fetchrow($subs)):
                        ?>
                        <li><a href="<?= htmlspecialchars($sub['url']) ?>"><?= htmlspecialchars($sub['menu2']) ?></a></li>
                        <?php endwhile; ?>
                    </ul>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>

            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .footer-body -->

    <hr class="footer-sep">

    <!-- Bottom Bar -->
    <div class="footer-bar">
        <div class="container">
            <div class="footer-bar-row">
                <p class="f-copy">&copy; <?= $tahun ?> <strong><?= !empty($data['nama']) ? htmlspecialchars($data['nama']) : 'IAI PI Bandung' ?></strong>. Hak cipta dilindungi undang-undang.</p>
                <span class="f-badge">Program MBKM &mdash; Kemdikbudristek RI</span>
            </div>
        </div>
    </div>

</div><!-- .footer-root -->