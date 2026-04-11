<?php
include 'ikutan/config.php';
include 'ikutan/mysqli.php';
$prodi = cleartext($_GET['prodi']);
$soal=$koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM mod_data_prodi where kode='".$prodi."'"));
if ($soal > 0) {
$q3 = $koneksi_db->sql_query ("SELECT * FROM `mod_data_prodi`  WHERE kode='".$prodi."'");
while ($data3 = $koneksi_db->sql_fetchrow($q3)){
	$nama2333 = $data3['nama'];
	$tampung = $data3['tampung'];
}
$prop1xysx= $koneksi_db->sql_query("SELECT * FROM mod_data_periode ORDER By id DESC LIMIT 1");
while($pr1xysx=$koneksi_db->sql_fetchrow($prop1xysx)){
	$idkatsx = $pr1xysx['tahun'];
}
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=PMB ".$idkatsx ." ".$nama2333.".xls");
?>


<?php




echo '
<div class="table-responsive">
<table class="table table-hover">';

echo '<tr>
	<th>No.</td>
<th>Nomor</th>
<th>Prodi</th>
<th>SK</th>
<th>Informasi</th>
<th>TB</th>
<th>BB</th>
<th>Nama</th>
<th>Tempat</th>
<th>Lahir</th>
<th>Kelamin</th>
<th>Nik</th>
<th>Agama</th>
<th>Telp</th>
<th>Email</th>
<th>Kwn</th>
<th>Jenis</th>
<th>Tanggal</th>

<th>Prov</th>
<th>Kab</th>
<th>Kec</th>
<th>Kel</th>
<th>Alamat</th>
<th>RT</th>
<th>RW</th>
<th>NPSN</th>
<th>Jalur PMB</th>
<th>Ibu</th>
<th>Asal Sekolah</th>
<th>NISN</th>
<th>Status</th>
<th>Nilai</th>
<th>Lulus</th>

</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_pmb` WHERE status='1' AND prodi='$prodi' AND lulus='Lulus' ORDER By `nilai` DESC LIMIT $tampung");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#f9f9f9"';
else $warna = null;	
$no ++;
$id = $data['id'];
$prov = $data['prov'];
$kab = $data['kab'];
$kec = $data['kec'];
$kel = $data['kel'];


$k2 = $koneksi_db->sql_query("SELECT * FROM provinsi WHERE id='$prov'");
while($kk2=$koneksi_db->sql_fetchrow($k2)){
$idk2 = $kk2['id'];
	$namak2 = $kk2['nama_provinsi'];
}

$k3 = $koneksi_db->sql_query("SELECT * FROM kabkota WHERE id='$kab'");
while($kk3=$koneksi_db->sql_fetchrow($k3)){
$idk3 = $kk3['id'];
	$namak3 = $kk3['nama_kabkota'];
}

$k4 = $koneksi_db->sql_query("SELECT * FROM kecamatan WHERE id='$kec'");
while($kk4=$koneksi_db->sql_fetchrow($k4)){
$idk4 = $kk4['id'];
	$namak4 = $kk4['nama_kecamatan'];
}

$k5 = $koneksi_db->sql_query("SELECT * FROM kelurahan WHERE id='$kel'");
while($kk5=$koneksi_db->sql_fetchrow($k5)){
$idk5 = $kk5['id'];
	$namak5 = $kk5['nama_kelurahan'];
}
echo '<tr>
	<td>'.$no.'</td>
<td>'.$data['nomor'].'</td>
<td>'.$data['prodi'].'</td>
<td>'.$data['sumber'].'</td>
<td>'.$data['get_info'].'</td>
<td>'.$data['height'].' cm</td>
<td>'.$data['weight'].' kg</td>
<td>'.$data['nama'].'</td>
<td>'.$data['tempat'].'</td>
<td>'.$data['lahir'].'</td>
<td>'.$data['kelamin'].'</td>
<td>'.$data['nik'].'</td>
<td>'.$data['agama'].'</td>
<td>'.$data['telp'].'</td>
<td>'.$data['email'].'</td>
<td>'.$data['kwn'].'</td>
<td>'.$data['jenis'].'</td>
<td>'.$data['tanggal'].'</td>

<td>'.$namak2.'</td>
<td>'.$namak3.'</td>
<td>'.$namak4.'</td>
<td>'.$namak5.'</td>
<td>'.$data['alamat'].'</td>

<td>'.$data['rt'].'</td>
<td>'.$data['rw'].'</td>



<td>'.$data['npsn'].'</td>
<td>'.$data['sumber2'].'</td>
<td>'.$data['ibu'].'</td>
<td>'.$data['sekolah'].'</td>
<td>'.$data['nisn'].'</td>
<td>'.$data['status'].'</td>
<td>'.$data['nilai'].'</td>
<td>'.$data['lulus'].'</td>


	
	
</tr>';
}


  

echo '</table></div>';
} else {
		echo 'Tidak ada data';
	}

?>