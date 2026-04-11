<h4>Form Import FCL</h4><br/><p>

<?php








switch (@$_GET['action']){

	
default:



if (isset ($_POST['submit'])){
	



$nama= cleantext($_POST['nama']);
$email = cleantext($_POST['email']);
$telp= cleantext($_POST['telp']);

$barang= cleantext($_POST['barang']);
$harga= cleantext($_POST['harga']);
$mata= cleantext($_POST['mata']);
$asal= cleantext($_POST['asal']);
$tujuan= cleantext($_POST['tujuan']);
$jumlah= cleantext($_POST['jumlah']);
$fit= cleantext($_POST['fit']);


$ket = $_POST['ket'];

$tanggal= date('Y-m-d');

$image_name		=$_FILES['image']['name'];
$image_size		=$_FILES['image']['size'];
$image_type		=$_FILES['image']['type'];


$image_name2		=$_FILES['image2']['name'];
$image_size2		=$_FILES['image2']['size'];
$image_type2		=$_FILES['image2']['type'];


$url=str_replace(" ", "-", $barang);

	$maxsize    = 1000000;
	
	





if ($image_size2 >= $maxsize){ 	
	
	 $error .= '- Ukuran doc import terlalu besar, jangan melebihi 1 MB<br />';
}
else {
	
	
}


if (!$image_name2){
	$foto	="na.jpg";
	
} else {
	
	$foto2	="2-$tanggal-$url.jpg";

$check = getimagesize($_FILES['image2']['tmp_name']);

if($check !== false) {
	
   
    $uploadOk = 1;
	

	
} else {
  $error .= '- Ini bukan foto<br />';
    $uploadOk = 0;
}

}






	
	
if ($image_size >= $maxsize){ 	
	
	 $error .= '- Ukuran foto terlalu besar, jangan melebihi 1 MB<br />';
}
else {
	
	
}


if (!$image_name){
	$foto	="na.jpg";
	
} else {
	
	$foto	="$tanggal-$url.jpg";

$check = getimagesize($_FILES['image']['tmp_name']);

if($check !== false) {
	
   
    $uploadOk = 1;
	

	
} else {
  $error .= '- Ini bukan foto<br />';
    $uploadOk = 0;
}

}

//$password = base64_encode($nama);
	if ($error != ''){
$content .= '<div class="error">'.$error.'</div>';

}else {
	$insert = $koneksi_db->sql_query ("INSERT INTO `mod_data_fcl` (`nama`,
`email`,
`telp`,
`barang`,
`harga`,
`mata`,
`asal`,
`tujuan`,
`jumlah`,
`fit`,
`foto`,`foto2`,
`ket`,`tanggal`) VALUES ('$nama',
'$email',
'$telp',
'$barang',
'$harga',
'$mata',
'$asal',
'$tujuan',
'$jumlah',
'$fit',
'$foto','$foto2',
'$ket','$tanggal')");
	if ($insert) {
		if (!$image_name){
			
		} else {
			
				$url=str_replace(" ", "-", $barang);
		copy($_FILES['image']['tmp_name'], "./images/fcl/".$tanggal."-".$url.".jpg");
			
		}
		
	if (!$image_name2){
			
		} else {
			
				$url=str_replace(" ", "-", $barang);
		copy($_FILES['image2']['tmp_name'], "./images/fcl/2-".$tanggal."-".$url.".jpg");
			
		}

		
		
		
		
	$subject = "$judul_situs - Form Order LCL";
$msg = "
$judul_situs - Form Order Baru





$nama<br />
$email<br />
$telp<br /><br />
$barang, $mata $harga<br /><br />

$asal ke $tujuan<br />
<br />
Jumlah Kontainer $jumlah $fit<br /><br />
$ket<br /><br />
$tanggal

";
	    mail_send('latieful.amin@gmail.com', 'latieful.amin@gmail.com', $subject, $msg, 1, 1);
	    Posted('contact');		
		
				
		
		
		
		
		
		
		
		
		
		
		
		$content .= '<div class="sukses">Order berhasil dimasukkan, akan kami hubungi secepatnya.</div>';
		posted('alumni');
		unset ($_POST);
		}
	else {
		$content .= '<div class=error>Data Gagal Dimasukkan<br>'.mysqli_error().'</div>';
		if (eregi ($no_induk,mysqli_error())) {
			input_alert('no_induk');
		}
		
		
		}
	
}	
	
	
	
	
}



$content .= '
<form method="POST" action="" enctype="multipart/form-data" name="input_siswa">
<table width=100%>

<tr>
<td>Nama</td>
<td>:</td>
<td>'.input_text ('nama',@$_POST['nama']).'</td>
</tr>

<tr>
<td>Email</td>
<td>:</td>
<td>'.input_text ('email',@$_POST['email']).'</td>
</tr>

<tr>
<td>No. Telp.</td>
<td>:</td>
<td>'.input_text ('telp',@$_POST['telp']).'</td>
</tr>

<tr>
<td>Nama Barang/HS Code</td>
<td>:</td>
<td>'.input_text ('barang',@$_POST['barang']).'</td>
</tr>
<tr>
<td>Harga Barang/Nilai Invoice</td>
<td>:</td>
<td><select name="mata" required>
<option value="RP">RP</option>
<option value="USD">USD</option>
</select>
 <input type="text" name="harga" required size="22"></td>
</tr>


<tr>
<td>Kota dan Negara Asal Barang</td>
<td>:</td>
<td>'.input_text ('asal',@$_POST['asal']).'</td>
</tr>

<tr>
<td>Kota Tujuan Indonesia</td>
<td>:</td>
<td>'.input_text ('tujuan',@$_POST['tujuan']).'</td>
</tr>
<tr>
<td>Jumlah Kontainer</td>
<td>:</td>
<td><input type="text" name="jumlah" required size="22"> <select name="fit" required>
<option value="20`">20`</option>
<option value="40`">40`</option>
<option value="20FT">20FT</option>
<option value="40FT">40FT`</option>
</select>
 </td>
</tr>


<tr>
<td>Doc Import (Performa Invoice/Packing List/DLL)</td>
<td>:</td>
<td><input name="image2" type="file" /></td>
</tr>


<tr>
<td>Foto Barang</td>
<td>:</td>
<td><input name="image" type="file" /></td>
</tr>



<tr>
<td>Pertanyaan/Keterangan</td>
<td>:</td>
<td>'.input_textarea2 ('ket',@$_POST['ket']).'</td>
</tr>


<tr>
<td></td>
<td></td>
<td><input type="submit"  name="submit" value="Order"></td>
</tr>

</table>
</form>
';



break;	
	
	

	


}














/////////////
echo $content;

?>