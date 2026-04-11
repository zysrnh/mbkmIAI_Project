<h4>Gallery Foto</h4><br/><p>
<a href="admin.php?pilih=foto&amp;modul=yes">List Data</a> | 
<a href="admin.php?pilih=foto&amp;modul=yes&amp;action=add">Add Data</a> | 
<a href="admin.php?pilih=foto&amp;modul=yes&amp;action=cari">Cari Data</a>
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

function sortorder($sort_url_orderby,$field,$nama){
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
	



$sort_url_name = '<a title="Sort Berdasarkan '.$nama.'" href="?'.$qs.'&amp;sort='.$sort_url_orderby.'&amp;order='.$field.'">'.$nama.'</a>';
$sort_url_name_img = '';
if (isset($_GET['sort']) && $_GET['order'] == $field){
$sort_url_name_img = $_GET['sort'] == 'asc' ? '&nbsp;<IMG height=10 alt=^ src="foto/_arrowup.gif" width=10 align=absMiddle border=0>' : '&nbsp;<IMG height=10 alt=^ src="foto/_arrowdown.gif" width=10 align=absMiddle border=0>';
}

return $sort_url_name.$sort_url_name_img;
}


switch (@$_GET['action']){

	
case 'add':


$datawajibdiisi = array ('nama','ket');

if (isset ($_POST['submit'])){
	
	
$error = '';	
	
foreach ($datawajibdiisi as $k=>$v){
	
	if (empty ($_POST[$v])){
		input_alert($v);
		$error .= '- Error In Form Filling: '.$v.'<br />';
	}
}


$nama= cleantext($_POST['nama']);

$ket = $_POST['ket'];
$kat = cleantext($_POST['kat']);

$tanggal= date('Y-m-d H:i:s');

$image_name		=$_FILES['image']['name'];
$image_size		=$_FILES['image']['size'];
$image_type		=$_FILES['image']['type'];
$url=str_replace(" ", "-", $nama);

	$maxsize    = 1000000;
if ($image_size >= $maxsize){ 	
	
	 $error .= '- Ukuran foto terlalu besar, jangan melebihi 1 MB<br />';
}
else {
	
	
}


if (!$image_name){
	$foto	="na.jpg";
	
} else {
	
	$foto	="$url.jpg";

$check = getimagesize($_FILES['image']['tmp_name']);

if($check !== false) {
	
   
    $uploadOk = 1;
	

	
} else {
  $error .= '- Ini bukan foto<br />';
    $uploadOk = 0;
}

}

//$password = base64_encode($nama);
	if ($error != ''){
$content .= '<div class="error">'.$error.'</div>';

}else {
	$insert = $koneksi_db->sql_query ("INSERT INTO `mod_data_foto` (`nama`,`foto`,`ket`,`kat`,`tanggal`) VALUES ('$nama','$foto','$ket','$kat','$tanggal')");
	if ($insert) {
		if (!$image_name){
			
		} else {
			
				$url=str_replace(" ", "-", $nama);
		copy($_FILES['image']['tmp_name'], "./images/temp/".$url.".jpg");
		
		
		
		
		
		

	if($image_type=='image/jpeg')
{
	function createthumbs($origImagePath, $tnImagePath, $fname, $thumbWidth)
{
    // 1. open the originals directory
    $dir = opendir($origImagePath);
    // 2. Find the original imaeg file
    // 3. load image and get image size
    $img = imagecreatefromjpeg("{$origImagePath}{$fname}");
    $width = imagesx($img);
    $height = imagesy($img);
    // 4. calculate thumbnail size
    $new_width = $thumbWidth;
    $new_height = floor($height * ($thumbWidth / $width));
    // 5. create a new temporary image
    $tmp_img = imagecreatetruecolor($new_width, $new_height);
    // 6. copy and resize old image into new image
    imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    // 7. save thumbnail into a file
    imagejpeg($tmp_img, "{$tnImagePath}{$fname}");
    // 8. close the directory
    closedir($dir);
}
} else {
	
	function createthumbs($origImagePath, $tnImagePath, $fname, $thumbWidth)
{
    // 1. open the originals directory
    $dir = opendir($origImagePath);
    // 2. Find the original imaeg file
    // 3. load image and get image size
    $img = imagecreatefrompng("{$origImagePath}{$fname}");
    $width = imagesx($img);
    $height = imagesy($img);
    // 4. calculate thumbnail size
    $new_width = $thumbWidth;
    $new_height = floor($height * ($thumbWidth / $width));
    // 5. create a new temporary image
    $tmp_img = imagecreatetruecolor($new_width, $new_height);
    // 6. copy and resize old image into new image
    imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    // 7. save thumbnail into a file
    imagepng($tmp_img, "{$tnImagePath}{$fname}");
    // 8. close the directory
    closedir($dir);
}
}	
createthumbs("images/temp/", "images/foto/thumb/", "$foto", 300);
	createthumbs("images/temp/", "images/foto/", "$foto", 600);	
		
		
		
			
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


$script_include[] = $JS_SCRIPT;

$propinsi5 = $koneksi_db->sql_query("SELECT * FROM mod_data_fotokat ORDER BY id ASC");
while($p11=$koneksi_db->sql_fetchrow($propinsi5)){
$kode1 = $p11['id'];
	$nama1 = $p11['nama'];
$asal44 .= '<option value="'.$kode1.'">'.$nama1.'</option>';
}
$content .= '
<form method="POST" action="" enctype="multipart/form-data" name="input_siswa">
<table width=100%>

<tr>
<td>Nama Foto</td>
<td>:</td>
<td>'.input_text ('nama',@$_POST['nama']).'</td>
</tr>
<tr>
<td>Katgeori</td>
<td>:</td>
<td><select name="kat" required>
<option value=""/>-- Pilih Kategori --</option>
'.$asal44.'
</select></td>
</tr>
<tr>
<td>Keterangan</td>
<td>:</td>
<td>'.input_textarea2 ('ket',@$_POST['ket']).'</td>
</tr>


<tr>
<td>File Foto</td>
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


$id = int_filter($_GET['id']);
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
$nama= cleantext($_POST['nama']);
$ket = $_POST['ket'];
$kat = cleantext($_POST['kat']);



$image_name		=$_FILES['image']['name'];
$image_size		=$_FILES['image']['size'];
$image_type		=$_FILES['image']['type'];
$url=str_replace(" ", "-", $nama);

	$maxsize    = 1000000;
if ($image_size >= $maxsize){ 	
	
	 $error .= '- Ukuran foto terlalu besar, jangan melebihi 1 MB<br />';
}
else {
	
	
}


if (!$image_name){
	$foto	=cleantext($_POST['foto']);
} else {
	
$ttge = date('ymdHis');	
$foto	="$url-$ttge.jpg";
$check = getimagesize($_FILES['image']['tmp_name']);

if($check !== false) {
	
	
	
   
    $uploadOk = 1;
	

	
} else {
  $error .= '- Ini bukan foto<br />';
    $uploadOk = 0;
}

}
//$password = base64_encode($no_induk);

	
	if ($error != ''){
$content .= '<div class="error">'.$error.'</div>';

}else {
	$insert = $koneksi_db->sql_query ("UPDATE `mod_data_foto` SET `nama`='$nama',`foto`='$foto',`ket`='$ket',`kat`='$kat' WHERE `id` = '$id'");
	if ($insert) {
		
		if (!$image_name){
} else {
copy($_FILES['image']['tmp_name'], "./images/temp/".$foto."");
		
		
		
	if($image_type=='image/jpeg')
{
	function createthumbs($origImagePath, $tnImagePath, $fname, $thumbWidth)
{
    // 1. open the originals directory
    $dir = opendir($origImagePath);
    // 2. Find the original imaeg file
    // 3. load image and get image size
    $img = imagecreatefromjpeg("{$origImagePath}{$fname}");
    $width = imagesx($img);
    $height = imagesy($img);
    // 4. calculate thumbnail size
    $new_width = $thumbWidth;
    $new_height = floor($height * ($thumbWidth / $width));
    // 5. create a new temporary image
    $tmp_img = imagecreatetruecolor($new_width, $new_height);
    // 6. copy and resize old image into new image
    imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    // 7. save thumbnail into a file
    imagejpeg($tmp_img, "{$tnImagePath}{$fname}");
    // 8. close the directory
    closedir($dir);
}
} else {
	
	function createthumbs($origImagePath, $tnImagePath, $fname, $thumbWidth)
{
    // 1. open the originals directory
    $dir = opendir($origImagePath);
    // 2. Find the original imaeg file
    // 3. load image and get image size
    $img = imagecreatefrompng("{$origImagePath}{$fname}");
    $width = imagesx($img);
    $height = imagesy($img);
    // 4. calculate thumbnail size
    $new_width = $thumbWidth;
    $new_height = floor($height * ($thumbWidth / $width));
    // 5. create a new temporary image
    $tmp_img = imagecreatetruecolor($new_width, $new_height);
    // 6. copy and resize old image into new image
    imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    // 7. save thumbnail into a file
    imagepng($tmp_img, "{$tnImagePath}{$fname}");
    // 8. close the directory
    closedir($dir);
}
}	
createthumbs("images/temp/", "images/foto/thumb/", "$foto", 300);
	createthumbs("images/temp/", "images/foto/", "$foto", 600);			
		
		
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
$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_foto` WHERE `id` = '$id'");
$getdata = $koneksi_db->sql_fetchrow($query);

$_POST = $getdata;
$foto = $getdata['foto'];
$kat = $getdata['kat'];
}
$script_include[] = $JS_SCRIPT;

$propinsi5 = $koneksi_db->sql_query("SELECT * FROM mod_data_fotokat ORDER BY id ASC");
while($p11=$koneksi_db->sql_fetchrow($propinsi5)){
$kode1 = $p11['id'];
	$nama1 = $p11['nama'];
$asal44 .= '<option value="'.$kode1.'">'.$nama1.'</option>';
}

$prop1xyp= $koneksi_db->sql_query("SELECT * FROM mod_data_fotokat WHERE id='$kat'");
while($pr1xyp=$koneksi_db->sql_fetchrow($prop1xyp)){
	$idkatp = $pr1xyp['id'];
$namakatp = $pr1xyp['nama'];
}
$content .= '
<form method="POST" action="" enctype="multipart/form-data" name="input_dosen">
<table width=100%>
<input type="hidden" name="foto" value="'.$foto.'">

<tr>
<td>Nama Foto</td>
<td>:</td>
<td>'.input_text ('nama',@$_POST['nama']).'</td>
</tr>
<tr>
<td>Katgeori</td>
<td>:</td>
<td><select name="kat" required>
<option value="'.$kat.'"/>'.$namakatp.'</option>
'.$asal44.'
</select></td>
</tr>
<tr>
<td>Keterangan</td>
<td>:</td>
<td>'.input_textarea2 ('ket',@$_POST['ket']).'</td>
</tr>

<tr>
<td>File Foto</td>
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
	
	
	
	
	
	
case 'kategori':
$kat = int_filter($_GET['kat']);
if (isset ($_POST['deleted'])){
	if (is_array (@$_POST['delete'])){
	foreach ($_POST['delete'] as $k=>$v){
		$query = $koneksi_db->sql_query ("DELETE FROM `mod_data_foto` WHERE `id`='$v'");
	}
	}
	
}



$query_add = '';
if (isset ($_GET['str']) && !empty($_GET['str'])){
	$str = substr($_GET['str'],0,1);
$query_add .= "WHERE LEFT (`nama`,1) = '$str'";
}




$num = $koneksi_db->sql_query("SELECT `id` FROM `mod_data_foto`  AND mod_data_fotokat='$kat'");
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
<th>No.</th>

<th>Foto</th>
<th>Keterangan</th>

<th>Edit</th>
<th><a href="javascript:checkall(\'namaform\', \'delete[]\');">Delete</a></th>
</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_foto` AND mod_data_fotokat='$kat' $SORT_SQL LIMIT $offset, $limit");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#"';
else $warna = null;	
$no++;
$id = $data['id'];
$kat = $data['kat'];

$prop1xyp= $koneksi_db->sql_query("SELECT * FROM mod_data_fotokat WHERE id='$kat'");
while($pr1xyp=$koneksi_db->sql_fetchrow($prop1xyp)){
	$idkatp = $pr1xyp['id'];
$namakatp = $pr1xyp['nama'];
}
$content .= '<tr>
	<td>'.$no.'.</td>

		<td><img src="images/foto/'.$data['foto'].'" width="100px" alt="'.$data['nama'].'"> </td>
	<td><b>'.$data['nama'].'</b><br/>'.$namakatp.'<br/>'.limitTXT(strip_tags($data['ket']),140).'</td>

	<td><a href="admin.php?pilih=foto&amp;modul=yes&amp;action=edit&amp;id='.$id.'&amp;referer='.$referer.'">Edit</a></td>
	<td><input type="checkbox" name="delete[]" value="'.$id.'" style="border:0px"></td>
	
</tr>';
}


$content .= '<tr>
<td>&nbsp;</td>
    <td>&nbsp;</td>

    <td>&nbsp;</td>    <td>&nbsp;</td>
    <td><input type="submit"  name="deleted" value="Delete" onclick="return confirm (\'Do You Want to Delete Data Such\')"></td>
  </tr>';  

$content .= '</table></div></form>';


$content .= '<p align=center>';
$content .= $a-> getPaging($jumlah, $_GET['pg'], $_GET['stg']);
$content .= '</p>';




break;	




default:

if (isset ($_POST['deleted'])){
	if (is_array (@$_POST['delete'])){
	foreach ($_POST['delete'] as $k=>$v){
		$query = $koneksi_db->sql_query ("DELETE FROM `mod_data_foto` WHERE `id`='$v'");
	}
	}
	
}



$query_add = '';
if (isset ($_GET['str']) && !empty($_GET['str'])){
	$str = substr($_GET['str'],0,1);
$query_add .= "WHERE LEFT (`nama`,1) = '$str'";
}




$num = $koneksi_db->sql_query("SELECT `id` FROM `mod_data_foto`  WHERE publikasi='1'");
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
<th>No.</th>

<th>Foto</th>
<th>Keterangan</th>

<th>Edit</th>
<th><a href="javascript:checkall(\'namaform\', \'delete[]\');">Delete</a></th>
</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_foto` $SORT_SQL LIMIT $offset, $limit");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#"';
else $warna = null;	
$no++;
$id = $data['id'];
$kat = $data['kat'];

$prop1xyp= $koneksi_db->sql_query("SELECT * FROM mod_data_fotokat WHERE id='$kat'");
while($pr1xyp=$koneksi_db->sql_fetchrow($prop1xyp)){
	$idkatp = $pr1xyp['id'];
$namakatp = $pr1xyp['nama'];
}
$content .= '<tr>
	<td>'.$no.'.</td>

		<td><img src="images/foto/'.$data['foto'].'" width="100px" alt="'.$data['nama'].'"> </td>
	<td><b>'.$data['nama'].'</b><br/>'.$namakatp.'<br/>'.limitTXT(strip_tags($data['ket']),140).'</td>

	<td><a href="admin.php?pilih=foto&amp;modul=yes&amp;action=edit&amp;id='.$id.'&amp;referer='.$referer.'">Edit</a></td>
	<td><input type="checkbox" name="delete[]" value="'.$id.'" style="border:0px"></td>
	
</tr>';
}


$content .= '<tr>
<td>&nbsp;</td>
    <td>&nbsp;</td>

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
<table border=0 width=100% style="border:0px solid">
<tr>
<td>Search </td><td>:</td><td>'.input_text ('search',@$_GET['search'],$type='text',$size=33,$opt='').'</td>
</tr>

<tr>
<td></td><td></td><td><input type="submit" name="submit" value="Search"></td>
</tr>
</table>
<input type="hidden" name="pilih" value="foto">
<input type="hidden" name="modul" value="yes">
<input type="hidden" name="action" value="cari">

</form>

';

if (isset ($_POST['deleted'])){
	if (is_array (@$_POST['delete'])){
	foreach ($_POST['delete'] as $k=>$v){
		$query = $koneksi_db->sql_query ("DELETE FROM `mod_data_foto` WHERE `id`='$v'");
	}
	}
	
}

$filter_field = array ('nama');
if (!empty ($_GET['search']) && !empty($_GET['field']) && in_array ($_GET['field'],$filter_field)){
$search = cleartext($_GET['search']);
$field = cleartext($_GET['field']);

$SQLOPERATOR = "LIKE '%$search%'";
if ($field == 'no_induk'){
	$SQLOPERATOR = "= '$search'";
}

$query_add = "WHERE `$field` $SQLOPERATOR";






$num = $koneksi_db->sql_query("SELECT `id` FROM `mod_data_foto` $query_add");
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
<th>No.</th>


<th>Foto</th>
<th>Keterangan</th>

<th>Edit</th>
<th><a href="javascript:checkall(\'namaform\', \'delete[]\');">Delete</a></th>
</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_foto` $query_add $SORT_SQL LIMIT $offset, $limit");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#"';
else $warna = null;	
$no++;
$id = $data['id'];
$kat = $data['kat'];

$prop1xyp= $koneksi_db->sql_query("SELECT * FROM mod_data_fotokat WHERE id='$kat'");
while($pr1xyp=$koneksi_db->sql_fetchrow($prop1xyp)){
	$idkatp = $pr1xyp['id'];
$namakatp = $pr1xyp['nama'];
}
$content .= '<tr>
	<td>'.$no.'.</td>

		<td><img src="images/foto/'.$data['foto'].'" width="100px" alt="'.$data['nama'].'"> </td>
	<td><b>'.$data['nama'].'</b><br/>'.$namakatp.'<br/>'.limitTXT(strip_tags($data['ket']),140).'</td>

	<td><a href="admin.php?pilih=foto&amp;modul=yes&amp;action=edit&amp;id='.$id.'&amp;referer='.$referer.'">Edit</a></td>
	<td><input type="checkbox" name="delete[]" value="'.$id.'" style="border:0px"></td>
	
</tr>';
}


$content .= '<tr>
<td>&nbsp;</td>
    <td>&nbsp;</td>

    <td>&nbsp;</td>    <td>&nbsp;</td>
    <td><input type="submit"  name="deleted" value="Delete" onclick="return confirm (\'Do You Want to Delete Data Such\')"></td>
  </tr>';  

$content .= '</table></div></form>';


$content .= '<p align=center>';
$content .= $a-> getPaging($jumlah, $_GET['pg'], $_GET['stg']);
$content .= '</p>';

	
	
}







break;	

}














/////////////
echo $content;

?>