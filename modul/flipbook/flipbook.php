<?php
/**
 * Flipbook Frontend — Unified Visual & Engine v4
 * Sama persis dengan modal di kiri.php:
 *  - Drag-to-pan via overflow:auto scroll
 *  - Momentum scroll
 *  - Wheel zoom toward cursor
 *  - 3D flip animation (desktop)
 *  - Mobile swipe gesture
 *  - Thumbnail strip
 *  - Bookshelf visual ala kiri.php
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

$is_admin = isset($_SESSION['LevelAkses']) && $_SESSION['LevelAkses'] === 'Administrator';
?>

<style>
/* ── Layout override ── */
.blog-right         { display: none !important; }
.col-sm-8.blog-left { width: 100% !important; padding: 0 !important; }
.blog-wrapper       { margin-top: 0 !important; background: transparent !important; padding: 0 !important; }

@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap');

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
    --shadow-lg  : 0 14px 48px rgba(48,98,56,.22);
    --radius-md  : 14px;
    --radius-lg  : 20px;
    --ease-out   : cubic-bezier(.16,1,.3,1);
    --ease-spring: cubic-bezier(.34,1.56,.64,1);
}

* { box-sizing: border-box; }
body, section, div, button, input { font-family: 'Plus Jakarta Sans', sans-serif; }

/* ══════════════════════════════════════
   HERO
══════════════════════════════════════ */
.fb-hero {
    background: linear-gradient(135deg, var(--moss-dark) 0%, var(--moss-olive) 100%);
    padding: 130px 0 64px; text-align: center;
    position: relative; overflow: hidden;
}
.fb-hero::before {
    content: ''; position: absolute; top: -80px; right: -80px;
    width: 340px; height: 340px; border-radius: 50%; background: rgba(255,255,255,.04);
}
.fb-hero::after {
    content: ''; position: absolute; bottom: -100px; left: -60px;
    width: 300px; height: 300px; border-radius: 50%; background: rgba(255,255,255,.035);
}
.fb-hero-inner { position: relative; z-index: 1; }
.fb-hero-label {
    display: inline-block; color: var(--moss-bg);
    font-size: 10.5px; font-weight: 800; text-transform: uppercase;
    letter-spacing: 3.5px; margin-bottom: 14px;
    background: rgba(255,255,255,.1); padding: 4px 16px; border-radius: 20px;
}
.fb-hero h1 {
    color: var(--white); font-size: 40px; font-weight: 900;
    margin: 0 0 14px; letter-spacing: -1.2px; line-height: 1.1;
}
.fb-hero p {
    color: rgba(255,255,255,.72); font-size: 14.5px; max-width: 500px;
    margin: 0 auto 28px; line-height: 1.8;
}
.fb-hero-divider {
    width: 48px; height: 3px; background: var(--moss-bg);
    border-radius: 2px; margin: 0 auto 28px; opacity: .65;
}
.fb-admin-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--white); color: var(--moss-dark);
    padding: 11px 26px; border-radius: 30px; font-weight: 800; font-size: 14px;
    text-decoration: none; box-shadow: 0 4px 20px rgba(0,0,0,.22);
    transition: background .25s, transform .25s var(--ease-spring), box-shadow .25s;
}
.fb-admin-btn:hover {
    background: var(--moss-bg); transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,.3); text-decoration: none; color: var(--moss-dark);
}

/* ══════════════════════════════════════
   FILTER BAR
══════════════════════════════════════ */
.fb-filter-wrap {
    background: var(--moss-bg); padding: 18px 0;
    border-bottom: 1px solid rgba(97,141,79,.2);
}
.fb-filter-inner { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; justify-content: center; }
.fb-filter-btn {
    padding: 7px 20px; border-radius: 30px; font-size: 12.5px; font-weight: 700;
    cursor: pointer; border: 2px solid var(--moss-mid); color: var(--moss-dark);
    background: transparent; transition: background .22s, color .22s, transform .22s var(--ease-spring);
    font-family: inherit;
}
.fb-filter-btn:hover { transform: translateY(-2px); }
.fb-filter-btn.active, .fb-filter-btn:hover {
    background: var(--moss-dark); border-color: var(--moss-dark); color: var(--white);
}

/* ══════════════════════════════════════
   BOOKSHELF (SAMA PERSIS KiriPHP)
══════════════════════════════════════ */
.fb-shelf-section {
    background: linear-gradient(180deg, #f0f4ed 0%, #e6ebe0 100%);
    padding: 54px 0 80px; min-height: 40vh;
}

.fb-search-bar {
    display: flex; max-width: 420px; margin: 0 auto 36px;
    background: #f3f7f0; border: 1.5px solid #ccd8c0; border-radius: 30px; overflow: hidden;
    transition: border-color .3s, box-shadow .3s;
}
.fb-search-bar:focus-within { border-color: var(--moss-mid); box-shadow: 0 0 0 4px rgba(97,141,79,.12); }
.fb-search-bar input {
    flex: 1; border: none; background: transparent;
    padding: 11px 18px; font-size: 13.5px; color: #333; outline: none; font-family: inherit;
}
.fb-search-bar input::placeholder { color: #aab8a8; }
.fb-search-bar button {
    background: var(--moss-dark); border: none; color: #fff;
    padding: 0 20px; cursor: pointer; transition: background .28s;
    display: flex; align-items: center;
}
.fb-search-bar button:hover { background: var(--moss-mid); }
.fb-search-bar button svg { width: 18px; height: 18px; fill: currentColor; }

.fb-shelf-row {
    position: relative;
    background: linear-gradient(175deg, #cdb07f 0%, #a07448 50%, #c4a579 100%);
    border-radius: 6px; border-bottom: 14px solid #7a5028;
    box-shadow: 0 12px 32px rgba(0,0,0,.24);
    display: flex; flex-wrap: wrap; gap: 22px;
    padding: 26px 26px 34px; margin-bottom: 48px;
    min-height: 190px; align-items: flex-end;
}
.fb-shelf-row::before {
    content: ''; position: absolute; bottom: -28px; left: -8px; right: -8px;
    height: 18px; background: linear-gradient(to bottom, #5c3b1a, #3a2210);
    border-radius: 0 0 6px 6px; box-shadow: 0 6px 14px rgba(0,0,0,.3);
}
.fb-shelf-row::after {
    content: ''; position: absolute; inset: 0; border-radius: 6px 6px 0 0;
    background: repeating-linear-gradient(
        91deg,
        rgba(255,255,255,0) 0px, rgba(255,255,255,.04) 1px,
        rgba(0,0,0,0) 2px, rgba(0,0,0,.03) 4px,
        rgba(255,255,255,0) 6px
    );
    pointer-events: none;
}
.fb-shelf-label {
    position: absolute; top: -15px; left: 14px; background: var(--moss-dark);
    color: var(--white); font-size: 10px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 2px;
    padding: 4px 14px; border-radius: 20px; box-shadow: var(--shadow-sm);
}

.fb-book {
    width: 116px; cursor: pointer; flex-shrink: 0; position: relative;
    transition: transform .35s var(--ease-spring); text-decoration: none;
}
.fb-book:hover { transform: translateY(-18px) scale(1.05) rotate(-1.5deg); text-decoration: none; }
.fb-book-cover {
    width: 116px; height: 164px; border-radius: 2px 8px 8px 2px; overflow: hidden;
    box-shadow: -5px 6px 16px rgba(0,0,0,.45), inset -4px 0 10px rgba(0,0,0,.18);
    position: relative; background: var(--moss-dark);
}
.fb-book-cover::after {
    content: ''; position: absolute; top: 0; left: 13px; right: 0; bottom: 0;
    background: linear-gradient(90deg, rgba(255,255,255,.14) 0%, transparent 22%, transparent 78%, rgba(0,0,0,.1) 100%);
    pointer-events: none;
}
.fb-book-cover img { width: 100%; height: 100%; object-fit: cover; display: block; }
.fb-book-spine {
    position: absolute; left: 0; top: 0; bottom: 0; width: 13px;
    background: rgba(0,0,0,.28); border-right: 1px solid rgba(255,255,255,.1);
}
.fb-book-no-cover {
    display: flex; align-items: center; justify-content: center;
    width: 100%; height: 100%;
    background: linear-gradient(135deg, var(--moss-dark), var(--moss-mid));
    color: var(--white); font-size: 11px; font-weight: 800;
    text-align: center; padding: 10px; line-height: 1.4; text-shadow: 0 1px 4px rgba(0,0,0,.35);
}
.fb-book-overlay {
    position: absolute; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(48,98,56,0); transition: background .28s;
    display: flex; align-items: center; justify-content: center;
    border-radius: 2px 8px 8px 2px;
}
.fb-book:hover .fb-book-overlay { background: rgba(48,98,56,.6); backdrop-filter: blur(2px); }
.fb-book-overlay span {
    color: var(--white); font-size: 11.5px; font-weight: 800;
    opacity: 0; transition: opacity .25s; letter-spacing: .8px;
    text-transform: uppercase; text-shadow: 0 1px 6px rgba(0,0,0,.5);
}
.fb-book:hover .fb-book-overlay span { opacity: 1; }
.fb-book-title {
    font-size: 10.5px; color: #3a2410; font-weight: 700;
    text-align: center; margin-top: 8px; line-height: 1.35;
    max-height: 2.7em; overflow: hidden;
}

/* ── Empty state ── */
.fb-empty { text-align: center; padding: 80px 30px; }
.fb-empty-icon {
    width: 96px; height: 96px; border-radius: 50%; background: var(--moss-bg);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 24px; box-shadow: var(--shadow-sm);
}
.fb-empty-icon svg { width: 48px; height: 48px; fill: var(--moss-mid); }
.fb-empty h3 { color: var(--moss-dark); font-size: 22px; font-weight: 900; margin: 0 0 10px; }
.fb-empty p  { color: var(--text-muted); font-size: 14px; margin: 0 0 28px; }

/* ══════════════════════════════════════════════════════════════
   UNIFIED FLIPBOOK MODAL (identik dengan kiri.php)
══════════════════════════════════════════════════════════════ */
.ufb-overlay {
    display: none; position: fixed; inset: 0; z-index: 99999;
    background: rgba(4,12,6,.92); backdrop-filter: blur(10px);
    align-items: center; justify-content: center;
}
.ufb-overlay.active { display: flex; }

.ufb-modal {
    width: 100vw; height: 100vh;
    display: flex; flex-direction: column;
    background: #14201a;
    animation: ufbIn .32s var(--ease-out);
}
@keyframes ufbIn {
    from { opacity: 0; transform: scale(.96); }
    to   { opacity: 1; transform: scale(1); }
}
@media (min-width: 768px) {
    .ufb-modal {
        width: 94vw; height: 94vh; max-width: 1440px;
        border-radius: 12px; overflow: hidden;
        box-shadow: 0 30px 90px rgba(0,0,0,.75), 0 0 0 1px rgba(255,255,255,.06);
    }
}

.ufb-header {
    height: 54px; background: var(--moss-dark);
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 20px; flex-shrink: 0; gap: 12px;
}
.ufb-header h4 {
    margin: 0; font-size: 14px; font-weight: 700; color: #fff;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap; flex: 1;
}
.ufb-header-actions { display: flex; gap: 6px; align-items: center; flex-shrink: 0; }
.ufb-hbtn {
    width: 32px; height: 32px; border-radius: 7px;
    border: 1px solid rgba(255,255,255,.18); background: rgba(255,255,255,.1); cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: #fff; transition: background .18s, transform .18s var(--ease-spring);
}
.ufb-hbtn:hover { background: rgba(255,255,255,.26); transform: scale(1.08); }
.ufb-close {
    background: rgba(255,100,100,.15); border: 1px solid rgba(255,100,100,.25);
    color: rgba(255,255,255,.8); font-size: 18px; cursor: pointer;
    width: 32px; height: 32px; border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    transition: background .18s, color .18s;
}
.ufb-close:hover { background: rgba(255,80,80,.4); color: #fff; }

/* Canvas wrap — SCROLLABLE */
.ufb-canvas-wrap {
    flex: 1; overflow: auto; position: relative;
    background: #08120a; cursor: grab;
    display: flex; align-items: flex-start; justify-content: flex-start;
    scrollbar-width: none; -ms-overflow-style: none;
    -webkit-overflow-scrolling: touch;
}
.ufb-canvas-wrap::-webkit-scrollbar { display: none; }
.ufb-canvas-wrap.is-dragging { cursor: grabbing; }

.ufb-scene-outer {
    display: flex; align-items: center; justify-content: center;
    min-width: 100%; min-height: 100%; flex-shrink: 0;
    padding: 24px 80px; box-sizing: border-box;
}
@media (max-width: 767px) {
    .ufb-scene-outer { padding: 0; align-items: flex-start; justify-content: flex-start; }
}

.ufb-scene {
    position: relative; display: inline-flex;
    align-items: stretch; flex-shrink: 0;
    perspective: 2800px; perspective-origin: 50% 50%;
}

#ufbCanvasL { display: block; box-shadow: -6px 0 24px rgba(0,0,0,.6); border-radius: 3px 0 0 3px; }
#ufbCanvasR { display: none; box-shadow: 6px 0 24px rgba(0,0,0,.6); border-radius: 0 3px 3px 0; }

.ufb-spine {
    display: none; width: 7px; flex-shrink: 0;
    background: linear-gradient(180deg, #5a8a62 0%, #1f4428 50%, #5a8a62 100%);
    box-shadow: 3px 0 10px rgba(0,0,0,.55), -3px 0 10px rgba(0,0,0,.55);
}

.ufb-nav-arrow {
    position: absolute; top: 50%; transform: translateY(-50%);
    width: 44px; height: 44px; border-radius: 50%;
    background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.18);
    color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: background .2s, transform .2s var(--ease-spring); z-index: 10; pointer-events: all;
}
.ufb-nav-arrow:hover { background: rgba(255,255,255,.25); transform: translateY(-50%) scale(1.1); }
.ufb-nav-arrow.prev { left: 16px; }
.ufb-nav-arrow.next { right: 16px; }
@media (max-width: 600px) { .ufb-nav-arrow { display: none; } }

.ufb-loading {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    flex-direction: column; gap: 14px;
    background: #08120a; z-index: 5; color: var(--moss-light); font-size: 13px; font-weight: 600;
}
.ufb-loading-spinner {
    width: 36px; height: 36px; border-radius: 50%;
    border: 3px solid rgba(97,141,79,.25); border-top-color: var(--moss-mid);
    animation: ufbSpin .75s linear infinite;
}
@keyframes ufbSpin { to { transform: rotate(360deg); } }

.ufb-swipe-hint {
    position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);
    background: rgba(48,98,56,.75); color: #fff; font-size: 11px;
    padding: 6px 16px; border-radius: 20px; pointer-events: none;
    opacity: 0; transition: opacity .6s; white-space: nowrap;
}
.ufb-swipe-hint.show { opacity: 1; }

.ufb-flipper {
    position: absolute; transform-style: preserve-3d;
    display: none; z-index: 20; pointer-events: none; will-change: transform;
}
.ufb-flip-front, .ufb-flip-back {
    position: absolute; inset: 0; overflow: hidden;
    backface-visibility: hidden; -webkit-backface-visibility: hidden;
}
.ufb-flip-back { transform: rotateY(180deg); }
.ufb-flip-front canvas, .ufb-flip-back canvas { display: block; width: 100%; height: 100%; }

.ufb-flipper.is-next .ufb-flip-front::after {
    content: ''; position: absolute; inset: 0; pointer-events: none;
    background: linear-gradient(to left, rgba(0,0,0,.5) 0%, transparent 65%);
}
.ufb-flipper.is-next .ufb-flip-back::after {
    content: ''; position: absolute; inset: 0; pointer-events: none;
    background: linear-gradient(to right, rgba(0,0,0,.3) 0%, transparent 55%);
}
.ufb-flipper.is-prev .ufb-flip-front::after {
    content: ''; position: absolute; inset: 0; pointer-events: none;
    background: linear-gradient(to right, rgba(0,0,0,.5) 0%, transparent 65%);
}
.ufb-flipper.is-prev .ufb-flip-back::after {
    content: ''; position: absolute; inset: 0; pointer-events: none;
    background: linear-gradient(to left, rgba(0,0,0,.3) 0%, transparent 55%);
}

.ufb-toolbar {
    display: flex; align-items: center; justify-content: center;
    gap: 8px; padding: 10px 20px;
    background: #0e1a10; flex-shrink: 0;
    border-top: 1px solid rgba(255,255,255,.06);
    flex-wrap: wrap;
}
.ufb-tbtn {
    height: 34px; border-radius: 8px;
    background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.1);
    color: #ccc; cursor: pointer; padding: 0 14px;
    font-size: 12.5px; font-weight: 700; font-family: inherit;
    display: flex; align-items: center; gap: 6px;
    transition: background .18s, color .18s, transform .18s var(--ease-spring);
}
.ufb-tbtn:hover { background: rgba(255,255,255,.18); color: #fff; }
.ufb-tbtn:disabled { opacity: .3; cursor: default; }
.ufb-page-badge {
    background: rgba(97,141,79,.2); color: var(--moss-light);
    border: 1px solid rgba(97,141,79,.3);
    padding: 0 16px; height: 34px; border-radius: 20px;
    font-size: 12px; font-weight: 700;
    display: flex; align-items: center; min-width: 110px; justify-content: center;
    letter-spacing: .3px;
}
.ufb-vdiv { width: 1px; height: 22px; background: rgba(255,255,255,.1); margin: 0 2px; }

@media (max-width: 767px) {
    .ufb-toolbar {
        gap: 4px; padding: 7px 8px;
        display: grid; grid-template-columns: 1fr auto 1fr;
    }
    .ufb-page-badge { font-size: 11px; min-width: 0; }
    .ufb-tb-desktop { display: none !important; }
    .ufb-tb-zoom-mobile {
        grid-column: 1 / -1;
        display: flex !important; gap: 6px;
    }
    .ufb-tb-zoom-mobile .ufb-tbtn { flex: 1; justify-content: center; }
    #ufbSpine, #ufbCanvasR, #ufbFlipper { display: none !important; }
    #ufbCanvasL { width: 100% !important; box-shadow: none !important; border-radius: 0 !important; }
    .ufb-scene-outer { padding: 0; }
}

.ufb-thumbs {
    display: flex; gap: 8px; overflow-x: auto; padding: 10px 16px;
    background: #0a140c; border-top: 1px solid rgba(255,255,255,.05); flex-shrink: 0;
    scrollbar-width: thin; scrollbar-color: #3a5a3e transparent;
}
.ufb-thumbs::-webkit-scrollbar { height: 3px; }
.ufb-thumbs::-webkit-scrollbar-thumb { background: #3a5a3e; border-radius: 2px; }
@media (max-width: 767px) { .ufb-thumbs { display: none; } }

.ufb-thumb {
    flex-shrink: 0; width: 48px; height: 68px; border-radius: 4px;
    background: #1e2e22; cursor: pointer; overflow: hidden;
    border: 2px solid transparent; transition: border-color .2s, transform .2s var(--ease-spring);
    position: relative;
}
.ufb-thumb:hover { transform: scale(1.08); border-color: rgba(97,141,79,.5); }
.ufb-thumb.active { border-color: var(--moss-mid); }
.ufb-thumb canvas { width: 100%; height: 100%; display: block; }
.ufb-thumb-n {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: rgba(0,0,0,.68); color: #aaa;
    font-size: 8.5px; text-align: center; padding: 2px 0;
}

/* ── Info section bawah ── */
.fb-info-section {
    background: var(--moss-bg); padding: 48px 0; text-align: center;
    border-top: 2px solid rgba(97,141,79,.15);
}
.fb-info-label {
    display: block; color: var(--moss-mid); font-size: 10.5px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 3px; margin-bottom: 10px;
}
.fb-info-section h2 { color: var(--moss-dark); font-size: 22px; font-weight: 900; margin: 0 0 12px; }
.fb-info-section p { color: var(--text-muted); font-size: 14px; max-width: 480px; margin: 0 auto 24px; line-height: 1.8; }
.fb-back-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--moss-dark); color: #fff; padding: 12px 30px;
    border-radius: 30px; font-weight: 800; font-size: 14px;
    text-decoration: none; box-shadow: 0 4px 20px rgba(48,98,56,.3);
    transition: background .25s, transform .25s var(--ease-spring);
}
.fb-back-btn:hover { background: var(--moss-mid); color: #fff; text-decoration: none; transform: translateY(-2px); }
</style>

<!-- ═══════════════════════════════════
     HERO
═══════════════════════════════════ -->
<div class="fb-hero">
    <div class="container">
        <div class="fb-hero-inner">
            <span class="fb-hero-label">Referensi Pedoman</span>
            <h1>E-Book &amp; Flipbook<br>MBKM IAI PI Bandung</h1>
            <div class="fb-hero-divider"></div>
            <p>Kumpulan buku pedoman dan panduan pelaksanaan program MBKM yang dapat dibaca langsung di browser.</p>
            <?php if ($is_admin): ?>
            <a href="admin.php?pilih=flipbook&modul=yes" class="fb-admin-btn">
                <svg viewBox="0 0 24 24" style="width:17px;height:17px;fill:var(--moss-dark)"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                Tambah / Kelola Buku
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$all_books = [];
$q = $koneksi_db->sql_query("SELECT * FROM mod_data_flipbook WHERE status='1' ORDER BY ordering ASC, id DESC");
while ($bk = $koneksi_db->sql_fetchrow($q)) $all_books[] = $bk;
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
            <button class="fb-filter-btn active" onclick="fbFilter('all',this)">&#128218; Semua</button>
            <?php foreach ($all_cats as $cat): ?>
            <button class="fb-filter-btn" onclick="fbFilter('<?= htmlspecialchars(addslashes($cat)) ?>',this)">
                <?= htmlspecialchars($cat) ?>
            </button>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- UNIFIED FLIPBOOK MODAL -->
<div class="ufb-overlay" id="ufbOverlay">
<div class="ufb-modal">
    <div class="ufb-header">
        <h4 id="ufbTitle">Dokumen</h4>
        <div class="ufb-header-actions">
            <button class="ufb-hbtn ufb-tb-desktop" onclick="ufbZoom(.2)" title="Zoom In">
                <svg width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M15.5 14h-.79l-.28-.27A6.5 6.5 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99 1.49-1.49-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14zm.5-7H9v2H7v1h2v2h1v-2h2V9h-2V7z"/></svg>
            </button>
            <button class="ufb-hbtn ufb-tb-desktop" onclick="ufbZoom(-.2)" title="Zoom Out">
                <svg width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M15.5 14h-.79l-.28-.27A6.5 6.5 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99 1.49-1.49-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14zM7 9h5v1H7z"/></svg>
            </button>
            <button class="ufb-hbtn ufb-tb-desktop" onclick="ufbFullscreen()" title="Fullscreen">
                <svg width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/></svg>
            </button>
            <a id="ufbDlLink" href="#" target="_blank" class="ufb-hbtn" title="Download PDF" style="text-decoration:none;">
                <svg width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
            </a>
            <button class="ufb-close" onclick="ufbClose()">&#x2715;</button>
        </div>
    </div>

    <div class="ufb-canvas-wrap" id="ufbWrap">
        <button class="ufb-nav-arrow prev" onclick="ufbNav(-1)">
            <svg width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
        </button>
        <button class="ufb-nav-arrow next" onclick="ufbNav(1)">
            <svg width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
        </button>

        <div class="ufb-loading" id="ufbLoading">
            <div class="ufb-loading-spinner"></div>
            <span>Memuat dokumen...</span>
        </div>

        <div class="ufb-scene-outer" id="ufbSceneOuter" style="display:none;">
            <div class="ufb-scene" id="ufbScene">
                <canvas id="ufbCanvasL"></canvas>
                <div id="ufbSpine" class="ufb-spine"></div>
                <canvas id="ufbCanvasR"></canvas>
                <div class="ufb-flipper" id="ufbFlipper">
                    <div class="ufb-flip-front"><canvas id="ufbFlipFront"></canvas></div>
                    <div class="ufb-flip-back" ><canvas id="ufbFlipBack"></canvas></div>
                </div>
            </div>
        </div>
        <div class="ufb-swipe-hint" id="ufbSwipeHint">&#8592; geser untuk pindah halaman &#8594;</div>
    </div>

    <div class="ufb-toolbar">
        <button class="ufb-tbtn" id="ufbBtnPrev" onclick="ufbNav(-1)">&#9664; Prev</button>

        <div class="ufb-tb-desktop" style="display:flex;gap:8px;align-items:center;">
            <div class="ufb-vdiv"></div>
            <button class="ufb-tbtn" onclick="ufbZoom(.15)">&#43;</button>
            <button class="ufb-tbtn" onclick="ufbZoom(-.15)">&#8722;</button>
            <button class="ufb-tbtn" onclick="ufbZoomReset()">&#8635;</button>
            <div class="ufb-vdiv"></div>
        </div>

        <span class="ufb-page-badge" id="ufbPageBadge">Cover</span>

        <div class="ufb-tb-desktop" style="display:flex;gap:8px;align-items:center;">
            <div class="ufb-vdiv"></div>
            <input type="number" id="ufbPageInput" min="1" value="1"
                style="width:46px;height:32px;border-radius:7px;border:1px solid rgba(255,255,255,.18);background:rgba(255,255,255,.08);color:#ddd;text-align:center;font-size:12px;outline:none;"
                onkeydown="if(event.key==='Enter')ufbGo(this.value)">
            <button class="ufb-tbtn" onclick="ufbGo(document.getElementById('ufbPageInput').value)">Go</button>
        </div>

        <button class="ufb-tbtn" id="ufbBtnNext" onclick="ufbNav(1)">Next &#9654;</button>

        <div class="ufb-tb-zoom-mobile" style="display:none;">
            <button class="ufb-tbtn" onclick="ufbZoom(.15)" style="flex:1;">&#43; Zoom</button>
            <button class="ufb-tbtn" onclick="ufbZoom(-.15)" style="flex:1;">&#8722; Zoom</button>
        </div>
    </div>

    <div class="ufb-thumbs" id="ufbThumbs"></div>
</div>
</div>

<!-- ═══════════════════════════════════
     BOOKSHELF
═══════════════════════════════════ -->
<section class="fb-shelf-section">
    <div class="container">
        <div class="fb-search-bar">
            <input type="text" id="fbSearchInput" placeholder="Cari buku pedoman..." oninput="fbSearch()">
            <button type="button" onclick="fbSearch()">
                <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
            </button>
        </div>

        <?php if (empty($all_books)): ?>
        <div class="fb-empty">
            <div class="fb-empty-icon">
                <svg viewBox="0 0 24 24"><path d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1zM21 18.5c-1.1-.35-2.3-.5-3.5-.5-1.7 0-4.15.65-5.5 1.5V8c1.35-.85 3.8-1.5 5.5-1.5 1.2 0 2.4.15 3.5.5v11.5z"/></svg>
            </div>
            <h3>Belum Ada Buku</h3>
            <p>Koleksi e-book pedoman MBKM belum tersedia saat ini.</p>
            <?php if ($is_admin): ?>
            <a href="admin.php?pilih=flipbook&modul=yes&aksi=tambah" class="fb-back-btn">
                <svg viewBox="0 0 24 24" style="width:17px;height:17px;fill:#fff"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
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
                foreach (array_chunk($cat_books, $per_row) as $ci => $row_books): ?>
                <div class="fb-shelf-row" data-cat="<?= htmlspecialchars($cat) ?>">
                    <?php if ($ci === 0): ?><span class="fb-shelf-label"><?= htmlspecialchars($cat) ?></span><?php endif; ?>
                    <?php foreach ($row_books as $bk):
                        $cs = !empty($bk['cover']) ? 'images/flipbook/'.htmlspecialchars($bk['cover']) : '';
                        $jd = htmlspecialchars($bk['judul']);
                        $pf = htmlspecialchars($bk['file_pdf']); ?>
                    <div class="fb-book" onclick="openFlipbook('<?= $pf ?>','<?= addslashes($jd) ?>')" data-cat="<?= htmlspecialchars($cat) ?>">
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
        <?php   endforeach; }
            /* No-category books */
            $no_cat = array_values(array_filter($all_books, function($b) { return empty(trim($b['kategori'])); }));
            if (!empty($no_cat)) {
                foreach (array_chunk($no_cat, $per_row) as $row_books): ?>
                <div class="fb-shelf-row" data-cat="all">
                    <span class="fb-shelf-label">Lainnya</span>
                    <?php foreach ($row_books as $bk):
                        $cs = !empty($bk['cover']) ? 'images/flipbook/'.htmlspecialchars($bk['cover']) : '';
                        $jd = htmlspecialchars($bk['judul']);
                        $pf = htmlspecialchars($bk['file_pdf']); ?>
                    <div class="fb-book" onclick="openFlipbook('<?= $pf ?>','<?= addslashes($jd) ?>')" data-cat="">
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
        <?php   endforeach; }
        } else {
            foreach (array_chunk($all_books, $per_row) as $row_books): ?>
            <div class="fb-shelf-row">
                <?php foreach ($row_books as $bk):
                    $cs = !empty($bk['cover']) ? 'images/flipbook/'.htmlspecialchars($bk['cover']) : '';
                    $jd = htmlspecialchars($bk['judul']);
                    $pf = htmlspecialchars($bk['file_pdf']); ?>
                <div class="fb-book" onclick="openFlipbook('<?= $pf ?>','<?= addslashes($jd) ?>')">
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
        <?php   endforeach; }
        ?>

        <?php if ($is_admin): ?>
        <div style="text-align:center;margin-top:24px;">
            <a href="admin.php?pilih=flipbook&modul=yes" class="fb-admin-btn" style="display:inline-flex;">
                <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:var(--moss-dark)"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                Kelola Koleksi Buku
            </a>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<!-- Info bottom -->
<section class="fb-info-section">
    <div class="container">
        <span class="fb-info-label">Informasi</span>
        <h2>Butuh Bantuan atau Informasi Lebih?</h2>
        <p>Hubungi tim MBKM IAI PI Bandung untuk informasi lebih lanjut mengenai program dan pedoman pelaksanaan.</p>
        <a href="index.php" class="fb-back-btn">
            <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:#fff"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
            Kembali ke Beranda
        </a>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
pdfjsLib.GlobalWorkerOptions.workerSrc =
    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

/* ══════════════════════════════════════════
   UNIFIED FLIPBOOK ENGINE (sama dengan kiri.php)
══════════════════════════════════════════ */
var _pdf = null, _page = 1, _total = 0;
var _busy = false, _scale = 1.3, _zoom = 1.0;
var _thumbsBuilt = false;
var FLIP_MS = 620;

var _cache = {};
function _el(id) { return _cache[id] || (_cache[id] = document.getElementById(id)); }
function _isMobile() { return window.innerWidth <= 767; }

function _calcScale() {
    var wrap = _el('ufbWrap');
    var w = wrap.clientWidth - (_isMobile() ? 0 : 120);
    var h = wrap.clientHeight - 40;
    if (!_pdf) return Promise.resolve(_isMobile() ? 1.0 : 1.3);
    return _pdf.getPage(1).then(function(pg) {
        var vp = pg.getViewport({ scale: 1 });
        var maxW = _isMobile() ? w : Math.floor((w - 7) / 2);
        return Math.max(.3, Math.min(3.5, Math.min(maxW / vp.width, h / vp.height)));
    });
}

function _rnd(num, cvs) {
    if (!_pdf || num < 1 || num > _total) {
        cvs.width = 0; cvs.height = 0; cvs.style.display = 'none';
        return Promise.resolve(null);
    }
    var dpr = Math.min(window.devicePixelRatio || 1, 2);
    var s   = _scale * _zoom;
    return _pdf.getPage(num).then(function(pg) {
        var vp = pg.getViewport({ scale: s * dpr });
        cvs.width  = vp.width; cvs.height = vp.height;
        cvs.style.width  = Math.round(vp.width  / dpr) + 'px';
        cvs.style.height = Math.round(vp.height / dpr) + 'px';
        cvs.style.display = 'block';
        return pg.render({ canvasContext: cvs.getContext('2d'), viewport: vp }).promise
            .then(function() { return cvs; });
    });
}

function _copy(src, dst) {
    if (!src || !src.width) return;
    dst.width = src.width; dst.height = src.height;
    dst.style.width = src.style.width; dst.style.height = src.style.height;
    dst.style.display = 'block';
    dst.getContext('2d').drawImage(src, 0, 0);
}

function _snap(p) {
    if (_isMobile()) return Math.max(1, Math.min(_total, p));
    var s = (p % 2 === 0) ? p - 1 : p;
    return Math.max(1, Math.min(_total, s));
}

function _ui(p) {
    var mob  = _isMobile();
    var hasR = !mob && p + 1 <= _total;

    _el('ufbSpine').style.display = hasR ? 'block' : 'none';
    var cR = _el('ufbCanvasR');
    if (!hasR) { cR.style.display = 'none'; cR.width = 0; }

    var label = (p === 1 && _total <= 1)
        ? 'Cover'
        : 'Hal ' + p + (hasR ? '\u2013' + (p + 1) : '') + ' / ' + _total;
    _el('ufbPageBadge').textContent = label;

    var inp = _el('ufbPageInput');
    if (inp) inp.value = p;

    _el('ufbBtnPrev').disabled = (p <= 1);
    _el('ufbBtnNext').disabled = mob ? (p >= _total) : (p + 1 >= _total);

    var mzr = document.querySelector('.ufb-tb-zoom-mobile');
    if (mzr) mzr.style.display = mob ? 'flex' : 'none';

    _updateThumb(p);
}

function _centerScene() {
    var wrap = _el('ufbWrap');
    var so   = _el('ufbSceneOuter');
    if (!so || !wrap) return;
    wrap.scrollLeft = Math.max(0, (so.scrollWidth  - wrap.clientWidth)  / 2);
    wrap.scrollTop  = Math.max(0, (so.scrollHeight - wrap.clientHeight) / 2);
}

function _direct(p, cb) {
    var mob = _isMobile();
    var cL  = _el('ufbCanvasL');
    var cR  = _el('ufbCanvasR');
    var tasks = [_rnd(p, cL)];
    if (!mob && p + 1 <= _total) tasks.push(_rnd(p + 1, cR));
    else { cR.style.display = 'none'; cR.width = 0; }
    Promise.all(tasks).then(function() {
        _ui(p); _busy = false; _centerScene();
        if (cb) cb();
    }).catch(function() { _busy = false; });
}

function _flip(p, dir) {
    if (_isMobile()) { _direct(p); return; }
    var cL  = _el('ufbCanvasL'), cR  = _el('ufbCanvasR');
    var fpr = _el('ufbFlipper'), ffr = _el('ufbFlipFront'), fbk = _el('ufbFlipBack');
    fpr.className = 'ufb-flipper';

    if (dir === 'next') {
        if (!cR.offsetWidth) { _busy = false; _direct(p); return; }
        _copy(cR, ffr);
        fpr.style.cssText = [
            'display:block','width:'+cR.offsetWidth+'px','height:'+cR.offsetHeight+'px',
            'left:'+cR.offsetLeft+'px','top:'+cR.offsetTop+'px',
            'transform-origin:0% 50%','transform:rotateY(0deg)',
            'transition:none','z-index:20','pointer-events:none'
        ].join(';');
        fpr.classList.add('is-next'); cR.style.visibility = 'hidden';
        Promise.all([_rnd(p, fbk), _rnd(p + 1, cR)]).then(function() {
            fbk.style.width = ffr.style.width; fbk.style.height = ffr.style.height;
            requestAnimationFrame(function() { requestAnimationFrame(function() {
                fpr.style.transition = 'transform '+FLIP_MS+'ms cubic-bezier(.77,0,.18,1)';
                fpr.style.transform  = 'rotateY(-180deg)';
            }); });
            setTimeout(function() {
                fpr.style.transition='none'; fpr.style.display='none';
                fpr.className='ufb-flipper'; cR.style.visibility='visible'; _direct(p);
            }, FLIP_MS + 60);
        }).catch(function() { fpr.style.display='none'; cR.style.visibility='visible'; _busy=false; });
    } else {
        if (!cL.offsetWidth) { _busy = false; _direct(p); return; }
        _copy(cL, ffr);
        fpr.style.cssText = [
            'display:block','width:'+cL.offsetWidth+'px','height:'+cL.offsetHeight+'px',
            'left:'+cL.offsetLeft+'px','top:'+cL.offsetTop+'px',
            'transform-origin:100% 50%','transform:rotateY(0deg)',
            'transition:none','z-index:20','pointer-events:none'
        ].join(';');
        fpr.classList.add('is-prev'); cL.style.visibility = 'hidden';
        Promise.all([_rnd(p + 1, fbk), _rnd(p, cL)]).then(function() {
            fbk.style.width = ffr.style.width; fbk.style.height = ffr.style.height;
            requestAnimationFrame(function() { requestAnimationFrame(function() {
                fpr.style.transition = 'transform '+FLIP_MS+'ms cubic-bezier(.77,0,.18,1)';
                fpr.style.transform  = 'rotateY(180deg)';
            }); });
            setTimeout(function() {
                fpr.style.transition='none'; fpr.style.display='none';
                fpr.className='ufb-flipper'; cL.style.visibility='visible'; _direct(p);
            }, FLIP_MS + 60);
        }).catch(function() { fpr.style.display='none'; cL.style.visibility='visible'; _busy=false; });
    }
}

function ufbNav(dir) {
    if (!_pdf || _busy) return;
    var mob = _isMobile();
    var step = mob ? 1 : 2;
    var newP = _snap(_page + dir * step);
    if (newP === _page) {
        newP = Math.max(1, Math.min(_total, _page + dir));
        if (newP === _page) return;
    }
    _busy = true; _page = newP;
    _isMobile() ? _direct(_page) : _flip(_page, dir > 0 ? 'next' : 'prev');
}

function ufbGo(n) {
    n = parseInt(n, 10);
    if (isNaN(n) || n < 1 || n > _total) return;
    var np = _snap(n);
    if (np === _page) return;
    var dir = np > _page ? 1 : -1;
    _busy = true; _page = np;
    _isMobile() ? _direct(_page) : _flip(_page, dir > 0 ? 'next' : 'prev');
}

function ufbZoom(d) {
    if (!_pdf) return;
    _zoom = Math.max(.35, Math.min(3.5, _zoom + d));
    _busy = false; _direct(_page);
}
function ufbZoomReset() {
    if (!_pdf) return; _zoom = 1.0;
    _calcScale().then(function(s) { _scale = s; _busy = false; _direct(_page); });
}
function ufbFullscreen() {
    var e = _el('ufbOverlay');
    if (!document.fullscreenElement) (e.requestFullscreen || e.webkitRequestFullscreen || function(){}).call(e);
    else (document.exitFullscreen || document.webkitExitFullscreen || function(){}).call(document);
}

function _buildThumbs() {
    if (_thumbsBuilt || !_pdf) return; _thumbsBuilt = true;
    var strip = _el('ufbThumbs'); strip.innerHTML = '';
    for (var i = 1; i <= _total; i++) {
        (function(pn) {
            var th = document.createElement('div'); th.className = 'ufb-thumb' + (pn===1?' active':''); th.dataset.page = pn;
            var tc = document.createElement('canvas'); th.appendChild(tc);
            var nn = document.createElement('div'); nn.className = 'ufb-thumb-n'; nn.textContent = pn; th.appendChild(nn);
            th.onclick = function() { ufbGo(pn); };
            strip.appendChild(th);
            _pdf.getPage(pn).then(function(pg) {
                var vp0 = pg.getViewport({ scale: 1 });
                var sc  = Math.min(48 / vp0.width, 68 / vp0.height);
                var vp  = pg.getViewport({ scale: sc });
                tc.width = vp.width; tc.height = vp.height;
                pg.render({ canvasContext: tc.getContext('2d'), viewport: vp }).promise;
            });
        })(i);
    }
}
function _updateThumb(p) {
    document.querySelectorAll('.ufb-thumb').forEach(function(t) {
        var tp = parseInt(t.dataset.page, 10);
        var a = _isMobile() ? (tp===p) : (tp===p || tp===p+1);
        t.classList.toggle('active', a);
        if (a) t.scrollIntoView({ behavior:'smooth', inline:'center', block:'nearest' });
    });
}

function _showSwipeHint() {
    var h = _el('ufbSwipeHint'); h.classList.add('show');
    setTimeout(function() { h.style.transition='opacity 1s'; h.style.opacity='0'; }, 2400);
    setTimeout(function() { h.classList.remove('show'); h.style.opacity=''; h.style.transition=''; }, 3600);
}

function openFlipbook(url, title) {
    _el('ufbTitle').textContent  = title || 'Dokumen';
    _el('ufbDlLink').href        = url;
    _el('ufbOverlay').classList.add('active');
    document.body.style.overflow = 'hidden';

    _pdf = null; _total = 0; _page = 1; _busy = false; _zoom = 1.0; _thumbsBuilt = false;
    ['ufbCanvasL','ufbCanvasR','ufbFlipFront','ufbFlipBack'].forEach(function(id) {
        var c = _el(id); c.width = 0; c.height = 0; c.style.display = 'none';
    });
    _el('ufbFlipper').style.display = 'none'; _el('ufbFlipper').className = 'ufb-flipper';
    _el('ufbSpine').style.display = 'none'; _el('ufbThumbs').innerHTML = '';
    _el('ufbPageBadge').textContent = 'Memuat...';
    _el('ufbLoading').style.display = 'flex';
    _el('ufbSceneOuter').style.display = 'none';

    pdfjsLib.getDocument(url).promise.then(function(pdf) {
        _pdf = pdf; _total = pdf.numPages;
        return _calcScale();
    }).then(function(s) {
        _scale = s;
        _el('ufbLoading').style.display = 'none';
        _el('ufbSceneOuter').style.display = 'flex';
        _direct(1, function() { _buildThumbs(); if (_isMobile()) _showSwipeHint(); });
    }).catch(function(err) {
        _el('ufbLoading').innerHTML = '&#9888; Gagal memuat: ' + (err.message || err);
        _busy = false;
    });
}

function ufbClose() {
    _el('ufbOverlay').classList.remove('active');
    document.body.style.overflow = '';
    ['ufbCanvasL','ufbCanvasR','ufbFlipFront','ufbFlipBack'].forEach(function(id) {
        var c = _el(id); c.width = 0; c.height = 0; c.style.display = 'none';
    });
    _el('ufbFlipper').style.display = 'none'; _el('ufbFlipper').className = 'ufb-flipper';
    _el('ufbSpine').style.display = 'none';
    _pdf = null; _busy = false; _page = 1; _thumbsBuilt = false;
}

document.addEventListener('keydown', function(e) {
    if (!_el('ufbOverlay').classList.contains('active')) return;
    if (e.key==='ArrowRight') ufbNav(1);
    if (e.key==='ArrowLeft')  ufbNav(-1);
    if (e.key==='Escape')     ufbClose();
    if (e.key==='+'||e.key==='=') ufbZoom(.15);
    if (e.key==='-') ufbZoom(-.15);
    if (e.key==='0') ufbZoomReset();
});
_el('ufbOverlay').addEventListener('click', function(e) { if (e.target===this) ufbClose(); });

/* ── DRAG-TO-PAN + MOMENTUM ── */
(function() {
    var wrap = _el('ufbWrap');
    var down = false, lx, ly, vx = 0, vy = 0, raf = null;
    var F = 0.88;
    function cancel() { if (raf) { cancelAnimationFrame(raf); raf = null; } }
    function mom() {
        vx *= F; vy *= F;
        wrap.scrollLeft -= vx; wrap.scrollTop -= vy;
        if (Math.abs(vx) > .4 || Math.abs(vy) > .4) raf = requestAnimationFrame(mom);
        else raf = null;
    }
    wrap.addEventListener('mousedown', function(e) {
        if (_isMobile()) return;
        if (e.target.tagName==='BUTTON'||e.target.tagName==='A'||e.target.tagName==='INPUT') return;
        cancel(); down = true; vx = 0; vy = 0;
        lx = e.clientX; ly = e.clientY;
        wrap.classList.add('is-dragging'); e.preventDefault();
    }, { passive: false });
    document.addEventListener('mousemove', function(e) {
        if (!down || _isMobile()) return;
        var dx = e.clientX - lx, dy = e.clientY - ly;
        vx = vx*.35 + dx*.65; vy = vy*.35 + dy*.65;
        wrap.scrollLeft -= dx; wrap.scrollTop -= dy;
        lx = e.clientX; ly = e.clientY;
    });
    document.addEventListener('mouseup', function() {
        if (!down) return; down = false; wrap.classList.remove('is-dragging');
        if (Math.abs(vx) > 1.2 || Math.abs(vy) > 1.2) raf = requestAnimationFrame(mom);
    });
    wrap.addEventListener('wheel', function(e) {
        if (!_pdf) return; e.preventDefault(); cancel();
        var old = _zoom;
        _zoom = Math.max(.35, Math.min(3.5, _zoom + (e.deltaY < 0 ? .1 : -.1)));
        if (_zoom === old) return;
        var wr = wrap.getBoundingClientRect();
        var cx = e.clientX - wr.left + wrap.scrollLeft;
        var cy = e.clientY - wr.top  + wrap.scrollTop;
        var ratio = _zoom / old;
        _busy = false;
        _direct(_page, function() {
            wrap.scrollLeft = Math.round(cx * ratio - (e.clientX - wr.left));
            wrap.scrollTop  = Math.round(cy * ratio - (e.clientY - wr.top));
        });
    }, { passive: false });
})();

/* ── SWIPE (mobile) ── */
(function() {
    var wrap = _el('ufbWrap');
    var sx, sy, axis, deciding;
    wrap.addEventListener('touchstart', function(e) {
        if (e.touches.length!==1) return;
        sx = e.touches[0].clientX; sy = e.touches[0].clientY;
        deciding = true; axis = null;
    }, { passive: true });
    wrap.addEventListener('touchmove', function(e) {
        if (!deciding && axis!=='h') return;
        var dx = e.touches[0].clientX - sx, dy = e.touches[0].clientY - sy;
        if (deciding && (Math.abs(dx)>8||Math.abs(dy)>8)) {
            axis = Math.abs(dx) > Math.abs(dy) ? 'h' : 'v'; deciding = false;
        }
        if (axis==='h') e.preventDefault();
    }, { passive: false });
    wrap.addEventListener('touchend', function(e) {
        if (!_isMobile()||axis!=='h') return;
        var dx = e.changedTouches[0].clientX - sx;
        if (Math.abs(dx) > 42) ufbNav(dx < 0 ? 1 : -1);
    }, { passive: true });
})();

/* ── RESIZE ── */
(function() {
    var t;
    window.addEventListener('resize', function() {
        clearTimeout(t);
        t = setTimeout(function() {
            if (!_pdf || !_el('ufbOverlay').classList.contains('active')) return;
            _calcScale().then(function(s) { _scale = s; _busy = false; _direct(_page); });
        }, 280);
    });
})();

/* ── CATEGORY FILTER ── */
function fbFilter(cat, btn) {
    document.querySelectorAll('.fb-filter-btn').forEach(function(b) { b.classList.remove('active'); });
    btn.classList.add('active');
    document.querySelectorAll('.fb-shelf-row').forEach(function(row) {
        row.style.display = (cat === 'all' || row.dataset.cat === cat) ? 'flex' : 'none';
    });
}

/* ── SEARCH ── */
function fbSearch() {
    var q = document.getElementById('fbSearchInput').value.toLowerCase().trim();
    document.querySelectorAll('.fb-book').forEach(function(b) {
        var t = b.querySelector('.fb-book-title');
        b.style.display = (!q || (t && t.textContent.toLowerCase().indexOf(q) !== -1)) ? '' : 'none';
    });
}
</script>