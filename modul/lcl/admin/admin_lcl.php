<h4>Form Import LCL</h4><br/><p>
<a href="admin.php?pilih=lcl&amp;modul=yes">List Data</a> | 
<a href="admin.php?pilih=lcl&amp;modul=yes&amp;action=cari">Cari Data</a>
<?php




if (!defined('cms-ADMINISTRATOR')) {
	Header("Location: ../index.php");
	exit;
}

if (!cek_login()){
    warning("Akses dihentikan, silahkan login terlebih dahulu","index.php", 3, 2);
    exit;
}

$index_hal = 1;
$content='';
$tampil='';
$no=0;
include 'modul/functions.php';



$_GET['str'] = isset($_GET['str']) ? $_GET['str'] : null;
$_GET['sort'] = isset($_GET['sort']) ? $_GET['sort'] : NULL;
$_GET['order'] = isset($_GET['order']) ? $_GET['order'] : NULL;

$sort_url_orderby = $_GET['sort'] == 'asc' ? 'dsc' : 'asc';

function sortorder($sort_url_orderby,$field,$nama){
//order name
$qs = '';
	
 $arr = explode("&",$_SERVER["QUERY_STRING"]);
      
      if (is_array($arr)) {
        for ($i=0;$i<count($arr);$i++) {
          if (!is_int(strpos($arr[$i],"sort=")) && !is_int(strpos($arr[$i],"order=")) && trim($arr[$i]) != "") {
	          list ($kunci,$isi) = explode ('=',$arr[$i]);
	          $isi = urldecode($isi);
	          $isi = urlencode ($isi);
	          
              $qs .= $kunci . '=' . $isi ."&amp;";
          }
        }
      }	
	



$sort_url_name = '<a title="Sort Berdasarkan '.$nama.'" href="?'.$qs.'&amp;sort='.$sort_url_orderby.'&amp;order='.$field.'">'.$nama.'</a>';
$sort_url_name_img = '';
if (isset($_GET['sort']) && $_GET['order'] == $field){
$sort_url_name_img = $_GET['sort'] == 'asc' ? '&nbsp;<IMG height=10 alt=^ src="lcl/_arrowup.gif" width=10 align=absMiddle border=0>' : '&nbsp;<IMG height=10 alt=^ src="lcl/_arrowdown.gif" width=10 align=absMiddle border=0>';
}

return $sort_url_name.$sort_url_name_img;
}


switch (@$_GET['action']){

	

default:

if (isset ($_POST['deleted'])){
	if (is_array (@$_POST['delete'])){
	foreach ($_POST['delete'] as $k=>$v){
		$query = $koneksi_db->sql_query ("DELETE FROM `mod_data_lcl` WHERE `id`='$v'");
	}
	}
	
}



$query_add = '';
if (isset ($_GET['str']) && !empty($_GET['str'])){
	$str = substr($_GET['str'],0,1);
$query_add .= "WHERE LEFT (`nama`,1) = '$str'";
}




$num = $koneksi_db->sql_query("SELECT `id` FROM `mod_data_lcl`");
$jumlah = $koneksi_db->sql_numrows ($num);
//mysql_free_result ($num);

$limit = 20;
if (empty($_GET['offset']) and !isset ($_GET['offset'])) {
$offset = 0;
}else {
$offset = int_filter ($_GET['offset']);	
}

$a = new paging ($limit);

// Pembagian halaman dimulai
 if (!isset ($_GET['pg'],$_GET['stg'])){
	  $_GET['pg'] = 1;
	  $_GET['stg'] = 1;
  }
  
  
$qs = '';
	
 $arr = explode("&",$_SERVER["QUERY_STRING"]);
      
      if (is_array($arr)) {
        for ($i=0;$i<count($arr);$i++) {
          if (!is_int(strpos($arr[$i],"str=")) && trim($arr[$i]) != "") {
	          list ($kunci,$isi) = explode ('=',$arr[$i]);
	          $isi = urldecode($isi);
	          $isi = urlencode ($isi);
	          
              $qs .= $kunci . '=' . $isi ."&amp;";
          }
        }
      }  
  
 





  
$content .= <<<js
<script language="javascript">
all_checked = true;
function checkall(formName, boxName) {
	for(i = 0; i < document.getElementById(formName).elements.length; i++)
	{
		var formElement = document.getElementById(formName).elements[i];
		if(formElement.type == 'checkbox' && formElement.name == boxName && formElement.disabled == false)
		{
			formElement.checked = all_checked;
		}
	}	
all_checked = all_checked ? false : true;
}
</script>


js;

$referer = referer_encode();
$content .= '<form method="POST" action="" id="namaform">
<div class="table-responsive"><table class="table table-hover">';

$content .= '<tr>
<th>No.</th>

<th>Foto Barang</th>
<th>Pengirim</th>
<th>Kiriman</th>
<th>Konfirm</th>

<th><a href="javascript:checkall(\'namaform\', \'delete[]\');">Delete</a></th>
</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_lcl` ORDER By `id` DESC LIMIT $offset, $limit");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#"';
else $warna = null;	
$no++;
$id = $data['id'];

$published = ($data['status'] == '1') ? '<a href="admin.php?pilih=lcl&modul=yes&amp;action=pub&amp;pub=0&amp;id='.$id.'"><img src="images/tick.gif" border="0" alt="Ya" /></a>' : '<a href="admin.php?pilih=lcl&modul=yes&amp;action=pub&amp;pub=1&amp;id='.$id.'"><img src="images/cross.png" border="0" alt="No" /></a>';	
	

$content .= '<tr>
	<td>'.$no.'.</td>

		<td><img src="images/lcl/'.$data['foto'].'" class="img-responsive" style="max-width:120px;" alt="'.$data['nama'].'"> </td>
	<td><b>'.$data['nama'].'</b><br/>'.$data['email'].'<br/>Telp. '.$data['telp'].'</td>
	<td><b>'.$data['barang'].'</b><br/>'.$data['ket'].'<br/><a href="admin.php?pilih=lcl&amp;modul=yes&amp;action=detail&amp;id='.$id.'">Detail</a></td>
<td>'.$published.'</td>

	<td><input type="checkbox" name="delete[]" value="'.$id.'" style="border:0px"></td>
	
</tr>';
}


$content .= '<tr>
<td>&nbsp;</td>
 
    <td>&nbsp;</td> <td>&nbsp;</td>
    <td>&nbsp;</td>    <td>&nbsp;</td>
    <td><input type="submit"  name="deleted" value="Delete" onclick="return confirm (\'Do You Want to Delete Data Such\')"></td>
  </tr>';  

$content .= '</table></div></form>';


$content .= '<p align=center>';
$content .= $a-> getPaging($jumlah, $_GET['pg'], $_GET['stg']);
$content .= '</p>';




break;	




case 'detail':

$id = int_filter($_GET['id']);
$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_lcl` WHERE `id` = '$id'");
$data = $koneksi_db->sql_fetchrow($query);


$content .= '
<h4>'.$data['barang'].'</h4>
<img src="images/lcl/'.$data['foto'].'" class="img-responsive" alt="'.$data['nama'].'">
<br/>

<table width=100%>

<tr>
<td width="30%">Nama</td>
<td width="2%">:</td>
<td>'.$data['nama'].'</td>
</tr>

<tr>
<td>Email</td>
<td>:</td>
<td>'.$data['email'].'</td>
</tr>

<tr>
<td>No. Telp.</td>
<td>:</td>
<td>'.$data['telp'].'</td>
</tr>

<tr>
<td>Nama Barang/HS Code</td>
<td>:</td>
<td>'.$data['barang'].'</td>
</tr>
<tr>
<td>Harga Barang/Nilai Invoice</td>
<td>:</td>
<td>'.$data['mata'].'
 '.$data['harga'].'</td>
</tr>


<tr>
<td>Kota dan Negara Asal Barang</td>
<td>:</td>
<td>'.$data['asal'].'</td>
</tr>

<tr>
<td>Kota Tujuan Indonesia</td>
<td>:</td>
<td>'.$data['tujuan'].'</td>
</tr>
<tr>
<td>Berat Barang (Kg)</td>
<td>:</td>
<td>'.$data['berat'].'</td>
</tr>
<tr>
<td>Volume M3(CBM)</td>
<td>:</td>
<td>'.$data['volume'].'</td>
</tr>
<tr>
<td>Dimensi Barang</td>
<td>:</td>
<td>'.$data['p'].' x '.$data['l'].' x '.$data['t'].'
</td>
</tr>





<tr>
<td valign=top>Pertanyaan/Keterangan</td>
<td valign=top>:</td>
<td valign=top>'.$data['ket'].'</td>
</tr>

</table>
<br/>
<a href="admin.php?pilih=lcl&modul=yes">Kembali</a>
';



break;	

case 'pub':	
	if ($_GET['pub'] == '0'){	
		$id = int_filter ($_GET['id']);	
		$koneksi_db->sql_query ("UPDATE mod_data_lcl SET status='0' WHERE id='$id'");		
	}	
	
	if ($_GET['pub'] == '1'){	
		$id = int_filter ($_GET['id']);	
		$koneksi_db->sql_query ("UPDATE mod_data_lcl SET status='1' WHERE id='$id'");			
	}	
	header ("location:admin.php?pilih=lcl&modul=yes");
	exit;


break;	


















case 'cari':


$_GET['field'] = !isset ($_GET['field']) ? 'nama' : $_GET['field'];



$content .= '
<form method="GET" action="">
<table border=0 width=100% style="border:0px solid">
<tr>
<td>Search </td><td>:</td><td>'.input_text ('search',@$_GET['search'],$type='text',$size=33,$opt='').'</td>
</tr>

<tr>
<td></td><td></td><td><input type="submit" name="submit" value="Search"></td>
</tr>
</table>
<input type="hidden" name="pilih" value="lcl">
<input type="hidden" name="modul" value="yes">
<input type="hidden" name="action" value="cari">

</form>

';

if (isset ($_POST['deleted'])){
	if (is_array (@$_POST['delete'])){
	foreach ($_POST['delete'] as $k=>$v){
		$query = $koneksi_db->sql_query ("DELETE FROM `mod_data_lcl` WHERE `id`='$v'");
	}
	}
	
}

$filter_field = array ('nama');
if (!empty ($_GET['search']) && !empty($_GET['field']) && in_array ($_GET['field'],$filter_field)){
$search = cleartext($_GET['search']);
$field = cleartext($_GET['field']);

$SQLOPERATOR = "LIKE '%$search%'";
if ($field == 'no_induk'){
	$SQLOPERATOR = "= '$search'";
}

$query_add = "WHERE `$field` $SQLOPERATOR";






$num = $koneksi_db->sql_query("SELECT `id` FROM `mod_data_lcl` $query_add");
$jumlah = $koneksi_db->sql_numrows ($num);
$koneksi_db->sql_freeresult ($num);

$limit = 20;
if (empty($_GET['offset']) and !isset ($_GET['offset'])) {
$offset = 0;
}else {
$offset = int_filter ($_GET['offset']);	
}

$a = new paging ($limit);

// Pembagian halaman dimulai
 if (!isset ($_GET['pg'],$_GET['stg'])){
	  $_GET['pg'] = 1;
	  $_GET['stg'] = 1;
  }


$content .= <<<js
<script language="javascript">
all_checked = true;
function checkall(formName, boxName) {
	for(i = 0; i < document.getElementById(formName).elements.length; i++)
	{
		var formElement = document.getElementById(formName).elements[i];
		if(formElement.type == 'checkbox' && formElement.name == boxName && formElement.disabled == false)
		{
			formElement.checked = all_checked;
		}
	}	
all_checked = all_checked ? false : true;
}
</script>


js;
$referer = referer_encode();
$content .= '<form method="POST" action="" id="namaform">
<div class="table-responsive"><table class="table table-hover">';

$content .= '<tr>
<th>No.</th>

<th>Foto Barang</th>
<th>Pengirim</th>
<th>Kiriman</th>
<th>Konfirm</th>

<th><a href="javascript:checkall(\'namaform\', \'delete[]\');">Delete</a></th>
</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_lcl` $query_add $SORT_SQL LIMIT $offset, $limit");




$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#"';
else $warna = null;	
$no++;
$id = $data['id'];

$published = ($data['status'] == '1') ? '<a href="admin.php?pilih=lcl&modul=yes&amp;action=pub&amp;pub=0&amp;id='.$id.'"><img src="images/tick.gif" border="0" alt="Ya" /></a>' : '<a href="admin.php?pilih=lcl&modul=yes&amp;action=pub&amp;pub=1&amp;id='.$id.'"><img src="images/cross.png" border="0" alt="No" /></a>';	
	

$content .= '<tr>
	<td>'.$no.'.</td>

		<td><img src="images/lcl/'.$data['foto'].'" class="img-responsive" style="max-width:120px;" alt="'.$data['nama'].'"> </td>
	<td><b>'.$data['nama'].'</b><br/>'.$data['email'].'<br/>Telp. '.$data['telp'].'</td>
	<td><b>'.$data['barang'].'</b><br/>'.$data['ket'].'<br/><a href="admin.php?pilih=lcl&amp;modul=yes&amp;action=detail&amp;id='.$id.'">Detail</a></td>
<td>'.$published.'</td>

	<td><input type="checkbox" name="delete[]" value="'.$id.'" style="border:0px"></td>
	
</tr>';
}


$content .= '<tr>
<td>&nbsp;</td>
 
    <td>&nbsp;</td> <td>&nbsp;</td>
    <td>&nbsp;</td>    <td>&nbsp;</td>
    <td><input type="submit"  name="deleted" value="Delete" onclick="return confirm (\'Do You Want to Delete Data Such\')"></td>
  </tr>';  

$content .= '</table></div></form>';



$content .= '<p align=center>';
$content .= $a-> getPaging($jumlah, $_GET['pg'], $_GET['stg']);
$content .= '</p>';

	
	
}







break;	

}














/////////////
echo $content;

?>