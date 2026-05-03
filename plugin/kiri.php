<?php global $koneksi_db; ?>

<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
    prefix: 'tw-',
    corePlugins: { preflight: false },
    theme: {
        extend: {
            colors: {
                moss: { dark: '#1B4332', mid: '#2D6A4F', light: '#2D6A4F', bg: '#DDE5CD', olive: '#1B4332' }
            }
        }
    }
}
</script>

<style>
/* ============================================================
   LANDING PAGE — MBKM IAI PI BANDUNG
   ============================================================ */
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap');

:root {
    --moss-dark  : #1B4332;
    --moss-mid   : #2D6A4F;
    --moss-light : #2D6A4F;
    --moss-bg    : #F8F9FA;
    --moss-olive : #1B4332;
    --text-dark  : #212529;
    --text-muted : #5a6b5c;
    --white      : #ffffff;
    --shadow-sm  : 0 2px 12px rgba(48,98,56,.10);
    --shadow-md  : 0 6px 28px rgba(48,98,56,.16);
    --shadow-lg  : 0 14px 48px rgba(48,98,56,.22);
    --radius-sm  : 8px;
    --radius-md  : 14px;
    --radius-lg  : 20px;
    --ease-out   : cubic-bezier(.16,1,.3,1);
    --ease-spring: cubic-bezier(.34,1.56,.64,1);
}

.container {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 20px;
    width: 100%;
}

* { box-sizing: border-box; }
body, section, div { font-family: 'Plus Jakarta Sans', sans-serif; }
body { background: #fff; }

a.scroll-top, .scroll-top {
    background: #2D6A4F !important; border-color: #2D6A4F !important;
    color: #fff !important; box-shadow: 0 4px 16px rgba(97,141,79,.35) !important;
}
a.scroll-top:hover, .scroll-top:hover { background: #1B4332 !important; border-color: #1B4332 !important; }

.blog-wrapper { background: transparent !important; padding: 0 !important; margin: 0 !important; }
.blog-left, .blog-right { display: none !important; }
.section-eyebrow { color: #2D6A4F !important; }
.dokum-dot.active { background: #1B4332 !important; }

/* ── Labels & Titles ── */
.lp-label {
    display: block; color: var(--moss-mid);
    font-size: 11px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 3.5px; margin-bottom: 12px;
}
.lp-title {
    color: var(--moss-dark); font-size: 32px; font-weight: 900;
    line-height: 1.12; margin: 0 0 24px; letter-spacing: -.8px;
}
.lp-title--lg { font-size: 40px; }
.lp-section { padding: 80px 0; }

/* ── MOBILE GLOBAL OVERRIDES ── */
@media (max-width: 768px) {
    .lp-title { font-size: 24px !important; margin-bottom: 16px; text-align: center; }
    .lp-title--lg { font-size: 28px !important; }
    .lp-label { font-size: 9px !important; text-align: center; letter-spacing: 2.5px; }
    .lp-divider { margin: 0 auto 28px !important; }
    .lp-section { padding: 40px 0; }

    .stat-num { font-size: 34px !important; }
    .stat-label { font-size: 9px !important; }
    .stat-item { padding: 15px 10px; border: none !important; }
    .stats-grid { display: grid !important; grid-template-columns: 1fr 1fr !important; gap: 10px; }

    .dokum-slide img, .dokum-slide-ph { height: 320px !important; }

    .cta-section h2 { font-size: 20px !important; text-align: center; line-height: 1.4; }
    .cta-badge { text-align: center; margin-top: 20px; }
    .cta-badge-name { font-size: 18px !important; }
}

/* ══════════════════════════════════════════
   SECTION 2: SAMBUTAN
══════════════════════════════════════════ */
.sambutan-section { background: var(--moss-bg); padding: 64px 0; border-top: 1px solid rgba(97,141,79,.15); }

/* VIDEO — lebih besar & proporsional */
.sambutan-media {
    border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg);
    position: relative; background: var(--moss-dark);
    min-height: 340px; height: 100%;
    display: flex; align-items: center; justify-content: center;
}
.sambutan-media-placeholder {
    display: flex; flex-direction: column;
    align-items: center; justify-content: center; min-height: 340px; padding: 40px;
}
.sambutan-media-placeholder p { color: rgba(255,255,255,.5); margin: 12px 0 0; font-size: 13px; text-align: center; }

.play-icon-wrap {
    width: 72px; height: 72px; border-radius: 50%; background: rgba(255,255,255,.92);
    display: flex; align-items: center; justify-content: center;
    position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
    text-decoration: none; transition: transform .3s var(--ease-spring), box-shadow .3s;
    box-shadow: 0 8px 28px rgba(0,0,0,.28); backdrop-filter: blur(4px);
}
.play-icon-wrap:hover { transform: translate(-50%,-50%) scale(1.14); box-shadow: 0 14px 42px rgba(0,0,0,.38); }
.play-icon-wrap svg { width: 30px; height: 30px; fill: var(--moss-dark); margin-left: 4px; }

/* Row alignment — tighter gap */
.sambutan-row {
    display: flex;
    align-items: stretch;
    gap: 40px;
}
.sambutan-col-video {
    flex: 0 0 45%;
    min-height: 380px;
}
.sambutan-col-text {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 0;
}

@media (max-width: 767px) {
    .sambutan-row { flex-direction: column; gap: 24px; }
    .sambutan-col-video { min-height: 240px; }
}

.sambutan-col-text .lp-title { font-size: 26px; }
.sambutan-col-text p { color: var(--text-muted); line-height: 1.85; font-size: 14px; }

.btn-primary-lp {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--moss-dark); color: var(--white);
    padding: 12px 28px; border-radius: 30px; font-weight: 700; font-size: 14px;
    text-decoration: none; letter-spacing: .1px;
    transition: background .28s, box-shadow .28s, transform .28s var(--ease-spring);
    margin-top: 20px; border: 2px solid var(--moss-dark);
}
.btn-primary-lp:hover { background: var(--moss-mid); border-color: var(--moss-mid); color: var(--white); text-decoration: none; box-shadow: var(--shadow-md); transform: translateY(-2px); }
.btn-outline-lp {
    display: inline-flex; align-items: center; gap: 8px;
    border: 2px solid var(--moss-dark); color: var(--moss-dark);
    padding: 11px 28px; border-radius: 30px; font-weight: 700; font-size: 14px;
    text-decoration: none; transition: background .28s, transform .28s var(--ease-spring); margin-top: 28px;
}
.btn-outline-lp:hover { background: var(--moss-dark); color: var(--white); text-decoration: none; transform: translateY(-2px); }

/* ══════════════════════════════════════════
   SECTION 3: STATISTIK — lebih proporsional
══════════════════════════════════════════ */
.stats-section {
    background: linear-gradient(135deg, var(--moss-dark) 0%, var(--moss-olive) 100%);
    padding: 80px 0; position: relative; overflow: hidden;
}
.stats-section::before {
    content: ''; position: absolute; top: -60px; right: -60px;
    width: 260px; height: 260px; border-radius: 50%; background: rgba(255,255,255,.04);
}
.stats-section::after {
    content: ''; position: absolute; bottom: -80px; left: -40px;
    width: 320px; height: 320px; border-radius: 50%; background: rgba(255,255,255,.035);
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    width: 100%;
}
.stat-item { text-align: center; padding: 40px 24px; position: relative; z-index: 1; }
.stat-item + .stat-item { border-left: 1px solid rgba(255,255,255,.12); }

.stat-icon-wrap {
    width: 56px; height: 56px; border-radius: 50%;
    background: rgba(255,255,255,.1); border: 1.5px solid rgba(255,255,255,.16);
    display: flex; align-items: center; justify-content: center; margin: 0 auto 18px;
    transition: background .3s, transform .3s var(--ease-spring);
}
.stat-item:hover .stat-icon-wrap { background: rgba(255,255,255,.2); transform: scale(1.1); }
.stat-icon-wrap svg { width: 26px; height: 26px; fill: var(--moss-bg); }

.stat-num { font-size: 60px; font-weight: 900; color: #fff; display: block; line-height: 1; letter-spacing: -2px; }
.stat-label { color: rgba(255,255,255,.72); font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; margin-top: 10px; display: block; }
.stat-line { width: 32px; height: 2px; background: rgba(255,255,255,.3); margin: 12px auto 0; border-radius: 1px; }

@media (max-width: 768px) {
    .stats-grid {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 0 !important;
    }
    .stat-item { border: 0.5px solid rgba(255,255,255,0.08) !important; padding: 28px 16px !important; }
    .stat-num { font-size: 40px !important; }
}

/* ══════════════════════════════════════════
   SECTION 4: DOKUMENTASI
══════════════════════════════════════════ */
.dokum-section { padding: 80px 0; background: var(--white); }
.dokum-slider-wrap {
    position: relative; overflow: hidden; border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg); max-width: 960px; margin: 0 auto;
}
.dokum-slides { display: flex; transition: transform .55s var(--ease-out); will-change: transform; }
.dokum-slide { min-width: 100%; position: relative; overflow: hidden; }
.dokum-slide img { width: 100%; height: 520px; object-fit: cover; display: block; }
.dokum-slide-ph {
    width: 100%; height: 520px;
    background: linear-gradient(135deg, var(--moss-dark), var(--moss-mid));
    display: flex; align-items: center; justify-content: center; flex-direction: column;
}
.dokum-slide-ph svg { width: 72px; height: 72px; fill: rgba(255,255,255,.2); }
.dokum-slide-ph p { color: rgba(255,255,255,.42); margin: 12px 0 0; font-size: 14px; }
.dokum-slide-cap {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: linear-gradient(to top, rgba(20,40,24,.9), transparent);
    padding: 60px 32px 28px; color: var(--white);
}
.dokum-slide-cap h4 { margin: 0 0 4px; font-size: 18px; font-weight: 800; }
.dokum-slide-cap p { margin: 0; font-size: 13px; opacity: .75; }
.dokum-nav {
    position: absolute; top: 50%; transform: translateY(-50%);
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.28);
    color: var(--white); width: 48px; height: 48px; border-radius: 50%; font-size: 20px; cursor: pointer;
    transition: background .2s, transform .2s var(--ease-spring); backdrop-filter: blur(6px);
    display: flex; align-items: center; justify-content: center;
}
.dokum-nav:hover { background: rgba(255,255,255,.36); transform: translateY(-50%) scale(1.1); }
.dokum-nav.prev { left: 16px; }
.dokum-nav.next { right: 16px; }
.dokum-dots { text-align: center; margin-top: 20px; }
.dokum-dot {
    display: inline-block; width: 8px; height: 8px; border-radius: 50%;
    background: var(--moss-light); margin: 0 4px; cursor: pointer;
    transition: all .3s var(--ease-spring); opacity: .45;
}
.dokum-dot.active { background: var(--moss-dark); opacity: 1; width: 24px; border-radius: 4px; }

/* ══════════════════════════════════════════
   SECTION 5: TESTIMONI
══════════════════════════════════════════ */
.testi-carousel-outer { position: relative; overflow: hidden; padding: 10px 0; }
.testi-card {
    background: var(--white); border-radius: var(--radius-md); padding: 24px;
    border: 1px solid rgba(0,0,0,0.06); margin: 10px 6px;
    box-shadow: var(--shadow-sm); min-height: 220px;
    display: flex; flex-direction: column; justify-content: space-between;
}
.testi-card .testi-quote {
    font-size: 13.5px; color: var(--text-muted); line-height: 1.65;
    margin: 0 0 16px; position: relative; padding-top: 18px;
}
.testi-card .testi-quote::before {
    content: '\201C'; font-size: 36px; color: var(--moss-light);
    position: absolute; top: -10px; left: -5px; opacity: 0.5;
}
.testi-card .testi-person { display: flex; align-items: center; gap: 12px; border-top: 1px solid #f0f3f0; padding-top: 14px; }
.testi-avatar {
    width: 42px; height: 42px; border-radius: 50%; overflow: hidden; flex-shrink: 0;
    border: 2px solid var(--moss-light); background: #F8F9FA;
}
.testi-name { font-weight: 800; font-size: 13.5px; color: var(--moss-dark); }
.testi-role { font-size: 11px; color: var(--moss-light); font-weight: 600; }

/* ══════════════════════════════════════════
   SECTION 6: BOOKSHELF
══════════════════════════════════════════ */
.bookshelf-section { background: var(--white); padding: 80px 0; }
.bookshelf-section-head { text-align: center; margin-bottom: 44px; }

.bookshelf-search {
    display: flex; max-width: 420px; margin: 0 auto 32px;
    background: #f5f7f3; border: 1.5px solid #d0dac8; border-radius: 30px; overflow: hidden;
    transition: border-color .3s, box-shadow .3s;
}
.bookshelf-search:focus-within { border-color: var(--moss-mid); box-shadow: 0 0 0 4px rgba(97,141,79,.12); }
.bookshelf-search input {
    flex: 1; border: none; background: transparent;
    padding: 11px 18px; font-size: 13.5px; color: #333; outline: none; font-family: inherit;
}
.bookshelf-search input::placeholder { color: #aab8a8; }
.bookshelf-search button {
    background: var(--moss-dark); border: none; color: #fff;
    padding: 0 20px; cursor: pointer; transition: background .3s;
    display: flex; align-items: center;
}
.bookshelf-search button:hover { background: var(--moss-mid); }
.bookshelf-search button svg { width: 18px; height: 18px; fill: currentColor; }

.bookshelf-row {
    position: relative; padding: 22px 26px 30px; margin-bottom: 48px;
    background: linear-gradient(175deg, #cdb07f 0%, #a07848 50%, #c4a579 100%);
    border-radius: 6px; border-bottom: 14px solid #7a5028;
    box-shadow: 0 12px 32px rgba(0,0,0,.24);
    display: flex; flex-wrap: wrap; gap: 22px; min-height: 190px;
    align-items: flex-end; justify-content: center;
}
.bookshelf-row::before {
    content: ''; position: absolute; bottom: -28px; left: -8px; right: -8px;
    height: 18px; background: linear-gradient(to bottom, #5c3b1a, #3a2210);
    border-radius: 0 0 6px 6px; box-shadow: 0 6px 14px rgba(0,0,0,.32);
}
.bookshelf-row::after {
    content: ''; position: absolute; inset: 0; border-radius: 6px 6px 0 0;
    background: repeating-linear-gradient(
        91deg,
        rgba(255,255,255,0) 0px, rgba(255,255,255,.04) 1px,
        rgba(0,0,0,0) 2px, rgba(0,0,0,.03) 4px,
        rgba(255,255,255,0) 6px
    );
    pointer-events: none;
}

.book-card {
    width: 118px; cursor: pointer;
    transition: transform .35s var(--ease-spring);
    position: relative; flex-shrink: 0; text-decoration: none;
}
.book-card:hover { transform: translateY(-18px) scale(1.05) rotate(-1.5deg); text-decoration: none; }
.book-cover {
    width: 118px; height: 168px; border-radius: 2px 8px 8px 2px; overflow: hidden;
    box-shadow: -5px 6px 16px rgba(0,0,0,.45), inset -4px 0 10px rgba(0,0,0,.18), 2px 2px 8px rgba(0,0,0,.22);
    position: relative; background: var(--moss-dark);
}
.book-cover::after {
    content: ''; position: absolute; top: 0; left: 12px; right: 0; bottom: 0;
    background: linear-gradient(90deg, rgba(255,255,255,.14) 0%, transparent 22%, transparent 78%, rgba(0,0,0,.1) 100%);
    pointer-events: none;
}
.book-cover img { width: 100%; height: 100%; object-fit: cover; display: block; }
.book-spine {
    position: absolute; left: 0; top: 0; bottom: 0; width: 13px;
    background: linear-gradient(90deg, rgba(0,0,0,.38) 0%, rgba(0,0,0,.18) 60%, rgba(255,255,255,.06) 100%);
    border-right: 1px solid rgba(255,255,255,.12);
}
.book-no-cover {
    display: flex; align-items: center; justify-content: center;
    width: 100%; height: 100%;
    background: linear-gradient(145deg, var(--moss-dark) 0%, var(--moss-mid) 55%, #2D6A4F 100%);
    color: var(--white); font-size: 11px; text-align: center; padding: 14px 10px;
    font-weight: 700; line-height: 1.4; text-shadow: 0 1px 4px rgba(0,0,0,.35);
}
.book-hover-overlay {
    position: absolute; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(48,98,56,0); transition: background .3s;
    display: flex; align-items: center; justify-content: center;
    border-radius: 2px 8px 8px 2px;
}
.book-card:hover .book-hover-overlay { background: rgba(48,98,56,.62); backdrop-filter: blur(2px); }
.book-hover-overlay span {
    color: var(--white); font-size: 11.5px; font-weight: 800;
    opacity: 0; transition: opacity .25s; letter-spacing: .8px; text-transform: uppercase;
    text-shadow: 0 1px 6px rgba(0,0,0,.5);
}
.book-card:hover .book-hover-overlay span { opacity: 1; }
.book-title {
    font-size: 10.5px; color: #3a2410; font-weight: 700;
    text-align: center; margin-top: 8px; line-height: 1.35;
    max-height: 2.7em; overflow: hidden;
}
.bookshelf-more { text-align: center; margin-top: 32px; }

/* ══════════════════════════════════════════
   SECTION 7: CTA — lebih proporsional
══════════════════════════════════════════ */
.cta-section {
    background: var(--moss-dark); padding: 90px 0; position: relative; overflow: hidden;
}
.cta-section::before {
    content: ''; position: absolute; top: -80px; right: -80px;
    width: 400px; height: 400px; border-radius: 50%; background: rgba(255,255,255,.05);
}
.cta-section::after {
    content: ''; position: absolute; bottom: -100px; left: 40%;
    width: 320px; height: 320px; border-radius: 50%; background: rgba(255,255,255,.04);
}
.cta-inner {
    position: relative; z-index: 1;
    display: flex;
    align-items: center;
    gap: 40px;
}
.cta-inner-text { flex: 1; }
.cta-inner-badge {
    flex: 0 0 auto;
    text-align: right;
    padding-left: 40px;
    border-left: 1px solid rgba(255,255,255,.15);
}
.cta-section h2 {
    color: var(--white); font-size: 36px; font-weight: 900;
    line-height: 1.25; margin: 0 0 8px;
}
.cta-section h2 span { color: #a8d5b5; }
.cta-sub {
    color: rgba(255,255,255,.6);
    font-size: 15px;
    margin: 0 0 28px;
    line-height: 1.6;
}
.cta-badge-name {
    color: var(--white); font-size: 28px; font-weight: 900;
    letter-spacing: -1px; display: block; line-height: 1.2;
}
.cta-badge-sub {
    color: rgba(255,255,255,.5); font-size: 11px; display: block;
    margin-top: 6px; text-transform: uppercase; letter-spacing: 2.5px;
}
@media (max-width: 767px) {
    .cta-inner { flex-direction: column; gap: 24px; text-align: center; }
    .cta-section h2 { font-size: 24px !important; }
    .cta-inner-badge { border-left: none; border-top: 1px solid rgba(255,255,255,.15); padding-left: 0; padding-top: 24px; text-align: center; }
    .cta-badge-name { font-size: 20px !important; }
}

/* ══════════════════════════════════════════
   SECTION 8: BERITA — kartu lebih besar
══════════════════════════════════════════ */
.news-section { padding: 80px 0; background: var(--moss-bg); }
.news-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
}
@media (max-width: 900px) { .news-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 600px) { .news-grid { grid-template-columns: 1fr; } }

.news-card {
    background: var(--white); border-radius: var(--radius-lg); overflow: hidden;
    box-shadow: var(--shadow-sm); transition: transform .35s var(--ease-out), box-shadow .35s;
    display: flex; flex-direction: column;
}
.news-card:hover { transform: translateY(-10px); box-shadow: var(--shadow-lg); }
/* Thumbnail lebih tinggi */
.nc-img { width: 100%; height: 260px; object-fit: cover; display: block; }
.nc-img-ph {
    width: 100%; height: 260px;
    background: linear-gradient(135deg, var(--moss-dark), var(--moss-mid));
    display: flex; align-items: center; justify-content: center;
}
.nc-img-ph svg { width: 56px; height: 56px; fill: rgba(255,255,255,.22); }
.nc-body { padding: 24px 26px; flex: 1; display: flex; flex-direction: column; }
.nc-cat {
    display: inline-block; background: #e8f0e8; color: var(--moss-dark);
    font-size: 10px; font-weight: 800; padding: 5px 14px; border-radius: 20px;
    margin-bottom: 12px; text-transform: uppercase; letter-spacing: 1px;
}
.nc-body h3 {
    font-size: 16px; font-weight: 800; color: var(--text-dark);
    margin: 0 0 12px; line-height: 1.5; flex: 1;
}
.nc-body h3 a { color: inherit; text-decoration: none; }
.nc-body h3 a:hover { color: var(--moss-dark); }
.nc-meta {
    font-size: 12px; color: #9aab9c; margin-top: auto; padding-top: 12px;
    border-top: 1px solid #edf2ea; display: flex; gap: 6px; align-items: center;
}

/* ══════════════════════════════════════════════════════════════
   UNIFIED FLIPBOOK MODAL
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
@keyframes ufbIn { from { opacity: 0; transform: scale(.96); } to { opacity: 1; transform: scale(1); } }
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
.ufb-header h4 { margin: 0; font-size: 14px; font-weight: 700; color: #fff; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; flex: 1; font-family: 'Plus Jakarta Sans', sans-serif; }
.ufb-header-actions { display: flex; gap: 6px; align-items: center; flex-shrink: 0; }
.ufb-hbtn { width: 32px; height: 32px; border-radius: 7px; border: 1px solid rgba(255,255,255,.18); background: rgba(255,255,255,.1); cursor: pointer; display: flex; align-items: center; justify-content: center; color: #fff; transition: background .18s, transform .18s var(--ease-spring); }
.ufb-hbtn:hover { background: rgba(255,255,255,.26); transform: scale(1.08); }
.ufb-close { background: rgba(255,100,100,.15); border: 1px solid rgba(255,100,100,.25); color: rgba(255,255,255,.8); font-size: 18px; line-height: 1; cursor: pointer; width: 32px; height: 32px; border-radius: 7px; display: flex; align-items: center; justify-content: center; transition: background .18s, color .18s; }
.ufb-close:hover { background: rgba(255,80,80,.4); color: #fff; }
.ufb-canvas-wrap { flex: 1; overflow: auto; position: relative; background: #08120a; cursor: grab; display: flex; align-items: flex-start; justify-content: flex-start; scrollbar-width: none; -ms-overflow-style: none; -webkit-overflow-scrolling: touch; }
.ufb-canvas-wrap::-webkit-scrollbar { display: none; }
.ufb-canvas-wrap.is-dragging { cursor: grabbing; }
.ufb-scene-outer { display: flex; align-items: center; justify-content: center; min-width: 100%; min-height: 100%; flex-shrink: 0; padding: 24px 80px; box-sizing: border-box; }
@media (max-width: 767px) { .ufb-scene-outer { padding: 0; align-items: flex-start; justify-content: flex-start; } }
.ufb-scene { position: relative; display: inline-flex; align-items: stretch; flex-shrink: 0; perspective: 2800px; perspective-origin: 50% 50%; }
#ufbCanvasL { display: block; box-shadow: -6px 0 24px rgba(0,0,0,.6); border-radius: 3px 0 0 3px; }
#ufbCanvasR { display: none; box-shadow: 6px 0 24px rgba(0,0,0,.6); border-radius: 0 3px 3px 0; }
.ufb-spine { display: none; width: 7px; flex-shrink: 0; background: linear-gradient(180deg, #5a8a62 0%, #1f4428 50%, #5a8a62 100%); box-shadow: 3px 0 10px rgba(0,0,0,.55), -3px 0 10px rgba(0,0,0,.55); }
.ufb-nav-arrow { position: absolute; top: 50%; transform: translateY(-50%); width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.18); color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background .2s, transform .2s var(--ease-spring); z-index: 10; pointer-events: all; }
.ufb-nav-arrow:hover { background: rgba(255,255,255,.25); transform: translateY(-50%) scale(1.1); }
.ufb-nav-arrow.prev { left: 16px; }
.ufb-nav-arrow.next { right: 16px; }
@media (max-width: 600px) { .ufb-nav-arrow { display: none; } }
.ufb-loading { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 14px; background: #08120a; z-index: 5; color: var(--moss-light); font-size: 13px; font-weight: 600; }
.ufb-loading-spinner { width: 36px; height: 36px; border-radius: 50%; border: 3px solid rgba(97,141,79,.3); border-top-color: var(--moss-mid); animation: ufbSpin .75s linear infinite; }
@keyframes ufbSpin { to { transform: rotate(360deg); } }
.ufb-swipe-hint { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); background: rgba(48,98,56,.75); color: #fff; font-size: 11px; padding: 6px 16px; border-radius: 20px; pointer-events: none; opacity: 0; transition: opacity .6s; white-space: nowrap; }
.ufb-swipe-hint.show { opacity: 1; }
.ufb-flipper { position: absolute; transform-style: preserve-3d; display: none; z-index: 20; pointer-events: none; will-change: transform; }
.ufb-flip-front, .ufb-flip-back { position: absolute; inset: 0; overflow: hidden; backface-visibility: hidden; -webkit-backface-visibility: hidden; }
.ufb-flip-back { transform: rotateY(180deg); }
.ufb-flip-front canvas, .ufb-flip-back canvas { display: block; width: 100%; height: 100%; }
.ufb-flipper.is-next .ufb-flip-front::after { content: ''; position: absolute; inset: 0; pointer-events: none; background: linear-gradient(to left, rgba(0,0,0,.5) 0%, transparent 65%); }
.ufb-flipper.is-next .ufb-flip-back::after { content: ''; position: absolute; inset: 0; pointer-events: none; background: linear-gradient(to right, rgba(0,0,0,.3) 0%, transparent 55%); }
.ufb-flipper.is-prev .ufb-flip-front::after { content: ''; position: absolute; inset: 0; pointer-events: none; background: linear-gradient(to right, rgba(0,0,0,.5) 0%, transparent 65%); }
.ufb-flipper.is-prev .ufb-flip-back::after { content: ''; position: absolute; inset: 0; pointer-events: none; background: linear-gradient(to left, rgba(0,0,0,.3) 0%, transparent 55%); }
.ufb-toolbar { display: flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 20px; background: #0e1a10; flex-shrink: 0; border-top: 1px solid rgba(255,255,255,.06); flex-wrap: wrap; }
.ufb-tbtn { height: 34px; border-radius: 8px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.1); color: #ccc; cursor: pointer; padding: 0 14px; font-size: 12.5px; font-weight: 700; font-family: inherit; display: flex; align-items: center; gap: 6px; transition: background .18s, color .18s, transform .18s var(--ease-spring); }
.ufb-tbtn:hover { background: rgba(255,255,255,.18); color: #fff; }
.ufb-tbtn:disabled { opacity: .3; cursor: default; }
.ufb-tbtn.icon-only { width: 34px; padding: 0; justify-content: center; border-radius: 50%; }
.ufb-page-badge { background: rgba(97,141,79,.2); color: var(--moss-light); border: 1px solid rgba(97,141,79,.3); padding: 0 16px; height: 34px; border-radius: 20px; font-size: 12px; font-weight: 700; display: flex; align-items: center; min-width: 110px; justify-content: center; letter-spacing: .3px; }
.ufb-vdiv { width: 1px; height: 22px; background: rgba(255,255,255,.1); margin: 0 2px; }
@media (max-width: 767px) { .ufb-toolbar { gap: 4px; padding: 7px 8px; display: grid; grid-template-columns: 1fr auto 1fr; } .ufb-page-badge { font-size: 11px; min-width: 0; } .ufb-tb-desktop { display: none !important; } .ufb-tb-zoom-mobile { grid-column: 1 / -1; display: flex !important; gap: 6px; } .ufb-tb-zoom-mobile .ufb-tbtn { flex: 1; justify-content: center; } }
.ufb-thumbs { display: flex; gap: 8px; overflow-x: auto; padding: 10px 16px; background: #0a140c; border-top: 1px solid rgba(255,255,255,.05); flex-shrink: 0; scrollbar-width: thin; scrollbar-color: #3a5a3e transparent; }
.ufb-thumbs::-webkit-scrollbar { height: 3px; }
.ufb-thumbs::-webkit-scrollbar-track { background: transparent; }
.ufb-thumbs::-webkit-scrollbar-thumb { background: #3a5a3e; border-radius: 2px; }
@media (max-width: 767px) { .ufb-thumbs { display: none; } }
.ufb-thumb { flex-shrink: 0; width: 48px; height: 68px; border-radius: 4px; background: #1e2e22; cursor: pointer; overflow: hidden; border: 2px solid transparent; transition: border-color .2s, transform .2s var(--ease-spring); position: relative; }
.ufb-thumb:hover { transform: scale(1.08); border-color: rgba(97,141,79,.5); }
.ufb-thumb.active { border-color: var(--moss-mid); }
.ufb-thumb canvas { width: 100%; height: 100%; display: block; object-fit: contain; }
.ufb-thumb-n { position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,.68); color: #aaa; font-size: 8.5px; text-align: center; padding: 2px 0; }
</style>

<?php
$q_prog = $koneksi_db->sql_query("SELECT * FROM mod_program ORDER BY id DESC LIMIT 8");
$programs = [];
while ($p = $koneksi_db->sql_fetchrow($q_prog)) $programs[] = $p;
$prog_count = count($programs);
?>

<style>
/* ══════════════════════════════════════════
   PROG UNGGULAN — FULL WIDTH FLUSH BLOCKS
══════════════════════════════════════════ */
.prog-unggulan-section {
    background: #fff;
    padding: 0 0 70px;
}
.prog-unggulan-head {
    text-align: center;
    padding: 56px 0 40px;
}

/* FULL WIDTH wrapper — no container, no padding */
.prog-carousel-fullwrap {
    position: relative;
    width: 100%;
    overflow: hidden;
}

/* Owl will handle the inner track */
.prog-carousel-track {
    /* Owl carousel handles display */
}

/* ── Kartu Portrait FULL HEIGHT ── */
.prog-unggulan-card {
    height: 500px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    text-decoration: none !important;
    display: flex !important;
    flex-direction: column;
    justify-content: flex-end;
    padding: 0 0 40px 36px;
    transition: opacity 0.3s;
    outline: none;
    border: none;
}
.prog-unggulan-card:hover { text-decoration: none; }
.prog-unggulan-card:hover .puc-thumb-bg img { opacity: 0.45; transform: scale(1.04); }

/* Color backgrounds */
.puc-c0 { background: rgba(27,67,50,0.90); }
.puc-c1 { background: rgba(20,52,38,0.90); }
.puc-c2 { background: rgba(45,106,79,0.90); }
.puc-c3 { background: rgba(30,74,55,0.90); }

/* ── Thumbnail background with overlay ── */
.puc-thumb-bg {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    z-index: 1; pointer-events: none;
}
.puc-thumb-bg img {
    width: 100%; height: 100%;
    object-fit: cover;
    opacity: 0.38;
    filter: saturate(0.55) contrast(1.1) brightness(1.05);
    transition: opacity 0.5s, transform 0.6s cubic-bezier(.16,1,.3,1);
}

/* Gradient overlay from bottom */
.puc-overlay {
    position: absolute; inset: 0; z-index: 2; pointer-events: none;
    background: linear-gradient(
        to top,
        rgba(0,0,0,0.75) 0%,
        rgba(0,0,0,0.35) 45%,
        rgba(0,0,0,0.05) 100%
    );
}

/* Number stripe top-left */
.puc-num-stripe {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 4px;
    background: rgba(255,255,255,0.18);
    z-index: 4;
}

/* ── Content ── */
.puc-content {
    position: relative; z-index: 3;
    padding-right: 24px;
}
.puc-num {
    display: inline-block;
    font-size: 9px; font-weight: 800;
    color: rgba(255,255,255,0.55);
    text-transform: uppercase; letter-spacing: 4px;
    margin-bottom: 10px;
    background: rgba(255,255,255,0.12);
    padding: 4px 10px; border-radius: 20px;
}
.puc-title {
    font-size: 17px; font-weight: 900; color: #fff;
    text-transform: uppercase; letter-spacing: 0.3px;
    line-height: 1.3; margin: 0 0 8px;
    text-shadow: 0 2px 12px rgba(0,0,0,.5);
}
.puc-desc {
    font-size: 12px; color: rgba(255,255,255,0.70);
    line-height: 1.65; margin: 0 0 16px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.puc-badge {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 11px; font-weight: 800; color: #fff;
    text-transform: uppercase; letter-spacing: 1.5px;
    background: rgba(255,255,255,0.18);
    border: 1px solid rgba(255,255,255,0.28);
    padding: 7px 16px; border-radius: 24px;
    transition: background 0.25s, transform 0.25s;
    backdrop-filter: blur(4px);
}
.prog-unggulan-card:hover .puc-badge {
    background: rgba(255,255,255,0.30);
    transform: translateX(4px);
}

/* ── Decorative icon ── */
.puc-icon-big {
    position: absolute; bottom: -10px; right: -6px; z-index: 2;
    width: 110px; height: 110px; opacity: 0.1; pointer-events: none;
    transition: opacity 0.38s, transform 0.38s cubic-bezier(.34,1.56,.64,1);
}
.puc-icon-big svg { width: 100%; height: 100%; fill: #fff; }
.prog-unggulan-card:hover .puc-icon-big { opacity: 0.22; transform: scale(1.1) rotate(-6deg); }

/* ── Arrow buttons ── */
.prog-carousel-arrow {
    position: absolute; top: 50%; transform: translateY(-50%);
    width: 48px; height: 48px; border-radius: 50%; z-index: 10;
    background: rgba(27,67,50,0.85); border: 2px solid rgba(255,255,255,0.22);
    color: #fff; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 6px 20px rgba(0,0,0,.35);
    transition: background 0.2s, transform 0.22s cubic-bezier(.34,1.56,.64,1);
    padding: 0; backdrop-filter: blur(6px);
}
.prog-carousel-arrow:hover { background: #2D6A4F; transform: translateY(-50%) scale(1.1); }
.prog-carousel-arrow.pca-prev { left: 16px; }
.prog-carousel-arrow.pca-next { right: 16px; }
.prog-carousel-arrow svg { width: 24px; height: 24px; fill: #fff; display: block; }

/* ── Dots ── */
.prog-carousel-dots {
    display: flex; justify-content: center; gap: 7px; margin-top: 24px;
}
.pcd-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: #2D6A4F; opacity: 0.38; cursor: pointer;
    transition: all 0.38s cubic-bezier(.34,1.56,.64,1); border: none; padding: 0;
}
.pcd-dot.active { background: #1B4332; opacity: 1; width: 26px; border-radius: 4px; }

/* Responsive heights */
@media (max-width: 992px) {
    .prog-unggulan-card { height: 440px; }
}
@media (max-width: 575px) {
    .prog-unggulan-card { height: 360px; padding: 0 0 30px 24px; }
    .puc-icon-big { width: 80px; height: 80px; }
    .prog-carousel-arrow { width: 38px; height: 38px; }
    .prog-carousel-arrow.pca-prev { left: 8px; }
    .prog-carousel-arrow.pca-next { right: 8px; }
}
</style>

<!-- ═══════════════════════════════════
     SECTION 1: PROGRAM MBKM — FULL WIDTH
═══════════════════════════════════ -->
<section class="prog-unggulan-section">

    <div class="prog-unggulan-head">
        <span class="lp-label" style="letter-spacing:4px;">Program Unggulan</span>
        <h2 class="lp-title lp-title--lg">PROGRAM MBKM IAI PI BANDUNG</h2>
        <div class="lp-divider" style="margin:0 auto;"></div>
    </div>

    <?php if ($prog_count > 0): ?>
    <div class="prog-carousel-fullwrap">

        <!-- Arrow Prev -->
        <button class="prog-carousel-arrow pca-prev" id="progArrowPrev"
                onclick="progCarouselNav(-1)" aria-label="Sebelumnya">
            <svg viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
        </button>

        <!-- Owl Carousel Track — FULL WIDTH, no margin -->
        <div class="owl-carousel owl-theme prog-carousel-track" id="progTrack">
        <?php
        $puc_icons = [
            'M12 3L1 9l11 6 9-4.91V17h2V9L12 3zm0 12.08L5.21 11 12 7.08 18.79 11 12 15.08zM1 17l11 6 11-6v-2L12 21 1 15v2z',
            'M20 6h-2.18c.07-.44.18-.86.18-1a3 3 0 0 0-6 0c0 .14.11.56.18 1H10c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-7-1a1 1 0 0 1 2 0c0 .22-.19.86-.25 1h-1.5c-.06-.14-.25-.78-.25-1zm-3 3h14v12H10V8z',
            'M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z',
            'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z',
            'M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z',
            'M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z',
            'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z',
            'M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z',
        ];
        $puc_colors = ['puc-c0','puc-c1','puc-c2','puc-c3'];

        foreach ($programs as $i => $data):
            $snippet  = !empty($data['deskripsi_singkat'])
                        ? $data['deskripsi_singkat']
                        : substr(strip_tags($data['isi']), 0, 90).'...';
            $img_src  = !empty($data['gambar'])
                        ? 'images/pages/'.htmlspecialchars($data['gambar'])
                        : '';
            $col_cls  = $puc_colors[$i % 4];
            $icon_d   = $puc_icons[$i % count($puc_icons)];
            $num_pad  = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        ?>
        <a href="index.php?pilih=program&modul=yes&id=<?= htmlspecialchars($data['slug']) ?>"
           class="prog-unggulan-card <?= $col_cls ?>">

            <div class="puc-num-stripe"></div>

            <?php if ($img_src): ?>
            <div class="puc-thumb-bg">
                <img src="<?= $img_src ?>" alt="<?= htmlspecialchars($data['judul']) ?>"
                     onerror="this.parentNode.style.display='none'">
            </div>
            <?php endif; ?>

            <div class="puc-overlay"></div>

            <div class="puc-content">
                <span class="puc-num"><?= $num_pad ?></span>
                <h3 class="puc-title"><?= htmlspecialchars($data['judul']) ?></h3>
                <p class="puc-desc"><?= htmlspecialchars($snippet) ?></p>
                <span class="puc-badge">Lihat Program &#8594;</span>
            </div>

            <div class="puc-icon-big">
                <svg viewBox="0 0 24 24"><path d="<?= $icon_d ?>"/></svg>
            </div>

        </a>
        <?php endforeach; ?>
        </div><!-- /owl carousel -->

        <!-- Arrow Next -->
        <button class="prog-carousel-arrow pca-next" id="progArrowNext"
                onclick="progCarouselNav(1)" aria-label="Selanjutnya">
            <svg viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
        </button>
    </div><!-- /fullwrap -->

    <!-- Dots -->
    <div class="prog-carousel-dots" id="progDots"></div>

    <?php else: ?>
    <p style="text-align:center;color:#2D6A4F;padding:50px 0;">Belum ada program yang tersedia.</p>
    <?php endif; ?>

</section>

<script>
window.addEventListener('DOMContentLoaded', function() {
    if (jQuery('#progTrack').length) {
        var owlProg = jQuery('#progTrack').owlCarousel({
            loop: true,
            margin: 0,          /* flush, no gap */
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 4500,
            autoplayHoverPause: true,
            smartSpeed: 900,
            stagePadding: 0,
            responsive: {
                0:    { items: 1 },
                576:  { items: 2 },
                992:  { items: 3 },
                1280: { items: 4 }
            }
        });

        window.progCarouselNav = function(dir) {
            if (dir > 0) owlProg.trigger('next.owl.carousel');
            else owlProg.trigger('prev.owl.carousel');
        };
    }
});
</script>

<!-- ═══════════════════════════════════
     SECTION 2: SAMBUTAN — video lebih besar, gap proporsional
═══════════════════════════════════ -->
<section class="sambutan-section">
    <div class="container">
        <div class="sambutan-row">

            <!-- Video col — 45% width, tinggi penuh -->
            <div class="sambutan-col-video">
                <div class="sambutan-media" style="height:100%; min-height:380px;">
                    <div class="sambutan-media-placeholder">
                        <svg viewBox="0 0 24 24" style="width:56px;height:56px;fill:rgba(255,255,255,.2);">
                            <path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/>
                        </svg>
                        <p>Video Profil MBKM IAI PI Bandung</p>
                    </div>
                    <?php
                    $vid = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM mod_data_video ORDER BY id DESC LIMIT 1"));
                    if ($vid && !empty($vid['video'])): ?>
                    <div style="position:absolute;top:0;left:0;right:0;bottom:0;">
                        <img src="http://img.youtube.com/vi/<?= $vid['video'] ?>/hqdefault.jpg"
                             style="width:100%;height:100%;object-fit:cover;display:block;">
                        <a href="https://www.youtube.com/watch?v=<?= $vid['video'] ?>" target="_blank" class="play-icon-wrap">
                            <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Text col -->
            <div class="sambutan-col-text">
                <span class="lp-label">Tentang</span>
                <?php
                $profil_data = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM mod_data_profil WHERE id='1'"));
                if ($profil_data && !empty($profil_data['nama'])): ?>
                <h2 class="lp-title" style="font-size:28px;"><?= htmlspecialchars($profil_data['nama']) ?></h2>
                <div class="lp-divider"></div>
                <p style="color:var(--text-muted);line-height:1.85;font-size:14.5px;"><?= limitTXT(strip_tags($profil_data['sambutan']), 580) ?></p>
                <div style="margin-top:16px;">
                    <a href="index.php?pilih=profil&modul=yes" class="btn-primary-lp">
                        Selengkapnya <i class="fa fa-arrow-right" style="margin-left:8px;font-size:12px;"></i>
                    </a>
                </div>
                <?php else: ?>
                <h2 class="lp-title" style="font-size:28px;">Tentang MBKM<br>IAI PI Bandung</h2>
                <div class="lp-divider"></div>
                <p style="color:var(--text-muted);line-height:1.85;font-size:14.5px;">Program MBKM (Merdeka Belajar Kampus Merdeka) di IAI PI Bandung hadir sebagai wujud komitmen kami dalam memberikan pengalaman belajar yang bermakna dan berdampak nyata bagi mahasiswa.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════
     SECTION 3: STATISTIK — lebih proporsional
═══════════════════════════════════ -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <?php
            $stats = [];
            $q_stat = $koneksi_db->sql_query("SELECT * FROM mod_data_stat ORDER BY id ASC LIMIT 4");
            while ($s = $koneksi_db->sql_fetchrow($q_stat)) $stats[] = $s;
            if (empty($stats)):
                $stats = [
                    ['jum'=>'7',   'nama'=>'Program Studi'],
                    ['jum'=>'1500','nama'=>'Mahasiswa'],
                    ['jum'=>'15000','nama'=>'Alumni'],
                    ['jum'=>'76',  'nama'=>'Dosen Ahli'],
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
            <div>
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

<!-- ═══════════════════════════════════
     SECTION 4: DOKUMENTASI
═══════════════════════════════════ -->
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

<!-- ═══════════════════════════════════
     SECTION 5: TESTIMONI
═══════════════════════════════════ -->
<section class="testi-section" style="padding:56px 0; background:var(--white);">
    <div class="container">
        <div class="testi-head" style="text-align:center; margin-bottom:32px;">
            <span class="lp-label">Testimoni</span>
            <h2 class="lp-title">PENGALAMAN MEREKA</h2>
            <div class="lp-divider" style="margin:0 auto;"></div>
        </div>
        <div class="testi-carousel-outer">
            <div class="owl-carousel owl-theme testi-track">
                <?php
                $q_testi = $koneksi_db->sql_query("SELECT * FROM mod_data_testi WHERE status='1' ORDER BY id DESC LIMIT 6");
                $testis = [];
                while ($t = $koneksi_db->sql_fetchrow($q_testi)) $testis[] = $t;
                if (empty($testis)):
                    $testis = [
                        ['nama'=>'Ahmad Fauzi','email'=>'Magang','ket'=>'Sangat luar biasa, saya mendapat ilmu praktis yang tidak bisa saya dapatkan di dalam kelas.','foto'=>''],
                        ['nama'=>'Siti Nurhaliza','email'=>'Pertukaran','ket'=>'Membuka wawasan lintas kampus dan menambah jaringan pertemanan yang sangat berharga.','foto'=>''],
                        ['nama'=>'Rizky Pratama','email'=>'Kampus Mengajar','ket'=>'Pengalaman mengajar ini mengubah perspektif saya tentang dunia pendidikan Indonesia.','foto'=>''],
                    ];
                endif;
                foreach ($testis as $t): ?>
                <div class="testi-card">
                    <div class="testi-quote"><?= htmlspecialchars($t['ket']) ?></div>
                    <div class="testi-person">
                        <div class="testi-avatar">
                            <?php if (!empty($t['foto'])): ?><img src="images/testi/<?= $t['foto'] ?>" style="width:100%;height:100%;object-fit:cover;"><?php endif; ?>
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

<script>
window.addEventListener('DOMContentLoaded', function() {
    if (jQuery('.testi-track').length) {
        jQuery('.testi-track').owlCarousel({
            loop: true, margin: 18, nav: false, dots: true, autoplay: true, autoplayTimeout: 5000,
            responsive: { 0: { items: 1 }, 600: { items: 2 }, 1000: { items: 3 } }
        });
    }
});
</script>

<!-- ═══════════════════════════════════
     UNIFIED FLIPBOOK MODAL
═══════════════════════════════════ -->
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
        <button class="ufb-nav-arrow prev" id="ufbNavPrev" onclick="ufbNav(-1)">
            <svg width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
        </button>
        <button class="ufb-nav-arrow next" id="ufbNavNext" onclick="ufbNav(1)">
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
            <button class="ufb-tbtn" onclick="ufbZoomReset()" title="Reset zoom">&#8635;</button>
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
        <div class="ufb-tb-zoom-mobile" style="display:none;grid-column:1/-1;gap:6px;">
            <button class="ufb-tbtn" onclick="ufbZoom(.15)" style="flex:1;">&#43; Zoom</button>
            <button class="ufb-tbtn" onclick="ufbZoom(-.15)" style="flex:1;">&#8722; Zoom</button>
        </div>
    </div>
    <div class="ufb-thumbs" id="ufbThumbs"></div>
</div>
</div>

<!-- ═══════════════════════════════════
     SECTION 6: BOOKSHELF
═══════════════════════════════════ -->
<section class="bookshelf-section">
    <div class="container">
        <div class="bookshelf-section-head">
            <span class="lp-label">Referensi</span>
            <h2 class="lp-title lp-title--lg">PEDOMAN MBKM IAI PI BANDUNG</h2>
            <div class="lp-divider" style="margin:0 auto;"></div>
        </div>
        <div class="bookshelf-search">
            <input type="text" id="bookSearchInput" placeholder="Cari buku pedoman..." oninput="filterBooksLP()">
            <button type="button" onclick="filterBooksLP()">
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
                    echo '<div class="book-hover-overlay"><span>&#128214; Buka</span></div>
                        </div>
                        <div class="book-title">'.$jd.'</div>
                    </div>';
                endforeach;
                echo '</div>';
            endforeach;
        else:
            $dummy_books = ['Pedoman Magang','Pedoman Pertukaran','Panduan KKNT','Pedoman Riset','Studi Independen','Kampus Mengajar'];
            $book_colors = ['#1B4332','#2D6A4F','#1B4332','#2D6A4F','#2D6A4F','#2a5430'];
            echo '<div class="bookshelf-row">';
            foreach ($dummy_books as $bi => $bn):
                echo '<div class="book-card" onclick="alert(\'Upload buku via Admin Flipbook terlebih dahulu.\')">
                    <div class="book-cover" style="background:'.$book_colors[$bi].';">
                        <div class="book-spine"></div>
                        <div class="book-no-cover">'.$bn.'</div>
                        <div class="book-hover-overlay"><span>&#128214; Buka</span></div>
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

<!-- ═══════════════════════════════════
     SECTION 7: CTA — proporsional & lebih tinggi
═══════════════════════════════════ -->
<section class="cta-section">
    <div class="container">
        <div class="cta-inner">
            <div class="cta-inner-text">
                <h2 class="lp-title" style="color:#fff;font-size:36px;margin-bottom:12px;">
                    Mari Bergabung Dengan<br><span style="color:#a8d5b5;">Program MBKM</span><br>Universitas IAI PI Bandung
                </h2>
                <p class="cta-sub">Wujudkan pengalaman belajar terbaik bersama kami. Program MBKM yang inovatif, berdampak, dan membuka peluang masa depan.</p>
                <a href="index.php?pilih=daftar&modul=yes" class="btn-primary-lp" style="background:rgba(255,255,255,.15);border-color:rgba(255,255,255,.35);margin-top:0;">
                    Daftar Sekarang &#8594;
                </a>
            </div>
            <div class="cta-inner-badge">
                <span class="cta-badge-name">MBKM<br>BERDAMPAK</span>
                <span class="cta-badge-sub">Universitas IAI PI Bandung</span>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════
     SECTION 8: BERITA — gambar lebih besar
═══════════════════════════════════ -->
<section class="news-section">
    <div class="container">
        <span class="lp-label">Kabar Terkini</span>
        <h2 class="lp-title lp-title--lg">BERITA &amp; KEGIATAN</h2>
        <div class="lp-divider" style="margin-bottom:40px;"></div>

        <div class="news-grid">
            <?php
            $q_news = $koneksi_db->sql_query("SELECT * FROM `artikel` WHERE publikasi=1 AND topik=1 ORDER BY `id` DESC LIMIT 3");
            $news_items = [];
            while ($d = $koneksi_db->sql_fetchrow($q_news)) $news_items[] = $d;

            if (empty($news_items)):
                $dummies = [
                    ['judul'=>'Peluncuran Program Magang MBKM 2024','hits'=>120],
                    ['judul'=>'Mahasiswa IAI PI Ikuti Pertukaran ke UIN Bandung','hits'=>98],
                    ['judul'=>'Sosialisasi MBKM untuk Mahasiswa Baru','hits'=>75],
                ];
                foreach ($dummies as $ni): ?>
                <div class="news-card">
                    <div class="nc-img-ph"><svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12zM6 10h2v2H6zm0 4h8v2H6zm4-4h8v2h-8z"/></svg></div>
                    <div class="nc-body">
                        <span class="nc-cat">MBKM</span>
                        <h3><a href="#"><?= htmlspecialchars($ni['judul']) ?></a></h3>
                        <div class="nc-meta"><?= $ni['hits'] ?> kali dibaca &nbsp;|&nbsp; <?= date('d M Y') ?></div>
                    </div>
                </div>
                <?php endforeach;
            else:
                foreach ($news_items as $data):
                    $url = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(" ", "-", $data[1]));
                    $url = trim(preg_replace('/-+/', '-', $url), '-');
                    if (empty($url)) $url = 'artikel-'.$data[0];
                    $image_src = !empty($data['gambar']) ? 'images/artikel/'.$data['gambar'] : '';
                ?>
                <div class="news-card">
                    <?php if ($image_src): ?>
                    <img src="<?= $image_src ?>" class="nc-img" alt="<?= htmlspecialchars($data[1]) ?>">
                    <?php else: ?>
                    <div class="nc-img-ph"><svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12zM6 10h2v2H6zm0 4h8v2H6zm4-4h8v2h-8z"/></svg></div>
                    <?php endif; ?>
                    <div class="nc-body">
                        <span class="nc-cat">MBKM</span>
                        <h3><a href="artikel/<?= $data[0] ?>/<?= $url ?>.html"><?= htmlspecialchars($data[1]) ?></a></h3>
                        <div class="nc-meta"><?= $data['hits'] ?> kali dibaca &nbsp;|&nbsp; <?= datetimess($data[5]) ?></div>
                    </div>
                </div>
                <?php endforeach;
            endif; ?>
        </div>

        <div style="text-align:center; margin-top:32px;">
            <a href="kategori/1/Berita-Kampus.html" class="btn-outline-lp">Lihat Semua Berita &raquo;</a>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     SCRIPTS
═══════════════════════════════════════════════════════════ -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
if (typeof pdfjsLib !== 'undefined') {
    pdfjsLib.GlobalWorkerOptions.workerSrc =
        'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
}

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
        var mob = _isMobile();
        var maxW = mob ? w : Math.floor((w - 7) / 2);
        return Math.max(.3, Math.min(3.5, Math.min(maxW / vp.width, h / vp.height)));
    });
}

function _rnd(num, cvs) {
    if (!_pdf || num < 1 || num > _total) {
        cvs.width = 0; cvs.height = 0; cvs.style.display = 'none';
        return Promise.resolve(null);
    }
    var dpr = Math.min(window.devicePixelRatio || 1, 2);
    var s = _scale * _zoom;
    return _pdf.getPage(num).then(function(pg) {
        var vp = pg.getViewport({ scale: s * dpr });
        cvs.width = vp.width; cvs.height = vp.height;
        cvs.style.width = Math.round(vp.width / dpr) + 'px';
        cvs.style.height = Math.round(vp.height / dpr) + 'px';
        cvs.style.display = 'block';
        return pg.render({ canvasContext: cvs.getContext('2d'), viewport: vp }).promise.then(function() { return cvs; });
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
    var mob = _isMobile();
    var hasR = !mob && p + 1 <= _total;
    _el('ufbSpine').style.display = hasR ? 'block' : 'none';
    var cR = _el('ufbCanvasR');
    if (!hasR) { cR.style.display = 'none'; cR.width = 0; }
    var label = (p === 1 && _total <= 1) ? 'Cover' : 'Hal ' + p + (hasR ? '\u2013' + (p + 1) : '') + ' / ' + _total;
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
    var wrap = _el('ufbWrap'); var scene = _el('ufbSceneOuter');
    if (!scene || !wrap) return;
    var cw = scene.scrollWidth || wrap.scrollWidth;
    var ch = scene.scrollHeight || wrap.scrollHeight;
    wrap.scrollLeft = Math.max(0, (cw - wrap.clientWidth) / 2);
    wrap.scrollTop = Math.max(0, (ch - wrap.clientHeight) / 2);
}

function _direct(p, cb) {
    var mob = _isMobile(); var cL = _el('ufbCanvasL'); var cR = _el('ufbCanvasR');
    var tasks = [_rnd(p, cL)];
    if (!mob && p + 1 <= _total) tasks.push(_rnd(p + 1, cR));
    else { cR.style.display = 'none'; cR.width = 0; }
    Promise.all(tasks).then(function() {
        _ui(p); _busy = false; _centerScene(); if (cb) cb();
    }).catch(function() { _busy = false; });
}

function _flip(p, dir) {
    if (_isMobile()) { _direct(p); return; }
    var cL = _el('ufbCanvasL'); var cR = _el('ufbCanvasR');
    var fpr = _el('ufbFlipper'); var ffr = _el('ufbFlipFront'); var fbk = _el('ufbFlipBack');
    fpr.className = 'ufb-flipper';
    if (dir === 'next') {
        if (!cR.offsetWidth) { _busy = false; _direct(p); return; }
        _copy(cR, ffr);
        fpr.style.cssText = ['display:block','width:'+cR.offsetWidth+'px','height:'+cR.offsetHeight+'px','left:'+cR.offsetLeft+'px','top:'+cR.offsetTop+'px','transform-origin:0% 50%','transform:rotateY(0deg)','transition:none','z-index:20','pointer-events:none'].join(';');
        fpr.classList.add('is-next'); cR.style.visibility = 'hidden';
        Promise.all([_rnd(p, fbk), _rnd(p + 1, cR)]).then(function() {
            fbk.style.width = ffr.style.width; fbk.style.height = ffr.style.height;
            requestAnimationFrame(function() { requestAnimationFrame(function() { fpr.style.transition = 'transform '+FLIP_MS+'ms cubic-bezier(.77,0,.18,1)'; fpr.style.transform = 'rotateY(-180deg)'; }); });
            setTimeout(function() { fpr.style.transition = 'none'; fpr.style.display = 'none'; fpr.className = 'ufb-flipper'; cR.style.visibility = 'visible'; _direct(p); }, FLIP_MS + 60);
        }).catch(function() { fpr.style.display='none'; cR.style.visibility='visible'; _busy=false; });
    } else {
        if (!cL.offsetWidth) { _busy = false; _direct(p); return; }
        _copy(cL, ffr);
        fpr.style.cssText = ['display:block','width:'+cL.offsetWidth+'px','height:'+cL.offsetHeight+'px','left:'+cL.offsetLeft+'px','top:'+cL.offsetTop+'px','transform-origin:100% 50%','transform:rotateY(0deg)','transition:none','z-index:20','pointer-events:none'].join(';');
        fpr.classList.add('is-prev'); cL.style.visibility = 'hidden';
        Promise.all([_rnd(p + 1, fbk), _rnd(p, cL)]).then(function() {
            fbk.style.width = ffr.style.width; fbk.style.height = ffr.style.height;
            requestAnimationFrame(function() { requestAnimationFrame(function() { fpr.style.transition = 'transform '+FLIP_MS+'ms cubic-bezier(.77,0,.18,1)'; fpr.style.transform = 'rotateY(180deg)'; }); });
            setTimeout(function() { fpr.style.transition = 'none'; fpr.style.display = 'none'; fpr.className = 'ufb-flipper'; cL.style.visibility = 'visible'; _direct(p); }, FLIP_MS + 60);
        }).catch(function() { fpr.style.display='none'; cL.style.visibility='visible'; _busy=false; });
    }
}

function ufbNav(dir) {
    if (!_pdf || _busy) return;
    var mob = _isMobile(); var step = mob ? 1 : 2;
    var newP = _snap(_page + dir * step);
    if (newP === _page) { newP = Math.max(1, Math.min(_total, _page + dir)); if (newP === _page) return; }
    _busy = true; _page = newP;
    if (mob) _direct(_page); else _flip(_page, dir > 0 ? 'next' : 'prev');
}

function ufbGo(n) {
    n = parseInt(n, 10);
    if (isNaN(n) || n < 1 || n > _total) return;
    var np = _snap(n); if (np === _page) return;
    var dir = np > _page ? 1 : -1;
    _busy = true; _page = np;
    _isMobile() ? _direct(_page) : _flip(_page, dir > 0 ? 'next' : 'prev');
}

function ufbZoom(d) { if (!_pdf) return; _zoom = Math.max(.35, Math.min(3.5, _zoom + d)); _busy = false; _direct(_page); }
function ufbZoomReset() { if (!_pdf) return; _zoom = 1.0; _calcScale().then(function(s) { _scale = s; _busy = false; _direct(_page); }); }
function ufbFullscreen() { var el = _el('ufbOverlay'); if (!document.fullscreenElement) (el.requestFullscreen || el.webkitRequestFullscreen || function(){}).call(el); else (document.exitFullscreen || document.webkitExitFullscreen || function(){}).call(document); }

function _buildThumbs() {
    if (_thumbsBuilt || !_pdf) return;
    _thumbsBuilt = true;
    var strip = _el('ufbThumbs'); strip.innerHTML = '';
    for (var i = 1; i <= _total; i++) {
        (function(pn) {
            var th = document.createElement('div'); th.className = 'ufb-thumb'+(pn===1?' active':''); th.dataset.page = pn;
            var tc = document.createElement('canvas'); th.appendChild(tc);
            var nn = document.createElement('div'); nn.className = 'ufb-thumb-n'; nn.textContent = pn; th.appendChild(nn);
            th.onclick = function() { ufbGo(pn); }; strip.appendChild(th);
            _pdf.getPage(pn).then(function(pg) { var vp0 = pg.getViewport({scale:1}); var sc = Math.min(48/vp0.width, 68/vp0.height); var vp = pg.getViewport({scale:sc}); tc.width = vp.width; tc.height = vp.height; pg.render({canvasContext:tc.getContext('2d'),viewport:vp}).promise; });
        })(i);
    }
}

function _updateThumb(p) {
    document.querySelectorAll('.ufb-thumb').forEach(function(t) {
        var tp = parseInt(t.dataset.page, 10);
        var a = _isMobile() ? (tp===p) : (tp===p||tp===p+1);
        t.classList.toggle('active', a);
        if (a) t.scrollIntoView({behavior:'smooth',inline:'center',block:'nearest'});
    });
}

function _showSwipeHint() {
    var h = _el('ufbSwipeHint'); h.classList.add('show');
    setTimeout(function() { h.style.transition='opacity 1s'; h.style.opacity='0'; }, 2400);
    setTimeout(function() { h.classList.remove('show'); h.style.opacity=''; h.style.transition=''; }, 3600);
}

function openFlipbook(url, title) {
    _el('ufbTitle').textContent = title || 'Dokumen';
    _el('ufbDlLink').href = url;
    _el('ufbOverlay').classList.add('active');
    document.body.style.overflow = 'hidden';
    _pdf = null; _total = 0; _page = 1; _busy = false; _zoom = 1.0; _thumbsBuilt = false;
    ['ufbCanvasL','ufbCanvasR','ufbFlipFront','ufbFlipBack'].forEach(function(id) { var c = _el(id); c.width = 0; c.height = 0; c.style.display = 'none'; });
    _el('ufbFlipper').style.display = 'none'; _el('ufbFlipper').className = 'ufb-flipper';
    _el('ufbSpine').style.display = 'none'; _el('ufbThumbs').innerHTML = '';
    _el('ufbPageBadge').textContent = 'Memuat...';
    _el('ufbLoading').style.display = 'flex'; _el('ufbSceneOuter').style.display = 'none';
    if (typeof pdfjsLib === 'undefined') { _el('ufbLoading').innerHTML = '&#9888; PDF.js tidak ditemukan.'; return; }
    pdfjsLib.getDocument(url).promise.then(function(pdf) { _pdf = pdf; _total = pdf.numPages; return _calcScale(); }).then(function(s) {
        _scale = s; _el('ufbLoading').style.display = 'none'; _el('ufbSceneOuter').style.display = 'flex';
        _direct(1, function() { _buildThumbs(); if (_isMobile()) _showSwipeHint(); });
    }).catch(function(err) { _el('ufbLoading').innerHTML = '&#9888; Gagal memuat: '+(err.message||err); _busy = false; });
}
function openFlipbookHome(url, title) { openFlipbook(url, title); }

function ufbClose() {
    _el('ufbOverlay').classList.remove('active'); document.body.style.overflow = '';
    ['ufbCanvasL','ufbCanvasR','ufbFlipFront','ufbFlipBack'].forEach(function(id) { var c = _el(id); c.width = 0; c.height = 0; c.style.display = 'none'; });
    _el('ufbFlipper').style.display = 'none'; _el('ufbFlipper').className = 'ufb-flipper';
    _el('ufbSpine').style.display = 'none'; _pdf = null; _busy = false; _page = 1; _thumbsBuilt = false;
}

document.addEventListener('keydown', function(e) {
    if (!_el('ufbOverlay').classList.contains('active')) return;
    if (e.key === 'ArrowRight') ufbNav(1); if (e.key === 'ArrowLeft') ufbNav(-1);
    if (e.key === 'Escape') ufbClose();
    if (e.key === '+' || e.key === '=') ufbZoom(.15); if (e.key === '-') ufbZoom(-.15); if (e.key === '0') ufbZoomReset();
});
_el('ufbOverlay').addEventListener('click', function(e) { if (e.target === this) ufbClose(); });

/* Drag-to-pan + momentum */
(function() {
    var wrap = _el('ufbWrap'); if (!wrap) return;
    var down = false, lx, ly, vx = 0, vy = 0, raf = null;
    var FRICTION = 0.88;
    function cancel() { if (raf) { cancelAnimationFrame(raf); raf = null; } }
    function momentum() { vx *= FRICTION; vy *= FRICTION; wrap.scrollLeft -= vx; wrap.scrollTop -= vy; if (Math.abs(vx) > .4 || Math.abs(vy) > .4) raf = requestAnimationFrame(momentum); else raf = null; }
    wrap.addEventListener('mousedown', function(e) { if (_isMobile()) return; if (e.target.tagName==='BUTTON'||e.target.tagName==='A'||e.target.tagName==='INPUT') return; cancel(); down=true; vx=0; vy=0; lx=e.clientX; ly=e.clientY; wrap.classList.add('is-dragging'); e.preventDefault(); }, {passive:false});
    document.addEventListener('mousemove', function(e) { if (!down||_isMobile()) return; var dx=e.clientX-lx,dy=e.clientY-ly; vx=vx*.35+dx*.65; vy=vy*.35+dy*.65; wrap.scrollLeft-=dx; wrap.scrollTop-=dy; lx=e.clientX; ly=e.clientY; });
    document.addEventListener('mouseup', function() { if (!down) return; down=false; wrap.classList.remove('is-dragging'); if (Math.abs(vx)>1.2||Math.abs(vy)>1.2) raf=requestAnimationFrame(momentum); });
    wrap.addEventListener('wheel', function(e) {
        if (!_pdf) return; e.preventDefault(); cancel();
        var oldZoom=_zoom; _zoom=Math.max(.35,Math.min(3.5,_zoom+(e.deltaY<0?.1:-.1)));
        if (_zoom===oldZoom) return;
        var wr=wrap.getBoundingClientRect(); var cx=e.clientX-wr.left+wrap.scrollLeft; var cy=e.clientY-wr.top+wrap.scrollTop; var ratio=_zoom/oldZoom;
        _busy=false; _direct(_page, function() { wrap.scrollLeft=Math.round(cx*ratio-(e.clientX-wr.left)); wrap.scrollTop=Math.round(cy*ratio-(e.clientY-wr.top)); });
    }, {passive:false});
})();

/* Swipe (mobile) */
(function() {
    var wrap = _el('ufbWrap'); if (!wrap) return;
    var sx, sy, axis, deciding;
    wrap.addEventListener('touchstart', function(e) { if (e.touches.length!==1) return; sx=e.touches[0].clientX; sy=e.touches[0].clientY; deciding=true; axis=null; }, {passive:true});
    wrap.addEventListener('touchmove', function(e) { if (!deciding&&axis!=='h') return; var dx=e.touches[0].clientX-sx,dy=e.touches[0].clientY-sy; if (deciding&&(Math.abs(dx)>8||Math.abs(dy)>8)) { axis=Math.abs(dx)>Math.abs(dy)?'h':'v'; deciding=false; } if (axis==='h') e.preventDefault(); }, {passive:false});
    wrap.addEventListener('touchend', function(e) { if (!_isMobile()||axis!=='h') return; var dx=e.changedTouches[0].clientX-sx; if (Math.abs(dx)>42) ufbNav(dx<0?1:-1); }, {passive:true});
})();

/* Resize */
(function() {
    var t;
    window.addEventListener('resize', function() { clearTimeout(t); t=setTimeout(function() { if (!_pdf||!_el('ufbOverlay').classList.contains('active')) return; _calcScale().then(function(s) { _scale=s; _busy=false; _direct(_page); }); }, 280); });
})();

/* Dokumentasi Slider */
var _dIdx = 0;
var _dSlides = document.querySelectorAll('.dokum-slide');
function _dokRender() { document.getElementById('dokSlides').style.transform='translateX(-'+(_dIdx*100)+'%)'; document.querySelectorAll('.dokum-dot').forEach(function(d,i){d.classList.toggle('active',i===_dIdx);}); }
function dokumNav(dir) { _dIdx=(_dIdx+dir+_dSlides.length)%_dSlides.length; _dokRender(); }
function dokumGo(i) { _dIdx=i; _dokRender(); }
if (_dSlides.length > 1) setInterval(function() { dokumNav(1); }, 5000);

/* Bookshelf Search */
function filterBooksLP() {
    var q = document.getElementById('bookSearchInput').value.toLowerCase().trim();
    document.querySelectorAll('.book-card').forEach(function(card) {
        var title = card.querySelector('.book-title'); if (!title) return;
        card.style.display = (!q||title.textContent.toLowerCase().indexOf(q)!==-1) ? '' : 'none';
    });
}
</script>