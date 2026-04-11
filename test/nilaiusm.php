<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:5px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:5px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-cly1{text-align:left;vertical-align:middle}
.tg .tg-0lax{text-align:left;vertical-align:top}
</style>
<?php

include 'ikutan/config.php';
include 'ikutan/mysqli.php';
$prodi = $_GET['prodi'];
$gel = $_GET['gel'];


global $koneksi_db,$translateKal;

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
<table style='width: 100%;font-family:Arial, sans-serif;font-size:14px;' border='0' cellspacing='0' cellpadding='0'>
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

<center>PRODI $namak1k GELOMBANG $gel</center><br/>
</td>
</tr>
</tbody></table>
";
	
	
	
	echo '<table class="tg" width="100%"> <tr>
<th>No.</td>
<th>Nomor</td>

<th>Nama Lengkap</th>
';


$query2 = $koneksi_db->sql_query ("SELECT * FROM `mod_data_aspek` ORDER By `id` ASC");
while ($data2 = $koneksi_db->sql_fetchrow($query2)){
	
echo '<th>'.$data2['nama'].' ('.$data2['bobot'].'%)</th>';
}






echo '
<th>Nilai Akhir (100%)</th>
<th>Status</th>
</tr>';
	
	
	

$hasil = $koneksi_db->sql_query( "SELECT * FROM mod_data_pmb WHERE status='1' AND prodi='$prodi' AND gel='$gel'" );

while ($data = $koneksi_db->sql_fetchrow($hasil)) {

 $id = md5($data['id']);

$no ++;
$id2 = $data['id'];
$nomor = $data['nomor'];

echo '<tr>


<td>'.$no.'.</td>
<td>'.$data['nomor'].'</td>
<td>'.$data['nama'].'</td>

';


$query2 = $koneksi_db->sql_query ("SELECT * FROM `mod_data_aspek` ORDER By `id` ASC");
while ($data2 = $koneksi_db->sql_fetchrow($query2)){
	
	$id3 = $data2['id'];
		$bobot = $data2['bobot'];
	
	
	$prop1xy2= $koneksi_db->sql_query("SELECT * FROM mod_data_nilai WHERE nomor='$nomor' AND aspek='$id3' AND prodi='$prodi'");
while($pr1xy2=$koneksi_db->sql_fetchrow($prop1xy2)){
$namakat2 = $pr1xy2['nilai'];
}

		$adaxx=$koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM mod_data_nilai where prodi='".$prodi."' and nomor='".$nomor."' and aspek='".$id3."'"));

	
echo '
	
	<input type="hidden" name="nomor[]" value="'.$nomor.'"/>
<input type="hidden" name="prodi[]" value="'.$prodi.'"/>
<input type="hidden" name="aspek[]" value="'.$id3.'"/>
<input type="hidden" name="bobot[]" value="'.$bobot.'"/>';
	if($adaxx > 0)
	{
			echo '<td>'.$namakat2.'</td>';
	} else {
			echo '<td></td>';
	}
	
}


$resultkx = $koneksi_db->sql_query('SELECT SUM(na) AS value_sum FROM mod_data_nilai WHERE nomor="'.$nomor.'" AND  prodi="'.$prodi.'"'); 
$rowkx = $koneksi_db->sql_fetchrow($resultkx); 
$sumkx = $rowkx['value_sum'];   

echo '

<td>'.$sumkx.'</td>
<td>'.$data['lulus'].'</td>
</tr>';
}



echo '</table></div>
';
	

	

if ($gel){
echo "<script language=javascript>
function printWindow() {
bV = parseInt(navigator.appVersion);
if (bV >= 4) window.print();}
printWindow();
</script>";
}




?>