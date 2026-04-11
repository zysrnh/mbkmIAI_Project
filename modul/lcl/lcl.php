<h4>Form Import LCL</h4><br/><p>

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
$berat= cleantext($_POST['berat']);
$volume= cleantext($_POST['volume']);
$p= cleantext($_POST['p']);
$l= cleantext($_POST['l']);
$t= cleantext($_POST['t']);

$ket = $_POST['ket'];

$tanggal= date('Y-m-d');

$image_name		=$_FILES['image']['name'];
$image_size		=$_FILES['image']['size'];
$image_type		=$_FILES['image']['type'];
$url=str_replace(" ", "-", $barang);

	$maxsize    = 1000000;
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
	$insert = $koneksi_db->sql_query ("INSERT INTO `mod_data_lcl` (`nama`,
`email`,
`telp`,
`barang`,
`harga`,
`mata`,
`asal`,
`tujuan`,
`berat`,
`volume`,
`p`,
`l`,
`t`,
`foto`,
`ket`,`tanggal`) VALUES ('$nama',
'$email',
'$telp',
'$barang',
'$harga',
'$mata',
'$asal',
'$tujuan',
'$berat',
'$volume',
'$p',
'$l',
'$t',
'$foto',
'$ket','$tanggal')");
	if ($insert) {
		if (!$image_name){
			
		} else {
			
				$url=str_replace(" ", "-", $barang);
		copy($_FILES['image']['tmp_name'], "./images/lcl/".$tanggal."-".$url.".jpg");
			
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
$berat Kg<br />
$volume M3 (CBM)
($p x $l x $t)<br /><br />
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
<td>Berat Barang (Kg)</td>
<td>:</td>
<td>'.input_text ('berat',@$_POST['berat']).'</td>
</tr>
<tr>
<td>Volume M3(CBM)</td>
<td>:</td>
<td>'.input_text ('volume',@$_POST['volume']).'</td>
</tr>
<tr>
<td>Dimensi Barang</td>
<td>:</td>
<td><input type="text" name="p" placeholder="Panjang" required size="5">
<input type="text" name="l" placeholder="Lebar" required size="5">
<input type="text" name="t" placeholder="Tinggi" required size="5">
</td>
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