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
   FLIPBOOK PREMIUM - SPREAD VIEW (2 halaman) + COVER SINGLE
   ============================================================ */
.fb2-overlay {
    display: none; position: fixed; inset: 0; z-index: 99999;
    background: rgba(0,0,0,.88); backdrop-filter: blur(8px);
    align-items: center; justify-content: center;
}
.fb2-overlay.active { display: flex; }
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

.fb2-header {
    height: 52px; background: #fff;
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 20px; flex-shrink: 0; border-bottom: 1px solid #eee;
}
.fb2-header h4 {
    margin: 0; font-size: 14px; font-weight: 600; color: #222;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap; flex: 1; padding-right: 16px;
}
.fb2-header-actions { display: flex; gap: 8px; align-items: center; }
.fb2-hbtn {
    width: 32px; height: 32px; border-radius: 6px;
    border: 1px solid #ddd; background: #f5f5f5; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: #444; transition: background .15s;
}
.fb2-hbtn:hover { background: #e8e8e8; }
.fb2-close-btn {
    background: transparent; border: none; font-size: 26px; line-height: 1;
    cursor: pointer; color: #888; padding: 4px 6px; transition: color .15s;
}
.fb2-close-btn:hover { color: #d32f2f; }

.fb2-body {
    flex: 1; display: flex; align-items: center; justify-content: center;
    padding: 24px 64px; position: relative; overflow: hidden;
    background: #1a1a1a; min-height: 400px;
}
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
    .fb2-body { padding: 16px 12px; }
}

.fb2-spread {
    display: flex; position: relative;
    box-shadow: 0 8px 50px rgba(0,0,0,.75);
    transition: transform .3s cubic-bezier(.2,.8,.2,1);
    transform-origin: center center;
}
.fb2-page { background: #fff; display: block; }
.fb2-page-left  { border-radius: 4px 0 0 4px; box-shadow: inset -5px 0 14px rgba(0,0,0,.18); }
.fb2-page-right { border-radius: 0 4px 4px 0; box-shadow: inset  5px 0 14px rgba(0,0,0,.18); }
.fb2-page-cover {
    border-radius: 6px;
    box-shadow: -6px 6px 30px rgba(0,0,0,.5), 4px 4px 0 rgba(0,0,0,.15);
}
.fb2-spine {
    width: 14px; flex-shrink: 0; align-self: stretch;
    background: linear-gradient(to right, rgba(0,0,0,.4), rgba(0,0,0,.12), rgba(255,255,255,.06));
}

/* Flip animation layers */
.fb2-flip-layer {
    position: absolute; top: 0; z-index: 20;
    transform-origin: left center; pointer-events: none; background: #fff;
    box-shadow: -4px 0 16px rgba(0,0,0,.3);
}
@keyframes fb2FlipFwd {
    0%   { transform: perspective(1400px) rotateY(0deg);    opacity: 1; }
    60%  { opacity: 0.5; }
    100% { transform: perspective(1400px) rotateY(-115deg); opacity: 0; }
}
@keyframes fb2FlipBack {
    0%   { transform: perspective(1400px) rotateY(-115deg); opacity: 0; }
    40%  { opacity: 0.5; }
    100% { transform: perspective(1400px) rotateY(0deg);    opacity: 1; }
}
.fb2-anim-fwd  { animation: fb2FlipFwd  .55s cubic-bezier(.4,0,.2,1) forwards; }
.fb2-anim-back { animation: fb2FlipBack .55s cubic-bezier(.4,0,.2,1) forwards; }

#fb2Loading {
    display: none; position: absolute;
    background: rgba(0,0,0,.65); color: #ddd;
    padding: 10px 24px; border-radius: 24px;
    font-size: 13px; font-weight: 600; z-index: 30;
}

.fb2-toolbar {
    display: flex; align-items: center; justify-content: center;
    gap: 8px; padding: 10px 20px;
    background: #111; flex-shrink: 0;
    border-top: 1px solid rgba(255,255,255,.06);
}
.fb2-page-info {
    background: rgba(255,255,255,.1); color: #ddd;
    font-size: 12px; font-weight: 600;
    padding: 5px 16px; border-radius: 20px;
    letter-spacing: .5px; min-width: 90px; text-align: center;
}
.fb2-tbtn {
    width: 34px; height: 34px; border-radius: 50%;
    background: rgba(255,255,255,.1); border: none; color: #ccc; cursor: pointer;
    display: flex; align-items: center; justify-content: center; transition: all .18s;
}
.fb2-tbtn:hover { background: rgba(255,255,255,.22); color: #fff; }
.fb2-tbtn.active { color: #618D4F; background: rgba(97,141,79,.2); }
.fb2-vdivider { width: 1px; height: 22px; background: rgba(255,255,255,.12); margin: 0 4px; }

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
.fb2-thumb.active { border-color: #618D4F; }
.fb2-thumb canvas { width: 100%; height: 100%; display: block; object-fit: contain; }
.fb2-thumb-num {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: rgba(0,0,0,.65); color: #ccc;
    font-size: 9px; text-align: center; padding: 2px 0;
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
                <p>Program MBKM (Merdeka Belajar Kampus Merdeka) di IAI PI Bandung hadir sebagai wujud komitmen kami dalam memberikan pengalaman belajar yang bermakna dan berdampak nyata bagi mahasiswa. Kami mengundang seluruh civitas akademika untuk aktif berpartisipasi dalam program-program MBKM yang telah kami rancang dengan penuh dedikasi.</p>
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
     SECTION 6: PEDOMAN FLIPBOOK (BOOKSHELF) - SPREAD VIEW
     ============================================================ -->

<!-- MODAL FLIPBOOK PREMIUM -->
<div class="fb2-overlay" id="fb2Overlay">
<div class="fb2-container">

    <!-- Header -->
    <div class="fb2-header">
        <h4 id="fb2Title">Dokumen</h4>
        <div class="fb2-header-actions">
            <button class="fb2-hbtn" onclick="fb2ZoomIn()" title="Zoom In">
                <svg width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M15.5 14h-.79l-.28-.27A6.5 6.5 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99 1.49-1.49-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14zm.5-7H9v2H7v1h2v2h1v-2h2V9h-2V7z"/></svg>
            </button>
            <button class="fb2-hbtn" onclick="fb2ZoomOut()" title="Zoom Out">
                <svg width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M15.5 14h-.79l-.28-.27A6.5 6.5 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99 1.49-1.49-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14zM7 9h5v1H7z"/></svg>
            </button>
            <button class="fb2-hbtn" onclick="fb2Fullscreen()" title="Fullscreen">
                <svg width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/></svg>
            </button>
            <a id="fb2DownloadLink" href="#" target="_blank" class="fb2-hbtn" title="Download PDF" style="text-decoration:none;">
                <svg width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
            </a>
            <button class="fb2-close-btn" onclick="fb2Close()">&times;</button>
        </div>
    </div>

    <!-- Body: spread view -->
    <div class="fb2-body" id="fb2Body">
        <button class="fb2-nav prev" onclick="fb2Go(-1)">
            <svg width="22" height="22" viewBox="0 0 24 24"><path fill="currentColor" d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
        </button>

        <!-- Spread: left page + spine + right page (atau cover single) -->
        <div class="fb2-spread" id="fb2Spread">
            <canvas class="fb2-page fb2-page-left"  id="fb2CanvasL" width="240" height="340"></canvas>
            <div class="fb2-spine" id="fb2Spine"></div>
            <canvas class="fb2-page fb2-page-right" id="fb2CanvasR" width="240" height="340"></canvas>
        </div>

        <div id="fb2Loading">Memuat dokumen...</div>

        <button class="fb2-nav next" onclick="fb2Go(1)">
            <svg width="22" height="22" viewBox="0 0 24 24"><path fill="currentColor" d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
        </button>
    </div>

    <!-- Toolbar bawah -->
    <div class="fb2-toolbar">
        <button class="fb2-tbtn" onclick="fb2Go(-1)" title="Sebelumnya">
            <svg width="17" height="17" viewBox="0 0 24 24"><path fill="currentColor" d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
        </button>
        <div class="fb2-page-info" id="fb2PageInfo">Cover</div>
        <button class="fb2-tbtn" onclick="fb2Go(1)" title="Berikutnya">
            <svg width="17" height="17" viewBox="0 0 24 24"><path fill="currentColor" d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
        </button>
        <div class="fb2-vdivider"></div>
        <button class="fb2-tbtn" id="fb2AutoBtn" onclick="fb2ToggleAuto()" title="Auto-play">
            <svg width="17" height="17" viewBox="0 0 24 24"><path fill="currentColor" d="M8 5v14l11-7z"/></svg>
        </button>
        <div class="fb2-vdivider"></div>
        <!-- Input halaman manual -->
        <input type="number" id="fb2PageInput" min="1" value="1"
            style="width:48px;height:30px;border-radius:6px;border:1px solid rgba(255,255,255,.2);
                   background:rgba(255,255,255,.08);color:#ddd;text-align:center;font-size:12px;outline:none;"
            onkeydown="if(event.key==='Enter') fb2GoToPage(this.value)">
        <button class="fb2-tbtn" onclick="fb2GoToPage(document.getElementById('fb2PageInput').value)" style="width:auto;padding:0 10px;border-radius:6px;font-size:11px;">Go</button>
    </div>

    <!-- Thumbnail strip -->
    <div class="fb2-thumbs" id="fb2Thumbs"></div>

</div>
</div>

<!-- BOOKSHELF SECTION -->
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
                    echo '<div class="book-card" onclick="openFlipbookHome(\''.addslashes($pf).'\',\''.addslashes($jd).'\')">
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

/* ══════════════════════════════════════════
   FLIPBOOK ENGINE - SPREAD VIEW
   Spread 0         = Cover (halaman 1, single, centered)
   Spread 1         = halaman 2 (kiri) + halaman 3 (kanan)
   Spread 2         = halaman 4 (kiri) + halaman 5 (kanan)
   dst...
══════════════════════════════════════════ */
var FB2 = {
    pdf:      null,
    total:    0,
    spread:   0,      /* spread index saat ini */
    zoom:     1,
    anim:     false,
    autoOn:   false,
    autoTimer: null
};

/* Total jumlah spread */
function fb2TotalSpreads() {
    if (!FB2.total) return 0;
    /* spread 0 = cover (1 halaman), lalu tiap spread berikutnya = 2 halaman */
    return Math.ceil((FB2.total - 1) / 2) + 1;
}

/* Halaman-halaman dalam satu spread */
function fb2SpreadPages(s) {
    if (s === 0) return { left: 1,   right: null }; /* cover single */
    var base = (s - 1) * 2 + 2;                     /* hal 2, 4, 6 ... */
    return { left: base, right: base + 1 };
}

/* Render satu halaman PDF ke canvas; pageNum=0 → blank */
function fb2RenderToCanvas(pageNum, canvas, done) {
    if (!FB2.pdf || pageNum < 1 || pageNum > FB2.total) {
        var ctx = canvas.getContext('2d');
        ctx.fillStyle = '#f8f8f8';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        /* garis tepi halaman blank */
        ctx.strokeStyle = '#e0e0e0';
        ctx.lineWidth = 1;
        ctx.strokeRect(0, 0, canvas.width, canvas.height);
        if (done) done();
        return;
    }
    FB2.pdf.getPage(pageNum).then(function(page) {
        var vp0  = page.getViewport({ scale: 1 });
        /* hitung skala agar muat di viewport, maks 3× */
        var maxH = window.innerHeight * 0.68;
        var maxW = (window.innerWidth < 768)
            ? window.innerWidth * 0.80         /* mobile: hampir full width */
            : window.innerWidth * 0.36;        /* desktop: setengah spread */
        var scale = Math.min(maxW / vp0.width, maxH / vp0.height, 3);
        var vp    = page.getViewport({ scale: scale });
        canvas.width  = vp.width;
        canvas.height = vp.height;
        page.render({ canvasContext: canvas.getContext('2d'), viewport: vp })
            .promise.then(function() { if (done) done(); });
    }).catch(function() {
        if (done) done();
    });
}

/* Update info halaman di toolbar */
function fb2UpdateInfo() {
    var el = document.getElementById('fb2PageInfo');
    var inp = document.getElementById('fb2PageInput');
    if (FB2.spread === 0) {
        el.textContent = 'Cover';
        if (inp) inp.value = 1;
        return;
    }
    var pp = fb2SpreadPages(FB2.spread);
    var p2show = (pp.right && pp.right <= FB2.total) ? '–' + pp.right : '';
    el.textContent = pp.left + p2show + ' / ' + FB2.total;
    if (inp) inp.value = pp.left;
}

/* Update highlight thumbnail */
function fb2UpdateThumbs() {
    document.querySelectorAll('.fb2-thumb').forEach(function(t, i) {
        t.classList.toggle('active', i === FB2.spread);
        if (i === FB2.spread) {
            t.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        }
    });
}

/* Render spread ke canvas + animasi flip opsional
   dir: +1 = maju, -1 = mundur */
function fb2ShowSpread(s, doAnim, dir, cb) {
    if (FB2.anim) return;
    var ts = fb2TotalSpreads();
    if (s < 0 || s >= ts) return;

    var spreadEl = document.getElementById('fb2Spread');
    var canL     = document.getElementById('fb2CanvasL');
    var canR     = document.getElementById('fb2CanvasR');
    var spine    = document.getElementById('fb2Spine');

    /* Fungsi render tanpa animasi */
    function doRender() {
        var isCover = (s === 0);
        var coverC  = document.getElementById('fb2CoverCanvas');

        if (isCover) {
            /* Tampilkan hanya cover, sembunyikan spread */
            canL.style.display  = 'none';
            spine.style.display = 'none';
            canR.style.display  = 'none';

            if (!coverC) {
                coverC    = document.createElement('canvas');
                coverC.id = 'fb2CoverCanvas';
                coverC.className = 'fb2-page fb2-page-cover';
                coverC.width  = 240;
                coverC.height = 340;
                spreadEl.appendChild(coverC);
            }
            coverC.style.display = 'block';

            /* Render cover dengan ukuran sedikit lebih besar */
            FB2.pdf.getPage(1).then(function(page) {
                var vp0 = page.getViewport({ scale: 1 });
                var maxH = window.innerHeight * 0.70;
                var maxW = (window.innerWidth < 768)
                    ? window.innerWidth * 0.75
                    : window.innerWidth * 0.30;
                var scale = Math.min(maxW / vp0.width, maxH / vp0.height, 3);
                var vp = page.getViewport({ scale: scale });
                coverC.width  = vp.width;
                coverC.height = vp.height;
                page.render({ canvasContext: coverC.getContext('2d'), viewport: vp })
                    .promise.then(function() {
                        FB2.spread = s;
                        fb2UpdateInfo();
                        fb2UpdateThumbs();
                        if (cb) cb();
                    });
            });

        } else {
            /* Tampilkan spread dua halaman */
            canL.style.display  = 'block';
            spine.style.display = 'block';
            canR.style.display  = 'block';
            if (coverC) coverC.style.display = 'none';

            var pp   = fb2SpreadPages(s);
            var done = 0;
            function chk() {
                if (++done === 2) {
                    FB2.spread = s;
                    fb2UpdateInfo();
                    fb2UpdateThumbs();
                    if (cb) cb();
                }
            }
            fb2RenderToCanvas(pp.left,                             canL, chk);
            fb2RenderToCanvas(pp.right <= FB2.total ? pp.right : 0, canR, chk);
        }
    }

    if (!doAnim) { doRender(); return; }

    /* ── Animasi flip ── */
    FB2.anim = true;

    /* Snapshot canvas sumber flip */
    var srcCanvas = (dir > 0) ? canR : canL;
    var isCoverSrc = (FB2.spread === 0);
    if (isCoverSrc) srcCanvas = document.getElementById('fb2CoverCanvas') || canR;

    var flipW = srcCanvas.offsetWidth  || srcCanvas.width  || 240;
    var flipH = srcCanvas.offsetHeight || srcCanvas.height || 340;

    var flip   = document.createElement('canvas');
    flip.className = 'fb2-flip-layer';
    flip.width  = srcCanvas.width  || 240;
    flip.height = srcCanvas.height || 340;
    flip.style.width  = flipW + 'px';
    flip.style.height = flipH + 'px';
    flip.style.top    = '0';

    if (dir > 0) {
        /* Flip dari kanan ke kiri */
        var lw = canL.offsetWidth || 240;
        flip.style.left = lw + spine.offsetWidth + 'px';
        flip.style.transformOrigin = 'left center';
        flip.getContext('2d').drawImage(srcCanvas, 0, 0, flip.width, flip.height);
        spreadEl.appendChild(flip);

        /* Render halaman baru di belakang animasi */
        doRender();

        requestAnimationFrame(function() {
            flip.classList.add('fb2-anim-fwd');
        });
        setTimeout(function() {
            flip.remove();
            FB2.anim = false;
        }, 600);

    } else {
        /* Flip dari kiri ke kanan */
        flip.style.right = (canR.offsetWidth || 240) + 'px';
        flip.style.left  = 'auto';
        flip.style.transformOrigin = 'right center';
        flip.getContext('2d').drawImage(srcCanvas, 0, 0, flip.width, flip.height);
        spreadEl.appendChild(flip);

        doRender();

        requestAnimationFrame(function() {
            flip.classList.add('fb2-anim-back');
        });
        setTimeout(function() {
            flip.remove();
            FB2.anim = false;
        }, 600);
    }
}

/* Navigasi spread */
function fb2Go(dir) {
    var next = FB2.spread + dir;
    if (next < 0 || next >= fb2TotalSpreads()) return;
    fb2ShowSpread(next, true, dir);
}

/* Goto halaman tertentu (konversi ke spread) */
function fb2GoToPage(pageNum) {
    pageNum = parseInt(pageNum, 10);
    if (isNaN(pageNum) || pageNum < 1 || pageNum > FB2.total) return;
    var targetSpread = (pageNum === 1) ? 0 : Math.ceil((pageNum - 1) / 2);
    var dir = targetSpread >= FB2.spread ? 1 : -1;
    fb2ShowSpread(targetSpread, true, dir);
}

/* Zoom */
function fb2ZoomIn() {
    FB2.zoom = Math.min(FB2.zoom + 0.2, 2.5);
    document.getElementById('fb2Spread').style.transform = 'scale(' + FB2.zoom + ')';
}
function fb2ZoomOut() {
    FB2.zoom = Math.max(FB2.zoom - 0.2, 0.4);
    document.getElementById('fb2Spread').style.transform = 'scale(' + FB2.zoom + ')';
}

/* Fullscreen */
function fb2Fullscreen() {
    var el = document.getElementById('fb2Overlay');
    if (!document.fullscreenElement) {
        (el.requestFullscreen || el.webkitRequestFullscreen || function(){}).call(el);
    } else {
        (document.exitFullscreen || document.webkitExitFullscreen || function(){}).call(document);
    }
}

/* Auto-play */
function fb2ToggleAuto() {
    FB2.autoOn = !FB2.autoOn;
    var btn = document.getElementById('fb2AutoBtn');
    btn.classList.toggle('active', FB2.autoOn);
    if (FB2.autoOn) {
        FB2.autoTimer = setInterval(function() {
            if (FB2.spread + 1 >= fb2TotalSpreads()) {
                fb2ToggleAuto(); return;
            }
            fb2Go(1);
        }, 3500);
    } else {
        clearInterval(FB2.autoTimer);
    }
}

/* Bangun thumbnail strip */
function fb2BuildThumbs() {
    var strip = document.getElementById('fb2Thumbs');
    strip.innerHTML = '';
    var ts = fb2TotalSpreads();
    for (var i = 0; i < ts; i++) {
        (function(si) {
            var th  = document.createElement('div');
            th.className = 'fb2-thumb' + (si === 0 ? ' active' : '');

            var tc  = document.createElement('canvas');
            tc.width = 50; tc.height = 70;
            th.appendChild(tc);

            var num = document.createElement('div');
            num.className = 'fb2-thumb-num';
            if (si === 0) {
                num.textContent = 'Cover';
            } else {
                var pp = fb2SpreadPages(si);
                num.textContent = pp.left + (pp.right <= FB2.total ? '-' + pp.right : '');
            }
            th.appendChild(num);

            th.onclick = function() {
                fb2ShowSpread(si, true, si > FB2.spread ? 1 : -1);
            };
            strip.appendChild(th);

            /* Render thumbnail kecil */
            var pn = (si === 0) ? 1 : fb2SpreadPages(si).left;
            if (FB2.pdf && pn >= 1 && pn <= FB2.total) {
                FB2.pdf.getPage(pn).then(function(page) {
                    var vp0   = page.getViewport({ scale: 1 });
                    var scale = Math.min(50 / vp0.width, 70 / vp0.height);
                    var vp    = page.getViewport({ scale: scale });
                    tc.width  = vp.width;
                    tc.height = vp.height;
                    page.render({ canvasContext: tc.getContext('2d'), viewport: vp }).promise;
                });
            }
        })(i);
    }
}

/* Tutup flipbook */
function fb2Close() {
    document.getElementById('fb2Overlay').classList.remove('active');
    document.body.style.overflow = '';
    FB2.pdf  = null;
    FB2.total = 0;
    if (FB2.autoOn) fb2ToggleAuto();
    /* Bersihkan cover canvas agar tidak muncul lagi di buku lain */
    var cc = document.getElementById('fb2CoverCanvas');
    if (cc) cc.remove();
}

/* Buka flipbook — dipanggil dari book-card onclick */
function openFlipbookHome(url, title) {
    document.getElementById('fb2Title').textContent       = title || 'Dokumen';
    document.getElementById('fb2DownloadLink').href       = url;
    document.getElementById('fb2Overlay').classList.add('active');
    document.body.style.overflow = 'hidden';

    var loadEl = document.getElementById('fb2Loading');
    loadEl.style.display = 'block';
    loadEl.textContent   = 'Memuat dokumen...';

    /* Reset state */
    FB2.pdf    = null;
    FB2.total  = 0;
    FB2.spread = 0;
    FB2.zoom   = 1;
    FB2.anim   = false;
    document.getElementById('fb2Spread').style.transform = 'scale(1)';

    /* Sembunyikan/hapus cover canvas lama */
    var cc = document.getElementById('fb2CoverCanvas');
    if (cc) cc.remove();

    /* Sembunyikan canvas L/R dulu */
    document.getElementById('fb2CanvasL').style.display  = 'none';
    document.getElementById('fb2Spine').style.display    = 'none';
    document.getElementById('fb2CanvasR').style.display  = 'none';

    if (typeof pdfjsLib === 'undefined') {
        loadEl.textContent = 'PDF.js tidak ditemukan.'; return;
    }

    pdfjsLib.getDocument(url).promise.then(function(pdf) {
        FB2.pdf   = pdf;
        FB2.total = pdf.numPages;
        loadEl.style.display = 'none';
        /* Render cover dulu, lalu bangun thumbs */
        fb2ShowSpread(0, false, 1, function() {
            fb2BuildThumbs();
        });
    }).catch(function(err) {
        loadEl.textContent = 'Gagal memuat PDF. ' + (err.message || err);
    });
}

/* ── Event: klik overlay untuk tutup ── */
document.getElementById('fb2Overlay').addEventListener('click', function(e) {
    if (e.target === this) fb2Close();
});

/* ── Keyboard shortcuts ── */
document.addEventListener('keydown', function(e) {
    if (!document.getElementById('fb2Overlay').classList.contains('active')) return;
    switch (e.key) {
        case 'ArrowRight': fb2Go(1);     break;
        case 'ArrowLeft':  fb2Go(-1);    break;
        case 'Escape':     fb2Close();   break;
        case '+': case '=': fb2ZoomIn(); break;
        case '-':           fb2ZoomOut();break;
    }
});

/* ── Touch swipe di body ── */
(function() {
    var body = document.getElementById('fb2Body');
    if (!body) return;
    var sx = 0;
    body.addEventListener('touchstart', function(e) {
        sx = e.touches[0].clientX;
    }, { passive: true });
    body.addEventListener('touchend', function(e) {
        var dx = e.changedTouches[0].clientX - sx;
        if (Math.abs(dx) > 50) { dx < 0 ? fb2Go(1) : fb2Go(-1); }
    }, { passive: true });
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