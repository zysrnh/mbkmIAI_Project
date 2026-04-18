<?php



if (!defined('cms-KONTEN')) {
	Header("Location: ../index.php");
	exit;
}

$index_hal=1;

$tengah='';

global $koneksi_db;

$id = int_filter($_GET['id']);
$hasil = $koneksi_db->sql_query( "SELECT judul,konten,foto FROM halaman WHERE id='$id'" );
$data = $koneksi_db->sql_fetchrow($hasil) ;

$judulnya = $data['judul'];

$urlkontenxhal=str_replace(" ", ", ", $judulnya);


$judul_situs = ucwords($data['judul']);
$_META['description'] = limitTXT2(htmlentities(strip_tags($data['konten'])),140);
$_META['keywords'] = $urlkontenxhal;




if (empty ($judulnya)){
		$tengah .='<div class="container"><div class="alert alert-danger" style="margin-top:20px;">Halaman tidak tersedia atau telah dihapus.</div></div>';
}else {

$tengah .='<div class="container">';
$tengah .='<div style="background:#fff; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.05); padding:40px; margin-bottom:40px;">';

$tengah .='<div class="hal-content" style="line-height:1.8; color:#444; font-size:16px;">';
$gambar = $data['foto'];
if(!$gambar)
{
	$tengah .= $data['konten'];
} else {
	$tengah .='<img class="img-fluid" style="float:left; padding-right:20px; padding-bottom:15px; margin-top:5px; max-width:45%; border-radius:8px;" src="images/pages/'.$data['foto'].'"><div style="display:flow-root;">'.$data['konten'].'</div>';
}

$tengah .='</div>'; // end hal-content
$tengah .='</div>'; // end card
$tengah .='</div>'; // end container

}
echo $tengah;

?> 