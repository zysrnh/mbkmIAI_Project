
<h4>Themes Setting</h4><br/><p>
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





switch (@$_GET['action']){

	
	
	
default:

if (isset ($_POST['deleted'])){
	if (is_array (@$_POST['delete'])){
	foreach ($_POST['delete'] as $k=>$v){
		$query = $koneksi_db->sql_query ("DELETE FROM `mod_data_themes` WHERE `id`='$v'");
	}
	}
	
}



$query_add = '';
if (isset ($_GET['str']) && !empty($_GET['str'])){
	$str = substr($_GET['str'],0,1);
$query_add .= "WHERE LEFT (`nama`,1) = '$str'";
}






if (isset ($_GET['progstudi']) && !empty($_GET['progstudi']) && is_numeric($_GET['progstudi'])){
	$progstudi = int_filter ($_GET['progstudi']);
$query_add = "WHERE `tbl_guru`.`kd_progstudi` = '$progstudi'";
}
if (isset ($_GET['kelas']) && !empty ($_GET['kelas'])){
	$kd_kelas = int_filter ($_GET['kelas']);
$query_add = "WHERE `tbl_guru`.`kd_kelas` = '$kd_kelas'";
}
if (!empty ($_GET['progstudi']) && !empty ($_GET['kelas']) && is_numeric($_GET['progstudi'])){
$query_add = "WHERE `tbl_guru`.`kd_progstudi` = '$progstudi' AND `tbl_guru`.`kd_kelas` = '$kd_kelas'";
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


$num = $koneksi_db->sql_query("SELECT `id` FROM `mod_data_themes` $query_add");
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
  
 
$str_abjad = array ('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
$gabung_str = '| ';
foreach ($str_abjad AS $k=>$v){
	if ($_GET['str'] == $v){
	$gabung_str .= '<b>'.$v.'</b> | ';		
	}else {
	$gabung_str .= '<a href="'.basename($_SERVER['PHP_SELF']).'?'.$qs.'&amp;str='.$v.'">'.$v.'</a> | ';	
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
<th>Komponen</th>
		
<th>Status</th>
	
</tr>';



$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_themes` $query_add $SORT_SQL ORDER By `id` ASC LIMIT $offset, $limit");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#"';
else $warna = null;	
$no++;
$id = $data['id'];
$published = ($data['status'] == '0') ? '<a href="admin.php?pilih=themes&modul=yes&amp;action=pub&amp;pub=1&amp;id='.$id.'&ref='.$referer.'"><img src="images/cross.png" border="0" alt="no" /></a>' : '<a href="admin.php?pilih=themes&modul=yes&amp;action=pub&amp;pub=0&amp;id='.$id.'&ref='.$referer.'"><img src="images/tick.gif" border="0" alt="ya" /></a>';	

$content .= '<tr>
<td>'.$no.'.</td>
<td>'.$data['nama'].'</td>
		<td>'.$published.'</td>
	
</tr>';
}


$content .= '</table></div>';


$content .= '<p align=center>';
$content .= $a-> getPaging($jumlah, $_GET['pg'], $_GET['stg']);
$content .= '</p>';




break;	





case 'pub':	

	if ($_GET['pub'] == '0'){	
		$id = int_filter ($_GET['id']);	
		$koneksi_db->sql_query ("UPDATE mod_data_themes SET status='0' WHERE id='$id'");
	}	
	
	if ($_GET['pub'] == '1'){	
		$id = int_filter ($_GET['id']);	
	$koneksi_db->sql_query ("UPDATE mod_data_themes SET status='1' WHERE id='$id'");	
	}	
	header ("location: ".referer_decode($_GET['ref'])."");
	exit;


break;	


}














/////////////
echo $content;

?>
</p>