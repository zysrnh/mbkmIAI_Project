<h4>File Sharing</h4><br/><p>
<a href="index.php?pilih=file&amp;modul=yes">List Data</a> | 
<a href="index.php?pilih=file&amp;modul=yes&amp;action=cari">Cari Data</a>

<?php


$pilih = cleartext($_GET['pilih']);

$seo1= $koneksi_db->sql_query("SELECT * FROM mod_data_meta WHERE nama='$pilih'");
while($pr1xypd=$koneksi_db->sql_fetchrow($seo1)){
	$judulseo1 = $pr1xypd['judul'];
$desseo1 = $pr1xypd['meta'];
$keyseo1 = $pr1xypd['tags'];
}

$judul_situs = $judulseo1;
$_META['description'] = $desseo1;
$_META['keywords'] = $keyseo1;


$index_hal = 1;
$content='';
$tampil='';
$no=0;
include 'modul/functions.php';



$_GET['str'] = isset($_GET['str']) ? $_GET['str'] : null;
$_GET['sort'] = isset($_GET['sort']) ? $_GET['sort'] : NULL;
$_GET['order'] = isset($_GET['order']) ? $_GET['order'] : NULL;

$sort_url_orderby = $_GET['sort'] == 'asc' ? 'dsc' : 'asc';

function sortorder($sort_url_orderby,$field,$judul){
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
	



$sort_url_name = '<a title="Sort Berdasarkan '.$judul.'" href="?'.$qs.'&amp;sort='.$sort_url_orderby.'&amp;order='.$field.'">'.$judul.'</a>';
$sort_url_name_img = '';
if (isset($_GET['sort']) && $_GET['order'] == $field){
$sort_url_name_img = $_GET['sort'] == 'asc' ? '&nbsp;<IMG height=10 alt=^ src="gambar/_arrowup.gif" width=10 align=absMiddle border=0>' : '&nbsp;<IMG height=10 alt=^ src="gambar/_arrowdown.gif" width=10 align=absMiddle border=0>';
}

return $sort_url_name.$sort_url_name_img;
}


switch (@$_GET['action']){

	
	
	
	
default:




$query_add = '';
if (isset ($_GET['str']) && !empty($_GET['str'])){
	$str = substr($_GET['str'],0,1);
$query_add .= "WHERE LEFT (`nama`,1) = '$str'";
}








$SORT_SQL = '';
$filter_field = array ('nama','tahun_tamat');
if (isset ($_GET['sort']) && !empty($_GET['sort']) && in_array ($_GET['order'],$filter_field)){
	$sort = $_GET['sort'];
	$order = $_GET['order'];
	if ($sort == 'asc') $sortSQL = 'ASC';
	else if ($sort == 'dsc') $sortSQL = 'DESC';
	
$SORT_SQL = "ORDER BY `$order` $sortSQL";
}


$num = $koneksi_db->sql_query("SELECT `id` FROM `mod_data_file` WHERE status='1' $query_add");
$jumlah = $koneksi_db->sql_numrows ($num);
//mysql_free_result ($num);

$limit = 10;
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
	<th>No. </th>
<th>Nama File </th>
		<th>Keterangan</th>
<th>Tanggal Upload</th>
<th>Action</th>

</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_file` WHERE status='1' $query_add $SORT_SQL ORDER BY `id` DESC LIMIT $offset, $limit");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#"';
else $warna = null;	
$no++;
$id = md5($data['id']);
$content .= '<tr>
<td>'.$no.'.</td>
<td>'.$data['nama'].'</td>
<td>'.$data['ket'].'</td>
<td>'.datetimess($data['tanggal']).'</td>
		<td><a href="files/'.$data['foto'].'" title="'.$data['nama'].'">Download</a></td>
	

</tr>';
}




$content .= '</table></div></form>';



$content .= '<p align=center>';
$content .= $a-> getPagingfile($jumlah, $_GET['pg'], $_GET['stg']);
$content .= '</p>';




break;	




case 'cari':


$_GET['field'] = !isset ($_GET['field']) ? 'nama' : $_GET['field'];



$content .= '
<form method="GET" action="">
<table border=0 width=100% align=left style="border:0px solid">
<tr>
<td>Search </td><td>:</td><td>'.input_text ('search',@$_GET['search'],$type='text',$size=33,$opt='').'</td>
</tr>

<tr>
<td></td><td></td><td><input type="submit" name="submit" value="Search"></td>
</tr>
</table>
<input type="hidden" name="pilih" value="file">
<input type="hidden" name="modul" value="yes">
<input type="hidden" name="action" value="cari">

</form>

';


$filter_field = array ('nama');
if (!empty ($_GET['search']) && !empty($_GET['field']) && in_array ($_GET['field'],$filter_field)){
$search = cleartext($_GET['search']);
$field = cleartext($_GET['field']);

$SQLOPERATOR = "LIKE '%$search%'";
if ($field == 'no_induk'){
	$SQLOPERATOR = "= '$search'";
}

$query_add = "WHERE `$field` $SQLOPERATOR";




$SORT_SQL = '';
$filter_field = array ('nama');
if (isset ($_GET['sort']) && !empty($_GET['sort']) && in_array ($_GET['order'],$filter_field)){
	$sort = $_GET['sort'];
	$order = $_GET['order'];
	if ($sort == 'asc') $sortSQL = 'ASC';
	else if ($sort == 'dsc') $sortSQL = 'DESC';
	
$SORT_SQL = "ORDER BY `$order` $sortSQL";
}


$num = $koneksi_db->sql_query("SELECT `id` FROM `mod_data_file` $query_add AND status='1'");
$jumlah = $koneksi_db->sql_numrows ($num);
$koneksi_db->sql_freeresult ($num);

$limit = 10;
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
	<th>No. </th>
<th>Nama File </th>
		<th>Keterangan</th>
<th>Tanggal Upload</th>
<th>Action</th>

</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_file` $query_add AND status='1' $SORT_SQL LIMIT $offset, $limit");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#"';
else $warna = null;	
$no++;
$id = md5($data['id']);
$content .= '<tr>
<td>'.$no.'.</td>
<td>'.$data['nama'].'</td>
<td>'.$data['ket'].'</td>
<td>'.datetimess($data['tanggal']).'</td>
		<td><a href="files/'.$data['foto'].'" title="'.$data['nama'].'">Download</a></td>
	

</tr>';
}




$content .= '</table></div></form>';


$content .= '<p align=center>';
$content .= $a-> getPagingfilecari($jumlah, $_GET['pg'], $_GET['stg'],$search);
$content .= '</p>';

	
	
}







break;	






}














/////////////
echo $content;

?>