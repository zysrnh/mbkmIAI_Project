<?php



if(ereg(basename (__FILE__), $_SERVER['PHP_SELF']))
{
	header("HTTP/1.1 404 Not Found");
	exit;
}
global $koneksi_db;
$no=0;
$baris=5;
echo '<h4 class="bg">Forum</h4>';
echo '<table cellspacing="1" cellpadding="2"  width=\'100%\' border="0">
		<tr><td width="50%" valign="top"><h4 class="bg">Posting Baru</h4>';
echo"<table class='border' width='100%' cellspacing=\"5\" cellpadding=\"5\">";
    $hasilcari = $koneksi_db->sql_query("SELECT id,thread_name,thread_parent,forum_id,thread_user FROM mod_forum_t WHERE thread_reply='' OR thread_parent=0 ORDER BY id DESC limit $baris");
    $jmlbaru=$koneksi_db->sql_numrows($hasilcari);
    while ($data=$koneksi_db->sql_fetchrow($hasilcari)){
    $urutan =$no + 1;
    $judul=$data['thread_name'];
    $user=$data['thread_user'];
echo"<tr><td align='left'><a href='./index.php?pilih=forum&modul=yes&amp;action=viewthread&amp;forum_id=$data[forum_id]&amp;thread_id=$data[id]'>$judul</a> (oleh: <a href='./?pilih=teman&amp;modul=yes&amp;aksi=see&amp;user=$user' title='Profile $user'>$user</a>)</td></tr>";
}  
    echo"</table></td>";
  echo"<td width='50%' valign=\"top\"><h4 class=\"bg\">Balasan Baru</h4>";
echo"<table class='border' width='100%' cellspacing=\"5\" cellpadding=\"5\">";
    $hasilcari = $koneksi_db->sql_query("SELECT id,thread_reply,thread_parent,forum_id,thread_user FROM mod_forum_t WHERE thread_name='' OR thread_parent!=0 ORDER BY id DESC limit $baris");
    $jmlbaru=$koneksi_db->sql_numrows($hasilcari);
    while ($data=$koneksi_db->sql_fetchrow($hasilcari)){
    $urutan =$no + 1;
    $judulr=$data['thread_reply'];
    $user=$data['thread_user'];
echo"<tr><td align='left'><a href='./index.php?pilih=forum&modul=yes&amp;action=viewthread&amp;forum_id=$data[forum_id]&amp;thread_id=$data[thread_parent]'>$judulr</a>  (oleh: <a href='./?pilih=teman&amp;modul=yes&amp;aksi=see&amp;user=$user' title='Profile $user'>$user</a>)</td></tr>";
}  
    echo"</table></td>"; 
echo "</tr></table>";
?>