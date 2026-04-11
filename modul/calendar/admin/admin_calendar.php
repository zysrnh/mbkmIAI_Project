<h4>Event Kalender</h4><br/><p>
 <link rel="stylesheet" href="css/bootstrap-datepicker2.css" type="text/css" />
 <?php

if (!defined('cms-ADMINISTRATOR')) {
    Header("Location: ../index.php");
    exit;
}



if (!cek_login ()){
    header ("location:index.php");
    exit;
}

$content = '';

$no=0;
$warna='';


$content .= '
<script type="text/javascript" language="javascript">
/*<![CDATA[*/
   function GP_popupConfirmMsg(msg) { //v1.0
  document.MM_returnValue = confirm(msg);
}
function flevPopupLink(){// v1.2
var v1=arguments,v2=window.open(v1[0],v1[1],v1[2]), v3=(v1.length>3)?v1[3]:false;if (v3){v2.focus();}document.MM_returnValue=false;
}
/*]]>*/
</script>';

$content .= '<div>';
$content .= '<a href="admin.php?pilih=calendar&amp;modul=yes">List Data</a> | <a href="admin.php?pilih=calendar&amp;modul=yes&amp;action=add">Add Data</a>';
$content .= '</div>';

$style_include[] = '
<style type="text/css">
/*<![CDATA[*/
@import url("css/form.css");
/*]]>*/
</style>';


if (!isset ($_GET['action'])) $_GET['action'] = NULL;

switch ($_GET['action']){
	
	
case 'add':

if (isset ($_POST['submit'])){
	
$judul = cleantext($_POST['judul']);	
$waktu_mulai = cleantext($_POST['waktu_mulai']);	
$waktu_akhir = cleantext($_POST['waktu_akhir']);	
$isi = cleantext($_POST['isi']);	
$background = cleantext($_POST['background']);	
$color = cleantext($_POST['color']);

$error = '';

foreach ($_POST as $K=>$V){
	if (empty($V)){
		$error = ' ';
	}
}	
	
	
if ($error != ''){
        $content .='<div class="error">Error Pengisian Data, Silahkan Lengkapi Form Tersebut</div>';
	
}else {
	$masuk = $koneksi_db->sql_query ("INSERT INTO `tbl_kalender` (`judul`,`waktu_mulai`,`waktu_akhir`,`isi`,`background`,`color`) VALUES ('$judul','$waktu_mulai','$waktu_akhir','$isi','$background','$color')");
if ($masuk) {
    $content .='<div class="sukses">Data berhasil dimasukkan.</div>'; 

}else {
$content .='<div class="error">Data Gagal dimasukkan</div>';
}//end else masuk
}//end else error
	
}

$content .= <<<scr
<script type="text/javascript">
/*<![CDATA[*/
ubahbackground=function(obj,ini){
var Obj = document.getElementById(obj);
try{
Obj.style.background = ini.value;
}catch(e){
alert('Tabel Warna Invalid');
}

};

ubahcolor=function(obj,ini){
var Obj = document.getElementById(obj);
try{
Obj.style.color = ini.value;
}catch(e){
alert('Tabel Warna Invalid');
}
	
};
/*]]>*/
</script>

scr;


$content .='<div>';
$content .= '<form method="post" action="" name="input_siswa" id="input_siswa" onsubmit="return cek()"><table width="100%" align="center">
	<tr>
		<td width="20%">Judul</td>
		<td width="1%">:</td>
		<td width="49%">'.input_text ('judul','').'</td>
	</tr>
	<tr>
		<td width="20%">Waktu Mulai</td>
		<td width="1%">:</td>
		<td width="49%"><input type="text" name="waktu_mulai"  class="tcal date required" id="" ></td>
	</tr>
	<tr>
		<td width="20%">Waktu Akhir</td>
		<td width="1%">:</td>
		<td width="49%"><input type="text" name="waktu_akhir"  class="tcal date required" id=""  ></td>
	</tr>
	<tr>
		<td width="20%">Background Color</td>
		<td width="1%">:</td>
		<td width="49%">'.input_text ('background','#d1d1d1','text',15,' onblur="return ubahbackground(\'ubahwarna\',this);"').' <span id="ubahwarna" style="background:#efefef">&nbsp;&nbsp;<span id="tulisanwarna">16</span>&nbsp;&nbsp;</span></td>
	</tr>
	<tr>
		<td width="20%">Color</td>
		<td width="1%">:</td>
		<td width="49%">'.input_text ('color','#999999','text',15,' onblur="return ubahcolor(\'tulisanwarna\',this);"').'</td>
	</tr>
	<tr>
		<td width="20%" valign="top">Isi</td>
		<td width="1%" valign="top">:</td>
		<td width="49%">'.input_textarea ('isi','',$rows=5,$cols=40,$opt='').'</td>
	</tr>
	<tr>
		<td width="20%">&nbsp;</td>
		<td width="1%">&nbsp;</td>
		<td width="49%"><input type="submit" name="submit" value="Simpan" class="submit" /></td>
	</tr>';
	
	
$content .= '</table></form>';
$content .='</div>';

break;

case 'edit':


$id = int_filter($_GET['id']);

if (isset ($_POST['submit'])){
	
$judul = cleantext($_POST['judul']);	
$waktu_mulai = cleantext($_POST['waktu_mulai']);	
$waktu_akhir = cleantext($_POST['waktu_akhir']);	
$isi = cleantext($_POST['isi']);	
$background = cleantext($_POST['background']);	
$color = cleantext($_POST['color']);		


$error = '';

foreach ($_POST as $K=>$V){
	if (empty($V)){
		$error = ' ';
	}
}	
	
	
if ($error != ''){
        $content .='<div class="error">Error Pengisian Data, Silahkan Lengkapi Form Tersebut</div>';	
}else {
	$masuk = $koneksi_db->sql_query ("UPDATE `tbl_kalender` SET `judul`='$judul',`waktu_mulai`='$waktu_mulai',`waktu_akhir`='$waktu_akhir',`isi`='$isi',`background`='$background',`color`='$color' WHERE `id`='$id'");
if ($masuk) {
    $content .='<div class="sukses">Data berhasil diperbarui.</div>'; 
unset($_POST);
}else {
$content .='<div class="error">Data Gagal diupdate</div>';
}
}



	
}

$qs = $koneksi_db->sql_query ("SELECT * FROM `tbl_kalender` WHERE `id`='$id'");
$get = $koneksi_db->sql_fetchrow($qs);


$content .= '<div>';
$content .= '<form method="post" action="" name="input_siswa" id="input_siswa" onsubmit="return cek()"><table style="width:100%" align="center">
	<tr>
		<td width="20%">Judul</td>
		<td width="1%">:</td>
		<td width="49%">'.input_text ('judul',$get['judul']).'</td>
	</tr>
	<tr>
		<td width="20%">Waktu Mulai</td>
		<td width="1%">:</td>
		<td width="49%"><input type="text" name="waktu_mulai" value="'.$get['waktu_mulai'].'" class="tcal date required" id="" ></td>
	</tr>
	<tr>
		<td width="20%">Waktu Akhir</td>
		<td width="1%">:</td>
		<td width="49%"><input type="text" name="waktu_akhir" value="'.$get['waktu_akhir'].'" class="tcal date required" id="" ></td>
	</tr>
	<tr>
		<td width="20%">Background Color</td>
		<td width="1%">:</td>
		<td width="49%">'.input_text ('background',$get['background'],'text',15,'onblur="return ubahbackground(\'ubahwarna\',this);"').' <span id="ubahwarna" style="background:'.$get['background'].'">&nbsp;&nbsp;<span id="tulisanwarna" style="color:'.$get['color'].'">16</span>&nbsp;&nbsp;</span></td>
	</tr>
	<tr>
		<td width="20%">Color</td>
		<td width="1%">:</td>
		<td width="49%">'.input_text ('color',$get['color'],'text',15,'onblur="return ubahcolor(\'tulisanwarna\',this);"').'</td>
	</tr>
	<tr>
		<td width="20%">Isi</td>
		<td width="1%">:</td>
		<td width="49%">'.input_textarea ('isi',$get['isi'],$rows=5,$cols=40,$opt='').'</td>
	</tr>
	<tr>
		<td width="20%">&nbsp;</td>
		<td width="1%">&nbsp;</td>
		<td width="49%"><input type="submit" name="submit" value="Edit" class="submit" /></td>
	</tr>';
	
	
$content .= '</table></form>';
$content .= '</div>';
break;


case 'delete':
$id = int_filter($_GET['id']);
$del = $koneksi_db->sql_query ("DELETE FROM `tbl_kalender` WHERE `id`='$id'");
if ($del) {
    $content .='<div><table width="100%" class="bodyline"><tr><td align="left"><img src="images/info.gif" border="0"></td><td align="center"><div class="sukses">Data Berhasil Dihapus</div></td><td align="right"><img src="images/info.gif" border="0"></td></tr></table></div>'; 
$content .= '<div><center><a href="admin.php?pilih=calendar&amp;modul=yes">Back</a></center></div>';
}else {
        $content .='<div><table width="100%" class="bodyline"><tr><td align="left"><img src="images/warning.gif" border="0"></td><td align="center"><div class="error">Data gagal di Hapus</div></td><td align="right"><img src="images/warning.gif" border="0"></td></tr></table></div>';
$content .= '<div><center><a href="admin.php?pilih=calendar&amp;modul=yes">Back</a></center></div>';
}
break;
	
default:


$limit = 10;
if (empty($_GET['offset']) and !isset ($_GET['offset'])) {
$offset = 0;
}else {
$offset = int_filter ($_GET['offset']);	
}


$query_add = '';
if (!empty ($_GET['waktu'])){
$query_add = "WHERE `waktu_mulai` LIKE '%".cleantext($_GET['waktu'])."%'";	
} 




$num = $koneksi_db->sql_query("SELECT COUNT(id) as t FROM `tbl_kalender` $query_add");
$rows = $koneksi_db->sql_fetchrow ($num);
$jumlah = $rows[0];
//mysql_free_result ($num);
$a = new paging ($limit);

// Pembagian halaman dimulai
 if (!isset ($_GET['pg'],$_GET['stg'])){
	  $_GET['pg'] = 1;
	  $_GET['stg'] = 1;
  }
  

  


$halamanpage = $a-> getPaging($jumlah, $_GET['pg'], $_GET['stg']);	
if (!empty($halamanpage)){
$content .= '<div>'; 
$content.= $halamanpage;
$content .= '</div>'; 
}








$content .= '<form method="POST" action="" id="namaform">
<div class="table-responsive"><table class="table table-hover">';

$content .= '<tr>
	<th>No.</th>
<th>Judul Event</th>

	
	<th>Tanggal Mulai</th>
	<th>Edit</th>
	<th>Hapus</th>

</tr>';





$query = $koneksi_db->sql_query ("SELECT * FROM `tbl_kalender` $query_add ORDER BY `waktu_mulai` DESC LIMIT $offset, $limit");
while ($getdata = $koneksi_db->sql_fetchrow($query)){
$no ++;
	
	
	$content .= '<tr>
	<td>'.$no.'</td>

	<td>'.$getdata['judul'].'</td>
<td>'.datetimess($getdata['waktu_mulai']).'</td>
<td><a href="admin.php?pilih=calendar&amp;modul=yes&amp;action=edit&amp;id='.$getdata['id'].'">Edit</a></td>
<td><a href="admin.php?pilih=calendar&amp;modul=yes&amp;action=delete&amp;id='.$getdata['id'].'" onclick="GP_popupConfirmMsg(\'Apakah Anda Yakin Ingin Menghapus Data Ini\')"><img src="images/cross.png" align="middle" border="0" alt="del" /></a></td>
	
</tr>';
	
	

}
$content .= '</table></div></form>';	

break;	
	
	
}


echo $content;
?>

