 <?php

/*
if(ereg(basename (__FILE__), $_SERVER['PHP_SELF']))
{
	header("HTTP/1.1 404 Not Found");
	exit;
}
*/
$tengah = null;

global $koneksi_db,$error;

if($_GET['aksi']=="register"){
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

$tengah .='    <h3 class="garis">Form Pendaftaran</h3>
<p>Silahkan daftar sebagai member dan manfaatkan fasilitas yang lebih lengkap pada website kami, seperti mengirimkan artikel, pengaduan, dan saran serta anda juga bisa bergabung dengan forum yang terdapat didalam website ini.</p>
                 ';

if(isset($_POST['submit'])){
$_POST = array_map('cleantext',$_POST);
$email = cleantext($_POST['email']);
$telp = cleantext($_POST['telp']);
$ktp = cleantext($_POST['ktp']);
$alamat = cleantext($_POST['alamat']);
$user = cleantext($_POST['user']);
$nama = cleantext($_POST['nama']);




$password     = md5($_POST['password']);
$rpassword    = md5($_POST['rpassword']);
$cekperaturan = $_POST['cekperaturan'];

$mail_blocker = explode(",", $mail_blocker);
	foreach ($mail_blocker as $key => $val) {
		if ($val == strtolower($email) && $val != "") $error .= "Given E-Mail the address is forbidden to use!<br />";
}
$name_blocker = explode(",", $name_blocker);
	foreach ($name_blocker as $key => $val) {
		if ($val == strtolower($nama) && $val != "") $error .= "Named it is forbidden to use!<br />";
}

if (!$user || preg_match("/[^a-zA-Z0-9_-]/", $user)) $error .= "Error: Karakter Username tidak diizinkan kecuali a-z,A-Z,0-9,-, dan _<br />";
if (strlen($user) > 10) $error .= "Username Terlalu Panjang Maksimal 10 Karakter<br />";
if (strrpos($user, " ") > 0) $error .= "Username Tidak Boleh Menggunakan Spasi";
if ($koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT user FROM pengguna WHERE user='$user'")) > 0) $error .= "Error: Username ".$user." sudah terdaftar , silahkan ulangi.<br />";
if (!$nama)  $error .= "Error: Formulir Nama belum diisi , silahkan ulangi.<br />";
if (!$user)  $error .= "Error: Formulir Username belum diisi , silahkan ulangi.<br />";
if (empty($_POST['password']))  $error .= "Error: Formulir Password belum diisi , silahkan ulangi.<br />";
if ($_POST['password'] != $_POST['rpassword'])  $error .= "Password and Retype Password Not Macth.<br />";
if (!is_valid_email($email)) $error .= "Error: E-Mail address invalid!<br />";
if ($cekperaturan != '1') $error .= "You should be agree with rules and conditions of use!<br />";
if ( @$_POST['keykode']!= @$_SESSION['Var_session'] or !isset($_SESSION['Var_session'])){
	$error .= '- Key Kode salah<br />';
	input_alert('keykode');
	
	}
if ($error){
        $tengah.='<div class="error">'.$error.'</div>';
}else{
		$insert = $koneksi_db->sql_query ("INSERT INTO `pengguna` (`user`,`password`,`nama`,`level`,`email`,`telp`,`alamat`) VALUES ('$user','$password','$nama','User','$email','$telp','$alamat')");
	if ($insert) {
	
		$tengah .= '<div class=sukses>Pendaftaran berhasil, silahkan login.</div>';

		}
      
}

}



$checkperaturan = isset($_POST['cekperaturan']) ? ' checked="checked"' : '';



$tengah .='


<tr>
<td><form method="post" action="">
<table width="100%">

<tr>
<td>Username</td>
<td>:</td>
<td><input name="user" type="text" size="33" value="'.cleantext(stripslashes(@$_POST['user'])).'" /></td>
</tr>
<tr>
<td>E-mail</td>
<td>:</td>
<td><input name="email" type="text" size="33" value="'.cleantext(stripslashes(@$_POST['email'])).'" /></td>
</tr>
<tr>
<td>Password</td>
<td>:</td>
<td><input name="password" type="password" size="33" /></td>
</tr>
<tr>
<td>ReType Password</td>
<td>:</td>
<td><input name="rpassword" type="password" size="33" /></td>
</tr>
<tr>
<td>Nama Lengkap</td>
<td>:</td>
<td>'.input_text ('nama',@$_POST['nama']).'</td>
</tr>


<tr>
<td>No. Telp.</td>
<td>:</td>
<td>'.input_text ('telp',@$_POST['telp']).'</td>
</tr>
<tr>
<td>Alamat</td>
<td>:</td>
<td>'.input_textarea2 ('alamat',@$_POST['alamat']).'</td>
</tr>

<tr>
<td></td>
<td></td>
<td><input type="checkbox" name="cekperaturan" value="1" id="setuju"'.$checkperaturan.' /> Saya setuju mengikuti aturan yang berlaku.</td>
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
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="submit" value="Daftar" />
</tr>
</table>
</form></td>
</tr>
</table>';
$tengah .='';

}


if($_GET['aksi']=="change"){

if (!cek_login ()){
   $tengah .='<p class="judul">Access Denied !!!!!!</p>';
   
}else{

global $koneksi_db,$PHP_SELF,$theme,$error;

$tengah .='   <h3 class="garis">Rubah Password</h3>
                ';

if (isset($_POST["submit"])) {

$user		   = $_SESSION['UserName'];
$email	      = text_filter($_POST['email']);
$password0 = md5($_POST["password0"]);
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];

$hasil = $koneksi_db->sql_query( "SELECT password,email FROM pengguna WHERE user='$user'" );
while ($data = $koneksi_db->sql_fetchrow($hasil)){
	$password=$data['password'];
	$email0=$data['email'];
}

if (!$password0)  $error .= "Error: Please enter your Old Password!<br />";
if (!$password1)  $error .= "Error: Please enter new password!<br />";
if (!$password2)  $error .= "Error: Please retype your your new password!<br />";
if (!is_valid_email($email)) $error .= "Error, E-Mail address invalid!<br />";
if ($password0 != $password)  $error .= "Invalid old pasword, silahkan ulangi lagi.<br />";
if ($password1 != $password2)   $error .= "New password dan retype berbeda, silahkan ulangi.<br />";


if ($error) {
$tengah.='<div class="error">'.$error.'</div>';
} else {

$password3=md5($password1);
$hasil = $koneksi_db->sql_query( "UPDATE pengguna SET email='$email', password='$password3' WHERE user='$user'" );

$tengah.='<div class="sukses">Change password succeeded.</div>';
}

}

$user =  $_SESSION['UserName'];
$hasil =  $koneksi_db->sql_query( "SELECT * FROM pengguna WHERE user='$user'" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
	$id=$data[0];
	$user=$data[1];
	$email=$data[3];
}


$tengah .='<div>';
$tengah .='

<form method="post" action="">
    <table>
        
        <tr>
            <td>Email</td><td> : </td>
            <td><input type="text" size="30" name="email" value="'.$email.'" /></td>
        </tr>
        <tr>
            <td>Old Password</td><td> : </td>
            <td><input type="password" size="10" name="password0" /></td>
        </tr>
        <tr>
            <td>New Password</td><td> : </td>
            <td><input type="password" size="10" name="password1" /></td>
        </tr>
        <tr>
            <td>Retype New Password</td><td> : </td>
            <td><input type="password" size="10" name="password2" /></td>
        </tr>
        <tr>
            <td></td><td>  </td><td>
            <input type="hidden" name="id" value="'.@$UserId.'" />
            <input type="hidden" name="user" value="'.@$user.'" />
            <input type="submit" name="submit" value="Update" />
            </td>
        </tr>
    </table>
</form> ';
$tengah .='</div>';



}
}

echo $tengah;


?>
       
