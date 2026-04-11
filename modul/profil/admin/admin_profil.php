<h4>Data Profil</h4><br/><p>
<?php



if (!defined('cms-ADMINISTRATOR')) {
	Header("Location: ../index.php");
	exit;
}

if (!cek_login()){
    warning("Access Denied!.... You Must Login First","index.php", 3, 2);
    exit;
}

//$index_hal = 1;

$content='';
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


	
	
	
	
	
	
	
default:


$id = $_GET['id'];

$datawajibdiisi = array ('nama');

if (isset ($_POST['submit'])){
	
	
$error = '';	
	
foreach ($datawajibdiisi as $k=>$v){
	
	if (empty ($_POST[$v])){
		input_alert($v);
		$error .= '<li>Error at Form : '.$v.'</li>';
	}
}

$slogan = cleantext($_POST['slogan']);
$sambutan = cleantext($_POST['sambutan']);
$slogan2 = cleantext($_POST['slogan2']);
$tele = cleantext($_POST['tele']);

$fb = cleantext($_POST['fb']);
$tw = cleantext($_POST['tw']);
$in = cleantext($_POST['in']);
$desc = cleantext($_POST['desc']);
$nama = cleantext($_POST['nama']);
$alamat = cleantext($_POST['alamat']);
$email = cleantext($_POST['email']);
$telp = cleantext($_POST['telp']);
$fax = cleantext($_POST['fax']);
$wa = cleantext($_POST['wa']);

$image_name		=$_FILES['image']['name'];
$image_size		=$_FILES['image']['size'];
$image_type		=$_FILES['image']['type'];

$image_name2		=$_FILES['image2']['name'];
$image_size2		=$_FILES['image2']['size'];
$image_type2		=$_FILES['image2']['type'];


$warnah = cleantext($_POST['warnah']);
$warnaf = cleantext($_POST['warnaf']);
$warnaf2 = cleantext($_POST['warnaf2']);


$url=date('ymdHis');


	$maxsize    = 1000000;
	
	
if (!$image_name){
} else {	
	
	if ($image_size >= $maxsize){ 	
	
	 $error .= '- Ukuran gambar Logo terlalu besar, jangan melebihi 1 MB<br />';
}
else {
	
	
}
	
}
	
	if (!$image_name2){
} else {	
	
	if ($image_size2 >= $maxsize){ 	
	
	 $error .= '- Ukuran gambar Favicon terlalu besar, jangan melebihi 1 MB<br />';
}
else {
	
	
}
	
}
	
	
	
	
if (!$image_name){
	$foto = cleantext($_POST['foto']);


} else {
	$foto	="logo-$url.png";
$check = getimagesize($_FILES['image']['tmp_name']);

if($check !== false) {
	
   
    $uploadOk = 1;
	

	
} else {
  $error .= '- File Logo harus memakai format gambar<br />';
    $uploadOk = 0;
}

}

if (!$image_name2){$foto2 = cleantext($_POST['foto2']);

} else {
	$foto2	="logofav-$url.png";
$check2 = getimagesize($_FILES['image2']['tmp_name']);

if($check2 !== false) {
	
   
    $uploadOk = 1;
	

	
} else {
  $error .= '- File Favicon harus memakai format gambar<br />';
    $uploadOk = 0;
}

}

	
if ($error != ''){
	$content .= '<div class=error>'.$error.'</div>';
}else {
	$insert = $koneksi_db->sql_query ("UPDATE `mod_data_profil` SET `nama`='$nama',`alamat`='$alamat',`email`='$email',`telp`='$telp',`fax`='$fax',`wa`='$wa',`desc`='$desc',`fb`='$fb',`tw`='$tw',`in`='$in',`slogan`='$slogan',`slogan2`='$slogan2',`sambutan`='$sambutan',`tele`='$tele',`foto`='$foto',`foto2`='$foto2'
,`warnah`='$warnah'
,`warnaf`='$warnaf'
,`warnaf2`='$warnaf2'
	WHERE `id` = '1'");
	if ($insert) {
		$content .= '<div class=sukses>Data berhasil diperbarui.</div>';
		
		if (!$image_name){
} else {
		
copy($_FILES['image']['tmp_name'], "./images/".$foto."");

} 
		if (!$image_name2){
} else {
		
copy($_FILES['image2']['tmp_name'], "./images/".$foto2."");

} 
		}
	else {
		$content .= '<div class=error>Data Gagal Di Update<br>'.mysqli_error().'</div>';
		if (eregi ($no_induk,mysqli_error())) {
			input_alert('no_induk');
		}
		
		
		}
	
}	
	
	
	
	
}


$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_profil` WHERE `id` = '1'");
$getdata = $koneksi_db->sql_fetchrow($query);

$_POST = $getdata;
//$images = $getdata['foto'];

$content .= '
<form method="POST" action="" enctype="multipart/form-data" name="input_jabatan">
<table width=100%>


<tr>
<td>Nama Usaha</td>
<td>:</td>
<td>'.input_text ('nama',@$_POST['nama']).'</td>
</tr>

<tr>
<td>Alamat Lengkap</td>
<td>:</td>
<td>'.input_text ('alamat',@$_POST['alamat']).'</td>
</tr>
<tr>
<td>Email</td>
<td>:</td>
<td>'.input_text ('email',@$_POST['email']).'</td>
</tr>
<tr>
<td>No. Telp</td>
<td>:</td>
<td>'.input_text ('telp',@$_POST['telp']).'</td>
</tr>

<tr>
<td>Fax</td>
<td>:</td>
<td>'.input_text ('fax',@$_POST['fax']).'</td>
</tr>
<tr>
<td>Ijin Usaha</td>
<td>:</td>
<td>'.input_text ('wa',@$_POST['wa']).'</td>
</tr>
<tr>
<td>Diskripsi Singkat</td>
<td>:</td>
<td>'.input_textarea ('desc',@$_POST['desc'],$rows=6,$cols=40,$opt=990).'</td>
</tr>

<tr>
<td>Facebook</td>
<td>:</td>
<td>'.input_text ('fb',@$_POST['fb']).'</td>
</tr>

<tr>
<td>Twitter</td>
<td>:</td>
<td>'.input_text ('tw',@$_POST['tw']).'</td>
</tr>

<tr>
<td>Instagram</td>
<td>:</td>
<td>'.input_text ('in',@$_POST['in']).'</td>
</tr>



<tr>
<td>Telegram</td>
<td>:</td>
<td>'.input_text ('tele',@$_POST['tele']).'</td>
</tr>

<tr>
<td>WA</td>
<td>:</td>
<td>'.input_text ('wa',@$_POST['wa']).'</td>
</tr>
<tr>
<td>Jam Operasional</td>
<td>:</td>
<td>'.input_text ('slogan',@$_POST['slogan']).'</td>
</tr>

<tr>
<td><br/><b>Konfigurasi</b><br/><br/></td>
<td></td>
<td></td>
</tr>


<tr>
<td>Kode Warna Header</td>
<td>:</td>
<td>'.input_text ('warnah',@$_POST['warnah']).'</td>
</tr>

<tr>
<td>Kode Warna Footer</td>
<td>:</td>
<td>'.input_text ('warnaf',@$_POST['warnaf']).'</td>
</tr>

<tr>
<td>Kode Warna Bottom</td>
<td>:</td>
<td>'.input_text ('warnaf2',@$_POST['warnaf2']).'</td>
</tr>

<tr>
<td>File Logo (372 x 100)</td>
<td>:</td>
<td><input name="image" type="file" /> <input type="hidden" name="foto" value="'.$getdata['foto'].'"></td>
</tr>

<tr>
<td>File Logo Favicon (40 x 40)</td>
<td>:</td>
<td><input name="image2" type="file" /> <input type="hidden" name="foto2" value="'.$getdata['foto2'].'"></td>
</tr>




<tr>
<td></td>
<td></td>
<td><input type="submit" name="submit" value="Edit"></td>
</tr>

</table>
</form>
';



break;	
	
	
	

}














/////////////
echo $content;

?> 