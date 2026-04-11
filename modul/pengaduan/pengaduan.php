<h4>Form Pengaduan</h4><br/><p>
  
<?php


  $pilih = cleartext($_GET['pilih']);

$seo1= $koneksi_db->sql_query("SELECT * FROM mod_data_meta WHERE nama='$pilih'");
while($pr1xypd=$koneksi_db->sql_fetchrow($seo1)){
	$judulseo1 = $pr1xypd['judul'];
$desseo1 = $pr1xypd['meta'];
$keyseo1 = $pr1xypd['tags'];
}

$judul_situs = $judulseo1;
$_META['description'] = $desseo1;
$_META['keywords'] = $keyseo1;


$content='';

switch (@$_GET['action']){


	
	

	
	
default:






$datawajibdiisi = array ('a','b','c','d','e','f');

if (isset ($_POST['submit'])){
	
	
$error = '';	
	
foreach ($datawajibdiisi as $k=>$v){
	
	if (empty ($_POST[$v])){
		input_alert($v);
		$error .= '- Error Dalam Pengisian Form : '.$v.'<br />';
	}
}




$a = cleantext($_POST['a']);
$b = cleantext($_POST['b']);
$c = cleantext($_POST['c']);
$d = cleantext($_POST['d']);
$e = cleantext($_POST['e']);
$f = cleantext($_POST['f']);
if ( @$_POST['keykode']!= @$_SESSION['Var_session'] or !isset($_SESSION['Var_session'])){
	$error .= '- Key Kode salah<br />';
	input_alert('keykode');
	
	}
	
if ($error != ''){
	echo '<div class=error>'.$error.'</div>';
}else {

   
    
	$insert = $koneksi_db->sql_query ("INSERT INTO `mod_data_pengaduan` (`a`,`b`,`c`,`d`,`e`,`f`) VALUES ('$a','$b','$c','$d','$e','$f')");
	if ($insert) {
		echo '<div class=sukses>Terimakasih, akan kami tidak lanjuti.</div>';
		}
	else {
		echo '<div class=error>Data Gagal Dimasukkan<br>'.mysqli_error().'</div>';
		if (eregi ($no_induk,mysqli_error())) {
			input_alert('no_induk');
		}
		}
		
		
	
}	
	
	
	
	
}





echo '
<form method="POST" action="" enctype="multipart/form-data" name="input_jabatan">
<table width=100%>

<tr>
<td>Nama Lengkap</td>
<td>:</td>
<td>'.input_text ('a',@$_POST['a']).'</td>
</tr>


<tr>
<td>No. KTP/SIM</td>
<td>:</td>
<td>'.input_text ('b',@$_POST['b']).'</td>
</tr>

<tr>
<td>No. Telp</td>
<td>:</td>
<td>'.input_text ('c',@$_POST['c']).'</td>
</tr>

<tr>
<td>Email (Valid)</td>
<td>:</td>
<td>'.input_text ('d',@$_POST['d']).'</td>
</tr>

<tr>
<td>Judul Pengaduan</td>
<td>:</td>
<td>'.input_text ('e',@$_POST['e']).'</td>
</tr>

<tr>
<td>Isi Pengaduan</td>
<td>:</td>
<td>'.input_textarea2 ('f',@$_POST['f']).'</td>
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
<td><input type="submit" name="submit" value="Kirim"></td>
</tr>

</table>
</form>

';


break;	












}














/////////////
echo $content;

?>