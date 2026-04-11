<h4>Layanan Online</h4><br/><p>

  <a href="admin.php?pilih=layanan&amp;modul=yes">List Data</a> | 
  <a href="admin.php?pilih=layanan&amp;modul=yes&amp;action=add">Add Data</a> |
    <a href="admin.php?pilih=layanan&amp;modul=yes&amp;action=cari">Cari Data</a>
  
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


include 'modul/functions.php';


$_GET['str'] = isset($_GET['str']) ? $_GET['str'] : null;
$_GET['sort'] = isset($_GET['sort']) ? $_GET['sort'] : NULL;
$_GET['order'] = isset($_GET['order']) ? $_GET['order'] : NULL;

$sort_url_orderby = $_GET['sort'] == 'asc' ? 'dsc' : 'asc';

function sortorder($sort_url_orderby,$field,$link){
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
	



$sort_url_name = '<a title="Sort Berdasarkan '.$link.'" href="?'.$qs.'&amp;sort='.$sort_url_orderby.'&amp;order='.$field.'">'.$link.'</a>';
$sort_url_name_img = '';
if (isset($_GET['sort']) && $_GET['order'] == $field){
$sort_url_name_img = $_GET['sort'] == 'asc' ? '&nbsp;<IMG height=10 alt=^ src="images/_arrowup.gif" width=10 align=absMiddle border=0>' : '&nbsp;<IMG height=10 alt=^ src="images/_arrowdown.gif" width=10 align=absMiddle border=0>';
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
		$error .= '- Error at Form : '.$v.'<br />';
	}
}




$nama = cleantext($_POST['nama']);
$link = cleantext($_POST['link']);
$ket = cleantext($_POST['ket']);
$icon= cleantext($_POST['icon']);

if ($error != ''){
	$content .= '<div class=error>'.$error.'</div>';
}else {

   
    
	$insert = $koneksi_db->sql_query ("INSERT INTO `mod_data_layanan` (`nama`,`icon`,`link`,`ket`) VALUES ('$nama','$icon','$link','$ket')");
	if ($insert) {
		$content .= '<div class=sukses>Data has been insert.</div>';
		}
	else {
		$content .= '<div class=error>Data Gagal Dimasukkan<br>'.mysql_error().'</div>';
		if (eregi ($no_induk,mysql_error())) {
			input_alert('no_induk');
		}
		}
		
		
	
}	
	
	
	
	
}





$content .= '
<form method="POST" action="" enctype="multipart/form-data" name="input_jabatan">
<table width=100%>

<tr>
<td>Nama</td>
<td>:</td>
<td>'.input_text ('nama',@$_POST['nama']).'</td>
</tr>
<tr>
<td>Keterangan</td>
<td>:</td>
<td>'.input_text ('ket',@$_POST['ket']).'</td>
</tr>

<tr>
<td>Link</td>
<td>:</td>
<td>'.input_text ('link',@$_POST['link']).'</td>
</tr>



<tr>
<td>Icon</td>
<td>:</td>
<td>'.input_text ('icon',@$_POST['icon']).'</td>
</tr>
<tr>
<td></td>
<td></td>
<td><a href="https://fontawesome.com/v4.7.0/icons/" target="_blank">https://fontawesome.com/v4.7.0/icons/</a></td>
</tr>







<tr>
<td></td>
<td></td>
<td><input type="submit" name="submit" value="Add"></td>
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
		$error .= '<li>Error In Form Filling : '.$v.'</li>';
	}
}

$link = cleantext($_POST['link']);
$nama = cleantext($_POST['nama']);
$ket = cleantext($_POST['ket']);
$icon = cleantext($_POST['icon']);

	
if ($error != ''){
	$content .= '<div class=error>'.$error.'</div>';
}else {
	$insert = $koneksi_db->sql_query ("UPDATE `mod_data_layanan` SET `nama`='$nama',`icon`='$icon',`link`='$link',`ket`='$ket' WHERE `id` = '$id'");
	if ($insert) {
		$content .= '<div class=sukses>Data berhasil diubah.</div>';
		header ("location: ".referer_decode($_GET['referer'])."");
		exit;
		}
	else {
		$content .= '<div class=error>Data Gagal Di Update<br>'.mysql_error().'</div>';
		if (eregi ($no_induk,mysql_error())) {
			input_alert('no_induk');
		}
		
		
		}
	
}	
	
	
	
	
}

if (!isset ($_POST['submit'])){
$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_layanan` WHERE `id` = '$id'");
$getdata = mysqli_fetch_assoc($query);

$_POST = $getdata;

}

$content .= '
<form method="POST" action="" enctype="multipart/form-data" name="input_jabatan">
<table width=100%>

<tr>
<td>Nama</td>
<td>:</td>
<td>'.input_text ('nama',@$_POST['nama']).'</td>
</tr>
<tr>
<td>Keterangan</td>
<td>:</td>
<td>'.input_text ('ket',@$_POST['ket']).'</td>
</tr>

<tr>
<td>Link</td>
<td>:</td>
<td>'.input_text ('link',@$_POST['link']).'</td>
</tr>



<tr>
<td>Icon</td>
<td>:</td>
<td>'.input_text ('icon',@$_POST['icon']).'</td>
</tr>


<tr>
<td></td>
<td></td>
<td><a href="https://fontawesome.com/v4.7.0/icons/" target="_blank">https://fontawesome.com/v4.7.0/icons/</a></td>
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
		$query = $koneksi_db->sql_query ("DELETE FROM `mod_data_layanan` WHERE `id`='$v'");
			$query2 = $koneksi_db->sql_query ("DELETE FROM `mod_data_foto` WHERE `kat`='$v'");
	}
	}
	
}



$query_add = '';
if (isset ($_GET['str']) && !empty($_GET['str'])){
	$str = substr($_GET['str'],0,1);
$query_add .= "WHERE LEFT (`nama`,1) = '$str'";
}







$num = $koneksi_db->sql_query("SELECT `id` FROM `mod_data_layanan` $query_add");
$jumlah = $koneksi_db->sql_numrows ($num);
//mysqli_free_result ($num);

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

<th>Nama</th>
<th>Link</th>

<th>Icon</th>
	<th>Edit</th>
	<th><a href="javascript:checkall(\'namaform\', \'delete[]\');">Delete</a></th>
</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_layanan` $query_add ORDER By `id` ASC LIMIT $offset, $limit");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#f9f9f9"';
else $warna = null;	
$no ++;
$id = $data['id'];


$content .= '<tr>
	<td>'.$no.'</td>
<td>'.$data['nama'].'</td>
<td>'.$data['link'].'</td>

<td>'.$data['icon'].'</td>

	<td><a href="admin.php?pilih=layanan&amp;modul=yes&amp;action=edit&amp;id='.$id.'&amp;referer='.$referer.'">Edit</a></td>
	<td><input type="checkbox" name="delete[]" value="'.$id.'" style="border:0px"></td>
	
</tr>';
}


$content .= '<tr><td>&nbsp;</td>

<td>&nbsp;</td><td>&nbsp;</td>
<td>&nbsp;</td><td>&nbsp;</td>
    <td><input type="submit" name="deleted" value="Delete" onclick="return confirm (\'Do You Want to Delete the Data\')"></td>
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
<input type="hidden" name="pilih" value="layanan">
<input type="hidden" name="modul" value="yes">
<input type="hidden" name="action" value="cari">

</form>

';

if (isset ($_POST['deleted'])){
	if (is_array (@$_POST['delete'])){
	foreach ($_POST['delete'] as $k=>$v){
		$query = $koneksi_db->sql_query ("DELETE FROM `mod_data_layanan` WHERE `id`='$v'");
			$query2 = $koneksi_db->sql_query ("DELETE FROM `mod_data_foto` WHERE `kat`='$v'");
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






$num = $koneksi_db->sql_query("SELECT `id` FROM `mod_data_layanan` $query_add");
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

<th>Nama</th>
<th>Link</th>

<th>Icon</th>
	<th>Edit</th>
	<th><a href="javascript:checkall(\'namaform\', \'delete[]\');">Delete</a></th>
</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_layanan` $query_add ORDER By `id` ASC LIMIT $offset, $limit");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#f9f9f9"';
else $warna = null;	
$no ++;
$id = $data['id'];


$content .= '<tr>
	<td>'.$no.'</td>
<td>'.$data['nama'].'</td>
<td>'.$data['link'].'</td>

<td>'.$data['icon'].'</td>

	<td><a href="admin.php?pilih=layanan&amp;modul=yes&amp;action=edit&amp;id='.$id.'&amp;referer='.$referer.'">Edit</a></td>
	<td><input type="checkbox" name="delete[]" value="'.$id.'" style="border:0px"></td>
	
</tr>';
}


$content .= '<tr><td>&nbsp;</td>

<td>&nbsp;</td><td>&nbsp;</td>
<td>&nbsp;</td><td>&nbsp;</td>
    <td><input type="submit" name="deleted" value="Delete" onclick="return confirm (\'Do You Want to Delete the Data\')"></td>
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