
<h4>Hubungi Kami</h4><br/><p>
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


if (!defined('cms-KONTEN')) {
	Header("Location: ../index.php");
	exit;
}


//$index_hal=1;


$tengah='';

if (isset($_POST['submit'])) {

    $nama = text_filter($_POST['nama']);
    $email = text_filter($_POST['email']);
    $pesan = nl2br(text_filter($_POST['pesan'], 2));
    $error = '';
    if (!is_valid_email($email)) $error .= "Error: E-Mail address invalid!<br />";
    $gfx_check = $_POST['gfx_check'];
        if (!$nama)  $error .= "Error: Please enter your name!<br />";
        if (!$pesan) $error .= "Error: Please enter a message!<br />";

   // $code = substr(hexdec(md5("".date("F j")."".$_POST['random_num']."".$sitekey."")), 2, 6);
if ($gfx_check != $_SESSION['Var_session'] or !isset($_SESSION['Var_session'])) {$error .= "Security Code Invalid <br />";}
if (cek_posted('contact')){
	$error .= 'Anda Telah Memposting, Tunggu beberapa Saat';
}

	if ($error) {
        $tengah.='<div class="error">'.$error.'</div>';
	} else {
		$subject = "$judul_situs - Contact Form";
$msg = "
$judul_situs - Contact Form

Nama Pengirim: $nama <br />
Email Pengirim: $email <br />
Pesan: $pesan
";
	    mail_send($email_master, $email, $subject, $msg, 1, 1);
	    Posted('contact');

        $tengah.='<div class="sukses">Thank you, mail has been sent!</div>';

unset($nama);
unset($email);
unset($pesan);

      }

}

$nama = !isset($nama) ? '' : $nama;
$email = !isset($email) ? '' : $email;
$pesan = !isset($pesan) ? '' : $pesan;


$tengah .='<div class="">';
$tengah .= "

Anda bisa menghubungi kami melalui formulir yang disediakan di bawah ini.
Semua pesan yang Anda tulis disini dikirim ke email kami.
<br />

<br />

<form method=\"post\" action=\"\">

<table width=\"100%\">
  <tr>
    <td>Your Name</td>
    <td>:</td>
    <td><input type=\"text\" name=\"nama\"  size=\"25\" value=\"".$nama."\" /></td>
  </tr>
  <tr>
    <td>Your Email</td>
    <td>:</td>
    <td><input type=\"text\" name=\"email\"  size=\"25\" value=\"".$email."\" /></td>
  </tr>
  <tr>
    <td>Message</td>
    <td>:</td>
    <td><textarea name=\"pesan\"  cols=\"40\" rows=\"10\">".$pesan."</textarea></td>
  </tr>";

  if (extension_loaded("gd")) {
$tengah .= "
  <tr>
    <td>Security Code</td>
    <td>:</td>
    <td><img src=\"ikutan/code_image.php\" border=\"1\" alt=\"Security Code\" /></td>
  </tr>
  <tr>
    <td>Type Code</td>
    <td>:</td>
    <td><input type=\"text\" name=\"gfx_check\" size=\"10\" maxlength=\"6\" /></td>
  </tr>";

}
$tengah .= "
  <tr>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td><input type=\"submit\" name=\"submit\" value=\"Submit\" /></td>
  </tr>
</table>
</form>";
/*$tengah .='</td></tr></table></td></tr></table>';*/
$tengah .='</div>';


echo $tengah;

?>
