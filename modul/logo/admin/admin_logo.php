<div><div class="color_transition_03"><h1>Data Sertifikasi</h4><br/><p>
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


include 'modul/logo/functions.php';


$content .= '
<link rel="stylesheet" media="screen" href="modul/logo/css/logo.css" />
<style type="text/css">
#tabel {
padding:0px;
}

#tabel tr.head {
height:20px;
background:#;
}
#tabel tr.head td{
	border-right: 1px solid #d1d1d1;
	border-bottom: 1px solid #d1d1d1;
	border-top: 1px solid #d1d1d1;
	background: #;
	padding-top:4px;
	padding-bottom:4px;
	padding-left:8px;
	padding-right:8px;
	color: #4f6b72;
	font-weight:bold;
}
#tabel tr.head td.depan, tr.isi td.depan{
border-left: 1px solid #d1d1d1;
}
#tabel tr.isi td{
border-right: 1px solid #d1d1d1;
	border-bottom: 1px solid #d1d1d1;
	padding-top:4px;
	padding-bottom:4px;
	padding-left:8px;
	padding-right:8px;
	color: #4f6b72;
}
.table_border_bottom{
border-bottom: 1px solid #d1d1d1;	
}

</style>
';



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

$nama = cleantext($_POST['nama']);
$image_name		=$_FILES['image']['name'];
$image_size		=$_FILES['image']['size'];
$image_type		=$_FILES['image']['type'];
$url=str_replace(" ", "-", $nama);
$foto	="".$nama.".jpg";

	
if ($error != ''){
	$content .= '<div class=error>'.$error.'</div>';
}else {
	$insert = $koneksi_db->sql_query ("UPDATE `logo` SET `nama`='$nama',`foto`='$foto' WHERE md5(`id`) = '$id'");
	if ($insert) {
	$url=str_replace(" ", "-", $nama);
		copy($_FILES['image']['tmp_name'], "./images/".$nama.".jpg");
		$content .= '<div class=sukses>Gambar berhasil dirubah.</div>';
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
$query = $koneksi_db->sql_query ("SELECT * FROM `logo` WHERE md5(`id`) = '$id'");
$getdata = $koneksi_db->sql_fetchrow($query);

$_POST = $getdata;


}

$content .= '
<form method="POST" action="" enctype="multipart/form-data" name="input_siswa">
<table width=100%>

<tr>
<td>Posisi (jangan dirubah)</td>
<td>:</td>
<td>'.input_text ('nama',@$_POST['nama']).'</td>
</tr>


<tr>
<td>Gambar</td>
<td>:</td>
<td><input name="image" type="file" /></td>
</tr>




<tr>
<td></td>
<td></td>
<td><input type="submit" class="button color big round" name="submit" value="Rubah"></td>
</tr>


</table>
</form>
';

}

break;	
	
	
	
	
default:

$referer = referer_encode();
$content .= '<form method="POST" action="" id="namaform">
<table width=100% id="tabel" cellpadding=0 cellspacing=0>';

$content .= '<tr class=head>
	<td class=depan>Posisi</td>

		<td style="text-align:center;padding:1px;">Gambar</td>



	<td style="text-align:center;padding:1px;">Rubah</td>
</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `logo`");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#"';
else $warna = null;	
$id = md5($data['id']);
$content .= '<tr class=isi '.$warna.'>
	<td class=depan>'.$data['nama'].'</td>

		<td style="text-align:center;padding:1px;">'.$data['foto'].'</td>


	<td style="text-align:center;padding:1px;"><a href="admin.php?pilih=logo&amp;modul=yes&amp;action=edit&amp;id='.$id.'&amp;referer='.$referer.'"><img src="gambar/edit.gif"></a></td>
	
</tr>';
}




$content .= '</table>';







break;	

}














/////////////
echo $content;

?></div></div>