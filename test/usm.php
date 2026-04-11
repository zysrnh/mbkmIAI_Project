<style>
.body {

	font-family:Tahoma, Geneva, sans-serif;
 font-size: 9px;
}

.atas{
	BORDER-RIGHT: 1px solid #CCCCCC; BORDER-TOP: 1px solid #CCCCCC; MARGIN-TOP: 1px; MARGIN-BOTTOM: 1px; BORDER-LEFT:  1px solid #CCCCCC; BORDER-BOTTOM: 1px solid #CCCCCC; BACKGROUND-COLOR: #CCCCCC;
        font-size: 11px;
	font-weight: bold;
	color: #666666;
	text-align: left;
	height: 21px;
	padding-top: 0px;
}

.tabel{
	BORDER-RIGHT: 1px solid #CCCCCC; BORDER-TOP: 1px solid #CCCCCC; MARGIN-TOP: 1px; MARGIN-BOTTOM: 1px; padding:1px; BORDER-LEFT:  1px solid #CCCCCC; BORDER-BOTTOM: 1px solid #CCCCCC; BACKGROUND-COLOR: #FFFFFF;
}

.tglcetak
{
font-size:8px;
color:#990000;

}
</style>
<?php

include 'ikutan/config.php';
include 'ikutan/mysqli.php';
$id = $_GET['id'];


global $koneksi_db,$translateKal;


		$soal=$koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM mod_data_pmb where md5(nomor)='".$id."'"));


if ($soal > 0) {

$hasil = $koneksi_db->sql_query( "SELECT * FROM mod_data_pmb WHERE md5(nomor)='$id'" );

while ($data = $koneksi_db->sql_fetchrow($hasil)) {

  $tglkartu = date('d');		
$array_bulan = array(1=>'Januari','Februari','Maret', 'April', 'Mei', 'Juni','Juli','Agustus','September','Oktober', 'November','Desember');
$bulankartu = $array_bulan[date('n')];		
$thnkartu = date('Y');
$prodi = $data['prodi'];
$bayar = $data['bayar'];
$prodixx = $data['nama'];
$prodiyy = $data['oleh2'];

$propinsi12xx = $koneksi_db->sql_query("SELECT * FROM mod_data_profil WHERE id='1'");
while($p111=$koneksi_db->sql_fetchrow($propinsi12xx)){

$nn = $p111['nama'];
$gg = $p111['alamat'];
$hh = $p111['telp'];
$ii = $p111['email'];
$iif = $p111['foto'];
}




$k1k = $koneksi_db->sql_query("SELECT * FROM mod_data_prodi WHERE kode='$prodi'");
while($kk1k=$koneksi_db->sql_fetchrow($k1k)){
$idk1k = $kk1k['id'];
	$namak1k = $kk1k['nama'];
}

$propinsi12xx2 = $koneksi_db->sql_query("SELECT * FROM mod_data_periode WHERE id='1'");
while($p11xx2=$koneksi_db->sql_fetchrow($propinsi12xx2)){
	$berkas = $p11xx2['berkas'];
$usm = $p11xx2['usm'];
}		
	
	
	if($bayar==0)
	{
		
		echo '<h4>Maaf anda belum melakukan konfrmasi pembayaran atau data pembayaran anda belum di konfirmasi panitia.</h4>';
	} else {
		

	
echo "

<body class='body'>
<table style='width: 650px;' border='0' cellspacing='0' cellpadding='0'>
<tbody>
<tr>
<td width='148'>
<p align='center'><img src='images/".$iif."' width='110px'></p>
</td>
<td colspan='4' valign='top' width='502'>
<p><strong>&nbsp;</strong><br/><strong>KARTU PESERTA</strong><br/>UJIAN SELEKSI MASUK (USM) MAHASISWA BARU<br/>".$nn."</p>
<hr/>

</td>
</tr>

</tbody></table>
";


	$lahir2 = str_replace("-", "", $data['lahir']);	

echo '<br/>
<table style="width: 650px;">
<tr>
<td>Nomor Pendaftaran</td>
<td>:</td>
<td>'.$data['nomor'].'</td>
</tr>
<tr>
<td>Nama Lengkap</td>
<td>:</td>
<td>'.$data['nama'].'</td>
</tr>
<tr>
<td>Prodi Pilihan</td>
<td>:</td>
<td>'.$data['prodi'].' - '.$namak1k.'</td>
</tr>
<tr>
<td>Pelaksanaan USM: </td>
<td>:</td>
<td>05 Agustus 2025</td>
</tr>
<tr>
<td>Gelombang</td>
<td>:</td>
<td>'.$data['gel'].'</td>
</tr>
<tr>
<td>Ruang Ujian</td>
<td>:</td>
<td>Kampus '.$nn.'</td>
</tr>

</table>
';

echo "
<table align=right border='0' cellspacing='0' cellpadding='0'>
<tbody>



<tr>

<td valign='top' width='250'>
<br/><p><span style='text-decoration;'>
<br/>

<br/><br/><br/><br/>
</p>
</td>

<td valign='top' width='250'>
<br/><p><span style='text-decoration;'>
<br/>

<br/><br/><br/><br/>";
echo '';

echo "
 </p>
</td>
<td valign='top' width='250'>
<br/><p><span style='text-decoration;'>
<br/>
Peserta,
<br/><br/><br/><br/>";
echo ''.$prodixx.'';

echo '</p>
</td>
</tr>
</tbody>
</table>



<table>
<tr><td>
<p>

<br/>
KETENTUAN :<br/>
<ul>
<p>1.Membawa persyaratan lengkap yang sudah ditentukandan dimasukan ke map berwarna sesuai prodi pilihan:</p>
<ul>
<li>Map Hijau : S1 Keperawan&nbsp;</li>
<li>Map Kuninh : S1 Kesehatan Masyarakat</li>
<li>Map Biru: S1 Kebidanan dan D3</li>
</ul>
<p>2. Jadwal akan diumumkan di Grup WA PCMB_AK25 STKINDO WU</p>
<p>3. Pakaian rapi dan sopan, tidak memakai sendal, celana jean atau kaos oblong</p>
<p>4. Membawa Kartu Peserta dan Alat Tulis</p>
<p>5. Tes Kelulusan:&nbsp;</p>
<ul>
<li>Ujian Tulis</li>
<li>Tes Kesehatan</li>
<li>Tes Wawancara&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</li>
</ul>
</ul>



</p>
</td></tr>
</table>




';

echo "





</body>










";
		}
	
	

	
}
if ($id){
echo "<script language=javascript>
function printWindow() {
bV = parseInt(navigator.appVersion);
if (bV >= 4) window.print();}
printWindow();
</script>";
}

} else {
		echo 'Tidak ada data';
	}


?>