<h4>Hasil Polling</h4><br/><p>
<?php



$index_hal = 1;

$pid = int_filter(@$_POST['pid']);
$pilihan = int_filter(@$_POST['pilihan']);

$cetak['tengah'] = '';



$sekarang_timeout = time ();
$vote_lebih2x = false;	
if(isset($_POST['submit']))
{
	//setcookie("COOKIE_VOTE", "vote", time()+3600);
	
	
	
	
	
	$query1 = "SELECT * FROM polling WHERE pid='$pid'";
	if(cek_posted('polling_result.php'))
	{
	
	$vote_lebih2x = true;	
		
		
	}
	else
	{
		
		posted('polling_result.php');
		//---- baca data polling
		$hasil = $koneksi_db->sql_query($query1);
		$data = $koneksi_db->sql_fetchrow($hasil);
		$PJAWABAN_TMP = explode("#", $data["pjawaban"]);
		$jmljwb = count($PJAWABAN_TMP);
		$PJAWABAN_TMP[$pilihan]++;
		$PJAWABAN = '';
		for($i=0;$i<$jmljwb;$i++)
		{
			$PJAWABAN .= $PJAWABAN_TMP[$i] . "#";
		}
		$PJAWABAN = substr_replace($PJAWABAN, "", -1, 1);
		//-----------------------------------------------
	
		//---- simpan data terbaru
		$query2 = "UPDATE `polling` SET `pjawaban`='$PJAWABAN' WHERE `pid`='$pid'";
		$koneksi_db->sql_query($query2);

		// ----------------------------------------------------------------------
	}
}




if (isset ($_POST['pid'])){
$cetak['tengah'].='<div>';

$pid = int_filter ($_POST['pid']);
//$type_poll = 'chart';
$data_s = $koneksi_db->sql_fetchrow( $koneksi_db->sql_query("SELECT * FROM polling WHERE pid='$pid'"));


//tampilkan data terbaru
$hasil =$koneksi_db->sql_query("SELECT * FROM polling WHERE pid='$pid'");

$data = $koneksi_db->sql_fetchrow($hasil);
$PJUDUL = $data["pjudul"];
$PPILIHAN = explode("#", $data["ppilihan"]);
$PJAWABAN = explode("#", $data["pjawaban"]);
$jmlpil = count($PPILIHAN);
$JMLVOTE = 0;
for($i=0;$i<$jmlpil;$i++)
{
	$JMLVOTE = $JMLVOTE + $PJAWABAN[$i];
}
// Jika tidak ada vote, tetapkan jumlah vote = 1 untuk menghindari pembagian dengan nol
if($JMLVOTE == 0)
{
	$JMLVOTE = 1;
}

$cetak['tengah'].= "<b>Hasil vote untuk polling :</b> $PJUDUL";
$cetak['tengah'].= "<table  border='0' style=\"width:100%\" cellpadding='0' cellspacing='0'>";

   
	asort($PJAWABAN);
	$no = 0;
	foreach ($PJAWABAN as $key => $val) {
	$persentase = round($PJAWABAN[$key] / $JMLVOTE * 100, 2);
	
	if ($no % 2 == 0){
		$bgcolor = 'bgcolor="#efefef"';
	}else {
		$bgcolor = '';
	}
	
	$cetak['tengah'].= "<tr $bgcolor style=\"height:20px;\">";
	$cetak['tengah'].= "<td style='width:22%'>" . $PPILIHAN[$key] . "</td>";
	//$loop = floor($persentase)*3;
	$loop = floor($persentase);
	$cetak['tengah'].= "<td width='60%'>";
	if ($loop <= 1 ){
		$loop = 1;
	}
		$td =$no % 12 ;
        $class ="bar".$td;
		$gambar = "bar/$class.gif";
		
		//echo $loop;
	$cetak['tengah'].= '<div style="background: #FFE5BB;width:'.$loop.'%;border: 1px solid #d1d1d1;height:10px"></div>';
		//$cetak['tengah'].= "<img src='$gambar' width='$loop' height='10'>";
	$cetak['tengah'].= "</td>";
	$cetak['tengah'].= "<td style=\"margin-left:3px;padding:5px;width:18%\">";
	$cetak['tengah'].= $PJAWABAN[$key] . " = $persentase%";
	$cetak['tengah'].= "</td>";
	$cetak['tengah'].= "</tr>";
	$no++;
}
$cetak['tengah'].= "</table>";
$cetak['tengah'].= "<p>total voting : $JMLVOTE";

if ($vote_lebih2x){
$cetak['tengah'].= "<br /><br />anda telah melakukan Vote lebih dari 1 kali";	
}



$cetak['tengah'].= "</div>";


}else {
        $cetak['tengah'] .='<div><table width="100%"><tr><td ><img src="images/warning.gif" border="0"></td><td align="center"><div class="error">Maaf Tidak ada Polling</div></td><td align="right"><img src="images/warning.gif" border="0"></td></tr></table></div>';

}

echo $cetak['tengah'];
?>

