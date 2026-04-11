<?php global $koneksi_db; ?>

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

/* ── GLOBAL OVERRIDES: sesuaikan elemen legacy ke palette hijau ── */

/* Tombol scroll-to-top */
a.scroll-top,
.scroll-top {
    background: #618D4F !important;
    border-color: #618D4F !important;
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(97,141,79,.35) !important;
}
a.scroll-top:hover,
.scroll-top:hover {
    background: #306238 !important;
    border-color: #306238 !important;
}

/* Blog-wrapper dari CMS template — hilangkan background dan padding */
.blog-wrapper {
    background: transparent !important;
    padding: 0 !important;
    margin: 0 !important;
}
.blog-left,
.blog-right {
    display: none !important; /* Sembunyikan sidebar & tengah di homepage */
}

/* Override warna aksen biru legacy */
.section-eyebrow { color: #618D4F !important; }
.dokum-dot.active { background: #306238 !important; }

/* Pastikan body background tidak override section kita */
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

/* ── TYPOGRAPHY HELPERS ── */
.lp-label {
    display: block;
    color: var(--moss-mid);
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2.5px;
    margin-bottom: 10px;
}
.lp-title {
    color: var(--moss-dark);
    font-size: 30px;
    font-weight: 800;
    line-height: 1.2;
    margin: 0 0 24px;
    letter-spacing: -.3px;
}
.lp-title--lg { font-size: 36px; }
.lp-divider {
    width: 48px;
    height: 3px;
    background: var(--moss-mid);
    border-radius: 2px;
    margin-bottom: 32px;
}

/* ── SECTION BASE ── */
.lp-section { padding: 72px 0; }

/* ══════════════════════════════════════════
   SECTION 1: PROGRAM CARDS
══════════════════════════════════════════ */
.prog-section {
    background: var(--white);
    padding: 0 0 20px;
}
.prog-section-head {
    text-align: center;
    padding: 60px 0 44px;
}
.prog-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
}
@media (max-width: 991px) { .prog-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 575px) { .prog-grid { grid-template-columns: 1fr; } }

.prog-card {
    background: var(--moss-dark);
    border-radius: var(--radius-md);
    padding: 28px 22px 52px;
    position: relative;
    cursor: pointer;
    transition: var(--transition);
    overflow: hidden;
    min-height: 200px;
    height: 100%;
    border-top: 4px solid var(--moss-mid);
}
.prog-card::after {
    content: '';
    position: absolute;
    bottom: 0; right: 0;
    width: 100px; height: 100px;
    background: rgba(255,255,255,.05);
    border-radius: 50%;
    transform: translate(30%, 30%);
}
.prog-card:hover {
    transform: translateY(-7px);
    box-shadow: var(--shadow-lg);
    background: var(--moss-mid);
}
.prog-card--alt  { background: var(--moss-olive); }
.prog-card--alt2 { background: var(--moss-mid); }
.prog-card--alt3 { background: #3d5a2e; }

.prog-card .pc-icon {
    width: 44px; height: 44px;
    background: rgba(255,255,255,.15);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 18px;
}
.prog-card .pc-icon svg { width: 22px; height: 22px; fill: #fff; }
.prog-card h3 {
    color: var(--white);
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin: 0 0 10px;
    line-height: 1.4;
}
.prog-card p {
    color: rgba(255,255,255,.80);
    font-size: 12.5px;
    line-height: 1.75;
    margin: 0;
}
.prog-card .pc-btn {
    position: absolute;
    bottom: -20px; left: 50%;
    transform: translateX(-50%);
    width: 44px; height: 44px;
    border-radius: 50%;
    background: var(--white);
    display: flex; align-items: center; justify-content: center;
    box-shadow: var(--shadow-md);
    text-decoration: none;
    transition: var(--transition);
    z-index: 2;
}
.prog-card .pc-btn svg { width: 16px; height: 16px; fill: var(--moss-dark); }
.prog-card .pc-btn:hover { box-shadow: var(--shadow-lg); transform: translateX(-50%) scale(1.12); text-decoration: none; }

/* Row wrapper to handle bottom overflow */
.prog-row-wrap { overflow: visible !important; padding-bottom: 48px; }
.prog-col { margin-bottom: 52px; padding: 0 12px; }

/* ══════════════════════════════════════════
   SECTION 2: SAMBUTAN
══════════════════════════════════════════ */
.sambutan-section {
    background: var(--moss-bg);
    padding: 72px 0;
    border-top: 1px solid rgba(97,141,79,.2);
}
.sambutan-media {
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    position: relative;
    background: var(--moss-dark);
    min-height: 300px;
    display: flex; align-items: center; justify-content: center;
}
.sambutan-media-placeholder {
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    min-height: 300px;
    padding: 40px;
}
.sambutan-media-placeholder p {
    color: rgba(255,255,255,.5);
    margin: 12px 0 0;
    font-size: 13px;
    text-align: center;
}
.play-icon-wrap {
    width: 64px; height: 64px;
    border-radius: 50%;
    background: rgba(255,255,255,.9);
    display: flex; align-items: center; justify-content: center;
    position: absolute; top: 50%; left: 50%;
    transform: translate(-50%,-50%);
    text-decoration: none;
    transition: var(--transition);
    box-shadow: 0 6px 24px rgba(0,0,0,.25);
}
.play-icon-wrap:hover { transform: translate(-50%,-50%) scale(1.1); box-shadow: 0 10px 32px rgba(0,0,0,.35); }
.play-icon-wrap svg { width: 24px; height: 24px; fill: var(--moss-dark); margin-left: 4px; }
.sambutan-text { padding-left: 40px; }
@media (max-width: 767px) { .sambutan-text { padding-left: 0; margin-top: 30px; } }
.sambutan-text .lp-title { font-size: 24px; }
.sambutan-text p { color: var(--text-muted); line-height: 1.85; font-size: 14.5px; }
.btn-primary-lp {
    display: inline-block;
    background: var(--moss-dark);
    color: var(--white);
    padding: 12px 30px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    letter-spacing: .2px;
    transition: var(--transition);
    margin-top: 24px;
    border: 2px solid var(--moss-dark);
}
.btn-primary-lp:hover {
    background: var(--moss-mid);
    border-color: var(--moss-mid);
    color: var(--white);
    text-decoration: none;
    box-shadow: var(--shadow-md);
}
.btn-outline-lp {
    display: inline-block;
    border: 2px solid var(--moss-dark);
    color: var(--moss-dark);
    padding: 11px 28px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: var(--transition);
    margin-top: 28px;
}
.btn-outline-lp:hover { background: var(--moss-dark); color: var(--white); text-decoration: none; }

/* ══════════════════════════════════════════
   SECTION 3: STATISTIK
══════════════════════════════════════════ */
.stats-section {
    background: linear-gradient(135deg, var(--moss-dark) 0%, var(--moss-olive) 100%);
    padding: 64px 0;
    position: relative;
    overflow: hidden;
}
.stats-section::before {
    content: '';
    position: absolute; top: -60px; right: -60px;
    width: 260px; height: 260px;
    border-radius: 50%;
    background: rgba(255,255,255,.04);
}
.stats-section::after {
    content: '';
    position: absolute; bottom: -80px; left: -40px;
    width: 320px; height: 320px;
    border-radius: 50%;
    background: rgba(255,255,255,.035);
}
.stat-item {
    text-align: center;
    padding: 24px 16px;
    position: relative;
    z-index: 1;
}
.stat-item + .stat-item {
    border-left: 1px solid rgba(255,255,255,.12);
}
@media (max-width: 575px) { .stat-item + .stat-item { border-left: none; border-top: 1px solid rgba(255,255,255,.12); } }
.stat-num {
    font-size: 48px;
    font-weight: 900;
    color: var(--moss-bg);
    display: block;
    line-height: 1;
    letter-spacing: -1px;
}
.stat-label {
    color: rgba(255,255,255,.75);
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-top: 8px;
    display: block;
}
.stat-line {
    width: 28px; height: 2px;
    background: var(--moss-light);
    margin: 10px auto 0;
    border-radius: 1px;
    opacity: .7;
}

/* ══════════════════════════════════════════
   SECTION 4: DOKUMENTASI KEGIATAN
══════════════════════════════════════════ */
.dokum-section {
    padding: 72px 0;
    background: var(--white);
}
.dokum-section .lp-title { text-align: center; }
.dokum-section .lp-label { text-align: center; display: block; }
.dokum-slider-wrap {
    position: relative;
    overflow: hidden;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg);
    max-width: 800px;
    margin: 0 auto;
}
.dokum-slides { display: flex; transition: transform .5s ease; will-change: transform; }
.dokum-slide { min-width: 100%; position: relative; }
.dokum-slide img { width: 100%; height: 420px; object-fit: cover; display: block; }
.dokum-slide-ph {
    width: 100%; height: 420px;
    background: linear-gradient(135deg, var(--moss-dark), var(--moss-mid));
    display: flex; align-items: center; justify-content: center; flex-direction: column;
}
.dokum-slide-ph svg { width: 64px; height: 64px; fill: rgba(255,255,255,.25); }
.dokum-slide-ph p { color: rgba(255,255,255,.45); margin: 12px 0 0; font-size: 13px; }
.dokum-slide-cap {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: linear-gradient(to top, rgba(30,45,32,.85), transparent);
    padding: 48px 28px 22px;
    color: var(--white);
}
.dokum-slide-cap h4 { margin: 0 0 4px; font-size: 17px; font-weight: 700; }
.dokum-slide-cap p { margin: 0; font-size: 12.5px; opacity: .8; }
.dokum-nav {
    position: absolute; top: 50%; transform: translateY(-50%);
    background: rgba(255,255,255,.18); border: 1px solid rgba(255,255,255,.3);
    color: var(--white); width: 42px; height: 42px;
    border-radius: 50%; font-size: 18px; cursor: pointer;
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

/* ══════════════════════════════════════════
   SECTION 5: TESTIMONI
══════════════════════════════════════════ */
.testi-section {
    padding: 72px 0;
    background: var(--moss-bg);
}
.testi-left h2 {
    font-size: 32px; font-weight: 900;
    color: var(--moss-dark); line-height: 1.2;
    margin: 0 0 16px; letter-spacing: -.3px;
}
.testi-left p { font-size: 14px; color: var(--text-muted); line-height: 1.8; margin: 0 0 24px; }
.testi-card {
    background: var(--white);
    border-radius: var(--radius-md);
    padding: 26px 28px;
    border-left: 3px solid var(--moss-mid);
    margin-bottom: 18px;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
}
.testi-card:hover { box-shadow: var(--shadow-md); transform: translateX(3px); }
.testi-card .testi-quote {
    font-size: 13.5px; color: var(--text-muted);
    line-height: 1.85; margin: 0 0 20px;
    font-style: italic; position: relative;
}
.testi-card .testi-quote::before {
    content: '\201C';
    font-size: 40px; color: var(--moss-light);
    line-height: 1; position: absolute;
    top: -8px; left: -4px; font-style: normal;
    font-family: Georgia, serif;
}
.testi-card .testi-quote--inner { padding-left: 24px; }
.testi-card .testi-person { display: flex; align-items: center; gap: 14px; }
.testi-avatar {
    width: 48px; height: 48px; border-radius: 50%;
    overflow: hidden; flex-shrink: 0;
    background: var(--moss-bg);
    display: flex; align-items: center; justify-content: center;
    border: 2px solid var(--moss-light);
}
.testi-avatar img { width: 100%; height: 100%; object-fit: cover; }
.testi-avatar svg { width: 24px; height: 24px; fill: var(--moss-mid); }
.testi-name { font-weight: 700; font-size: 13.5px; color: var(--moss-dark); }
.testi-role { font-size: 11.5px; color: var(--moss-light); font-weight: 500; margin-top: 2px; }

/* ══════════════════════════════════════════
   SECTION 6: PEDOMAN / BOOKSHELF
══════════════════════════════════════════ */
.bookshelf-section {
    background: var(--white);
    padding: 72px 0;
}
.bookshelf-section-head { text-align: center; margin-bottom: 40px; }
.bookshelf-row {
    position: relative;
    padding: 20px 20px 28px;
    margin-bottom: 36px;
    background: linear-gradient(to bottom, #c4a97e, #9e7a46);
    border-radius: 4px;
    border-bottom: 10px solid #6e4c1e;
    box-shadow: 0 8px 24px rgba(0,0,0,.2);
    display: flex; flex-wrap: wrap; gap: 18px;
    min-height: 160px; align-items: flex-end;
}
.bookshelf-row::before {
    content: '';
    position: absolute; bottom: -22px; left: -6px; right: -6px;
    height: 16px;
    background: linear-gradient(to bottom, #5c3b1a, #3d2510);
    border-radius: 0 0 5px 5px;
    box-shadow: 0 5px 10px rgba(0,0,0,.3);
}
.book-card {
    width: 96px; cursor: pointer;
    transition: transform .3s ease;
    position: relative; flex-shrink: 0; text-decoration: none;
}
.book-card:hover { transform: translateY(-12px) scale(1.05); text-decoration: none; }
.book-cover {
    width: 96px; height: 136px;
    border-radius: 2px 6px 6px 2px;
    overflow: hidden;
    box-shadow: -4px 4px 12px rgba(0,0,0,.35), inset -3px 0 5px rgba(0,0,0,.12);
    position: relative; background: var(--moss-dark);
}
.book-cover img { width: 100%; height: 100%; object-fit: cover; display: block; }
.book-spine {
    position: absolute; left: 0; top: 0; bottom: 0;
    width: 10px; background: rgba(0,0,0,.2);
    border-right: 1px solid rgba(255,255,255,.08);
}
.book-no-cover {
    display: flex; align-items: center; justify-content: center;
    width: 100%; height: 100%;
    background: linear-gradient(135deg, var(--moss-dark), var(--moss-mid));
    color: var(--white); font-size: 10px; text-align: center;
    padding: 8px; font-weight: 600; line-height: 1.4;
}
.book-hover-overlay {
    position: absolute; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(48,98,56,0); transition: background .3s;
    display: flex; align-items: center; justify-content: center;
    border-radius: 2px 6px 6px 2px;
}
.book-card:hover .book-hover-overlay { background: rgba(48,98,56,.55); }
.book-hover-overlay span {
    color: var(--white); font-size: 11px; font-weight: 700;
    opacity: 0; transition: opacity .3s; letter-spacing: .5px;
    text-transform: uppercase;
}
.book-card:hover .book-hover-overlay span { opacity: 1; }
.book-title {
    font-size: 9.5px; color: #3d2510; font-weight: 600;
    text-align: center; margin-top: 6px; line-height: 1.3;
    max-height: 2.6em; overflow: hidden;
}
.bookshelf-more { text-align: center; margin-top: 32px; }

/* ══════════════════════════════════════════
   SECTION 7: CTA BANNER
══════════════════════════════════════════ */
.cta-section {
    background: var(--moss-dark);
    padding: 60px 0;
    position: relative;
    overflow: hidden;
}
.cta-section::before {
    content: '';
    position: absolute; top: -80px; right: -80px;
    width: 360px; height: 360px; border-radius: 50%;
    background: rgba(255,255,255,.04);
}
.cta-section::after {
    content: '';
    position: absolute; bottom: -100px; left: 40%;
    width: 280px; height: 280px; border-radius: 50%;
    background: rgba(255,255,255,.03);
}
.cta-section .cta-inner { position: relative; z-index: 1; }
.cta-section h2 {
    color: var(--white);
    font-size: 26px; font-weight: 800;
    line-height: 1.4; margin: 0;
}
.cta-section h2 span { color: var(--moss-bg); }
.cta-badge {
    text-align: right;
}
.cta-badge-name {
    color: var(--white);
    font-size: 24px; font-weight: 900;
    letter-spacing: -1px; display: block;
}
.cta-badge-sub {
    color: var(--moss-light);
    font-size: 12.5px; display: block; margin-top: 4px;
    text-transform: uppercase; letter-spacing: 1.5px;
}

/* ══════════════════════════════════════════
   SECTION 8: BERITA & KEGIATAN
══════════════════════════════════════════ */
.news-section {
    padding: 72px 0;
    background: var(--moss-bg);
}
.news-card {
    background: var(--white);
    border-radius: var(--radius-md);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
    height: 100%; display: flex; flex-direction: column;
}
.news-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }
.nc-img { width: 100%; height: 196px; object-fit: cover; display: block; }
.nc-img-ph {
    width: 100%; height: 196px;
    background: linear-gradient(135deg, var(--moss-dark), var(--moss-mid));
    display: flex; align-items: center; justify-content: center;
}
.nc-img-ph svg { width: 52px; height: 52px; fill: rgba(255,255,255,.25); }
.nc-body { padding: 20px; flex: 1; display: flex; flex-direction: column; }
.nc-cat {
    display: inline-block;
    background: var(--moss-bg);
    color: var(--moss-dark);
    font-size: 10.5px; font-weight: 700;
    padding: 3px 10px; border-radius: 20px;
    margin-bottom: 11px; text-transform: uppercase; letter-spacing: .8px;
}
.nc-body h3 { font-size: 14.5px; font-weight: 700; color: var(--text-dark); margin: 0 0 10px; line-height: 1.55; flex: 1; }
.nc-body h3 a { color: inherit; text-decoration: none; }
.nc-body h3 a:hover { color: var(--moss-dark); }
.nc-meta {
    font-size: 11.5px; color: #9aab9c;
    margin-top: auto; padding-top: 12px;
    border-top: 1px solid #f0f4ed;
    display: flex; gap: 6px; align-items: center;
}

/* ══════════════════════════════════════════
   FLIPBOOK MODAL
══════════════════════════════════════════ */
.flipbook-modal-overlay {
    display: none; position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(10,20,12,.88);
    z-index: 9999; align-items: center; justify-content: center;
}
.flipbook-modal-overlay.active { display: flex; }
.flipbook-modal {
    background: var(--text-dark);
    border-radius: var(--radius-md);
    width: 90vw; max-width: 1000px; height: 88vh;
    display: flex; flex-direction: column;
    overflow: hidden;
    box-shadow: 0 30px 80px rgba(0,0,0,.65);
}
.flipbook-modal-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 20px;
    background: var(--moss-dark);
    border-radius: var(--radius-md) var(--radius-md) 0 0;
}
.flipbook-modal-header h4 {
    color: var(--white); margin: 0; font-size: 15px;
    font-weight: 600; flex: 1; padding-right: 10px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.btn-close-flipbook {
    background: rgba(255,255,255,.15); border: none; color: var(--white);
    font-size: 18px; line-height: 1; border-radius: 50%;
    width: 32px; height: 32px; cursor: pointer; transition: var(--transition); flex-shrink: 0;
}
.btn-close-flipbook:hover { background: rgba(255,255,255,.35); }
.flipbook-modal-toolbar {
    display: flex; align-items: center; justify-content: center;
    gap: 8px; padding: 10px 20px;
    background: #101e12;
    border-bottom: 1px solid rgba(255,255,255,.08);
    flex-wrap: wrap;
}
.flipbook-modal-toolbar button {
    background: var(--moss-mid); color: var(--white); border: none;
    border-radius: var(--radius-sm); padding: 6px 14px; font-size: 12.5px;
    cursor: pointer; transition: var(--transition);
}
.flipbook-modal-toolbar button:hover { background: var(--moss-dark); }
.flipbook-modal-toolbar .page-info { color: #8ea090; font-size: 12.5px; min-width: 100px; text-align: center; }
.flipbook-canvas-wrap {
    flex: 1; overflow: hidden;
    display: flex; align-items: center; justify-content: center;
    background: #0a120b; position: relative;
}
.flipbook-pages-container {
    display: flex; gap: 4px;
    align-items: center; justify-content: center;
    height: 100%; transition: opacity .3s ease;
}
.flipbook-canvas-wrap canvas { box-shadow: 0 0 24px rgba(0,0,0,.5); max-height: 100%; border-radius: 2px; display: block; }
.flipbook-download-link {
    display: block; text-align: center; padding: 10px;
    background: #101e12; color: var(--moss-light); font-size: 13px;
    text-decoration: none; border-top: 1px solid rgba(255,255,255,.08);
}
.flipbook-download-link:hover { color: var(--moss-bg); text-decoration: none; }
.flipbook-loading { position: absolute; color: #6a8c6e; font-size: 14px; }
</style>

<!-- ============================================================
     SECTION 1: PROGRAM MBKM (dari database halaman)
     ============================================================ -->
<?php
// Ambil semua halaman program (id 2-9) dalam satu query
$q_prog = $koneksi_db->sql_query("SELECT * FROM halaman WHERE id IN (2,3,4,5,6,7,8,9) ORDER BY id ASC");
$programs = [];
while ($p = $koneksi_db->sql_fetchrow($q_prog)) $programs[] = $p;
$prog_count = count($programs);

// Warna dan ikon untuk tiap urutan card
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

// Fungsi bersihkan teks konten: strip tags → decode entities aman → strip emoji → clean whitespace
function cleanProgText($str) {
    // 1. Strip tags HTML
    $str = strip_tags($str);
    // 2. Decode entity HTML umum secara aman (tanpa html_entity_decode yg bisa corrupt UTF-8)
    $str = str_replace(
        ['&nbsp;','&amp;','&lt;','&gt;','&quot;','&#39;','&mdash;','&ndash;','&bull;'],
        [' ',     '&',   '<',   '>',   '"',    "'",    '—',      '–',      '•'],
        $str
    );
    // 3. Strip emoji dan simbol unicode special
    $str = preg_replace('/[\x{1F000}-\x{1FFFF}]/u', '', $str);
    $str = preg_replace('/[\x{2600}-\x{27FF}]/u', '', $str);
    $str = preg_replace('/[\x{FE00}-\x{FE0F}]/u', '', $str);
    // 4. Bersihkan whitespace berulang
    $str = preg_replace('/\s+/', ' ', $str);
    return trim($str);
}
?>
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
    </div><!-- end row -->
    <?php else: ?>
    <p style="text-align:center; color:#9EBB97; padding:40px 0;">Program belum tersedia.</p>
    <?php endif; ?>
</div><!-- end container -->
</section>


<!-- ============================================================
     SECTION 2: SAMBUTAN
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
                <span class="lp-label">Sambutan Pimpinan</span>
                <?php
                $sam = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM halaman WHERE id='1'"));
                if ($sam):
                    $urlkat = str_replace(" ", "-", $sam['judul']);
                ?>
                <h2 class="lp-title"><?= htmlspecialchars($sam['judul']) ?></h2>
                <div class="lp-divider"></div>
                <p><?= limitTXT(strip_tags($sam['konten']), 460) ?></p>
                <a href="pages/<?= $sam['id'] ?>/<?= $urlkat ?>.html" class="btn-primary-lp">Baca Selengkapnya</a>
                <?php else: ?>
                <h2 class="lp-title">Sambutan Pimpinan MBKM<br>IAI PI Bandung</h2>
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
                    ['jum'=>'8','nama'=>'Program MBKM'],
                    ['jum'=>'95%','nama'=>'Tingkat Kepuasan'],
                ];
            endif;
            foreach ($stats as $s):
            ?>
            <div class="col-xs-6 col-sm-3">
                <div class="stat-item">
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
                    $img_src  = $is_real ? 'images/foto/'.$d['foto'] : '';
                    $title    = $is_real ? htmlspecialchars($d['nama']) : $d['title'];
                    $sub_cap  = $is_real ? '' : $d['sub'];
                ?>
                <div class="dokum-slide">
                    <?php if ($img_src): ?>
                    <img src="<?= $img_src ?>" alt="<?= $title ?>">
                    <?php else: ?>
                    <div class="dokum-slide-ph">
                        <svg viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                        <p>Foto Dokumentasi <?= $idx+1 ?></p>
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
     ============================================================ -->
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

<section class="bookshelf-section">
    <div class="container">
        <div class="bookshelf-section-head">
            <span class="lp-label">Referensi</span>
            <h2 class="lp-title lp-title--lg">PEDOMAN MBKM IAI PI BANDUNG</h2>
            <div class="lp-divider" style="margin:0 auto;"></div>
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