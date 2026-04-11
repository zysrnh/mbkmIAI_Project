<h3 class="garis">Halaman Dinamis</h3>

<?php

if (!defined('cms-ADMINISTRATOR')) {
	Header("Location: ../index.php");
	exit;
}

if (!cek_login ()){
   $admin .='<p class="judul">Akses di hentikan, KLATENWEB.com</p>';
   exit;
}


$index_hal = 1;


$admin .='<div class=""><a href="admin.php?pilih=admin_pages"><b>Home</b></a> | <a href="admin.php?pilih=admin_pages&amp;aksi=add"><b>Buat Halaman</b></a></div>';

$admin .= "\n";


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






switch(@$_GET['aksi']) {
case 'del':
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 1) {
$id = int_filter($_GET['id']);	
$query = $koneksi_db->sql_query("DELETE FROM `halaman` WHERE `id` = '$id'");
header("location:admin.php?pilih=admin_pages");
exit;
}

break;
case 'edit':
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
$id = int_filter($_GET['id']);	


if (isset($_POST['submit'])) {
$judul = cleantext($_POST['judul']);
$konten = $_POST['konten'];

$query = $koneksi_db->sql_query("UPDATE `halaman` SET `judul` = '$judul', `konten` = '$konten' WHERE `id` = '$id'");	
header("location:admin.php?pilih=admin_pages");
exit;
}

$query = $koneksi_db->sql_query("SELECT * FROM `halaman` WHERE `id` = '$id'");	
$data = mysqli_fetch_assoc($query);

$script_include[] = $JS_SCRIPT;

$admin .= '<form method="post" action="">';
$admin .= 'Title : <br />';
$admin .= '<input type="text" name="judul" value="'.stripslashes(htmlspecialchars($data['judul'])).'" size="50" /><br />';
$admin .= 'Content : <br />';
$admin .= '<textarea id="elm1" name="konten" rows="15" cols="80" style="width: 100%">';
$admin .= htmlspecialchars($data['konten']);
$admin .= '</textarea>';

$admin .= '<input type="submit" class="button color big round" name="submit" value="Edit" />';
$admin .= '</form>';

}
break;	
case 'add':
if (isset($_POST['submit'])) {
$judul = cleantext($_POST['judul']);
$konten = $_POST['konten'];

$error = '';

if (empty($judul)) {
	$error .= '- Error: Title cannot empty.<br />';
}

	if ($error != '') {
	 $admin .= '<div class="error">'.$error.'</div>';
	} else {

	$query = $koneksi_db->sql_query("INSERT INTO `halaman` (`judul`,`konten`) VALUES ('$judul','$konten')");	
		if ($query) {
		$admin .= '<div class="sukses">DAata berhasil dimasukkan.</div>';
			} 
			else {
				$admin .= '<div class="error">'.mysqli_error().'</div>';
			}

}

}
$script_include[] = $JS_SCRIPT;

$admin .= '<form method="post" action="">';
$admin .= 'Title : <br />';
$admin .= '<input type="text" name="judul" value="'.stripslashes(htmlspecialchars(@$_POST['judul'])).'" size="50" /><br />';
$admin .= 'Content : <br />';
$admin .= '<textarea id="elm1" name="konten" rows="15" cols="80" style="width: 100%">';
$admin .= htmlspecialchars(@$_POST['konten']);
$admin .= '</textarea>';

$admin .= '<input type="submit" class="button color big round" name="submit" value="Add" />';
$admin .= '</form>';

break;	




default:
$warna = '';
$query = $koneksi_db->sql_query("SELECT `id`,`judul` FROM halaman ORDER BY id");
$admin .='<table style="width:100%" cellspacing="1" cellpadding="0">';
while($data = mysqli_fetch_assoc($query)) {
$warna = empty ($warna) ? 'bgcolor="#efefef"' : '';
		
		
			$urlkat=str_replace(" ", "-", $data['judul']);
		$admin .='<tr '.$warna.'><td><a href="pages/'.$data['id'].'/'.$urlkat.'.html" title="'.$data['judul'].'">'.limittxt($data['judul'],40).'</a></td>';
		$admin .='<td>';
		if ($data['id'] == 1){
		$deleted = '';	
	
		
		
		
		}else {
		$deleted = '<a href="admin.php?pilih=admin_pages&amp;aksi=del&amp;id='.$data['id'].'" onclick="return confirm(\'Do You Want to Delete Data It ?\')" style="color:red">Delete</a> - ';		
		}
		
		
        $admin .=''.$deleted.'<a href="admin.php?pilih=admin_pages&amp;aksi=edit&amp;id='.$data['id'].'">Edit</a> - <a href="admin.php?pilih=admin_menu&amp;aksi=addsub&amp;url=pages/'.$data['id'].'/'.$urlkat.'.html">Make Menu</a></td></tr>';

		
}

$admin .= '</table>';
break;
}

echo $admin;
?>