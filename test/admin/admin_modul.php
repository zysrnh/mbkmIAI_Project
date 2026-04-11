<h4>Pengaturan Modul</h4>



<?php


if (!defined('cms-ADMINISTRATOR')) {
    Header("Location: ../index.php");
    exit;
}


if (!cek_login ()){
   exit;
}else{

$index_hal = 1;

$admin = <<<Js

 <script type="text/javascript" language="javascript">
    /*<![CDATA[*/
    // Updates the title of the frameset if possible (ns4 does not allow this)
    if (typeof(parent.document) != 'undefined' && typeof(parent.document) != 'unknown'
        && typeof(parent.document.title) == 'string') {
        parent.document.title = 'Administrasi';
    }
    
    // js form validation stuff
    var confirmMsg  = 'Apakah anda ingin ';
   
    </script>
    <script  type="text/javascript" language="javascript">function confirmLink(theLink, theSqlQuery)
{
    // Confirmation is not required in the configuration file
    // or browser is Opera (crappy js implementation)
    if (confirmMsg == '' || typeof(window.opera) != 'undefined') {
        return true;
    }

    var is_confirmed = confirm(confirmMsg + ' :' + theSqlQuery);
    if (is_confirmed) {
        theLink.href += '&is_js_confirmed=1';
    }

    return is_confirmed;
}
/*]]>*/
</script>


<script language="javascript" src="js/fat.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
 /*<![CDATA[*/
var xmlhttp = false;
try {
xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
try {
xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
} catch (E) {
xmlhttp = false;
}
}
if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
xmlhttp = new XMLHttpRequest();
}


function delrow(tbid, trid) {
	var tb= document.getElementById(tbid);
	var tr= document.getElementById(trid);
	tb.removeChild(tr);
  }

function hapus(serverPage,tbody,iddata){
	
	var hapus_ga = confirm ('Apakah Anda Yakin Ingin Menghapus Data Ini ??');
	
	if (hapus_ga == true){
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
		//obj.innerHTML = xmlhttp.responseText;
		var responservertext = xmlhttp.responseText;
		if (responservertext != ""){
		document.getElementById('responseajax').innerHTML = '<div><table width="100%" class="bodyline"><tr><td align="left"><img src="images/warning.gif" border="0"></td><td align="center"><div class="error">' + responservertext + '</div></td><td align="right"><img src="images/warning.gif" border="0"></td></tr></table></div>';
		}
		
		
	Fat.fade_element(iddata,null,1000,'#FF3333');
	
	if (responservertext == ""){
	 setTimeout("delrow('"+tbody+"','"+iddata+"')", 1000);
	}else {
	Fat.fade_element(iddata,null,1000,'#efefef','#ff3333');
	}
	
	
		}
		}
		xmlhttp.send(null);
		
		
		}
	
}
/*]]>*/
</script> 

Js;


$admin .='<div><a href="admin.php?pilih=admin_modul"><b>Home</b></a> | <a href="admin.php?pilih=admin_modul&amp;aksi=add"><b>Buat Blok Modul Baru</b></a></div>';

if($_GET['aksi']==""){
global $koneksi_db;

$hasil = $koneksi_db->sql_query( "SELECT * FROM modul ORDER BY ordering" );
$cekmax = $koneksi_db->sql_query ("SELECT MAX(`ordering`) FROM `modul`");
$datacekmax = $koneksi_db->sql_fetchrow($cekmax);
$numbers = $datacekmax[0];



$admin .='
<div class="table-responsive"><table class="table table-hover">
<tbody id="rowbody">
 <tr>
 <th><b>Nama Modul</b></th>
<th><b>Status</b></th>
<th><b>Order</b></th>

<th colspan="2"><b>Aksi</b></th>
  </tr>';
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$id = $data['id'];
$published = ($data['published'] == 1) ? '<a href="admin.php?pilih=admin_modul&amp;aksi=pub&amp;pub=tidak&amp;id='.$data['id'].'"><img src="images/tick.gif" border="0" alt="ya" /></a>' : '<a href="admin.php?pilih=admin_modul&amp;aksi=pub&amp;pub=ya&amp;id='.$data['id'].'"><img src="images/tidak.png" border="0" alt="tidak" /></a>';
$posisinya = ($data['posisi'] == 1) ? '<a href="admin.php?pilih=admin_modul&amp;aksi=pindah&amp;id='.$data[0].'&amp;posisi=0">Pindah Kiri</a>' : '<a href="admin.php?pilih=admin_modul&amp;aksi=pindah&amp;id='.$data[0].'&amp;posisi=1">Pindah Kanan</a>';
$orderd = '<a href="admin.php?pilih=admin_modul&amp;aksi=down&amp;id='.$data['ordering'].'"><img src="images/downarrow.png" border="0" alt="down" /></a>';    
$orderu = '<a href="admin.php?pilih=admin_modul&amp;aksi=up&amp;id='.$data['ordering'].'"><img src="images/uparrow.png" border="0" alt="up" /></a>';    
$ordering_down = $orderd;    
$ordering_up = $orderu;        

if ($data['ordering'] == 1) $ordering_up = '&nbsp;&nbsp;&nbsp;';
if ($data['ordering'] == $numbers) $ordering_down = '&nbsp;';

$admin.='
<tr>
    <td>'.$data[1].'</td>
    <td>'.$published.'</td>
    <td>'.$ordering_up.'  '.$ordering_down.'</td>

    <td align="center"><a href="admin.php?pilih=admin_modul&amp;aksi=edit&amp;id='.$data[0].'">Edit</a></td>
    <td align="center"><a href="javascript:hapus(\'modul/ajax/modul_deletes.php?id='.$id.'\',\'rowbody\',\'id_'.$id.'\');">Hapus</a></td>
  </tr>';
}

$admin.='</tbody></table></div>';

$admin .= '<div id="responseajax"></div>';
}


if($_GET['aksi']=="up"){

$ID = int_filter ($_GET['id']);
$select = $koneksi_db->sql_query ("SELECT MAX(ordering) as sc FROM modul");
$data = $koneksi_db->sql_fetchrow ($select);
$total = $data['sc'] + 1;
$update = $koneksi_db->sql_query ("UPDATE modul SET ordering='$total' WHERE ordering='".($ID-1)."'"); 
$update = $koneksi_db->sql_query ("UPDATE modul SET ordering=ordering-1 WHERE ordering='$ID'");
$update = $koneksi_db->sql_query ("UPDATE modul SET ordering='$ID' WHERE ordering='$total'");   
header ("location:admin.php?pilih=admin_modul");
}

if($_GET['aksi']=="down"){
$ID = int_filter ($_GET['id']);
$select = $koneksi_db->sql_query ("SELECT MAX(ordering) as sc FROM modul");
$data = $koneksi_db->sql_fetchrow ($select);
$total = $data['sc'] + 1;
$update = $koneksi_db->sql_query ("UPDATE modul SET ordering='$total' WHERE ordering='".($ID+1)."'"); 
$update = $koneksi_db->sql_query ("UPDATE modul SET ordering=ordering+1 WHERE ordering='$ID'");
$update = $koneksi_db->sql_query ("UPDATE modul SET ordering='$ID' WHERE ordering='$total'");    
header ("location:admin.php?pilih=admin_modul");
}

if($_GET['aksi']=="add"){
global $koneksi_db, $theme;

if (isset($_POST['submit'])) {

    $judul     = text_filter($_POST['judul']);
    $isi         = text_filter($_POST['isi']);
    $setup    = $_POST['setup'];
    $posisi    = $_POST['posisi'];
    $ceks = $koneksi_db->sql_query ("SELECT MAX(ordering) as ordering FROM modul");
    $hasil = $koneksi_db->sql_fetchrow ($ceks);
    $ordering = $hasil['ordering'] + 1;
	$error = '';
    if (!$judul or !$isi)  $error .= "Error: Formulir belum terisi dengan benar, silahkan ulangi.<br />";

    if ($error){
        $admin.='<div class="error">'.$error.'</div>';
    }else{

    $hasil = $koneksi_db->sql_query( "INSERT INTO modul (modul,isi,setup,posisi,ordering,published) VALUES ('$judul','$isi','$setup','$posisi','$ordering','1')" );
    if($hasil){
        $admin.='<div class="sukses">Blok Modul Baru telah berhasil dibuat.</div>';
        $style_include[] ='<meta http-equiv="refresh" content="3; url=admin.php?pilih=admin_modul" />';
    }
    }

}
$admin .='<table width="100%" border="0" cellspacing="0" cellpadding="0" class="middle"><tr><td><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bodyline"><tr><td class="bgcolor1">';
$admin .='<b>Buat Blok Modul Baru</b><br />';
$judul = !isset($judul) ? '' : $judul;
$isi = !isset($isi) ? '' : $isi;

$admin .='<form method="post" action="">
    <table>
        <tr>
            <td>Judul Blok Modul</td>
            <td>:</td>
            <td><input type="text" size="30" name="judul" value="'.$judul.'" />
    </td>
        </tr>
        <tr>
            <td>File Modul (*.php)</td>
            <td>:</td>
            <td><input type="text" name="isi" size="30" value="'.$isi.'" /></td>
        </tr>
        <tr>
            <td>File Setup Modul (*.php)</td>
            <td>:</td>
            <td><input type="text" name="setup" size="30" /></td>
        </tr>
        <tr>
            <td>Posisi Blok Modul</td>
            <td>:</td>
            <td><select name="posisi"><option value="1">Kanan</option></select></td>
        </tr>

        <tr>
            <td></td><td></td><td><input type="submit" name="submit" value="Submit" /></td>
        </tr>
    </table>
</form> ';
$admin .='</td></tr></table></td></tr></table>';

}

if($_GET['aksi']=="pindah"){
global $koneksi_db,$PHP_SELF;

    $id = int_filter ($_GET['id']);
    $posisi = $_GET['posisi'];
    $hasil = $koneksi_db->sql_query( "UPDATE modul SET posisi='$posisi' WHERE id='$id'" );
    if($hasil){
    $ke = ($posisi==0)?"Hidden":"Tampil";
    $admin.='<table width="100%" border="0" cellspacing="0" cellpadding="0" class="middle"><tr><td><table width="100%" class="bodyline"><tr><td align="left"><img src="images/info.gif" border="0"></td><td align="center"><font class="option"><b><br />Posisi Blok Modul telah pindah ke : '.$ke.'<br /></font></td><td align="right"><img src="images/info.gif" border="0"></td></tr></table></td></tr></table>';
    $admin.='<meta http-equiv="refresh" content="3; url=admin.php?pilih=admin_modul">';
    }
}


if($_GET['aksi']=="edit"){
global $koneksi_db;

$id = int_filter ($_GET['id']);

if (isset($_POST['submit'])) {

$judul     = text_filter($_POST['judul']);
$isi         = text_filter($_POST['isi']);
$setup    = $_POST['setup'];
$posisi    = $_POST['posisi'];
$error = '';
if (!$judul or !$isi)  $error .= "Error: Formulir belum terisi dengan benar, silahkan ulangi.<br />";

if ($error){
$admin.='<div class="error">'.$error.'</div>';
}else{

$hasil = $koneksi_db->sql_query( "UPDATE modul SET modul='$judul', isi='$isi', setup='$setup', posisi='$posisi' WHERE id='$id'" );
if($hasil){
$admin.='<div class="sukses">Modul telah di updated</div>';
$style_include[] ='<meta http-equiv="refresh" content="3; url=admin.php?pilih=admin_modul" />';
}
}

}

$hasil = $koneksi_db->sql_query( "SELECT * FROM modul WHERE id=$id" );
while ($data =  $koneksi_db->sql_fetchrow($hasil)) {
    $id      = $data[0];
    $judul  = $data[1];
    $isi      = $data[2];
    $setup = $data[3];
    $posisi = $data[4];
    }

$admin .='<table width="100%" border="0" cellspacing="0" cellpadding="0" class="middle"><tr><td><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bodyline"><tr><td class="bgcolor1">';
$admin .='<b>Edit Blok Modul</b><br />

<form method="post" action="">
    <table>
        <tr>
            <td>Judul Blok Modul</td>
            <td>:</td>
            <td>
            <input type="hidden" name="id" value="'.$id.'" />
            <input type="text" size="30" name="judul" value="'.$judul.'" />
            </td>
        </tr>
        <tr>
            <td>File Modul (*.php)</td>
            <td>:</td>
            <td><input type="text" size="30" name="isi" value="'.$isi.'" /></td>
        </tr>
        <tr>
            <td>File Setup Modul (*.php)</td>
            <td>:</td>
            <td><input type="text" size="30" name="setup" value="'.$setup.'" /></td>
        </tr>
        <tr>
            <td>Posisi Blok Modul</td>
            <td>:</td>';

$kiri = '';
$kanan = '';
if ($posisi==0){
$kiri="selected='selected'";
} else {
$kanan="selected='selected'";
}
$admin .='
            <td><select name="posisi"><option value="1" '.$kanan.'>Kanan</option></select></td>
        </tr>
        <tr>
            <td></td><td></td><td><input type="submit" name="submit" value="submit" /></td>
        </tr>
    </table>
</form>';
$admin .='</td></tr></table></td></tr></table>';

}


if($_GET['aksi']=="hapus"){
    global $koneksi_db;
    $id = int_filter ($_GET['id']);
    $hasil = $koneksi_db->sql_query("DELETE FROM modul WHERE id='$id'");
    if($hasil){
    $admin.='<table width="100%" border="0" cellspacing="0" cellpadding="0" class="middle"><tr><td><table width="100%" class="bodyline"><tr><td align="left"><img src="images/info.gif" border="0"></td><td align="center"><font class="option"><b><br />Blok Modul telah di delete!<br /></font></td><td align="right"><img src="images/info.gif" border="0"></td></tr></table></td></tr></table>';
    $admin.='<meta http-equiv="refresh" content="3; url=admin.php?pilih=admin_modul">';
    }
}

if ($_GET['aksi'] == 'pub'){

    if ($_GET['pub'] == 'tidak'){
    $id = int_filter ($_GET['id']);
    $koneksi_db->sql_query ("UPDATE modul SET published=0 WHERE id='$id'");
        }

    if ($_GET['pub'] == 'ya'){
    $id = int_filter ($_GET['id']);
    $koneksi_db->sql_query ("UPDATE modul SET published=1 WHERE id='$id'");
        }

    header ("location:admin.php?pilih=admin_modul");
}

echo $admin;

}
?> 
