<?php global $koneksi_db; ?>
<style>
/* ============================================================
   FOOTER - MODERN CLASSIC AESTHETIC
   ============================================================ */
.classic-footer {
    background-color: #545837;
    color: #DDE5CD;
    font-family: 'Inter', sans-serif;
    padding: 60px 20px 20px;
}
.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
    margin-bottom: 40px;
}
.footer-col h4 {
    font-family: 'Playfair Display', serif;
    font-size: 20px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 24px;
    position: relative;
    padding-bottom: 12px;
}
.footer-col h4::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    width: 40px; height: 2px;
    background-color: #9EBB97;
}
.footer-col p {
    font-size: 14px;
    line-height: 1.8;
    color: rgba(221,229,205,0.8);
    margin-bottom: 15px;
}
.footer-links {
    list-style: none;
    padding: 0; margin: 0;
}
.footer-links li {
    margin-bottom: 12px;
}
.footer-links a {
    color: rgba(221,229,205,0.8);
    text-decoration: none;
    font-size: 14px;
    transition: color 0.3s ease;
    display: inline-block;
}
.footer-links a:hover {
    color: #9EBB97;
    transform: translateX(4px);
}
.footer-socials {
    display: flex; gap: 15px; margin-top: 20px;
}
.social-icon-modern {
    width: 36px; height: 36px;
    background-color: rgba(221,229,205,0.1);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #DDE5CD;
    transition: all 0.3s ease;
    text-decoration: none;
}
.social-icon-modern:hover {
    background-color: #618D4F;
    color: #fff;
}
.footer-bottom {
    text-align: center;
    padding-top: 24px;
    border-top: 1px solid rgba(221,229,205,0.1);
    font-size: 13px;
    color: rgba(221,229,205,0.6);
}
</style>

<footer class="classic-footer">
    <div class="footer-container">
        <!-- Kolom 1: Brand -->
        <div class="footer-col">
            <h4>MBKM IAI PI Bandung</h4>
            <?php
            $data = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM mod_data_profil LIMIT 1"));
            ?>
            <p><?= !empty($data['slogan']) ? htmlspecialchars($data['slogan']) : 'Institut Agama Islam Persis Bandung provides a prestigious, forward-thinking academic environment deeply rooted in classic university traditions.' ?></p>
            <div class="footer-socials">
                <a href="#" class="social-icon-modern"><svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V15.39h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 3.39h-2.33v6.489C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z"/></svg></a>
                <a href="#" class="social-icon-modern"><svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.05c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/></svg></a>
                <a href="#" class="social-icon-modern"><svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg></a>
            </div>
        </div>
        
        <?php
        // Mengembalikan query dinamis untuk kolom navigasi footer
        $hasil3 = $koneksi_db->sql_query("SELECT * FROM menu2 WHERE published=1 ORDER BY ordering");
        $menus  = [];
        while ($dm = $koneksi_db->sql_fetchrow($hasil3)) $menus[] = $dm;
        $total  = count($menus);
        // Max 2 kolom dinamis untuk footer-col
        if($total > 0):
            $per_col = max(1, ceil($total / 2));
            $chunks  = array_chunk($menus, $per_col);
            foreach ($chunks as $chunk):
        ?>
        <div class="footer-col">
            <?php foreach ($chunk as $index => $m): 
                $idmenu = $m['id'];
                // Tampilkan judul kolom hanya untuk elemen pertama di chunk ini
                if($index == 0) {
                    echo "<h4>" . htmlspecialchars($m['menu2']) . "</h4>";
                }
                
                $hasSub = $koneksi_db->sql_numrows($koneksi_db->sql_query(
                    "SELECT id FROM submenu2 WHERE parent='".$idmenu."' AND published='1'"
                )) > 0;
            ?>
                <?php if ($hasSub): ?>
                <ul class="footer-links" <?php if($index > 0) echo 'style="margin-top:20px;"'; ?>>
                    <?php if($index > 0): ?>
                        <h4 style="font-size:16px; margin-bottom:12px; padding-bottom:6px;"><?= htmlspecialchars($m['menu2']) ?></h4>
                    <?php endif; ?>
                    <?php
                    $subs = $koneksi_db->sql_query(
                        "SELECT * FROM submenu2 WHERE published='1' AND parent='".$idmenu."' ORDER BY ordering ASC"
                    );
                    while ($sub = $koneksi_db->sql_fetchrow($subs)):
                    ?>
                    <li><a href="<?= htmlspecialchars($sub['url']) ?>"><?= htmlspecialchars($sub['menu2']) ?></a></li>
                    <?php endwhile; ?>
                </ul>
                <?php else: ?>
                    <?php if($index > 0): ?>
                        <ul class="footer-links" style="margin-top:20px;">
                            <li><a href="<?= htmlspecialchars($m['url']) ?>"><?= htmlspecialchars($m['menu2']) ?></a></li>
                        </ul>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php 
            endforeach;
        else: // Fallback if no db menus
        ?>
        <div class="footer-col">
            <h4>Quick Links</h4>
            <ul class="footer-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php#programs">Academic Programs</a></li>
                <li><a href="index.php#facilities">Campus Facilities</a></li>
                <li><a href="index.php#about">About Us</a></li>
                <li><a href="index.php?pilih=hal&id=2">Apply Now</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Programs</h4>
            <ul class="footer-links">
                <li><a href="#">Pertukaran Mahasiswa</a></li>
                <li><a href="#">Kampus Mengajar</a></li>
                <li><a href="#">Magang</a></li>
            </ul>
        </div>
        <?php endif; ?>
        
        <!-- Kolom Contact Info -->
        <div class="footer-col" style="min-width: 280px;">
            <h4>Contact Info</h4>
            <p><svg viewBox="0 0 24 24" width="16" height="16" fill="#9EBB97" style="vertical-align: middle; margin-right: 8px;"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg> <?= !empty($data['alamat']) ? htmlspecialchars($data['alamat']) : 'Jl. Ciganitri Mukti Raya, Bandung' ?></p>
            <p><svg viewBox="0 0 24 24" width="16" height="16" fill="#9EBB97" style="vertical-align: middle; margin-right: 8px;"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg> <?= !empty($data['telp']) ? htmlspecialchars($data['telp']) : '+62 812-3456-7890' ?></p>
            <p><svg viewBox="0 0 24 24" width="16" height="16" fill="#9EBB97" style="vertical-align: middle; margin-right: 8px;"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg> <?= !empty($data['email']) ? htmlspecialchars($data['email']) : 'info@iaipibandung.ac.id' ?></p>
        </div>
    </div>
    
    <div class="footer-bottom">
        &copy; <?= date('Y') ?> MBKM IAI PI Bandung. All rights reserved. Designed with precision & elegance. 
        <a href="admin.html" style="margin-left:15px;color:rgba(221,229,205,0.4);text-decoration:none;font-size:11px;">Admin Portal</a>
    </div>
</footer>
<?php ?>