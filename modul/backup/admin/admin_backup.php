<h4>Backup dan Restore Data</h4><br/><p>

<?php

require_once('ikutan/mysql_backup_import.php');
require_once('ikutan/config.php');


if(isset($_REQUEST['backup'])){


//$dir  = dirname(__FILE__); // directory files
$dir  = 'files/'; // directory files
$name = 'backup'; // name sql backup
$message=backup_database( $dir, $name, $mysql_host,$mysql_user,$mysql_password,$mysql_database) ; // execute

echo "Download file <a href='files/".$message."' target='_blank'>Database </a><br/>";


}
if(isset($_REQUEST['restore'])){

$filename = $_FILES['filedata']['name'];
$uploadedfile = $_FILES['filedata']['tmp_name'];
$actual_name = time().".sql";
$sementara = "files/$actual_name";
if(move_uploaded_file($uploadedfile, $sementara)){

$f = fopen($sementara, 'r');
$isi = fread($f, filesize($sementara));
fclose($f);
$data = explode(";\n", $isi);
 	
	foreach (explode(";", $isi) as $key=>$sql) {
		$sql = trim($sql);
		if ($sql) {
 			$koneksi_db->sql_query($sql);
			 //echo $sql.'<hr/>';
 		}
	}
	echo '<div class="alert  alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Informasi ! </strong>proses Restoer data berhasil...</div>'; 
  	
	/// berhasil
 @unlink ($sementara);
/*
	$file = $sementara; // sql data file
	$args = file_get_contents($file); // get contents
	$message=mysqli_import_sql( $args, $mysql_host,$mysql_user,$mysql_password,$mysql_database ); // execute
	echo $message;
	//if ($message) @unlink ($sementara);
*/	
}	
}

?> 




<table align="left"><tr>
<form method='post' enctype="multipart/form-data">
<td>
<input type="submit"  name="backup" value="Backup Data"> 
</td>
</tr>
<tr>
<td>
<input type="file" name="filedata" id="filedata" class="fileInput" />
<input type="submit" name="restore" value="Restore Data">

</td><td>

</form></td></tr></table>
