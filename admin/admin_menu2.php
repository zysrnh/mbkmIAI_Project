<h3 class="garis">Footer Menu</h3>

<?php



if (!defined('cms-ADMINISTRATOR')) {
	Header("Location: ../index.php");
	exit;
}
$index_hal = 1;
$admin = '';
if (!cek_login ()){   
	
$admin .='<p class="judul">Access Denied !!!!!!</p>';
}else{
	


$admin .='<div class="border"><a href="admin.php?pilih=admin_menu2"><b>Home</b></a> | <a href="admin.php?pilih=admin_menu2&amp;aksi=addsub"><b>Buat Sub Menu Baru</b></a></div>';


if($_GET['aksi']=="up"){

$ID = int_filter ($_GET['id']);
$parent = int_filter ($_GET['parent']);
$select = $koneksi_db->sql_query ("SELECT MAX(ordering) as sc FROM submenu2 WHERE parent='$parent'");
$data = $koneksi_db->sql_fetchrow ($select);

if ($data['sc'] <= 0){
$qquery = $koneksi_db->sql_query ("SELECT `id` FROM `submenu2` WHERE parent='$parent'");
$integer = 1;
while ($getsql = mysql_fetch_assoc($qquery)){
$koneksi_db->sql_query ("UPDATE `submenu2` SET `ordering` = $integer WHERE `id` = '".$getsql['id']."'");
$integer++;	
}	
header ("location:admin.php?pilih=admin_menu2");
exit;	
}

$total = $data['sc'] + 1;
$update = $koneksi_db->sql_query ("UPDATE submenu2 SET ordering='$total' WHERE ordering='".($ID-1)."' AND parent='$parent'"); 
$update = $koneksi_db->sql_query ("UPDATE submenu2 SET ordering=ordering-1 WHERE ordering='$ID' AND parent='$parent'");
$update = $koneksi_db->sql_query ("UPDATE submenu2 SET ordering='$ID' WHERE ordering='$total' AND parent='$parent'");   
header ("location:admin.php?pilih=admin_menu2");
}

if($_GET['aksi']=="down"){
$ID = int_filter ($_GET['id']);
$parent = int_filter ($_GET['parent']);
$select = $koneksi_db->sql_query ("SELECT MAX(ordering) as sc FROM submenu2 WHERE parent='$parent'");
$data = $koneksi_db->sql_fetchrow ($select);

if ($data['sc'] <= 0){
$qquery = $koneksi_db->sql_query ("SELECT `id` FROM `submenu2` WHERE parent='$parent'");
$integer = 1;
while ($getsql = mysql_fetch_assoc($qquery)){
$koneksi_db->sql_query ("UPDATE `submenu2` SET `ordering` = $integer WHERE `id` = '".$getsql['id']."'");
$integer++;	
}	
	
header ("location:admin.php?pilih=admin_menu2");
exit;	
}

$total = $data['sc'] + 1;
$update = $koneksi_db->sql_query ("UPDATE submenu2 SET ordering='$total' WHERE ordering='".($ID+1)."' AND parent='$parent'"); 
$update = $koneksi_db->sql_query ("UPDATE submenu2 SET ordering=ordering+1 WHERE ordering='$ID' AND parent='$parent'");
$update = $koneksi_db->sql_query ("UPDATE submenu2 SET ordering='$ID' WHERE ordering='$total' AND parent='$parent'");

header ("location:admin.php?pilih=admin_menu2");
}




if($_GET['aksi']=="mup"){

$ID = int_filter ($_GET['id']);
$select = $koneksi_db->sql_query ("SELECT MAX(ordering) as sc FROM menu2");
$data = $koneksi_db->sql_fetchrow ($select);

if ($data['sc'] <= 0){
$qquery = $koneksi_db->sql_query ("SELECT `id` FROM `submenu2`");
$integer = 1;
while ($getsql = mysql_fetch_assoc($qquery)){
$koneksi_db->sql_query ("UPDATE `menu2` SET `ordering` = $integer WHERE `id` = '".$getsql['id']."'");
$integer++;	
}	
	
header ("location:admin.php?pilih=admin_menu2");
exit;	
}

$total = $data['sc'] + 1;
$update = $koneksi_db->sql_query ("UPDATE menu2 SET ordering='$total' WHERE ordering='".($ID-1)."'"); 
$update = $koneksi_db->sql_query ("UPDATE menu2 SET ordering=ordering-1 WHERE ordering='$ID'");
$update = $koneksi_db->sql_query ("UPDATE menu2 SET ordering='$ID' WHERE ordering='$total'");   
header ("location:admin.php?pilih=admin_menu2");
}

if($_GET['aksi']=="mdown"){
$ID = int_filter ($_GET['id']);
$select = $koneksi_db->sql_query ("SELECT MAX(ordering) as sc FROM menu2");
$data = $koneksi_db->sql_fetchrow ($select);

if ($data['sc'] <= 0){
$qquery = $koneksi_db->sql_query ("SELECT `id` FROM `menu2`");
$integer = 1;
while ($getsql = mysql_fetch_assoc($qquery)){
$koneksi_db->sql_query ("UPDATE `menu2` SET `ordering` = $integer WHERE `id` = '".$getsql['id']."'");
$integer++;	
}	
	
header ("location:admin.php?pilih=admin_menu2");
exit;	
}

$total = $data['sc'] + 1;
$update = $koneksi_db->sql_query ("UPDATE menu2 SET ordering='$total' WHERE ordering='".($ID+1)."'"); 
$update = $koneksi_db->sql_query ("UPDATE menu2 SET ordering=ordering+1 WHERE ordering='$ID'");
$update = $koneksi_db->sql_query ("UPDATE menu2 SET ordering='$ID' WHERE ordering='$total'");

header ("location:admin.php?pilih=admin_menu2");
}





if($_GET['aksi']==""){
	
$hasil = $koneksi_db->sql_query( "SELECT * FROM menu2 ORDER BY ordering" );

$querymax = $koneksi_db->sql_query ("SELECT MAX(`ordering`) FROM `menu2`");
$alhasil = $koneksi_db->sql_fetchrow($querymax);	
$numbers_parent = $alhasil[0];

$admin .='
<table cellspacing="0" style="width:100%">
	<tr bgcolor="#d1d1d1">
	<th style="width:25px;text-align:center;padding:10px 5px 10px 5px;border-left:1px solid #ccc;border-top:1px solid #ccc;">No</th>
	<th style="text-align:left;padding:10px 5px 10px 5px;border-top:1px solid #ccc;border-left:1px solid #ccc;">Menu Item</th>
	<th style="text-align:center;padding:10px 5px 10px 5px;border-top:1px solid #ccc;border-left:1px solid #ccc;">Order</th>
	<th style="text-align:center;padding:10px 5px 10px 5px;border-top:1px solid #ccc;border-left:1px solid #ccc;">Publikasi</th>
	<th colspan="2" style="text-align:center;padding:10px 5px 10px0 5px;border-right:1px solid #ccc;border-top:1px solid #ccc;border-left:1px solid #ccc;width:160px;">Aksi</th>
	</tr>';
$no = 1;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
	$parent=$data[0];
	$published = ($data['published'] == 1) ? '<a href="admin.php?pilih=admin_menu2&amp;aksi=pub&amp;pub=tidak&amp;id='.$parent.'"><img src="images/tick.gif" border="0" alt="ya" /></a>' : '<a href="admin.php?pilih=admin_menu2&amp;aksi=pub&amp;pub=ya&amp;id='.$parent.'"><img src="images/tidak.png" border="0" alt="no" /></a>';
	
$orderd = '<a href="admin.php?pilih=admin_menu2&amp;aksi=mdown&amp;id='.$data[4].'"><img src="images/downarrow-1.png" border="0" alt="down" /></a>';    
$orderu = '<a href="admin.php?pilih=admin_menu2&amp;aksi=mup&amp;id='.$data[4].'"><img src="images/uparrow-1.png" border="0" alt="up" /></a>'; 

   
$ordering_down = $orderd;    
$ordering_up = $orderu;        

if ($data[4] == 1) $ordering_up = '&nbsp;&nbsp;&nbsp;';
if ($data[4] == $numbers_parent) $ordering_down = '&nbsp;';		

$admin .='
	<tr>
	<td style="width:25px;text-align:center;padding:2px;border-left:1px solid #ccc;border-top:1px solid #ccc;"><b>'.$no.'</b></td>
	<td style="text-align:left;padding:2px;border-top:1px solid #ccc;border-left:1px solid #ccc;"><a href="'.$data['url'].'"><b>'.$data['menu2'].'</b></a></td>
	<td style="text-align:center;padding:2px;border-top:1px solid #ccc;border-left:1px solid #ccc;">'.$ordering_up.'  '.$ordering_down.'</td>
	<td style="text-align:center;padding:2px;border-top:1px solid #ccc;border-left:1px solid #ccc;">'.$published.'</td>
	<td style="text-align:center;padding:2px;border-top:1px solid #ccc;border-left:1px solid #ccc;width:30px;"></td>
	<td style="text-align:center;padding:2px;border-right:1px solid #ccc;border-top:1px solid #ccc;border-left:1px solid #ccc;width:30px;"><a href="admin.php?pilih=admin_menu2&amp;aksi=edit&amp;id='.$data[0].'"><img border="0" src="images/edit.gif" width="24" height="15" alt="edit" /></a></td>
	</tr>';


$subhasil = $koneksi_db->sql_query( "SELECT * FROM submenu2 WHERE parent='$parent' ORDER BY ordering ");		
$jmlsub = $koneksi_db->sql_numrows( $subhasil );	
$querymax = $koneksi_db->sql_query ("SELECT MAX(`ordering`) FROM `submenu2` WHERE parent=$parent");
$alhasil = $koneksi_db->sql_fetchrow($querymax);	
$numbers = $alhasil[0];
if ($jmlsub>0) {
$warna = '';		
$i = 1;
while ($subdata = $koneksi_db->sql_fetchrow($subhasil)) {            
$spublished = ($subdata['published'] == 1) ? '<a href="admin.php?pilih=admin_menu2&amp;aksi=spub&amp;pub=tidak&amp;id='.$subdata[0].'"><img src="images/tick.gif" border="0" alt="ya" /></a>' : '<a href="admin.php?pilih=admin_menu2&amp;aksi=spub&amp;pub=ya&amp;id='.$subdata[0].'"><img src="images/tidak.png" border="0" alt="no" /></a>';
$orderd = '<a href="admin.php?pilih=admin_menu2&amp;aksi=down&amp;id='.$subdata[5].'&amp;parent='.$parent.'"><img src="images/downarrow.png" border="0" alt="down" /></a>';    
$orderu = '<a href="admin.php?pilih=admin_menu2&amp;aksi=up&amp;id='.$subdata[5].'&amp;parent='.$parent.'"><img src="images/uparrow.png" border="0" alt="up" /></a>'; 
$ordering_down = $orderd;    
$ordering_up = $orderu;        

if ($subdata[5] == 1) $ordering_up = '';
if ($subdata[5] == $numbers) $ordering_down = '';			
						
$warna = empty ($warna) ? ' bgcolor="#efefef"' : '';

$admin .='
	<tr>
	<td style="width:25px;text-align:center;padding:2px;border-left:1px solid #ccc;border-top:1px solid #ccc;"></td>
	<td style="text-align:left;padding:2px;border-top:1px solid #ccc;border-left:1px solid #ccc;"><a href="'.$subdata['url'].'">'.$subdata['menu2'].'</a></td>
	<td style="text-align:center;padding:2px;border-top:1px solid #ccc;border-left:1px solid #ccc;">'.$ordering_up.'  '.$ordering_down.'</td>
	<td style="text-align:center;padding:2px;border-top:1px solid #ccc;border-left:1px solid #ccc;">'.$spublished.'</td>
	<td style="text-align:center;padding:2px;border-top:1px solid #ccc;border-left:1px solid #ccc;width:30px;"><a href="admin.php?pilih=admin_menu2&amp;aksi=delsub&amp;id='.$subdata['id'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><img border="0" src="images/delete_button.gif" width="22" height="15" alt="del" /></td>
	<td style="text-align:center;padding:2px;border-right:1px solid #ccc;border-top:1px solid #ccc;border-left:1px solid #ccc;width:30px;"><a href="admin.php?pilih=admin_menu2&amp;aksi=editsub&amp;id='.$subdata[0].'"><img border="0" src="images/edit.gif" width="24" height="15" alt="edit" /></a></td>
	</tr>';
$i++;		
}		
}
unset($numbers);
$no++;
}
$admin .= '<tr><td colspan="6" style="width:25px;text-align:center;padding:5px;border-top:1px solid #ccc;">&nbsp;</td></tr></table>';
}

if($_GET['aksi']=="add"){
	global $koneksi_db, $theme,$error;
	
if (isset($_POST['submit'])) {
	$menu2     = $_POST['menu2'];
	$url      = $_POST['url'];
	$error = '';
	if (!$menu2)  $error .= "Error: Silahkan Masukkan Nama Menunya!<br />";
	if (!$url) $error .= "Error: Silahkan Masukkan Url Menunya!<br />";
	if ($error){
		$admin.='<div class="error">'.$error.'</div>';
	}else {
	
	$cekmax = $koneksi_db->sql_query ("SELECT (MAX(`ordering`)+1) FROM `menu2`");
	$getcekmax = $koneksi_db->sql_fetchrow($cekmax);
	$hasil = $koneksi_db->sql_query( "INSERT INTO menu2 (menu2,url,ordering) VALUES ('$menu2','$url','".$getcekmax[0]."')" );
	if($hasil){
		$admin.='<div class="sukses">Menu Baru Berhasil dibuat</div>';
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=admin_menu2" />';
		}		
	}
}
	
	
$url = isset($_POST['submit']) ? $_POST['url'] : @$_GET['url'];
	
$admin .='<div class="border">';	
$admin .='<form method="post" action="">    
<table>        
<tr>            
<td>Menu</td>            
<td>:</td>            
<td><input type="text" size="30" name="menu2" /></td>        
</tr>        
<tr>            
<td>URL</td>            
<td>:</td>            
<td><input type="text" size="30" name="url" value="'.$url.'" /></td>        
</tr>        
<tr>            
<td></td><td></td><td colspan="2"><input type="submit" name="submit" value="Buat" /></td>        
</tr>    
</table></form>';
$admin .='</div>';

}

if($_GET['aksi']=="addsub"){
	global $koneksi_db, $theme;
	
if (isset($_POST['submit'])) {
	$menu2     = $_POST['menu2'];
	$url      = $_POST['url'];
	$parent1  = $_POST['parent1'];
	$error = '';
	if (!$menu2)  $error .= "Error: Silahkan Masukkan Nama Menunya!<br />";
	if (!$url) $error .= "Error: Silahkan Masukkan Url Menunya!<br />";
	if ($error){
		$admin.='<div class="error">'.$error.'</div>';
	}else {
		
	$cekmax = $koneksi_db->sql_query ("SELECT (MAX(`ordering`)+1) FROM `submenu2` WHERE `parent` = '$parent1'");
	$cekmaxnum = $koneksi_db->sql_fetchrow($cekmax);
	$hasil = $koneksi_db->sql_query( "INSERT INTO submenu2 (menu2,url,parent,ordering) VALUES ('$menu2','$url','$parent1','".$cekmaxnum[0]."')" );
	if($hasil){
		$admin.='<div class="sukses">Sub Menu baru telah dibuat.</div>';
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=admin_menu2" />';
	}		
	}
}
$url = isset($_POST['submit']) ? $_POST['url'] : @$_GET['url'];

$admin .='<div class="border">';
$admin .='<form method="post" action="">    
<table>        
<tr>            
<td>Menu</td>            
<td>:</td>            
<td><input type="text" size="30" name="menu2" /></td>        
</tr>        
<tr>            
<td>URL</td><td>:</td><td><input type="text" size="30" name="url" value="'.$url.'" /></td>        
</tr>        
<tr>            
<td>Sub dari</td>            
<td>:</td>            
<td>';            

$hasil = $koneksi_db->sql_query( "SELECT * FROM menu2 ORDER BY id" );            

$admin .='<select name="parent1">';            
while ($data = $koneksi_db->sql_fetchrow($hasil)) {       	
	$admin .='<option value="'.$data[0].'">'.$data[1].'</option>';            
}

$admin .='</select>';
$admin .='        
</td>        
</tr>        
<tr>            
<td></td><td></td><td colspan="2"><input type="submit" name="submit" value="Buat" /></td>        
</tr>    
</table></form>';
$admin .='</div>';
}

if($_GET['aksi']=="del"){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	
	$hasil = $koneksi_db->sql_query("DELETE FROM menu2 WHERE id='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Menu telah di delete! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="3; url=admin.php?pilih=admin_menu2" />';    
	}
}

if($_GET['aksi']=="delsub"){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM submenu2 WHERE id='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Sub Menu telah di delete! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="3; url=admin.php?pilih=admin_menu2" />';    
	}
}

if($_GET['aksi']=="edit"){
	global $koneksi_db,$error;
	$id     = int_filter($_GET['id']);
	
if (isset($_POST['submit'])) {
	$menu2     = $_POST['menu2'];
	$url      = $_POST['url'];
	
	if (!$menu2)  $error .= "Error: Silahkan Masukkan Nama Menunya!<br />";
	if (!$url) $error .= "Error: Silahkan Masukkan Url Menunya!<br />";
	
	if ($error){
		$admin.='<div class="error>'.$error.'</div>';
	}else{
		
	
	
	$hasil = $koneksi_db->sql_query( "UPDATE menu2 SET menu2='$menu2', url='$url' WHERE id='$id'" );
	if($hasil){
		$admin.='<div class="sukses">Menu telah di updated</div>';
		$style_include[] ='<meta http-equiv="refresh" content="3; url=admin.php?pilih=admin_menu2">';
	}
       }
}else{
	$hasil = $koneksi_db->sql_query( "SELECT * FROM menu2 WHERE id=$id" );
	while ($data = $koneksi_db->sql_fetchrow($hasil)) {    
		
		$id=$data[0];    
		$menu2=$data[1];    
		$url=$data[2];    
	}
$admin .='<table width="100%" border="0" cellspacing="0" cellpadding="0" class="middle"><tr><td><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bodyline"><tr><td class="bgcolor1">';
$admin .='<b>Edit Menu Item</b><form method="post" action="">    
<table>        
<tr>            
<td>Menu</td>            
<td>:</td>            
<td><input type="hidden" name="id" value="'.$id.'"><input type="text" size="30" name="menu2" value="'.$menu2.'"></td>        
</tr>        
<tr>            
<td>URL</td>            
<td>:</td>            
<td><input type="text" size="30" name="url" value="'.$url.'"></td>        
</tr>        
<tr>            
<td></td><td></td><td colspan="2"><input type="submit" name="submit" value="Update"></td>        
</tr>    
</table></form>';
$admin .='</td></tr></table></td></tr></table>';

}
}

if($_GET['aksi']=="editsub"){
	global $koneksi_db,$error;
	$id     = int_filter($_GET['id']);
	
if (isset($_POST['submit'])) {
	$menu2     = $_POST['menu2'];
	$url      = $_POST['url'];
	$parent1   = $_POST['parent1'];
	
if (!$menu2)  $error .= "Error: Silahkan Masukkan Nama Menunya!<br />";
if (!$url) $error .= "Error: Silahkan Masukkan Url Menunya!<br />";
if (!$parent1) $error .= "Error: Silahkan Pilih Parent untuk  Sub Menunya!<br />";
if ($error){
	$admin.='<div class="error">'.$error.'</div>';
}else{

$hasil = $koneksi_db->sql_query( "UPDATE submenu2 SET menu2='$menu2', url='$url', parent='$parent1' WHERE id='$id'");
if($hasil){
	$admin.='<div class="sukses">Sub Menu telah di updated</div>';
	$style_include[] ='<meta http-equiv="refresh" content="3; url=admin.php?pilih=admin_menu2" />';
}
}
}else{

	$hasil = $koneksi_db->sql_query( "SELECT * FROM submenu2 WHERE id=$id" );
	while ($data = $koneksi_db->sql_fetchrow($hasil)) {    
		$id=$data[0];    
		$menu2=$data[1];    
		$url=$data[2];    
		$parent=$data[3];
	}

$admin .='<table width="100%" border="0" cellspacing="0" cellpadding="0" class="middle"><tr><td><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bodyline"><tr><td class="bgcolor1">';
$admin .='<b>Edit Menu Item</b>';
$admin .='<form method="post" action="" >    
<table>        
<tr>            
<td>Menu</td>            
<td>:</td>            
<td><input type="hidden" name="id" value="'.$id.'"><input type="text" size="30" name="menu2" value="'.$menu2.'"></td>        
</tr>        
<tr>            
<td>URL</td>            
<td>:</td>            
<td><input type="text" size="30" name="url" value="'.$url.'"></td>        
</tr>        
<tr>            
<td>Sub dari</td>            
<td>:</td>            
<td><select name="parent1">';
$hasil = $koneksi_db->sql_query( "SELECT * FROM menu2 ORDER BY id" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
	$pilihan = ($data[0]==$parent)?"selected":'';
	$admin .='<option value="'.$data['0'].'" '.$pilihan.'>'.$data[1].'</option>';
}

$admin .='</select>        
</td>        
</tr>        
<tr>            
<td></td><td></td><td colspan="2"><input type="submit" name="submit" value="Update"></td>        
</tr>    
</table></form> ';
$admin .='</td></tr></table></td></tr></table>';


}
}

if ($_GET['aksi'] == 'pub'){	
	if ($_GET['pub'] == 'tidak'){	
		$id = int_filter ($_GET['id']);	
		$koneksi_db->sql_query ("UPDATE menu2 SET published=0 WHERE id='$id'");		
	}	
	
	if ($_GET['pub'] == 'ya'){	
		$id = int_filter ($_GET['id']);	
		$koneksi_db->sql_query ("UPDATE menu2 SET published=1 WHERE id='$id'");		
	}	
	header ("location:admin.php?pilih=admin_menu2");
	exit;
}

if ($_GET['aksi'] == 'spub'){	
	if ($_GET['pub'] == 'tidak'){	
		$id = int_filter ($_GET['id']);	
		$koneksi_db->sql_query ("UPDATE submenu2 SET published=0 WHERE id='$id'");		
	}	
	if ($_GET['pub'] == 'ya'){	
		$id = int_filter ($_GET['id']);	
		$koneksi_db->sql_query ("UPDATE submenu2 SET published=1 WHERE id='$id'");		
	}	
	header ("location:admin.php?pilih=admin_menu2");
	exit;
}
}

if($_GET['aksi']== 'delma'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `admin` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Menu Admin berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=admin_menu2&aksi=menu2admin" />';    
	}
}

if($_GET['aksi']== 'delmu'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `menu2_users` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Menu User berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=admin_menu2&aksi=menu2user" />';    
	}
}

if($_GET['aksi'] == 'menu2admin'){
$tengah = '';
if($_GET['op']== 'up'){

$ID = int_filter ($_GET['id']);
$select = $koneksi_db->sql_query ("SELECT MAX(ordering) as sc FROM admin");
$data = $koneksi_db->sql_fetchrow ($select);
$total = $data['sc'] + 1;
$update = $koneksi_db->sql_query ("UPDATE admin SET ordering='$total' WHERE ordering='".($ID-1)."'"); 
$update = $koneksi_db->sql_query ("UPDATE admin SET ordering=ordering-1 WHERE ordering='$ID'");
$update = $koneksi_db->sql_query ("UPDATE admin SET ordering='$ID' WHERE ordering='$total'");   
header ("location:admin.php?pilih=admin_menu2&aksi=menu2admin");
}

if($_GET['op']== 'down'){
$ID = int_filter ($_GET['id']);
$select = $koneksi_db->sql_query ("SELECT MAX(ordering) as sc FROM admin");
$data = $koneksi_db->sql_fetchrow ($select);
$total = $data['sc'] + 1;
$update = $koneksi_db->sql_query ("UPDATE admin SET ordering='$total' WHERE ordering='".($ID+1)."'"); 
$update = $koneksi_db->sql_query ("UPDATE admin SET ordering=ordering+1 WHERE ordering='$ID'");
$update = $koneksi_db->sql_query ("UPDATE admin SET ordering='$ID' WHERE ordering='$total'");    
header ("location:admin.php?pilih=admin_menu2&aksi=menu2admin");
}
if(isset($_POST['submit'])){
	$menu2 		= $_POST['menu2'];
	$url 		= $_POST['url'];
	$modul		= $_POST['modul'];
	$ceks 		= $koneksi_db->sql_query ("SELECT MAX(ordering) as ordering FROM admin");
    $hasil 		= $koneksi_db->sql_fetchrow ($ceks);
    $ordering 	= $hasil['ordering'] + 1;
	$error 	= '';
	if (!$menu2)  	$error .= "Error: Silahkan Isi Nama Menunya<br />";
	if (!$url)   	$error .= "Error: Silahkan Isi Urlnya<br />";
	if ($error){
		$tengah .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = $koneksi_db->sql_query( "INSERT INTO `admin` (`menu2` ,`url` ,`modul` ,`ordering`) VALUES ('$menu2','$url','$modul','$ordering')" );
		if($hasil){
			$tengah .= '<div class="sukses"><b>Menu Berhasil di Buat.</b></div>';
		}else{
			$tengah .= '<div class="error"><b>Menu Gagal di Buat.</b></div>';
		}
		unset($menu2);
		unset($url);
	}

}
$menu2     		= !isset($menu2) ? '' : $menu2;
$url     		= !isset($url) ? '' : $url;

$tengah .= '
<div class="border">
<form method="post" action="">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">Nama Menu</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">:</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0"><input type="text" name="menu2" value="'.$menu2.'" size="25"></td>
	</tr>
	<tr>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">URL</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">:</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0"><input type="text" name="url" value="'.$url.'" size="25"></td>
	</tr>
	<tr>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">Status modulul</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">:</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0"><select name="modul"><option value="0">Tidak</option><option value="1">Ya</option></select></td>
	</tr>
	<tr>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0"></td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0"></td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">
		<input type="submit" value="Submit" name="submit"></td>
	</tr>
</table>
</form>
</div>';
$tengah .= '
<table cellspacing="0" style="width:100%">
	<tr bgcolor="#c0c0c0">
	<th style="width:25px;text-align:center;padding:10px 5px 10px 5px;border-left:1px solid #ccc;border-top:1px solid #ccc;">No</th>
	<th style="text-align:left;padding:10px 5px 10px 5px;border-top:1px solid #ccc;border-left:1px solid #ccc;">Nama Menu</th>
	<th style="text-align:center;padding:10px 5px 10px 5px;border-top:1px solid #ccc;border-left:1px solid #ccc;">Ordering</th>
	<th style="text-align:center;padding:10px 5px 10px 5px;border-right:1px solid #ccc;border-top:1px solid #ccc;border-left:1px solid #ccc;">Aksi</th>
	</tr>';

$no =1;
$query 		= $koneksi_db->sql_query ("SELECT * FROM `admin` ORDER BY `ordering` ASC");
$cekmax 	= $koneksi_db->sql_query ("SELECT MAX(`ordering`) FROM `admin`");
$datacekmax = $koneksi_db->sql_fetchrow($cekmax);
$numbers 	= $datacekmax[0];
while($data = $koneksi_db->sql_fetchrow($query)) {
$orderd = '<a class="image" href="admin.php?pilih=admin_menu2&amp;aksi=menu2admin&amp;op=down&amp;id='.$data['ordering'].'"><img src="images/downarrow.png" border="0" alt="down" /></a>';    
$orderu = '<a class="image" href="admin.php?pilih=admin_menu2&amp;aksi=menu2admin&amp;op=up&amp;id='.$data['ordering'].'"><img src="images/uparrow.png" border="0" alt="up" /></a>';    
$ordering_down = $orderd;    
$ordering_up = $orderu;        

if ($data['ordering'] == 1) $ordering_up = '&nbsp;&nbsp;&nbsp;';
if ($data['ordering'] == $numbers) $ordering_down = '&nbsp;';

$warna = empty ($warna) ? 'bgcolor="#efefef"' : '';
$tengah .= '
	<tr '.$warna.'>
	<td style="width:25px;text-align:center;padding:2px;border-left:1px solid #ccc;border-top:1px solid #ccc;">'.$no.'</td>
	<td style="text-align:left;padding:2px;border-top:1px solid #ccc;border-left:1px solid #ccc;">'.$data['menu2'].'</td>
	<td style="text-align:center;padding:2px;border-top:1px solid #ccc;border-left:1px solid #ccc;">'.$ordering_up.'  '.$ordering_down.'</td>
	<td style="text-align:center;padding:10px 5px 10px0 5px;border-right:1px solid #ccc;border-top:1px solid #ccc;border-left:1px solid #ccc;"><a href="admin.php?pilih=admin_menu2&amp;aksi=delma&amp;id='.$data['id'].'">Hapus</a> | <a href="admin.php?pilih=admin_menu2&amp;aksi=editma&amp;id='.$data['id'].'">Edit</a></td>
	</tr>';
$no++;		
}	
$tengah .= '<tr><td colspan="4" style="width:25px;text-align:center;padding:5px;border-top:1px solid #ccc;">&nbsp;</td></tr></table>';
$admin .= $tengah;
}

if($_GET['aksi'] == 'editma'){
$id = int_filter ($_GET['id']);
$tengah = '';
if(isset($_POST['submit'])){
	$menu2 		= $_POST['menu2'];
	$url 		= $_POST['url'];
	$modul		= $_POST['modul'];

	$error 	= '';
	if (!$menu2)  	$error .= "Error: Silahkan Isi Nama Menunya<br />";
	if (!$url)   	$error .= "Error: Silahkan Isi Urlnya<br />";
	if ($error){
		$tengah .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = $koneksi_db->sql_query( "UPDATE `admin` SET `menu2`='$menu2' ,`url`='$url' ,`modul`='$modul' WHERE `id`='$id'" );
		if($hasil){
			$tengah .= '<div class="sukses"><b>Menu Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=admin_menu2&aksi=menu2admin" />';	
		}else{
			$tengah .= '<div class="error"><b>Menu Gagal di Update.</b></div>';
		}
	}

}
$query 		= $koneksi_db->sql_query ("SELECT * FROM `admin` WHERE `id`='$id'");
$data 		= $koneksi_db->sql_fetchrow($query);
$cekmodul		= $data['modul'];
$tengah .= '
<div class="border">
<form method="post" action="">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">Nama Menu</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">:</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0"><input type="text" name="menu2" value="'.$data['menu2'].'" size="25"></td>
	</tr>
	<tr>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">URL</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">:</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0"><input type="text" name="url" value="'.$data['url'].'" size="25"></td>
	</tr>
	<tr>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">Status modulul</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">:</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0"><select name="modul">';
if($cekmodul == 1){
	$tengah .= '<option value="0">Tidak</option><option value="1" selected>Ya</option>';
}else{
	$tengah .= '<option value="0" selected>Tidak</option><option value="1">Ya</option>';
}
$tengah .= '
		</select></td>
	</tr>
	<tr>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0"></td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0"></td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">
		<input type="submit" value="Submit" name="submit"></td>
	</tr>
</table>
</form>
</div>';	
$admin .= $tengah;
}

if($_GET['aksi'] == 'editmu'){
$id = int_filter ($_GET['id']);
$tengah = '';
if(isset($_POST['submit'])){
	$menu2 		= $_POST['menu2'];
	$url 		= $_POST['url'];

	$error 	= '';
	if (!$menu2)  	$error .= "Error: Silahkan Isi Nama Menunya<br />";
	if (!$url)   	$error .= "Error: Silahkan Isi Urlnya<br />";
	if ($error){
		$tengah .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = $koneksi_db->sql_query( "UPDATE `menu2_users` SET `menu2`='$menu2' ,`url`='$url' WHERE `id`='$id'" );
		if($hasil){
			$tengah .= '<div class="sukses"><b>Menu Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=admin_menu2&aksi=menu2user" />';	
		}else{
			$tengah .= '<div class="error"><b>Menu Gagal di Update.</b></div>';
		}
	}

}
$query 		= $koneksi_db->sql_query ("SELECT * FROM `menu2_users` WHERE `id`='$id'");
$data 		= $koneksi_db->sql_fetchrow($query);

$tengah .= '
<div class="border">
<form method="post" action="">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">Nama Menu</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">:</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0"><input type="text" name="menu2" value="'.$data['menu2'].'" size="25"></td>
	</tr>
	<tr>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">URL</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">:</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0"><input type="text" name="url" value="'.$data['url'].'" size="25"></td>
	</tr>
	<tr>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0"></td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0"></td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">
		<input type="submit" value="Submit" name="submit"></td>
	</tr>
</table>
</form>
</div>';	
$admin .= $tengah;
}

if($_GET['aksi'] == 'menu2user'){
	
$tengah = '';
if($_GET['op']== 'up'){

$ID = int_filter ($_GET['id']);
$select = $koneksi_db->sql_query ("SELECT MAX(ordering) as sc FROM menu2_users");
$data = $koneksi_db->sql_fetchrow ($select);
$total = $data['sc'] + 1;
$update = $koneksi_db->sql_query ("UPDATE menu2_users SET ordering='$total' WHERE ordering='".($ID-1)."'"); 
$update = $koneksi_db->sql_query ("UPDATE menu2_users SET ordering=ordering-1 WHERE ordering='$ID'");
$update = $koneksi_db->sql_query ("UPDATE menu2_users SET ordering='$ID' WHERE ordering='$total'");   
header ("location:admin.php?pilih=admin_menu2&aksi=menu2user");
}

if($_GET['op']== 'down'){
$ID = int_filter ($_GET['id']);
$select = $koneksi_db->sql_query ("SELECT MAX(ordering) as sc FROM menu2_users");
$data = $koneksi_db->sql_fetchrow ($select);
$total = $data['sc'] + 1;
$update = $koneksi_db->sql_query ("UPDATE menu2_users SET ordering='$total' WHERE ordering='".($ID+1)."'"); 
$update = $koneksi_db->sql_query ("UPDATE menu2_users SET ordering=ordering+1 WHERE ordering='$ID'");
$update = $koneksi_db->sql_query ("UPDATE menu2_users SET ordering='$ID' WHERE ordering='$total'");    
header ("location:admin.php?pilih=admin_menu2&aksi=menu2user");
}

if(isset($_POST['submit'])){
	$menu2 		= $_POST['menu2'];
	$url 		= $_POST['url'];
	$ceks 		= $koneksi_db->sql_query ("SELECT MAX(ordering) as ordering FROM menu2_users");
    $hasil 		= $koneksi_db->sql_fetchrow ($ceks);
    $ordering 	= $hasil['ordering'] + 1;
	$error 	= '';
	if (!$menu2)  	$error .= "Error: Silahkan Isi Nama Menunya<br />";
	if (!$url)   	$error .= "Error: Silahkan Isi Urlnya<br />";
	if ($error){
		$tengah .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = $koneksi_db->sql_query( "INSERT INTO `menu2_users` (`menu2` ,`url` ,`ordering`) VALUES ('$menu2','$url','$ordering')" );
		if($hasil){
			$tengah .= '<div class="sukses"><b>Menu Berhasil di Buat.</b></div>';
		}else{
			$tengah .= '<div class="error"><b>Menu Gagal di Buat.</b></div>';
		}
		unset($menu2);
		unset($url);
	}

}
$menu2     		= !isset($menu2) ? '' : $menu2;
$url     		= !isset($url) ? '' : $url;

$tengah .= '
<div class="border">
<form method="post" action="">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">Nama Menu</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">:</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0"><input type="text" name="menu2" value="'.$menu2.'" size="25"></td>
	</tr>
	<tr>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">URL</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">:</td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0"><input type="text" name="url" value="'.$url.'" size="25"></td>
	</tr>
	<tr>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0"></td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0"></td>
		<td style="padding-left: 5px; padding-right: 5px; padding-top: 5px; padding-bottom: 0">
		<input type="submit" value="Submit" name="submit"></td>
	</tr>
</table>
</form>
</div>';
$tengah .= '
<table cellspacing="0" style="width:100%">
	<tr bgcolor="#c0c0c0">
	<th style="width:25px;text-align:center;padding:10px 5px 10px 5px;border-left:1px solid #ccc;border-top:1px solid #ccc;">No</th>
	<th style="text-align:left;padding:10px 5px 10px 5px;border-top:1px solid #ccc;border-left:1px solid #ccc;">Nama Menu</th>
	<th style="text-align:center;padding:10px 5px 10px 5px;border-top:1px solid #ccc;border-left:1px solid #ccc;">Ordering</th>
	<th style="text-align:center;padding:10px 5px 10px 5px;border-right:1px solid #ccc;border-top:1px solid #ccc;border-left:1px solid #ccc;">Aksi</th>
	</tr>';

$no =1;
$query 		= $koneksi_db->sql_query ("SELECT * FROM `menu2_users` ORDER BY `ordering` ASC");
$cekmax 	= $koneksi_db->sql_query ("SELECT MAX(`ordering`) FROM `menu2_users`");
$datacekmax = $koneksi_db->sql_fetchrow($cekmax);
$numbers 	= $datacekmax[0];
while($data = $koneksi_db->sql_fetchrow($query)) {
$orderd = '<a class="image" href="admin.php?pilih=admin_menu2&amp;aksi=menu2user&amp;op=down&amp;id='.$data['ordering'].'"><img src="images/downarrow.png" border="0" alt="down" /></a>';    
$orderu = '<a class="image" href="admin.php?pilih=admin_menu2&amp;aksi=menu2user&amp;op=up&amp;id='.$data['ordering'].'"><img src="images/uparrow.png" border="0" alt="up" /></a>';    
$ordering_down = $orderd;    
$ordering_up = $orderu;        

if ($data['ordering'] == 1) $ordering_up = '&nbsp;&nbsp;&nbsp;';
if ($data['ordering'] == $numbers) $ordering_down = '&nbsp;';

$warna = empty ($warna) ? 'bgcolor="#efefef"' : '';
$tengah .= '
	<tr '.$warna.'>
	<td style="width:25px;text-align:center;padding:2px;border-left:1px solid #ccc;border-top:1px solid #ccc;">'.$no.'</td>
	<td style="text-align:left;padding:2px;border-top:1px solid #ccc;border-left:1px solid #ccc;">'.$data['menu2'].'</td>
	<td style="text-align:center;padding:2px;border-top:1px solid #ccc;border-left:1px solid #ccc;">'.$ordering_up.'  '.$ordering_down.'</td>
	<td style="text-align:center;padding:10px 5px 10px0 5px;border-right:1px solid #ccc;border-top:1px solid #ccc;border-left:1px solid #ccc;"><a href="admin.php?pilih=admin_menu2&amp;aksi=delmu&amp;id='.$data['id'].'">Hapus</a> | <a href="admin.php?pilih=admin_menu2&amp;aksi=editmu&amp;id='.$data['id'].'">Edit</a></td>
	</tr>';
$no++;		
}	
$tengah .= '<tr><td colspan="4" style="width:25px;text-align:center;padding:5px;border-top:1px solid #ccc;">&nbsp;</td></tr></table>';
$admin .= $tengah;
}

echo $admin;

?>
     
