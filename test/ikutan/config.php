<?php


define('cms-FUNGSI', true);
error_reporting(0);


$mysql_host = 'localhost';
$mysql_user = 'iais9713_pmbonlineadmin';
$mysql_password = '@Administartor12';
$mysql_database = 'iais9713_pmbonline';



$translateKal = array(	'Mon' => 'Senin',
						'Tue' => 'Selasa',
						'Wed' => 'Rabu',
						'Thu' => 'Kamis',
						'Fri' => 'Jumat',
						'Sat' => 'Sabtu',
						'Sun' => 'Minggu',
						'Jan' => 'Januari',
						'Feb' => 'Februari',
						'Mar' => 'Maret',
						'Apr' => 'April',
						'May' => 'Mei',
						'Jun' => 'Juni',
						'Jul' => 'Juli',
						'Aug' => 'Agustus',
						'Sep' => 'September',
						'Oct' => 'Oktober',
						'Nov' => 'Nopember',
						'Dec' => 'Desember');


if (file_exists('ikutan/fungsi.php')){
	include 'ikutan/fungsi.php';
}

if (substr(phpversion(),0,3) >= 5.1) {
date_default_timezone_set('Asia/Jakarta');
}

 $koneksi = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);
 if(mysqli_connect_errno()){
  echo "";
 }
 
    $query = "SELECT * FROM tb_setting";
    $result = mysqli_query($koneksi, $query);
    while ($row = mysqli_fetch_array($result)) {
  
    $email_master=$row['Email_Admin'];
 
    $judul_situs=$row['Web_Title'];
    $url_situs=$row['Url_Situs'];
  
    $adminfile = 'admin';


    $_META['description'] =$row['Meta_Desc'];
    $_META['keywords'] =$row['Meta_Key'];


    }

?>
