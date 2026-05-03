<?php
echo '
<style>
/* ── HERO SECTION ── */
.custom-hero {
    background: linear-gradient(145deg, rgba(27,67,50,0.85) 0%, rgba(27,67,50,0.7) 60%, rgba(45,106,79,0.85) 100%), url("images/Assets/Kampus.png");
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    color: #fff;
    padding: 140px 0 0;
    position: relative;
    overflow: hidden;
    min-height: 520px;
}

/* Subtle texture overlay */
.custom-hero::before {
    content: \'\';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse at 20% 50%, rgba(158,187,151,.12) 0%, transparent 60%),
        radial-gradient(ellipse at 80% 20%, rgba(221,229,205,.07) 0%, transparent 50%);
    z-index: 0;
}

/* Geometric accent circles */
.custom-hero::after {
    content: \'\';
    position: absolute;
    right: -60px; bottom: 40px;
    width: 420px; height: 420px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,.07);
    z-index: 0;
}

.hero-inner {
    position: relative;
    z-index: 2;
    padding: 0 20px;
}

/* Eyebrow label */
.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,255,255,.10);
    border: 1px solid rgba(255,255,255,.16);
    border-radius: 30px;
    padding: 6px 18px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #F8F9FA;
    margin-bottom: 22px;
}
.hero-eyebrow span {
    width: 6px; height: 6px;
    background: #F8F9FA;
    border-radius: 50%;
    display: inline-block;
}

.custom-hero h1 {
    font-family: \'Inter\', sans-serif;
    font-size: 52px;
    font-weight: 900;
    margin: 0 0 16px;
    line-height: 1.1;
    color: #ffffff;
    letter-spacing: -1.5px;
    text-shadow: 0 4px 20px rgba(0,0,0,0.4);
}
.custom-hero h1 .accent {
    color: #ffffff;
}

.custom-hero .hero-sub {
    font-size: 15px;
    font-weight: 400;
    color: rgba(221,229,205,.8);
    margin: 0 0 36px;
    line-height: 1.7;
    max-width: 520px;
}

.custom-hero .hero-content {
    max-width: 660px;
    position: relative;
    z-index: 2;
    padding-bottom: 120px;
}

/* Hero CTA buttons */
.hero-actions { display: flex; gap: 16px; flex-wrap: wrap; align-items: center; }
.hero-btn-primary {
    display: inline-block;
    background: #F8F9FA;
    color: #1B4332;
    padding: 13px 32px;
    border-radius: 30px;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    letter-spacing: .2px;
    transition: all .28s cubic-bezier(.4,0,.2,1);
    border: 2px solid #F8F9FA;
}
.hero-btn-primary:hover {
    background: transparent;
    color: #F8F9FA;
    text-decoration: none;
}
.hero-btn-outline {
    display: inline-block;
    border: 2px solid rgba(255,255,255,.35);
    color: rgba(255,255,255,.88);
    padding: 13px 28px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: all .28s cubic-bezier(.4,0,.2,1);
}
.hero-btn-outline:hover {
    border-color: #F8F9FA;
    color: #F8F9FA;
    text-decoration: none;
}

/* Floating stats bar */
.hero-stats-bar {
    position: absolute;
    right: 5%; top: 50%;
    transform: translateY(-50%);
    display: flex; flex-direction: column; gap: 14px;
    z-index: 2;
}
@media (max-width: 991px) { .hero-stats-bar { display: none; } }
@media (max-width: 768px) {
    .custom-hero { padding: 120px 0 0; min-height: 480px; }
    .custom-hero h1 { font-size: 32px; text-align: center; }
    .custom-hero .hero-sub { font-size: 14px; text-align: center; margin-left: auto; margin-right: auto; }
    .custom-hero .hero-content { padding-bottom: 80px; text-align: center; width: 100%; max-width: 100%; flex: 0 0 100%; }
    .hero-actions { justify-content: center; gap: 12px; }
    .hero-btn-primary, .hero-btn-outline { width: 100%; max-width: 250px; text-align: center; padding: 12px 20px; font-size: 13px; }
    .wave-bottom svg { height: 50px; }
}

.hero-stat-pill {
    background: rgba(255,255,255,.10);
    border: 1px solid rgba(255,255,255,.18);
    border-radius: 12px;
    padding: 14px 22px;
    backdrop-filter: blur(10px);
    text-align: center;
    min-width: 130px;
}
.hero-stat-pill .sp-num {
    color: #F8F9FA;
    font-size: 26px;
    font-weight: 900;
    display: block;
    line-height: 1;
    letter-spacing: -.5px;
}
.hero-stat-pill .sp-lbl {
    color: rgba(221,229,205,.7);
    font-size: 10.5px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 4px;
    display: block;
}

/* Wave bottom */
.wave-bottom {
    position: absolute;
    bottom: -2px; left: 0;
    width: 100%; line-height: 0; z-index: 3;
}
.wave-bottom svg {
    display: block;
    width: calc(100% + 1.3px);
    height: 90px;
}
</style>

<div class="custom-hero">
    <div class="container" style="position:relative; z-index:2;">
        <div class="col-md-8 hero-content hero-inner">

            <h1>MERDEKA BELAJAR<br><span class="accent">BERDAMPAK NYATA</span></h1>
            <p class="hero-sub">Institut Agama Islam Persis Bandung berkomitmen menghadirkan pengalaman belajar autentik melalui 8 program MBKM yang terstruktur dan berdampak.</p>
            <div class="hero-actions">
                <a href="register.php" class="hero-btn-primary">Daftar Sekarang</a>
                <a href="index.php?pilih=flipbook&modul=yes" class="hero-btn-outline">Lihat Pedoman</a>
            </div>
        </div>


    </div>

    <div class="wave-bottom">
        <svg viewBox="0 0 1440 90" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 90H1440V40C1200 10 960 0 720 0C480 0 240 10 0 40V90Z" fill="#ffffff"/>
        </svg>
    </div>
</div>
';
?>