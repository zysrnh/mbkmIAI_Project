<h4>Dosen dan Karyawan</h4><br/><p>


<?php

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


$query_add = '';
if (isset ($_GET['str']) && !empty($_GET['str'])){
	$str = substr($_GET['str'],0,1);
$query_add .= "WHERE LEFT (`nama`,1) = '$str'";
}




$num = $koneksi_db->sql_query("SELECT `id` FROM `mod_data_team` $query_add");
$jumlah = $koneksi_db->sql_numrows ($num);
//mysql_free_result ($num);

$limit = 12;
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
  
 



$content .= '<div style="margin-left:-14px;">';


  







$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_team` $query_add ORDER By `id` ASC LIMIT $offset, $limit");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#"';
else $warna = null;	
$no++;
$id = $data['id'];
	$url=str_replace(" ", "-", $data[1]);

$content .= '





                <div class="medium-4 small-12 columns"  style="margin-bottom:26px;">
                	<div class="shadow">
                        <div class="staff-box">
                            <a href="team/'.$data['id'].'/'.$url.'.html" title="'.$data['nama'].'"><img  src="images/team/'.$data['foto'].'" alt="'.$data['nama'].'" /></a>
                            <div class="staff-links">
                                <ul class="menu">
                                    <li><a href="'.$data['fb'].'"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="'.$data['tw'].'"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="'.$data['in'].'"><i class="fa fa-instagram"></i></a></li>
                                </ul>                             
                            </div><!-- staff links /-->
                         </div><!-- staff box /-->       
                         <div class="staff-detail">
                            <h4><a href="team/'.$data['id'].'/'.$url.'.html" title="'.$data['nama'].'">'.$data['nama'].'</a><br><span>'.$data['pekerjaan'].'</span></h4>
                            <p>'.limitTXT(strip_tags($data['ket']),60).'</p>
                           	
                            <a href="team/'.$data['id'].'/'.$url.'.html" title="'.$data['nama'].'" class="small-button">Read More &raquo;</a>                                                                                    
                   		 </div>                                                
                    </div>                    
                </div><!-- Staff -->












								

';
}





$content .= '</div><p align=center>';
$content .= $a-> getPagingteam($jumlah, $_GET['pg'], $_GET['stg']);
$content .= '</p>';




break;	





	
case 'detail':
$id = int_filter($_GET['id']);



$query = $koneksi_db->sql_query ("SELECT * FROM `mod_data_team` WHERE id='$id'");



$warna = null;
while ($data = $koneksi_db->sql_fetchrow($query)){
if (!isset($warna)) $warna = 'style="background:#"';
else $warna = null;	
$no++;

$kett = limitTXT2(strip_tags($data['ket']),160);
$urlt=str_replace(" ", ", ", $kett);

$judul_situs = $data['nama'];
$_META['description'] = limitTXT2(strip_tags($data['ket']),160);
$_META['keywords'] = $urlt;


$content .= '


						
							
								<div style="float:right;">
						
										<img alt="'.$data['nama'].'" width="200" class="img-fluid" src="images/team/'.$data['foto'].'">
									
								</div>
								
						
						

							<h2 class="mb-0">'.$data['nama'].'</h4><br/><p>
							<h4 class="heading-primary">'.$data['pekerjaan'].'</h4>
							<p>'.$data['ket'].'
							<br/>Telp. '.$data['hp'].'
							</p>

							<hr class="solid">

							

									
										 <div class="socialicons">
											<a target="_blank" href="'.$data['fb'].'" title="Facebook"><i class="fa fa-facebook"></i></a>
											<a href="'.$data['tw'].'" title="tw"><i class="fa fa-twitter"></i></a>
											<a href="'.$data['in'].'" title="in"><i class="fa fa-instagram"></i></a>
										</div>
										<br/>
										<a href="team.html">Kembali</a>
							
							

					
					
';
}






break;	



}














/////////////
echo $content;

?>