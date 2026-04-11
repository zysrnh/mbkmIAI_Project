<h4>File Manager</h4><br/><p>
<a href="admin.php?pilih=file&amp;modul=yes">List Data</a> | 
<a href="admin.php?pilih=file&amp;modul=yes&amp;action=add">Add Data</a> | 
<a href="admin.php?pilih=file&amp;modul=yes&amp;action=cari">Cari Data</a>

<?php



if (!defined('cms-ADMINISTRATOR')) {
	Header("Location: ../index.php");
	exit;
}

if (!cek_login()){
    warning("Akses dihentikan, silahkan login terlebih dahulu","index.php", 3, 2);
    exit;
}

$index_hal = 1;
$content='';
$tampil='';
$no=0;
include 'modul/functions.php';



$_GET['str'] = isset($_GET['str']) ? $_GET['str'] : null;
$_GET['sort'] = isset($_GET['sort']) ? $_GET['sort'] : NULL;
$_GET['order'] = isset($_GET['order']) ? $_GET['order'] : NULL;

$sort_url_orderby = $_GET['sort'] == 'asc' ? 'dsc' : 'asc';

function sortorder($sort_url_orderby,$field,$judul){
//order name
$qs = '';
	
 $arr = explode("&",$_SERVER["QUERY_STRING"]);
      
      if (is_array($arr)) {
        for ($i=0;$i<count($arr);$i++) {
          if (!is_int(strpos($arr[$i],"sort=")) && !is_int(strpos($arr[$i],"order=")) && trim($arr[$i]) != "") {
	          list ($kunci,$isi) = explode ('=',$arr[$i]);
	          $isi = urldecode($isi);
	          $isi = urlencode ($isi);
	          
              $qs .= $kunci . '=' . $isi ."&amp;";
          }
        }
      }	
	



$sort_url_name = '<a title="Sort Berdasarkan '.$judul.'" href="?'.$qs.'&amp;sort='.$sort_url_orderby.'&amp;order='.$field.'">'.$judul.'</a>';
$sort_url_name_img = '';
if (isset($_GET['sort']) && $_GET['order'] == $field){
$sort_url_name_img = $_GET['sort'] == 'asc' ? '&nbsp;<IMG height=10 alt=^ src="gambar/_arrowup.gif" width=10 align=absMiddle border=0>' : '&nbsp;<IMG height=10 alt=^ src="gambar/_arrowdown.gif" width=10 align=absMiddle border=0>';
}

return $sort_url_name.$sort_url_name_img;
}


switch (@$_GET['action']){

	
case 'add':


$datawajibdiisi = array ('nama');

if (isset ($_POST['submit'])){
	
	
$error = '';	
	
foreach ($datawajibdiisi as $k=>$v){
	
	if (empty ($_POST[$v])){
		input_alert($v);
		$error .= '- Error In Form Filling: '.$v.'<br />';
	}
}
$tanggal = date('Y-m-d');
$ket = cleantext($_POST['ket']);
$nama = cleantext($_POST['nama']);



$image_name		=$_FILES['image']['name'];
$image_size		=$_FILES['image']['size'];
$image_type		=$_FILES['image']['type'];
$url=str_replace(" ", "-", $nama);



if ($image_type=='application/octet-stream')

{
	$foto	="$tanggal-$url.rar";
	
} 

elseif($image_type=='application/zip')

{
	
	$foto	="$tanggal-$url.zip";
} elseif($image_type=='application/vnd.openxmlformats-officedocument.wordprocessingml.document')

{
	
	$foto	="$tanggal-$url.docx";
}

elseif($image_type=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')

{
	
	$foto	="$tanggal-$url.xlsx";
}
elseif($image_type=='application/pdf')

{
	
	$foto	="$tanggal-$url.pdf";
}
elseif($image_type=='application/vnd.openxmlformats-officedocument.presentationml.presentation')

{
	
	$foto	="$tanggal-$url.pptx";
} 

 else {
	
	$error .= "Error: Format tidak didukung, contoh .pdf, .xlsx, .docx, .zip, .pptx<br />";
}

if (!$image_name)  $error .= "Error: File belum diisi , silahkan ulangi.<br />";

//$password = base64_encode($nama);
	if ($error != ''){
$content .= '<div class="error">'.$error.'</div>';

}else {
	$insert = $koneksi_db->sql_query ("INSERT INTO `mod_data_file` (`nama`,`foto`,`tanggal`,`ket`,`format`) VALUES ('$nama','$foto','$tanggal','$ket','$image_type')");
	if ($insert) {
	$url=str_replace(" ", "-", $nama);
	
	
	if ($image_type=='application/octet-stream')

{
copy($_FILES['image']['tmp_name'], "./files/".$tanggal."-".$url.".rar");
	
} 

elseif($image_type=='application/zip')

{
	
	copy($_FILES['image']['tmp_name'], "./files/".$tanggal."-".$url.".zip");
}

elseif($image_type=='application/vnd.openxmlformats-officedocument.wordprocessingml.document')

{
	
	copy($_FILES['image']['tmp_name'], "./files/".$tanggal."-".$url.".docx");
}

elseif($image_type=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')

{
	
	copy($_FILES['image']['tmp_name'], "./files/".$tanggal."-".$url.".xlsx");
}
elseif($image_type=='application/pdf')

{
	
copy($_FILES['image']['tmp_name'], "./files/".$tanggal."-".$url.".pdf");
}
	
	elseif($image_type=='application/vnd.openxmlformats-officedocument.presentationml.presentation')

{
	
	copy($_FILES['image']['tmp_name'], "./files/".$tanggal."-".$url.".pptx");
} 
		

		

		$content .= '<div class="sukses">Data successfully inserted.</div>';
		posted('alumni');
		unset ($_POST);
		}
	else {
		$content .= '<div class=error>Data Gagal Dimasukkan<br>'.mysqli_error().'</div>';
		if (eregi ($no_induk,mysqli_error())) {
			input_alert('no_induk');
		}
		
		
		}
	
}	
	
	
	
	
}





$content .= '
<form method="POST" action="" enctype="multipart/form-data" name="input_siswa">
<table width=100%>

<tr>
<td>Nama File</td>
<td>:</td>
<td>'.input_text ('nama',@$_POST['nama']).'</td>
</tr>

<tr>
<td>Keterangan</td>
<td>:</td>
<td>'.input_text ('ket',@$_POST['ket']).'</td>
</tr>

<tr>
<td>Upload</td>
<td>:</td>
<td><input name="image" type="file" /></td>
</tr>


<tr>
<td></td>
<td></td>
<td><input type="submit"  name="submit" value="Add"></td>
</tr>

</table>
</form>
';



break;	
	
	
		
	
case 'edit':


$id = $_GET['id'];
if (!empty ($_GET['id'])){


$datawajibdiisi = array ('nama');

if (isset ($_POST['submit'])){
	
	
$error = '';	
	
foreach ($datawajibdiisi as $k=>$v){
	
	if (empty ($_POST[$v])){
		input_alert($v);
		$error .= '<li>Error Dalam Pengisian Form : '.$v.'</li>';
	}
}

$ket = cleantext($_POST['ket']);
$nama = cleantext($_POST['nama']);



$image_name		=$_FILES['image']['name'];
$image_size		=$_FILES['image']['size'];
$image_type		=$_FILES['image']['type'];
$url=str_replace(" ", "-", $nama);

if(!$image_name	)
	
	{  
	
	} else { 
	
	


if ($image_type=='application/octet-stream')

{
	$foto	="$tanggal-$url.rar";
	
} 

elseif($image_type=='application/zip')

{
	
	$foto	="$tanggal-$url.zip";
}


elseif($image_type=='application/vnd.openxmlformats-officedocument.wordprocessingml.document')

{
	
	$foto	="$tanggal-$url.docx";
}

elseif($image_type=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')

{
	
	$foto	="$tanggal-$url.xlsx";
}
elseif($image_type=='application/pdf')

{
	
	$foto	="$tanggal-$url.pdf";
}
elseif($image_type=='application/vnd.openxmlformats-officedocument.presentationml.presentation')

{
	
	$foto	="$tanggal-$url.pptx";
} 

 else {
	
	$error .= "Error: Format tidak didukung, contoh .pdf, .xlsx, .docx, .zip, .pptx<br />";
}

	}


	
	if ($error != ''){
$content .= '<div class="error">'.$error.'</div>';
} 
	
elseif (!$image_name){
	$insert = $koneksi_db->sql_query ("UPDATE `mod_data_file` SET `nama`='$nama',`ket`='$ket' WHERE md5(`id`) = '$id'");
	if ($insert) {
		$content .= '<div class=sukses>Data Berhasil Di Update</div>';
		header ("location: ".referer_decode($_GET['referer'])."");
		exit;
		}
	else {
		$content .= '<div class=error>Data Gagal Di Update<br>'.mysqli_error().'</div>';
		if (eregi ($no_induk,mysqli_error())) {
			input_alert('no_induk');
		}
		
		
		}
}else {
	$insert = $koneksi_db->sql_query ("UPDATE `mod_data_file` SET `nama`='$nama',`foto`='$foto',`ket`='$ket' WHERE md5(`id`) = '$id'");
	if ($insert) {
	$url=str_replace(" ", "-", $nama);
	
	
	if ($image_type=='application/octet-stream')

{
copy($_FILES['image']['tmp_name'], "./files/".$tanggal."-".$url.".rar");
	
} 

elseif($image_type=='application/zip')

{
	
	copy($_FILES['image']['tmp_name'], "./files/".$tanggal."-".$url.".zip");
}
elseif($image_type=='application/vnd.openxmlformats-officedocument.wordprocessingml.document')

{
	
	copy($_FILES['image']['tmp_name'], "./files/".$tanggal."-".$url.".docx");
}

elseif($image_type=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')

{
	
	copy($_FILES['image']['tmp_name'], "./files/".$tanggal."-".$url.".xlsx");
}
elseif($image_type=='application/pdf')

{
	
copy($_FILES['image']['tmp_name'], "./files/".$tanggal."-".$url.".pdf");
}
	
	elseif($image_type=='application/vnd.openxmlformats-officedocument.presentationml.presentation')

{
	
	copy($_FILES['image']['tmp_name'], "./files/".$tanggal."-".$url.".pptx");
} 
		
		$content .= '<div class=sukses>Data Berhasil Di Update</div>';
		header ("location: ".referer_decode($_GET['referer'])."");
		exit;
		}
	else {
		$content .= '<div class=error>Data Gagal Di Update<br>'.mysqli_error().'</div>';
		if (eregi ($no_induk,mysqli_error())) {
			input_alert('no_induk');
		}
		
		
		}
	
}	
	
	
	
	
}

if (!isset ($_POST['submit'])){
$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_file` WHERE md5(`id`) = '$id'");
$getdata = $koneksi_db->sql_fetchrow($query);

$_POST = $getdata;
$tampil = $getdata['tampil'];
}

$content .= '
<form method="POST" action="" enctype="multipart/form-data" name="input_guru">
<table width=100%>

<tr>
<td>Nama File</td>
<td>:</td>
<td>'.input_text ('nama',@$_POST['nama']).'</td>
</tr>

<tr>
<td>Keterangan</td>
<td>:</td>
<td>'.input_text ('ket',@$_POST['ket']).'</td>
</tr>

<tr>
<td>Upload</td>
<td>:</td>
<td><input name="image" type="file" /></td>
</tr>

<tr>
<td></td>
<td></td>
<td><input type="submit" name="submit" value="Edit"></td>
</tr>

</table>
</form>
';

}

break;	
	
	
	
	
	
default:

if (isset ($_POST['deleted'])){
	if (is_array (@$_POST['delete'])){
	foreach ($_POST['delete'] as $k=>$v){
		$query = $koneksi_db->sql_query ("DELETE FROM `mod_data_file` WHERE md5(`id`)='$v'");
	}
	}
	
}



$query_add = '';
if (isset ($_GET['str']) && !empty($_GET['str'])){
	$str = substr($_GET['str'],0,1);
$query_add .= "WHERE LEFT (`nama`,1) = '$str'";
}






if (isset ($_GET['progstudi']) && !empty($_GET['progstudi']) && is_numeric($_GET['progstudi'])){
	$progstudi = int_filter ($_GET['progstudi']);
$query_add = "WHERE `tbl_guru`.`kd_progstudi` = '$progstudi'";
}
if (isset ($_GET['kelas']) && !empty ($_GET['kelas'])){
	$kd_kelas = int_filter ($_GET['kelas']);
$query_add = "WHERE `tbl_guru`.`kd_kelas` = '$kd_kelas'";
}
if (!empty ($_GET['progstudi']) && !empty ($_GET['kelas']) && is_numeric($_GET['progstudi'])){
$query_add = "WHERE `tbl_guru`.`kd_progstudi` = '$progstudi' AND `tbl_guru`.`kd_kelas` = '$kd_kelas'";
}



$SORT_SQL = '';
$filter_field = array ('nama','tahun_tamat');
if (isset ($_GET['sort']) && !empty($_GET['sort']) && in_array ($_GET['order'],$filter_field)){
	$sort = $_GET['sort'];
	$order = $_GET['order'];
	if ($sort == 'asc') $sortSQL = 'ASC';
	else if ($sort == 'dsc') $sortSQL = 'DESC';
	
$SORT_SQL = "ORDER BY `$order` $sortSQL";
}


$num = $koneksi_db->sql_query("SELECT `id` FROM `mod_data_file` $query_add");
$jumlah = $koneksi_db->sql_numrows ($num);
//mysql_free_result ($num);

$limit = 20;
if (empty($_GET['offset']) and !isset ($_GET['offset'])) {
$offset = 0;
}else {
$offset = int_filter ($_GET['offset']);	
}

$a = new paging ($limit);

// Pembagian halaman dimulai
 if (!isset ($_GET['pg'],$_GET['stg'])){
	  $_GET['pg'] = 1;
	  $_GET['stg'] = 1;
  }
  
  
$qs = '';
	
 $arr = explode("&",$_SERVER["QUERY_STRING"]);
      
      if (is_array($arr)) {
        for ($i=0;$i<count($arr);$i++) {
          if (!is_int(strpos($arr[$i],"str=")) && trim($arr[$i]) != "") {
	          list ($kunci,$isi) = explode ('=',$arr[$i]);
	          $isi = urldecode($isi);
	          $isi = urlencode ($isi);
	          
              $qs .= $kunci . '=' . $isi ."&amp;";
          }
        }
      }  
  
 
$str_abjad = array ('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
$gabung_str = '| ';
foreach ($str_abjad AS $k=>$v){
	if ($_GET['str'] == $v){
	$gabung_str .= '<b>'.$v.'</b> | ';		
	}else {
	$gabung_str .= '<a href="'.basename($_SERVER['PHP_SELF']).'?'.$qs.'&amp;str='.$v.'">'.$v.'</a> | ';	
	}
} 






  
$content .= <<<js
<script language="javascript">
all_checked = true;
function checkall(formName, boxName) {
	for(i = 0; i < document.getElementById(formName).elements.length; i++)
	{
		var formElement = document.getElementById(formName).elements[i];
		if(formElement.type == 'checkbox' && formElement.name == boxName && formElement.disabled == false)
		{
			formElement.checked = all_checked;
		}
	}	
all_checked = all_checked ? false : true;
}
</script>


js;

$referer = referer_encode();
$content .= '<form method="POST" action="" id="namaform">
<div class="table-responsive"><table class="table table-hover">';

$content .= '<tr>
	<th>No. </th>
<th>Nama File </th>
		<th>Keterangan</th>
<th>Tanggal Upload</th>
<th>Action</th>
<th>Publish</th>
	<th>Edit</th>
	<th><a href="javascript:checkall(\'namaform\', \'delete[]\');">Hapus</a></th>
</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_file` $query_add $SORT_SQL LIMIT $offset, $limit");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#"';
else $warna = null;	
$no++;
$id = md5($data['id']);
$id2 = $data['id'];
$published = ($data['status'] == '0') ? '<a href="admin.php?pilih=file&modul=yes&amp;action=pub&amp;pub=0&amp;id='.$id2.'&ref='.$referer.'"><img src="images/cross.png" border="0" alt="no" /></a>' : '<a href="admin.php?pilih=file&modul=yes&amp;action=pub&amp;pub=1&amp;id='.$id2.'&ref='.$referer.'"><img src="images/tick.gif" border="0" alt="ya" /></a>';	

$content .= '<tr>
<td>'.$no.'.</td>
<td>'.$data['nama'].'</td>
<td>'.$data['ket'].'</td>
<td>'.datetimess($data['tanggal']).'</td>
		<td><a href="files/'.$data['foto'].'">Download</a></td>
		<td>'.$published.'</td>
	<td><a href="admin.php?pilih=file&amp;modul=yes&amp;action=edit&amp;id='.$id.'&amp;referer='.$referer.'">Edit</a></td>
	<td><input type="checkbox" name="delete[]" value="'.$id.'" style="border:0px"></td>
</tr>';
}


$content .= '<tr>
<td>&nbsp;</td>
    <td>&nbsp;</td><td>&nbsp;</td>
<td>&nbsp;</td><td>&nbsp;</td>
    <td>&nbsp;</td>    <td>&nbsp;</td>
    <td><input type="submit"  name="deleted" value="Delete" onclick="return confirm (\'Do You Want to Delete Data Such\')"></td>
  </tr>';  

$content .= '</table></div></form>';


$content .= '<p align=center>';
$content .= $a-> getPaging($jumlah, $_GET['pg'], $_GET['stg']);
$content .= '</p>';




break;	




case 'cari':


$_GET['field'] = !isset ($_GET['field']) ? 'nama' : $_GET['field'];



$content .= '
<form method="GET" action="">
<table border=0 width=100% align=left style="border:0px solid">
<tr>
<td>Search </td><td>:</td><td>'.input_text ('search',@$_GET['search'],$type='text',$size=33,$opt='').'</td>
</tr>

<tr>
<td></td><td></td><td><input type="submit" name="submit" value="Search"></td>
</tr>
</table>
<input type="hidden" name="pilih" value="file">
<input type="hidden" name="modul" value="yes">
<input type="hidden" name="action" value="cari">

</form>

';


$filter_field = array ('nama');
if (!empty ($_GET['search']) && !empty($_GET['field']) && in_array ($_GET['field'],$filter_field)){
$search = cleartext($_GET['search']);
$field = cleartext($_GET['field']);

$SQLOPERATOR = "LIKE '%$search%'";
if ($field == 'no_induk'){
	$SQLOPERATOR = "= '$search'";
}

$query_add = "WHERE `$field` $SQLOPERATOR";




$SORT_SQL = '';
$filter_field = array ('nama');
if (isset ($_GET['sort']) && !empty($_GET['sort']) && in_array ($_GET['order'],$filter_field)){
	$sort = $_GET['sort'];
	$order = $_GET['order'];
	if ($sort == 'asc') $sortSQL = 'ASC';
	else if ($sort == 'dsc') $sortSQL = 'DESC';
	
$SORT_SQL = "ORDER BY `$order` $sortSQL";
}


$num = $koneksi_db->sql_query("SELECT `id` FROM `mod_data_file` $query_add");
$jumlah = $koneksi_db->sql_numrows ($num);
$koneksi_db->sql_freeresult ($num);

$limit = 20;
if (empty($_GET['offset']) and !isset ($_GET['offset'])) {
$offset = 0;
}else {
$offset = int_filter ($_GET['offset']);	
}

$a = new paging ($limit);

// Pembagian halaman dimulai
 if (!isset ($_GET['pg'],$_GET['stg'])){
	  $_GET['pg'] = 1;
	  $_GET['stg'] = 1;
  }


$content .= <<<js
<script language="javascript">
all_checked = true;
function checkall(formName, boxName) {
	for(i = 0; i < document.getElementById(formName).elements.length; i++)
	{
		var formElement = document.getElementById(formName).elements[i];
		if(formElement.type == 'checkbox' && formElement.name == boxName && formElement.disabled == false)
		{
			formElement.checked = all_checked;
		}
	}	
all_checked = all_checked ? false : true;
}
</script>


js;
$referer = referer_encode();
$content .= '<form method="POST" action="" id="namaform">
<div class="table-responsive"><table class="table table-hover">';

$content .= '<tr>
	<th>No. </th>
<th>Nama File </th>
		<th>Keterangan</th>
<th>Tanggal Upload</th>
<th>Action</th>
<th>Publish</th>
	<th>Edit</th>
	<th><a href="javascript:checkall(\'namaform\', \'delete[]\');">Hapus</a></th>
</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_file` $query_add $SORT_SQL LIMIT $offset, $limit");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#"';
else $warna = null;	
$no++;
$id = md5($data['id']);
$id2 = $data['id'];
$published = ($data['status'] == '0') ? '<a href="admin.php?pilih=file&modul=yes&amp;action=pub&amp;pub=0&amp;id='.$id2.'&ref='.$referer.'"><img src="images/cross.png" border="0" alt="no" /></a>' : '<a href="admin.php?pilih=file&modul=yes&amp;action=pub&amp;pub=1&amp;id='.$id2.'&ref='.$referer.'"><img src="images/tick.gif" border="0" alt="ya" /></a>';	

$content .= '<tr>
<td>'.$no.'.</td>
<td>'.$data['nama'].'</td>
<td>'.$data['ket'].'</td>
<td>'.datetimess($data['tanggal']).'</td>
		<td><a href="files/'.$data['foto'].'">Download</a></td>
		<td>'.$published.'</td>
	<td><a href="admin.php?pilih=file&amp;modul=yes&amp;action=edit&amp;id='.$id.'&amp;referer='.$referer.'">Edit</a></td>
	<td><input type="checkbox" name="delete[]" value="'.$id.'" style="border:0px"></td>
</tr>';
}


$content .= '<tr>
<td>&nbsp;</td><td>&nbsp;</td>
    <td>&nbsp;</td>
<td>&nbsp;</td><td>&nbsp;</td>
    <td>&nbsp;</td>    <td>&nbsp;</td>
    <td><input type="submit"  name="deleted" value="Delete" onclick="return confirm (\'Do You Want to Delete Data Such\')"></td>
  </tr>';  

$content .= '</table></div></form>';


$content .= '<p align=center>';
$content .= $a-> getPaging($jumlah, $_GET['pg'], $_GET['stg']);
$content .= '</p>';

	
	
}







break;	



case 'pub':	

	if ($_GET['pub'] == '0'){	
		$id = int_filter ($_GET['id']);	
		$koneksi_db->sql_query ("UPDATE mod_data_file SET status='1' WHERE id='$id'");
	}	
	
	if ($_GET['pub'] == '1'){	
		$id = int_filter ($_GET['id']);	
	$koneksi_db->sql_query ("UPDATE mod_data_file SET status='0' WHERE id='$id'");	
	}	
	header ("location: ".referer_decode($_GET['ref'])."");
	exit;


break;	



}














/////////////
echo $content;

?>