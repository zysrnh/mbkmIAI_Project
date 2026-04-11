<?php
/**
 * Flipbook Frontend Module — Redesigned
 * Tampilan buku rak premium, sesuai landing page MBKM IAI PI Bandung
 */

global $koneksi_db;

// Auto-create tabel jika belum ada (aman dijalankan berkali-kali)
$koneksi_db->sql_query("
    CREATE TABLE IF NOT EXISTS `mod_data_flipbook` (
      `id`        INT(11) NOT NULL AUTO_INCREMENT,
      `judul`     VARCHAR(255) NOT NULL,
      `deskripsi` TEXT,
      `cover`     VARCHAR(255) DEFAULT NULL,
      `file_pdf`  VARCHAR(255) NOT NULL,
      `kategori`  VARCHAR(100) DEFAULT NULL,
      `ordering`  INT(5) DEFAULT 0,
      `status`    TINYINT(1) DEFAULT 1,
      `tanggal`   DATETIME DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$action  = isset($_GET['act'])  ? cleartext($_GET['act']) : '';
$book_id = isset($_GET['id'])   ? (int)$_GET['id'] : 0;
$is_admin = isset($_SESSION['LevelAkses']) && $_SESSION['LevelAkses'] === 'Administrator';
?>

<?php /* ============================================================
   OVERRIDE CSS — semua dalam flipbook.php, tidak ubah file lain
   ============================================================ */ ?>
<style>
/* 1. Sembunyikan sidebar kanan, blog-left full-width */
.blog-right             { display: none !important; }
.col-sm-8.blog-left     { width: 100% !important; padding: 0 !important; }

/* 2. Reset blog-wrapper */
.blog-wrapper {
    margin-top: 0 !important;
    background: transparent !important;
    padding: 0 !important;
}


/* ── CSS Variables (sama dengan landing page) ── */
:root {
    --moss-dark   : #306238;
    --moss-mid    : #618D4F;
    --moss-light  : #9EBB97;
    --moss-bg     : #DDE5CD;
    --moss-olive  : #545837;
    --text-dark   : #1e2d20;
    --text-muted  : #5a6b5c;
    --white       : #ffffff;
    --shadow-sm   : 0 2px 12px rgba(48,98,56,.10);
    --shadow-md   : 0 6px 28px rgba(48,98,56,.16);
    --shadow-lg   : 0 14px 48px rgba(48,98,56,.22);
    --radius-sm   : 8px;
    --radius-md   : 14px;
    --radius-lg   : 20px;
    --transition  : all .28s cubic-bezier(.4,0,.2,1);
}

/* ── HERO SECTION ── */
.fb-hero {
    background: linear-gradient(135deg, var(--moss-dark) 0%, var(--moss-olive) 100%);
    padding: 130px 0 60px; /* top: kompensasi navbar absolute ~85px */
    text-align: center;
    position: relative;
    overflow: hidden;
}
.fb-hero::before {
    content: '';
    position: absolute; top: -80px; right: -80px;
    width: 340px; height: 340px; border-radius: 50%;
    background: rgba(255,255,255,.04);
}
.fb-hero::after {
    content: '';
    position: absolute; bottom: -100px; left: -60px;
    width: 300px; height: 300px; border-radius: 50%;
    background: rgba(255,255,255,.035);
}
.fb-hero-inner { position: relative; z-index: 1; }
.fb-hero-label {
    display: inline-block;
    color: var(--moss-bg);
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 3px;
    margin-bottom: 14px;
    background: rgba(255,255,255,.1);
    padding: 4px 14px; border-radius: 20px;
}
.fb-hero h1 {
    color: var(--white);
    font-size: 38px; font-weight: 900;
    margin: 0 0 14px; letter-spacing: -1px;
    line-height: 1.15;
}
.fb-hero p {
    color: rgba(255,255,255,.75);
    font-size: 15px; max-width: 520px;
    margin: 0 auto 28px; line-height: 1.75;
}
.fb-hero-divider {
    width: 56px; height: 3px;
    background: var(--moss-bg);
    border-radius: 2px;
    margin: 0 auto 28px;
    opacity: .7;
}
.fb-admin-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--white);
    color: var(--moss-dark);
    padding: 11px 26px;
    border-radius: 30px;
    font-weight: 700; font-size: 14px;
    text-decoration: none;
    box-shadow: 0 4px 20px rgba(0,0,0,.2);
    transition: var(--transition);
}
.fb-admin-btn:hover {
    background: var(--moss-bg);
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(0,0,0,.28);
    text-decoration: none;
    color: var(--moss-dark);
}

/* ── KATEGORI FILTER ── */
.fb-filter-wrap {
    background: var(--moss-bg);
    padding: 20px 0;
    border-bottom: 1px solid rgba(97,141,79,.2);
}
.fb-filter-inner {
    display: flex; flex-wrap: wrap; gap: 10px;
    align-items: center; justify-content: center;
}
.fb-filter-btn {
    padding: 7px 20px;
    border-radius: 30px;
    font-size: 13px; font-weight: 600;
    cursor: pointer; border: 2px solid var(--moss-mid);
    color: var(--moss-dark); background: transparent;
    transition: var(--transition);
}
.fb-filter-btn.active,
.fb-filter-btn:hover {
    background: var(--moss-dark);
    border-color: var(--moss-dark);
    color: var(--white);
}

/* ── BOOKSHELF UTAMA ── */
.fb-shelf-section {
    background: linear-gradient(180deg, #f0f4ed 0%, #e8ece4 100%);
    padding: 54px 0 80px;
    min-height: 40vh;
}

/* Rak kayu */
.fb-shelf-row {
    position: relative;
    background: linear-gradient(to bottom, #c9ab82, #a07444);
    border-radius: 6px;
    border-bottom: 12px solid #7a5230;
    box-shadow: 0 10px 28px rgba(0,0,0,.25);
    display: flex; flex-wrap: wrap;
    gap: 24px; padding: 28px 28px 36px;
    margin-bottom: 48px;
    min-height: 200px; align-items: flex-end;
}
.fb-shelf-row::after {
    content: '';
    position: absolute; bottom: -26px; left: -8px; right: -8px;
    height: 18px;
    background: linear-gradient(to bottom, #5c3b1a, #3d2510);
    border-radius: 0 0 6px 6px;
    box-shadow: 0 6px 14px rgba(0,0,0,.3);
}
.fb-shelf-label {
    position: absolute; top: -16px; left: 14px;
    background: var(--moss-dark);
    color: var(--white);
    font-size: 10.5px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 1.5px;
    padding: 4px 14px; border-radius: 20px;
    box-shadow: var(--shadow-sm);
}

/* Book Card */
.fb-book {
    width: 110px; cursor: pointer;
    flex-shrink: 0; position: relative;
    transition: transform .32s cubic-bezier(.34,1.56,.64,1);
    text-decoration: none;
}
.fb-book:hover { transform: translateY(-16px) scale(1.04); }
.fb-book-cover {
    width: 110px; height: 154px;
    border-radius: 2px 7px 7px 2px;
    overflow: hidden;
    box-shadow: -5px 5px 14px rgba(0,0,0,.45),
                inset -4px 0 8px rgba(0,0,0,.18);
    position: relative;
    background: var(--moss-dark);
}
.fb-book-cover img { width:100%; height:100%; object-fit:cover; display:block; }
.fb-book-spine {
    position: absolute; left:0; top:0; bottom:0;
    width: 13px;
    background: rgba(0,0,0,.25);
    border-right: 1px solid rgba(255,255,255,.1);
}
.fb-book-no-cover {
    display: flex; align-items: center; justify-content: center;
    width: 100%; height: 100%;
    background: linear-gradient(135deg, var(--moss-dark), var(--moss-mid));
    color: var(--white);
    font-size: 11px; font-weight: 700;
    text-align: center; padding: 10px;
    line-height: 1.4;
}
.fb-book-overlay {
    position: absolute; top:0; left:0; right:0; bottom:0;
    background: rgba(48,98,56,0);
    transition: background .3s;
    display: flex; align-items: center; justify-content: center;
    border-radius: 2px 7px 7px 2px;
}
.fb-book:hover .fb-book-overlay { background: rgba(48,98,56,.55); }
.fb-book-overlay span {
    color: var(--white); font-size: 12px; font-weight: 700;
    opacity: 0; transition: opacity .3s; letter-spacing: .5px;
    text-transform: uppercase; text-align: center; padding: 0 8px;
}
.fb-book:hover .fb-book-overlay span { opacity: 1; }
.fb-book-title {
    font-size: 10.5px; color: #3d2510; font-weight: 700;
    text-align: center; margin-top: 9px; line-height: 1.35;
    max-height: 2.7em; overflow: hidden;
    text-decoration: none;
    display: block;
}
.fb-book-cat {
    font-size: 9px; color: var(--moss-mid); font-weight: 600;
    text-align: center; margin-top: 2px; letter-spacing: .5px;
    text-transform: uppercase;
}

/* ── EMPTY STATE ── */
.fb-empty {
    text-align: center; padding: 80px 30px;
}
.fb-empty-icon {
    width: 96px; height: 96px;
    border-radius: 50%;
    background: var(--moss-bg);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 24px;
    box-shadow: var(--shadow-sm);
}
.fb-empty-icon svg { width:48px; height:48px; fill: var(--moss-mid); }
.fb-empty h3 {
    color: var(--moss-dark); font-size: 22px;
    font-weight: 800; margin: 0 0 10px;
}
.fb-empty p { color: var(--text-muted); font-size: 14px; margin:0 0 28px; }
.fb-empty-admin-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--moss-dark); color: var(--white);
    padding: 12px 28px; border-radius: 30px;
    font-weight: 700; font-size: 14px;
    text-decoration: none; transition: var(--transition);
    box-shadow: var(--shadow-md);
}
.fb-empty-admin-btn:hover {
    background: var(--moss-mid); color: var(--white);
    text-decoration: none; transform: translateY(-2px);
}

/* ── FLIPBOOK VIEWER MODAL ── */
.fb-modal-overlay {
    display: none; position: fixed;
    top:0; left:0; right:0; bottom:0;
    background: rgba(10,20,12,.92);
    z-index: 9999; align-items: center; justify-content: center;
}
.fb-modal-overlay.active { display: flex; }
.fb-modal {
    background: #1a2b1c;
    border-radius: var(--radius-md);
    width: 92vw; max-width: 1060px; height: 90vh;
    display: flex; flex-direction: column;
    overflow: hidden;
    box-shadow: 0 30px 80px rgba(0,0,0,.7);
    animation: fbSlideIn .3s cubic-bezier(.34,1.56,.64,1);
}
@keyframes fbSlideIn {
    from { transform: scale(.92) translateY(20px); opacity:0; }
    to   { transform: scale(1) translateY(0); opacity:1; }
}
.fb-modal-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 22px;
    background: var(--moss-dark);
    border-radius: var(--radius-md) var(--radius-md) 0 0;
}
.fb-modal-header h4 {
    color: var(--white); margin:0; font-size: 15px;
    font-weight: 700; flex:1; padding-right:12px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.fb-btn-close {
    background: rgba(255,255,255,.15); border: none;
    color: var(--white); font-size: 20px; line-height: 1;
    border-radius: 50%; width: 34px; height: 34px;
    cursor: pointer; transition: var(--transition); flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.fb-btn-close:hover { background: rgba(255,255,255,.35); }
.fb-modal-toolbar {
    display: flex; align-items: center; justify-content: center;
    gap: 8px; padding: 10px 20px;
    background: #111e13;
    border-bottom: 1px solid rgba(255,255,255,.07);
    flex-wrap: wrap;
}
.fb-modal-toolbar button {
    background: var(--moss-mid); color: var(--white);
    border: none; border-radius: 6px;
    padding: 7px 16px; font-size: 12.5px;
    cursor: pointer; transition: var(--transition);
    font-weight: 600;
}
.fb-modal-toolbar button:hover { background: var(--moss-dark); }
.fb-page-info {
    color: #8ea090; font-size: 12.5px;
    min-width: 110px; text-align: center; font-weight: 600;
}
.fb-canvas-wrap {
    flex: 1; overflow: hidden;
    display: flex; align-items: center; justify-content: center;
    background: #0a120b; position: relative;
}
.fb-pages-container {
    display: flex; gap: 4px;
    align-items: center; justify-content: center;
    height: 100%; transition: opacity .3s;
}
.fb-canvas-wrap canvas {
    box-shadow: 0 0 28px rgba(0,0,0,.55);
    max-height: 100%; border-radius: 2px; display: block;
}
.fb-download-link {
    display: block; text-align: center; padding: 11px;
    background: #111e13; color: var(--moss-light);
    font-size: 13px; text-decoration: none;
    border-top: 1px solid rgba(255,255,255,.07);
    font-weight: 600; transition: var(--transition);
}
.fb-download-link:hover { color: var(--moss-bg); text-decoration: none; }
.fb-loading {
    position: absolute; color: #6a8c6e; font-size: 14px;
    display: flex; align-items: center; gap: 10px;
}
.fb-loading::before {
    content: '';
    width: 20px; height: 20px; border-radius: 50%;
    border: 2px solid var(--moss-mid);
    border-top-color: transparent;
    animation: spin .8s linear infinite;
    display: block;
}
@keyframes spin { to { transform: rotate(360deg); } }

@media (max-width: 767px) {
    .fb-hero h1 { font-size: 26px; }
    .fb-book { width:88px; }
    .fb-book-cover { width:88px; height:126px; }
    .fb-shelf-row { gap: 16px; padding: 22px 18px 32px; }
}
</style>

<?php /* ============================================================
   HERO SECTION
   ============================================================ */ ?>
<div class="fb-hero">
    <div class="container">
        <div class="fb-hero-inner">
            <span class="fb-hero-label">Referensi Pedoman</span>
            <h1>E-Book &amp; Flipbook<br>MBKM IAI PI Bandung</h1>
            <div class="fb-hero-divider"></div>
            <p>Kumpulan buku pedoman dan panduan pelaksanaan program MBKM yang dapat dibaca langsung di browser.</p>
            <?php if ($is_admin): ?>
            <a href="admin.php?pilih=flipbook&modul=yes" class="fb-admin-btn">
                <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:var(--moss-dark)"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                Tambah / Kelola Buku
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// Ambil semua buku aktif dari DB
$all_books = [];
$q = $koneksi_db->sql_query("SELECT * FROM mod_data_flipbook WHERE status='1' ORDER BY ordering ASC, id DESC");
while ($bk = $koneksi_db->sql_fetchrow($q)) {
    $all_books[] = $bk;
}

// Ambil kategori unik untuk filter
$all_cats = [];
foreach ($all_books as $bk) {
    $c = trim($bk['kategori']);
    if ($c && !in_array($c, $all_cats)) $all_cats[] = $c;
}
?>

<?php if (!empty($all_cats)): ?>
<div class="fb-filter-wrap">
    <div class="container">
        <div class="fb-filter-inner">
            <button class="fb-filter-btn active" onclick="filterBooks('all', this)">📚 Semua</button>
            <?php foreach ($all_cats as $cat): ?>
            <button class="fb-filter-btn" onclick="filterBooks('<?= htmlspecialchars(addslashes($cat)) ?>', this)">
                <?= htmlspecialchars($cat) ?>
            </button>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php /* ============================================================
   BOOKSHELF SECTION
   ============================================================ */ ?>
<section class="fb-shelf-section">
    <div class="container">
        <?php if (empty($all_books)): ?>
        <div class="fb-empty">
            <div class="fb-empty-icon">
                <svg viewBox="0 0 24 24"><path d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1zM21 18.5c-1.1-.35-2.3-.5-3.5-.5-1.7 0-4.15.65-5.5 1.5V8c1.35-.85 3.8-1.5 5.5-1.5 1.2 0 2.4.15 3.5.5v11.5z"/></svg>
            </div>
            <h3>Belum Ada Buku</h3>
            <p>Koleksi e-book pedoman MBKM belum tersedia saat ini.</p>
            <?php if ($is_admin): ?>
            <a href="admin.php?pilih=flipbook&modul=yes&aksi=tambah" class="fb-empty-admin-btn">
                <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:#fff"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                Upload Buku Pertama
            </a>
            <?php endif; ?>
        </div>
        <?php else: ?>

        <?php
        // Group by kategori jika ada, atau tampilkan semua
        $per_row = 7;
        if (!empty($all_cats)) {
            // Group per kategori
            foreach ($all_cats as $cat) {
                $cat_books = array_filter($all_books, function($b) use ($cat) {
                    return trim($b['kategori']) === $cat;
                });
                $cat_books = array_values($cat_books);
                if (empty($cat_books)) continue;

                $chunks = array_chunk($cat_books, $per_row);
                foreach ($chunks as $ci => $row_books):
                ?>
                <div class="fb-shelf-row" data-cat="<?= htmlspecialchars($cat) ?>">
                    <?php if ($ci === 0): ?>
                    <span class="fb-shelf-label"><?= htmlspecialchars($cat) ?></span>
                    <?php endif; ?>
                    <?php foreach ($row_books as $bk):
                        $cover_src = !empty($bk['cover']) ? 'images/flipbook/' . htmlspecialchars($bk['cover']) : '';
                        $judul     = htmlspecialchars($bk['judul']);
                        $pdf       = htmlspecialchars($bk['file_pdf']);
                    ?>
                    <div class="fb-book" onclick="openFB('<?= $pdf ?>', '<?= addslashes($judul) ?>')" data-cat="<?= htmlspecialchars($cat) ?>">
                        <div class="fb-book-cover">
                            <div class="fb-book-spine"></div>
                            <?php if ($cover_src): ?>
                            <img src="<?= $cover_src ?>" alt="<?= $judul ?>">
                            <?php else: ?>
                            <div class="fb-book-no-cover"><?= $judul ?></div>
                            <?php endif; ?>
                            <div class="fb-book-overlay"><span>&#128214; Buka</span></div>
                        </div>
                        <div class="fb-book-title"><?= $judul ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach;
            } // end foreach $all_cats

            // Buku tanpa kategori
            $no_cat_books = array_values(array_filter($all_books, function($b) { return empty(trim($b['kategori'])); }));
            if (!empty($no_cat_books)):
                $chunks = array_chunk($no_cat_books, $per_row);
                foreach ($chunks as $row_books):
                ?>
                <div class="fb-shelf-row" data-cat="all">
                    <span class="fb-shelf-label">Lainnya</span>
                    <?php foreach ($row_books as $bk):
                        $cover_src = !empty($bk['cover']) ? 'images/flipbook/' . htmlspecialchars($bk['cover']) : '';
                        $judul     = htmlspecialchars($bk['judul']);
                        $pdf       = htmlspecialchars($bk['file_pdf']);
                    ?>
                    <div class="fb-book" onclick="openFB('<?= $pdf ?>', '<?= addslashes($judul) ?>')" data-cat="">
                        <div class="fb-book-cover">
                            <div class="fb-book-spine"></div>
                            <?php if ($cover_src): ?>
                            <img src="<?= $cover_src ?>" alt="<?= $judul ?>">
                            <?php else: ?>
                            <div class="fb-book-no-cover"><?= $judul ?></div>
                            <?php endif; ?>
                            <div class="fb-book-overlay"><span>&#128214; Buka</span></div>
                        </div>
                        <div class="fb-book-title"><?= $judul ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach;
            endif;

        } else {
            // Semua buku tanpa kategori, tampilkan satu rak
            $chunks = array_chunk($all_books, $per_row);
            foreach ($chunks as $row_books):
            ?>
            <div class="fb-shelf-row">
                <?php foreach ($row_books as $bk):
                    $cover_src = !empty($bk['cover']) ? 'images/flipbook/' . htmlspecialchars($bk['cover']) : '';
                    $judul     = htmlspecialchars($bk['judul']);
                    $pdf       = htmlspecialchars($bk['file_pdf']);
                ?>
                <div class="fb-book" onclick="openFB('<?= $pdf ?>', '<?= addslashes($judul) ?>')">
                    <div class="fb-book-cover">
                        <div class="fb-book-spine"></div>
                        <?php if ($cover_src): ?>
                        <img src="<?= $cover_src ?>" alt="<?= $judul ?>">
                        <?php else: ?>
                        <div class="fb-book-no-cover"><?= $judul ?></div>
                        <?php endif; ?>
                        <div class="fb-book-overlay"><span>&#128214; Buka</span></div>
                    </div>
                    <div class="fb-book-title"><?= $judul ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach;
        }
        ?>

        <?php if ($is_admin): ?>
        <div style="text-align:center; margin-top:24px;">
            <a href="admin.php?pilih=flipbook&modul=yes" class="fb-admin-btn" style="display:inline-flex;">
                <svg viewBox="0 0 24 24" style="width:17px;height:17px;fill:var(--moss-dark)"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                Kelola Koleksi Buku
            </a>
        </div>
        <?php endif; ?>

        <?php endif; // end if empty books ?>
    </div>
</section>

<?php /* ============================================================
   CTA SECTION (bottom banner)
   ============================================================ */ ?>
<section style="background:var(--moss-bg); padding:48px 0; text-align:center; border-top:2px solid rgba(97,141,79,.15);">
    <div class="container">
        <span style="display:block; color:var(--moss-mid); font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:2px; margin-bottom:10px;">Informasi</span>
        <h2 style="color:var(--moss-dark); font-size:22px; font-weight:800; margin:0 0 12px;">Butuh Bantuan atau Informasi Lebih?</h2>
        <p style="color:var(--text-muted); font-size:14px; max-width:480px; margin:0 auto 24px; line-height:1.8;">
            Hubungi tim MBKM IAI PI Bandung untuk informasi lebih lanjut mengenai program dan pedoman pelaksanaan.
        </p>
        <a href="index.php" style="display:inline-flex; align-items:center; gap:8px; background:var(--moss-dark); color:#fff; padding:12px 30px; border-radius:30px; font-weight:700; font-size:14px; text-decoration:none; transition:all .28s; box-shadow:0 4px 20px rgba(48,98,56,.3);">
            <svg viewBox="0 0 24 24" style="width:17px;height:17px;fill:#fff"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
            Kembali ke Beranda
        </a>
    </div>
</section>

<?php /* ============================================================
   FLIPBOOK VIEWER MODAL
   ============================================================ */ ?>
<div class="fb-modal-overlay" id="fbOverlay">
    <div class="fb-modal">
        <div class="fb-modal-header">
            <h4 id="fbTitle">Memuat Buku...</h4>
            <button class="fb-btn-close" onclick="closeFB()" title="Tutup">&#x2715;</button>
        </div>
        <div class="fb-modal-toolbar">
            <button onclick="fbPrev()">&#9664; Prev</button>
            <button onclick="fbPrevSpread()">&#171; 2 Hal</button>
            <span class="fb-page-info" id="fbPageInfo">Hal 1 / 1</span>
            <button onclick="fbNextSpread()">2 Hal &#187;</button>
            <button onclick="fbNext()">Next &#9654;</button>
            <button onclick="fbZoomIn()">&#43; Zoom</button>
            <button onclick="fbZoomOut()">&#8722; Zoom</button>
        </div>
        <div class="fb-canvas-wrap" id="fbCanvasWrap">
            <div class="fb-pages-container" id="fbPages">
                <canvas id="fbCanvasL"></canvas>
                <canvas id="fbCanvasR"></canvas>
            </div>
            <div class="fb-loading" id="fbLoading">Memuat dokumen...</div>
        </div>
        <a href="#" id="fbDownload" class="fb-download-link" target="_blank">&#11015; Download PDF</a>
    </div>
</div>

<!-- PDF.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

let _pdf = null, _page = 1, _total = 0, _scale = 1.2;

function openFB(url, title) {
    document.getElementById('fbTitle').textContent = title;
    document.getElementById('fbDownload').href = url;
    document.getElementById('fbOverlay').classList.add('active');
    document.getElementById('fbLoading').style.display = 'flex';
    document.getElementById('fbPages').style.opacity = '0';
    _page = 1;
    pdfjsLib.getDocument(url).promise.then(function(pdf) {
        _pdf = pdf;
        _total = pdf.numPages;
        document.getElementById('fbLoading').style.display = 'none';
        document.getElementById('fbPages').style.opacity = '1';
        fbRender(_page);
    }).catch(function(err) {
        document.getElementById('fbLoading').textContent = '⚠ Gagal memuat PDF. Cek koneksi & path file.';
        console.error(err);
    });
}
function closeFB() {
    document.getElementById('fbOverlay').classList.remove('active');
    _pdf = null;
    ['fbCanvasL','fbCanvasR'].forEach(function(id) {
        var c = document.getElementById(id);
        c.getContext('2d').clearRect(0,0,c.width,c.height);
    });
}
function fbRenderPage(num, id) {
    if (!_pdf || num < 1 || num > _total) {
        document.getElementById(id).style.display = 'none';
        return Promise.resolve();
    }
    return _pdf.getPage(num).then(function(page) {
        var vp = page.getViewport({ scale: _scale });
        var c  = document.getElementById(id);
        c.style.display = 'block';
        c.width = vp.width; c.height = vp.height;
        return page.render({ canvasContext: c.getContext('2d'), viewport: vp }).promise;
    });
}
function fbRender(p) {
    if (!_pdf) return;
    fbRenderPage(p, 'fbCanvasL');
    if (p + 1 <= _total) {
        fbRenderPage(p + 1, 'fbCanvasR');
    } else {
        document.getElementById('fbCanvasR').style.display = 'none';
    }
    var right = (p + 1 <= _total) ? '-' + (p+1) : '';
    document.getElementById('fbPageInfo').textContent = 'Hal ' + p + right + ' / ' + _total;
}
function fbNext()       { if (_pdf && _page < _total) { _page++; fbRender(_page); } }
function fbPrev()       { if (_pdf && _page > 1) { _page--; fbRender(_page); } }
function fbNextSpread() { if (_pdf && _page + 2 <= _total) { _page += 2; fbRender(_page); } }
function fbPrevSpread() { if (_pdf && _page - 2 >= 1) { _page -= 2; fbRender(_page); } }
function fbZoomIn()     { _scale += 0.2; if (_pdf) fbRender(_page); }
function fbZoomOut()    { if (_scale > 0.4) { _scale -= 0.2; if (_pdf) fbRender(_page); } }

document.getElementById('fbOverlay').addEventListener('click', function(e) {
    if (e.target === this) closeFB();
});
document.addEventListener('keydown', function(e) {
    if (!document.getElementById('fbOverlay').classList.contains('active')) return;
    if (e.key === 'ArrowRight') fbNext();
    if (e.key === 'ArrowLeft')  fbPrev();
    if (e.key === 'Escape')     closeFB();
});

// Filter buku berdasarkan kategori
function filterBooks(cat, btn) {
    document.querySelectorAll('.fb-filter-btn').forEach(function(b) { b.classList.remove('active'); });
    btn.classList.add('active');
    document.querySelectorAll('.fb-shelf-row').forEach(function(row) {
        if (cat === 'all') {
            row.style.display = 'flex';
        } else {
            row.style.display = (row.dataset.cat === cat) ? 'flex' : 'none';
        }
    });
}
</script>
