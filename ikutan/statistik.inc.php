<?php

$penambahan_waktu = 0;
$sjam = date('G' , time() + $penambahan_waktu);
$sbulan = date('m', time() + $penambahan_waktu);
$shari = date('w', time() + $penambahan_waktu);
$stanggal = date('d', time() + $penambahan_waktu);
function stats(){
/* Get the Browser data */
global $koneksi_db, $sbulan,$shari,$sjam;
include('user_agents.php');

if (isset($_SERVER['HTTP_USER_AGENT']))
{
	$agent = trim($_SERVER['HTTP_USER_AGENT']);
}


foreach ($platforms as $key => $val)
{
	if (preg_match("|".preg_quote($key)."|i", $agent))
	{
		//$os = $val;
		return TRUE;
	}
}
			
    if((preg_match("/\Nav/", $agent)) || (preg_match("/\Gold/", $agent)) || (preg_match("/\X11/", $agent)) || (preg_match("/\Mozilla/", $agent)) || (preg_match("/\Netscape/", $agent)) AND (!preg_match("/\MSIE/", $agent)) AND (!preg_match("/\Konqueror/", $agent))) $browser =0;   //"Netscape";
    // Opera needs to be above MSIE as it pretends to be an MSIE clone
    elseif(preg_match("/\Opera/", $agent)) $browser = 1;    // "Opera";
    elseif(preg_match("/\MSIE 4.0/", $agent)) $browser =2;   //"MSIE 4.0";
    elseif(preg_match("/\MSIE 5.0/", $agent)) $browser =3;  // "MSIE 5.0";
    elseif(preg_match("/\MSIE 6.0/", $agent)) $browser =4; //"MSIE 6.0";
    elseif(preg_match("/\Lynx/", $agent)) $browser =5;   // "Lynx";
    elseif(preg_match("/\WebTV/", $agent)) $browser = 6;       //"WebTV";
    elseif(preg_match("/\Konqueror/", $agent)) $browser =7;   //"Konqueror";
    elseif((preg_matchi("bot/", $agent)) || (preg_match("/\Google/", $agent)) || (preg_match("/\Slurp/", $agent)) || (preg_match("/\Scooter/", $agent)) || (preg_matchi("Spider/", $agent)) || (preg_matchi("Infoseek/", $agent))) $browser =8;   //"Bot";
    else $browser =9;   

    if(preg_match("/\Win/", $agent)) $os =0;// "Windows";
    elseif((preg_match("/\Mac/", $agent)) || (preg_match("/\PPC/", $agent))) $os =1;// "Mac";
    elseif(preg_match("/\Linux/", $agent)) $os =2;// "Linux";
    elseif(preg_match("/\FreeBSD/", $agent)) $os =3;// "FreeBSD";
    elseif(preg_match("/\SunOS/", $agent)) $os =4;// "SunOS";
    elseif(preg_match("/\IRIX/", $agent)) $os =5;// "IRIX";
    elseif(preg_match("/\BeOS/", $agent)) $os =6;// "BeOS";
    elseif(preg_match("/\OS2/", $agent)) $os =7;// "OS/2";
    elseif(preg_match("/\AIX/", $agent)) $os =8;// "AIX";
    else $os =9;// "Other";
   
   
 

   
//baca database    
//tampilkan data terbaru

$query1 = "SELECT * FROM stat_browse WHERE id='1'";
//---- baca data polling

$hasil = $koneksi_db->sql_query($query1);
$data = $koneksi_db->sql_fetchrow($hasil);
$PJAWABAN_TMP = explode("#", $data["pjawaban"]);
$jmljwb = count($PJAWABAN_TMP);
$PJAWABAN_TMP[$browser]++;
$PJAWABAN = '';
for($i=0;$i<$jmljwb;$i++){
	$PJAWABAN .= $PJAWABAN_TMP[$i] . "#";
}
$PJAWABAN = substr_replace($PJAWABAN, "", -1, 1);
//-----------------------------------------------
	
//---- simpan data terbaru
$query2 = "UPDATE stat_browse SET pjawaban='$PJAWABAN' WHERE id='1'";
$koneksi_db->sql_query($query2);
// ----------------------------------------------------------------------	
		
		
//baca database    
//tampilkan data terbaru
$query2= "SELECT * FROM stat_browse WHERE id='2'";
//---- baca data polling

		$hasil2 = $koneksi_db->sql_query($query2);
		$data = $koneksi_db->sql_fetchrow($hasil2);
		$PJAWABAN_TMP2 = explode("#", $data["pjawaban"]);
		$jmljwb2 = count($PJAWABAN_TMP2);
		$PJAWABAN_TMP2[$os]++;
$PJAWABAN2 = '';
		for($i=0;$i<$jmljwb2;$i++)
		{
			$PJAWABAN2 .= $PJAWABAN_TMP2[$i] . "#";
		}
		$PJAWABAN2 = substr_replace($PJAWABAN2, "", -1, 1);
		//-----------------------------------------------
	
		//---- simpan data terbaru
		$query3 = "UPDATE stat_browse SET pjawaban='$PJAWABAN2' WHERE id='2'";
		$koneksi_db->sql_query($query3);
		// ----------------------------------------------------------------------	

	
// edit hari
 /* Month-Counter */
    $bulans = $sbulan - 1;
    
     //baca database    
  //tampilkan data terbaru
$query4= "SELECT * FROM stat_browse WHERE id='4'";
//---- baca data polling

		$hasil4 = $koneksi_db->sql_query($query4);
		$data = $koneksi_db->sql_fetchrow($hasil4);
		$PJAWABAN_TMP4 = explode("#", $data["pjawaban"]);
		$jmljwb4 = count($PJAWABAN_TMP4);
		$PJAWABAN_TMP4[$bulans]++;
$PJAWABAN4 = '';
		for($i=0;$i<$jmljwb4;$i++)
		{
			$PJAWABAN4 .= $PJAWABAN_TMP4[$i] . "#";
		}
		$PJAWABAN4 = substr_replace($PJAWABAN4, "", -1, 1);
		//-----------------------------------------------
	
		//---- simpan data terbaru
		$query4 = "UPDATE stat_browse SET pjawaban='$PJAWABAN4' WHERE id='4'";
		$koneksi_db->sql_query($query4);
		// ----------------------------------------------------------------------	
    
     /* Weekday-Counter */
    $haris = $shari;
$query3= "SELECT * FROM stat_browse WHERE id='3'";
//---- baca data polling

		$hasil3 = $koneksi_db->sql_query($query3);
		$data = $koneksi_db->sql_fetchrow($hasil3);
		$PJAWABAN_TMP3 = explode("#", $data["pjawaban"]);
		$jmljwb3 = count($PJAWABAN_TMP3);
		$PJAWABAN_TMP3[$haris]++;
$PJAWABAN3 = '';
		for($i=0;$i<$jmljwb3;$i++)
		{
			$PJAWABAN3 .= $PJAWABAN_TMP3[$i] . "#";
		}
		$PJAWABAN3 = substr_replace($PJAWABAN3, "", -1, 1);
		//-----------------------------------------------
	
		//---- simpan data terbaru
		$query3 = "UPDATE stat_browse SET pjawaban='$PJAWABAN3' WHERE id='3'";
		$koneksi_db->sql_query($query3);
		// ----------------------------------------------------------------------	
    
 /* Per-Hour-Counter */
    $jams = $sjam;
   
     //baca database    
  //tampilkan data terbaru
$query5= "SELECT * FROM stat_browse WHERE id='5'";
//---- baca data polling

		$hasil5 = $koneksi_db->sql_query($query5);
		$data = $koneksi_db->sql_fetchrow($hasil5);
		$PJAWABAN_TMP5 = explode("#", $data["pjawaban"]);
		$jmljwb5 = count($PJAWABAN_TMP5);
		$PJAWABAN_TMP5[$jams]++;
$PJAWABAN5 = '';
		for($i=0;$i<$jmljwb5;$i++)
		{
			$PJAWABAN5 .= $PJAWABAN_TMP5[$i] . "#";
		}
		$PJAWABAN5 = substr_replace($PJAWABAN5, "", -1, 1);
		//-----------------------------------------------
	
		//---- simpan data terbaru
		$query5 = "UPDATE stat_browse SET pjawaban='$PJAWABAN5' WHERE id='5'";
		$koneksi_db->sql_query($query5);
		// ----------------------------------------------------------------------	
    

}



?>