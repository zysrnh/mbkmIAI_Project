<h4>Buat Halaman</h4><br/><p>
<a href="admin.php?pilih=pages&amp;modul=yes">List Data</a> | 
<a href="admin.php?pilih=pages&amp;modul=yes&amp;action=add">Add Data</a> | 
<a href="admin.php?pilih=pages&amp;modul=yes&amp;action=cari">Cari Data</a>

<?php


$JS_SCRIPT = <<<js
<!-- TinyMCE -->
<script src="js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
        selector: "textarea#elm1",
        theme: "modern",
        width: "100%",
        height: 200,
        plugins: [
             "leaui_formula advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
             "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
             "save table contextmenu directionality emoticons template paste textcolor"
       ],
       content_css: "css/content.css",
	   paste_data_images: true,
       toolbar: "leaui_formula  insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons", 
       style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ]
    }); 
</script>
<!-- /TinyMCE -->
js;


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


$datawajibdiisi = array ('judul','konten');

if (isset ($_POST['submit'])){
	
	
$error = '';	
	
foreach ($datawajibdiisi as $k=>$v){
	
	if (empty ($_POST[$v])){
		input_alert($v);
		$error .= '- Error In Form Filling: '.$v.'<br />';
	}
}

$judul= cleantext($_POST['judul']);
$konten = $_POST['konten'];

$image_name		=$_FILES['image']['name'];
$image_size		=$_FILES['image']['size'];
$image_type		=$_FILES['image']['type'];
$url=str_replace(" ", "-", $judul);

	$maxsize    = 1000000;
if ($image_size >= $maxsize){ 	
	
	 $error .= '- Ukuran gambar terlalu besar, jangan melebihi 1 MB<br />';
}
else {
	
	
}


if (!$image_name){
	$foto	="";
	
} else {
	
	$foto	="$url.jpg";

$check = getimagesize($_FILES['image']['tmp_name']);

if($check !== false) {
	
   
    $uploadOk = 1;
	

	
} else {
  $error .= '- Ini bukan gambar<br />';
    $uploadOk = 0;
}

}

//$password = base64_encode($judul);
	if ($error != ''){
$content .= '<div class="error">'.$error.'</div>';

}else {
	$insert = $koneksi_db->sql_query ("INSERT INTO `halaman` (`judul`,`foto`,`konten`) VALUES ('$judul','$foto','$konten')");
	if ($insert) {
		if (!$image_name){
			
		} else {
			
				$url=str_replace(" ", "-", $judul);
		copy($_FILES['image']['tmp_name'], "./images/pages/".$url.".jpg");
		
		
		
		
		
		
		
			
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

$propinsi5 = $koneksi_db->sql_query("SELECT * FROM topik ORDER BY id ASC");
while($p11=$koneksi_db->sql_fetchrow($propinsi5)){
$kode1 = $p11['id'];
	$judul1 = $p11['topik'];
$asal44 .= '<option value="'.$kode1.'">'.$judul1.'</option>';
}
$content .= '
<form method="POST" action="" enctype="multipart/form-data" name="input_siswa">
<table width=100%>

<tr>
<td>Judul Halaman</td>
<td>:</td>
<td>'.input_text ('judul',@$_POST['judul']).'</td>
</tr>

<tr>
<td></td>
<td></td>
<td><textarea id="elm1" name="konten" rows="15" cols="80" style="width: 100%;">'.htmlspecialchars(@$_POST['konten']).'</textarea></td>
</tr>


<tr>
<td>File Gambar</td>
<td>:</td>
<td><input name="image" type="file"  style="margin-top:2px;"/></td>
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


$datawajibdiisi = array ('judul');

if (isset ($_POST['submit'])){
	
	
$error = '';	
	
foreach ($datawajibdiisi as $k=>$v){
	
	if (empty ($_POST[$v])){
		input_alert($v);
		$error .= '<li>Error Dalam Pengisian Form : '.$v.'</li>';
	}
}
$judul= cleantext($_POST['judul']);
$konten = $_POST['konten'];


$image_name		=$_FILES['image']['name'];
$image_size		=$_FILES['image']['size'];
$image_type		=$_FILES['image']['type'];
$url=str_replace(" ", "-", $judul);

	$maxsize    = 1000000;
if ($image_size >= $maxsize){ 	
	
	 $error .= '- Ukuran gambar terlalu besar, jangan melebihi 1 MB<br />';
}
else {
	
	
}


if (!$image_name){
	$foto	=cleantext($_POST['foto']);
} else {
$foto	="$url.jpg";
$check = getimagesize($_FILES['image']['tmp_name']);

if($check !== false) {
	
	
	
   
    $uploadOk = 1;
	

	
} else {
  $error .= '- Ini bukan gambar<br />';
    $uploadOk = 0;
}

}
//$password = base64_encode($no_induk);

	
	if ($error != ''){
$content .= '<div class="error">'.$error.'</div>';

}else {
	$insert = $koneksi_db->sql_query ("UPDATE `halaman` SET `judul`='$judul',`foto`='$foto',`konten`='$konten' WHERE `id` = '$id'");
	if ($insert) {
		
		if (!$image_name){
} else {
	$url=str_replace(" ", "-", $judul);
		copy($_FILES['image']['tmp_name'], "./images/pages/".$url.".jpg");
		
		
		
		
		
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
$query = $koneksi_db->sql_query ("SELECT * FROM `halaman` WHERE `id` = '$id'");
$getdata = $koneksi_db->sql_fetchrow($query);

$_POST = $getdata;
$foto = $getdata['foto'];
}
$script_include[] = $JS_SCRIPT;

$content .= '
<form method="POST" action="" enctype="multipart/form-data" name="input_guru">
<table width=100%>
<input type="hidden" name="foto" value="'.$foto.'">

<tr>
<td>Judul Halaman</td>
<td>:</td>
<td>'.input_text ('judul',@$_POST['judul']).'</td>
</tr>

<tr>
<td></td>
<td></td>
<td><textarea id="elm1" name="konten" rows="15" cols="80" style="width: 100%;">'.htmlspecialchars(@$_POST['konten']).'</textarea></td>
</tr>


<tr>
<td>File Gambar</td>
<td>:</td>
<td><input name="image" type="file" style="margin-top:2px;" /></td>
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
		$query = $koneksi_db->sql_query ("DELETE FROM `halaman` WHERE `id`='$v'");
	}
	}
	
}



$query_add = '';
if (isset ($_GET['str']) && !empty($_GET['str'])){
	$str = substr($_GET['str'],0,1);
$query_add .= "WHERE LEFT (`judul`,1) = '$str'";
}




$num = $koneksi_db->sql_query("SELECT `id` FROM `halaman`");
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
$content .= '<form method="POST" action="" id="judulform">
<div class="table-responsive"><table class="table table-hover">';

$content .= '<tr>
<th>No.</th>

<th>Judul Halaman</th>
<th>Isi Halaman</th>
<th>Action</th>
<th>Edit</th>
<th><a href="javascript:checkall(\'judulform\', \'delete[]\');">Delete</a></th>
</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `halaman` $SORT_SQL LIMIT $offset, $limit");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#"';
else $warna = null;	
$no++;
$id = $data['id'];
$urlkat=str_replace(" ", "-", $data['judul']);




$content .= '<tr>
	<td>'.$no.'.</td>

		<td><b>'.$data['judul'].'</b><br/>'.$data['foto'].'</td>
	<td>'.limitTXT(strip_tags($data['konten']),140).'</td>

	
	<td><a href="admin.php?pilih=admin_menu&amp;aksi=addsub&amp;url=pages/'.$data['id'].'/'.$urlkat.'.html">Submenu</a></td>
	
	<td><a href="admin.php?pilih=pages&amp;modul=yes&amp;action=edit&amp;id='.$id.'&amp;referer='.$referer.'">Edit</a></td>';
	
	if ($id==1|| $id==2||$id==3||$id==4||$id==5){
	$content .= '<td><img src="images/cross.png"></td>';	
	
		
		
		
		}else {
		$content .= '<td><input type="checkbox" name="delete[]" value="'.$id.'" style="border:0px"></td> ';		
		}
	
	
	$content .= '
</tr>';
}


$content .= '<tr>
<td>&nbsp;</td>
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


$_GET['field'] = !isset ($_GET['field']) ? 'judul' : $_GET['field'];



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
<input type="hidden" name="pilih" value="pages">
<input type="hidden" name="modul" value="yes">
<input type="hidden" name="action" value="cari">

</form>

';

if (isset ($_POST['deleted'])){
	if (is_array (@$_POST['delete'])){
	foreach ($_POST['delete'] as $k=>$v){
		$query = $koneksi_db->sql_query ("DELETE FROM `halaman` WHERE `id`='$v'");
	}
	}
	
}

$filter_field = array ('judul');
if (!empty ($_GET['search']) && !empty($_GET['field']) && in_array ($_GET['field'],$filter_field)){
$search = cleartext($_GET['search']);
$field = cleartext($_GET['field']);

$SQLOPERATOR = "LIKE '%$search%'";
if ($field == 'no_induk'){
	$SQLOPERATOR = "= '$search'";
}

$query_add = "WHERE `$field` $SQLOPERATOR";






$num = $koneksi_db->sql_query("SELECT `id` FROM `halaman` $query_add");
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
$content .= '<form method="POST" action="" id="judulform">
<div class="table-responsive"><table class="table table-hover">';

$content .= '<tr>
<th>No.</th>


<th>Judul Halaman</th>
<th>Isi Halaman</th>
<th>Action</th>
<th>Edit</th>
<th><a href="javascript:checkall(\'judulform\', \'delete[]\');">Delete</a></th>
</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `halaman` $query_add $SORT_SQL LIMIT $offset, $limit");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#"';
else $warna = null;	
$no++;
$id = $data['id'];
$urlkat=str_replace(" ", "-", $data['judul']);
$content .= '<tr>
	<td>'.$no.'.</td>

		<td><b>'.$data['judul'].'</b><br/>'.$data['foto'].'</td>
	<td>'.limitTXT(strip_tags($data['konten']),140).'</td>

	
	<td><a href="admin.php?pilih=admin_menu&amp;aksi=addsub&amp;url=pages/'.$data['id'].'/'.$urlkat.'.html">Submenu</a></td>
	
	<td><a href="admin.php?pilih=pages&amp;modul=yes&amp;action=edit&amp;id='.$id.'&amp;referer='.$referer.'">Edit</a></td>';
	
	if ($id==1|| $id==2||$id==3||$id==4||$id==5){
	$content .= '<td><img src="images/cross.png"></td>';	
	
		
		
		
		}else {
		$content .= '<td><input type="checkbox" name="delete[]" value="'.$id.'" style="border:0px"></td> ';		
		}
	
	
	$content .= '
</tr>';
}


$content .= '<tr>
<td>&nbsp;</td>
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