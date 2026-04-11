<?php
include 'ikutan/config.php';
include 'ikutan/mysqli.php';
$kota5 = $_GET['kota5'];
$kec5 =$koneksi_db->sql_query("SELECT id,nama_kecamatan FROM kecamatan WHERE  kabkota_id='$kota5' order by id");

echo "<option>-- Pilih Kecamatan --</option>";
while($kec = $koneksi_db->sql_fetchrow($kec5)){
	
    echo "<option value=\"".$kec['id']."\">".$kec['nama_kecamatan']."</option>\n";
}
?>
