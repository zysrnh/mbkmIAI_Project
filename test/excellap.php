<?php
include 'ikutan/config.php';
include 'ikutan/mysqli.php';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=LAPORAN PMB.xls");
?>


<?php

echo '<form method="POST" action="" id="namaform">
<div class="table-responsive">
<table class="table table-hover">';

echo '<tr>
	<th>No.</td>
<th>Kode</th>
<th>Nama</th>

	<th>Pendaftar</th>
<th>Sudah Bayar</th>

</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_prodi` ORDER By `id` ASC");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#f9f9f9"';
else $warna = null;	
$no ++;
$id = $data['kode'];

$ada=$koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM mod_data_pmb where prodi='".$id."'"));
$ada2=$koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM mod_data_pmb where prodi='".$id."' AND status='1'"));
$ada3=$koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM mod_data_pmb where prodi='".$id."' AND status='1' AND lulus='Lulus'"));

echo '<tr>
	<td>'.$no.'</td>
<td>'.$data['kode'].'</td>

<td>'.$data['nama'].'</td>

	<td>'.$ada.'</td>
<td>'.$ada2.'</td>

</tr>';
}



echo '</table></div>
';



?>