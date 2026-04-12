<?php



include 'ikutan/session.php';
@header("Content-type: text/html; charset=utf-8;");
ob_start("ob_gzhandler");


define('cms-ADMINISTRATOR', true);
include "ikutan/config.php";
include "ikutan/mysqli.php";
include "ikutan/template.php";
global $judul_situs,$theme;


$old_modules = !isset($old_modules) ? null : $old_modules;
$_GET['aksi'] = !isset($_GET['aksi']) ? null : $_GET['aksi'];

$cek = '';
if (!cek_login ()){
   	$cek ='<div class="error"><font class="option">You Must Login First If Not Yet Have Account Please Register.</div>';
   	header ("location:admin.html");
	    exit;

}else{

if ($_SESSION['LevelAkses']=="Administrator"){

include "ikutan/security.php";

if ($old_modules == 1) {
      //  if (!ini_get("register_globals")) @import_request_variables('GPC');
}  

ob_start();
if(!isset($_GET['pilih'])){
	include 'konten/normal.php';
	} else if (@$_GET['modul'] == 'yes'
			&& file_exists('modul/'.$_GET['pilih'].'/admin/admin_'.$_GET['pilih'].'.php') 
			&& !preg_match("/[\.\/]/",$_GET['pilih'])) {
				include 'modul/'.$_GET['pilih'].'/admin/admin_'.$_GET['pilih'].'.php';	
			} else if (!isset($_GET['modul']) 
			&& file_exists('admin/'.$_GET['pilih'].'.php') 
			&& !preg_match("/[\.\/]/",$_GET['pilih'])) {
				include 'admin/'.$_GET['pilih'].'.php';	
				}
	else {
	include 'konten/normal.php';	
	}

$tengah = ob_get_contents();
ob_end_clean();

if ($_GET['aksi'] == 'logout') {
logout ();
}


}

else if ($_SESSION['LevelAkses']=="Editor"){
	
include "ikutan/security.php";	

ob_start();
if(!isset($_GET['pilih'])){
	include 'konten/normal.php';
		}else if (@$_GET['modul'] == 'yes' 
				  && file_exists('modul/'.$_GET['pilih'].'/editor/editor_'.$_GET['pilih'].'.php') 
				  && !preg_match("/[\.\/]/",$_GET['pilih'])){
						include 'modul/'.$_GET['pilih'].'/editor/editor_'.$_GET['pilih'].'.php';	
					}else {
						include 'konten/normal.php';	
					}
$tengah = ob_get_contents();
ob_end_clean();

}


else if ($_SESSION['LevelAkses']=="User"){
	
include "ikutan/security.php";	

ob_start();
if(!isset($_GET['pilih'])){
	include 'konten/normal.php';
		}else if (@$_GET['modul'] == 'yes' 
				  && file_exists('modul/'.$_GET['pilih'].'/user/user_'.$_GET['pilih'].'.php') 
				  && !preg_match("/[\.\/]/",$_GET['pilih'])){
						include 'modul/'.$_GET['pilih'].'/user/user_'.$_GET['pilih'].'.php';	
					}else {
						include 'konten/normal.php';	
					}
$tengah = ob_get_contents();
ob_end_clean();

}







else{
	$cek.='<div class"error">Access has been stop.</div>';

}

}
///////////////// BASE URL ////////////
ob_start();
include "plugin/baseurl.php";
$baseurl = ob_get_contents();
ob_end_clean();

//////////////////////////////////
///////////////// LOGO ////////////
ob_start();
include "plugin/logo.php";
$logo = ob_get_contents();
ob_end_clean();

//////////////////////////////////
///////////////// MEDSOS ////////////
ob_start();
include "plugin/medsos.php";
$medsos = ob_get_contents();
ob_end_clean();

//////////////////////////////////
///////////////// FOOTER ////////////
ob_start();
include "plugin/footer.php";
$footer = ob_get_contents();
ob_end_clean();
//////////////////////////////////
///////////////// LINKLOGIN ////////////
ob_start();
include "plugin/linklogin.php";
$linklogin = ob_get_contents();
ob_end_clean();

//////////////////////////////////
///// MENU KIRI /////////////////////

if (!isset($_GET['pilih'])) {
ob_start();

include "plugin/kiri.php";
$kiri = ob_get_contents();
ob_end_clean(); 
} else {
ob_start();
$kiri = ob_get_contents();
ob_end_clean();
}

///// MENU KIRI /////////////////////
///// MENU KANAN /////////////////////
if (!isset($_GET['pilih'])) {
ob_start();


$kanan = ob_get_contents();
ob_end_clean(); 
} else {
ob_start();
include "plugin/berita.php";
echo "<!-- blok kanan -->";
modul(1);
echo "<!-- blok kanan -->";
blok(1);

$kanan = ob_get_contents();
ob_end_clean();
}
///// MENU KANAN /////////////////////
///// HEADER /////////////////////
if (!isset($_GET['pilih'])) {
ob_start();
include "plugin/header.php";
$header = ob_get_contents();
ob_end_clean(); 
} else {
ob_start();
include "plugin/head.php";
$header = ob_get_contents();
ob_end_clean();
}
///// HEADER /////////////////////
///// IKLAN /////////////////////
if (!isset($_GET['pilih'])) {
ob_start();

include "plugin/iklan.php";
$iklan = ob_get_contents();
ob_end_clean(); 
} else {
ob_start();
$iklan = ob_get_contents();
ob_end_clean();
}

///// MENU KIRI /////////////////////
///// SPASI /////////////////////
if (!isset($_GET['pilih'])) {
ob_start();
$spasi = ob_get_contents();
ob_end_clean(); 
} else {
ob_start();
include "plugin/spasi.php";
$spasi = ob_get_contents();
ob_end_clean();
}
///// SPASI /////////////////////
///// SPASI /////////////////////
if (!isset($_GET['pilih'])) {
ob_start();
$spasi2 = ob_get_contents();
ob_end_clean(); 
} else {
ob_start();
include "plugin/spasi2.php";
$spasi2 = ob_get_contents();
ob_end_clean();
}
///// SPASI /////////////////////

///// SPASI /////////////////////
if (!isset($_GET['pilih'])) {
ob_start();
$spasi3 = ob_get_contents();
ob_end_clean(); 
} else {
ob_start();
include "plugin/spasi3.php";
$spasi3 = ob_get_contents();
ob_end_clean();
}
///// SPASI /////////////////////
///// JQUERY HIDDEN /////////////////////

if (!isset($_GET['pilih'])) {
ob_start();

include "plugin/jhidden.php";
$jhidden = ob_get_contents();
ob_end_clean(); 
} else {
ob_start();
$jhidden = ob_get_contents();
ob_end_clean();
}

///// JQUERY HIDDEN /////////////////////

echo $cek;
$style_include_out = !isset($style_include) ? '' : implode("",$style_include);
$script_include_out = !isset($script_include) ? '' : implode("",$script_include);
$linklogin = !isset($linklogin) ? '' : $linklogin;
$kiri = !isset($kiri) ? '' : $kiri;
$kanan = !isset($kanan) ? '' : $kanan;
$header = !isset($header) ? '' : $header;
$logo = !isset($logo) ? '' : $logo;
$baseurl = !isset($baseurl) ? '' : $baseurl;
$medsos = !isset($medsos) ? '' : $medsos;
$footer = !isset($footer) ? '' : $footer;
$jhidden = !isset($jhidden) ? '' : $jhidden;
$spasi = !isset($spasi) ? '' : $spasi;
$spasi2 = !isset($spasi2) ? '' : $spasi2;
$spasi3 = !isset($spasi3) ? '' : $spasi3;
$iklan = !isset($iklan) ? '' : $iklan;
$define = array ( 'linklogin'     => $linklogin,
				  'kiri'     => $kiri,
				  'kanan'     => $kanan,
				  'header'     => $header,
				  'logo'     => $logo,
				  'baseurl'     => $baseurl,
				  'medsos'     => $medsos,
				  'footer'     => $footer,
				  'jhidden'     => $jhidden,
				  'spasi'     => $spasi,
				  'spasi2'     => $spasi2,
				  'spasi3'     => $spasi3,
				  'iklan'     => $iklan,
				'tengah'     => $tengah,
				 'judul_situs' => $judul_situs,
				 'style_include' => $style_include_out,
				 'script_include' => $script_include_out,
				 'meta_description' => $_META['description'],
				 'meta_keywords' => $_META['keywords']
                );
                
$tpl = new template ('thema/cms-template.html');
$tpl-> define_tag($define);

$tpl-> cetak();
?>