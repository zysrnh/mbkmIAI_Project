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
    background: rgba(8,18,10,.93);
    z-index: 9999; align-items: center; justify-content: center;
}
.fb-modal-overlay.active { display: flex; }
.fb-modal {
    background: #1a2b1c;
    border-radius: var(--radius-md);
    width: 96vw; max-width: 1140px; height: 93vh;
    display: flex; flex-direction: column;
    overflow: hidden;
    box-shadow: 0 30px 80px rgba(0,0,0,.75);
    animation: fbSlideIn .35s cubic-bezier(.34,1.56,.64,1);
}
@keyframes fbSlideIn {
    from { transform: scale(.9) translateY(24px); opacity:0; }
    to   { transform: scale(1) translateY(0); opacity:1; }
}
.fb-modal-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 13px 22px;
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
    gap: 6px; padding: 9px 16px;
    background: #111e13;
    border-bottom: 1px solid rgba(255,255,255,.07);
    flex-wrap: wrap;
}
.fb-modal-toolbar button {
    background: var(--moss-mid); color: var(--white);
    border: none; border-radius: 6px;
    padding: 7px 15px; font-size: 12.5px;
    cursor: pointer; transition: var(--transition);
    font-weight: 600;
}
.fb-modal-toolbar button:hover { background: var(--moss-dark); }
.fb-modal-toolbar button:disabled { opacity:.35; cursor:default; }
.fb-page-info {
    color: #8ea090; font-size: 12.5px;
    min-width: 120px; text-align: center; font-weight: 600;
}

/* ── Book canvas area ── */
.fb-canvas-wrap {
    flex: 1; overflow: auto;
    display: flex; align-items: center; justify-content: center;
    background: #0a120b; position: relative;
    padding: 24px 16px;
}

/* Scene: perspective container */
.fb-scene {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    perspective: 2500px;
    perspective-origin: 50% 50%;
}

/* Static page canvases */
#fbCanvasL { display:block; box-shadow: -6px 0 24px rgba(0,0,0,.6); border-radius:3px 0 0 3px; }
#fbCanvasR { display:block; box-shadow:  6px 0 24px rgba(0,0,0,.6); border-radius:0 3px 3px 0; }

/* Book spine */
.fb-spine {
    width: 5px;
    background: linear-gradient(180deg,#4a7a52,#1d3d22 50%,#4a7a52);
    flex-shrink: 0;
    box-shadow: 2px 0 8px rgba(0,0,0,.5), -2px 0 8px rgba(0,0,0,.5);
    display: none;
    align-self: stretch;
}
.fb-spine.visible { display: block; }

/* ── THE FLIPPER — true 3D page turn ── */
.fb-flipper {
    position: absolute;
    transform-style: preserve-3d;
    display: none;
    z-index: 20;
    pointer-events: none;
}
/* Front face: shows current page */
.fb-flip-front {
    position: absolute;
    inset: 0;
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
    overflow: hidden;
}
/* Back face: shows next page (pre-rendered, initially unseen) */
.fb-flip-back {
    position: absolute;
    inset: 0;
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
    transform: rotateY(180deg);
    overflow: hidden;
}
.fb-flip-front canvas,
.fb-flip-back canvas { display:block; }

/* Shadow overlay on the turning page (the fold gradient) */
.fb-flip-front::after, .fb-flip-back::after {
    content: '';
    position: absolute;
    inset: 0;
    pointer-events: none;
    background: linear-gradient(to right, transparent 60%, rgba(0,0,0,.35));
    opacity: 0;
    transition: opacity .3s;
}
.fb-flipper.flipping .fb-flip-front::after { opacity: 1; }

.fb-download-link {
    display: block; text-align: center; padding: 11px;
    background: #111e13; color: var(--moss-light);
    font-size: 13px; text-decoration: none;
    border-top: 1px solid rgba(255,255,255,.07);
    font-weight: 600; transition: var(--transition);
}
.fb-download-link:hover { color: var(--moss-bg); text-decoration: none; }
.fb-loading {
    position: absolute; inset:0; display:flex; align-items:center; justify-content:center;
    color: #6a8c6e; font-size: 14px; gap: 10px; flex-direction: column;
    background: #0a120b;
}
.fb-loading::before {
    content: '';
    width: 32px; height: 32px; border-radius: 50%;
    border: 3px solid var(--moss-mid);
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
            <button id="btnPrev"  onclick="fbNav(-1)">&#9664; Prev</button>
            <button id="btnPrev2" onclick="fbNav(-2)">&#171; 2 Hal</button>
            <span class="fb-page-info" id="fbPageInfo">Hal 1 / 1</span>
            <button id="btnNext2" onclick="fbNav(2)">2 Hal &#187;</button>
            <button id="btnNext"  onclick="fbNav(1)">Next &#9654;</button>
            <button onclick="fbZoom(0.2)">&#43; Zoom</button>
            <button onclick="fbZoom(-0.2)">&#8722; Zoom</button>
            <button onclick="fbZoomReset()" style="background:rgba(255,255,255,.1)">&#8635;</button>
        </div>
        <div class="fb-canvas-wrap" id="fbCanvasWrap">
            <div class="fb-loading" id="fbLoading">Memuat dokumen...</div>
            <!-- Book scene: left page, spine, right page, + flipper overlay -->
            <div class="fb-scene" id="fbScene" style="display:none;">
                <canvas id="fbCanvasL"></canvas>
                <div class="fb-spine" id="fbSpine"></div>
                <canvas id="fbCanvasR"></canvas>
                <!-- 3D flipper: positioned absolutely, rotates around one edge -->
                <div class="fb-flipper" id="fbFlipper">
                    <div class="fb-flip-front"><canvas id="fbFlipFront"></canvas></div>
                    <div class="fb-flip-back" ><canvas id="fbFlipBack" ></canvas></div>
                </div>
            </div>
        </div>
        <a href="#" id="fbDownload" class="fb-download-link" target="_blank">&#11015; Download PDF</a>
    </div>
</div>

<!-- PDF.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

var _pdf = null, _page = 1, _total = 0, _scale = 1.3, _busy = false;

/* ── Render a single page into a canvas element ── */
function rndPage(num, canvas) {
    if (!_pdf || num < 1 || num > _total) {
        if (canvas) { canvas.style.visibility = 'hidden'; canvas.width = 0; }
        return Promise.resolve();
    }
    return _pdf.getPage(num).then(function(pg) {
        var vp = pg.getViewport({ scale: _scale });
        canvas.style.visibility = 'visible';
        canvas.width  = vp.width;
        canvas.height = vp.height;
        return pg.render({ canvasContext: canvas.getContext('2d'), viewport: vp }).promise;
    });
}

/* Copy pixel content from one canvas to another */
function copyCanvas(src, dst) {
    if (!src || !src.width) return;
    dst.width  = src.width;
    dst.height = src.height;
    dst.getContext('2d').drawImage(src, 0, 0);
}

/* Position the flipper absolutely within the scene, over a given reference canvas */
function placeFlipperOver(refCanvas, originX) {
    var flipper  = document.getElementById('fbFlipper');
    var scene    = document.getElementById('fbScene');
    var sr = scene.getBoundingClientRect();
    var cr = refCanvas.getBoundingClientRect();
    var w  = refCanvas.width  || refCanvas.offsetWidth;
    var h  = refCanvas.height || refCanvas.offsetHeight;
    flipper.style.cssText = [
        'display:block',
        'position:absolute',
        'width:'  + w + 'px',
        'height:' + h + 'px',
        'left:'   + Math.round(cr.left - sr.left) + 'px',
        'top:'    + Math.round(cr.top  - sr.top)  + 'px',
        'transform-origin:' + originX + ' 50%',
        'transform:rotateY(0deg)',
        'transform-style:preserve-3d',
        'transition:none',
        'z-index:20',
        'pointer-events:none'
    ].join(';');
}

/* Update info bar and nav buttons */
function finalize(p) {
    var hasR = (p + 1 <= _total);
    document.getElementById('fbSpine').className = 'fb-spine' + (hasR ? ' visible' : '');
    document.getElementById('fbPageInfo').textContent =
        'Hal ' + p + (hasR ? '\u2013' + (p+1) : '') + ' / ' + _total;
    document.getElementById('btnPrev').disabled  = (p <= 1);
    document.getElementById('btnPrev2').disabled = (p <= 1);
    document.getElementById('btnNext').disabled  = (p >= _total);
    document.getElementById('btnNext2').disabled = (p + 1 >= _total);
    _busy = false;
}

/* Core render function */
function fbRender(p, dir) {
    if (!_pdf || _busy) return;
    _busy = true;

    var cL      = document.getElementById('fbCanvasL');
    var cR      = document.getElementById('fbCanvasR');
    var flipper = document.getElementById('fbFlipper');
    var flipF   = document.getElementById('fbFlipFront');
    var flipB   = document.getElementById('fbFlipBack');

    if (!dir) {
        /* Static render — no animation */
        Promise.all([rndPage(p, cL), rndPage(p + 1, cR)]).then(function() {
            finalize(p);
        });
        return;
    }

    var FLIP_MS = 750; // total animation duration in ms

    if (dir === 'next') {
        /* RIGHT page flips to the LEFT (spine = left edge of right page) */
        if (!cR.width) { _busy = false; fbRender(p, null); return; }

        /* 1. Copy current right page to front face of flipper */
        copyCanvas(cR, flipF);

        /* 2. Place flipper exactly over cR, origin at LEFT edge (spine side) */
        placeFlipperOver(cR, '0%');
        cR.style.visibility = 'hidden';

        /* 3. Pre-render NEW left page on back face */
        rndPage(p, flipB).then(function() {
            /* 4. Pre-render new right page on cR (hidden under flipper) */
            rndPage(p + 1, cR);

            /* 5. Trigger 3D flip: rotate -180° around LEFT edge → page lands on LEFT side */
            flipper.classList.add('flipping');
            requestAnimationFrame(function() {
                requestAnimationFrame(function() {
                    flipper.style.transition = 'transform ' + FLIP_MS + 'ms cubic-bezier(0.77,0,0.175,1)';
                    flipper.style.transform  = 'rotateY(-180deg)';
                });
            });

            /* 6. After animation: update static left canvas and show everything */
            setTimeout(function() {
                flipper.style.transition = 'none';
                flipper.style.display    = 'none';
                flipper.classList.remove('flipping');
                cR.style.visibility = 'visible';
                /* Update left canvas with new page */
                rndPage(p, cL).then(function() {
                    rndPage(p + 1, cR).then(function() {
                        finalize(p);
                    });
                });
            }, FLIP_MS + 60);
        });

    } else { /* dir === 'prev' */
        /* LEFT page flips to the RIGHT (spine = right edge of left page) */
        if (!cL.width) { _busy = false; fbRender(p, null); return; }

        /* 1. Copy current left page to front face */
        copyCanvas(cL, flipF);

        /* 2. Place flipper over cL, origin at RIGHT edge (spine side) */
        placeFlipperOver(cL, '100%');
        cL.style.visibility = 'hidden';

        /* 3. Pre-render NEW right page on back face */
        rndPage(p + 1, flipB).then(function() {
            rndPage(p, cL); /* pre-render new left page */

            flipper.classList.add('flipping');
            requestAnimationFrame(function() {
                requestAnimationFrame(function() {
                    flipper.style.transition = 'transform ' + FLIP_MS + 'ms cubic-bezier(0.77,0,0.175,1)';
                    flipper.style.transform  = 'rotateY(180deg)';
                });
            });

            setTimeout(function() {
                flipper.style.transition = 'none';
                flipper.style.display    = 'none';
                flipper.classList.remove('flipping');
                cL.style.visibility = 'visible';
                rndPage(p, cL).then(function() {
                    rndPage(p + 1, cR).then(function() {
                        finalize(p);
                    });
                });
            }, FLIP_MS + 60);
        });
    }
}

function openFB(url, title) {
    document.getElementById('fbTitle').textContent = title;
    document.getElementById('fbDownload').href = url;
    document.getElementById('fbOverlay').classList.add('active');
    document.getElementById('fbLoading').style.display = 'flex';
    document.getElementById('fbScene').style.display = 'none';
    document.body.style.overflow = 'hidden';
    _page = 1; _busy = false;
    pdfjsLib.getDocument(url).promise.then(function(pdf) {
        _pdf = pdf; _total = pdf.numPages;
        document.getElementById('fbLoading').style.display = 'none';
        document.getElementById('fbScene').style.display = 'flex';
        fbRender(1, null);
    }).catch(function(err) {
        document.getElementById('fbLoading').innerHTML =
            '&#9888; Gagal memuat PDF<br><small style="opacity:.6">' + err.message + '</small>';
    });
}

function closeFB() {
    document.getElementById('fbOverlay').classList.remove('active');
    document.body.style.overflow = '';
    document.getElementById('fbFlipper').style.display = 'none';
    _pdf = null; _busy = false;
    ['fbCanvasL','fbCanvasR','fbFlipFront','fbFlipBack'].forEach(function(id) {
        var c = document.getElementById(id);
        c.getContext('2d').clearRect(0, 0, c.width, c.height);
        c.width = 0;
    });
}

function fbNav(delta) {
    if (!_pdf || _busy) return;
    var isNext  = delta > 0;
    var newPage = Math.max(1, Math.min(_total, _page + delta));
    if (newPage === _page) return;
    _page = newPage;
    fbRender(_page, isNext ? 'next' : 'prev');
}

function fbZoom(d)   { _scale = Math.max(0.4, Math.min(4, _scale + d)); if (_pdf) { _busy=false; fbRender(_page, null); } }
function fbZoomReset(){ _scale = 1.3; if (_pdf) { _busy=false; fbRender(_page, null); } }

document.getElementById('fbOverlay').addEventListener('click', function(e) {
    if (e.target === this) closeFB();
});
document.addEventListener('keydown', function(e) {
    if (!document.getElementById('fbOverlay').classList.contains('active')) return;
    if (e.key==='ArrowRight') fbNav(1);
    if (e.key==='ArrowLeft')  fbNav(-1);
    if (e.key==='Escape')     closeFB();
    if (e.key==='+')          fbZoom(0.2);
    if (e.key==='-')          fbZoom(-0.2);
});

/* ── Category filter ── */
function filterBooks(cat, btn) {
    document.querySelectorAll('.fb-filter-btn').forEach(function(b) { b.classList.remove('active'); });
    btn.classList.add('active');
    document.querySelectorAll('.fb-shelf-row').forEach(function(row) {
        row.style.display = (cat === 'all' || row.dataset.cat === cat) ? 'flex' : 'none';
    });
}
</script>


