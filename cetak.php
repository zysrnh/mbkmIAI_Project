<link rel="icon" href="images/favicon.ico" type="image/x-icon">

<?php


include 'ikutan/config.php';
include 'ikutan/mysqli.php';
$_GET['id'] = !isset($_GET['id']) ? null : $_GET['id'];
$id = int_filter($_GET['id']);

global $koneksi_db,$translateKal;


$hasil = $koneksi_db->sql_query( "SELECT * FROM artikel WHERE id='$id' AND publikasi=1" );

while ($data = $koneksi_db->sql_fetchrow($hasil)) {

		$topik=$data[7];
		$topik1 = $koneksi_db->sql_query( "SELECT * FROM topik WHERE id='$topik'" );

		while ($topik2 = $koneksi_db->sql_fetchrow($topik1)) {
			$topikku=$topik2[1];
		}
$urltgl=str_replace("-", "/", $data[5]);








								$url=str_replace(" ", "-", $data[1]);
		echo "<html><head><title>$data[1]</title>";
		$urlkontenxy=str_replace(" ", ", ", $data[1]);
echo '
<meta name="Description" content="'.ucwords($data[1]).'" />
<meta name="Keywords" content="'.$urlkontenxy.'" />

';








		echo "</head><body><h3 class="garis">$data[1]</h3>";
		
		echo ''.datetimess($data[5]).'<br/>'.$data[2].'';
		echo "<br/>Sumber : $judul_situs <a href=$url_situs>$url_situs</a><br>";
		echo 'Selengkapnya : <a href="'.$url_situs.'/artikel/'.$data[0].'/'.$url.'.html" title="'.$data[1].'">'.$url_situs.'/artikel/'.$data[0].'/'.$url.'.html</a></body</html>';

}

if ($id){
echo "<script language=javascript>
function printWindow() {
bV = parseInt(navigator.appVersion);
if (bV >= 4) window.print();}
printWindow();
</script>";
}
?>