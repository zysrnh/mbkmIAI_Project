<h4>Data Pengguna</h4><br/><p>
  <a href="admin.php?pilih=pengguna&amp;modul=yes">List Data</a> | 
  <a href="admin.php?pilih=pengguna&amp;modul=yes&amp;action=add">Add Data</a> |
  <a href="admin.php?pilih=pengguna&amp;modul=yes&amp;action=cari">Search Data</a>
  
  
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



switch (@$_GET['action']){


	
	
	
	
	
		
	
case 'cari':


$_GET['field'] = !isset ($_GET['field']) ? 'nama' : $_GET['field'];



$content .= '
<form method="GET" action="">
<table border=0>
<tr>
<td>&nbsp;&nbsp;&nbsp;Search </td><td>:&nbsp;&nbsp;&nbsp;</td><td>'.input_text ('search',@$_GET['search'],$type='text',$size=33,$opt='').'</td>
</tr>
<tr>
<td></td><td></td><td><input type="submit" name="submit" value="Search"></td>
</tr>
</table>
<input type="hidden" name="pilih" value="pengguna" />
<input type="hidden" name="modul" value="yes" />
<input type="hidden" name="action" value="cari" />

</form>
<br>
';
 

$filter_field = array ('nama');
if (!empty ($_GET['search']) && !empty($_GET['field']) && in_array ($_GET['field'],$filter_field)){
$search = cleantext($_GET['search']);
$field = cleantext($_GET['field']);

$SQLOPERATOR = "LIKE '%$search%'";
if ($field == 'jabatan_tamat'){
	$SQLOPERATOR = "= '$search'";
}

$query_add = "WHERE `$field` $SQLOPERATOR";

if (isset ($_POST['deleted'])){
	if (is_array (@$_POST['delete'])){
	foreach ($_POST['delete'] as $k=>$v){
			$query = $koneksi_db->sql_query ("DELETE FROM `pengguna` WHERE `user`='$v'");
		$query2 = $koneksi_db->sql_query ("DELETE FROM `pengguna` WHERE `user`='$v'");
	}
	}
	
}


$SORT_SQL = '';
$filter_field = array ('nama');
if (isset ($_GET['sort']) && !empty($_GET['sort']) && in_array ($_GET['order'],$filter_field)){
	$sort = $_GET['sort'];
	$order = $_GET['order'];
	if ($sort == 'asc') $sortSQL = 'ASC';
	else if ($sort == 'dsc') $sortSQL = 'DESC';
	
$SORT_SQL = "ORDER BY `$order` $sortSQL";
}


$num = $koneksi_db->sql_query("SELECT `UserId` FROM `pengguna` $query_add");
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
<div class="table-responsive">
<table class="table table-hover">';

$content .= '<tr>
	<th>No.</td>
<th>Nama</th>
<th>Alamat</th>
<th>Email</th>
<th>Level</th>
	<th>Edit</th>
	<th><a href="javascript:checkall(\'namaform\', \'delete[]\');">Delete</a></th>
</tr>';





$query = $koneksi_db->sql_query ("SELECT * FROM `pengguna` $query_add ORDER By `UserId` ASC LIMIT $offset, $limit");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#f9f9f9"';
else $warna = null;	
$no ++;
$id = md5($data['UserId']);


$content .= '<tr>
	<td>'.$no.'</td>

<td>'.$data['nama'].'<br/>'.$data['user'].'<br/>
<a href="admin.php?pilih=pengguna&amp;modul=yes&amp;action=edit2&amp;id='.$id.'&amp;referer='.$referer.'">Reset</a>
</td>
<td>'.$data['alamat'].'<br/>Telp. '.$data['telp'].'</td>
<td>'.$data['email'].'</td>
<td>'.$data['level'].'</td>


	<td><a href="admin.php?pilih=pengguna&amp;modul=yes&amp;action=edit&amp;id='.$id.'&amp;referer='.$referer.'">Edit</a></td>
	<td><input type="checkbox" name="delete[]" value="'.$data['user'].'" style="border:0px"></td>
	
</tr>';
}


$content .= '<tr><td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
    <td><input type="submit" name="deleted" value="Delete" onclick="return confirm (\'Do You Want to Delete the Data\')"></td>
  </tr>';  

$content .= '</table></div></form>';



$content .= '<p align=center>';
$content .= $a-> getPaging($jumlah, $_GET['pg'], $_GET['stg']);
$content .= '</p>';

	
	
}







break;	
	
	

		
	
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
$level = cleantext($_POST['level']);
$email = cleantext($_POST['email']);
$user = cleantext($_POST['user']);
$password = md5($user);
$nama = cleantext($_POST['nama']);
$alamat = cleantext($_POST['alamat']);
$telp = cleantext($_POST['telp']);
$tanggal = date('Y-m-d');
if ($error != ''){
	$content .= '<div class=error>'.$error.'</div>';
}else {

   
    
	$insert = $koneksi_db->sql_query ("INSERT INTO `pengguna` (`nama`,`alamat`,`telp`,`user`,`password`,`email`,`level`,`tanggal`) VALUES ('$nama','$alamat','$telp','$user','$password','$email','$level','$tanggal')");
	if ($insert) {
		
	
		$insert3s = $koneksi_db->sql_query ("INSERT INTO `mod_data_jumlah` (`nama`) VALUES ('1')");
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




$prop1xys= $koneksi_db->sql_query("SELECT * FROM mod_data_jumlah ORDER By id DESC LIMIT 1");
while($pr1xys=$koneksi_db->sql_fetchrow($prop1xys)){
	$idkats = $pr1xys['id'];
}

$ttgxx = date('ys');


$content .= '

<form method="POST" action="" enctype="multipart/form-data" name="input_jabatan">
<table width=100%>
<tr>
<td>Kode Pengguna</td>
<td>:</td>
<td><input type="text" value="'.$ttgxx.''.$idkats.'" disabled="disable"> <input type="hidden" value="'.$ttgxx.''.$idkats.'" name="user"></td>
</tr>

<tr>
<td>Nama Lengkap</td>
<td>:</td>
<td>'.input_text ('nama',@$_POST['nama']).'</td>
</tr>

<tr>
<td>Alamat</td>
<td>:</td>
<td>'.input_text ('alamat',@$_POST['alamat']).'</td>
</tr>
<tr>
<td>No. Telp</td>
<td>:</td>
<td>'.input_text ('telp',@$_POST['telp']).'</td>
</tr>

<tr>
<td>Email</td>
<td>:</td>
<td>'.input_text ('email',@$_POST['email']).'</td>
</tr>


<tr>
<td>Level</td>
<td>:</td>
<td><select name="level" required>
<option value="">-- Pilih Level --</option>
<option value="Administrator">Administrator</option>
<option value="Editor">Editor</option>
<option value="User">User</option>

</select>
</td>
</tr>



<tr>
<td></td>
<td></td>
<td><input type="submit" name="submit" value="Tambah"></td>
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
		$error .= '<li>Error In Form Filling : '.$v.'</li>';
	}
}

$email = cleantext($_POST['email']);
$nama = cleantext($_POST['nama']);
$alamat = cleantext($_POST['alamat']);
$telp = cleantext($_POST['telp']);


	
if ($error != ''){
	$content .= '<div class=error>'.$error.'</div>';
}else {
	$insert = $koneksi_db->sql_query ("UPDATE `pengguna` SET `nama`='$nama',`alamat`='$alamat',`telp`='$telp',`email`='$email' WHERE md5(`UserId`) = '$id'");
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
$query = $koneksi_db->sql_query ("SELECT * FROM `pengguna` WHERE md5(`UserId`) = '$id'");
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
<td>Alamat</td>
<td>:</td>
<td>'.input_text ('alamat',@$_POST['alamat']).'</td>
</tr>
<tr>
<td>No. Telp</td>
<td>:</td>
<td>'.input_text ('telp',@$_POST['telp']).'</td>
</tr>

<tr>
<td>Email</td>
<td>:</td>
<td>'.input_text ('email',@$_POST['email']).'</td>
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
		$query = $koneksi_db->sql_query ("DELETE FROM `pengguna` WHERE `user`='$v'");

	}
	}
	
}


$num = $koneksi_db->sql_query("SELECT `UserId` FROM `pengguna` $query_add");
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
<div class="table-responsive">
<table class="table table-hover">';

$content .= '<tr>
	<th>No.</td>

<th>Nama</th>
<th>Alamat</th>
<th>Email</th>
<th>Level</th>
	<th>Edit</th>
	<th><a href="javascript:checkall(\'namaform\', \'delete[]\');">Delete</a></th>
</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `pengguna` $query_add ORDER By `UserId` ASC LIMIT $offset, $limit");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#f9f9f9"';
else $warna = null;	
$no ++;
$id = md5($data['UserId']);


$content .= '<tr>
	<td>'.$no.'</td>
<td>'.$data['nama'].'<br/>'.$data['user'].'<br/>
<a href="admin.php?pilih=pengguna&amp;modul=yes&amp;action=edit2&amp;id='.$id.'&amp;referer='.$referer.'">Reset</a>
</td>
<td>'.$data['alamat'].'<br/>Telp. '.$data['telp'].'</td>
<td>'.$data['email'].'</td>
<td>'.$data['level'].'</td>

	<td><a href="admin.php?pilih=pengguna&amp;modul=yes&amp;action=edit&amp;id='.$id.'&amp;referer='.$referer.'">Edit</a></td>
	<td><input type="checkbox" name="delete[]" value="'.$data['user'].'" style="border:0px"></td>
	
</tr>';
}


$content .= '<tr><td>&nbsp;</td>

<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
    <td><input type="submit" name="deleted" value="Delete" onclick="return confirm (\'Do You Want to Delete the Data\')"></td>
  </tr>';  

$content .= '</table></div></form>';


$content .= '<p align=center>';
$content .= $a-> getPaging($jumlah, $_GET['pg'], $_GET['stg']);
$content .= '</p>';




break;	










	
case 'edit2':


$id = $_GET['id'];
if (!empty ($_GET['id'])){

$datawajibdiisi = array ('pass');

if (isset ($_POST['submit'])){
	
	
$error = '';	
	
foreach ($datawajibdiisi as $k=>$v){
	
	if (empty ($_POST[$v])){
		input_alert($v);
		$error .= '<li>Error In Form Filling : '.$v.'</li>';
	}
}


$pass = md5($_POST['pass']);



	
if ($error != ''){
	$content .= '<div class=error>'.$error.'</div>';
}else {
	$insert = $koneksi_db->sql_query ("UPDATE `pengguna` SET `password`='$pass' WHERE md5(`UserId`) = '$id'");
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
$query = $koneksi_db->sql_query ("SELECT * FROM `pengguna` WHERE md5(`UserId`) = '$id'");
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
<td>Alamat</td>
<td>:</td>
<td>'.input_text ('alamat',@$_POST['alamat']).'</td>
</tr>
<tr>
<td>Level</td>
<td>:</td>
<td>'.input_text ('level',@$_POST['level']).'</td>
</tr>
<tr>
<td>Password Baru</td>
<td>:</td>
<td>'.input_text ('pass',@$_POST['pass']).'</td>
</tr>


<tr>
<td></td>
<td></td>
<td><input type="submit" name="submit" value="Reset"></td>
</tr>

</table>
</form>
';

}

break;	
	


}














/////////////
echo $content;

?>