<?php global $koneksi_db; ?>

<style>
/* ============================================================
   LANDING PAGE MBKM IAI PI BANDUNG - INABA STYLE
   ============================================================ */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

* { box-sizing: border-box; }

/* ── 1. PROGRAM CARDS ── */
.program-section {
    padding: 70px 0 80px;
    background: #fff;
}
.section-eyebrow {
    color: #42a5f5;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    display: block;
    margin-bottom: 8px;
}
.section-title {
    color: #0d47a1;
    font-size: 32px;
    font-weight: 800;
    margin: 0 0 40px;
    line-height: 1.2;
}
.prog-card {
    border-radius: 14px;
    padding: 28px 22px 50px;
    min-height: 210px;
    position: relative;
    cursor: pointer;
    transition: transform .3s, box-shadow .3s;
    margin-bottom: 50px;
    overflow: hidden;
}
.prog-card:hover { transform: translateY(-8px); box-shadow: 0 18px 40px rgba(0,0,0,0.22); }
.prog-card .p-icon { font-size: 44px; display: block; margin-bottom: 14px; }
.prog-card h3 { color: #fff; font-size: 16px; font-weight: 700; margin: 0 0 10px; text-transform: uppercase; line-height: 1.3; }
.prog-card p { color: rgba(255,255,255,.88); font-size: 12px; line-height: 1.7; margin: 0; }
.prog-card .prog-btn {
    position: absolute; bottom: -22px; left: 50%; transform: translateX(-50%);
    width: 48px; height: 48px; border-radius: 50%; background: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; font-weight: bold; box-shadow: 0 4px 14px rgba(0,0,0,.2);
    text-decoration: none; transition: box-shadow .3s;
}
.prog-card .prog-btn:hover { box-shadow: 0 8px 22px rgba(0,0,0,.3); text-decoration: none; }

/* ── 2. STATISTIK ── */
.stats-section {
    background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
    padding: 60px 0;
}
.stat-item { text-align: center; padding: 20px; }
.stat-item .stat-icon { font-size: 36px; display: block; margin-bottom: 10px; color: rgba(255,255,255,.7); }
.stat-item .stat-num { font-size: 48px; font-weight: 900; color: #ffcc00; display: block; line-height: 1; }
.stat-item .stat-label { color: rgba(255,255,255,.85); font-size: 13px; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; margin-top: 6px; display: block; }

/* ── 3. DOKUMENTASI ── */
.dokum-section { padding: 70px 0; background: #f4f7fb; }
.dokum-section .section-title { text-align: center; }
.dokum-section .section-eyebrow { text-align: center; display: block; }
.dokum-slider-wrap { position: relative; overflow: hidden; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,.15); }
.dokum-slides { display: flex; transition: transform .5s ease; will-change: transform; }
.dokum-slide { min-width: 100%; position: relative; }
.dokum-slide img { width: 100%; height: 420px; object-fit: cover; display: block; }
.dokum-slide-cap {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: linear-gradient(to top, rgba(0,0,0,.7), transparent);
    padding: 30px 30px 20px; color: #fff;
}
.dokum-slide-cap h4 { margin: 0 0 4px; font-size: 18px; font-weight: 700; }
.dokum-slide-cap p { margin: 0; font-size: 13px; opacity: .85; }
.dokum-nav {
    position: absolute; top: 50%; transform: translateY(-50%);
    background: rgba(255,255,255,.25); border: none; color: #fff;
    width: 44px; height: 44px; border-radius: 50%; font-size: 20px;
    cursor: pointer; transition: background .3s; backdrop-filter: blur(4px);
}
.dokum-nav:hover { background: rgba(255,255,255,.5); }
.dokum-nav.prev { left: 15px; }
.dokum-nav.next { right: 15px; }
.dokum-dots { text-align: center; margin-top: 16px; }
.dokum-dot {
    display: inline-block; width: 10px; height: 10px; border-radius: 50%;
    background: #ccc; margin: 0 4px; cursor: pointer; transition: background .3s;
}
.dokum-dot.active { background: #0d47a1; }

/* ── 4. TESTIMONI ── */
.testi-section { padding: 80px 0; background: #fff; }
.testi-left h2 { font-size: 38px; font-weight: 900; color: #0d47a1; line-height: 1.15; margin: 0 0 20px; }
.testi-left p { font-size: 15px; color: #666; line-height: 1.7; margin: 0 0 30px; }
.testi-left .divider { width: 60px; height: 4px; background: #ffcc00; border-radius: 2px; }
.testi-card-wrap { position: relative; }
.testi-card {
    background: #f8fbff; border-radius: 16px;
    padding: 28px; border-left: 4px solid #0d47a1;
    margin-bottom: 20px;
}
.testi-card .testi-quote { font-size: 14px; color: #444; line-height: 1.8; margin: 0 0 20px; font-style: italic; }
.testi-card .testi-person { display: flex; align-items: center; gap: 14px; }
.testi-card .testi-avatar {
    width: 52px; height: 52px; border-radius: 50%; object-fit: cover;
    background: #dde; display: flex; align-items: center; justify-content: center;
    font-size: 24px; color: #0d47a1; overflow: hidden; flex-shrink: 0;
}
.testi-card .testi-name { font-weight: 700; font-size: 14px; color: #0d47a1; }
.testi-card .testi-role { font-size: 12px; color: #999; }

/* ── 5. CTA BANNER ── */
.cta-banner {
    background: linear-gradient(135deg, #0d47a1 0%, #1976d2 100%);
    padding: 50px 0;
    position: relative;
    overflow: hidden;
}
.cta-banner::before {
    content: '';
    position: absolute; top: -50%; left: -10%;
    width: 400px; height: 400px;
    background: rgba(255,255,255,.05);
    border-radius: 50%;
}
.cta-banner h2 { color: #fff; font-size: 26px; font-weight: 800; margin: 0; line-height: 1.3; }
.cta-banner .cta-brand { text-align: right; }
.cta-banner .cta-brand-name { color: #fff; font-size: 28px; font-weight: 900; letter-spacing: -1px; }
.cta-banner .cta-brand-sub { color: rgba(255,255,255,.7); font-size: 13px; }

/* ── 6. BERITA ── */
.berita-section { padding: 70px 0; background: #f4f7fb; }
.news-card {
    background: #fff; border-radius: 14px; overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.07);
    transition: transform .3s, box-shadow .3s;
    height: 100%; display: flex; flex-direction: column;
}
.news-card:hover { transform: translateY(-6px); box-shadow: 0 14px 35px rgba(0,0,0,.14); }
.news-card .nc-img { width: 100%; height: 200px; object-fit: cover; display: block; }
.news-card .nc-img-ph {
    width: 100%; height: 200px;
    background: linear-gradient(135deg,#0d47a1,#1976d2);
    display: flex; align-items: center; justify-content: center;
    font-size: 50px; color: rgba(255,255,255,.4);
}
.news-card .nc-body { padding: 20px; flex: 1; display: flex; flex-direction: column; }
.news-card .nc-cat {
    display: inline-block; background: #e3f0ff; color: #0d47a1;
    font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 20px; margin-bottom: 10px;
}
.news-card h3 { font-size: 15px; font-weight: 700; color: #1a1a2e; margin: 0 0 10px; line-height: 1.5; flex: 1; }
.news-card h3 a { color: inherit; text-decoration: none; }
.news-card h3 a:hover { color: #0d47a1; }
.news-card .nc-meta { font-size: 12px; color: #aaa; margin-top: auto; padding-top: 12px; border-top: 1px solid #f0f0f0; }
.btn-outline-mbkm {
    display: inline-block; border: 2px solid #0d47a1; color: #0d47a1;
    padding: 11px 30px; border-radius: 30px; font-weight: 600; font-size: 14px;
    text-decoration: none; transition: all .3s; margin-top: 30px;
}
.btn-outline-mbkm:hover { background: #0d47a1; color: #fff; text-decoration: none; }

/* Flipbook override */
.flipbook-modal-overlay.active { display: flex !important; }
</style>

<!-- ============================================================
     SECTION 1: 8 PROGRAM MBKM (dari database halaman)
     ============================================================ -->
<style>
section.about { padding-top:0!important; margin-top:0!important; }
.kotak-wrapper { padding-top:20px; padding-bottom:50px; }
.kotak-col { padding-left:10px; padding-right:10px; margin-bottom:50px; }
.kotak-inner { position:relative; padding:30px 25px 55px 25px; min-height:230px; transition:transform 0.3s ease, box-shadow 0.3s ease; cursor:pointer; border-radius:12px; }
.kotak-inner:hover { transform:translateY(-8px); box-shadow:0 15px 35px rgba(0,0,0,0.3); }
.kotak-inner .k-icon { font-size:55px; color:#ffffff; margin-bottom:15px; display:block; transition:transform 0.3s ease; }
.kotak-inner:hover .k-icon { transform:scale(1.15) rotate(5deg); }
.kotak-inner h3 { color:#ffffff; font-size:18px; font-weight:bold; text-transform:uppercase; margin:0 0 12px 0; line-height:1.3; }
.kotak-inner p { color:rgba(255,255,255,0.92); font-size:13px; line-height:1.7; margin:0; }
.kotak-btn { position:absolute; bottom:-22px; left:50%; margin-left:-25px; width:50px; height:50px; background:#ffffff; border-radius:50%; display:block; text-align:center; line-height:48px; font-size:24px; font-weight:bold; text-decoration:none; box-shadow:0 3px 12px rgba(0,0,0,0.25); transition:box-shadow 0.3s ease; z-index:99; }
.kotak-btn:hover { box-shadow:0 6px 20px rgba(0,0,0,0.35); opacity:0.85; text-decoration:none; }
.kotak-row { overflow:visible!important; }
</style>

<section class="about">
<div class="container kotak-wrapper" style="margin-top:0;">

    <!-- BARIS 1 -->
    <div class="row kotak-row" style="margin-bottom:30px;">

        <?php $perintah="SELECT * FROM halaman WHERE id='2'"; $hasil=$koneksi_db->sql_query($perintah);
        while($data=$koneksi_db->sql_fetchrow($hasil)){$urlkat=str_replace(" ","-",$data['judul']); echo '
        <div class="col-sm-3 kotak-col"><div class="kotak-inner" style="background-color:#1a3a5c;">
            <i class="fa fa-graduation-cap k-icon"></i><h3>'.$data[1].'</h3>
            <p>'.limitTXT(strip_tags($data['konten']),130).'</p>
            <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="kotak-btn" style="color:#1a3a5c;">&#8250;</a>
        </div></div>'; } ?>

        <?php $perintah="SELECT * FROM halaman WHERE id='3'"; $hasil=$koneksi_db->sql_query($perintah);
        while($data=$koneksi_db->sql_fetchrow($hasil)){$urlkat=str_replace(" ","-",$data['judul']); echo '
        <div class="col-sm-3 kotak-col"><div class="kotak-inner" style="background-color:#1a7a5c;">
            <i class="fa fa-briefcase k-icon"></i><h3>'.$data[1].'</h3>
            <p>'.limitTXT(strip_tags($data['konten']),130).'</p>
            <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="kotak-btn" style="color:#1a7a5c;">&#8250;</a>
        </div></div>'; } ?>

        <?php $perintah="SELECT * FROM halaman WHERE id='4'"; $hasil=$koneksi_db->sql_query($perintah);
        while($data=$koneksi_db->sql_fetchrow($hasil)){$urlkat=str_replace(" ","-",$data['judul']); echo '
        <div class="col-sm-3 kotak-col"><div class="kotak-inner" style="background-color:#5a3a7c;">
            <i class="fa fa-users k-icon"></i><h3>'.$data[1].'</h3>
            <p>'.limitTXT(strip_tags($data['konten']),130).'</p>
            <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="kotak-btn" style="color:#5a3a7c;">&#8250;</a>
        </div></div>'; } ?>

        <?php $perintah="SELECT * FROM halaman WHERE id='5'"; $hasil=$koneksi_db->sql_query($perintah);
        while($data=$koneksi_db->sql_fetchrow($hasil)){$urlkat=str_replace(" ","-",$data['judul']); echo '
        <div class="col-sm-3 kotak-col"><div class="kotak-inner" style="background-color:#1a5c7a;">
            <i class="fa fa-flask k-icon"></i><h3>'.$data[1].'</h3>
            <p>'.limitTXT(strip_tags($data['konten']),130).'</p>
            <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="kotak-btn" style="color:#1a5c7a;">&#8250;</a>
        </div></div>'; } ?>

    </div><!-- end baris 1 -->

    <!-- BARIS 2 -->
    <div class="row kotak-row">

        <?php $perintah="SELECT * FROM halaman WHERE id='6'"; $hasil=$koneksi_db->sql_query($perintah);
        while($data=$koneksi_db->sql_fetchrow($hasil)){$urlkat=str_replace(" ","-",$data['judul']); echo '
        <div class="col-sm-3 kotak-col"><div class="kotak-inner" style="background-color:#7a3a1a;">
            <i class="fa fa-handshake-o k-icon"></i><h3>'.$data[1].'</h3>
            <p>'.limitTXT(strip_tags($data['konten']),130).'</p>
            <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="kotak-btn" style="color:#7a3a1a;">&#8250;</a>
        </div></div>'; } ?>

        <?php $perintah="SELECT * FROM halaman WHERE id='7'"; $hasil=$koneksi_db->sql_query($perintah);
        while($data=$koneksi_db->sql_fetchrow($hasil)){$urlkat=str_replace(" ","-",$data['judul']); echo '
        <div class="col-sm-3 kotak-col"><div class="kotak-inner" style="background-color:#3a1a7a;">
            <i class="fa fa-lightbulb-o k-icon"></i><h3>'.$data[1].'</h3>
            <p>'.limitTXT(strip_tags($data['konten']),130).'</p>
            <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="kotak-btn" style="color:#3a1a7a;">&#8250;</a>
        </div></div>'; } ?>

        <?php $perintah="SELECT * FROM halaman WHERE id='8'"; $hasil=$koneksi_db->sql_query($perintah);
        while($data=$koneksi_db->sql_fetchrow($hasil)){$urlkat=str_replace(" ","-",$data['judul']); echo '
        <div class="col-sm-3 kotak-col"><div class="kotak-inner" style="background-color:#7a1a3a;">
            <i class="fa fa-rocket k-icon"></i><h3>'.$data[1].'</h3>
            <p>'.limitTXT(strip_tags($data['konten']),130).'</p>
            <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="kotak-btn" style="color:#7a1a3a;">&#8250;</a>
        </div></div>'; } ?>

        <?php $perintah="SELECT * FROM halaman WHERE id='9'"; $hasil=$koneksi_db->sql_query($perintah);
        while($data=$koneksi_db->sql_fetchrow($hasil)){$urlkat=str_replace(" ","-",$data['judul']); echo '
        <div class="col-sm-3 kotak-col"><div class="kotak-inner" style="background-color:#1a6a2a;">
            <i class="fa fa-home k-icon"></i><h3>'.$data[1].'</h3>
            <p>'.limitTXT(strip_tags($data['konten']),130).'</p>
            <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="kotak-btn" style="color:#1a6a2a;">&#8250;</a>
        </div></div>'; } ?>

    </div><!-- end baris 2 -->

</div><!-- end container -->
</section>


<!-- ============================================================
     SECTION 2: SAMBUTAN
     ============================================================ -->
<section style="padding:60px 0; background:#fff; border-top: 1px solid #f0f0f0;">
    <div class="container">
        <div class="row" style="align-items:center;">
            <div class="col-sm-5" style="margin-bottom:30px;">
                <div style="border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,.12); position:relative; background:#0d47a1; min-height:280px; display:flex; align-items:center; justify-content:center;">
                    <div style="text-align:center; padding:40px; color:rgba(255,255,255,.3);">
                        <div style="font-size:80px;">🎥</div>
                        <p style="color:rgba(255,255,255,.5); margin:10px 0 0; font-size:14px;">Video Profil MBKM IAI PI Bandung</p>
                    </div>
                    <?php
                    $vid = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM mod_data_video ORDER BY id DESC LIMIT 1"));
                    if ($vid && !empty($vid['video'])):
                    ?>
                    <div style="position:absolute;top:0;left:0;right:0;bottom:0;">
                        <img src="http://img.youtube.com/vi/<?= $vid['video'] ?>/hqdefault.jpg" style="width:100%;height:100%;object-fit:cover;">
                        <a href="https://www.youtube.com/watch?v=<?= $vid['video'] ?>" target="_blank" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:rgba(255,255,255,.9);border-radius:50%;width:64px;height:64px;display:flex;align-items:center;justify-content:center;font-size:28px;text-decoration:none;">▶</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-7" style="padding-left:40px;">
                <span class="section-eyebrow">Sambutan</span>
                <?php
                $sam = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM halaman WHERE id='1'"));
                if ($sam):
                    $urlkat = str_replace(" ", "-", $sam['judul']);
                ?>
                <h2 class="section-title" style="font-size:26px; margin-bottom:16px;"><?= htmlspecialchars($sam['judul']) ?></h2>
                <p style="color:#555; line-height:1.8; font-size:15px;"><?= limitTXT(strip_tags($sam['konten']), 480) ?></p>
                <a href="pages/<?= $sam['id'] ?>/<?= $urlkat ?>.html" style="display:inline-block; margin-top:20px; background:#0d47a1; color:#fff; padding:12px 28px; border-radius:30px; font-weight:600; text-decoration:none; font-size:14px; transition:background .3s;" onmouseover="this.style.background='#1565c0'" onmouseout="this.style.background='#0d47a1'">Baca Selengkapnya &rarr;</a>
                <?php else: ?>
                <h2 class="section-title" style="font-size:26px; margin-bottom:16px;">Sambutan Pimpinan MBKM IAI PI Bandung</h2>
                <p style="color:#555; line-height:1.8; font-size:15px;">Program MBKM (Merdeka Belajar Kampus Merdeka) di IAI PI Bandung hadir sebagai wujud komitmen kami dalam memberikan pengalaman belajar yang bermakna dan berdampak nyata bagi mahasiswa. Kami mengundang seluruh civitas akademika untuk aktif berpartisipasi dalam program-program MBKM yang telah kami rancang dengan penuh semangat dan dedikasi.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     SECTION 3: STATISTIK
     ============================================================ -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <?php
            $stats = [];
            $q_stat = $koneksi_db->sql_query("SELECT * FROM mod_data_stat ORDER BY id ASC LIMIT 4");
            while ($s = $koneksi_db->sql_fetchrow($q_stat)) $stats[] = $s;

            if (empty($stats)):
                $stats = [
                    ['ket'=>'🎓','jum'=>'500+','nama'=>'Mahasiswa Aktif'],
                    ['ket'=>'🏢','jum'=>'150+','nama'=>'Mitra Industri'],
                    ['ket'=>'📋','jum'=>'8','nama'=>'Program MBKM'],
                    ['ket'=>'🌟','jum'=>'95%','nama'=>'Tingkat Kepuasan'],
                ];
            endif;
            foreach ($stats as $s):
            ?>
            <div class="col-xs-6 col-sm-3">
                <div class="stat-item">
                    <span class="stat-icon"><?= $s['ket'] ?></span>
                    <span class="stat-num"><?= $s['jum'] ?></span>
                    <span class="stat-label"><?= $s['nama'] ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============================================================
     SECTION 4: DOKUMENTASI KEGIATAN
     ============================================================ -->
<section class="dokum-section">
    <div class="container">
        <span class="section-eyebrow">Galeri</span>
        <h2 class="section-title" style="text-align:center;">DOKUMENTASI KEGIATAN MBKM</h2>
        <div class="dokum-slider-wrap" style="max-width:780px; margin:0 auto;">
            <div class="dokum-slides" id="dokSlides">
                <?php
                $dummy_docs = [
                    ['img'=>'','title'=>'Pelepasan Peserta Program Magang 2024','sub'=>'Program Magang MBKM IAI PI Bandung'],
                    ['img'=>'','title'=>'Orientasi Mahasiswa Pertukaran Antar PT','sub'=>'Program Pertukaran Mahasiswa Semester Ganjil'],
                    ['img'=>'','title'=>'Kegiatan Kampus Mengajar di Pelosok','sub'=>'Kampus Mengajar - Membangun Pendidikan Nusantara'],
                    ['img'=>'','title'=>'Dokumentasi KKNT Membangun Desa','sub'=>'Kuliah Kerja Nyata Tematik 2024'],
                ];
                $q_foto = $koneksi_db->sql_query("SELECT * FROM mod_data_foto ORDER BY id DESC LIMIT 5");
                $real_docs = [];
                while ($f = $koneksi_db->sql_fetchrow($q_foto)) $real_docs[] = $f;
                $docs = !empty($real_docs) ? $real_docs : $dummy_docs;

                foreach ($docs as $idx => $d):
                    $is_real = isset($d['nama']);
                    $img_src  = $is_real ? 'images/foto/'.$d['foto'] : '';
                    $title    = $is_real ? htmlspecialchars($d['nama']) : $d['title'];
                    $sub_cap  = $is_real ? '' : $d['sub'];
                ?>
                <div class="dokum-slide">
                    <?php if ($img_src): ?>
                    <img src="<?= $img_src ?>" alt="<?= $title ?>">
                    <?php else: ?>
                    <div style="width:100%;height:420px;background:linear-gradient(135deg,#0d47a1,#1976d2);display:flex;align-items:center;justify-content:center;flex-direction:column;">
                        <span style="font-size:70px;">📸</span>
                        <p style="color:rgba(255,255,255,.5);margin:10px;font-size:13px;">Foto Dokumentasi <?= $idx+1 ?></p>
                    </div>
                    <?php endif; ?>
                    <div class="dokum-slide-cap">
                        <h4><?= $title ?></h4>
                        <?php if ($sub_cap): ?><p><?= $sub_cap ?></p><?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <button class="dokum-nav prev" onclick="dokumNav(-1)">&#8249;</button>
            <button class="dokum-nav next" onclick="dokumNav(1)">&#8250;</button>
        </div>
        <div class="dokum-dots" id="dokDots">
            <?php $dcnt = !empty($real_docs) ? count($real_docs) : count($dummy_docs); for ($i=0;$i<$dcnt;$i++): ?>
            <span class="dokum-dot <?= $i==0?'active':'' ?>" onclick="dokumGo(<?= $i ?>)"></span>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- ============================================================
     SECTION 5: TESTIMONI
     ============================================================ -->
<section class="testi-section">
    <div class="container">
        <div class="row" style="align-items:flex-start;">
            <div class="col-sm-4 testi-left" style="padding-top:10px; margin-bottom:30px;">
                <span class="section-eyebrow">Testimoni</span>
                <h2>BAGAIMANA<br>PENGALAMAN<br>MEREKA?</h2>
                <p>Beragam testimoni mengenai Program MBKM Universitas IAI PI Bandung dari mahasiswa yang telah berpartisipasi.</p>
                <div class="divider"></div>
            </div>
            <div class="col-sm-8">
                <?php
                $q_testi = $koneksi_db->sql_query("SELECT * FROM mod_data_testi WHERE status='1' ORDER BY id DESC LIMIT 3");
                $testis = [];
                while ($t = $koneksi_db->sql_fetchrow($q_testi)) $testis[] = $t;

                if (empty($testis)):
                    $testis = [
                        ['nama'=>'Ahmad Fauzi (Mahasiswa MBKM)','email'=>'Program Magang - PT. XYZ','ket'=>'"Pengalaman magang melalui program MBKM sangat luar biasa. Saya mendapat banyak pengetahuan praktis yang tidak diajarkan di kelas. Tim MBKM IAI PI Bandung selalu siap membantu selama program berlangsung."','foto'=>''],
                        ['nama'=>'Siti Nurhaliza (Mahasiswi MBKM)','email'=>'Program Pertukaran Mahasiswa','ket'=>'"Program pertukaran mahasiswa membuka wawasan saya tentang budaya belajar di kampus lain. Sangat rekomendasikan untuk mahasiswa semester 5 ke atas!"','foto'=>''],
                        ['nama'=>'Rizky Pratama (Mahasiswa MBKM)','email'=>'Kampus Mengajar - SDN Cimahi','ket'=>'"Mengajar di sekolah dasar adalah pengalaman yang mengubah hidup saya. Saya jadi lebih menghargai dunia pendidikan dan ingin terus berkontribusi."','foto'=>''],
                    ];
                endif;

                foreach ($testis as $t):
                ?>
                <div class="testi-card">
                    <p class="testi-quote"><?= htmlspecialchars($t['ket']) ?></p>
                    <div class="testi-person">
                        <div class="testi-avatar">
                            <?php if (!empty($t['foto'])): ?>
                            <img src="images/testi/<?= $t['foto'] ?>" style="width:100%;height:100%;object-fit:cover;">
                            <?php else: ?>
                            👤
                            <?php endif; ?>
                        </div>
                        <div>
                            <div class="testi-name"><?= htmlspecialchars($t['nama']) ?></div>
                            <div class="testi-role"><?= htmlspecialchars($t['email']) ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     SECTION 6: PEDOMAN FLIPBOOK (BOOKSHELF)
     ============================================================ -->
<style>
.bookshelf-home-wrap { background:#f4f6f9; padding:60px 0 70px; }
.bookshelf-home-header { text-align:center; margin-bottom:35px; }
.bookshelf-home-header .label-top { color:#42a5f5; font-size:13px; text-transform:uppercase; letter-spacing:2px; font-weight:600; }
.bookshelf-home-header h2 { color:#0d47a1; font-size:32px; font-weight:800; margin:8px 0 0; }
.bookshelf-row-home { position:relative; padding:20px 20px 30px; margin-bottom:35px; background:linear-gradient(to bottom,#c8a97e,#a0784a); border-radius:4px; border-bottom:12px solid #7a5430; box-shadow:0 8px 20px rgba(0,0,0,.25); display:flex; flex-wrap:wrap; gap:20px; min-height:170px; align-items:flex-end; }
.bookshelf-row-home::before { content:''; position:absolute; bottom:-26px; left:-8px; right:-8px; height:18px; background:linear-gradient(to bottom,#5c3b1a,#3d2510); border-radius:0 0 6px 6px; box-shadow:0 6px 12px rgba(0,0,0,.3); }
.book-home-card { width:100px; cursor:pointer; transition:transform .3s ease; position:relative; flex-shrink:0; text-decoration:none; }
.book-home-card:hover { transform:translateY(-12px) scale(1.06); text-decoration:none; }
.book-home-cover { width:100px; height:140px; border-radius:2px 6px 6px 2px; overflow:hidden; box-shadow:-4px 4px 10px rgba(0,0,0,.4),inset -3px 0 5px rgba(0,0,0,.15); position:relative; background:#1a3a6c; }
.book-home-cover img { width:100%; height:100%; object-fit:cover; display:block; }
.book-home-cover .spine { position:absolute; left:0; top:0; bottom:0; width:10px; background:rgba(0,0,0,.2); border-right:1px solid rgba(255,255,255,.1); }
.book-home-cover .no-cover-txt { display:flex; align-items:center; justify-content:center; width:100%; height:100%; background:linear-gradient(135deg,#1565c0,#0d47a1); color:#fff; font-size:10px; text-align:center; padding:6px; font-weight:600; line-height:1.4; }
.book-home-cover .book-hover-overlay { position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(13,71,161,0); transition:background .3s; display:flex; align-items:center; justify-content:center; border-radius:2px 6px 6px 2px; }
.book-home-card:hover .book-hover-overlay { background:rgba(13,71,161,.55); }
.book-hover-overlay span { color:#fff; font-size:11px; font-weight:bold; opacity:0; transition:opacity .3s; }
.book-home-card:hover .book-hover-overlay span { opacity:1; }
.book-home-title { font-size:10px; color:#3d2510; font-weight:600; text-align:center; margin-top:6px; line-height:1.3; max-height:2.6em; overflow:hidden; }
.bookshelf-see-all { text-align:center; margin-top:30px; }
.bookshelf-see-all a { display:inline-block; background:#0d47a1; color:#fff; padding:12px 30px; border-radius:30px; font-weight:600; text-decoration:none; font-size:14px; transition:background .3s; }
.bookshelf-see-all a:hover { background:#1565c0; text-decoration:none; color:#fff; }
/* Flipbook Modal Styles */
.flipbook-modal-overlay { display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,.85); z-index:9999; align-items:center; justify-content:center; }
.flipbook-modal-overlay.active { display:flex; }
.flipbook-modal { background:#1a1a2e; border-radius:12px; width:90vw; max-width:1000px; height:88vh; display:flex; flex-direction:column; overflow:hidden; box-shadow:0 25px 60px rgba(0,0,0,.6); }
.flipbook-modal-header { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; background:#0d47a1; border-radius:12px 12px 0 0; }
.flipbook-modal-header h4 { color:#fff; margin:0; font-size:15px; font-weight:600; flex:1; padding-right:10px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.btn-close-flipbook { background:rgba(255,255,255,.2); border:none; color:#fff; font-size:18px; line-height:1; border-radius:50%; width:32px; height:32px; cursor:pointer; transition:background .2s; flex-shrink:0; }
.btn-close-flipbook:hover { background:rgba(255,255,255,.4); }
.flipbook-modal-toolbar { display:flex; align-items:center; justify-content:center; gap:10px; padding:10px 20px; background:#16213e; border-bottom:1px solid rgba(255,255,255,.1); flex-wrap:wrap; }
.flipbook-modal-toolbar button { background:#0d47a1; color:#fff; border:none; border-radius:6px; padding:6px 14px; font-size:13px; cursor:pointer; transition:background .2s; }
.flipbook-modal-toolbar button:hover { background:#1565c0; }
.flipbook-modal-toolbar .page-info { color:#aaa; font-size:13px; min-width:100px; text-align:center; }
.flipbook-canvas-wrap { flex:1; overflow:hidden; display:flex; align-items:center; justify-content:center; background:#0f0f1a; position:relative; }
.flipbook-pages-container { display:flex; gap:4px; align-items:center; justify-content:center; height:100%; transition:opacity .3s ease; }
.flipbook-canvas-wrap canvas { box-shadow:0 0 20px rgba(0,0,0,.5); max-height:100%; border-radius:2px; display:block; }
.flipbook-download-link { display:block; text-align:center; padding:10px; background:#16213e; color:#42a5f5; font-size:13px; text-decoration:none; border-top:1px solid rgba(255,255,255,.1); }
.flipbook-download-link:hover { color:#90caf9; text-decoration:none; }
.flipbook-loading { position:absolute; color:#888; font-size:14px; }
</style>

<div class="flipbook-modal-overlay" id="flipbookOverlayHome">
    <div class="flipbook-modal">
        <div class="flipbook-modal-header">
            <h4 id="flipbookTitleHome">Judul Buku</h4>
            <button class="btn-close-flipbook" onclick="closeFlipbookHome()" title="Tutup">&times;</button>
        </div>
        <div class="flipbook-modal-toolbar">
            <button onclick="prevPageHome()">&#9664; Prev</button>
            <button onclick="prevSpreadHome()">&#171; 2 Hal</button>
            <span class="page-info" id="pageInfoHome">Hal 1 / 1</span>
            <button onclick="nextSpreadHome()">2 Hal &#187;</button>
            <button onclick="nextPageHome()">Next &#9654;</button>
            <button onclick="zoomInHome()">&#43; Zoom</button>
            <button onclick="zoomOutHome()">&#8722; Zoom</button>
        </div>
        <div class="flipbook-canvas-wrap" id="flipbookCanvasWrapHome">
            <div class="flipbook-pages-container" id="pagesContainerHome" style="opacity:1;">
                <canvas id="canvasLeftHome"></canvas>
                <canvas id="canvasRightHome"></canvas>
            </div>
            <div class="flipbook-loading" id="flipbookLoadingHome" style="display:none;">Memuat dokumen...</div>
        </div>
        <a href="#" id="flipbookDownloadHome" class="flipbook-download-link" target="_blank">&#11015; Download PDF</a>
    </div>
</div>

<section class="bookshelf-home-wrap">
    <div class="container">
        <div class="bookshelf-home-header">
            <div class="label-top">Pedoman</div>
            <h2>PEDOMAN MBKM IAI PI BANDUNG</h2>
        </div>
        <?php
        $buku_list = [];
        $q_buku = $koneksi_db->sql_query("SELECT * FROM mod_data_flipbook WHERE status='1' ORDER BY ordering ASC, id DESC LIMIT 12");
        while ($bk = $koneksi_db->sql_fetchrow($q_buku)) $buku_list[] = $bk;

        if (!empty($buku_list)):
            $chunks_b = array_chunk($buku_list, 6);
            foreach ($chunks_b as $brow):
                echo '<div class="bookshelf-row-home">';
                foreach ($brow as $bk):
                    $cv = !empty($bk['cover']) ? 'images/flipbook/'.htmlspecialchars($bk['cover']) : '';
                    $jd = htmlspecialchars($bk['judul']);
                    $pf = htmlspecialchars($bk['file_pdf']);
                    echo '<div class="book-home-card" onclick="openFlipbookHome(\''.addslashes($pf).'\',\''.addslashes($jd).'\')">
                        <div class="book-home-cover">
                            <div class="spine"></div>';
                    echo $cv ? '<img src="'.$cv.'" alt="'.$jd.'">' : '<div class="no-cover-txt">'.$jd.'</div>';
                    echo '<div class="book-hover-overlay"><span>&#128214; Buka</span></div>
                        </div>
                        <div class="book-home-title">'.$jd.'</div>
                    </div>';
                endforeach;
                echo '</div>';
            endforeach;
        else:
            // Dummy buku
            $dummy_books = ['Pedoman Magang','Pedoman Pertukaran','Panduan KKNT','Pedoman Riset','Studi Independen','Kampus Mengajar'];
            $book_colors = ['#1565c0','#2e7d32','#6a1b9a','#e65100','#00695c','#ad1457'];
            echo '<div class="bookshelf-row-home">';
            foreach ($dummy_books as $bi => $bn):
                echo '<div class="book-home-card" onclick="alert(\'Upload buku via Admin Flipbook terlebih dahulu.\')">
                    <div class="book-home-cover" style="background:'.$book_colors[$bi].';">
                        <div class="spine"></div>
                        <div class="no-cover-txt">'.$bn.'</div>
                        <div class="book-hover-overlay"><span>&#128214; Buka</span></div>
                    </div>
                    <div class="book-home-title">'.$bn.'</div>
                </div>';
            endforeach;
            echo '</div>';
        endif;
        ?>
        <div class="bookshelf-see-all">
            <a href="index.php?pilih=flipbook&modul=yes">Lihat Semua Pedoman &raquo;</a>
        </div>
    </div>
</section>

<!-- ============================================================
     SECTION 7: CTA BANNER
     ============================================================ -->
<section class="cta-banner">
    <div class="container">
        <div class="row" style="align-items:center;">
            <div class="col-sm-8">
                <h2>Mari Bergabung Dengan Program MBKM<br>Universitas IAI PI Bandung</h2>
            </div>
            <div class="col-sm-4 cta-brand">
                <div class="cta-brand-name">MBKM BERDAMPAK</div>
                <div class="cta-brand-sub">Universitas IAI PI Bandung</div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     SECTION 8: BERITA & KEGIATAN
     ============================================================ -->
<style>
.mbkm-news-section { padding:70px 0; background:#f4f7fb; }
.mbkm-news-section .section-eyebrow { display:block; margin-bottom:8px; }
.mbkm-news-section .section-title { margin-bottom:40px; }
</style>
<section class="mbkm-news-section">
    <div class="container">
        <span class="section-eyebrow">Kabar MBKM IAI PI Bandung</span>
        <h2 class="section-title">BERITA &amp; KEGIATAN</h2>
        <div class="row">
            <?php
            $q_news = $koneksi_db->sql_query("SELECT * FROM `artikel` WHERE publikasi=1 AND topik=1 ORDER BY `id` DESC LIMIT 3");
            $news_items = [];
            while ($d = $koneksi_db->sql_fetchrow($q_news)) $news_items[] = $d;

            if (empty($news_items)):
                $news_items = [
                    ['judul'=>'Peluncuran Program Magang MBKM 2024','gambar'=>'','tanggal'=>date('Y-m-d'),'hits'=>120,'url'=>'#'],
                    ['judul'=>'Mahasiswa IAI PI Ikuti Pertukaran ke UIN Bandung','gambar'=>'','tanggal'=>date('Y-m-d'),'hits'=>98,'url'=>'#'],
                    ['judul'=>'Sosialisasi MBKM untuk Mahasiswa Baru','gambar'=>'','tanggal'=>date('Y-m-d'),'hits'=>75,'url'=>'#'],
                ];
                foreach ($news_items as $ni):
                ?>
                <div class="col-sm-4" style="margin-bottom:30px;">
                    <div class="news-card">
                        <div class="nc-img-ph">&#128240;</div>
                        <div class="nc-body">
                            <span class="nc-cat">MBKM</span>
                            <h3><a href="<?= $ni['url'] ?>"><?= htmlspecialchars($ni['judul']) ?></a></h3>
                            <div class="nc-meta">&#128065; <?= $ni['hits'] ?> views &nbsp;|&nbsp; &#128197; <?= date('d M Y') ?></div>
                        </div>
                    </div>
                </div>
                <?php
                endforeach;
            else:
                foreach ($news_items as $data):
                    $gambar = $data['gambar'];
                    $url = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(" ", "-", $data[1]));
                    $url = trim(preg_replace('/-+/', '-', $url), '-');
                    if (empty($url)) $url = 'artikel-'.$data[0];
                    $image_src = !empty($gambar) ? 'images/artikel/'.$gambar : '';
                ?>
                <div class="col-sm-4" style="margin-bottom:30px;">
                    <div class="news-card">
                        <?php if ($image_src): ?>
                        <img src="<?= $image_src ?>" class="nc-img" alt="<?= htmlspecialchars($data[1]) ?>">
                        <?php else: ?>
                        <div class="nc-img-ph">&#128240;</div>
                        <?php endif; ?>
                        <div class="nc-body">
                            <span class="nc-cat">MBKM</span>
                            <h3><a href="artikel/<?= $data[0] ?>/<?= $url ?>.html"><?= htmlspecialchars($data[1]) ?></a></h3>
                            <div class="nc-meta">&#128065; <?= $data['hits'] ?> views &nbsp;|&nbsp; &#128197; <?= datetimess($data[5]) ?></div>
                        </div>
                    </div>
                </div>
                <?php
                endforeach;
            endif;
            ?>
        </div>
        <div style="text-align:center;">
            <a href="kategori/1/Berita-Kampus.html" class="btn-outline-mbkm">Lihat Semua Berita &raquo;</a>
        </div>
    </div>
</section>

<!-- PDF.js + Flipbook Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
if (typeof pdfjsLib !== 'undefined') {
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
}
var _pdfH=null,_curH=1,_totH=0,_scH=1.2;
function openFlipbookHome(url,title) {
    document.getElementById('flipbookTitleHome').textContent=title;
    document.getElementById('flipbookDownloadHome').href=url;
    document.getElementById('flipbookOverlayHome').classList.add('active');
    document.getElementById('flipbookLoadingHome').style.display='block';
    document.getElementById('pagesContainerHome').style.opacity='0';
    _curH=1;
    pdfjsLib.getDocument(url).promise.then(function(pdf){
        _pdfH=pdf;_totH=pdf.numPages;
        document.getElementById('flipbookLoadingHome').style.display='none';
        document.getElementById('pagesContainerHome').style.opacity='1';
        _rsH(_curH);
    }).catch(function(){ document.getElementById('flipbookLoadingHome').textContent='Gagal memuat PDF.'; document.getElementById('flipbookLoadingHome').style.display='block'; });
}
function closeFlipbookHome(){ document.getElementById('flipbookOverlayHome').classList.remove('active'); _pdfH=null; }
function _rpH(n,cid){ if(!_pdfH||n<1||n>_totH){document.getElementById(cid).style.display='none';return;} _pdfH.getPage(n).then(function(p){var vp=p.getViewport({scale:_scH});var c=document.getElementById(cid);c.style.display='block';c.height=vp.height;c.width=vp.width;p.render({canvasContext:c.getContext('2d'),viewport:vp}); }); }
function _rsH(p){ if(!_pdfH)return; _rpH(p,'canvasLeftHome'); if(p+1<=_totH){_rpH(p+1,'canvasRightHome');}else{document.getElementById('canvasRightHome').style.display='none';} document.getElementById('pageInfoHome').textContent='Hal '+p+(p+1<=_totH?'-'+(p+1):'')+' / '+_totH; }
function nextPageHome(){if(_pdfH&&_curH<_totH){_curH++;_rsH(_curH);}}
function prevPageHome(){if(_pdfH&&_curH>1){_curH--;_rsH(_curH);}}
function nextSpreadHome(){if(_pdfH&&_curH+2<=_totH){_curH+=2;_rsH(_curH);}}
function prevSpreadHome(){if(_pdfH&&_curH-2>=1){_curH-=2;_rsH(_curH);}}
function zoomInHome(){_scH+=0.2;if(_pdfH)_rsH(_curH);}
function zoomOutHome(){if(_scH>0.4){_scH-=0.2;if(_pdfH)_rsH(_curH);}}
document.getElementById('flipbookOverlayHome').addEventListener('click',function(e){if(e.target===this)closeFlipbookHome();});
document.addEventListener('keydown',function(e){if(!document.getElementById('flipbookOverlayHome').classList.contains('active'))return;if(e.key==='ArrowRight')nextPageHome();if(e.key==='ArrowLeft')prevPageHome();if(e.key==='Escape')closeFlipbookHome();});

/* Dokumentasi Slider */
var _dIdx=0,_dSlides=document.querySelectorAll('.dokum-slide');
function _dokRender(){
    document.getElementById('dokSlides').style.transform='translateX(-'+(_dIdx*100)+'%)';
    document.querySelectorAll('.dokum-dot').forEach(function(d,i){d.classList.toggle('active',i===_dIdx);});
}
function dokumNav(dir){_dIdx=(_dIdx+dir+_dSlides.length)%_dSlides.length;_dokRender();}
function dokumGo(i){_dIdx=i;_dokRender();}
setInterval(function(){dokumNav(1);},5000);
</script>