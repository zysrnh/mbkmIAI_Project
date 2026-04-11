<?php

if (!defined('cms-FUNGSI')) {
	Header("Location: index.php");
    exit;
}

function input_textarea2 ($name,$value,$rows=4,$cols=44){
	global $_input;
	$_POST = !isset ($_POST) ? array() : $_POST;
	$focus = count($_POST) <= 0 ? ' onblur="this.style.color=\'#6A8FB1\'; this.className=\'\'" onfocus="this.style.color=\'#FB6101\'; this.className=\'inputfocus\'"' : '';
$value = stripslashes($value);	
return '<textarea rows="4" name="'.$name.'" '.@$_input[$name].$focus.' cols="44">'.$value.'</textarea>';;	
}

function getPagingx($jumlah, $pg, $stg, $topik) {
		
		$topik    = int_filter($_GET['topik']);
$k5 = $koneksi_db->sql_query("SELECT * FROM topik WHERE id='$topik'");
while($kk5=$koneksi_db->sql_fetchrow($k5)){
	$namak5 = $kk5['topik'];
}
		$urlxtopik=str_replace(" ", "-", $namak5);
		
		
        if (!isset ($pg,$stg)){
              $pg = 1;
              $stg = 1;
          }
      $qs = '';
      $arr = explode("&",$_SERVER["QUERY_STRING"]);
      if (is_array($arr)) {
        for ($i=0;$i<count($arr);$i++) {
          if (!is_int(strpos($arr[$i],"pg=")) && !is_int(strpos($arr[$i],"stg=")) && !is_int(strpos($arr[$i],"offset="))&& trim($arr[$i]) != "") {
              $qs .= $arr[$i]."&amp;";
          }
        }
      }
      if ($this->rowperpage<$jumlah) {
        $allpage = ceil($jumlah/$this->rowperpage);
        $allstg  = ceil($allpage/$this->pageperstg);
        $minpage = (($stg-1)*$this->pageperstg)+1;
        $maxpage = $stg*$this->pageperstg;
        if ($maxpage>$allpage) $maxpage = $allpage;
        if ($allpage>1) {
             if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
          $rtn  = "<table cellpadding=\"2\" cellspacing=\"0\"><tr style=\"text-align:center\"><td class=\"smallbody\">";
          if ($stg>1) $rtn .= "<a class=\"nextstage\" href=\"\">&laquo;&laquo;&laquo;</a> | ";
          if ($pg>1) {
            if ($pg==$minpage) {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"category/".$topik."/".$urlxtopik."/".($stg-1)."/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            } else {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"category/".$topik."/".$urlxtopik."/$stg/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            }
          }
          for ($i=$minpage;$i<=$maxpage;$i++) {

            if ($i==$pg) {
              $rtn .= "<b>$i</b> | ";
            } else {
                if  ($i==1) {
                 $newoffset = 0;
              }else {
                  $newoffset = ($i-1)*$this->rowperpage;
              }
              $rtn .= "<a href=\"category/".$topik."/".$urlxtopik."/$stg/$newoffset/pg=".$i."\" title='Page $i'>$i</a> | ";
            }
          }
          if ($pg<=$maxpage) {
            if ($pg==$maxpage && $stg<$allstg) {
              $rtn .= " <a class=\"nextpage\" href=\"category/".$topik."/".$urlxtopik."/".($stg+1)."/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            } elseif ($pg<$maxpage) {
              $rtn .= " <a class=\"nextpage\" href=\"category/".$topik."/".$urlxtopik."/$stg/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            }
          }
          if ($stg<$allstg) {
              $rtn .= "<a class=\"nextstage\" href=\"category/".$topik."/".$urlxtopik."/".($stg+1)."/".(($maxpage)*$this->rowperpage)."/pg=".($maxpage+1)."\"  title='Page $i'> &raquo;&raquo;&raquo;</a> | ";
              }
          $rtn = substr($rtn,0,strlen($rtn)-3);
          $rtn .= "</td></tr></table>";
          return $rtn;
        }
      }
    }
    


  function smart_resize_image($file,
                              $string             = null,
                              $width              = 0, 
                              $height             = 0, 
                              $proportional       = false, 
                              $output             = 'file', 
                              $delete_original    = true, 
                              $use_linux_commands = false,
                              $quality            = 100,
                              $grayscale          = false
  		 ) {
      
    if ( $height <= 0 && $width <= 0 ) return false;
    if ( $file === null && $string === null ) return false;

    # Setting defaults and meta
    $info                         = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
    $image                        = '';
    $final_width                  = 0;
    $final_height                 = 0;
    list($width_old, $height_old) = $info;
	$cropHeight = $cropWidth = 0;

    # Calculating proportionality
    if ($proportional) {
      if      ($width  == 0)  $factor = $height/$height_old;
      elseif  ($height == 0)  $factor = $width/$width_old;
      else                    $factor = min( $width / $width_old, $height / $height_old );

      $final_width  = round( $width_old * $factor );
      $final_height = round( $height_old * $factor );
    }
    else {
      $final_width = ( $width <= 0 ) ? $width_old : $width;
      $final_height = ( $height <= 0 ) ? $height_old : $height;
	  $widthX = $width_old / $width;
	  $heightX = $height_old / $height;
	  
	  $x = min($widthX, $heightX);
	  $cropWidth = ($width_old - $width * $x) / 2;
	  $cropHeight = ($height_old - $height * $x) / 2;
    }

    # Loading image to memory according to type
    switch ( $info[2] ) {
      case IMAGETYPE_JPEG:  $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);  break;
      case IMAGETYPE_GIF:   $file !== null ? $image = imagecreatefromgif($file)  : $image = imagecreatefromstring($string);  break;
      case IMAGETYPE_PNG:   $file !== null ? $image = imagecreatefrompng($file)  : $image = imagecreatefromstring($string);  break;
      default: return false;
    }
    
    # Making the image grayscale, if needed
    if ($grayscale) {
      imagefilter($image, IMG_FILTER_GRAYSCALE);
    }    
    
    # This is the resizing/resampling/transparency-preserving magic
    $image_resized = imagecreatetruecolor( $final_width, $final_height );
    if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
      $transparency = imagecolortransparent($image);
      $palletsize = imagecolorstotal($image);

      if ($transparency >= 0 && $transparency < $palletsize) {
        $transparent_color  = imagecolorsforindex($image, $transparency);
        $transparency       = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
        imagefill($image_resized, 0, 0, $transparency);
        imagecolortransparent($image_resized, $transparency);
      }
      elseif ($info[2] == IMAGETYPE_PNG) {
        imagealphablending($image_resized, false);
        $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
        imagefill($image_resized, 0, 0, $color);
        imagesavealpha($image_resized, true);
      }
    }
    imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);
	
	
    # Taking care of original, if needed
    if ( $delete_original ) {
      if ( $use_linux_commands ) exec('rm '.$file);
      else @unlink($file);
    }

    # Preparing a method of providing result
    switch ( strtolower($output) ) {
      case 'browser':
        $mime = image_type_to_mime_type($info[2]);
        header("Content-type: $mime");
        $output = NULL;
      break;
      case 'file':
        $output = $file;
      break;
      case 'return':
        return $image_resized;
      break;
      default:
      break;
    }
    
    # Writing image according to type to the output destination and image quality
    switch ( $info[2] ) {
      case IMAGETYPE_GIF:   imagegif($image_resized, $output);    break;
      case IMAGETYPE_JPEG:  imagejpeg($image_resized, $output, $quality);   break;
      case IMAGETYPE_PNG:
        $quality = 9 - (int)((0.9*$quality)/10.0);
        imagepng($image_resized, $output, $quality);
        break;
      default: return false;
    }

    return true;
  }

function watermarkImage ($SourceFile, $WaterMarkText, $DestinationFile) { 
	//$SourceFile is source of the image file to be watermarked
	//$WaterMarkText is the text of the watermark
	//$DestinationFile is the destination location where the watermarked images will be placed
	
	//Delete if destinaton file already exists
	@unlink($DestinationFile);
	
	//This is the vertical center of the image
	$top = getimagesize($SourceFile);
	$top = $top[1]/2;
	list($width, $height) = getimagesize($SourceFile);
	
	$image_p = imagecreatetruecolor($width, $height);
	
	$image = imagecreatefromjpeg($SourceFile);
	
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height); 
	


	
	//Path to the font file on the server. Do not miss to upload the font file
	$font = 'arial.ttf';

	//Font sie
	$font_size = 24; 

	//Give a white shadow
	$white = imagecolorallocate($image_p, 255, 255, 255);	
	imagettftext($image_p, $font_size, 0, 10, $top, $white, $font, $WaterMarkText);
	
	//Print in black color
	$black = imagecolorallocate($image_p, 0, 0, 0);
	imagettftext($image_p, $font_size, 0, 8, $top-1, $black, $font, $WaterMarkText);

   if ($DestinationFile<>'') {

      imagejpeg ($image_p, $DestinationFile, 100); 

   } else {

      header('Content-Type: image/jpeg');

      imagejpeg($image_p, null, 100);

   };

   imagedestroy($image); 

   imagedestroy($image_p); 

}
function watermark_image($oldimage_name, $new_image_name){
    global $image_path;
    list($owidth,$oheight) = getimagesize($oldimage_name);
    $width = $height = 300;    // tentukan ukuran gambar akhir, contoh: 300 x 300
    $im = imagecreatetruecolor($width, $height);
    $img_src = imagecreatefromjpeg($oldimage_name);
    imagecopyresampled($im, $img_src, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
    $watermark = imagecreatefrompng($image_path);
    list($w_width, $w_height) = getimagesize($image_path);        
    $pos_x = $width - $w_width; 
    $pos_y = $height - $w_height;
    imagecopy($im, $watermark, $pos_x, $pos_y, 0, 0, $w_width, $w_height);
    imagejpeg($im, $new_image_name, 100); 
    imagedestroy($im);
    unlink($oldimage_name);
    return true;
}
 
function watermark_text($oldimage_name, $new_image_name){
    global $font_path, $font_size, $text_show;
    list($owidth,$oheight) = getimagesize($oldimage_name);
    $width = $height = 300;  // tentukan ukuran gambar akhir, contoh: 300 x 300  
    $image = imagecreatetruecolor($width, $height);
    $image_src = imagecreatefromjpeg($oldimage_name);
    imagecopyresampled($image, $image_src, 0, 0, 0, 0, $width, $height, $owidth, $oheight);  
	$blue   = imagecolorallocate($image, 79, 166, 185);  // tentukan warna teks dalam RGB (255,255,255)
	$shadow = imagecolorallocate($image, 178, 178, 178); // efek teks shadow
	imagettftext($image, $font_size, 0, 70, 191, $shadow, $font_path, $text_show);  // posisikan logo watermark pada gambar
    imagettftext($image, $font_size, 0, 68, 190, $blue, $font_path, $text_show);
    imagejpeg($image, $new_image_name, 100); 
    imagedestroy($image);
    unlink($oldimage_name);
    return true;
}
function matauang($jumlah){
	global $mata_uang,$ribuan,$desimal,$letak_matauang,$jumlah_desimal;
	//$jumlah=number_format($jumlah,$desimal,@$jumlah_desimal,$ribuan);
	$jumlah = number_format($jumlah,0,',','.');
	$jumlah =($letak_matauang=='L')?"$mata_uang$jumlah":"$jumlah$mata_uang";
	return $jumlah;
}
function kotakjudul($title, $content) {
    global  $theme;
    $thefile = addslashes(file_get_contents("thema/cms-menu.html"));
    $thefile = "\$r_file=\"".$thefile."\";";
    eval($thefile);
    echo $r_file;
}

function catch_that_image($post) {
		$first_img = NULL;
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post, $matches);
		$first_img = $matches [1][0];
		return $first_img;
	}

function modul($posisi){
    global $koneksi_db,$STYLE_INCLUDE,$SCRIPT_INCLUDE;
	
    $modulku = $koneksi_db->sql_query( "SELECT * FROM modul WHERE published=1 AND posisi=$posisi ORDER BY ordering" );

                while ($viewmodul = $koneksi_db->sql_fetchrow($modulku)) {
	                if (file_exists($viewmodul['isi'])){
                    include $viewmodul['isi'];
                    kotakjudul($viewmodul[1], @$out,'');
                   	$out = '';
                	}
                    
                    
                }
               
}

function blok($posisi){
    global $koneksi_db;
	
                $modulku = $koneksi_db->sql_query( "SELECT * FROM blok WHERE published=1 AND posisi=$posisi ORDER BY ordering" );

                while ($viewmodul = $koneksi_db->sql_fetchrow($modulku)) {

                  kotakjudul($viewmodul['1'], $viewmodul['2'],'');

                }
                
}

function strip_ext($name){
            $ext = strrchr($name, '.');
            if($ext !== false) {
            $name = substr($name, 0, -strlen($ext));
            }
        return $name;
}

    /* Verifikasi kode HTML */

function gb($string) {

        $string = stripslashes(nl2br($string));

        return($string);

}

function gb0($string) {

        $string = stripslashes(nl2br($string));
        $string = htmlspecialchars($string);
        return($string);

}


function gb1($string) {

        $string = nl2br($string);
        return($string);

}


function gb2($string) {

        $string = htmlspecialchars($string);
        $string = nl2br($string);
        return($string);

}

function hlm($string) {

        $string = stripslashes($string);
        return($string);

}

function nohtml($string) {

        $string = stripslashes(htmlspecialchars($string));
        return($string);

}

function asli($string) {

        $string = htmlspecialchars($string);
        return($string);

}



function themenews($id, $title, $ket, $content, $author='') {
    global $theme;
    $thefile = addslashes(file_get_contents("thema/cms-konten.html"));
    $thefile = "\$r_file=\"".$thefile."\";";
    eval($thefile);
    echo $r_file;
}


// Format Password
function gen_pass($m) {
    $m = intval($m);
    $pass = "";
    for ($i = 0; $i < $m; $i++) {
        $te = mt_rand(48, 122);
        if (($te > 57 && $te < 65) || ($te > 90 && $te < 97)) $te = $te - 9;
        $pass .= chr($te);
    }
    return $pass;
}

switch(isset($_REQUEST['code'])) {
    case "gfx":
    $code = substr(hexdec(md5("".date("F j")."".$_REQUEST["random_num"]."".$sitekey."")), 2, 6);
        $image = ImageCreateFromJpeg("images/code_bg.jpg");
        $text_color = ImageColorAllocate($image, 100, 100, 100);
        Header("Content-type: image/jpeg");
        ImageString($image, 5, 12, 2, $code, $text_color);
        ImageJpeg($image, "", 50);
        ImageDestroy($image);
        exit;
        break;
}



// HTML and Word filter
function text_filter($message, $type="") {

    if (intval($type) == 2) {
        $message = htmlspecialchars(trim($message), ENT_QUOTES);
    } else {
        $message = strip_tags(urldecode($message));
        $message = htmlspecialchars(trim($message), ENT_QUOTES);
    }
   
    return $message;
}


// Mail check
function checkemail($email) {
    global $error;
    $email = strtolower($email);
    if ((!$email) || ($email=="") || (!preg_match("/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,6}$/", $email))) $error .= "<center>Alamat email tidak valid.<br />Silahkan lihat contoh (<b>admin@cms.com</b>)</center>";
    if ((strlen($email) >= 4) && (substr($email, 0, 4) == "www.")) $error .= "<center>Alamat email tidak valid.<br />Silahkan hapus awalan (<b>www.</b>)</center>";
    if (strrpos($email, " ") > 0) $error .= "<center>Alamat email tidak valid, mungkin terdapat spasi.</center>";
    return $error;
}

// Mail send
function mail_send($email, $smail, $subject, $message, $id="", $pr="") {
    $email = text_filter($email);
    $smail = text_filter($smail);
    $subject = text_filter($subject);
    $id = intval($id);
    $pr = (!$pr) ? "3" : "".intval($pr)."";
    $message = (!$id) ? "".$message."" : "".$message."<br /><br />IP: ".getenv("REMOTE_ADDR")."<br />User agent: ".getenv("HTTP_USER_AGENT")."";
    $mheader = "MIME-Version: 1.0\n"
    ."Content-Type: text/html; charset=utf-8\n"
    ."Reply-To: \"$smail\" <$smail>\n"
    ."From: \"$smail\" <$smail>\n"
    ."Return-Path: <$smail>\n"
    ."X-Priority: $pr\n"
    ."X-Mailer: Klaten WEB.com Mailer\n";
    @mail($email, $subject, $message, $mheader);
}


class paging {
    function paging ($limit) {
      $this->rowperpage = $limit;
      $this->pageperstg = 5;

    }


    function getPaging6($jumlah, $pg, $stg, $topik, $rubrik) {


		$urlxtopik=str_replace(" ", "-", $rubrik);
		
		
        if (!isset ($pg,$stg)){
              $pg = 1;
              $stg = 1;
          }
      $qs = '';
      $arr = explode("&",$_SERVER["QUERY_STRING"]);
      if (is_array($arr)) {
        for ($i=0;$i<count($arr);$i++) {
          if (!is_int(strpos($arr[$i],"pg=")) && !is_int(strpos($arr[$i],"stg=")) && !is_int(strpos($arr[$i],"offset="))&& trim($arr[$i]) != "") {
              $qs .= $arr[$i]."&amp;";
          }
        }
      }
      if ($this->rowperpage<$jumlah) {
        $allpage = ceil($jumlah/$this->rowperpage);
        $allstg  = ceil($allpage/$this->pageperstg);
        $minpage = (($stg-1)*$this->pageperstg)+1;
        $maxpage = $stg*$this->pageperstg;
        if ($maxpage>$allpage) $maxpage = $allpage;
        if ($allpage>1) {
             if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
          $rtn  = "<table cellpadding=\"2\" cellspacing=\"0\"><tr style=\"text-align:center\"><td class=\"smallbody\">";
          if ($stg>1) $rtn .= "<a class=\"nextstage\" href=\"\">&laquo;&laquo;&laquo;</a> | ";
          if ($pg>1) {
            if ($pg==$minpage) {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"category/".$topik."/".$urlxtopik."/".($stg-1)."/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            } else {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"category/".$topik."/".$urlxtopik."/$stg/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            }
          }
          for ($i=$minpage;$i<=$maxpage;$i++) {

            if ($i==$pg) {
              $rtn .= "<b>$i</b> | ";
            } else {
                if  ($i==1) {
                 $newoffset = 0;
              }else {
                  $newoffset = ($i-1)*$this->rowperpage;
              }
              $rtn .= "<a href=\"category/".$topik."/".$urlxtopik."/$stg/$newoffset/pg=".$i."\" title='Page $i'>$i</a> | ";
            }
          }
          if ($pg<=$maxpage) {
            if ($pg==$maxpage && $stg<$allstg) {
              $rtn .= " <a class=\"nextpage\" href=\"category/".$topik."/".$urlxtopik."/".($stg+1)."/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            } elseif ($pg<$maxpage) {
              $rtn .= " <a class=\"nextpage\" href=\"category/".$topik."/".$urlxtopik."/$stg/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            }
          }
          if ($stg<$allstg) {
              $rtn .= "<a class=\"nextstage\" href=\"category/".$topik."/".$urlxtopik."/".($stg+1)."/".(($maxpage)*$this->rowperpage)."/pg=".($maxpage+1)."\"  title='Page $i'> &raquo;&raquo;&raquo;</a> | ";
              }
          $rtn = substr($rtn,0,strlen($rtn)-3);
          $rtn .= "</td></tr></table>";
          return $rtn;
        }
      }
    }
    
    
    function getPaging3($jumlah, $pg, $stg, $queryx) {


		$urlxtopik=$queryx;
		
		
        if (!isset ($pg,$stg)){
              $pg = 1;
              $stg = 1;
          }
      $qs = '';
      $arr = explode("&",$_SERVER["QUERY_STRING"]);
      if (is_array($arr)) {
        for ($i=0;$i<count($arr);$i++) {
          if (!is_int(strpos($arr[$i],"pg=")) && !is_int(strpos($arr[$i],"stg=")) && !is_int(strpos($arr[$i],"offset="))&& trim($arr[$i]) != "") {
              $qs .= $arr[$i]."&amp;";
          }
        }
      }
      if ($this->rowperpage<$jumlah) {
        $allpage = ceil($jumlah/$this->rowperpage);
        $allstg  = ceil($allpage/$this->pageperstg);
        $minpage = (($stg-1)*$this->pageperstg)+1;
        $maxpage = $stg*$this->pageperstg;
        if ($maxpage>$allpage) $maxpage = $allpage;
        if ($allpage>1) {
             if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
          $rtn  = "<table cellpadding=\"2\" cellspacing=\"0\"><tr style=\"text-align:center\"><td class=\"smallbody\">";
          if ($stg>1) $rtn .= "<a class=\"nextstage\" href=\"\">&laquo;&laquo;&laquo;</a> | ";
          if ($pg>1) {
            if ($pg==$minpage) {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"search/".$urlxtopik."/".($stg-1)."/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            } else {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"search/".$urlxtopik."/$stg/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            }
          }
          for ($i=$minpage;$i<=$maxpage;$i++) {

            if ($i==$pg) {
              $rtn .= "<b>$i</b> | ";
            } else {
                if  ($i==1) {
                 $newoffset = 0;
              }else {
                  $newoffset = ($i-1)*$this->rowperpage;
              }
              $rtn .= "<a href=\"search/".$urlxtopik."/$stg/$newoffset/pg=".$i."\" title='Page $i'>$i</a> | ";
            }
          }
          if ($pg<=$maxpage) {
            if ($pg==$maxpage && $stg<$allstg) {
              $rtn .= " <a class=\"nextpage\" href=\"search/".$urlxtopik."/".($stg+1)."/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            } elseif ($pg<$maxpage) {
              $rtn .= " <a class=\"nextpage\" href=\"search/".$urlxtopik."/$stg/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            }
          }
          if ($stg<$allstg) {
              $rtn .= "<a class=\"nextstage\" href=\"search/".$urlxtopik."/".($stg+1)."/".(($maxpage)*$this->rowperpage)."/pg=".($maxpage+1)."\"  title='Page $i'> &raquo;&raquo;&raquo;</a> | ";
              }
          $rtn = substr($rtn,0,strlen($rtn)-3);
          $rtn .= "</td></tr></table>";
          return $rtn;
        }
      }
    }
    
	
	
	
	
	
	
	
	 function getPagingkatfoto($jumlah, $pg, $stg, $kid) {


		$urlxtopik=$kid;
		
		
        if (!isset ($pg,$stg)){
              $pg = 1;
              $stg = 1;
          }
      $qs = '';
      $arr = explode("&",$_SERVER["QUERY_STRING"]);
      if (is_array($arr)) {
        for ($i=0;$i<count($arr);$i++) {
          if (!is_int(strpos($arr[$i],"pg=")) && !is_int(strpos($arr[$i],"stg=")) && !is_int(strpos($arr[$i],"offset="))&& trim($arr[$i]) != "") {
              $qs .= $arr[$i]."&amp;";
          }
        }
      }
      if ($this->rowperpage<$jumlah) {
        $allpage = ceil($jumlah/$this->rowperpage);
        $allstg  = ceil($allpage/$this->pageperstg);
        $minpage = (($stg-1)*$this->pageperstg)+1;
        $maxpage = $stg*$this->pageperstg;
        if ($maxpage>$allpage) $maxpage = $allpage;
        if ($allpage>1) {
             if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
          $rtn  = "<table cellpadding=\"2\" cellspacing=\"0\"><tr style=\"text-align:center\"><td class=\"smallbody\">";
          if ($stg>1) $rtn .= "<a class=\"nextstage\" href=\"\">&laquo;&laquo;&laquo;</a> | ";
          if ($pg>1) {
            if ($pg==$minpage) {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"gallery/".$urlxtopik."/".($stg-1)."/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            } else {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"gallery/".$urlxtopik."/$stg/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            }
          }
          for ($i=$minpage;$i<=$maxpage;$i++) {

            if ($i==$pg) {
              $rtn .= "<b>$i</b> | ";
            } else {
                if  ($i==1) {
                 $newoffset = 0;
              }else {
                  $newoffset = ($i-1)*$this->rowperpage;
              }
              $rtn .= "<a href=\"gallery/".$urlxtopik."/$stg/$newoffset/pg=".$i."\" title='Page $i'>$i</a> | ";
            }
          }
          if ($pg<=$maxpage) {
            if ($pg==$maxpage && $stg<$allstg) {
              $rtn .= " <a class=\"nextpage\" href=\"gallery/".$urlxtopik."/".($stg+1)."/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            } elseif ($pg<$maxpage) {
              $rtn .= " <a class=\"nextpage\" href=\"gallery/".$urlxtopik."/$stg/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            }
          }
          if ($stg<$allstg) {
              $rtn .= "<a class=\"nextstage\" href=\"gallery/".$urlxtopik."/".($stg+1)."/".(($maxpage)*$this->rowperpage)."/pg=".($maxpage+1)."\"  title='Page $i'> &raquo;&raquo;&raquo;</a> | ";
              }
          $rtn = substr($rtn,0,strlen($rtn)-3);
          $rtn .= "</td></tr></table>";
          return $rtn;
        }
      }
    }
	
	
		 function getPagingvideo($jumlah, $pg, $stg) {


		
		
        if (!isset ($pg,$stg)){
              $pg = 1;
              $stg = 1;
          }
      $qs = '';
      $arr = explode("&",$_SERVER["QUERY_STRING"]);
      if (is_array($arr)) {
        for ($i=0;$i<count($arr);$i++) {
          if (!is_int(strpos($arr[$i],"pg=")) && !is_int(strpos($arr[$i],"stg=")) && !is_int(strpos($arr[$i],"offset="))&& trim($arr[$i]) != "") {
              $qs .= $arr[$i]."&amp;";
          }
        }
      }
      if ($this->rowperpage<$jumlah) {
        $allpage = ceil($jumlah/$this->rowperpage);
        $allstg  = ceil($allpage/$this->pageperstg);
        $minpage = (($stg-1)*$this->pageperstg)+1;
        $maxpage = $stg*$this->pageperstg;
        if ($maxpage>$allpage) $maxpage = $allpage;
        if ($allpage>1) {
             if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
          $rtn  = "<table cellpadding=\"2\" cellspacing=\"0\"><tr style=\"text-align:center\"><td class=\"smallbody\">";
          if ($stg>1) $rtn .= "<a class=\"nextstage\" href=\"\">&laquo;&laquo;&laquo;</a> | ";
          if ($pg>1) {
            if ($pg==$minpage) {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"video/".($stg-1)."/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            } else {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"video/$stg/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            }
          }
          for ($i=$minpage;$i<=$maxpage;$i++) {

            if ($i==$pg) {
              $rtn .= "<b>$i</b> | ";
            } else {
                if  ($i==1) {
                 $newoffset = 0;
              }else {
                  $newoffset = ($i-1)*$this->rowperpage;
              }
              $rtn .= "<a href=\"video/$stg/$newoffset/pg=".$i."\" title='Page $i'>$i</a> | ";
            }
          }
          if ($pg<=$maxpage) {
            if ($pg==$maxpage && $stg<$allstg) {
              $rtn .= " <a class=\"nextpage\" href=\"video/".($stg+1)."/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            } elseif ($pg<$maxpage) {
              $rtn .= " <a class=\"nextpage\" href=\"video/$stg/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            }
          }
          if ($stg<$allstg) {
              $rtn .= "<a class=\"nextstage\" href=\"video/".($stg+1)."/".(($maxpage)*$this->rowperpage)."/pg=".($maxpage+1)."\"  title='Page $i'> &raquo;&raquo;&raquo;</a> | ";
              }
          $rtn = substr($rtn,0,strlen($rtn)-3);
          $rtn .= "</td></tr></table>";
          return $rtn;
        }
      }
    }
	
	
	
	 function getPagingfile($jumlah, $pg, $stg) {


		
		
        if (!isset ($pg,$stg)){
              $pg = 1;
              $stg = 1;
          }
      $qs = '';
      $arr = explode("&",$_SERVER["QUERY_STRING"]);
      if (is_array($arr)) {
        for ($i=0;$i<count($arr);$i++) {
          if (!is_int(strpos($arr[$i],"pg=")) && !is_int(strpos($arr[$i],"stg=")) && !is_int(strpos($arr[$i],"offset="))&& trim($arr[$i]) != "") {
              $qs .= $arr[$i]."&amp;";
          }
        }
      }
      if ($this->rowperpage<$jumlah) {
        $allpage = ceil($jumlah/$this->rowperpage);
        $allstg  = ceil($allpage/$this->pageperstg);
        $minpage = (($stg-1)*$this->pageperstg)+1;
        $maxpage = $stg*$this->pageperstg;
        if ($maxpage>$allpage) $maxpage = $allpage;
        if ($allpage>1) {
             if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
          $rtn  = "<table cellpadding=\"2\" cellspacing=\"0\"><tr style=\"text-align:center\"><td class=\"smallbody\">";
          if ($stg>1) $rtn .= "<a class=\"nextstage\" href=\"\">&laquo;&laquo;&laquo;</a> | ";
          if ($pg>1) {
            if ($pg==$minpage) {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"file-sharing/".($stg-1)."/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            } else {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"file-sharing/$stg/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            }
          }
          for ($i=$minpage;$i<=$maxpage;$i++) {

            if ($i==$pg) {
              $rtn .= "<b>$i</b> | ";
            } else {
                if  ($i==1) {
                 $newoffset = 0;
              }else {
                  $newoffset = ($i-1)*$this->rowperpage;
              }
              $rtn .= "<a href=\"file-sharing/$stg/$newoffset/pg=".$i."\" title='Page $i'>$i</a> | ";
            }
          }
          if ($pg<=$maxpage) {
            if ($pg==$maxpage && $stg<$allstg) {
              $rtn .= " <a class=\"nextpage\" href=\"file-sharing/".($stg+1)."/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            } elseif ($pg<$maxpage) {
              $rtn .= " <a class=\"nextpage\" href=\"file-sharing/$stg/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            }
          }
          if ($stg<$allstg) {
              $rtn .= "<a class=\"nextstage\" href=\"file-sharing/".($stg+1)."/".(($maxpage)*$this->rowperpage)."/pg=".($maxpage+1)."\"  title='Page $i'> &raquo;&raquo;&raquo;</a> | ";
              }
          $rtn = substr($rtn,0,strlen($rtn)-3);
          $rtn .= "</td></tr></table>";
          return $rtn;
        }
      }
    }
	
	
	function getPagingfilecari($jumlah, $pg, $stg, $search) {


		$urlxtopik=str_replace(" ", "+", $search);
		
		
        if (!isset ($pg,$stg)){
              $pg = 1;
              $stg = 1;
          }
      $qs = '';
      $arr = explode("&",$_SERVER["QUERY_STRING"]);
      if (is_array($arr)) {
        for ($i=0;$i<count($arr);$i++) {
          if (!is_int(strpos($arr[$i],"pg=")) && !is_int(strpos($arr[$i],"stg=")) && !is_int(strpos($arr[$i],"offset="))&& trim($arr[$i]) != "") {
              $qs .= $arr[$i]."&amp;";
          }
        }
      }
      if ($this->rowperpage<$jumlah) {
        $allpage = ceil($jumlah/$this->rowperpage);
        $allstg  = ceil($allpage/$this->pageperstg);
        $minpage = (($stg-1)*$this->pageperstg)+1;
        $maxpage = $stg*$this->pageperstg;
        if ($maxpage>$allpage) $maxpage = $allpage;
        if ($allpage>1) {
             if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
          $rtn  = "<table cellpadding=\"2\" cellspacing=\"0\"><tr style=\"text-align:center\"><td class=\"smallbody\">";
          if ($stg>1) $rtn .= "<a class=\"nextstage\" href=\"\">&laquo;&laquo;&laquo;</a> | ";
          if ($pg>1) {
            if ($pg==$minpage) {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"file-sharing/".$urlxtopik."/".($stg-1)."/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            } else {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"file-sharing/".$urlxtopik."/$stg/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            }
          }
          for ($i=$minpage;$i<=$maxpage;$i++) {

            if ($i==$pg) {
              $rtn .= "<b>$i</b> | ";
            } else {
                if  ($i==1) {
                 $newoffset = 0;
              }else {
                  $newoffset = ($i-1)*$this->rowperpage;
              }
              $rtn .= "<a href=\"file-sharing/".$urlxtopik."/$stg/$newoffset/pg=".$i."\" title='Page $i'>$i</a> | ";
            }
          }
          if ($pg<=$maxpage) {
            if ($pg==$maxpage && $stg<$allstg) {
              $rtn .= " <a class=\"nextpage\" href=\"file-sharing/".$urlxtopik."/".($stg+1)."/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            } elseif ($pg<$maxpage) {
              $rtn .= " <a class=\"nextpage\" href=\"file-sharing/".$urlxtopik."/$stg/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            }
          }
          if ($stg<$allstg) {
              $rtn .= "<a class=\"nextstage\" href=\"file-sharing/".$urlxtopik."/".($stg+1)."/".(($maxpage)*$this->rowperpage)."/pg=".($maxpage+1)."\"  title='Page $i'> &raquo;&raquo;&raquo;</a> | ";
              }
          $rtn = substr($rtn,0,strlen($rtn)-3);
          $rtn .= "</td></tr></table>";
          return $rtn;
        }
      }
    }
    
	
	
	 function getPagingtesti($jumlah, $pg, $stg) {


		
		
        if (!isset ($pg,$stg)){
              $pg = 1;
              $stg = 1;
          }
      $qs = '';
      $arr = explode("&",$_SERVER["QUERY_STRING"]);
      if (is_array($arr)) {
        for ($i=0;$i<count($arr);$i++) {
          if (!is_int(strpos($arr[$i],"pg=")) && !is_int(strpos($arr[$i],"stg=")) && !is_int(strpos($arr[$i],"offset="))&& trim($arr[$i]) != "") {
              $qs .= $arr[$i]."&amp;";
          }
        }
      }
      if ($this->rowperpage<$jumlah) {
        $allpage = ceil($jumlah/$this->rowperpage);
        $allstg  = ceil($allpage/$this->pageperstg);
        $minpage = (($stg-1)*$this->pageperstg)+1;
        $maxpage = $stg*$this->pageperstg;
        if ($maxpage>$allpage) $maxpage = $allpage;
        if ($allpage>1) {
             if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
          $rtn  = "<table cellpadding=\"2\" cellspacing=\"0\"><tr style=\"text-align:center\"><td class=\"smallbody\">";
          if ($stg>1) $rtn .= "<a class=\"nextstage\" href=\"\">&laquo;&laquo;&laquo;</a> | ";
          if ($pg>1) {
            if ($pg==$minpage) {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"testimonial/".($stg-1)."/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            } else {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"testimonial/$stg/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            }
          }
          for ($i=$minpage;$i<=$maxpage;$i++) {

            if ($i==$pg) {
              $rtn .= "<b>$i</b> | ";
            } else {
                if  ($i==1) {
                 $newoffset = 0;
              }else {
                  $newoffset = ($i-1)*$this->rowperpage;
              }
              $rtn .= "<a href=\"testimonial/$stg/$newoffset/pg=".$i."\" title='Page $i'>$i</a> | ";
            }
          }
          if ($pg<=$maxpage) {
            if ($pg==$maxpage && $stg<$allstg) {
              $rtn .= " <a class=\"nextpage\" href=\"testimonial/".($stg+1)."/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            } elseif ($pg<$maxpage) {
              $rtn .= " <a class=\"nextpage\" href=\"testimonial/$stg/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            }
          }
          if ($stg<$allstg) {
              $rtn .= "<a class=\"nextstage\" href=\"testimonial/".($stg+1)."/".(($maxpage)*$this->rowperpage)."/pg=".($maxpage+1)."\"  title='Page $i'> &raquo;&raquo;&raquo;</a> | ";
              }
          $rtn = substr($rtn,0,strlen($rtn)-3);
          $rtn .= "</td></tr></table>";
          return $rtn;
        }
      }
    }
	
	
	function getPagingtesticari($jumlah, $pg, $stg, $search) {


		$urlxtopik=str_replace(" ", "+", $search);
		
		
        if (!isset ($pg,$stg)){
              $pg = 1;
              $stg = 1;
          }
      $qs = '';
      $arr = explode("&",$_SERVER["QUERY_STRING"]);
      if (is_array($arr)) {
        for ($i=0;$i<count($arr);$i++) {
          if (!is_int(strpos($arr[$i],"pg=")) && !is_int(strpos($arr[$i],"stg=")) && !is_int(strpos($arr[$i],"offset="))&& trim($arr[$i]) != "") {
              $qs .= $arr[$i]."&amp;";
          }
        }
      }
      if ($this->rowperpage<$jumlah) {
        $allpage = ceil($jumlah/$this->rowperpage);
        $allstg  = ceil($allpage/$this->pageperstg);
        $minpage = (($stg-1)*$this->pageperstg)+1;
        $maxpage = $stg*$this->pageperstg;
        if ($maxpage>$allpage) $maxpage = $allpage;
        if ($allpage>1) {
             if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
          $rtn  = "<table cellpadding=\"2\" cellspacing=\"0\"><tr style=\"text-align:center\"><td class=\"smallbody\">";
          if ($stg>1) $rtn .= "<a class=\"nextstage\" href=\"\">&laquo;&laquo;&laquo;</a> | ";
          if ($pg>1) {
            if ($pg==$minpage) {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"testimonial/".$urlxtopik."/".($stg-1)."/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            } else {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"testimonial/".$urlxtopik."/$stg/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            }
          }
          for ($i=$minpage;$i<=$maxpage;$i++) {

            if ($i==$pg) {
              $rtn .= "<b>$i</b> | ";
            } else {
                if  ($i==1) {
                 $newoffset = 0;
              }else {
                  $newoffset = ($i-1)*$this->rowperpage;
              }
              $rtn .= "<a href=\"testimonial/".$urlxtopik."/$stg/$newoffset/pg=".$i."\" title='Page $i'>$i</a> | ";
            }
          }
          if ($pg<=$maxpage) {
            if ($pg==$maxpage && $stg<$allstg) {
              $rtn .= " <a class=\"nextpage\" href=\"testimonial/".$urlxtopik."/".($stg+1)."/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            } elseif ($pg<$maxpage) {
              $rtn .= " <a class=\"nextpage\" href=\"testimonial/".$urlxtopik."/$stg/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            }
          }
          if ($stg<$allstg) {
              $rtn .= "<a class=\"nextstage\" href=\"testimonial/".$urlxtopik."/".($stg+1)."/".(($maxpage)*$this->rowperpage)."/pg=".($maxpage+1)."\"  title='Page $i'> &raquo;&raquo;&raquo;</a> | ";
              }
          $rtn = substr($rtn,0,strlen($rtn)-3);
          $rtn .= "</td></tr></table>";
          return $rtn;
        }
      }
    }
    
	
	 function getPagingfoto($jumlah, $pg, $stg) {


		
		
        if (!isset ($pg,$stg)){
              $pg = 1;
              $stg = 1;
          }
      $qs = '';
      $arr = explode("&",$_SERVER["QUERY_STRING"]);
      if (is_array($arr)) {
        for ($i=0;$i<count($arr);$i++) {
          if (!is_int(strpos($arr[$i],"pg=")) && !is_int(strpos($arr[$i],"stg=")) && !is_int(strpos($arr[$i],"offset="))&& trim($arr[$i]) != "") {
              $qs .= $arr[$i]."&amp;";
          }
        }
      }
      if ($this->rowperpage<$jumlah) {
        $allpage = ceil($jumlah/$this->rowperpage);
        $allstg  = ceil($allpage/$this->pageperstg);
        $minpage = (($stg-1)*$this->pageperstg)+1;
        $maxpage = $stg*$this->pageperstg;
        if ($maxpage>$allpage) $maxpage = $allpage;
        if ($allpage>1) {
             if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
          $rtn  = "<table cellpadding=\"2\" cellspacing=\"0\"><tr style=\"text-align:center\"><td class=\"smallbody\">";
          if ($stg>1) $rtn .= "<a class=\"nextstage\" href=\"\">&laquo;&laquo;&laquo;</a> | ";
          if ($pg>1) {
            if ($pg==$minpage) {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"gallery/".($stg-1)."/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            } else {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"gallery/$stg/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            }
          }
          for ($i=$minpage;$i<=$maxpage;$i++) {

            if ($i==$pg) {
              $rtn .= "<b>$i</b> | ";
            } else {
                if  ($i==1) {
                 $newoffset = 0;
              }else {
                  $newoffset = ($i-1)*$this->rowperpage;
              }
              $rtn .= "<a href=\"gallery/$stg/$newoffset/pg=".$i."\" title='Page $i'>$i</a> | ";
            }
          }
          if ($pg<=$maxpage) {
            if ($pg==$maxpage && $stg<$allstg) {
              $rtn .= " <a class=\"nextpage\" href=\"gallery/".($stg+1)."/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            } elseif ($pg<$maxpage) {
              $rtn .= " <a class=\"nextpage\" href=\"gallery/$stg/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            }
          }
          if ($stg<$allstg) {
              $rtn .= "<a class=\"nextstage\" href=\"gallery/".($stg+1)."/".(($maxpage)*$this->rowperpage)."/pg=".($maxpage+1)."\"  title='Page $i'> &raquo;&raquo;&raquo;</a> | ";
              }
          $rtn = substr($rtn,0,strlen($rtn)-3);
          $rtn .= "</td></tr></table>";
          return $rtn;
        }
      }
    }
	
	
	
	function getPagingdosen($jumlah, $pg, $stg) {


		
		
        if (!isset ($pg,$stg)){
              $pg = 1;
              $stg = 1;
          }
      $qs = '';
      $arr = explode("&",$_SERVER["QUERY_STRING"]);
      if (is_array($arr)) {
        for ($i=0;$i<count($arr);$i++) {
          if (!is_int(strpos($arr[$i],"pg=")) && !is_int(strpos($arr[$i],"stg=")) && !is_int(strpos($arr[$i],"offset="))&& trim($arr[$i]) != "") {
              $qs .= $arr[$i]."&amp;";
          }
        }
      }
      if ($this->rowperpage<$jumlah) {
        $allpage = ceil($jumlah/$this->rowperpage);
        $allstg  = ceil($allpage/$this->pageperstg);
        $minpage = (($stg-1)*$this->pageperstg)+1;
        $maxpage = $stg*$this->pageperstg;
        if ($maxpage>$allpage) $maxpage = $allpage;
        if ($allpage>1) {
             if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
          $rtn  = "<table cellpadding=\"2\" cellspacing=\"0\"><tr style=\"text-align:center\"><td class=\"smallbody\">";
          if ($stg>1) $rtn .= "<a class=\"nextstage\" href=\"\">&laquo;&laquo;&laquo;</a> | ";
          if ($pg>1) {
            if ($pg==$minpage) {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"dosen/".($stg-1)."/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            } else {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"dosen/$stg/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            }
          }
          for ($i=$minpage;$i<=$maxpage;$i++) {

            if ($i==$pg) {
              $rtn .= "<b>$i</b> | ";
            } else {
                if  ($i==1) {
                 $newoffset = 0;
              }else {
                  $newoffset = ($i-1)*$this->rowperpage;
              }
              $rtn .= "<a href=\"dosen/$stg/$newoffset/pg=".$i."\" title='Page $i'>$i</a> | ";
            }
          }
          if ($pg<=$maxpage) {
            if ($pg==$maxpage && $stg<$allstg) {
              $rtn .= " <a class=\"nextpage\" href=\"dosen/".($stg+1)."/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            } elseif ($pg<$maxpage) {
              $rtn .= " <a class=\"nextpage\" href=\"dosen/$stg/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            }
          }
          if ($stg<$allstg) {
              $rtn .= "<a class=\"nextstage\" href=\"dosen/".($stg+1)."/".(($maxpage)*$this->rowperpage)."/pg=".($maxpage+1)."\"  title='Page $i'> &raquo;&raquo;&raquo;</a> | ";
              }
          $rtn = substr($rtn,0,strlen($rtn)-3);
          $rtn .= "</td></tr></table>";
          return $rtn;
        }
      }
    }
	
	
	
	
	
	
	function getPaging7($jumlah, $pg, $stg, $tagx) {


		$urlxtopik=str_replace(" ", "+", $tagx);
		
		
        if (!isset ($pg,$stg)){
              $pg = 1;
              $stg = 1;
          }
      $qs = '';
      $arr = explode("&",$_SERVER["QUERY_STRING"]);
      if (is_array($arr)) {
        for ($i=0;$i<count($arr);$i++) {
          if (!is_int(strpos($arr[$i],"pg=")) && !is_int(strpos($arr[$i],"stg=")) && !is_int(strpos($arr[$i],"offset="))&& trim($arr[$i]) != "") {
              $qs .= $arr[$i]."&amp;";
          }
        }
      }
      if ($this->rowperpage<$jumlah) {
        $allpage = ceil($jumlah/$this->rowperpage);
        $allstg  = ceil($allpage/$this->pageperstg);
        $minpage = (($stg-1)*$this->pageperstg)+1;
        $maxpage = $stg*$this->pageperstg;
        if ($maxpage>$allpage) $maxpage = $allpage;
        if ($allpage>1) {
             if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
          $rtn  = "<table cellpadding=\"2\" cellspacing=\"0\"><tr style=\"text-align:center\"><td class=\"smallbody\">";
          if ($stg>1) $rtn .= "<a class=\"nextstage\" href=\"\">&laquo;&laquo;&laquo;</a> | ";
          if ($pg>1) {
            if ($pg==$minpage) {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"tags/".$urlxtopik."/".($stg-1)."/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            } else {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"tags/".$urlxtopik."/$stg/".$newoffset."/pg=".($pg-1)."\"  title='Page $i'>&laquo; Previous</a> | ";
            }
          }
          for ($i=$minpage;$i<=$maxpage;$i++) {

            if ($i==$pg) {
              $rtn .= "<b>$i</b> | ";
            } else {
                if  ($i==1) {
                 $newoffset = 0;
              }else {
                  $newoffset = ($i-1)*$this->rowperpage;
              }
              $rtn .= "<a href=\"tags/".$urlxtopik."/$stg/$newoffset/pg=".$i."\" title='Page $i'>$i</a> | ";
            }
          }
          if ($pg<=$maxpage) {
            if ($pg==$maxpage && $stg<$allstg) {
              $rtn .= " <a class=\"nextpage\" href=\"tags/".$urlxtopik."/".($stg+1)."/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            } elseif ($pg<$maxpage) {
              $rtn .= " <a class=\"nextpage\" href=\"tags/".$urlxtopik."/$stg/".(($pg)*$this->rowperpage)."/pg=".($pg+1)."\"  title='Page $i'>Next &raquo;</a> | ";
            }
          }
          if ($stg<$allstg) {
              $rtn .= "<a class=\"nextstage\" href=\"tags/".$urlxtopik."/".($stg+1)."/".(($maxpage)*$this->rowperpage)."/pg=".($maxpage+1)."\"  title='Page $i'> &raquo;&raquo;&raquo;</a> | ";
              }
          $rtn = substr($rtn,0,strlen($rtn)-3);
          $rtn .= "</td></tr></table>";
          return $rtn;
        }
      }
    }
    
	
	
		
	
	
	
	
	    function getPaging($jumlah, $pg, $stg) {
        if (!isset ($pg,$stg)){
              $pg = 1;
              $stg = 1;
          }
      $qs = '';
      $arr = explode("&",$_SERVER["QUERY_STRING"]);
      if (is_array($arr)) {
        for ($i=0;$i<count($arr);$i++) {
          if (!is_int(strpos($arr[$i],"pg=")) && !is_int(strpos($arr[$i],"stg=")) && !is_int(strpos($arr[$i],"offset="))&& trim($arr[$i]) != "") {
              $qs .= $arr[$i]."&amp;";
          }
        }
      }
      if ($this->rowperpage<$jumlah) {
        $allpage = ceil($jumlah/$this->rowperpage);
        $allstg  = ceil($allpage/$this->pageperstg);
        $minpage = (($stg-1)*$this->pageperstg)+1;
        $maxpage = $stg*$this->pageperstg;
        if ($maxpage>$allpage) $maxpage = $allpage;
        if ($allpage>1) {
             if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
          $rtn  = "<table cellpadding=\"2\" cellspacing=\"0\"><tr style=\"text-align:center\"><td class=\"smallbody\">";
          if ($stg>1) $rtn .= "<a class=\"nextstage\" href=\"".$_SERVER["PHP_SELF"]."?".$qs."pg=".($minpage-1)."&amp;stg=".($stg-1). "&amp;offset=". $newoffset ."\">&laquo;&laquo;&laquo;</a> | ";
          if ($pg>1) {
            if ($pg==$minpage) {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"".$_SERVER["PHP_SELF"]."?".$qs."pg=".($pg-1)."&amp;stg=".($stg-1). "&amp;offset=".$newoffset."\">&laquo; Previous</a> | ";
            } else {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn .= "<a class=\"nextpage\" href=\"".$_SERVER["PHP_SELF"]."?".$qs."pg=".($pg-1)."&amp;stg=$stg&amp;offset=".$newoffset."\">&laquo; Previous</a> | ";
            }
          }
          for ($i=$minpage;$i<=$maxpage;$i++) {

            if ($i==$pg) {
              $rtn .= "<b>$i</b> | ";
            } else {
                if  ($i==1) {
                 $newoffset = 0;
              }else {
                  $newoffset = ($i-1)*$this->rowperpage;
              }
              $rtn .= "<a href=\"".$_SERVER["PHP_SELF"]."?".$qs."pg=$i&amp;stg=$stg&amp;offset=$newoffset\" title='Page $i'>$i</a> | ";
            }
          }
          if ($pg<=$maxpage) {
            if ($pg==$maxpage && $stg<$allstg) {
              $rtn .= " <a class=\"nextpage\" href=\"".$_SERVER["PHP_SELF"]."?".$qs."pg=".($pg+1)."&amp;stg=".($stg+1)."&amp;offset=".(($pg)*$this->rowperpage)."\">Next &raquo;</a> | ";
            } elseif ($pg<$maxpage) {
              $rtn .= " <a class=\"nextpage\" href=\"".$_SERVER["PHP_SELF"]."?".$qs."pg=".($pg+1)."&amp;stg=$stg&amp;offset=" .(($pg)*$this->rowperpage). "\">Next &raquo;</a> | ";
            }
          }
          if ($stg<$allstg) {
              $rtn .= "<a class=\"nextstage\" href=\"".$_SERVER["PHP_SELF"]."?".$qs."pg=".($maxpage+1)."&amp;stg=".($stg+1)."&amp;offset=".(($maxpage)*$this->rowperpage)."\"> &raquo;&raquo;&raquo;</a> | ";
              }
          $rtn = substr($rtn,0,strlen($rtn)-3);
          $rtn .= "</td></tr></table>";
          return $rtn;
        }
      }
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
    
     function getPagingajax($jumlah, $pg, $stg) {
        if (!isset ($pg,$stg)){
              $pg = 1;
              $stg = 1;
          }
          $qs = '';
      $arr = explode("&",$_SERVER["QUERY_STRING"]);
      if (is_array($arr)) {
        for ($i=0;$i<count($arr);$i++) {
          if (!is_int(strpos($arr[$i],"pg=")) && !is_int(strpos($arr[$i],"stg=")) && !is_int(strpos($arr[$i],"offset=")) && !is_int(strpos($arr[$i],"math.rand=")) && trim($arr[$i]) != "") {
              $qs .= $arr[$i]."&";
          }
        }
      }
      if ($this->rowperpage<$jumlah) {
        $allpage = ceil($jumlah/$this->rowperpage);
        $allstg  = ceil($allpage/$this->pageperstg);
        $minpage = (($stg-1)*$this->pageperstg)+1;
        $maxpage = $stg*$this->pageperstg;
        if ($maxpage>$allpage) $maxpage = $allpage;
        if ($allpage>1) {
             if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
          $rtn  = array ();
          
          if ($stg>1) {
	          $rtn[] = array('link'=>"".$qs."pg=".($minpage-1)."&stg=".($stg-1). "&offset=". $newoffset,'title'=>'&laquo;&laquo;&laquo;');
      			}
          if ($pg>1) {
            if ($pg==$minpage) {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn[] = array ('link'=>"".$qs."pg=".($pg-1)."&stg=".($stg-1). "&offset=".$newoffset,'title'=>'&laquo; Previous');
            } else {
                if (($pg-1) == 1){
                    $newoffset = 0;

                } else {
                   $newoffset = (($pg-2)*$this->rowperpage);
                }
              $rtn[] = array('link'=>"".$qs."pg=".($pg-1)."&stg=$stg&offset=".$newoffset,'title'=>'&laquo; Previous');
            }
          }
          for ($i=$minpage;$i<=$maxpage;$i++) {

            if ($i==$pg) {
              $rtn[] = array('link'=>'','title'=>'<b>'.$i.'</b>');
            } else {
                if  ($i==1) {
                 $newoffset = 0;
              }else {
                  $newoffset = ($i-1)*$this->rowperpage;
              }
              $rtn[] = array('link'=>"".$qs."pg=$i&stg=$stg&offset=$newoffset",'title'=>$i);
            }
          }
          if ($pg<=$maxpage) {
            if ($pg==$maxpage && $stg<$allstg) {
              $rtn[] = array('link'=>"".$qs."pg=".($pg+1)."&stg=".($stg+1)."&offset=".(($pg)*$this->rowperpage),'title'=>'Next &raquo;');
            } elseif ($pg<$maxpage) {
              $rtn[] = array('link'=>"".$qs."pg=".($pg+1)."&stg=$stg&offset=" .(($pg)*$this->rowperpage),'title'=>'Next &raquo;');
            }
          }
          if ($stg<$allstg) {
              $rtn[] = array('link'=>"".$qs."pg=".($maxpage+1)."&stg=".($stg+1)."&offset=".(($maxpage)*$this->rowperpage),'title'=>'&raquo;&raquo;&raquo;');
              }
         // $rtn = substr($rtn,0,strlen($rtn)-3);
         
          return $rtn;
        }
      }
    }
    
    
    
  }

function cleanText ($text,$html=true) {
        $text = preg_replace( "'<script[^>]*>.*?</script>'si", '', $text );
        $text = preg_replace( '/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $text );
        $text = preg_replace( '/<!--.+?-->/', '', $text );
        $text = preg_replace( '/{.+?}/', '', $text );
        $text = preg_replace( '/&nbsp;/', ' ', $text );
        $text = preg_replace( '/&amp;/', ' ', $text );
        $text = preg_replace( '/&quot;/', ' ', $text );
        $text = strip_tags( $text );
        $text = preg_replace("/\r\n\r\n\r\n+/", " ", $text);
        $text = $html ? htmlspecialchars( $text ) : $text;
        return $text;
}

function validate_url($url) {
   return preg_match("/(((ht|f)tps*:\/\/)*)((([a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3}))|(([0-9]{1,3}\.){3}([0-9]{1,3})))((\/|\?)[a-z0-9~#%&'_\+=:\?\.-]*)*)$/", $url);
}

function int_filter ($nama){
//memfilter karakter alpa menjadi kosong
if (is_numeric ($nama)){
return (int)preg_replace ( '/\D/i', '', $nama);
}
else {
    $nama = ltrim($nama, ';');
    $nama = explode (';', $nama);
    return (int)preg_replace ( '/\D/i', '', $nama[0]);
}
}

function cms_login (){
global $UserName,$Expire,$koneksi_db;

$user          = $_POST['username'];
$password      = md5($_POST['password']);
$query         = $koneksi_db->sql_query ("SELECT user,password,level,email FROM pengguna WHERE user='$user' AND password='$password' AND tipe='aktif' AND level='User' OR  user='$user' AND password='$password' AND tipe='aktif' AND level='Editor' ");
$total         = $koneksi_db->sql_numrows($query);
$data          = $koneksi_db->sql_fetchrow ($query);


$koneksi_db->sql_freeresult ($query);
if ($total > 0 && $user == $data['user'] && $password == $data['password']){

$_SESSION['UserName']= $data['user'];
$_SESSION['LevelAkses']= $data['level'];
$_SESSION['UserEmail']= $data['email'];
if($_SESSION['LevelAkses']=="Administrator"){
header ("location:admin.php");
exit;
}else{
header ("location:index.php");
exit;
}

}else {
return '<div class="error" style="width:96%">Username atau Password Salah</div>';
}

}
function cms_loginadmin (){
global $UserName,$Expire,$koneksi_db;

$user          = $_POST['username'];
$password      = md5($_POST['password']);
$query         = $koneksi_db->sql_query ("SELECT user,password,level,email FROM pengguna WHERE user='$user' AND password='$password' AND tipe='aktif' AND level='Administrator'");
$total         = $koneksi_db->sql_numrows($query);
$data          = $koneksi_db->sql_fetchrow ($query);


$koneksi_db->sql_freeresult ($query);
if ($total > 0 && $user == $data['user'] && $password == $data['password']){

$_SESSION['UserName']= $data['user'];
$_SESSION['LevelAkses']= $data['level'];
$_SESSION['UserEmail']= $data['email'];
if($_SESSION['LevelAkses']=="Administrator"){
header ("location:admin.php");
exit;
}else{
header ("location:index.php");
exit;
}

}else {
return '<div class="error" style="width:96%">Username atau Password Salah</div>';
}

}
function cek_login (){
    global $UserName,$Expire;

    if (isset ($_SESSION['UserName']) && !empty ($_SESSION['UserName'])){
    return true;
    }else {
        return false;
    }
}

function logout (){
$_SESSION['UserID']= '';
$_SESSION['UserName']= '';
$_SESSION['LevelAkses']= '';
$_SESSION['UserEmail']= '';

header ("location:index.php");
    exit;

}

function limitTXT ($nama, $limit){
    if (strlen ($nama) > $limit) {
    $nama = substr($nama, 0, $limit) .'...';
    }else {
        $nama = $nama;
    }
return $nama;
}


function limitTXT2 ($nama, $limit){
    if (strlen ($nama) > $limit) {
    $nama = substr($nama, 0, $limit) .'';
    }else {
        $nama = $nama;
    }
return $nama;
}

function inisialpage($pagenumber){

	$rowsPerPage = $pagenumber;
	$pageNum = 1;
	if(isset($_GET['page']))
	{
		$pageNum = $_GET['page'];
	}
	$offset = ($pageNum - 1) * $rowsPerPage;
	if($offset<0) { $offset=0;}
	return $offset;

}

function showpage($fieldname,$tablename,$links,$pagenumber){
global $koneksi_db;
	$rowsPerPage = $pagenumber;
	$pageNum = 1;
	if($_GET['page']!="")
	{
		$pageNum = $_GET['page'];
	}
	$que=$koneksi_db->sql_query("SELECT COUNT(".$fieldname.") as numrows FROM ".$tablename);
	$rs=$koneksi_db->sql_fetchrow($que);
	$numrows = $rs['numrows'];
	$maxPage = ceil($numrows/$rowsPerPage);
	$self = $_SERVER['PHP_SELF'];
	if ($pageNum > 1)
	{
		$page = $pageNum - 1;
		$prev = " <a href=\"$self?".$links."&page=$page\"><</a> ";

		$first = " <a href=\"$self?".$links."&page=1\"><<</a> ";
	}
	else
	{
		$prev  = ' < ';
		$first = ' << ';
	}
	if ($pageNum < $maxPage)
	{
		$page = $pageNum + 1;
		$next = " <a href=\"$self?".$links."&page=$page\">></a> ";

		$last = " <a href=\"$self?".$links."&page=$maxPage\">>></a> ";
	}
	else
	{
		$next = ' > ';
		$last = ' >> ';
	}
	return $first . $prev . " <strong>$pageNum</strong> : <strong>$maxPage</strong> " . $next . $last;
}

function sensor($str){
global $koneksi_db;
$cek =$koneksi_db->sql_query ("SELECT `word` FROM `sensor`");
while ($data = $koneksi_db->sql_fetchrow($cek)){
$badwords[]	= "/".$data['word']."/i";
}
return preg_replace($badwords, "Be blocked, cms.com", $str);
}

function datetimes($tgl,$Jam=true){
/*Contoh Format : 2007-08-15 01:27:45*/
$tanggal = strtotime($tgl);
$bln_array = array (
			'01'=>'Januari',
			'02'=>'Februari',
			'03'=>'Maret',
			'04'=>'April',
			'05'=>'Mei',
			'06'=>'Juni',
			'07'=>'Juli',
			'08'=>'Agustus',
			'09'=>'September',
			'10'=>'Oktober',
			'11'=>'November',
			'12'=>'Desember'
			);
$hari_arr = Array ('0'=>'Minggu',
				   '1'=>'Senin',
				   '2'=>'Selasa',
					'3'=>'Rabu',
					'4'=>'Kamis',
					'5'=>'Jum`at',
					'6'=>'Sabtu'
				   );
$hari = @$hari_arr[date('w',$tanggal)];
$tggl = date('j',$tanggal);
$bln = @$bln_array[date('m',$tanggal)];
$thn = date('Y',$tanggal);
$jam = $Jam ? date ('H:i:s',$tanggal) : '';
return "$hari, $tggl $bln $thn";			
}



function datetimess($tgl,$Jam=true){
/*Contoh Format : 2007-08-15 01:27:45*/
$tanggal = strtotime($tgl);
$bln_array = array (
			'01' => 'Januari',
'02' => 'Februari',
'03' => 'Maret',
'04' => 'April',
'05' => 'Mei',
'06' => 'Juni',
'07' => 'Juli',
'08' => 'Agustus',
'09' => 'September',
'10' => 'Oktober',
'11' => 'November',
'12' => 'Desember'
			);
$hari_arr = Array ('0' => 'Sunday',
'1' => 'Monday',
'2' => 'Tuesday',
'3' => 'Wednesday',
'4' => 'Thursday',
'5' => 'Friday',
'6' => 'Saturday'
				   );
$hari = @$hari_arr[date('w',$tanggal)];
$tggl = date('j',$tanggal);
$bln = @$bln_array[date('m',$tanggal)];
$thn = date('Y',$tanggal);
$jam = $Jam ? date ('H:i:s',$tanggal) : '';
return "$tggl $bln $thn";			
}




function dbd($tgl,$Jam=true){
/*Contoh Format : 2007-08-15 01:27:45*/
$tanggal = strtotime($tgl);
$bln_array = array (
			'01' => 'January',
'02' => 'February',
'03' => 'March',
'04' => 'April',
'05' => 'May',
'06' => 'June',
'07' => 'July',
'08' => 'August',
'09' => 'September',
'10' => 'October',
'11' => 'November',
'12' => 'December'
			);
$hari_arr = Array ('0' => 'Sunday',
'1' => 'Monday',
'2' => 'Tuesday',
'3' => 'Wednesday',
'4' => 'Thursday',
'5' => 'Friday',
'6' => 'Saturday'
				   );
$hari = @$hari_arr[date('w',$tanggal)];
$tggl = date('j',$tanggal);
$bln = @$bln_array[date('m',$tanggal)];
$thn = date('Y',$tanggal);
$jam = $Jam ? date ('H:i:s',$tanggal) : '';
return "$tggl";			
}

function dbm($tgl,$Jam=true){
/*Contoh Format : 2007-08-15 01:27:45*/
$tanggal = strtotime($tgl);
$bln_array = array (
			'01' => 'January',
'02' => 'February',
'03' => 'March',
'04' => 'April',
'05' => 'May',
'06' => 'June',
'07' => 'July',
'08' => 'August',
'09' => 'September',
'10' => 'October',
'11' => 'November',
'12' => 'December'
			);
$hari_arr = Array ('0' => 'Sunday',
'1' => 'Monday',
'2' => 'Tuesday',
'3' => 'Wednesday',
'4' => 'Thursday',
'5' => 'Friday',
'6' => 'Saturday'
				   );
$hari = @$hari_arr[date('w',$tanggal)];
$tggl = date('j',$tanggal);
$bln = date('M',$tanggal);
$thn = date('Y',$tanggal);
$jam = $Jam ? date ('H:i:s',$tanggal) : '';
return "$bln";			
}



function menu_tabs ($link,$url){
/*
$path = "/home/httpd/html/index.php?id=ad";
echo $file = basename($path);        // $file is set to "index.php"
*/	


$data = '<DIV id="tabsB"><UL>';
if (is_array ($link)){
	foreach ($link as $key=>$value){
		parse_str(str_replace ('&amp;','&',$value),$output);
		if (@$output['action'] == $url){
		$data .= '<LI id="current"><A href="'.$value.'"><SPAN>'.$key.'</SPAN></A></LI>';
			}else {
				$data .= '<LI><A href="'.$value.'"><SPAN>'.$key.'</SPAN></A></LI>';
				  }
	}
  
}  
$data .= '</UL></DIV>
<br>
';	
return $data;	
}


function input_text ($name,$value,$type='text',$size=33,$opt=''){
	global $_input;
	$value = cleantext(stripslashes($value));

	//$focus =  ' onblur="this.style.color=\'#6A8FB1\'; this.className=\'\'" onfocus="this.style.color=\'#FB6101\'; this.className=\'inputfocus\'"';
return '<input type="'.$type.'" name="'.$name.'" size="'.$size.'" '.@$_input[$name].' value="'.$value.'"'.$opt.' required/>';	
}

function input_alert($name){
	global $_input;
$_input[$name] = ' class="inputfocus_alert"';	
}

function js_cek ($form,$name){
	
$content = '<script language="javascript" type="text/javascript">
function cek(){
';

/**
if (document.input_siswa.judul.value=="") {
alert("Judul agendanya apa?");
document.input_siswa.judul.focus();
return false
}
**/

if (is_array ($name)){
	
foreach ($name as $k=>$v){
	
$content .= '
if (document.'.$form.'.'.$k.'.value=="") {
alert("'.$v.'");
document.'.$form.'.'.$k.'.focus();
return false
}

';	
	
}	
	
	
	
}


$content .= '
return true
}
</script>';
return $content;
}

function input_textarea ($name,$value,$rows=2,$cols=36,$opt){
	global $_input;
	$_POST = !isset ($_POST) ? array() : $_POST;
	$focus = count($_POST) <= 0 ? ' onblur="this.style.color=\'#6A8FB1\'; this.className=\'\'" onfocus="this.style.color=\'#FB6101\'; this.className=\'inputfocus\'"' : '';
$value = stripslashes($value);	
return '<textarea rows="'.$rows.'" name="'.$name.'" '.@$_input[$name].$focus.' cols="'.$cols.'"'.$opt.'>'.$value.'</textarea>';;	
}

function converttgl ($date){
$bln_array = array ('01'=>'Januari',
			'02'=>'Februari',
			'03'=>'Maret',
			'04'=>'April',
			'05'=>'Mei',
			'06'=>'Juni',
			'07'=>'Juli',
			'08'=>'Agustus',
			'09'=>'September',
			'10'=>'Oktober',
			'11'=>'November',
			'12'=>'Desember'
			);
$date = explode ('-',$date);

return $date[2] . ' ' . $bln_array[$date[1]] . ' ' . $date[0];			
				
}



function referer_encode (){
return base64_encode(basename($_SERVER['PHP_SELF']) .'?'. $_SERVER['QUERY_STRING']);
}

function referer_decode ($url){
return base64_decode($url);	
}

function extension($file)
{
    $pos = strrpos($file,'.');
    if(!$pos)
        return 'Unknown';
    $str = substr($file, $pos, strlen($file));
    return strtolower ($str);
}

function bukafile($filename){
$fp = @fopen($filename, "r");
$sizeof = (@filesize($filename) == 0) ? 1 : filesize($filename);
return @fread($fp, $sizeof);
	fclose($fp);
} 
##------ End Fungsi

##------ Fungsi Tulis file
function tulisfile ($filename , $nilai){
$file = fopen ($filename, "w+");
return fwrite ($file,$nilai);
fclose($file);	
}

function alttxt ($html){
$data = str_replace ('"','&quot;',$html);
//$data = str_replace ("'","\'",$data);
$data = addslashes ($data);
$data = preg_replace ('/([\r\n])[\s]+/', '<br>',wordwrap($data,35,' ',1));
return $data;
}



function is_valid_email($mail) {
	// checks email address for correct pattern
	// simple: 	"/^[-_a-z0-9]+(\.[-_a-z0-9]+)*@[-a-z0-9]+(\.[-a-z0-9]+)*\.[a-z]{2,6}$/i"
	$r = 0;
	if($mail) {
		$p  =	"/^[-_a-z0-9]+(\.[-_a-z0-9]+)*@[-a-z0-9]+(\.[-a-z0-9]+)*\.(";
		// TLD  (01-30-2004)
		$p .=	"com|edu|gov|int|mil|net|org|aero|biz|coop|info|museum|name|pro|arpa";
		// ccTLD (01-30-2004)
		$p .=	"ac|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|az|ba|bb|bd|";
		$p .=	"be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|";
		$p .=	"cg|ch|ci|ck|cl|cm|cn|co|cr|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|";
		$p .=	"ec|ee|eg|eh|er|es|et|fi|fj|fk|fm|fo|fr|ga|gd|ge|gf|gg|gh|gi|";
		$p .=	"gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|";
		$p .=	"im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|";
		$p .=	"ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mk|ml|";
		$p .=	"mm|mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|";
		$p .=	"nl|no|np|nr|nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|";
		$p .=	"py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|";
		$p .=	"sr|st|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|";
		$p .=	"tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|";
		$p .=	"za|zm|zw";
		$p .=	")$/i";

		$r = preg_match($p, $mail) ? 1 : 0;
	}
	return $r;
}
function cek_ip ($check) {
$bytes = explode('.', $check);
		if (count($bytes) == 4 or count($bytes) == 6) {
			$returnValue = true;
			foreach ($bytes as $byte) {
				if (!(is_numeric($byte) && $byte >= 0 && $byte <= 255)) {
					$returnValue = false;
				}
			}
			return $returnValue;
		}
		return false;
}
function getIP(){
$banned = array ('127.0.0.1', '192.168', '10');
$ip_adr = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$bool = false;
foreach ($banned as $key=>$val){
//if (preg_match("$val",$ip_adr)){
if (preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', getenv("HTTP_X_FORWARDED_FOR")) == ''){
$bool = true;
break;
}
}
if (empty($ip_adr) or $bool or !cek_ip($ip_adr)){
$ip_adr = @$_SERVER['REMOTE_ADDR'];	
}
return $ip_adr; 	
}

function posted($filename,$menit = 10){
//$file = basename($_SERVER['PHP_SELF']);
global $koneksi_db;
$file = $filename;
$IP = getIP();
$waktu = time() + 60 * $menit;
$in = $koneksi_db->sql_query ("INSERT INTO `posted_ip` (`file`,`ip`,`time`) VALUES ('$file','$IP','$waktu')");
}
function cek_posted($filename){
global $koneksi_db;
$delete = $koneksi_db->sql_query ("DELETE FROM `posted_ip` WHERE `time` < '".time()."'");
$cek = $koneksi_db->sql_query ("SELECT COUNT(`ip`) AS IP FROM `posted_ip` WHERE `ip` = '".getIP()."' AND `file` = '".$filename."' AND `time` > '".time()."'");
$total = $koneksi_db->sql_fetchrow($cek);
if ($total['IP'] >= 1){
return true;	
}else {
return false;	
}
}

function cleartext($txt) {
return preg_replace('/[!"\#\$%\'\(\)\?@\[\]\^`\{\}~\*\/]/', '', $txt);
}

function utf2html (&$str) {
    
    $ret = "";
    $max = strlen($str);
    $last = 0;  // keeps the index of the last regular character
    for ($i=0; $i<$max; $i++) {
        $c = $str{$i};
        $c1 = ord($c);
        if ($c1>>5 == 6) {  // 110x xxxx, 110 prefix for 2 bytes unicode
            $ret .= substr($str, $last, $i-$last); // append all the regular characters we've passed
            $c1 &= 31; // remove the 3 bit two bytes prefix
            $c2 = ord($str{++$i}); // the next byte
            $c2 &= 63;  // remove the 2 bit trailing byte prefix
            $c2 |= (($c1 & 3) << 6); // last 2 bits of c1 become first 2 of c2
            $c1 >>= 2; // c1 shifts 2 to the right
            $ret .= "&#" . ($c1 * 0x100 + $c2) . ";"; // this is the fastest string concatenation
            $last = $i+1;       
        }
        elseif ($c1>>4 == 14) {  // 1110 xxxx, 110 prefix for 3 bytes unicode
            $ret .= substr($str, $last, $i-$last); // append all the regular characters we've passed
            $c2 = ord($str{++$i}); // the next byte
            $c3 = ord($str{++$i}); // the third byte
            $c1 &= 15; // remove the 4 bit three bytes prefix
            $c2 &= 63;  // remove the 2 bit trailing byte prefix
            $c3 &= 63;  // remove the 2 bit trailing byte prefix
            $c3 |= (($c2 & 3) << 6); // last 2 bits of c2 become first 2 of c3
            $c2 >>=2; //c2 shifts 2 to the right
            $c2 |= (($c1 & 15) << 4); // last 4 bits of c1 become first 4 of c2
            $c1 >>= 4; // c1 shifts 4 to the right
            $ret .= '&#' . (($c1 * 0x10000) + ($c2 * 0x100) + $c3) . ';'; // this is the fastest string concatenation
            $last = $i+1;       
        }
    }
    $str=$ret . substr($str, $last, $i); // append the last batch of regular characters
    return $str;
}

function decodeURIComponent($str){
//return utf2html(rawurldecode($str));
return $str;
}

function wraptext($konten,$panjang=30){
$data_konten = explode (' ',$konten);	
$TMPmsg = array ();
        for ($i=0; $i<count($data_konten); $i++){
                if (strlen($data_konten[$i]) >= $panjang) {
                    $TMPmsg[] = wordwrap($data_konten[$i], $panjang, " <br />", TRUE);
                }else {
                	$TMPmsg[] = $data_konten[$i];
            		}
        }	
return implode (" ",$TMPmsg);	
}

function stripWhitespace($str) {
		$r = preg_replace('/[\n\r\t]+/', '', $str);
		return preg_replace('/\s{2,}/', ' ', $r);
	}
function stripImages($str) {
		$str = preg_replace('/(<a[^>]*>)(<img[^>]+alt=")([^"]*)("[^>]*>)(<\/a>)/i', '$1$3$5<br />', $str);
		$str = preg_replace('/(<img[^>]+alt=")([^"]*)("[^>]*>)/i', '$2<br />', $str);
		$str = preg_replace('/<img[^>]*>/i', '', $str);
		return $str;
	}
function stripScripts($str) {
		return preg_replace('/(<link[^>]+rel="[^"]*stylesheet"[^>]*>|<img[^>]*>|style="[^"]*")|<script[^>]*>.*?<\/script>|<style[^>]*>.*?<\/style>|<!--.*?-->/i', '', $str);
	}


?>