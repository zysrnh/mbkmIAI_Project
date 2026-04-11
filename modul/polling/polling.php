<?php


ob_start();


	$query = "SELECT * FROM polling WHERE public='ya'";

	
	
	$hasil = $koneksi_db->sql_query($query);
	$data = $koneksi_db->sql_fetchrow($hasil);
	$PID = $data["pid"];
	$PJUDUL = $data["pjudul"];
	$PPILIHAN = explode("#", $data["ppilihan"]);
	$jmlpil = count($PPILIHAN);
	
	if ($koneksi_db->sql_numrows($hasil) > 0){
$koneksi_db->sql_fetchrow ($hasil);
	echo  "$PJUDUL<br />";
	echo  '<form method="post" action="index.php?pilih=polling&amp;modul=yes&amp;act=polling_result" name="form">';
	echo  "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
	echo  "<tr><td width='2%' style='padding-right:6px;margin-top:0px;padding-top:4px;' valign='top'><input type=\"radio\" name=\"pilihan\" value=\"0\" id=\"pil0\" checked=\"checked\" style=\"border:0;\" /></td><td width=\"98%\" ><label for=\"pil0\" style=\"cursor:pointer;margin-top:0px;padding-top:2px;\" onmouseover=\"this.style.textDecoration = 'underline'\" onmouseout=\"this.style.textDecoration = 'none'\"> $PPILIHAN[0]</label></td></tr>\n";
	for($i=1;$i<$jmlpil;$i++)
	{
		echo  "<tr><td width='2%' style='padding-right:6px;' valign='top'><input type=\"radio\" name=\"pilihan\" value=\"$i\" id=\"pil$i\" style=\"border:0;\" /></td><td width=\"98%\"  valign='middle'><label for=\"pil$i\" style=\"cursor:pointer;margin-top:-4px;padding-top:2px;\" onmouseover=\"this.style.textDecoration = 'underline'\" onmouseout=\"this.style.textDecoration = 'none'\" >$PPILIHAN[$i]</label></td></tr>\n";
	}
	echo  "</table>";
	echo  "<input type=\"hidden\" name=\"pid\" value=\"$PID\" />";
	echo  "<div align='center'>";
	echo  "";
	echo  "<input type='submit' name='submit' value='Vote' class='button' />&nbsp;";
	echo  "<input type='submit' name='result' value='Hasil' class='button' />";
	echo  "</div>";
	echo  "</form>";
}else {
echo  "<br />Tidak ada polling yang dipublikasikan<br />";	
}
$out = ob_get_contents();
ob_end_clean();	
?>