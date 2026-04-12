<?php
/**
 * Flipbook Frontend Module — Fixed v3
 * Mobile : single page, auto-fit, swipe gesture (no 3D flip)
 * Desktop: spread 2 pages, 3D flip animation, drag-to-pan, wheel zoom
 *
 * Fix list v3:
 *  1. isMobile() cached per-render, bukan per-event → konsisten
 *  2. placeFlipperOver pakai offsetLeft/offsetTop → tidak terpengaruh scroll
 *  3. Page snap logic diperbaiki untuk total halaman genap
 *  4. _busy reset di semua code path (termasuk error)
 *  5. Resize handler → recalc scale + re-render
 *  6. Swipe: preventDefault hanya kalau horizontal (tidak block scroll vertikal)
 *  7. Flip direction canvas assignment diperbaiki (front/back tidak terbalik)
 *  8. Mobile toolbar hanya tampilkan tombol yang relevan via CSS class
 */

global $koneksi_db;

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

$action   = isset($_GET['act']) ? cleantext($_GET['act']) : '';
$book_id  = isset($_GET['id'])  ? (int)$_GET['id'] : 0;
$is_admin = isset($_SESSION['LevelAkses']) && $_SESSION['LevelAkses'] === 'Administrator';
?>

<style>
/* ── Layout override ── */
.blog-right         { display: none !important; }
.col-sm-8.blog-left { width: 100% !important; padding: 0 !important; }
.blog-wrapper       { margin-top: 0 !important; background: transparent !important; padding: 0 !important; }

:root {
    --moss-dark  : #306238;
    --moss-mid   : #618D4F;
    --moss-light : #9EBB97;
    --moss-bg    : #DDE5CD;
    --moss-olive : #545837;
    --text-dark  : #1e2d20;
    --text-muted : #5a6b5c;
    --white      : #ffffff;
    --shadow-sm  : 0 2px 12px rgba(48,98,56,.10);
    --shadow-md  : 0 6px 28px rgba(48,98,56,.16);
    --radius-md  : 14px;
    --transition : all .28s cubic-bezier(.4,0,.2,1);
}

/* ── HERO ── */
.fb-hero {
    background: linear-gradient(135deg, var(--moss-dark) 0%, var(--moss-olive) 100%);
    padding: 130px 0 60px; text-align: center;
    position: relative; overflow: hidden;
}
.fb-hero::before {
    content: ''; position: absolute; top: -80px; right: -80px;
    width: 340px; height: 340px; border-radius: 50%;
    background: rgba(255,255,255,.04);
}
.fb-hero::after {
    content: ''; position: absolute; bottom: -100px; left: -60px;
    width: 300px; height: 300px; border-radius: 50%;
    background: rgba(255,255,255,.035);
}
.fb-hero-inner { position: relative; z-index: 1; }
.fb-hero-label {
    display: inline-block; color: var(--moss-bg);
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 3px; margin-bottom: 14px;
    background: rgba(255,255,255,.1); padding: 4px 14px; border-radius: 20px;
}
.fb-hero h1 {
    color: var(--white); font-size: 38px; font-weight: 900;
    margin: 0 0 14px; letter-spacing: -1px; line-height: 1.15;
}
.fb-hero p {
    color: rgba(255,255,255,.75); font-size: 15px; max-width: 520px;
    margin: 0 auto 28px; line-height: 1.75;
}
.fb-hero-divider {
    width: 56px; height: 3px; background: var(--moss-bg);
    border-radius: 2px; margin: 0 auto 28px; opacity: .7;
}
.fb-admin-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--white); color: var(--moss-dark);
    padding: 11px 26px; border-radius: 30px; font-weight: 700; font-size: 14px;
    text-decoration: none; box-shadow: 0 4px 20px rgba(0,0,0,.2); transition: var(--transition);
}
.fb-admin-btn:hover {
    background: var(--moss-bg); transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(0,0,0,.28); text-decoration: none; color: var(--moss-dark);
}

/* ── FILTER ── */
.fb-filter-wrap {
    background: var(--moss-bg); padding: 20px 0;
    border-bottom: 1px solid rgba(97,141,79,.2);
}
.fb-filter-inner { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; justify-content: center; }
.fb-filter-btn {
    padding: 7px 20px; border-radius: 30px; font-size: 13px; font-weight: 600;
    cursor: pointer; border: 2px solid var(--moss-mid); color: var(--moss-dark);
    background: transparent; transition: var(--transition);
}
.fb-filter-btn.active, .fb-filter-btn:hover {
    background: var(--moss-dark); border-color: var(--moss-dark); color: var(--white);
}

/* ── BOOKSHELF ── */
.fb-shelf-section {
    background: linear-gradient(180deg, #f0f4ed 0%, #e8ece4 100%);
    padding: 54px 0 80px; min-height: 40vh;
}
.fb-shelf-row {
    position: relative;
    background: linear-gradient(to bottom, #c9ab82, #a07444);
    border-radius: 6px; border-bottom: 12px solid #7a5230;
    box-shadow: 0 10px 28px rgba(0,0,0,.25);
    display: flex; flex-wrap: wrap; gap: 24px;
    padding: 28px 28px 36px; margin-bottom: 48px;
    min-height: 200px; align-items: flex-end;
}
.fb-shelf-row::after {
    content: ''; position: absolute; bottom: -26px; left: -8px; right: -8px;
    height: 18px; background: linear-gradient(to bottom, #5c3b1a, #3d2510);
    border-radius: 0 0 6px 6px; box-shadow: 0 6px 14px rgba(0,0,0,.3);
}
.fb-shelf-label {
    position: absolute; top: -16px; left: 14px; background: var(--moss-dark);
    color: var(--white); font-size: 10.5px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 1.5px;
    padding: 4px 14px; border-radius: 20px; box-shadow: var(--shadow-sm);
}
.fb-book {
    width: 110px; cursor: pointer; flex-shrink: 0; position: relative;
    transition: transform .32s cubic-bezier(.34,1.56,.64,1); text-decoration: none;
}
.fb-book:hover { transform: translateY(-16px) scale(1.04); }
.fb-book-cover {
    width: 110px; height: 154px; border-radius: 2px 7px 7px 2px; overflow: hidden;
    box-shadow: -5px 5px 14px rgba(0,0,0,.45), inset -4px 0 8px rgba(0,0,0,.18);
    position: relative; background: var(--moss-dark);
}
.fb-book-cover img { width:100%; height:100%; object-fit:cover; display:block; }
.fb-book-spine {
    position: absolute; left:0; top:0; bottom:0; width: 13px;
    background: rgba(0,0,0,.25); border-right: 1px solid rgba(255,255,255,.1);
}
.fb-book-no-cover {
    display: flex; align-items: center; justify-content: center;
    width: 100%; height: 100%;
    background: linear-gradient(135deg, var(--moss-dark), var(--moss-mid));
    color: var(--white); font-size: 11px; font-weight: 700;
    text-align: center; padding: 10px; line-height: 1.4;
}
.fb-book-overlay {
    position: absolute; top:0; left:0; right:0; bottom:0;
    background: rgba(48,98,56,0); transition: background .3s;
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
    max-height: 2.7em; overflow: hidden; text-decoration: none; display: block;
}

/* ── EMPTY ── */
.fb-empty { text-align: center; padding: 80px 30px; }
.fb-empty-icon {
    width: 96px; height: 96px; border-radius: 50%; background: var(--moss-bg);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 24px; box-shadow: var(--shadow-sm);
}
.fb-empty-icon svg { width:48px; height:48px; fill: var(--moss-mid); }
.fb-empty h3 { color: var(--moss-dark); font-size: 22px; font-weight: 800; margin: 0 0 10px; }
.fb-empty p  { color: var(--text-muted); font-size: 14px; margin:0 0 28px; }
.fb-empty-admin-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--moss-dark); color: var(--white); padding: 12px 28px;
    border-radius: 30px; font-weight: 700; font-size: 14px;
    text-decoration: none; transition: var(--transition); box-shadow: var(--shadow-md);
}
.fb-empty-admin-btn:hover {
    background: var(--moss-mid); color: var(--white);
    text-decoration: none; transform: translateY(-2px);
}

/* ══════════════════════════════════════════
   MODAL
══════════════════════════════════════════ */
.fb-modal-overlay {
    display: none; position: fixed; top:0; left:0; right:0; bottom:0;
    background: rgba(8,18,10,.93); z-index: 9999;
    align-items: center; justify-content: center;
}
.fb-modal-overlay.active { display: flex; }
.fb-modal {
    background: #1a2b1c; border-radius: var(--radius-md);
    width: 96vw; max-width: 1140px; height: 93vh;
    display: flex; flex-direction: column; overflow: hidden;
    box-shadow: 0 30px 80px rgba(0,0,0,.75);
    animation: fbSlideIn .35s cubic-bezier(.34,1.56,.64,1);
}
@keyframes fbSlideIn {
    from { transform: scale(.9) translateY(24px); opacity:0; }
    to   { transform: scale(1) translateY(0); opacity:1; }
}
.fb-modal-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 13px 22px; background: var(--moss-dark);
    border-radius: var(--radius-md) var(--radius-md) 0 0; flex-shrink: 0;
}
.fb-modal-header h4 {
    color: var(--white); margin:0; font-size: 15px; font-weight: 700;
    flex:1; padding-right:12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.fb-btn-close {
    background: rgba(255,255,255,.15); border: none; color: var(--white);
    font-size: 20px; line-height: 1; border-radius: 50%; width: 34px; height: 34px;
    cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.fb-btn-close:hover { background: rgba(255,255,255,.35); }

/* Toolbar */
.fb-modal-toolbar {
    display: flex; align-items: center; justify-content: center;
    gap: 6px; padding: 9px 16px; background: #111e13;
    border-bottom: 1px solid rgba(255,255,255,.07);
    flex-wrap: wrap; flex-shrink: 0;
}
.fb-modal-toolbar button {
    background: var(--moss-mid); color: var(--white); border: none;
    border-radius: 6px; padding: 7px 15px; font-size: 12.5px;
    cursor: pointer; font-weight: 600; transition: var(--transition);
    touch-action: manipulation;
}
.fb-modal-toolbar button:hover    { background: var(--moss-dark); }
.fb-modal-toolbar button:disabled { opacity:.35; cursor:default; }
.fb-page-info {
    color: #8ea090; font-size: 12.5px; min-width: 120px;
    text-align: center; font-weight: 600;
}

/* ── Canvas area ── */
.fb-canvas-wrap {
    flex: 1; overflow: auto; position: relative;
    background: #0a120b; cursor: grab;
    display: flex; align-items: flex-start; justify-content: flex-start;
    scrollbar-width: none; -ms-overflow-style: none;
    -webkit-overflow-scrolling: touch;
}
.fb-canvas-wrap::-webkit-scrollbar { display: none; }
.fb-canvas-wrap.is-dragging        { cursor: grabbing; }

.fb-scene-outer {
    display: flex; align-items: center; justify-content: center;
    min-width: 100%; min-height: 100%; flex-shrink: 0;
    padding: 20px 16px; box-sizing: border-box;
}

.fb-scene {
    position: relative; display: inline-flex;
    align-items: stretch; flex-shrink: 0;
    perspective: 2500px; perspective-origin: 50% 50%;
}
#fbCanvasL { display:block; box-shadow: -6px 0 24px rgba(0,0,0,.6); border-radius:3px 0 0 3px; }
#fbCanvasR { display:block; box-shadow:  6px 0 24px rgba(0,0,0,.6); border-radius:0 3px 3px 0; }

.fb-spine {
    width: 6px; flex-shrink: 0;
    background: linear-gradient(180deg,#4a7a52,#1d3d22 50%,#4a7a52);
    box-shadow: 2px 0 8px rgba(0,0,0,.5), -2px 0 8px rgba(0,0,0,.5);
}

/* ── Flipper (desktop) ── */
.fb-flipper {
    position: absolute;
    transform-style: preserve-3d;
    display: none;
    z-index: 20;
    pointer-events: none;
    will-change: transform;
}
.fb-flip-front, .fb-flip-back {
    position: absolute; inset: 0; overflow: hidden;
    backface-visibility: hidden; -webkit-backface-visibility: hidden;
}
.fb-flip-back { transform: rotateY(180deg); }
.fb-flip-front canvas, .fb-flip-back canvas { display:block; width:100%; height:100%; }

/* Bayangan saat flip maju (kanan ke kiri) */
.fb-flipper.is-next .fb-flip-front::after {
    content:''; position:absolute; inset:0; pointer-events:none;
    background: linear-gradient(to left, rgba(0,0,0,.45) 0%, transparent 70%);
    transition: opacity 0.3s;
}
.fb-flipper.is-next .fb-flip-back::after {
    content:''; position:absolute; inset:0; pointer-events:none;
    background: linear-gradient(to right, rgba(0,0,0,.3) 0%, transparent 60%);
}
/* Bayangan saat flip mundur (kiri ke kanan) */
.fb-flipper.is-prev .fb-flip-front::after {
    content:''; position:absolute; inset:0; pointer-events:none;
    background: linear-gradient(to right, rgba(0,0,0,.45) 0%, transparent 70%);
}
.fb-flipper.is-prev .fb-flip-back::after {
    content:''; position:absolute; inset:0; pointer-events:none;
    background: linear-gradient(to left, rgba(0,0,0,.3) 0%, transparent 60%);
}

.fb-download-link {
    display: block; text-align: center; padding: 11px;
    background: #111e13; color: var(--moss-light); font-size: 13px;
    text-decoration: none; border-top: 1px solid rgba(255,255,255,.07);
    font-weight: 600; flex-shrink: 0; transition: var(--transition);
}
.fb-download-link:hover { color: var(--moss-bg); text-decoration: none; }

.fb-loading {
    position: absolute; inset:0; display:flex; align-items:center;
    justify-content:center; color: #6a8c6e; font-size: 14px;
    gap: 10px; flex-direction: column; background: #0a120b; z-index: 5;
}
.fb-loading::before {
    content: ''; width: 32px; height: 32px; border-radius: 50%;
    border: 3px solid var(--moss-mid); border-top-color: transparent;
    animation: spin .8s linear infinite; display: block;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* Mobile swipe hint */
.fb-swipe-hint {
    position: absolute; bottom: 16px; left: 50%; transform: translateX(-50%);
    background: rgba(48,98,56,.7); color: #fff; font-size: 11px;
    padding: 5px 14px; border-radius: 20px; pointer-events: none;
    opacity: 1; transition: opacity 1s;
    display: none;
}
.fb-swipe-hint.visible { display: block; }
.fb-swipe-hint.fade    { opacity: 0; }

/* ══════════════════════════════════════════
   MOBILE (≤767px)
══════════════════════════════════════════ */
@media (max-width: 767px) {
    .fb-hero h1    { font-size: 26px; }
    .fb-book       { width: 88px; }
    .fb-book-cover { width: 88px; height: 126px; }
    .fb-shelf-row  { gap: 16px; padding: 22px 18px 32px; }

    .fb-modal-overlay { align-items: flex-end; }
    .fb-modal {
        width: 100vw !important; max-width: 100vw !important;
        height: 100dvh !important;
        border-radius: 0 !important; animation: none !important;
    }
    .fb-modal-header    { border-radius: 0; padding: 10px 14px; }
    .fb-modal-header h4 { font-size: 13px; }
    .fb-btn-close       { width: 30px; height: 30px; font-size: 18px; }

    /* Toolbar mobile: grid 3 kolom (Prev | Info | Next) + Zoom row */
    .fb-modal-toolbar {
        gap: 4px; padding: 6px 8px;
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        justify-items: stretch;
    }
    .fb-modal-toolbar button {
        padding: 10px 6px; font-size: 13px; width: 100%;
    }
    .fb-page-info {
        font-size: 12px; min-width: auto;
        background: rgba(255,255,255,.06); border-radius: 6px;
        padding: 5px 10px; white-space: nowrap;
    }
    /* Sembunyikan tombol desktop-only */
    .fb-tb-desktop { display: none !important; }

    /* Buat Zoom +/- span full row */
    .fb-tb-zoom-row {
        grid-column: 1 / -1;
        display: flex; gap: 6px;
    }
    .fb-tb-zoom-row button { flex: 1; }

    /* Canvas: full bleed, no extra padding */
    .fb-canvas-wrap { cursor: default; }
    .fb-scene-outer { padding: 0; align-items: flex-start; justify-content: flex-start; }

    /* Sembunyikan elemen desktop */
    #fbSpine   { display: none !important; }
    #fbCanvasR { display: none !important; width: 0 !important; }
    #fbFlipper { display: none !important; }

    #fbCanvasL {
        width: 100% !important;
        box-shadow: none !important;
        border-radius: 0 !important;
    }
}
</style>

<?php /* ── HERO ── */ ?>
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
$all_books = [];
$q = $koneksi_db->sql_query("SELECT * FROM mod_data_flipbook WHERE status='1' ORDER BY ordering ASC, id DESC");
while ($bk = $koneksi_db->sql_fetchrow($q)) { $all_books[] = $bk; }
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
            <button class="fb-filter-btn active" onclick="filterBooks('all',this)">📚 Semua</button>
            <?php foreach ($all_cats as $cat): ?>
            <button class="fb-filter-btn" onclick="filterBooks('<?= htmlspecialchars(addslashes($cat)) ?>',this)">
                <?= htmlspecialchars($cat) ?>
            </button>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

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
        $per_row = 7;
        if (!empty($all_cats)) {
            foreach ($all_cats as $cat) {
                $cat_books = array_values(array_filter($all_books, function($b) use ($cat) {
                    return trim($b['kategori']) === $cat;
                }));
                if (empty($cat_books)) continue;
                foreach (array_chunk($cat_books, $per_row) as $ci => $row_books):
        ?>
                <div class="fb-shelf-row" data-cat="<?= htmlspecialchars($cat) ?>">
                    <?php if ($ci === 0): ?>
                    <span class="fb-shelf-label"><?= htmlspecialchars($cat) ?></span>
                    <?php endif; ?>
                    <?php foreach ($row_books as $bk):
                        $cs = !empty($bk['cover']) ? 'images/flipbook/'.htmlspecialchars($bk['cover']) : '';
                        $jd = htmlspecialchars($bk['judul']);
                        $pf = htmlspecialchars($bk['file_pdf']); ?>
                    <div class="fb-book" onclick="openFB('<?= $pf ?>','<?= addslashes($jd) ?>')" data-cat="<?= htmlspecialchars($cat) ?>">
                        <div class="fb-book-cover">
                            <div class="fb-book-spine"></div>
                            <?php if ($cs): ?><img src="<?= $cs ?>" alt="<?= $jd ?>">
                            <?php else: ?><div class="fb-book-no-cover"><?= $jd ?></div><?php endif; ?>
                            <div class="fb-book-overlay"><span>&#128214; Buka</span></div>
                        </div>
                        <div class="fb-book-title"><?= $jd ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
        <?php   endforeach;
            }
            $no_cat = array_values(array_filter($all_books, function($b){ return empty(trim($b['kategori'])); }));
            if (!empty($no_cat)) {
                foreach (array_chunk($no_cat, $per_row) as $row_books):
        ?>
                <div class="fb-shelf-row" data-cat="all">
                    <span class="fb-shelf-label">Lainnya</span>
                    <?php foreach ($row_books as $bk):
                        $cs = !empty($bk['cover']) ? 'images/flipbook/'.htmlspecialchars($bk['cover']) : '';
                        $jd = htmlspecialchars($bk['judul']);
                        $pf = htmlspecialchars($bk['file_pdf']); ?>
                    <div class="fb-book" onclick="openFB('<?= $pf ?>','<?= addslashes($jd) ?>')" data-cat="">
                        <div class="fb-book-cover">
                            <div class="fb-book-spine"></div>
                            <?php if ($cs): ?><img src="<?= $cs ?>" alt="<?= $jd ?>">
                            <?php else: ?><div class="fb-book-no-cover"><?= $jd ?></div><?php endif; ?>
                            <div class="fb-book-overlay"><span>&#128214; Buka</span></div>
                        </div>
                        <div class="fb-book-title"><?= $jd ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
        <?php   endforeach;
            }
        } else {
            foreach (array_chunk($all_books, $per_row) as $row_books):
        ?>
            <div class="fb-shelf-row">
                <?php foreach ($row_books as $bk):
                    $cs = !empty($bk['cover']) ? 'images/flipbook/'.htmlspecialchars($bk['cover']) : '';
                    $jd = htmlspecialchars($bk['judul']);
                    $pf = htmlspecialchars($bk['file_pdf']); ?>
                <div class="fb-book" onclick="openFB('<?= $pf ?>','<?= addslashes($jd) ?>')">
                    <div class="fb-book-cover">
                        <div class="fb-book-spine"></div>
                        <?php if ($cs): ?><img src="<?= $cs ?>" alt="<?= $jd ?>">
                        <?php else: ?><div class="fb-book-no-cover"><?= $jd ?></div><?php endif; ?>
                        <div class="fb-book-overlay"><span>&#128214; Buka</span></div>
                    </div>
                    <div class="fb-book-title"><?= $jd ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php   endforeach;
        } ?>

        <?php if ($is_admin): ?>
        <div style="text-align:center;margin-top:24px;">
            <a href="admin.php?pilih=flipbook&modul=yes" class="fb-admin-btn" style="display:inline-flex;">
                <svg viewBox="0 0 24 24" style="width:17px;height:17px;fill:var(--moss-dark)"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                Kelola Koleksi Buku
            </a>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<section style="background:var(--moss-bg);padding:48px 0;text-align:center;border-top:2px solid rgba(97,141,79,.15);">
    <div class="container">
        <span style="display:block;color:var(--moss-mid);font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;margin-bottom:10px;">Informasi</span>
        <h2 style="color:var(--moss-dark);font-size:22px;font-weight:800;margin:0 0 12px;">Butuh Bantuan atau Informasi Lebih?</h2>
        <p style="color:var(--text-muted);font-size:14px;max-width:480px;margin:0 auto 24px;line-height:1.8;">
            Hubungi tim MBKM IAI PI Bandung untuk informasi lebih lanjut mengenai program dan pedoman pelaksanaan.
        </p>
        <a href="index.php" style="display:inline-flex;align-items:center;gap:8px;background:var(--moss-dark);color:#fff;padding:12px 30px;border-radius:30px;font-weight:700;font-size:14px;text-decoration:none;box-shadow:0 4px 20px rgba(48,98,56,.3);">
            <svg viewBox="0 0 24 24" style="width:17px;height:17px;fill:#fff"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
            Kembali ke Beranda
        </a>
    </div>
</section>

<?php /* ── MODAL ── */ ?>
<div class="fb-modal-overlay" id="fbOverlay">
    <div class="fb-modal">
        <div class="fb-modal-header">
            <h4 id="fbTitle">Memuat Buku...</h4>
            <button class="fb-btn-close" onclick="closeFB()">&#x2715;</button>
        </div>

        <!--
            Toolbar layout:
            Desktop: [Prev] [«2] [Info] [2»] [Next] [+Zoom] [-Zoom] [Reset]
            Mobile : [Prev] [Info] [Next]  ←── via CSS grid 3 kolom
                     [+Zoom ─────── -Zoom]  ←── fb-tb-zoom-row
            Tombol .fb-tb-desktop disembunyikan di mobile via CSS
        -->
        <div class="fb-modal-toolbar">
            <button id="btnPrev">&#9664; Prev</button>
            <button id="btnPrev2" class="fb-tb-desktop">&#171; 2 Hal</button>
            <span   class="fb-page-info" id="fbPageInfo">Hal 1 / 1</span>
            <button id="btnNext2" class="fb-tb-desktop">2 Hal &#187;</button>
            <button id="btnNext">Next &#9654;</button>
            <div class="fb-tb-zoom-row fb-tb-desktop" style="display:flex;gap:6px;">
                <button onclick="fbZoom(0.2)" style="flex:1;">&#43; Zoom</button>
                <button onclick="fbZoom(-0.2)" style="flex:1;">&#8722; Zoom</button>
                <button onclick="fbZoomReset()" style="flex:1;background:rgba(255,255,255,.12);">&#8635;</button>
            </div>
            <!-- Mobile zoom row -->
            <div class="fb-tb-zoom-row" id="mobileZoomRow" style="display:none;grid-column:1/-1;">
                <button onclick="fbZoom(0.15)" style="flex:1;">&#43; Zoom</button>
                <button onclick="fbZoom(-0.15)" style="flex:1;">&#8722; Zoom</button>
            </div>
        </div>

        <div class="fb-canvas-wrap" id="fbCanvasWrap">
            <div class="fb-loading" id="fbLoading">Memuat dokumen...</div>
            <div class="fb-scene-outer" id="fbSceneOuter" style="display:none;">
                <div class="fb-scene" id="fbScene">
                    <canvas id="fbCanvasL"></canvas>
                    <div    id="fbSpine" class="fb-spine" style="display:none;"></div>
                    <canvas id="fbCanvasR" style="display:none;"></canvas>
                    <!-- Flipper overlay untuk animasi 3D (desktop only) -->
                    <div class="fb-flipper" id="fbFlipper">
                        <div class="fb-flip-front"><canvas id="fbFlipFront"></canvas></div>
                        <div class="fb-flip-back" ><canvas id="fbFlipBack" ></canvas></div>
                    </div>
                </div>
            </div>
            <!-- Hint swipe untuk mobile -->
            <div class="fb-swipe-hint" id="fbSwipeHint">&#8592; geser untuk pindah halaman &#8594;</div>
        </div>
        <a href="#" id="fbDownload" class="fb-download-link" target="_blank" rel="noopener">
            &#11015; Download PDF
        </a>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
pdfjsLib.GlobalWorkerOptions.workerSrc =
    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

/* ════════════════════════════════════════
   STATE
════════════════════════════════════════ */
var _pdf   = null;
var _page  = 1;
var _total = 0;
var _busy  = false;
var _scale = 1.3;
var FLIP_MS = 660;

/* Cache elemen DOM sekali saja */
var EL = {};
function el(id) { return EL[id] || (EL[id] = document.getElementById(id)); }

/* ════════════════════════════════════════
   UTILITY
════════════════════════════════════════ */
function isMobile() { return window.innerWidth <= 767; }

/*
 * calcAutoScale — hitung scale agar halaman muat di area modal.
 * Mobile : 1 halaman, lebar penuh.
 * Desktop: 2 halaman berdampingan, setengah lebar dikurangi spine.
 */
function calcAutoScale() {
    var wrap   = el('fbCanvasWrap');
    var availW = wrap.clientWidth  - 32;   /* padding kiri + kanan */
    var availH = wrap.clientHeight - 40;   /* breathing room atas-bawah */
    if (!_pdf) return Promise.resolve(isMobile() ? 1.0 : 1.3);

    return _pdf.getPage(1).then(function(pg) {
        var vp = pg.getViewport({ scale: 1 });
        var mob = isMobile();
        var maxW = mob ? availW : Math.floor((availW - 6) / 2);   /* 6 = lebar spine */
        var scaleW = maxW   / vp.width;
        var scaleH = availH / vp.height;
        return Math.max(0.3, Math.min(3.5, Math.min(scaleW, scaleH)));
    });
}

/* Render satu halaman ke canvas, DPR-aware (cap 2×) */
function rndPage(num, canvas) {
    if (!_pdf || num < 1 || num > _total) {
        canvas.width = 0; canvas.height = 0;
        canvas.style.display = 'none';
        return Promise.resolve(null);
    }
    var dpr = Math.min(window.devicePixelRatio || 1, 2);
    return _pdf.getPage(num).then(function(pg) {
        var vp = pg.getViewport({ scale: _scale * dpr });
        canvas.width  = vp.width;
        canvas.height = vp.height;
        canvas.style.width  = Math.round(vp.width  / dpr) + 'px';
        canvas.style.height = Math.round(vp.height / dpr) + 'px';
        canvas.style.display = 'block';
        return pg.render({ canvasContext: canvas.getContext('2d'), viewport: vp }).promise
            .then(function() { return canvas; });
    });
}

/* Salin konten canvas src ke dst (untuk flipper) */
function copyCanvas(src, dst) {
    if (!src || !src.width) return;
    dst.width  = src.width;  dst.height = src.height;
    dst.style.width  = src.style.width;
    dst.style.height = src.style.height;
    dst.style.display = 'block';
    dst.getContext('2d').drawImage(src, 0, 0);
}

/* Update info halaman & status tombol */
function updateUI(p) {
    var mob  = isMobile();
    var hasR = !mob && (p + 1 <= _total);

    el('fbSpine').style.display = hasR ? 'block' : 'none';

    var cR = el('fbCanvasR');
    if (!hasR) { cR.style.display = 'none'; cR.width = 0; }

    var label = 'Hal ' + p + (hasR ? '\u2013' + (p + 1) : '') + ' / ' + _total;
    el('fbPageInfo').textContent = label;

    el('btnPrev').disabled  = (p <= 1);
    el('btnPrev2').disabled = (p <= 1);
    el('btnNext').disabled  = (p >= _total);
    el('btnNext2').disabled = mob ? (p >= _total) : (p + 1 >= _total);

    /* Mobile zoom row */
    el('mobileZoomRow').style.display = mob ? 'flex' : 'none';
}

/* ════════════════════════════════════════
   RENDER TANPA ANIMASI
════════════════════════════════════════ */
function fbRenderDirect(p, cb) {
    var mob = isMobile();
    var cL  = el('fbCanvasL');
    var cR  = el('fbCanvasR');

    /* Mobile: paksa lebar canvas = lebar wrap */
    if (mob) {
        cL.style.removeProperty('width'); /* biarkan JS set via rndPage */
    }

    var tasks = [rndPage(p, cL)];
    if (!mob && p + 1 <= _total) {
        tasks.push(rndPage(p + 1, cR));
    } else {
        cR.style.display = 'none'; cR.width = 0;
    }

    Promise.all(tasks).then(function() {
        updateUI(p);
        _busy = false;
        if (cb) cb();
    }).catch(function() { _busy = false; });
}

/* ════════════════════════════════════════
   RENDER DENGAN ANIMASI FLIP 3D (desktop)
════════════════════════════════════════ */
function fbRenderFlip(p, dir) {
    /* Jangan pernah jalankan flip di mobile — fallback langsung */
    if (isMobile()) { fbRenderDirect(p); return; }

    var cL      = el('fbCanvasL');
    var cR      = el('fbCanvasR');
    var scene   = el('fbScene');
    var flipper = el('fbFlipper');
    var flipF   = el('fbFlipFront');
    var flipB   = el('fbFlipBack');

    /* Reset kelas flipper */
    flipper.className = 'fb-flipper';

    if (dir === 'next') {
        /*
         * MAJU: halaman kanan (cR) berputar ke kiri menjadi halaman baru kiri.
         * front = halaman kanan lama (yang "dibalik")
         * back  = halaman kiri baru (terungkap setelah flip)
         * origin = kiri flipper (0%)
         * rotasi = -180deg
         */
        if (!cR.offsetWidth) { _busy = false; fbRenderDirect(p); return; }

        copyCanvas(cR, flipF);

        /* Posisi flipper = posisi cR dalam fbScene */
        flipper.style.cssText = [
            'display:block',
            'width:'  + cR.offsetWidth  + 'px',
            'height:' + cR.offsetHeight + 'px',
            'left:'   + cR.offsetLeft   + 'px',
            'top:'    + cR.offsetTop    + 'px',
            'transform-origin: 0% 50%',
            'transform: rotateY(0deg)',
            'transition: none',
            'z-index: 20',
            'pointer-events: none'
        ].join(';');

        flipper.classList.add('is-next');

        /* Sembunyikan halaman kanan asli & render konten baru di background */
        cR.style.visibility = 'hidden';

        /* Render halaman baru:
           p   = halaman kiri baru  → masuk ke flipB (terungkap saat flip selesai)
           p+1 = halaman kanan baru → langsung ke cR (sudah ada, revealed setelah flipper hilang) */
        Promise.all([ rndPage(p, flipB), rndPage(p + 1, cR) ]).then(function() {
            /* Sync ukuran flipB dengan flipF agar tidak kelihatan beda */
            flipB.style.width  = flipF.style.width;
            flipB.style.height = flipF.style.height;

            /* Jalankan animasi setelah 2 frame (hindari flicker) */
            requestAnimationFrame(function() {
                requestAnimationFrame(function() {
                    flipper.style.transition = 'transform ' + FLIP_MS + 'ms cubic-bezier(0.77,0,0.175,1)';
                    flipper.style.transform  = 'rotateY(-180deg)';
                });
            });

            setTimeout(function() {
                flipper.style.transition = 'none';
                flipper.style.display    = 'none';
                flipper.className = 'fb-flipper';
                cR.style.visibility = 'visible';
                /* Render ulang cL dengan halaman p yang benar */
                fbRenderDirect(p);
            }, FLIP_MS + 80);
        }).catch(function() {
            flipper.style.display = 'none';
            cR.style.visibility = 'visible';
            _busy = false;
        });

    } else {
        /*
         * MUNDUR: halaman kiri (cL) berputar ke kanan menjadi halaman baru kanan.
         * front = halaman kiri lama (yang "dibalik")
         * back  = halaman kanan baru (terungkap setelah flip)
         * origin = kanan flipper (100%)
         * rotasi = +180deg
         */
        if (!cL.offsetWidth) { _busy = false; fbRenderDirect(p); return; }

        copyCanvas(cL, flipF);

        flipper.style.cssText = [
            'display:block',
            'width:'  + cL.offsetWidth  + 'px',
            'height:' + cL.offsetHeight + 'px',
            'left:'   + cL.offsetLeft   + 'px',
            'top:'    + cL.offsetTop    + 'px',
            'transform-origin: 100% 50%',
            'transform: rotateY(0deg)',
            'transition: none',
            'z-index: 20',
            'pointer-events: none'
        ].join(';');

        flipper.classList.add('is-prev');

        cL.style.visibility = 'hidden';

        /* Render:
           p+1 = halaman kanan baru → masuk flipB (terungkap)
           p   = halaman kiri baru  → ke cL (revealed setelah flipper hilang) */
        Promise.all([ rndPage(p + 1, flipB), rndPage(p, cL) ]).then(function() {
            flipB.style.width  = flipF.style.width;
            flipB.style.height = flipF.style.height;

            requestAnimationFrame(function() {
                requestAnimationFrame(function() {
                    flipper.style.transition = 'transform ' + FLIP_MS + 'ms cubic-bezier(0.77,0,0.175,1)';
                    flipper.style.transform  = 'rotateY(180deg)';
                });
            });

            setTimeout(function() {
                flipper.style.transition = 'none';
                flipper.style.display    = 'none';
                flipper.className = 'fb-flipper';
                cL.style.visibility = 'visible';
                fbRenderDirect(p);
            }, FLIP_MS + 80);
        }).catch(function() {
            flipper.style.display = 'none';
            cL.style.visibility = 'visible';
            _busy = false;
        });
    }
}

/* ════════════════════════════════════════
   OPEN / CLOSE
════════════════════════════════════════ */
function openFB(url, title) {
    el('fbTitle').textContent = title;
    el('fbDownload').href     = url;
    el('fbOverlay').classList.add('active');
    el('fbLoading').style.display    = 'flex';
    el('fbSceneOuter').style.display = 'none';
    document.body.style.overflow = 'hidden';
    _page = 1; _busy = false;

    pdfjsLib.getDocument(url).promise.then(function(pdf) {
        _pdf = pdf; _total = pdf.numPages;
        return calcAutoScale();
    }).then(function(s) {
        _scale = s;
        el('fbLoading').style.display    = 'none';
        el('fbSceneOuter').style.display = 'flex';
        fbRenderDirect(1, function() {
            /* Tampilkan swipe hint di mobile */
            if (isMobile()) showSwipeHint();
        });
    }).catch(function(err) {
        el('fbLoading').innerHTML =
            '&#9888; Gagal memuat PDF<br><small style="opacity:.6">' + err.message + '</small>';
        _busy = false;
    });
}

function closeFB() {
    el('fbOverlay').classList.remove('active');
    document.body.style.overflow = '';

    /* Bersihkan semua canvas */
    ['fbCanvasL','fbCanvasR','fbFlipFront','fbFlipBack'].forEach(function(id) {
        var c = el(id);
        if (c.width > 0) c.getContext('2d').clearRect(0, 0, c.width, c.height);
        c.width = 0; c.height = 0; c.style.display = 'none';
    });

    var flipper = el('fbFlipper');
    flipper.style.display = 'none';
    flipper.className = 'fb-flipper';
    el('fbSpine').style.display = 'none';

    _pdf = null; _busy = false; _page = 1;
}

/* ════════════════════════════════════════
   NAVIGASI
════════════════════════════════════════ */
/*
 * Logika snap halaman:
 * - Desktop: selalu tampilkan halaman ganjil di kiri (spread 1–2, 3–4, dst.)
 * - Mobile : satu halaman, tidak ada snap
 * - Halaman terakhir genap tetap bisa ditampilkan
 */
function snapPage(p) {
    if (isMobile()) return Math.max(1, Math.min(_total, p));
    /* Snap ke ganjil, tapi jika total genap dan p=total, biarkan */
    var snapped = (p % 2 === 0) ? Math.max(1, p - 1) : p;
    return Math.max(1, Math.min(_total, snapped));
}

function fbNavSingle(dir) {
    if (!_pdf || _busy) return;
    var mob  = isMobile();
    var step = mob ? 1 : 2;
    var newP = snapPage(_page + dir * step);
    if (newP === _page) {
        /* Coba tanpa snap jika stuck di akhir */
        newP = Math.max(1, Math.min(_total, _page + dir));
        if (newP === _page) return;
    }
    _busy = true; _page = newP;
    if (mob) fbRenderDirect(_page);
    else     fbRenderFlip(_page, dir > 0 ? 'next' : 'prev');
}

function fbNavDouble(dir) {
    if (!_pdf || _busy || isMobile()) return;
    var newP = snapPage(_page + dir * 4);
    if (newP === _page) return;
    _busy = true; _page = newP;
    fbRenderDirect(_page);
}

/* ════════════════════════════════════════
   ZOOM
════════════════════════════════════════ */
function fbZoom(d) {
    if (!_pdf) return;
    _scale = Math.max(0.3, Math.min(4, _scale + d));
    _busy = false;
    fbRenderDirect(_page);
}

function fbZoomReset() {
    if (!_pdf) return;
    calcAutoScale().then(function(s) { _scale = s; _busy = false; fbRenderDirect(_page); });
}

/* ════════════════════════════════════════
   BIND TOOLBAR
════════════════════════════════════════ */
el('btnPrev').onclick  = function() { fbNavSingle(-1); };
el('btnNext').onclick  = function() { fbNavSingle(1);  };
el('btnPrev2').onclick = function() { fbNavDouble(-1); };
el('btnNext2').onclick = function() { fbNavDouble(1);  };

/* Backdrop close */
el('fbOverlay').addEventListener('click', function(e) {
    if (e.target === this) closeFB();
});

/* ════════════════════════════════════════
   KEYBOARD
════════════════════════════════════════ */
document.addEventListener('keydown', function(e) {
    if (!el('fbOverlay').classList.contains('active')) return;
    if (e.key === 'ArrowRight') fbNavSingle(1);
    if (e.key === 'ArrowLeft')  fbNavSingle(-1);
    if (e.key === 'Escape')     closeFB();
    if (e.key === '+')          fbZoom(0.2);
    if (e.key === '-')          fbZoom(-0.2);
    if (e.key === '0')          fbZoomReset();
});

/* ════════════════════════════════════════
   SWIPE GESTURE (mobile)
   Fix: preventDefault hanya saat horizontal
════════════════════════════════════════ */
(function() {
    var wrap = el('fbCanvasWrap');
    var sx, sy, sScrollTop, deciding, decidedAxis;

    wrap.addEventListener('touchstart', function(e) {
        if (e.touches.length !== 1) return;
        sx = e.touches[0].clientX;
        sy = e.touches[0].clientY;
        sScrollTop = wrap.scrollTop;
        deciding = true; decidedAxis = null;
    }, { passive: true });

    wrap.addEventListener('touchmove', function(e) {
        if (!deciding && decidedAxis !== 'h') return;
        var dx = e.touches[0].clientX - sx;
        var dy = e.touches[0].clientY - sy;
        if (deciding && (Math.abs(dx) > 8 || Math.abs(dy) > 8)) {
            decidedAxis = Math.abs(dx) > Math.abs(dy) ? 'h' : 'v';
            deciding = false;
        }
        if (decidedAxis === 'h') {
            e.preventDefault(); /* blokir scroll saat swipe horizontal */
        }
    }, { passive: false });

    wrap.addEventListener('touchend', function(e) {
        if (!isMobile() || decidedAxis !== 'h') return;
        var dx = e.changedTouches[0].clientX - sx;
        if (Math.abs(dx) > 45) {
            fbNavSingle(dx < 0 ? 1 : -1);
        }
    }, { passive: true });
})();

/* ════════════════════════════════════════
   SWIPE HINT (mobile)
════════════════════════════════════════ */
function showSwipeHint() {
    var hint = el('fbSwipeHint');
    hint.classList.add('visible');
    setTimeout(function() { hint.classList.add('fade'); }, 2400);
    setTimeout(function() { hint.classList.remove('visible', 'fade'); }, 3500);
}

/* ════════════════════════════════════════
   DRAG-TO-PAN + MOMENTUM (desktop)
════════════════════════════════════════ */
(function() {
    var wrap = el('fbCanvasWrap');
    var isDown = false, lx, ly, velX = 0, velY = 0, rafId = null;
    var FRICTION = 0.87;

    function cancelMomentum() {
        if (rafId) { cancelAnimationFrame(rafId); rafId = null; }
    }
    function applyMomentum() {
        velX *= FRICTION; velY *= FRICTION;
        wrap.scrollLeft -= velX; wrap.scrollTop -= velY;
        if (Math.abs(velX) > 0.5 || Math.abs(velY) > 0.5) {
            rafId = requestAnimationFrame(applyMomentum);
        } else { rafId = null; }
    }

    function onDown(e) {
        if (isMobile()) return; /* drag hanya desktop */
        if (e.target.tagName === 'BUTTON' || e.target.tagName === 'A') return;
        cancelMomentum();
        isDown = true;
        var pt = e.touches ? e.touches[0] : e;
        lx = pt.clientX; ly = pt.clientY; velX = 0; velY = 0;
        wrap.classList.add('is-dragging');
        wrap.style.userSelect = 'none';
        e.preventDefault();
    }
    function onMove(e) {
        if (!isDown || isMobile()) return;
        e.preventDefault();
        var pt = e.touches ? e.touches[0] : e;
        var dx = pt.clientX - lx, dy = pt.clientY - ly;
        velX = velX * 0.4 + dx * 0.6;
        velY = velY * 0.4 + dy * 0.6;
        wrap.scrollLeft -= dx; wrap.scrollTop -= dy;
        lx = pt.clientX; ly = pt.clientY;
    }
    function onUp() {
        if (!isDown) return; isDown = false;
        wrap.classList.remove('is-dragging');
        wrap.style.userSelect = '';
        if (Math.abs(velX) > 1.5 || Math.abs(velY) > 1.5) {
            rafId = requestAnimationFrame(applyMomentum);
        }
    }

    wrap.addEventListener('mousedown',     onDown, { passive: false });
    document.addEventListener('mousemove', onMove, { passive: false });
    document.addEventListener('mouseup',   onUp);

    /* Wheel zoom ke posisi kursor */
    wrap.addEventListener('wheel', function(e) {
        e.preventDefault();
        if (!_pdf) return;
        cancelMomentum();
        var STEP = 0.12, old = _scale;
        _scale = Math.max(0.3, Math.min(4, _scale + (e.deltaY < 0 ? STEP : -STEP)));
        if (_scale === old) return;
        var wr    = wrap.getBoundingClientRect();
        var cx    = e.clientX - wr.left + wrap.scrollLeft;
        var cy    = e.clientY - wr.top  + wrap.scrollTop;
        var ratio = _scale / old;
        _busy = false;
        fbRenderDirect(_page, function() {
            wrap.scrollLeft = Math.round(cx * ratio - (e.clientX - wr.left));
            wrap.scrollTop  = Math.round(cy * ratio - (e.clientY - wr.top));
        });
    }, { passive: false });
})();

/* ════════════════════════════════════════
   RESIZE — recalc scale saat orientasi berubah
════════════════════════════════════════ */
(function() {
    var resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (!_pdf || !el('fbOverlay').classList.contains('active')) return;
            calcAutoScale().then(function(s) {
                _scale = s; _busy = false; fbRenderDirect(_page);
            });
        }, 280);
    });
})();

/* ════════════════════════════════════════
   CATEGORY FILTER
════════════════════════════════════════ */
function filterBooks(cat, btn) {
    document.querySelectorAll('.fb-filter-btn').forEach(function(b) { b.classList.remove('active'); });
    btn.classList.add('active');
    document.querySelectorAll('.fb-shelf-row').forEach(function(row) {
        row.style.display = (cat === 'all' || row.dataset.cat === cat) ? 'flex' : 'none';
    });
}
</script>