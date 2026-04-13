<?php global $koneksi_db; ?>

<!-- Tailwind CSS CDN (Play) — prefixed tw- to avoid conflicts -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
    prefix: 'tw-',
    corePlugins: { preflight: false },
    theme: {
        extend: {
            colors: {
                moss: { dark: '#306238', mid: '#618D4F', light: '#9EBB97', bg: '#DDE5CD', olive: '#545837' }
            }
        }
    }
}
</script>

<style>
/* ============================================================
   LANDING PAGE MBKM IAI PI BANDUNG
   Color Palette:
   --moss-dark    : #306238  (Deep Moss Green)
   --moss-mid     : #618D4F  (Middle Green)
   --moss-light   : #9EBB97  (Laurel Green)
   --moss-bg      : #DDE5CD  (Dirty White)
   --moss-olive   : #545837  (Olive Drab Camouflage)
   ============================================================ */
@import url('https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap');

a.scroll-top, .scroll-top {
    background: #618D4F !important; border-color: #618D4F !important;
    color: #fff !important; box-shadow: 0 4px 16px rgba(97,141,79,.35) !important;
}
a.scroll-top:hover, .scroll-top:hover { background: #306238 !important; border-color: #306238 !important; }

.blog-wrapper { background: transparent !important; padding: 0 !important; margin: 0 !important; }
.blog-left, .blog-right { display: none !important; }
.section-eyebrow { color: #618D4F !important; }
.dokum-dot.active { background: #306238 !important; }
body { background: #fff; }

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

* { box-sizing: border-box; }
body, section, div { font-family: 'Inter', sans-serif; }

.lp-label {
    display: block; color: var(--moss-mid);
    font-size: 12px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 3px; margin-bottom: 12px;
}
.lp-title {
    color: var(--moss-dark); font-size: 34px; font-weight: 800;
    line-height: 1.15; margin: 0 0 24px; letter-spacing: -.5px;
}
.lp-title--lg { font-size: 42px; }
.lp-divider {
    width: 56px; height: 3.5px;
    background: linear-gradient(90deg, var(--moss-dark), var(--moss-mid));
    border-radius: 3px; margin-bottom: 36px;
}
.lp-section { padding: 80px 0; }

/* ── SECTION 1: PROGRAM CARDS ── */
.prog-section { background: var(--white); padding: 0 0 30px; }
.prog-section-head { text-align: center; padding: 72px 0 50px; }

.prog-card {
    background: var(--moss-dark); border-radius: var(--radius-lg);
    padding: 32px 26px 28px; position: relative; cursor: pointer;
    transition: var(--transition); overflow: hidden; min-height: 220px;
    height: 100%; border-top: 4px solid var(--moss-mid);
}
.prog-card::after {
    content: ''; position: absolute; bottom: -20px; right: -20px;
    width: 120px; height: 120px; background: rgba(255,255,255,.05); border-radius: 50%;
}
.prog-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-lg); background: var(--moss-mid); }
.prog-card--alt  { background: var(--moss-olive); }
.prog-card--alt2 { background: var(--moss-mid); }
.prog-card--alt3 { background: #3d5a2e; }

.prog-card .pc-icon {
    width: 52px; height: 52px; background: rgba(255,255,255,.15);
    border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;
}
.prog-card .pc-icon svg { width: 26px; height: 26px; fill: #fff; }
.prog-card h3 {
    color: var(--white); font-size: 15px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .5px; margin: 0 0 12px; line-height: 1.45;
}
.prog-card p { color: rgba(255,255,255,.80); font-size: 13px; line-height: 1.8; margin: 0; }
.prog-card .pc-btn {
    position: absolute; bottom: 16px; right: 16px; width: 40px; height: 40px;
    border-radius: 50%; background: rgba(255,255,255,.18);
    display: flex; align-items: center; justify-content: center;
    text-decoration: none; transition: var(--transition); z-index: 2;
}
.prog-card .pc-btn svg { width: 16px; height: 16px; fill: #fff; }
.prog-card .pc-btn:hover { background: rgba(255,255,255,.35); transform: scale(1.12); text-decoration: none; }

/* ── SECTION 2: SAMBUTAN ── */
.sambutan-section { background: var(--moss-bg); padding: 80px 0; border-top: 1px solid rgba(97,141,79,.15); }
.sambutan-media {
    border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg);
    position: relative; background: var(--moss-dark); min-height: 360px;
    display: flex; align-items: center; justify-content: center;
}
.sambutan-media-placeholder {
    display: flex; flex-direction: column;
    align-items: center; justify-content: center; min-height: 360px; padding: 40px;
}
.sambutan-media-placeholder p { color: rgba(255,255,255,.5); margin: 12px 0 0; font-size: 13px; text-align: center; }
.play-icon-wrap {
    width: 72px; height: 72px; border-radius: 50%; background: rgba(255,255,255,.92);
    display: flex; align-items: center; justify-content: center;
    position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
    text-decoration: none; transition: var(--transition); box-shadow: 0 8px 28px rgba(0,0,0,.25); backdrop-filter: blur(4px);
}
.play-icon-wrap:hover { transform: translate(-50%,-50%) scale(1.12); box-shadow: 0 12px 40px rgba(0,0,0,.35); }
.play-icon-wrap svg { width: 28px; height: 28px; fill: var(--moss-dark); margin-left: 4px; }
.sambutan-text { padding-left: 48px; }
@media (max-width: 767px) { .sambutan-text { padding-left: 0; margin-top: 30px; } }
.sambutan-text .lp-title { font-size: 28px; }
.sambutan-text p { color: var(--text-muted); line-height: 1.9; font-size: 15px; }
.btn-primary-lp {
    display: inline-block; background: var(--moss-dark); color: var(--white);
    padding: 12px 30px; border-radius: 30px; font-weight: 600; font-size: 14px;
    text-decoration: none; letter-spacing: .2px; transition: var(--transition);
    margin-top: 24px; border: 2px solid var(--moss-dark);
}
.btn-primary-lp:hover { background: var(--moss-mid); border-color: var(--moss-mid); color: var(--white); text-decoration: none; box-shadow: var(--shadow-md); }
.btn-outline-lp {
    display: inline-block; border: 2px solid var(--moss-dark); color: var(--moss-dark);
    padding: 11px 28px; border-radius: 30px; font-weight: 600; font-size: 14px;
    text-decoration: none; transition: var(--transition); margin-top: 28px;
}
.btn-outline-lp:hover { background: var(--moss-dark); color: var(--white); text-decoration: none; }

/* ── SECTION 3: STATISTIK ── */
.stats-section {
    background: linear-gradient(135deg, var(--moss-dark) 0%, var(--moss-olive) 100%);
    padding: 64px 0; position: relative; overflow: hidden;
}
.stats-section::before {
    content: ''; position: absolute; top: -60px; right: -60px;
    width: 260px; height: 260px; border-radius: 50%; background: rgba(255,255,255,.04);
}
.stats-section::after {
    content: ''; position: absolute; bottom: -80px; left: -40px;
    width: 320px; height: 320px; border-radius: 50%; background: rgba(255,255,255,.035);
}
.stat-item { text-align: center; padding: 30px 20px; position: relative; z-index: 1; }
.stat-item + .stat-item { border-left: 1px solid rgba(255,255,255,.12); }
@media (max-width: 575px) { .stat-item + .stat-item { border-left: none; border-top: 1px solid rgba(255,255,255,.12); } }
.stat-num { font-size: 56px; font-weight: 900; color: var(--moss-bg); display: block; line-height: 1; letter-spacing: -1px; }
.stat-label { color: rgba(255,255,255,.75); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; margin-top: 8px; display: block; }
.stat-line { width: 28px; height: 2px; background: var(--moss-light); margin: 10px auto 0; border-radius: 1px; opacity: .7; }
.stat-icon-wrap {
    width: 46px; height: 46px; border-radius: 50%;
    background: rgba(255,255,255,.12); border: 1.5px solid rgba(255,255,255,.18);
    display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; transition: var(--transition);
}
.stat-item:hover .stat-icon-wrap { background: rgba(255,255,255,.22); transform: scale(1.08); }
.stat-icon-wrap svg { width: 22px; height: 22px; fill: var(--moss-bg); }

/* ── SECTION 4: DOKUMENTASI ── */
.dokum-section { padding: 80px 0; background: var(--white); }
.dokum-section .lp-title { text-align: center; }
.dokum-section .lp-label { text-align: center; display: block; }
.dokum-slider-wrap {
    position: relative; overflow: hidden; border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg); max-width: 900px; margin: 0 auto;
}
.dokum-slides { display: flex; transition: transform .5s ease; will-change: transform; }
.dokum-slide { min-width: 100%; position: relative; overflow: hidden; }
.dokum-slide img { width: 100%; height: 480px; object-fit: cover; display: block; }
.dokum-slide-ph {
    width: 100%; height: 480px;
    background: linear-gradient(135deg, var(--moss-dark), var(--moss-mid));
    display: flex; align-items: center; justify-content: center; flex-direction: column;
}
.dokum-slide-ph svg { width: 72px; height: 72px; fill: rgba(255,255,255,.25); }
.dokum-slide-ph p { color: rgba(255,255,255,.45); margin: 12px 0 0; font-size: 14px; }
.dokum-slide-cap {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: linear-gradient(to top, rgba(30,45,32,.85), transparent);
    padding: 48px 28px 22px; color: var(--white);
}
.dokum-slide-cap h4 { margin: 0 0 4px; font-size: 17px; font-weight: 700; }
.dokum-slide-cap p { margin: 0; font-size: 12.5px; opacity: .8; }
.dokum-nav {
    position: absolute; top: 50%; transform: translateY(-50%);
    background: rgba(255,255,255,.18); border: 1px solid rgba(255,255,255,.3);
    color: var(--white); width: 42px; height: 42px; border-radius: 50%; font-size: 18px; cursor: pointer;
    transition: var(--transition); backdrop-filter: blur(6px);
    display: flex; align-items: center; justify-content: center;
}
.dokum-nav:hover { background: rgba(255,255,255,.40); }
.dokum-nav.prev { left: 14px; }
.dokum-nav.next { right: 14px; }
.dokum-dots { text-align: center; margin-top: 18px; }
.dokum-dot {
    display: inline-block; width: 8px; height: 8px; border-radius: 50%;
    background: var(--moss-light); margin: 0 4px; cursor: pointer;
    transition: var(--transition); opacity: .5;
}
.dokum-dot.active { background: var(--moss-dark); opacity: 1; transform: scale(1.3); }

/* ── SECTION 5: TESTIMONI ── */
.testi-section { padding: 80px 0; background: var(--moss-bg); }
.testi-left h2 {
    font-size: 36px; font-weight: 900; color: var(--moss-dark);
    line-height: 1.15; margin: 0 0 18px; letter-spacing: -.3px;
}
.testi-left p { font-size: 15px; color: var(--text-muted); line-height: 1.85; margin: 0 0 24px; }
.testi-card {
    background: var(--white); border-radius: var(--radius-lg); padding: 30px 32px;
    border-left: 4px solid var(--moss-mid); margin-bottom: 20px;
    box-shadow: var(--shadow-sm); transition: var(--transition);
}
.testi-card:hover { box-shadow: var(--shadow-md); transform: translateX(4px); }
.testi-card .testi-quote { font-size: 14.5px; color: var(--text-muted); line-height: 1.85; margin: 0 0 22px; font-style: italic; position: relative; }
.testi-card .testi-quote::before {
    content: '\201C'; font-size: 48px; color: var(--moss-light);
    line-height: 1; position: absolute; top: -10px; left: -4px;
    font-style: normal; font-family: Georgia, serif;
}
.testi-card .testi-quote--inner { padding-left: 28px; }
.testi-card .testi-person { display: flex; align-items: center; gap: 16px; }
.testi-avatar {
    width: 52px; height: 52px; border-radius: 50%; overflow: hidden; flex-shrink: 0;
    background: var(--moss-bg); display: flex; align-items: center; justify-content: center;
    border: 2.5px solid var(--moss-light);
}
.testi-avatar img { width: 100%; height: 100%; object-fit: cover; }
.testi-avatar svg { width: 26px; height: 26px; fill: var(--moss-mid); }
.testi-name { font-weight: 700; font-size: 14.5px; color: var(--moss-dark); }
.testi-role { font-size: 12px; color: var(--moss-light); font-weight: 500; margin-top: 3px; }

/* ── SECTION 6: BOOKSHELF ── */
.bookshelf-section { background: var(--white); padding: 80px 0; }
.bookshelf-section-head { text-align: center; margin-bottom: 44px; }
.bookshelf-row {
    position: relative; padding: 24px 28px 32px; margin-bottom: 40px;
    background: linear-gradient(to bottom, #c4a97e, #9e7a46);
    border-radius: 6px; border-bottom: 12px solid #6e4c1e;
    box-shadow: 0 10px 30px rgba(0,0,0,.22);
    display: flex; flex-wrap: wrap; gap: 24px; min-height: 200px;
    align-items: flex-end; justify-content: center;
}
.bookshelf-row::before {
    content: ''; position: absolute; bottom: -22px; left: -6px; right: -6px;
    height: 16px; background: linear-gradient(to bottom, #5c3b1a, #3d2510);
    border-radius: 0 0 5px 5px; box-shadow: 0 5px 10px rgba(0,0,0,.3);
}
.book-card {
    width: 120px; cursor: pointer; transition: transform .3s cubic-bezier(.4,0,.2,1);
    position: relative; flex-shrink: 0; text-decoration: none;
}
.book-card:hover { transform: translateY(-14px) scale(1.06) rotate(-1deg); text-decoration: none; }
.book-cover {
    width: 120px; height: 170px; border-radius: 2px 8px 8px 2px; overflow: hidden;
    box-shadow: -4px 4px 14px rgba(0,0,0,.4), inset -3px 0 8px rgba(0,0,0,.15), 2px 2px 6px rgba(0,0,0,.2);
    position: relative; background: var(--moss-dark);
}
.book-cover::after {
    content: ''; position: absolute; top: 0; left: 10px; right: 0; bottom: 0;
    background: linear-gradient(90deg, rgba(255,255,255,.12) 0%, transparent 20%, transparent 80%, rgba(0,0,0,.08) 100%);
    pointer-events: none;
}
.book-cover img { width: 100%; height: 100%; object-fit: cover; display: block; }
.book-spine {
    position: absolute; left: 0; top: 0; bottom: 0; width: 12px;
    background: linear-gradient(90deg, rgba(0,0,0,.35) 0%, rgba(0,0,0,.15) 60%, rgba(255,255,255,.05) 100%);
    border-right: 1px solid rgba(255,255,255,.1);
}
.book-no-cover {
    display: flex; align-items: center; justify-content: center;
    width: 100%; height: 100%;
    background: linear-gradient(145deg, var(--moss-dark) 0%, var(--moss-mid) 50%, #3d5a2e 100%);
    color: var(--white); font-size: 11.5px; text-align: center; padding: 14px 10px;
    font-weight: 600; line-height: 1.4; text-shadow: 0 1px 3px rgba(0,0,0,.3);
}
.book-hover-overlay {
    position: absolute; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(48,98,56,0); transition: all .35s;
    display: flex; align-items: center; justify-content: center;
    border-radius: 2px 8px 8px 2px;
}
.book-card:hover .book-hover-overlay { background: rgba(48,98,56,.6); backdrop-filter: blur(2px); }
.book-hover-overlay span {
    color: var(--white); font-size: 12px; font-weight: 700;
    opacity: 0; transition: opacity .3s; letter-spacing: .5px; text-transform: uppercase;
    text-shadow: 0 1px 4px rgba(0,0,0,.4);
}
.book-card:hover .book-hover-overlay span { opacity: 1; }
.book-title {
    font-size: 11px; color: #3d2510; font-weight: 600;
    text-align: center; margin-top: 8px; line-height: 1.35; max-height: 2.7em; overflow: hidden;
}
.bookshelf-more { text-align: center; margin-top: 32px; }
.bookshelf-search {
    display: flex; max-width: 400px; margin: 0 auto 28px;
    background: #f7f9f6; border: 1.5px solid #d8e2d4; border-radius: 30px; overflow: hidden;
    transition: border-color .3s, box-shadow .3s;
}
.bookshelf-search:focus-within { border-color: var(--moss-mid); box-shadow: 0 0 0 3px rgba(97,141,79,.15); }
.bookshelf-search input {
    flex: 1; border: none; background: transparent;
    padding: 10px 18px; font-size: 13.5px; color: #333; outline: none;
}
.bookshelf-search input::placeholder { color: #aab8a8; }
.bookshelf-search button {
    background: var(--moss-dark); border: none; color: #fff;
    padding: 0 20px; cursor: pointer; transition: background .3s;
    display: flex; align-items: center;
}
.bookshelf-search button:hover { background: var(--moss-mid); }
.bookshelf-search button svg { width: 18px; height: 18px; fill: currentColor; }

/* ── SECTION 7: CTA ── */
.cta-section { background: var(--moss-dark); padding: 60px 0; position: relative; overflow: hidden; }
.cta-section::before {
    content: ''; position: absolute; top: -80px; right: -80px;
    width: 360px; height: 360px; border-radius: 50%; background: rgba(255,255,255,.04);
}
.cta-section::after {
    content: ''; position: absolute; bottom: -100px; left: 40%;
    width: 280px; height: 280px; border-radius: 50%; background: rgba(255,255,255,.03);
}
.cta-section .cta-inner { position: relative; z-index: 1; }
.cta-section h2 { color: var(--white); font-size: 30px; font-weight: 800; line-height: 1.35; margin: 0; }
.cta-section h2 span { color: var(--moss-bg); }
.cta-badge { text-align: right; }
.cta-badge-name { color: var(--white); font-size: 24px; font-weight: 900; letter-spacing: -1px; display: block; }
.cta-badge-sub { color: var(--moss-light); font-size: 12.5px; display: block; margin-top: 4px; text-transform: uppercase; letter-spacing: 1.5px; }

/* ── SECTION 8: BERITA ── */
.news-section { padding: 80px 0; background: var(--moss-bg); }
.news-card {
    background: var(--white); border-radius: var(--radius-lg); overflow: hidden;
    box-shadow: var(--shadow-sm); transition: var(--transition); height: 100%; display: flex; flex-direction: column;
}
.news-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-lg); }
.nc-img { width: 100%; height: 220px; object-fit: cover; display: block; }
.nc-img-ph {
    width: 100%; height: 220px;
    background: linear-gradient(135deg, var(--moss-dark), var(--moss-mid));
    display: flex; align-items: center; justify-content: center;
}
.nc-img-ph svg { width: 52px; height: 52px; fill: rgba(255,255,255,.25); }
.nc-body { padding: 22px 24px; flex: 1; display: flex; flex-direction: column; }
.nc-cat {
    display: inline-block; background: var(--moss-bg); color: var(--moss-dark);
    font-size: 10.5px; font-weight: 700; padding: 4px 12px; border-radius: 20px;
    margin-bottom: 12px; text-transform: uppercase; letter-spacing: .8px;
}
.nc-body h3 { font-size: 16px; font-weight: 700; color: var(--text-dark); margin: 0 0 12px; line-height: 1.5; flex: 1; }
.nc-body h3 a { color: inherit; text-decoration: none; }
.nc-body h3 a:hover { color: var(--moss-dark); }
.nc-meta {
    font-size: 11.5px; color: #9aab9c; margin-top: auto; padding-top: 12px;
    border-top: 1px solid #f0f4ed; display: flex; gap: 6px; align-items: center;
}

/* ============================================================
   FLIPBOOK MODAL — PREMIUM ENGINE
   Menggabungkan tampilan kiri.php dengan logika flipbook.php
   - Desktop: spread 2 halaman + animasi 3D flip
   - Mobile : 1 halaman, swipe gesture, auto-fit
   ============================================================ */

/* ── Modal Overlay ── */
.fb2-overlay {
    display: none; position: fixed; inset: 0; z-index: 99999;
    background: rgba(0,0,0,.88); backdrop-filter: blur(8px);
    align-items: center; justify-content: center;
}
.fb2-overlay.active { display: flex; }

/* ── Modal Container ── */
.fb2-container {
    width: 100vw; height: 100vh;
    display: flex; flex-direction: column; background: #1a1a1a;
}
@media (min-width: 768px) {
    .fb2-container {
        width: 92vw; height: 92vh; max-width: 1400px;
        border-radius: 10px; overflow: hidden;
        box-shadow: 0 24px 80px rgba(0,0,0,.7);
    }
}

/* ── Header ── */
.fb2-header {
    height: 52px; background: var(--moss-dark);
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 20px; flex-shrink: 0;
}
.fb2-header h4 {
    margin: 0; font-size: 14px; font-weight: 600; color: #fff;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap; flex: 1; padding-right: 16px;
}
.fb2-header-actions { display: flex; gap: 8px; align-items: center; }
.fb2-hbtn {
    width: 32px; height: 32px; border-radius: 6px;
    border: 1px solid rgba(255,255,255,.2); background: rgba(255,255,255,.12); cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: #fff; transition: background .15s;
}
.fb2-hbtn:hover { background: rgba(255,255,255,.28); }
.fb2-close-btn {
    background: transparent; border: none; font-size: 26px; line-height: 1;
    cursor: pointer; color: rgba(255,255,255,.7); padding: 4px 6px; transition: color .15s;
}
.fb2-close-btn:hover { color: #ff6b6b; }

/* ── Body ── */
.fb2-body {
    flex: 1; display: flex; align-items: center; justify-content: center;
    padding: 24px 64px; position: relative; overflow: hidden;
    background: #0a120b; min-height: 400px;
    cursor: grab;
}
.fb2-body.is-dragging { cursor: grabbing; }

/* Nav arrows */
.fb2-nav {
    position: absolute; top: 50%; transform: translateY(-50%);
    width: 46px; height: 46px; border-radius: 50%;
    background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2);
    color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: all .2s; z-index: 10;
}
.fb2-nav:hover { background: rgba(255,255,255,.28); }
.fb2-nav.prev { left: 12px; }
.fb2-nav.next { right: 12px; }
@media (max-width: 600px) {
    .fb2-nav { display: none; }
    .fb2-body { padding: 0; cursor: default; }
}

/* ── Scene / Spread ── */
.fb2-scene {
    position: relative; display: inline-flex;
    align-items: stretch; flex-shrink: 0;
    perspective: 2500px; perspective-origin: 50% 50%;
}
#fb2CanvasL {
    display: block;
    box-shadow: -6px 0 24px rgba(0,0,0,.6);
    border-radius: 4px 0 0 4px;
}
#fb2CanvasR {
    display: block;
    box-shadow: 6px 0 24px rgba(0,0,0,.6);
    border-radius: 0 4px 4px 0;
}
.fb2-spine {
    width: 6px; flex-shrink: 0; align-self: stretch;
    background: linear-gradient(180deg, #4a7a52, #1d3d22 50%, #4a7a52);
    box-shadow: 2px 0 8px rgba(0,0,0,.5), -2px 0 8px rgba(0,0,0,.5);
}
.fb2-page-cover {
    border-radius: 6px;
    box-shadow: -6px 6px 30px rgba(0,0,0,.5), 4px 4px 0 rgba(0,0,0,.15);
}

/* ── Flipper (desktop 3D) ── */
.fb2-flipper {
    position: absolute; transform-style: preserve-3d;
    display: none; z-index: 20; pointer-events: none; will-change: transform;
}
.fb2-flip-front, .fb2-flip-back {
    position: absolute; inset: 0; overflow: hidden;
    backface-visibility: hidden; -webkit-backface-visibility: hidden;
}
.fb2-flip-back { transform: rotateY(180deg); }
.fb2-flip-front canvas, .fb2-flip-back canvas { display:block; width:100%; height:100%; }

.fb2-flipper.is-next .fb2-flip-front::after {
    content:''; position:absolute; inset:0; pointer-events:none;
    background: linear-gradient(to left, rgba(0,0,0,.4) 0%, transparent 70%);
}
.fb2-flipper.is-next .fb2-flip-back::after {
    content:''; position:absolute; inset:0; pointer-events:none;
    background: linear-gradient(to right, rgba(0,0,0,.25) 0%, transparent 60%);
}
.fb2-flipper.is-prev .fb2-flip-front::after {
    content:''; position:absolute; inset:0; pointer-events:none;
    background: linear-gradient(to right, rgba(0,0,0,.4) 0%, transparent 70%);
}
.fb2-flipper.is-prev .fb2-flip-back::after {
    content:''; position:absolute; inset:0; pointer-events:none;
    background: linear-gradient(to left, rgba(0,0,0,.25) 0%, transparent 60%);
}

/* ── Loading ── */
#fb2Loading {
    display: none; position: absolute;
    background: rgba(0,0,0,.65); color: #ddd;
    padding: 10px 24px; border-radius: 24px;
    font-size: 13px; font-weight: 600; z-index: 30;
}
#fb2Loading::before {
    content: ''; display: inline-block;
    width: 14px; height: 14px; border-radius: 50%;
    border: 2px solid var(--moss-mid); border-top-color: transparent;
    animation: fb2spin .7s linear infinite;
    vertical-align: middle; margin-right: 8px;
}
@keyframes fb2spin { to { transform: rotate(360deg); } }

/* ── Swipe hint ── */
.fb2-swipe-hint {
    position: absolute; bottom: 16px; left: 50%; transform: translateX(-50%);
    background: rgba(48,98,56,.75); color: #fff; font-size: 11px;
    padding: 5px 14px; border-radius: 20px; pointer-events: none;
    opacity: 1; transition: opacity 1s; display: none;
}
.fb2-swipe-hint.visible { display: block; }
.fb2-swipe-hint.fade    { opacity: 0; }

/* ── Toolbar bawah ── */
.fb2-toolbar {
    display: flex; align-items: center; justify-content: center;
    gap: 8px; padding: 10px 20px;
    background: #111; flex-shrink: 0;
    border-top: 1px solid rgba(255,255,255,.06);
    flex-wrap: wrap;
}
.fb2-page-info {
    background: rgba(255,255,255,.1); color: #ddd;
    font-size: 12px; font-weight: 600;
    padding: 5px 16px; border-radius: 20px;
    letter-spacing: .5px; min-width: 100px; text-align: center;
}
.fb2-tbtn {
    width: 34px; height: 34px; border-radius: 50%;
    background: rgba(255,255,255,.1); border: none; color: #ccc; cursor: pointer;
    display: flex; align-items: center; justify-content: center; transition: all .18s;
}
.fb2-tbtn:hover { background: rgba(255,255,255,.22); color: #fff; }
.fb2-tbtn.active { color: var(--moss-mid); background: rgba(97,141,79,.2); }
.fb2-vdivider { width: 1px; height: 22px; background: rgba(255,255,255,.12); margin: 0 4px; }
.fb2-tb-zoom {
    display: flex; gap: 4px;
}
.fb2-tbtn-text {
    height: 30px; border-radius: 6px; border: none;
    background: rgba(255,255,255,.1); color: #ccc;
    padding: 0 12px; cursor: pointer; font-size: 12px; font-weight: 600;
    transition: all .18s;
}
.fb2-tbtn-text:hover { background: rgba(255,255,255,.22); color: #fff; }
.fb2-page-input {
    width: 48px; height: 30px; border-radius: 6px;
    border: 1px solid rgba(255,255,255,.2);
    background: rgba(255,255,255,.08); color: #ddd;
    text-align: center; font-size: 12px; outline: none;
}

/* ── Thumbnail strip ── */
.fb2-thumbs {
    display: flex; gap: 8px; overflow-x: auto; padding: 10px 16px;
    background: #0d0d0d; border-top: 1px solid rgba(255,255,255,.05);
    flex-shrink: 0;
    scrollbar-width: thin; scrollbar-color: #444 transparent;
}
.fb2-thumbs::-webkit-scrollbar { height: 4px; }
.fb2-thumbs::-webkit-scrollbar-track { background: transparent; }
.fb2-thumbs::-webkit-scrollbar-thumb { background: #444; border-radius: 2px; }

.fb2-thumb {
    flex-shrink: 0; width: 50px; height: 70px; border-radius: 3px;
    background: #2a2a2a; cursor: pointer; overflow: hidden;
    border: 2px solid transparent; transition: all .18s; position: relative;
}
.fb2-thumb:hover { border-color: rgba(97,141,79,.5); }
.fb2-thumb.active { border-color: var(--moss-mid); }
.fb2-thumb canvas { width: 100%; height: 100%; display: block; object-fit: contain; }
.fb2-thumb-num {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: rgba(0,0,0,.65); color: #ccc;
    font-size: 9px; text-align: center; padding: 2px 0;
}

/* ── Mobile overrides ── */
@media (max-width: 767px) {
    .fb2-toolbar {
        gap: 4px; padding: 6px 8px;
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        justify-items: stretch;
    }
    .fb2-page-info {
        font-size: 12px; min-width: auto;
        background: rgba(255,255,255,.06); border-radius: 6px;
        padding: 5px 10px;
    }
    .fb2-tb-desktop { display: none !important; }
    .fb2-tb-zoom-mobile {
        grid-column: 1 / -1;
        display: flex !important; gap: 6px;
    }
    .fb2-tb-zoom-mobile .fb2-tbtn-text { flex: 1; }
    #fb2CanvasR { display: none !important; width: 0 !important; }
    #fb2Spine   { display: none !important; }
    #fb2Flipper { display: none !important; }
    #fb2CanvasL { width: 100% !important; box-shadow: none !important; border-radius: 0 !important; }
    .fb2-thumbs { display: none; }
}
</style>

<?php
$q_prog = $koneksi_db->sql_query("SELECT * FROM halaman WHERE id IN (2,3,4,5,6,7,8,9) ORDER BY id ASC");
$programs = [];
while ($p = $koneksi_db->sql_fetchrow($q_prog)) $programs[] = $p;
$prog_count = count($programs);

$prog_styles = [
    ['bg'=>'var(--moss-dark)',  'border'=>'var(--moss-light)', 'icon'=>'M12 3L1 9l11 6 9-4.91V17h2V9L12 3zm0 12.08L5.21 11 12 7.08 18.79 11 12 15.08zM1 17l11 6 11-6v-2L12 21 1 15v2z'],
    ['bg'=>'var(--moss-olive)', 'border'=>'var(--moss-light)', 'icon'=>'M20 6h-2.18c.07-.44.18-.86.18-1a3 3 0 0 0-6 0c0 .14.11.56.18 1H10c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-7-1a1 1 0 0 1 2 0c0 .22-.19.86-.25 1h-1.5c-.06-.14-.25-.78-.25-1zm-3 3h14v12H10V8z'],
    ['bg'=>'var(--moss-mid)',   'border'=>'var(--moss-bg)',   'icon'=>'M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z'],
    ['bg'=>'#3d5a2e',          'border'=>'var(--moss-light)', 'icon'=>'M19.5 12c0-3.59-2.91-6.5-6.5-6.5S6.5 8.41 6.5 12H5c0-3.87 3.13-7 7-7s7 3.13 7 7h-1.5zM12 3C6.48 3 2 7.48 2 13v5h20v-5c0-5.52-4.48-10-10-10zm8 13H4v-3c0-4.41 3.59-8 8-8s8 3.59 8 8v3z'],
    ['bg'=>'var(--moss-dark)',  'border'=>'var(--moss-mid)',  'icon'=>'M4 13v7h7v-4h2v4h7v-7l-8-5-8 5zm14 5h-3v-4H9v4H6v-4.43l6-3.75 6 3.75V18zM4 10l8-5 8 5H20V8l-8-5-8 5v2H4z'],
    ['bg'=>'var(--moss-olive)', 'border'=>'var(--moss-bg)',   'icon'=>'M12 2a5 5 0 1 0 0 10A5 5 0 0 0 12 2zm0 8a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm7 5h-1v-1c0-.55-.45-1-1-1H7c-.55 0-1 .45-1 1v1H5c-1.1 0-2 .9-2 2v6h18v-6c0-1.1-.9-2-2-2zm0 6H5v-4h1v1h2v-1h8v1h2v-1h1v4z'],
    ['bg'=>'var(--moss-mid)',   'border'=>'var(--moss-dark)', 'icon'=>'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z'],
    ['bg'=>'#3d5a2e',          'border'=>'var(--moss-light)', 'icon'=>'M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z'],
];

function cleanProgText($str) {
    $str = strip_tags($str);
    $str = str_replace(['&nbsp;','&amp;','&lt;','&gt;','&quot;','&#39;','&mdash;','&ndash;','&bull;'],
        [' ','&','<','>','"',"'",'—','–','•'], $str);
    $str = preg_replace('/[\x{1F000}-\x{1FFFF}]/u', '', $str);
    $str = preg_replace('/[\x{2600}-\x{27FF}]/u', '', $str);
    $str = preg_replace('/[\x{FE00}-\x{FE0F}]/u', '', $str);
    $str = preg_replace('/\s+/', ' ', $str);
    return trim($str);
}
?>

<!-- ============================================================
     SECTION 1: PROGRAM MBKM
     ============================================================ -->
<section class="prog-section">
<div class="prog-section-head">
    <span class="lp-label">Program Unggulan</span>
    <h2 class="lp-title lp-title--lg"><?= $prog_count > 0 ? ($prog_count > 1 ? $prog_count.' PROGRAM MBKM' : 'PROGRAM MBKM') : '8 PROGRAM MBKM' ?></h2>
    <div class="lp-divider" style="margin: 0 auto;"></div>
</div>
<div class="container" style="padding-bottom:30px;">
    <?php if ($prog_count > 0): ?>
    <div class="row" style="overflow:visible; display:flex; flex-wrap:wrap; align-items:stretch;">
        <?php foreach ($programs as $i => $data):
            $style   = $prog_styles[$i % count($prog_styles)];
            $urlkat  = str_replace(' ', '-', $data['judul']);
            $snippet = limitTXT(cleanProgText($data['konten']), 120);
        ?>
        <div class="col-sm-3" style="padding:0 12px; margin-bottom:32px; display:flex;">
            <div class="prog-card" style="background:<?= $style['bg'] ?>; border-top-color:<?= $style['border'] ?>;">
                <div class="pc-icon">
                    <svg viewBox="0 0 24 24"><path d="<?= $style['icon'] ?>"/></svg>
                </div>
                <h3><?= htmlspecialchars($data['judul']) ?></h3>
                <p><?= htmlspecialchars(strip_tags($snippet)) ?></p>
                <a href="pages/<?= $data['id'] ?>/<?= $urlkat ?>.html" class="pc-btn">
                    <svg viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p style="text-align:center; color:#9EBB97; padding:40px 0;">Program belum tersedia.</p>
    <?php endif; ?>
</div>
</section>

<!-- ============================================================
     SECTION 2: TENTANG / SAMBUTAN
     ============================================================ -->
<section class="sambutan-section">
    <div class="container">
        <div class="row" style="align-items:center;">
            <div class="col-sm-5" style="margin-bottom:30px;">
                <div class="sambutan-media">
                    <div class="sambutan-media-placeholder">
                        <svg viewBox="0 0 24 24" style="width:48px;height:48px;fill:rgba(255,255,255,.2);">
                            <path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/>
                        </svg>
                        <p>Video Profil MBKM IAI PI Bandung</p>
                    </div>
                    <?php
                    $vid = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM mod_data_video ORDER BY id DESC LIMIT 1"));
                    if ($vid && !empty($vid['video'])):
                    ?>
                    <div style="position:absolute;top:0;left:0;right:0;bottom:0;">
                        <img src="http://img.youtube.com/vi/<?= $vid['video'] ?>/hqdefault.jpg" style="width:100%;height:100%;object-fit:cover;">
                        <a href="https://www.youtube.com/watch?v=<?= $vid['video'] ?>" target="_blank" class="play-icon-wrap">
                            <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-7 sambutan-text">
                <span class="lp-label">Tentang</span>
                <?php
                $profil_data = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM mod_data_profil WHERE id='1'"));
                if ($profil_data && !empty($profil_data['nama'])):
                ?>
                <h2 class="lp-title"><?= htmlspecialchars($profil_data['nama']) ?></h2>
                <div class="lp-divider"></div>
                <p><?= limitTXT(strip_tags($profil_data['sambutan']), 460) ?></p>
                <?php else: ?>
                <h2 class="lp-title">Tentang MBKM<br>IAI PI Bandung</h2>
                <div class="lp-divider"></div>
                <p>Program MBKM (Merdeka Belajar Kampus Merdeka) di IAI PI Bandung hadir sebagai wujud komitmen kami dalam memberikan pengalaman belajar yang bermakna dan berdampak nyata bagi mahasiswa.</p>
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
                    ['jum'=>'500+','nama'=>'Mahasiswa Aktif'],
                    ['jum'=>'150+','nama'=>'Mitra Industri'],
                    ['jum'=>'8',   'nama'=>'Program MBKM'],
                    ['jum'=>'95%', 'nama'=>'Tingkat Kepuasan'],
                ];
            endif;
            $stat_icons = [
                'M12 3L1 9l11 6 9-4.91V17h2V9L12 3zm0 12.08L5.21 11 12 7.08 18.79 11 12 15.08zM1 17l11 6 11-6v-2L12 21 1 15v2z',
                'M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z',
                'M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z',
                'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z',
            ];
            $si = 0;
            foreach ($stats as $s):
                $sicon = $stat_icons[$si % 4]; $si++;
            ?>
            <div class="col-xs-6 col-sm-3">
                <div class="stat-item">
                    <div class="stat-icon-wrap">
                        <svg viewBox="0 0 24 24"><path d="<?= $sicon ?>"/></svg>
                    </div>
                    <span class="stat-num"><?= $s['jum'] ?></span>
                    <span class="stat-label"><?= $s['nama'] ?></span>
                    <div class="stat-line"></div>
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
        <span class="lp-label" style="text-align:center;display:block;">Galeri Kegiatan</span>
        <h2 class="lp-title lp-title--lg" style="text-align:center;">DOKUMENTASI KEGIATAN MBKM</h2>
        <div class="lp-divider" style="margin: 0 auto 40px;"></div>
        <div class="dokum-slider-wrap">
            <div class="dokum-slides" id="dokSlides">
                <?php
                $dummy_docs = [
                    ['img'=>'','title'=>'Pelepasan Peserta Program Magang 2024','sub'=>'Program Magang MBKM IAI PI Bandung'],
                    ['img'=>'','title'=>'Orientasi Mahasiswa Pertukaran Antar Perguruan Tinggi','sub'=>'Program Pertukaran Mahasiswa Semester Ganjil'],
                    ['img'=>'','title'=>'Kegiatan Kampus Mengajar di Pelosok Nusantara','sub'=>'Kampus Mengajar - Membangun Pendidikan Nusantara'],
                    ['img'=>'','title'=>'Dokumentasi KKNT Membangun Desa','sub'=>'Kuliah Kerja Nyata Tematik 2024'],
                ];
                $q_foto = $koneksi_db->sql_query("SELECT * FROM mod_data_foto ORDER BY id DESC LIMIT 5");
                $real_docs = [];
                while ($f = $koneksi_db->sql_fetchrow($q_foto)) $real_docs[] = $f;
                $docs = !empty($real_docs) ? $real_docs : $dummy_docs;
                foreach ($docs as $idx => $d):
                    $is_real = isset($d['nama']);
                    $img_src = $is_real && !empty($d['foto']) && @file_exists('images/foto/'.$d['foto']) ? 'images/foto/'.$d['foto'] : '';
                    $title   = $is_real ? htmlspecialchars($d['nama']) : $d['title'];
                    $sub_cap = $is_real ? htmlspecialchars(isset($d['ket']) ? $d['ket'] : '') : $d['sub'];
                ?>
                <div class="dokum-slide">
                    <?php if ($img_src): ?>
                    <img src="<?= $img_src ?>" alt="<?= $title ?>" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                    <div class="dokum-slide-ph" style="display:none">
                        <svg viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                        <p><?= $title ?></p>
                    </div>
                    <?php else: ?>
                    <div class="dokum-slide-ph">
                        <svg viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                        <p><?= $title ?: 'Foto Dokumentasi '.($idx+1) ?></p>
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
                <span class="lp-label">Testimoni</span>
                <h2>BAGAIMANA<br>PENGALAMAN<br>MEREKA?</h2>
                <div class="lp-divider"></div>
                <p>Beragam testimoni dari mahasiswa yang telah berpartisipasi dalam program MBKM IAI PI Bandung.</p>
            </div>
            <div class="col-sm-8">
                <?php
                $q_testi = $koneksi_db->sql_query("SELECT * FROM mod_data_testi WHERE status='1' ORDER BY id DESC LIMIT 3");
                $testis = [];
                while ($t = $koneksi_db->sql_fetchrow($q_testi)) $testis[] = $t;
                if (empty($testis)):
                    $testis = [
                        ['nama'=>'Ahmad Fauzi','email'=>'Program Magang - PT. XYZ','ket'=>'Pengalaman magang melalui program MBKM sangat luar biasa. Saya mendapat banyak pengetahuan praktis yang tidak diajarkan di kelas. Tim MBKM IAI PI Bandung selalu siap membantu selama program berlangsung.','foto'=>''],
                        ['nama'=>'Siti Nurhaliza','email'=>'Program Pertukaran Mahasiswa','ket'=>'Program pertukaran mahasiswa membuka wawasan saya tentang budaya belajar di kampus lain. Sangat direkomendasikan untuk mahasiswa semester lima ke atas.','foto'=>''],
                        ['nama'=>'Rizky Pratama','email'=>'Kampus Mengajar - SDN Cimahi','ket'=>'Mengajar di sekolah dasar adalah pengalaman yang mengubah perspektif saya. Saya menjadi lebih menghargai dunia pendidikan dan ingin terus berkontribusi.','foto'=>''],
                    ];
                endif;
                foreach ($testis as $t):
                ?>
                <div class="testi-card">
                    <p class="testi-quote">
                        <span class="testi-quote--inner"><?= htmlspecialchars($t['ket']) ?></span>
                    </p>
                    <div class="testi-person">
                        <div class="testi-avatar">
                            <?php if (!empty($t['foto'])): ?>
                            <img src="images/testi/<?= $t['foto'] ?>" alt="<?= htmlspecialchars($t['nama']) ?>">
                            <?php else: ?>
                            <svg viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
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
     Tampilan dari kiri.php, Engine dari flipbook.php
     ============================================================ -->

<!-- MODAL FLIPBOOK PREMIUM (tampilan kiri.php + engine flipbook.php) -->
<div class="fb2-overlay" id="fb2Overlay">
<div class="fb2-container">

    <!-- Header (warna moss-dark seperti kiri.php) -->
    <div class="fb2-header">
        <h4 id="fb2Title">Dokumen</h4>
        <div class="fb2-header-actions">
            <!-- Zoom In -->
            <button class="fb2-hbtn fb2-tb-desktop" onclick="fb2ZoomIn()" title="Zoom In">
                <svg width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M15.5 14h-.79l-.28-.27A6.5 6.5 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99 1.49-1.49-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14zm.5-7H9v2H7v1h2v2h1v-2h2V9h-2V7z"/></svg>
            </button>
            <!-- Zoom Out -->
            <button class="fb2-hbtn fb2-tb-desktop" onclick="fb2ZoomOut()" title="Zoom Out">
                <svg width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M15.5 14h-.79l-.28-.27A6.5 6.5 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99 1.49-1.49-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14zM7 9h5v1H7z"/></svg>
            </button>
            <!-- Fullscreen -->
            <button class="fb2-hbtn fb2-tb-desktop" onclick="fb2Fullscreen()" title="Fullscreen">
                <svg width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/></svg>
            </button>
            <!-- Download -->
            <a id="fb2DownloadLink" href="#" target="_blank" class="fb2-hbtn" title="Download PDF" style="text-decoration:none;">
                <svg width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
            </a>
            <button class="fb2-close-btn" onclick="fb2Close()">&#x2715;</button>
        </div>
    </div>

    <!-- Body: spread view dengan flipper 3D -->
    <div class="fb2-body" id="fb2Body">
        <button class="fb2-nav prev" onclick="fb2Nav(-1)">
            <svg width="22" height="22" viewBox="0 0 24 24"><path fill="currentColor" d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
        </button>

        <!-- Scene: canvas kiri + spine + canvas kanan (desktop) / canvas saja (mobile) -->
        <div class="fb2-scene" id="fb2Scene">
            <canvas id="fb2CanvasL"></canvas>
            <div id="fb2Spine" class="fb2-spine" style="display:none;"></div>
            <canvas id="fb2CanvasR" style="display:none;"></canvas>
            <!-- Flipper 3D (desktop only) -->
            <div class="fb2-flipper" id="fb2Flipper">
                <div class="fb2-flip-front"><canvas id="fb2FlipFront"></canvas></div>
                <div class="fb2-flip-back" ><canvas id="fb2FlipBack" ></canvas></div>
            </div>
        </div>

        <div id="fb2Loading">Memuat dokumen...</div>
        <div class="fb2-swipe-hint" id="fb2SwipeHint">&#8592; geser untuk pindah halaman &#8594;</div>

        <button class="fb2-nav next" onclick="fb2Nav(1)">
            <svg width="22" height="22" viewBox="0 0 24 24"><path fill="currentColor" d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
        </button>
    </div>

    <!-- Toolbar bawah -->
    <div class="fb2-toolbar">
        <!-- Prev (desktop: 2 hal, mobile: 1 hal) -->
        <button id="fb2BtnPrev" onclick="fb2Nav(-1)">&#9664; Prev</button>
        <!-- Info halaman -->
        <span class="fb2-page-info" id="fb2PageInfo">Cover</span>
        <!-- Next -->
        <button id="fb2BtnNext" onclick="fb2Nav(1)">Next &#9654;</button>

        <!-- Desktop controls -->
        <div class="fb2-vdivider fb2-tb-desktop"></div>
        <button class="fb2-tbtn fb2-tb-desktop" id="fb2AutoBtn" onclick="fb2ToggleAuto()" title="Auto-play">
            <svg width="17" height="17" viewBox="0 0 24 24"><path fill="currentColor" d="M8 5v14l11-7z"/></svg>
        </button>
        <div class="fb2-tb-zoom fb2-tb-desktop">
            <button class="fb2-tbtn-text" onclick="fb2ZoomIn()">&#43;</button>
            <button class="fb2-tbtn-text" onclick="fb2ZoomOut()">&#8722;</button>
            <button class="fb2-tbtn-text" onclick="fb2ZoomReset()">&#8635;</button>
        </div>
        <input type="number" id="fb2PageInput" min="1" value="1" class="fb2-page-input fb2-tb-desktop"
            onkeydown="if(event.key==='Enter') fb2GoToPage(this.value)">
        <button class="fb2-tbtn-text fb2-tb-desktop" onclick="fb2GoToPage(document.getElementById('fb2PageInput').value)">Go</button>

        <!-- Mobile zoom row -->
        <div class="fb2-tb-zoom-mobile" style="display:none;">
            <button class="fb2-tbtn-text" onclick="fb2ZoomIn()">&#43; Zoom</button>
            <button class="fb2-tbtn-text" onclick="fb2ZoomOut()">&#8722; Zoom</button>
        </div>
    </div>

    <!-- Thumbnail strip (hidden mobile via CSS) -->
    <div class="fb2-thumbs" id="fb2Thumbs"></div>

</div>
</div>

<!-- BOOKSHELF SECTION (tampilan persis kiri.php) -->
<section class="bookshelf-section">
    <div class="container">
        <div class="bookshelf-section-head">
            <span class="lp-label">Referensi</span>
            <h2 class="lp-title lp-title--lg">PEDOMAN MBKM IAI PI BANDUNG</h2>
            <div class="lp-divider" style="margin:0 auto;"></div>
        </div>
        <div class="bookshelf-search">
            <input type="text" id="bookSearchInput" placeholder="Cari buku pedoman..." oninput="filterBooks()">
            <button type="button" onclick="filterBooks()">
                <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
            </button>
        </div>
        <?php
        $buku_list = [];
        $q_buku = $koneksi_db->sql_query("SELECT * FROM mod_data_flipbook WHERE status='1' ORDER BY ordering ASC, id DESC LIMIT 12");
        while ($bk = $koneksi_db->sql_fetchrow($q_buku)) $buku_list[] = $bk;

        if (!empty($buku_list)):
            $chunks_b = array_chunk($buku_list, 6);
            foreach ($chunks_b as $brow):
                echo '<div class="bookshelf-row">';
                foreach ($brow as $bk):
                    $cv = !empty($bk['cover']) ? 'images/flipbook/'.htmlspecialchars($bk['cover']) : '';
                    $jd = htmlspecialchars($bk['judul']);
                    $pf = htmlspecialchars($bk['file_pdf']);
                    echo '<div class="book-card" onclick="openFlipbook(\''.addslashes($pf).'\',\''.addslashes($jd).'\')">
                        <div class="book-cover">
                            <div class="book-spine"></div>';
                    echo $cv ? '<img src="'.$cv.'" alt="'.$jd.'">' : '<div class="book-no-cover">'.$jd.'</div>';
                    echo '<div class="book-hover-overlay"><span>Buka</span></div>
                        </div>
                        <div class="book-title">'.$jd.'</div>
                    </div>';
                endforeach;
                echo '</div>';
            endforeach;
        else:
            $dummy_books = ['Pedoman Magang','Pedoman Pertukaran','Panduan KKNT','Pedoman Riset','Studi Independen','Kampus Mengajar'];
            $book_colors = ['#306238','#618D4F','#545837','#3d5a2e','#9EBB97','#2a5430'];
            echo '<div class="bookshelf-row">';
            foreach ($dummy_books as $bi => $bn):
                echo '<div class="book-card" onclick="alert(\'Upload buku via Admin Flipbook terlebih dahulu.\')">
                    <div class="book-cover" style="background:'.$book_colors[$bi].';">
                        <div class="book-spine"></div>
                        <div class="book-no-cover">'.$bn.'</div>
                        <div class="book-hover-overlay"><span>Buka</span></div>
                    </div>
                    <div class="book-title">'.$bn.'</div>
                </div>';
            endforeach;
            echo '</div>';
        endif;
        ?>
        <div class="bookshelf-more">
            <a href="index.php?pilih=flipbook&modul=yes" class="btn-primary-lp" style="margin-top:0;">Lihat Semua Pedoman &raquo;</a>
        </div>
    </div>
</section>

<!-- ============================================================
     SECTION 7: CTA BANNER
     ============================================================ -->
<section class="cta-section">
    <div class="container">
        <div class="row cta-inner" style="align-items:center;">
            <div class="col-sm-8">
                <h2>Mari Bergabung Dengan Program MBKM<br><span>Universitas IAI PI Bandung</span></h2>
            </div>
            <div class="col-sm-4 cta-badge">
                <span class="cta-badge-name">MBKM BERDAMPAK</span>
                <span class="cta-badge-sub">Universitas IAI PI Bandung</span>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     SECTION 8: BERITA & KEGIATAN
     ============================================================ -->
<section class="news-section">
    <div class="container">
        <span class="lp-label">Kabar Terkini</span>
        <h2 class="lp-title lp-title--lg">BERITA &amp; KEGIATAN</h2>
        <div class="lp-divider" style="margin-bottom:40px;"></div>
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
                        <div class="nc-img-ph">
                            <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12zM6 10h2v2H6zm0 4h8v2H6zm4-4h8v2h-8z"/></svg>
                        </div>
                        <div class="nc-body">
                            <span class="nc-cat">MBKM</span>
                            <h3><a href="<?= $ni['url'] ?>"><?= htmlspecialchars($ni['judul']) ?></a></h3>
                            <div class="nc-meta"><?= $ni['hits'] ?> kali dibaca &nbsp;|&nbsp; <?= date('d M Y') ?></div>
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
                        <div class="nc-img-ph">
                            <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12zM6 10h2v2H6zm0 4h8v2H6zm4-4h8v2h-8z"/></svg>
                        </div>
                        <?php endif; ?>
                        <div class="nc-body">
                            <span class="nc-cat">MBKM</span>
                            <h3><a href="artikel/<?= $data[0] ?>/<?= $url ?>.html"><?= htmlspecialchars($data[1]) ?></a></h3>
                            <div class="nc-meta"><?= $data['hits'] ?> kali dibaca &nbsp;|&nbsp; <?= datetimess($data[5]) ?></div>
                        </div>
                    </div>
                </div>
                <?php
                endforeach;
            endif;
            ?>
        </div>
        <div style="text-align:center; margin-top:16px;">
            <a href="kategori/1/Berita-Kampus.html" class="btn-outline-lp">Lihat Semua Berita &raquo;</a>
        </div>
    </div>
</section>

<!-- ============================================================
     SCRIPTS
     ============================================================ -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
/* ── PDF.js worker ── */
if (typeof pdfjsLib !== 'undefined') {
    pdfjsLib.GlobalWorkerOptions.workerSrc =
        'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
}

/* ══════════════════════════════════════════════════════════════
   FLIPBOOK ENGINE — Gabungan kiri.php (tampilan) + flipbook.php (fungsi)
   ─────────────────────────────────────────────────────────────
   STATE:
   - _pdf     : objek PDF dari PDF.js
   - _page    : halaman kiri yang sedang ditampilkan (selalu ganjil di desktop)
   - _total   : total halaman
   - _busy    : mencegah flip ganda
   - _scale   : skala render
   - _zoom    : zoom tambahan (dari tombol +/-)
   - _autoOn  : mode auto-play
   ══════════════════════════════════════════════════════════════ */
var _pdf      = null;
var _page     = 1;
var _total    = 0;
var _busy     = false;
var _scale    = 1.3;
var _zoom     = 1.0;
var _autoOn   = false;
var _autoTimer = null;
var FLIP_MS   = 640;

/* Cache elemen DOM */
var _EL = {};
function _el(id) { return _EL[id] || (_EL[id] = document.getElementById(id)); }

/* ── Helpers ── */
function _isMobile() { return window.innerWidth <= 767; }

/* Hitung skala otomatis agar halaman muat di area modal */
function _calcScale() {
    var body   = _el('fb2Body');
    var availW = body.clientWidth  - (_isMobile() ? 0 : 128); /* padding nav kiri+kanan */
    var availH = body.clientHeight - 40;
    if (!_pdf) return Promise.resolve(_isMobile() ? 1.0 : 1.3);
    return _pdf.getPage(1).then(function(pg) {
        var vp = pg.getViewport({ scale: 1 });
        var mob   = _isMobile();
        var maxW  = mob ? availW : Math.floor((availW - 6) / 2); /* 6 = spine */
        var scaleW = maxW   / vp.width;
        var scaleH = availH / vp.height;
        return Math.max(0.3, Math.min(3.5, Math.min(scaleW, scaleH)));
    });
}

/* Render satu halaman PDF ke canvas */
function _rndPage(num, canvas) {
    if (!_pdf || num < 1 || num > _total) {
        canvas.width = 0; canvas.height = 0;
        canvas.style.display = 'none';
        return Promise.resolve(null);
    }
    var dpr = Math.min(window.devicePixelRatio || 1, 2);
    var s   = _scale * _zoom;
    return _pdf.getPage(num).then(function(pg) {
        var vp = pg.getViewport({ scale: s * dpr });
        canvas.width        = vp.width;
        canvas.height       = vp.height;
        canvas.style.width  = Math.round(vp.width  / dpr) + 'px';
        canvas.style.height = Math.round(vp.height / dpr) + 'px';
        canvas.style.display = 'block';
        return pg.render({ canvasContext: canvas.getContext('2d'), viewport: vp }).promise
            .then(function() { return canvas; });
    });
}

/* Salin canvas src → dst (untuk flipper animasi) */
function _copyCanvas(src, dst) {
    if (!src || !src.width) return;
    dst.width  = src.width;  dst.height = src.height;
    dst.style.width  = src.style.width;
    dst.style.height = src.style.height;
    dst.style.display = 'block';
    dst.getContext('2d').drawImage(src, 0, 0);
}

/* Snap halaman ke posisi spread yang valid */
function _snapPage(p) {
    if (_isMobile()) return Math.max(1, Math.min(_total, p));
    var s = (p % 2 === 0) ? Math.max(1, p - 1) : p;
    return Math.max(1, Math.min(_total, s));
}

/* Update UI: info halaman, tombol, spine */
function _updateUI(p) {
    var mob  = _isMobile();
    var hasR = !mob && (p + 1 <= _total);

    _el('fb2Spine').style.display  = hasR ? 'block' : 'none';
    var cR = _el('fb2CanvasR');
    if (!hasR) { cR.style.display = 'none'; cR.width = 0; }

    var label = (p === 1 && _total <= 1)
        ? 'Cover'
        : 'Hal ' + p + (hasR ? '\u2013' + (p + 1) : '') + ' / ' + _total;
    _el('fb2PageInfo').textContent = label;

    var inp = _el('fb2PageInput');
    if (inp) inp.value = p;

    _el('fb2BtnPrev').disabled = (p <= 1);
    _el('fb2BtnNext').disabled = mob ? (p >= _total) : (p + 1 >= _total);

    /* Mobile zoom row */
    var mzr = document.querySelector('.fb2-tb-zoom-mobile');
    if (mzr) mzr.style.display = mob ? 'flex' : 'none';
}

/* ── RENDER LANGSUNG (tanpa animasi) ── */
function _renderDirect(p, cb) {
    var mob = _isMobile();
    var cL  = _el('fb2CanvasL');
    var cR  = _el('fb2CanvasR');

    var tasks = [_rndPage(p, cL)];
    if (!mob && p + 1 <= _total) {
        tasks.push(_rndPage(p + 1, cR));
    } else {
        cR.style.display = 'none'; cR.width = 0;
    }

    Promise.all(tasks).then(function() {
        _updateUI(p);
        _busy = false;
        _updateThumbs(p);
        if (cb) cb();
    }).catch(function() { _busy = false; });
}

/* ── RENDER DENGAN ANIMASI 3D FLIP (desktop only) ── */
function _renderFlip(p, dir) {
    if (_isMobile()) { _renderDirect(p); return; }

    var cL      = _el('fb2CanvasL');
    var cR      = _el('fb2CanvasR');
    var flipper = _el('fb2Flipper');
    var scene   = _el('fb2Scene');
    var flipF   = _el('fb2FlipFront');
    var flipB   = _el('fb2FlipBack');

    flipper.className = 'fb2-flipper';

    if (dir === 'next') {
        /* Flip canvas kanan menjadi halaman baru kiri */
        if (!cR.offsetWidth) { _busy = false; _renderDirect(p); return; }

        _copyCanvas(cR, flipF);

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
        cR.style.visibility = 'hidden';

        Promise.all([ _rndPage(p, flipB), _rndPage(p + 1, cR) ]).then(function() {
            flipB.style.width  = flipF.style.width;
            flipB.style.height = flipF.style.height;
            requestAnimationFrame(function() {
                requestAnimationFrame(function() {
                    flipper.style.transition = 'transform ' + FLIP_MS + 'ms cubic-bezier(0.77,0,0.175,1)';
                    flipper.style.transform  = 'rotateY(-180deg)';
                });
            });
            setTimeout(function() {
                flipper.style.transition = 'none';
                flipper.style.display    = 'none';
                flipper.className = 'fb2-flipper';
                cR.style.visibility = 'visible';
                _renderDirect(p);
            }, FLIP_MS + 80);
        }).catch(function() {
            flipper.style.display = 'none';
            cR.style.visibility = 'visible';
            _busy = false;
        });

    } else {
        /* Flip canvas kiri menjadi halaman baru kanan */
        if (!cL.offsetWidth) { _busy = false; _renderDirect(p); return; }

        _copyCanvas(cL, flipF);

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

        Promise.all([ _rndPage(p + 1, flipB), _rndPage(p, cL) ]).then(function() {
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
                flipper.className = 'fb2-flipper';
                cL.style.visibility = 'visible';
                _renderDirect(p);
            }, FLIP_MS + 80);
        }).catch(function() {
            flipper.style.display = 'none';
            cL.style.visibility = 'visible';
            _busy = false;
        });
    }
}

/* ── NAVIGASI ── */
function fb2Nav(dir) {
    if (!_pdf || _busy) return;
    var mob  = _isMobile();
    var step = mob ? 1 : 2;
    var newP = _snapPage(_page + dir * step);
    if (newP === _page) {
        newP = Math.max(1, Math.min(_total, _page + dir));
        if (newP === _page) return;
    }
    _busy = true; _page = newP;
    if (mob) _renderDirect(_page);
    else     _renderFlip(_page, dir > 0 ? 'next' : 'prev');
}

/* Goto halaman tertentu */
function fb2GoToPage(pageNum) {
    pageNum = parseInt(pageNum, 10);
    if (isNaN(pageNum) || pageNum < 1 || pageNum > _total) return;
    var newP = _isMobile() ? pageNum : _snapPage(pageNum);
    if (newP === _page) return;
    var dir = newP > _page ? 1 : -1;
    _busy = true; _page = newP;
    if (_isMobile()) _renderDirect(_page);
    else             _renderFlip(_page, dir > 0 ? 'next' : 'prev');
}

/* ── ZOOM ── */
function fb2ZoomIn() {
    if (!_pdf) return;
    _zoom = Math.min(_zoom + 0.2, 3.0);
    _busy = false; _renderDirect(_page);
}
function fb2ZoomOut() {
    if (!_pdf) return;
    _zoom = Math.max(_zoom - 0.2, 0.4);
    _busy = false; _renderDirect(_page);
}
function fb2ZoomReset() {
    if (!_pdf) return;
    _zoom = 1.0;
    _calcScale().then(function(s) { _scale = s; _busy = false; _renderDirect(_page); });
}

/* ── FULLSCREEN ── */
function fb2Fullscreen() {
    var el = _el('fb2Overlay');
    if (!document.fullscreenElement) {
        (el.requestFullscreen || el.webkitRequestFullscreen || function(){}).call(el);
    } else {
        (document.exitFullscreen || document.webkitExitFullscreen || function(){}).call(document);
    }
}

/* ── AUTO-PLAY ── */
function fb2ToggleAuto() {
    _autoOn = !_autoOn;
    var btn = _el('fb2AutoBtn');
    if (btn) btn.classList.toggle('active', _autoOn);
    if (_autoOn) {
        _autoTimer = setInterval(function() {
            if (_page + (_isMobile() ? 1 : 2) > _total) {
                fb2ToggleAuto(); return;
            }
            fb2Nav(1);
        }, 3500);
    } else {
        clearInterval(_autoTimer);
    }
}

/* ── THUMBNAIL ── */
function _buildThumbs() {
    var strip = _el('fb2Thumbs');
    if (!strip || !_pdf) return;
    strip.innerHTML = '';
    /* Tambahkan thumbnail per halaman */
    for (var i = 1; i <= _total; i++) {
        (function(pn) {
            var th  = document.createElement('div');
            th.className = 'fb2-thumb' + (pn === 1 ? ' active' : '');
            th.dataset.page = pn;

            var tc = document.createElement('canvas');
            tc.width = 50; tc.height = 70;
            th.appendChild(tc);

            var num = document.createElement('div');
            num.className = 'fb2-thumb-num';
            num.textContent = pn;
            th.appendChild(num);

            th.onclick = function() { fb2GoToPage(pn); };
            strip.appendChild(th);

            /* Render thumbnail */
            _pdf.getPage(pn).then(function(page) {
                var vp0   = page.getViewport({ scale: 1 });
                var scale = Math.min(50 / vp0.width, 70 / vp0.height);
                var vp    = page.getViewport({ scale: scale });
                tc.width = vp.width; tc.height = vp.height;
                page.render({ canvasContext: tc.getContext('2d'), viewport: vp }).promise;
            });
        })(i);
    }
}

function _updateThumbs(p) {
    document.querySelectorAll('.fb2-thumb').forEach(function(t) {
        var tp = parseInt(t.dataset.page, 10);
        var mob = _isMobile();
        var active = mob ? (tp === p) : (tp === p || tp === p + 1);
        t.classList.toggle('active', active);
        if (active) t.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
    });
}

/* ── SWIPE HINT ── */
function _showSwipeHint() {
    var hint = _el('fb2SwipeHint');
    hint.classList.add('visible');
    setTimeout(function() { hint.classList.add('fade'); }, 2400);
    setTimeout(function() { hint.classList.remove('visible', 'fade'); }, 3500);
}

/* ── OPEN FLIPBOOK (dipanggil dari book-card) ── */
function openFlipbook(url, title) {
    _el('fb2Title').textContent       = title || 'Dokumen';
    _el('fb2DownloadLink').href       = url;
    _el('fb2Overlay').classList.add('active');
    document.body.style.overflow = 'hidden';

    /* Reset state */
    _pdf = null; _total = 0; _page = 1;
    _busy = false; _zoom = 1.0;
    if (_autoOn) fb2ToggleAuto();

    /* Reset canvas */
    ['fb2CanvasL','fb2CanvasR','fb2FlipFront','fb2FlipBack'].forEach(function(id) {
        var c = _el(id);
        if (c.width > 0) c.getContext('2d').clearRect(0, 0, c.width, c.height);
        c.width = 0; c.height = 0; c.style.display = 'none';
    });
    _el('fb2Flipper').style.display = 'none';
    _el('fb2Flipper').className = 'fb2-flipper';
    _el('fb2Spine').style.display = 'none';
    _el('fb2Thumbs').innerHTML = '';
    _el('fb2PageInfo').textContent = 'Memuat...';

    /* Loading */
    var loadEl = _el('fb2Loading');
    loadEl.style.display = 'block';
    loadEl.textContent   = '';

    if (typeof pdfjsLib === 'undefined') {
        loadEl.textContent = 'PDF.js tidak ditemukan.'; return;
    }

    pdfjsLib.getDocument(url).promise.then(function(pdf) {
        _pdf   = pdf;
        _total = pdf.numPages;
        return _calcScale();
    }).then(function(s) {
        _scale = s;
        loadEl.style.display = 'none';
        _renderDirect(1, function() {
            _buildThumbs();
            if (_isMobile()) _showSwipeHint();
        });
    }).catch(function(err) {
        loadEl.textContent = 'Gagal memuat PDF. ' + (err.message || err);
        _busy = false;
    });
}

/* Alias: nama lama di kiri.php juga tetap berfungsi */
function openFlipbookHome(url, title) { openFlipbook(url, title); }

/* ── TUTUP ── */
function fb2Close() {
    _el('fb2Overlay').classList.remove('active');
    document.body.style.overflow = '';
    if (_autoOn) fb2ToggleAuto();

    ['fb2CanvasL','fb2CanvasR','fb2FlipFront','fb2FlipBack'].forEach(function(id) {
        var c = _el(id);
        if (c.width > 0) c.getContext('2d').clearRect(0, 0, c.width, c.height);
        c.width = 0; c.height = 0; c.style.display = 'none';
    });
    _el('fb2Flipper').style.display = 'none';
    _el('fb2Flipper').className = 'fb2-flipper';
    _el('fb2Spine').style.display = 'none';
    _pdf = null; _busy = false; _page = 1;
}

/* ── KEYBOARD ── */
document.addEventListener('keydown', function(e) {
    if (!_el('fb2Overlay').classList.contains('active')) return;
    switch (e.key) {
        case 'ArrowRight': fb2Nav(1);      break;
        case 'ArrowLeft':  fb2Nav(-1);     break;
        case 'Escape':     fb2Close();     break;
        case '+': case '=': fb2ZoomIn();  break;
        case '-':           fb2ZoomOut(); break;
        case '0':           fb2ZoomReset(); break;
    }
});

/* ── KLIK OVERLAY UNTUK TUTUP ── */
_el('fb2Overlay').addEventListener('click', function(e) {
    if (e.target === this) fb2Close();
});

/* ── DRAG-TO-PAN + MOMENTUM (desktop) ── */
(function() {
    var body = _el('fb2Body');
    if (!body) return;
    var isDown = false, lx, ly, velX = 0, velY = 0, rafId = null;
    var FRICTION = 0.85;

    function cancelMom() { if (rafId) { cancelAnimationFrame(rafId); rafId = null; } }
    function applyMom() {
        velX *= FRICTION; velY *= FRICTION;
        /* fb2Body tidak punya overflow scroll, jadi pan dilakukan via transformOrigin */
        if (Math.abs(velX) > 0.5 || Math.abs(velY) > 0.5) {
            rafId = requestAnimationFrame(applyMom);
        } else { rafId = null; }
    }

    function onDown(e) {
        if (_isMobile()) return;
        if (e.target.tagName === 'BUTTON' || e.target.tagName === 'A') return;
        cancelMom();
        isDown = true; velX = 0; velY = 0;
        var pt = e.touches ? e.touches[0] : e;
        lx = pt.clientX; ly = pt.clientY;
        body.classList.add('is-dragging');
        e.preventDefault();
    }
    function onMove(e) {
        if (!isDown || _isMobile()) return;
        e.preventDefault();
        var pt = e.touches ? e.touches[0] : e;
        velX = velX * 0.4 + (pt.clientX - lx) * 0.6;
        velY = velY * 0.4 + (pt.clientY - ly) * 0.6;
        lx = pt.clientX; ly = pt.clientY;
    }
    function onUp() {
        if (!isDown) return; isDown = false;
        body.classList.remove('is-dragging');
        if (Math.abs(velX) > 1.5 || Math.abs(velY) > 1.5) {
            rafId = requestAnimationFrame(applyMom);
        }
    }

    body.addEventListener('mousedown', onDown, { passive: false });
    document.addEventListener('mousemove', onMove, { passive: false });
    document.addEventListener('mouseup', onUp);

    /* Wheel zoom */
    body.addEventListener('wheel', function(e) {
        e.preventDefault();
        if (!_pdf) return;
        cancelMom();
        _zoom = Math.max(0.4, Math.min(3.0, _zoom + (e.deltaY < 0 ? 0.12 : -0.12)));
        _busy = false; _renderDirect(_page);
    }, { passive: false });
})();

/* ── SWIPE GESTURE (mobile) ── */
(function() {
    var body = _el('fb2Body');
    if (!body) return;
    var sx, sy, deciding, decidedAxis;

    body.addEventListener('touchstart', function(e) {
        if (e.touches.length !== 1) return;
        sx = e.touches[0].clientX;
        sy = e.touches[0].clientY;
        deciding = true; decidedAxis = null;
    }, { passive: true });

    body.addEventListener('touchmove', function(e) {
        if (!deciding && decidedAxis !== 'h') return;
        var dx = e.touches[0].clientX - sx;
        var dy = e.touches[0].clientY - sy;
        if (deciding && (Math.abs(dx) > 8 || Math.abs(dy) > 8)) {
            decidedAxis = Math.abs(dx) > Math.abs(dy) ? 'h' : 'v';
            deciding = false;
        }
        if (decidedAxis === 'h') e.preventDefault();
    }, { passive: false });

    body.addEventListener('touchend', function(e) {
        if (!_isMobile() || decidedAxis !== 'h') return;
        var dx = e.changedTouches[0].clientX - sx;
        if (Math.abs(dx) > 45) fb2Nav(dx < 0 ? 1 : -1);
    }, { passive: true });
})();

/* ── RESIZE: recalc scale ── */
(function() {
    var t;
    window.addEventListener('resize', function() {
        clearTimeout(t);
        t = setTimeout(function() {
            if (!_pdf || !_el('fb2Overlay').classList.contains('active')) return;
            _calcScale().then(function(s) { _scale = s; _busy = false; _renderDirect(_page); });
        }, 280);
    });
})();

/* ══════════════════════════════════════════
   DOKUMENTASI SLIDER
══════════════════════════════════════════ */
var _dIdx = 0;
var _dSlides = document.querySelectorAll('.dokum-slide');
function _dokRender() {
    document.getElementById('dokSlides').style.transform = 'translateX(-' + (_dIdx * 100) + '%)';
    document.querySelectorAll('.dokum-dot').forEach(function(d, i) {
        d.classList.toggle('active', i === _dIdx);
    });
}
function dokumNav(dir) { _dIdx = (_dIdx + dir + _dSlides.length) % _dSlides.length; _dokRender(); }
function dokumGo(i)    { _dIdx = i; _dokRender(); }
if (_dSlides.length > 1) setInterval(function() { dokumNav(1); }, 5000);

/* ══════════════════════════════════════════
   BOOKSHELF SEARCH
══════════════════════════════════════════ */
function filterBooks() {
    var q = document.getElementById('bookSearchInput').value.toLowerCase().trim();
    document.querySelectorAll('.book-card').forEach(function(card) {
        var title = card.querySelector('.book-title');
        if (!title) return;
        card.style.display = (title.textContent.toLowerCase().indexOf(q) !== -1) ? '' : 'none';
    });
}
</script>