<h4>Form Login</h4><br/><p>
<?php



 
///ob_start();
global $koneksi_db;

$login  ='';
if (isset ($_POST['submit_login']) && @$_POST['loguser'] == 1){


	$login .= cms_loginadmin ();
}

if (!cek_login ()){

$login .= '<form method="post" action="">
<table width=100%>
 <tr>
    <td width="10%">Username </td><td width="1%">:</td><td><input type="text" class="inputlogin" name="username"> </td>
  </tr>
  <tr>
    <td>Password </td><td>:</td><td><input type="password" class="inputlogin" name="password"></td>
  </tr>';


  
  
$login .='<tr>
    <td></td><td></td><td valign=top><input type="hidden" value="1" name="loguser" /><input type="submit" value="Login" class="buttonlogin" name="submit_login" /></td>
  </tr>
  </table>
</form>';

}else{

$login .='  Gunakan header menu untuk mengelola konten.';



} //akhir cek login

echo $login;



?>  