<h4>Testimonial</h4><br/><p>
<a href="index.php?pilih=testi&amp;modul=yes">List Data</a> | 
<a href="index.php?pilih=testi&amp;modul=yes&amp;action=add">Add Data</a> | 
<a href="index.php?pilih=testi&amp;modul=yes&amp;action=cari">Cari Data</a>
<?php




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
$sort_url_name_img = $_GET['sort'] == 'asc' ? '&nbsp;<IMG height=10 alt=^ src="testi/_arrowup.gif" width=10 align=absMiddle border=0>' : '&nbsp;<IMG height=10 alt=^ src="testi/_arrowdown.gif" width=10 align=absMiddle border=0>';
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

$ket = cleantext($_POST['ket']);
$email = cleantext($_POST['email']);

$tanggal= date('Y-m-d');

$image_name		=$_FILES['image']['name'];
$image_size		=$_FILES['image']['size'];
$image_type		=$_FILES['image']['type'];
$url=str_replace(" ", "-", $nama);

if ( @$_POST['keykode']!= @$_SESSION['Var_session'] or !isset($_SESSION['Var_session'])){
	$error .= '- Key Kode salah<br />';
	input_alert('keykode');
	
	}

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
	$insert = $koneksi_db->sql_query ("INSERT INTO `mod_data_testi` (`nama`,`ket`,`email`,`tanggal`,`foto`,`status`) VALUES ('$nama','$ket','$email','$tanggal','$foto','0')");
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
createthumbs("images/temp/", "images/testi/thumb/", "$foto", 80);
createthumbs("images/temp/", "images/testi/", "$foto", 300);
		
		
		
			
		}
		


		$content .= '<div class="sukses">Data berhasil dimasukkan, menunggu persetujuan admin.</div>';
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
<td>Nama</td>
<td>:</td>
<td>'.input_text ('nama',@$_POST['nama']).'</td>
</tr>

<tr>
<td>Email</td>
<td>:</td>
<td>'.input_text ('email',@$_POST['email']).'</td>
</tr>

<tr>
<td>Keterangan</td>
<td>:</td>
<td>'.input_textarea2 ('ket',@$_POST['ket']).'</td>
</tr>




<tr>
<td></td>
<td></td>
<td><img src="ikutan/code_image.php" alt="case sensitif" /></td>
</tr>

<tr>
<td>Key kode*</td>
<td>:</td>
<td>'.input_text ('keykode','',$type='text',$size=8,$opt='maxlength=20').'</td>
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
	

	


default:

if (isset ($_POST['deleted'])){
	if (is_array (@$_POST['delete'])){
	foreach ($_POST['delete'] as $k=>$v){
		$query = $koneksi_db->sql_query ("DELETE FROM `mod_data_testi` WHERE `id`='$v'");
	}
	}
	
}



$query_add = '';
if (isset ($_GET['str']) && !empty($_GET['str'])){
	$str = substr($_GET['str'],0,1);
$query_add .= "WHERE LEFT (`nama`,1) = '$str'";
}




$num = $koneksi_db->sql_query("SELECT `id` FROM `mod_data_testi`  WHERE status='1'");
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
function checkall(formNama, boxNama) {
	for(i = 0; i < document.getElementById(formNama).elements.length; i++)
	{
		var formElement = document.getElementById(formNama).elements[i];
		if(formElement.type == 'checkbox' && formElement.name == boxNama && formElement.disabled == false)
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

</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_testi` WHERE status='1' $query_add $SORT_SQL LIMIT $offset, $limit");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#"';
else $warna = null;	
$no++;
$id = $data['id'];


$published = ($data['status'] == '1') ? '<a href="admin.php?pilih=testi&modul=yes&amp;action=pub&amp;pub=0&amp;id='.$id.'"><img src="images/tick.gif" border="0" alt="Ya" /></a>' : '<a href="admin.php?pilih=testi&modul=yes&amp;action=pub&amp;pub=1&amp;id='.$id.'"><img src="images/cross.png" border="0" alt="No" /></a>';	
	

$content .= '<tr>
	<td>'.$no.'.</td>

		<td><img src="images/testi/thumb/'.$data['foto'].'" width="80px" alt="'.$data['nama'].'"> </td>
	<td><b>'.$data['nama'].'</b><br/>'.$data['email'].'<br/>'.limitTXT(strip_tags($data['ket']),140).'</td>

	
</tr>';
}



$content .= '</table></div></form>';

$content .= '<p align=center>';
$content .= $a-> getPagingtesti($jumlah, $_GET['pg'], $_GET['stg']);
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
<input type="hidden" name="pilih" value="testi">
<input type="hidden" name="modul" value="yes">
<input type="hidden" name="action" value="cari">

</form>

';

if (isset ($_POST['deleted'])){
	if (is_array (@$_POST['delete'])){
	foreach ($_POST['delete'] as $k=>$v){
		$query = $koneksi_db->sql_query ("DELETE FROM `mod_data_testi` WHERE `id`='$v'");
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






$num = $koneksi_db->sql_query("SELECT `id` FROM `mod_data_testi` $query_add AND status='1'");
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
function checkall(formNama, boxNama) {
	for(i = 0; i < document.getElementById(formNama).elements.length; i++)
	{
		var formElement = document.getElementById(formNama).elements[i];
		if(formElement.type == 'checkbox' && formElement.name == boxNama && formElement.disabled == false)
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

</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_testi` $query_add AND status='1' $SORT_SQL LIMIT $offset, $limit");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#"';
else $warna = null;	
$no++;
$id = $data['id'];


$published = ($data['status'] == '1') ? '<a href="admin.php?pilih=testi&modul=yes&amp;action=pub&amp;pub=0&amp;id='.$id.'"><img src="images/tick.gif" border="0" alt="Ya" /></a>' : '<a href="admin.php?pilih=testi&modul=yes&amp;action=pub&amp;pub=1&amp;id='.$id.'"><img src="images/cross.png" border="0" alt="No" /></a>';	
	

$content .= '<tr>
	<td>'.$no.'.</td>

		<td><img src="images/testi/thumb/'.$data['foto'].'" width="80px" alt="'.$data['nama'].'"> </td>
	<td><b>'.$data['nama'].'</b><br/>'.$data['email'].'<br/>'.limitTXT(strip_tags($data['ket']),140).'</td>

	
</tr>';
}



$content .= '</table></div></form>';


$content .= '<p align=center>';
$content .= $a-> getPagingtesticari($jumlah, $_GET['pg'], $_GET['stg'],$search);
$content .= '</p>';

	
	
}







break;	

}














/////////////
echo $content;

?>