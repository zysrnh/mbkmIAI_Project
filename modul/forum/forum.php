<h4>Forum Diskusi</h4><br/><p>
<?php



$tengah='';
global $script_include,$style_include;

$JS_SCRIPT = <<<js
<!-- TinyMCE -->
<script src="plugin/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
	branding: false,
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>
<!-- /TinyMCE -->
js;

if (!isset($_SESSION['mod_forum'])) {
$_SESSION['mod_forum'] = array();
}
if (!isset($_SESSION['mod_forum']['viewthread'])) {
$_SESSION['mod_forum']['viewthread'] = array();
}
$_SESSION['UserName'] = isset($_SESSION['UserName']) ? $_SESSION['UserName'] : null;
$_SESSION['LevelAkses'] = isset($_SESSION['LevelAkses']) ? $_SESSION['LevelAkses'] : null;
$PATH = 'modul/forum/avatar/';

include 'modul/forum/inc/function.php';

if (isset($_POST['forum_login_'.session_id()])){
	
	
$user          = $_POST['username'];
$password      = md5($_POST['password']);
$query         = $koneksi_db->sql_query ("SELECT user,password,level,email FROM `pengguna` WHERE user='$user' AND password='$password' AND tipe='aktif'");
$total         = $koneksi_db->sql_numrows($query);
$data          = $koneksi_db->sql_fetchrow ($query);

if ($total > 0 && $user == $data['user'] && $password == $data['password']){


$_SESSION['UserName']= $data['user'];

$_SESSION['LevelAkses']= $data['level'];

$_SESSION['UserEmail']= $data['email'];
}else {
$_LOGIN_NOTIFY = '<div class="error" style="width:70%">Wrong Username or Password</div>';
}	

	
}

$index_hal = 1;
$script_include[] = <<<EOF

EOF;
$style_include[] = '<link rel="stylesheet" type="text/css" href="modul/forum/css/style.css" />';


$ForumMenu = '';
if($_SESSION['LevelAkses']=="Administrator"){
$ForumMenu = ' | <a href="index.php?pilih=forum&amp;modul=yes&amp;action=add_forum">Add Forum</a>  | <a href="index.php?pilih=forum&modul=yes&action=avatar">Ganti Photo</a> | <a href="index.php?pilih=forum&modul=yes&action=signature">Signature</a>';	
}
if ($_SESSION['LevelAkses']=="Editor") {
$ForumMenu = ' | <a href="index.php?pilih=forum&modul=yes&action=avatar">Ganti Photo</a> | <a href="index.php?pilih=forum&modul=yes&action=signature">Signature</a>';	
	
}
if ($_SESSION['LevelAkses']=="User") {
$ForumMenu = ' | <a href="index.php?pilih=forum&modul=yes&action=avatar">Ganti Photo</a> | <a href="index.php?pilih=forum&modul=yes&action=signature">Signature</a>';	
	
}

$tengah .= '<div ><a href="index.php?pilih=forum&amp;modul=yes">Beranda Forum</a> '.$ForumMenu.' </div>';




switch(@$_GET['action']) {
case 'userdetail':
$user = cleantext($_GET['user']);


$cek = $koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT `user` FROM `pengguna` WHERE `user` = '$user'"));
if ($cek) {
$query1 = $koneksi_db->sql_query("SELECT MIN(`thread_date`) AS `mindate`,MAX(`thread_date`) AS `maxdate`,COUNT(*) AS `total` FROM `mod_forum_t` WHERE `thread_user` = '$user'");
$data1 = $koneksi_db->sql_fetchrow($query1);
$mindate = datetimes($data1['mindate']);
$maxdate = datetimes($data1['maxdate']);
$total = $data1['total'];

$query2 = $koneksi_db->sql_query("SELECT COUNT(*) AS `total` FROM `mod_forum_t`");
$data2 = $koneksi_db->sql_fetchrow($query2);
$totalpost = $data2['total'];

$tengah .= '<table id="forum-diskusi" cellpadding="0" cellspacing="0">';
$tengah .= '<tr class="head"><td class="depan" colspan="3">&nbsp;</td></tr>';
$tengah .= '<tr class="isi"><td class="depan">User</td><td>:</td><td>'.$user.'</td></tr>';
$tengah .= '<tr class="isi"><td class="depan">Bergabung dalam Forum sejak</td><td>:</td><td>'.$mindate.'</td></tr>';
$tengah .= '<tr class="isi"><td class="depan">Terakhir posting</td><td>:</td><td>'.$maxdate.'</td></tr>';
$tengah .= '<tr class="isi"><td class="depan">Total Posting</td><td>:</td><td>'.$total.' dari '.$totalpost.' ('.round($total / $totalpost * 100,2).'%)</td></tr>';
$tengah .= '</table>';
}
break;
case 'avatar':
if (isset($_SESSION['UserName'])) {
$username = $_SESSION['UserName'];


if (isset ($_POST['submit'])){
	$avatar = cleantext($_POST['avatar']);
	
	$insert = $koneksi_db->sql_query ("UPDATE `mod_forum_a` SET `avatar` = '$avatar' WHERE `username` = '$username'");
	if ($insert) {
	$tengah .= '<div class=sukses>Avatar has been update.</div>';
	}
	
	
}


	

$tengah .= '<form action="" method="post" enctype="multipart/form-data"><table>';

$tengah .= '<tr><td>URL Picture</td><td>:</td><td><input type="text" name="avatar" size="33"></td></tr>';

$tengah .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="submit" name="submit" value="Process"></td></tr>';

$tengah .= '</table></form>';

}
break;
case 'signature':
if (isset($_SESSION['UserName'])) {
$username = $_SESSION['UserName'];
if (!isset($_POST['submit'])) {
$query1 = $koneksi_db->sql_query("SELECT `signature` FROM `mod_forum_a` WHERE `username` = '$username'");
$num = $koneksi_db->sql_numrows($query1);
if ($num == 0) {
$query1 = $koneksi_db->sql_query("INSERT INTO `mod_forum_a` (`username`) VALUES('$username')");	
}else {
	$data = $koneksi_db->sql_fetchrow($query1);
	$_POST['signature'] = $data['signature'];
}

}else {
	$signature = strip_tags($_POST['signature'],'<a><b><i><hr>');
	$update = $koneksi_db->sql_query("UPDATE `mod_forum_a` SET `signature` = '$signature' WHERE `username` = '$username'");
	if ($update) {
		$tengah .= '<div class="sukses">Sukses update signature</div>';
	}
}
$tengah .= '<form method="post" action=""><table>';

$tengah .= '<tr><td>Signature</td><td>:</td><td><textarea name="signature" cols="60" rows="4">'.htmlentities(stripslashes(@$_POST['signature'])).'</textarea></td></tr>';

$tengah .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="submit" name="submit" value="submit" /></td></tr>';

$tengah .= '</table></form>';
$tengah .= '';
}
break;
case 'del_forum':
if($_SESSION['LevelAkses']=="Administrator"){
$forum_id = intval($_GET['forum_id']);
$del = $koneksi_db->sql_query("DELETE FROM `mod_forum` WHERE `id` = '$forum_id'");
$del = $koneksi_db->sql_query("DELETE FROM `mod_forum_t` WHERE `forum_id` = '$forum_id'");
		if ($del) {
			header("location: index.php?pilih=forum&modul=yes");
			exit;
		}
}
break;
case 'add_forum':
$checked = null;
if($_SESSION['LevelAkses']=="Administrator"){
if (isset($_POST['submit'])) {
	$error = null;
	$checked = isset($_POST['lock']) ? 'checked="checked"' : '';

	if (empty($_POST['name'])) {
		$error .= 'Nama Forum tidak boleh kosong<br/>';
	}
	if (empty($_POST['desc'])) {
		$error .= 'Desc Forum tidak boleh kosong<br/>';
	}
	if ($error != '') {
		$tengah .= '<div class="error">'.$error.'</div>';
	}else {
		$_POST = array_map('strip_tags',$_POST);
		$forum_name = $_POST['name'];
		$forum_desc = $_POST['desc'];
		$forum_lock = @$_POST['lock'];
		$maxpost = $_POST['maxpost'];
		
		$insert = $koneksi_db->sql_query("INSERT INTO `mod_forum` (`forum_name`,`forum_desc`,`lock`,`maxpost`) VALUES('$forum_name','$forum_desc','$forum_lock','$maxpost')");
		if ($insert) {
			header("location: index.php?pilih=forum&modul=yes");
			exit;
		}
	}
	
}






$tengah .= '<form method="post" action=""><table>';
$tengah .= '<tr><td>Forum Name</td><td>:</td><td><input type="text" name="name" value="'.htmlentities(stripslashes(@$_POST['name'])).'" size="40" /></td></tr>';
$tengah .= '<tr><td>Desc</td><td>:</td><td><textarea name="desc" cols="60" rows="4">'.htmlentities(stripslashes(@$_POST['desc'])).'</textarea></td></tr>';
$tengah .= '<tr><td>max. post</td><td>:</td><td><input type="text" name="maxpost" value="'.htmlentities(stripslashes(@$_POST['maxpost'])).'" size="5" /></td></tr>';
$tengah .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="checkbox" name="lock" value="1" '.$checked.' /> Lock Forum</td></tr>';
$tengah .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="submit" name="submit" value="Add" /></td></tr>';

$tengah .= '</table></form>';
$tengah .= '';
}
break;
case 'edit_forum':
$forum_id = intval($_GET['forum_id']);
if($_SESSION['LevelAkses']=="Administrator"){
if (isset($_POST['submit'])) {
	$error = null;
	$checked = isset($_POST['lock']) ? 'checked="checked"' : '';

	if (empty($_POST['name'])) {
		$error .= 'Nama Forum tidak boleh kosong<br/>';
	}
	if (empty($_POST['desc'])) {
		$error .= 'Desc Forum tidak boleh kosong<br/>';
	}
	if ($error != '') {
		$tengah .= '<div class="error">'.$error.'</div>';
	}else {
		$_POST = array_map('strip_tags',$_POST);
		$forum_name = $_POST['name'];
		$forum_desc = $_POST['desc'];
		$forum_lock = @$_POST['lock'];
		$maxpost = $_POST['maxpost'];
		
		$update = $koneksi_db->sql_query("UPDATE `mod_forum` SET `forum_name` = '$forum_name', `forum_desc` = '$forum_desc', `lock` = '$forum_lock', `maxpost` = '$maxpost' WHERE `id` = '$forum_id'");
		if ($update) {
			header("location: index.php?pilih=forum&modul=yes");
			exit;
		}
	}
	
}


$query = $koneksi_db->sql_query("SELECT * FROM `mod_forum` WHERE `id` = '$forum_id'");
$data = $koneksi_db->sql_fetchrow($query);

if (!isset($_POST['submit'])) {
	$_POST['name'] = $data['forum_name'];
	$_POST['desc'] = $data['forum_desc'];
	$_POST['maxpost'] = $data['maxpost'];
	$checked = $data['lock'] ? 'checked="checked"' : '';
}



$tengah .= '<form method="post" action=""><table>';
$tengah .= '<tr><td>Forum Name</td><td>:</td><td><input type="text" name="name" value="'.htmlentities(stripslashes(@$_POST['name'])).'" size="40" /></td></tr>';
$tengah .= '<tr><td>Desc</td><td>:</td><td><textarea name="desc" cols="60" rows="4">'.htmlentities(stripslashes(@$_POST['desc'])).'</textarea></td></tr>';
$tengah .= '<tr><td>max. post</td><td>:</td><td><input type="text" name="maxpost" value="'.htmlentities(stripslashes(@$_POST['maxpost'])).'" size="5" /></td></tr>';
$tengah .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="checkbox" name="lock" value="1" '.$checked.' /> Lock Forum</td></tr>';
$tengah .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="submit" name="submit" value="Edit" /></td></tr>';

$tengah .= '</table></form>';
$tengah .= '';
}
break;
case 'delete_thread':
$forum_id = intval($_GET['forum_id']);
$thread_id = intval($_GET['thread_id']);
$username = $_SESSION['UserName'];

$query = $koneksi_db->sql_query("SELECT * FROM `mod_forum_t` WHERE `forum_id` = '$forum_id' AND `id` = '$thread_id' AND `thread_user` = '$username'");
$data = $koneksi_db->sql_fetchrow($query);
$thread_parent = $data['thread_parent'];
$del = $koneksi_db->sql_query("DELETE FROM `mod_forum_t` WHERE `forum_id` = '$forum_id' AND `id` = '$thread_id' AND `thread_user` = '$username'");
if ($thread_parent == 0) {
$del = $koneksi_db->sql_query("DELETE FROM `mod_forum_t` WHERE `forum_id` = '$forum_id' AND `thread_parent` = '$thread_id'");
}
if ($del) {
	$redirect = $_GET['redirect'];
	header("location: $redirect");
	exit;
}
break;
case 'new':
//print_r($_SESSION);
$forum_id = intval($_GET['forum_id']);



if (empty($_SESSION['UserName'])) {
$tengah .= '<div class="error">Maaf anda harus login dulu</div>';
	
	$tengah .= forum_login();

}else {

$cek = $koneksi_db->sql_query("SELECT `lock`,`maxpost` FROM `mod_forum` WHERE `id` = '$forum_id'");
$data_locked = $koneksi_db->sql_fetchrow($cek);
$forum_locked = $data_locked['lock'];
$forum_maxpost = $data_locked['maxpost'];

$cek2 = $koneksi_db->sql_query("SELECT count(*) AS `total` FROM `mod_forum_t` WHERE `forum_id` = '$forum_id'");
$data53 = $koneksi_db->sql_fetchrow($cek2);
$totalpost = $data53['total'];


if ($forum_locked) {
	$tengah .= '<div class="error">Maaf Forum tersebut di lock</div>';
}elseif ($totalpost >= $forum_maxpost && $forum_maxpost > 0) {
	$tengah .= '<div class="error">Maaf Forum tersebut limit maxpost '.$forum_maxpost.'</div>';
} else {
if (isset($_POST['preview'])) {
$tengah .= '<div >'.bbcode(stripslashes($_POST['comment'])).'</div>';
}


if (isset($_POST['submit'])) {
	$error = '';
	if (empty($_POST['subject'])) {
		$error .= '- Silahkan isi judul nya<br/>';
	}
	
	if (empty($_POST['comment'])) {
		$error .= '- Silahkan isi komentar nya<br/>';
	}
	    $gfx_check = $_POST['gfx_check'];

if ($gfx_check != $_SESSION['Var_session'] or !isset($_SESSION['Var_session'])) {$error .= "Security Code Invalid <br />";}
	if ($error != '') {
		$tengah .= '<div class="error" style="margin-top:10px">'.$error.'</div>';
	}else {
		$subject = trim(strip_tags($_POST['subject']));
		$comment = $_POST['comment'];
		$date = date('Y-m-d H:i:s');
		$username = $_SESSION['UserName'];
		$ip = getIP();
		$useragent = mysqli_escape_string(stripslashes($_SERVER["HTTP_USER_AGENT"]));
		$query = $koneksi_db->sql_query("INSERT INTO `mod_forum_t` (`thread_name`,`thread_desc`,`forum_id`,`thread_date`,`thread_user`,`thread_parent`,`ip`,`useragent`) VALUES('$subject','$comment','$forum_id','$date','$username','0','$ip','$useragent')");
		if ($query) {
			lastthread_forum($forum_id,mysqli_insert_id());
			exit;
		}else {
			$tengah .= '<div class="error" style="margin-top:10px">'.mysqli_error().'</div>';
		}
	}
	
}



$forum_id = intval($_GET['forum_id']);

$query = $koneksi_db->sql_query("SELECT `forum_name` FROM `mod_forum` WHERE `id` = '$forum_id'");
$data = $koneksi_db->sql_fetchrow($query);
$name = $data['forum_name'];



$script_include[] = $JS_SCRIPT;
$tengah .= '<div  style="font-weight:bold;">Forum : '.$data['forum_name'].'</div>';


$tengah .= '';
$tengah .= '<form method="post" action=""><table>';
$tengah .= '<tr><td>Judul</td><td>:</td><td><input type="text" name="subject" value="'.htmlentities(stripslashes(@$_POST['subject'])).'" size="40" /></td></tr>';
$tengah .= '<tr><td>Isi</td><td>:</td><td><textarea name="comment" cols="40" rows="4">'.stripslashes(htmlspecialchars(@$_POST['comment'])).'</textarea></td></tr>';



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

$tengah .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="submit" name="submit" value="Buat Posting" /></td></tr>';

$tengah .= '</table></form>';

$tengah .= '';




}

}

break;
case 'reply':
//print_r($_SESSION);
$forum_id = intval($_GET['forum_id']);
$thread_id = intval($_GET['thread_id']);



if (empty($_SESSION['UserName'])) {
	$tengah .= '<div class="error">Maaf anda harus login dulu</div>';
	
	$tengah .= forum_login();

}else {
	
	
$cek = $koneksi_db->sql_query("SELECT `maxpost`,`lock` FROM `mod_forum` WHERE `id` = '$forum_id'");
$data_locked = $koneksi_db->sql_fetchrow($cek);
$forum_locked = $data_locked['lock'];	
$forum_maxpost = $data_locked['maxpost'];	

$cek2 = $koneksi_db->sql_query("SELECT count(*) AS `total` FROM `mod_forum_t` WHERE `forum_id` = '$forum_id'");
$data53 = $koneksi_db->sql_fetchrow($cek2);
$totalpost = $data53['total'];

if ($forum_locked) {
	$tengah .= '<div class="error">Maaf anda tidak dapat me relpy post ini</div>';
}elseif ($totalpost >= $forum_maxpost && $forum_maxpost > 0) {
	$tengah .= '<div class="error">Maaf Forum tersebut limit maxpost '.$forum_maxpost.'</div>';
}

else {	


  
	
$query2 = $koneksi_db->sql_query("SELECT * FROM `mod_forum_t` WHERE `forum_id` = '$forum_id' AND `id` = '$thread_id'");
$data2 = $koneksi_db->sql_fetchrow($query2);


$thread_desc2 = wordwrap($data2['thread_desc'], 60, " ", TRUE);
/// ---- signature -------
$findSignatureAvatar = $koneksi_db->sql_query("SELECT `signature`,`avatar` FROM `mod_forum_a` WHERE `username` = '".$data2['thread_user']."'");
$getSignatureAvatar = $koneksi_db->sql_fetchrow($findSignatureAvatar);
if (!empty($getSignatureAvatar['signature'])){
$thread_desc2 .= '<br/><br/>' . nl2br($getSignatureAvatar['signature']);
}
$avatar = $getSignatureAvatar['avatar'];
$query1 = $koneksi_db->sql_query("SELECT MIN(`thread_date`) AS `mindate`,COUNT(`id`) AS `total` FROM `mod_forum_t` WHERE `thread_user` = '".$data2['thread_user']."'");
$data1 = $koneksi_db->sql_fetchrow($query1);
$mindate = date('d/m/Y',strtotime($data1['mindate']));
$total = $data1['total'];
/// ---- signature -------

$tengah .= '<div  style="font-weight:bold;">Topic : '.$data2['thread_name'].'</div>';


$tengah .= '<table id="forum-diskusi" cellspacing="0" cellpadding="0" style="width:100%">';
$tengah .= '<tr class="head"><td class="depan" style="width:25%;">Author</td><td style="width:75%;text-align:left" colspan="2">Post</td></tr>';

$tengah .= '<tr class="isi" style="background:#FCFAF0"><td class="depan" style="vertical-align:top;"><a name="topforum" title="'.$data2['ip'].' '.htmlentities($data2['useragent']).'" href="index.php?pilih=forum&amp;modul=yes&amp;action=userdetail&amp;user='.$data2['thread_user'].'">'.$data2['thread_user'].'</a></td><td><img src="modul/forum/images/date.png"alt="date.png" /> '.datetimes($data2['thread_date']).'</td><td style="width:5%;"><img src="modul/forum/images/comment_yellow.gif" alt="quote" /></td></tr>';
$tengah .= '<tr class="isi" style="background:#FCFAF0"><td class="depan" style="vertical-align:top;"><center>
';
if (!$avatar) {
$tengah .= '<img src="images/profilethumb.png" width="128" height="128">
';} else{
$tengah .= '<img src="'.$avatar.'" width="128" height="128">
';
}


$tengah .= '</center><br/><b>post :</b> '.$total.'<br/><b>Join :</b> '.$mindate.'</td><td style="text-align:left" colspan="2">'.$thread_desc2.'</td></tr>';

$tengah .= '</table>';

if (isset($_POST['preview'])) {
$tengah .= '<div >'.bbcode(stripslashes($_POST['comment'])).'</div>';
}


if (isset($_POST['submit'])) {
	$error = '';
	if (empty($_POST['subject'])) {
		$error .= '- Silahkan isi subject nya<br/>';
	}
	
	if (empty($_POST['comment'])) {
		$error .= '- Silahkan isi komentar nya<br/>';
	}
	  $gfx_check = $_POST['gfx_check'];

if ($gfx_check != $_SESSION['Var_session'] or !isset($_SESSION['Var_session'])) {$error .= "Security Code Invalid <br />";}


	if ($error != '') {
		$tengah .= '<div class="error" style="margin-top:10px">'.$error.'</div>';
	}else {
		$subject = trim(strip_tags($_POST['subject']));
		$comment = $_POST['comment'];
		$date = date('Y-m-d H:i:s');
		$username = $_SESSION['UserName'];
		$ip = getIP();
		$useragent = mysqli_escape_string(stripslashes($_SERVER["HTTP_USER_AGENT"]));
		$query = $koneksi_db->sql_query("INSERT INTO `mod_forum_t` (`thread_reply`,`thread_desc`,`forum_id`,`thread_date`,`thread_user`,`thread_parent`,`ip`,`useragent`) VALUES('$subject','$comment','$forum_id','$date','$username','$thread_id','$ip','$useragent')");
		if ($query) {
			lastpost_forum($forum_id,$thread_id,mysqli_insert_id());
			exit;
		}else {
			$tengah .= '<div class="error" style="margin-top:10px">'.mysqli_error().'</div>';
		}
	}
	
}



if (!isset($_POST['subject'])) {
$_POST['subject'] = $data2['thread_name'];	
}
$script_include[] = $JS_SCRIPT;
$tengah .= '<p>&nbsp;</p>';
$tengah .= '';
$tengah .= '<form method="post" action=""><table>';
$tengah .= '<tr><td>Posting</td><td>:</td><td><input type="text" name="subject" value="'.htmlentities(stripslashes(@$_POST['subject'])).'" size="40" /></td></tr>';
$tengah .= '<tr><td>Komentar</td><td>:</td><td><textarea name="comment" cols="40" rows="4">'.stripslashes(htmlspecialchars(@$_POST['comment'])).'</textarea></td></tr>';

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
$tengah .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="submit" name="submit" value="Komentar" /></td></tr>';

$tengah .= '</table></form>';

$tengah .= '';




}

}
break;
case 'viewthread':
$forum_id = intval($_GET['forum_id']);
$thread_id = intval($_GET['thread_id']);


$query2 = $koneksi_db->sql_query("SELECT COUNT(`id`) AS `total` FROM `mod_forum_t`");
$data2 = $koneksi_db->sql_fetchrow($query2);
$totalpost = $data2['total'];

if ($_SESSION['LevelAkses']=="Administrator") {
	
if (isset($_POST['delete'])) {
	//print_r($_POST);
	$forum_id = intval($_GET['forum_id']);
	//$thread_id = intval($_GET['thread_id']);
	$username = $_SESSION['UserName'];
	if (isset($_POST['del'])) {
		if (is_array($_POST['del'])) {
				foreach($_POST['del'] as $key=>$val) {
					$query = $koneksi_db->sql_query("SELECT * FROM `mod_forum_t` WHERE `forum_id` = '$forum_id' AND `id` = '$val'");
					$data = $koneksi_db->sql_fetchrow($query);
					$thread_parent = $data['thread_parent'];
					$del = $koneksi_db->sql_query("DELETE FROM `mod_forum_t` WHERE `forum_id` = '$forum_id' AND `id` = '$val'");
						if ($thread_parent == 0) {
						$del = $koneksi_db->sql_query("DELETE FROM `mod_forum_t` WHERE `forum_id` = '$forum_id' AND `thread_parent` = '$val'");
						}
					}
			}
	}
}	
	
	
$tengah .= '<form method="post" action="">';	
}

if (!in_array($thread_id,$_SESSION['mod_forum']['viewthread'])) {
$_SESSION['mod_forum']['viewthread'][] = $thread_id;
$update = $koneksi_db->sql_query("UPDATE `mod_forum_t` SET `thread_view` = thread_view + 1 WHERE `forum_id` = '$forum_id' AND `id` = '$thread_id'");
}

$query = $koneksi_db->sql_query("SELECT `forum_name` FROM `mod_forum` WHERE `id` = '$forum_id'");
$data = $koneksi_db->sql_fetchrow($query);
$name = $data['forum_name'];

$query2 = $koneksi_db->sql_query("SELECT * FROM `mod_forum_t` WHERE `forum_id` = '$forum_id' AND `id` = '$thread_id'");
$data2 = $koneksi_db->sql_fetchrow($query2);

$tengah .= '<div  style="font-weight:bold;">Forum/Topic : <a href="index.php?pilih=forum&amp;modul=yes&amp;action=viewtopic&amp;forum_id='.$forum_id.'">'.$data['forum_name'].'</a> / '.$data2['thread_name'].'</div>';

$tengah .= '<div style="text-align:right;"><a href="index.php?pilih=forum&amp;modul=yes&amp;action=new&amp;forum_id='.$forum_id.'&amp;thread_id='.$thread_id.'"><img src="modul/forum/images/new.png" alt="new post" /> Buat Posting</a> <a href="index.php?pilih=forum&amp;modul=yes&amp;action=reply&amp;forum_id='.$forum_id.'&amp;thread_id='.$thread_id.'"><img src="modul/forum/images/page_white_edit.png" alt="reply" /> Komentar</a></div>';


$tengah .= '<table id="forum-diskusi" cellspacing="0" cellpadding="0" style="width:100%">';
$tengah .= '<tr class="head"><td class="depan" style="width:25%;">Author</td><td style="width:75%;text-align:left" colspan="2">Post</td></tr>';



//---------- paging -------------------
$query1 = $koneksi_db->sql_query ("SELECT count(`id`) AS `total` FROM `mod_forum_t` WHERE `forum_id` = '$forum_id' AND `thread_parent` = '$thread_id'");
$getdata1 = $koneksi_db->sql_fetchrow($query1);
$jumlah = $getdata1['total'];
$limit = 10;
$pembagian = new paging ($limit);
if (empty($_GET['offset']) and !isset ($_GET['offset'])) {
$offset = 0;
}else {
$offset = int_filter($_GET['offset']);	
}

if (empty($_GET['pg']) and !isset ($_GET['pg'])) {
$pg = 1;
}else {
$pg = int_filter($_GET['pg']);	
}
if (empty($_GET['stg']) and !isset ($_GET['stg'])) {
$stg = 1;
}else {
$stg = int_filter($_GET['stg']);		
}
//---------- paging -------------------

$Hapus = '&nbsp;';
if ($_SESSION['UserName'] == $data2['thread_user'] && $_SESSION['LevelAkses'] == 'User') {
	$Hapus = '<a href="index.php?pilih=forum&amp;modul=yes&amp;action=delete_thread&amp;forum_id='.$forum_id.'&amp;thread_id='.$data2['id'].'&amp;redirect='.urlencode('index.php?pilih=forum&modul=yes&action=viewtopic&forum_id='.$forum_id).'" onclick="return confirm(\'Apakah anda yakin ingin menghapus data ini \n semua data pada topic ini akan terhapus ?\')"><img src="modul/forum/images/cross.png" alt="quote" /></a>';
}

$thread_desc2 = wordwrap($data2['thread_desc'], 60, " ", TRUE);

$inputChexbox = '';
if ($_SESSION['LevelAkses']=="Administrator") {
$inputChexbox = '<input type="checkbox" name="del[]" value="'.$data2['id'].'"/> ';	
}


/// ---- signature -------
$findSignatureAvatar = $koneksi_db->sql_query("SELECT `signature`,`avatar` FROM `mod_forum_a` WHERE `username` = '".$data2['thread_user']."'");
$getSignatureAvatar = $koneksi_db->sql_fetchrow($findSignatureAvatar);
if (!empty($getSignatureAvatar['signature'])){
$thread_desc2 .= '<br/><br/>' . nl2br($getSignatureAvatar['signature']);
}
$userr = $data2['thread_user'];
$propinsi13 = $koneksi_db->sql_query ("SELECT * FROM `pengguna` WHERE user='$userr'");
while ($data213 = $koneksi_db->sql_fetchrow($propinsi13)){
	$nip2 = $data213['nama'];
	$pengajar2 = $data213['level'];

}
$avatar = $getSignatureAvatar['avatar'];
$query1 = $koneksi_db->sql_query("SELECT MIN(`thread_date`) AS `mindate`,COUNT(`id`) AS `total` FROM `mod_forum_t` WHERE `thread_user` = '".$data2['thread_user']."'");
$data1 = $koneksi_db->sql_fetchrow($query1);
$mindate = date('d/m/Y',strtotime($data1['mindate']));
$total = $data1['total'];
/// ---- signature -------


if ($koneksi_db->sql_numrows($query2) > 0) {
$tengah .= '<tr class="isi" style="background:#FCFAF0"><td class="depan" style="vertical-align:top;">'.$inputChexbox.' <a name="topforum" title="'.$data2['ip'].' '.htmlentities($data2['useragent']).'" href="index.php?pilih=forum&amp;modul=yes&amp;action=userdetail&amp;user='.$data2['thread_user'].'">'.$nip2.' - '.$data2['thread_user'].'</a></td><td><img src="modul/forum/images/date.png"alt="date.png" /> '.datetimes($data2['thread_date'],true).'</td><td style="width:9%;">'.$Hapus.'</td></tr>';
$tengah .= '<tr class="isi" style="background:#FCFAF0"><td class="depan" style="vertical-align:top;"><center>
';
if (!$avatar) {
$tengah .= '<img src="images/profilethumb.png" width="128" height="128">
';} else{
$tengah .= '<img src="'.$avatar.'" width="128" height="128">
';
}
$tengah .= '
</center><br/><b>post :</b> '.$total.' ('.round($total / $totalpost * 100,2).'%)<br/><b>Bergabung :</b> '.$mindate.'<br/>'.$pengajar2.'</td><td style="text-align:left" colspan="2">'.$thread_desc2.'</td></tr>';
}




$query = $koneksi_db->sql_query("SELECT * FROM `mod_forum_t` WHERE `forum_id` = '$forum_id' AND `thread_parent` = '$thread_id' ORDER BY `id` LIMIT $offset,$limit");
$i = 0;
while($data = $koneksi_db->sql_fetchrow($query)) {
	if ($i % 2 == 0) {
	$className = ' forum-zebra-color';
}else {
	$className = '';
}

$Hapus = '&nbsp;';
$redirect = urlencode($_SERVER["REQUEST_URI"]);
if ($_SESSION['UserName'] == $data['thread_user'] && $_SESSION['LevelAkses'] == 'User') {
	$Hapus = '<a href="index.php?pilih=forum&amp;modul=yes&amp;action=delete_thread&amp;forum_id='.$forum_id.'&amp;thread_id='.$data['id'].'&amp;redirect='.$redirect.'" onclick="return confirm(\'Apakah anda yakin ingin menghapus data ini ?\')"><img src="modul/forum/images/cross.png" alt="quote" /></a>';
}
$inputChexbox = '';
if ($_SESSION['LevelAkses']=="Administrator") {
$inputChexbox = '<input type="checkbox" name="del[]" value="'.$data['id'].'"/> ';	
}
$thread_desc = wordwrap($data['thread_desc'], 60, " ", TRUE);
$thread_desc = auto_link($thread_desc);

/// ---- signature -------
$findSignatureAvatar = $koneksi_db->sql_query("SELECT `signature`,`avatar` FROM `mod_forum_a` WHERE `username` = '".$data['thread_user']."'");
$getSignatureAvatar = $koneksi_db->sql_fetchrow($findSignatureAvatar);
if (!empty($getSignatureAvatar['signature'])){
$thread_desc .= '<br/><br/>' . nl2br($getSignatureAvatar['signature']);
}
$avatar = $getSignatureAvatar['avatar'];

$query1 = $koneksi_db->sql_query("SELECT MIN(`thread_date`) AS `mindate`,COUNT(`id`) AS `total` FROM `mod_forum_t` WHERE `thread_user` = '".$data['thread_user']."'");
$data1 = $koneksi_db->sql_fetchrow($query1);
$mindate = date('d/m/Y',strtotime($data1['mindate']));
$total = $data1['total'];
/// ---- signature -------
$userr = $data['thread_user'];
$propinsi13 = $koneksi_db->sql_query ("SELECT * FROM `pengguna` WHERE user='$userr'");
while ($data213 = $koneksi_db->sql_fetchrow($propinsi13)){
	$nip2 = $data213['nama'];
	$pengajar2 = $data213['level'];

}

$tengah .= '<tr class="isi'.$className.'"><td class="depan" style="vertical-align:top;">'.$inputChexbox.'<a name="'.$data['id'].'" title="'.$data['ip'].' '.htmlentities($data['useragent']).'" href="index.php?pilih=forum&amp;modul=yes&amp;action=userdetail&amp;user='.$data['thread_user'].'">'.$nip2.' - '.$data['thread_user'].'</a></td><td><img src="modul/forum/images/date.png"alt="date.png" /> '.datetimes($data['thread_date'],true).'</td><td>'.$Hapus.'</td></tr>';
$tengah .= '<tr class="isi'.$className.'"><td class="depan" style="vertical-align:top;"><center>

';
if (!$avatar) {
$tengah .= '<img src="images/profilethumb.png" width="128" height="128">
';} else{
$tengah .= '<img src="'.$avatar.'" width="128" height="128">
';
}
$tengah .= '


</center><br/><b>post :</b> '.$total.' ('.round($total / $totalpost * 100,2).'%)<br/><b>Join :</b> '.$mindate.'<br/>'.$pengajar2.'</td><td style="width:75%;text-align:left" colspan="2">RE: <b>'.$data['thread_reply'].'</b><br/><br/>'.$thread_desc.'</td></tr>';
$i++;
}


$tengah .= '</table>';
if ($_SESSION['LevelAkses']=="Administrator") {
$tengah .= '<input type="submit" name="delete" value="Delete" /></form>';	
}
if ($jumlah > $limit) {
$tengah .= '<div  align="center">'.$pembagian->getPaging($jumlah, $pg, $stg).'</div>';
}
break;	
case 'viewtopic':
$forum_id = intval($_GET['forum_id']);

$query = $koneksi_db->sql_query("SELECT `forum_name` FROM `mod_forum` WHERE `id` = '$forum_id'");
$data = $koneksi_db->sql_fetchrow($query);
$name = $data['forum_name'];
$tengah .= '<div  style="font-weight:bold;">Forum : '.$data['forum_name'].'</div>';

$tengah .= '<div style="text-align:right;"><a href="index.php?pilih=forum&amp;modul=yes&amp;action=new&amp;forum_id='.$forum_id.'"><img src="modul/forum/images/new.png" alt="new post" /> Buat Posting</a></div>';
$tengah .= '<table id="forum-diskusi" cellspacing="0" cellpadding="0" style="width:100%">';
$tengah .= '<tr class="head"><td class="depan thread-name-width">Topics</td><td class="thread-thread-width">Author</td><td class="thread-reply-width">Replies</td><td class="thread-view-width">Dilihat</td><td class="thread-lastpost-width">Komentar Terakhir</td></tr>';

$forum_id = intval($_GET['forum_id']);

//---------- paging -------------------
$query1 = $koneksi_db->sql_query ("SELECT count(`id`) AS `total` FROM `mod_forum_t` WHERE `forum_id` = '$forum_id' AND `thread_parent` = 0");
$getdata1 = $koneksi_db->sql_fetchrow($query1);
$jumlah = $getdata1['total'];
$limit = 10;
$pembagian = new paging ($limit);
if (empty($_GET['offset']) and !isset ($_GET['offset'])) {
$offset = 0;
}else {
$offset = int_filter($_GET['offset']);	
}

if (empty($_GET['pg']) and !isset ($_GET['pg'])) {
$pg = 1;
}else {
$pg = int_filter($_GET['pg']);	
}
if (empty($_GET['stg']) and !isset ($_GET['stg'])) {
$stg = 1;
}else {
$stg = int_filter($_GET['stg']);		
}
//---------- paging -------------------

$query = $koneksi_db->sql_query("SELECT * FROM `mod_forum_t` WHERE `forum_id` = '$forum_id' AND `thread_parent` = 0 ORDER BY `id` LIMIT $offset,$limit");
if ($koneksi_db->sql_numrows($query) == 0) {
	$tengah .= '<tr class="isi"><td class="depan thread-name-width">--</td><td class="thread-user-width" style="text-align:center;">--</td><td class="thread-reply-width" style="text-align:center;">--</td><td class="thread-view-width" style="text-align:center;">--</td><td class="thread-lastpost-width" style="text-align:center;">--</td></tr>';
}
$i = 1;
while($data = $koneksi_db->sql_fetchrow($query)) {
	if ($i % 2 == 0) {
	$className = ' forum-zebra-color';
}else {
	$className = '';
}

$thread_parent = $data['id'];

$hitung_threads = $koneksi_db->sql_query("SELECT count(*) AS total FROM `mod_forum_t` WHERE `forum_id` = '$forum_id' AND `thread_parent` = $thread_parent");
$fetch_threads = $koneksi_db->sql_fetchrow($hitung_threads);
$total_reply = $fetch_threads['total'];


$hitung_lastpost = $koneksi_db->sql_query("SELECT MAX(`thread_date`) AS date FROM `mod_forum_t` WHERE `forum_id` = '$forum_id' AND `thread_parent` = $thread_parent");
$fetch_lastpost = $koneksi_db->sql_fetchrow($hitung_lastpost);


$lastpost = cleantext($data['thread_desc']);
$lastdate = datetimes($data['thread_date']);

	$tengah .= '<tr class="isi'.$className.'"><td class="depan thread-name-width"><a href="index.php?pilih=forum&amp;modul=yes&amp;action=viewthread&amp;forum_id='.$forum_id.'&amp;thread_id='.$thread_parent.'">'.$data['thread_name'].'</a></td><td class="thread-user-width" style="text-align:center;">'.$data['thread_user'].'</td><td class="thread-reply-width" style="text-align:center;">'.$total_reply.'</td><td class="thread-view-width" style="text-align:center;">'.$data['thread_view'].'</td><td class="thread-lastpost-width" style="text-align:left;">'.$lastpost.'<br>'.$lastdate.'</td></tr>';
	$i++;
}



$tengah .= '</table>';
if ($jumlah > $limit) {
$tengah .= '<div  align="center">'.$pembagian->getPaging($jumlah, $pg, $stg).'</div>';
}
break;
	
default:
$tengah .= '<table id="forum-diskusi" cellspacing="0" cellpadding="0" style="width:100%">';
$tengah .= '<tr class="head"><td class="depan forum-name-width">Forum Name</td><td class="forum-thread-width">Threads</td><td class="forum-reply-width">Replies</td><td class="forum-lastpost-width">Posting Terakhir</td></tr>';



//---------- paging -------------------
$query1 = $koneksi_db->sql_query ("SELECT count(`id`) AS `total` FROM `mod_forum`");
$getdata1 = $koneksi_db->sql_fetchrow($query1);
$jumlah = $getdata1['total'];
$limit = 10;
$pembagian = new paging ($limit);
if (empty($_GET['offset']) and !isset ($_GET['offset'])) {
$offset = 0;
}else {
$offset = int_filter($_GET['offset']);	
}

if (empty($_GET['pg']) and !isset ($_GET['pg'])) {
$pg = 1;
}else {
$pg = int_filter($_GET['pg']);	
}
if (empty($_GET['stg']) and !isset ($_GET['stg'])) {
$stg = 1;
}else {
$stg = int_filter($_GET['stg']);		
}
//---------- paging -------------------


$query = $koneksi_db->sql_query("SELECT * FROM `mod_forum` LIMIT $offset,$limit");
$i = 1;
while($data = $koneksi_db->sql_fetchrow($query)) {
if ($i % 2 == 0) {
	$className = ' forum-zebra-color';
}else {
	$className = '';
}
$forum_id = $data['id'];

$hitung_threads = $koneksi_db->sql_query("SELECT count(*) AS total FROM `mod_forum_t` WHERE `forum_id` = '$forum_id' AND `thread_parent` = 0");
$fetch_threads = $koneksi_db->sql_fetchrow($hitung_threads);
$total_threads = $fetch_threads['total'];


$hitung_replies = $koneksi_db->sql_query("SELECT count(*) AS total FROM `mod_forum_t` WHERE `forum_id` = '$forum_id'");
$fetch_replies = $koneksi_db->sql_fetchrow($hitung_replies);
$total_replies = $fetch_replies['total'];


$hitung_maxdate = $koneksi_db->sql_query("SELECT MAX(`thread_date`) AS `date`,`thread_user`,`forum_id`,`thread_parent`,`id` FROM `mod_forum_t` WHERE `forum_id` = '$forum_id' GROUP BY `thread_date` DESC LIMIT 1");
$fetch_maxdate = $koneksi_db->sql_fetchrow($hitung_maxdate);
$fetch_maxdate['thread_parent'] = $fetch_maxdate['thread_parent'] == 0 ? $fetch_maxdate['id'] : $fetch_maxdate['thread_parent'];
$fetch_maxdate['date'] = isset($fetch_maxdate['date']) ? $fetch_maxdate['date'] : null;
$maxdate = $fetch_maxdate['date'] ? datetimes($fetch_maxdate['date']).' <br>'.$fetch_maxdate['thread_user'] .' <a href="'.lastpost_forum ($fetch_maxdate['forum_id'], $fetch_maxdate['thread_parent'], $fetch_maxdate['id'],false).'"><img src="modul/forum/images/post2.png" alt="post" /></a>' : '--';

$adminOnly = '';
$forumLock = '';
if ($_SESSION['LevelAkses']=="Administrator") {
$adminOnly = '<a href="index.php?pilih=forum&amp;modul=yes&amp;action=edit_forum&amp;forum_id='.$data['id'].'"><img src="modul/forum/images/comment_edit.png" alt="comment" /></a> <a href="index.php?pilih=forum&amp;modul=yes&amp;action=del_forum&amp;forum_id='.$data['id'].'" onclick="return confirm(\'Semua Data topic,thread akan di hapus \n Lanjutkan ??\')"><img src="modul/forum/images/cross.png" alt="cross" /></a>';	
$forumLock = $data['lock'] == 1 ? '<img src="modul/forum/images/lock.png" alt="lock" />' : '<img src="modul/forum/images/lock_open.png" alt="lock_open.png" />';
}

$tengah .= '<tr class="isi'.$className.'"><td class="depan">'.$forumLock.' <span class="forum-nama"><a href="index.php?pilih=forum&amp;modul=yes&amp;action=viewtopic&amp;forum_id='.$data['id'].'">'.$data['forum_name'].'</a></span> '.$adminOnly.' <br/><span class="forum-desc">'.$data['forum_desc'].'</span></td><td style="text-align:center;">'.$total_threads.'</td><td style="text-align:center;">'.$total_replies.'</td><td style="text-align:left;">'.$maxdate.'</td></tr>';

$i++;
}

$tengah .= '</table>';
if ($jumlah > $limit) {
$tengah .= '<div  align="center">'.$pembagian->getPaging($jumlah, $pg, $stg).'</div>';
}
break;
}

echo $tengah;
?> 