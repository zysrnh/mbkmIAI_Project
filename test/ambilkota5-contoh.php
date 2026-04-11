<?php
include 'ikutan/config.php';
include 'ikutan/mysqli.php';
$propinsi5x = $_GET['propinsi5'];

$propinsi5e= $koneksi_db->sql_query("SELECT * FROM mod_data_barang WHERE kat='$propinsi5x' ORDER By id ASC");
echo "<option>-- Pilih Barang --</option>";
while($pr1xye=$koneksi_db->sql_fetchrow($propinsi5e)){
	$idkate = $pr1xye['id'];
$namakate = $pr1xye['nama'];
echo '<option value="'.$idkate.'">'.$namakate.'</option>';
}
?>
