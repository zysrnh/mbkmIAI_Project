<?php

include '../../ikutan/session.php';
include '../../ikutan/config.php';
include '../../ikutan/fungsi.php';
include '../../ikutan/mysqli.php';


if (!cek_login ()){
  echo 'error.. login kembali';
   exit;
}else{

if (  $_SESSION['LevelAkses']=="Administrator"){

if (isset ($_GET['id'])){
$pid = int_filter($_GET['id']);	
$query = $koneksi_db->sql_query("DELETE FROM `polling` WHERE `pid`='$pid'");	
if ($query) echo '';
else {echo 'Data Gagal Didelete';
echo '<br>'.mysqli_error();
}
}
}else{
echo 'Secure by Klaten WEB.com';
}

}

?>