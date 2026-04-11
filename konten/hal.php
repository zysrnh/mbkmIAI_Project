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
		$tengah .='<div class="error">Halaman tidak tersedia.</div>';
}else {




$tengah .='  <h3 class="garis">'.$data['judul'].'</h3>

';

$tengah .='<div>';
$gambar = $data['foto'];
if(!$gambar)
{
	$tengah .= $data['konten'];
} else {
	
	$tengah .='<img class="img-fluid" width="40%" style="float:left;padding-right:10px;margin-top:10px;" src="images/pages/'.$data['foto'].'"><br/><div style="margin-top:-10px;">'.$data['konten'].'</div>';
}






$tengah .='</div>';

}
echo $tengah;

?> 