<h4>Form Login</h4><br/><p>
<?php



 
///ob_start();
global $koneksi_db;
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

$login  ='';
if (isset ($_POST['submit_login']) && @$_POST['loguser'] == 1){


	$login .= cms_login ();
}

if (!cek_login ()){

	if (isset ($_POST['submit_login'])){
	
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
	
	
$username = $_POST['username'];
$password = cleantext($_POST['password']);
$tanggal = date('Y-m-d');


	$insert = $koneksi_db->sql_query ("INSERT INTO `mod_data_login` (`username`,`password`,`tanggal`,`ip`) VALUES ('$username','$password','$tanggal','$ip')");

	
	
	
	
	
	
}
	

$login .= 'Silahkan login dengan memasukkan username dan password yang sudah anda daftarkan, jika merasa belum mendaftar silahkan klik tulisan Daftar.<br/><form method="post" action="">
<table width=100%>
  <tr>
    <td width="10%">Username </td><td width="1%">:</td><td><input type="text" class="inputlogin" name="username"> </td>
  </tr>
  <tr>
    <td>Password </td><td>:</td><td><input type="password" class="inputlogin" name="password"></td>
  </tr>';


  
  
$login .='<tr>
    <td></td><td></td><td valign=top><input type="hidden" value="1" name="loguser" /><input type="submit" value="Login" name="submit_login" /> <a href="register.html" title="Daftar">atau Daftar</a></td>
  </tr>
  </table>
</form>';

}else{

$login .='  Gunakan header menu untuk mengelola konten.';



} //akhir cek login

echo $login;



?>   
