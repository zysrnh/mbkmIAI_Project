<?php
// Inner page hero banner
global $koneksi_db;
$hero_title = "MBKM IAI PI BANDUNG";
$hero_desc = "Informasi Detail & Halaman Konten";

if (isset($_GET['pilih']) && $_GET['pilih'] === 'hal' && isset($_GET['id'])) {
    $id_hal = (int)$_GET['id'];
    $hal_res = $koneksi_db->sql_query("SELECT judul FROM halaman WHERE id='$id_hal'");
    if ($h = $koneksi_db->sql_fetchrow($hal_res)) {
        $hero_title = mb_strimwidth($h['judul'], 0, 50, '...');
    }
}
?>
<div style="background: #306238; padding: 140px 0 50px; color: white; text-align: center; position:relative; z-index:1;">
    <div class="container" style="position:relative; z-index:2;">
        <h1 style="color:white; margin:0; font-weight:700; letter-spacing:1px;font-size:2rem;text-transform:uppercase;"><?= htmlspecialchars($hero_title) ?></h1>
        <p style="margin-top:10px; color:#9EBB97; font-size:16px;"><?= htmlspecialchars($hero_desc) ?></p>
    </div>
    <!-- Overlay subtle pattern -->
    <div style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0.05; background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px; z-index:1;"></div>
</div>
<div style="background: #f8f9fa; padding:40px 0;">
