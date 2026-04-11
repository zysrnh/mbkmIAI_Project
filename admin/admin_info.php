<h3 class="garis">Rubah Password</h3><?php

if (!defined('cms-ADMINISTRATOR')) {
	Header("Location: ../index.php");
	exit;
}

$admin = '';

if (!cek_login ()){
   $admin .='<h4 class="bg">Akses di hentikan, KLATENWEB.com</h4>';
}else{

global $koneksi_db,$PHP_SELF,$theme,$error;




if (isset($_POST["submit"])) {

$user		   = text_filter($_POST['user']);
$email	      = text_filter($_POST['email']);
$password0 = md5($_POST["password0"]);
$password1 = $_POST["password1"];
$password2 = $_POST["password2"];


$hasil = $koneksi_db->sql_query( "SELECT password,email FROM pengguna WHERE user='$user'" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
	$password=$data['password'];
	$email0=$data['email'];
	}
$error = '';
if (!$password0)  $error .= "Error: Silahkan masukkan password lama anda.<br />";
if (!$password1)  $error .= "Error: Silahkan masukkan password baru anda.<br />";
if (!$password2)  $error .= "Error: Silahkan masukkan ulang password baru anda.<br />";
checkemail($email);
if ($password0 != $password)  $error .= "Password lama tidak dikenal, silahkan ulangi lagi.<br />";
if ($password1 != $password2)   $error .= "Kedua password baru tidak sama, silahkan ulangi.<br />";


if ($error) {

$admin .='<div class="error">'.$error.'</div>';

} else {

$password3=md5($password1);
$hasil = $koneksi_db->sql_query( "UPDATE pengguna SET user='$user', email='$email', password='$password3' WHERE user='$user'" );

$admin.='<div class="sukses">Password successfully changed.</div>';
}

}

$user =  $_SESSION['UserName'];
$hasil =  $koneksi_db->sql_query( "SELECT * FROM pengguna WHERE user='$user'" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
	$id=$data[0];
	$user=$data[1];
	$email=$data[3];
}

$admin .='<div class="">';
$admin .='
<form method="post" action="">
    <table width="100%">
       
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
            <td></td> <td></td><td colspan="2">
            <input type="hidden" name="user" value="'.$user.'" />
            <input type="submit" name="submit" value="Update" />
            </td>
        </tr>
    </table>
</form> ';
$admin .='</div>';

}

echo $admin;


?> 