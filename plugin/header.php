<?php
echo '
<style>
.custom-hero {
    background: #0d47a1; /* Deep blue to match nav */
    color: #fff;
    padding: 180px 50px 100px;
    position: relative;
    overflow: hidden;
    min-height: 500px;
}
.custom-hero h1 {
    font-size: 55px;
    font-weight: 800;
    margin: 0;
    line-height: 1.2;
    color: #fff;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}
.custom-hero h2 {
    font-size: 32px;
    font-weight: 600;
    margin-top: 20px;
    color: #fff;
}
.custom-hero .hero-content {
    max-width: 700px;
    position: relative;
    z-index: 2;
    margin-top: 50px;
}
.hero-graphic {
    position: absolute;
    right: 15%;
    top: 50%;
    transform: translateY(-40%);
    width: 250px;
    z-index: 1;
}
.wave-bottom {
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 100%;
    line-height: 0;
}
.wave-bottom svg {
    display: block;
    width:calc(100% + 1.3px);
    height: 120px;
}
</style>
<div class="custom-hero">
    <div class="container relative" style="position:relative; height: 100%;">
        <div class="col-md-8 hero-content">
            <h1>PROGRAM MERDEKA<br>BELAJAR BERDAMPAK</h1>
            <h2>Universitas IAI PI Bandung</h2>
        </div>
        <div class="col-md-4 hero-graphic hidden-xs hidden-sm">
            <!-- Simulated 3D Graphic from Screenshot -->
            <div style="position:relative; width: 140px; height: 280px; margin:auto;">
               <div style="position:absolute; left:0; top:20px; width:120px; height:240px; background: linear-gradient(to bottom, #1976d2, #0d47a1); border-radius:20px 80px 80px 20px; box-shadow: -10px 10px 25px rgba(0,0,0,0.4);"></div>
               <div style="position:absolute; width:65px; height:65px; background:#ffca28; border-radius:50%; top:40px; right: -30px; box-shadow: 5px 5px 15px rgba(0,0,0,0.2);"></div>
               <div style="position:absolute; width:85px; height:130px; background:linear-gradient(to bottom, #ffca28, #f57f17); border-radius:20px 80px 80px 20px; bottom:20px; right: -30px; box-shadow: 5px 5px 15px rgba(0,0,0,0.2);"></div>
            </div>
        </div>
    </div>
    <div class="wave-bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120H1440V60C1440 60 1100 0 720 0C340 0 0 60 0 60V120Z" fill="#ffffff"/>
        </svg>
    </div>
</div>
';
?>