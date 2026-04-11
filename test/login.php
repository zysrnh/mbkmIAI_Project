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
$id = cleartext($_GET['id']);


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
	
echo "

<body class='body'>
<table style='width: 650px;' border='0' cellspacing='0' cellpadding='0'>
<tbody>
<tr>
<td width='148'>
<p align='center'><img src='images/".$iif."' width='110px'></p>
</td>
<td colspan='4' valign='top' width='502'>
<p><strong>&nbsp;</strong><br/><strong>".$nn."</strong><br/>".$gg.". Telp. ".$hh."<br/>Email&nbsp; ".$ii."</p>
<hr/>

</td>
</tr>
<tr>
<td colspan='5' valign='top' width='650'>

<center>Login Pendaftaran</center><br/>
</td>
</tr>
</tbody></table>
";


	$lahir2 = str_replace("-", "", $data['lahir']);	

echo '
<table style="width: 650px;">

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
<td>Biaya Pendaftaran</td>
<td>:</td>
<td>'.matauang($data['biaya']).'</td>
</tr>
</table>
<table>
<tr><td>
<p><br/>Informasi Login :</p>
</td></tr>
</table>


<table style="width: 650px;">
<tr>
<td>Username</td>
<td>:</td>
<td>'.$data['nomor'].'</td>
</tr>
<tr>
<td>Password</td>
<td>:</td>
<td>'.$lahir2.'</td>
</tr>


</table>

<table>
<tr><td>
<p>

<br/>
Pembayaran uang pendaftaran di Kampus STKINDO WIRAUTAMA Jl. Raya Andir No 17B ; Jl. Raya Laswi No.742 Kec. Ciparay Kab. Bandung atau Transfer ke Norek BRI 013201001457308 an : stkindowirautama
<br/><br/>
Kemudian login dan upload bukti transfer pembayaran lalu cetak bukti pendaftaran.

<br/><br/>
Berkas paling lambat di kumpulkan pada '.$berkas.'<br/>
Informasi tambahan : Pelaksanaan USM pada '.$usm.'




</p>
</td></tr>
</table>




';

echo "




<table align=right border='0' cellspacing='0' cellpadding='0'>
<tbody>



<tr>

<td valign='top' width='250'>
<br/>
</td>

<td valign='top' width='250'>

</td>
<td valign='top' width='250'>
<br/><p><span style='text-decoration;'>Bandung, ".$tglkartu." ".$bulankartu." ".$thnkartu."
<br/>
Pendaftar,
<br/><br/><br/><br/>";
echo ''.$prodixx.'';

echo "</p>
</td>
</tr>
</tbody>
</table>

</body>










";
	
	

	
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