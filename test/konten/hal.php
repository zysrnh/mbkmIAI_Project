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




$tengah .='  <h4>'.$data['judul'].'</h4>

';

$tengah .='<div>';
$gambar = $data['foto'];

	$tengah .= $data['konten'];







$tengah .='</div>';

}
echo $tengah;

?> 