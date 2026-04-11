
<?php



$index_hal = 1;
if (!empty($_GET['tag'])){
		$tag = mysql_escape_string($_GET['tag']);
$urlkontenx=str_replace(" ", ", ", $tag);

$tagx = $tag;

$judul_situs = ucwords(stripslashes(strip_tags($_GET['tag'])));
$_META['description'] = ucwords(stripslashes(strip_tags($_GET['tag'])));
$_META['keywords'] = $urlkontenx;


			echo '
							<h4>Tags '.ucwords(stripslashes(strip_tags($_GET['tag']))).'</h4><br/><p><ul class="keo_aside_fea_course">
			';
			
			
			$limit = 5;
			$offset = int_filter(@$_GET['offset']);
			$pg        = int_filter(@$_GET['pg']);
			$stg    = int_filter(@$_GET['stg']);
			
			if (strlen($tag) == 3) {
			$finder = "`tags` LIKE '%$tag%'";
			}else {
				$finder = "MATCH (tags) AGAINST ('$tag' IN BOOLEAN MODE)";
			}
			
			
			$totals = $koneksi_db->sql_query( "SELECT count(`id`) AS `total` FROM `artikel` WHERE $finder AND publikasi = 1" );
			$tot = $koneksi_db->sql_fetchrow ( $totals );
			$jumlah = $tot['total'];
			$a = new paging ($limit);
			if (empty($_GET['offset']) and !isset ($_GET['offset'])) {
					$offset = 0;
					}
					
					if (empty($_GET['pg']) and !isset ($_GET['pg'])) {
					$pg = 1;
					}
					
					if (empty($_GET['stg']) and !isset ($_GET['stg'])) {
					$stg = 1;
					}
					
			if ($jumlah > 0) {		
			$query = $koneksi_db->sql_query("SELECT * FROM `artikel` WHERE $finder AND publikasi = 1 ORDER BY `tgl` DESC LIMIT $offset,$limit");
			while($data = $koneksi_db->sql_fetchrow($query)) {
			$url=str_replace(" ", "-", $data['judul']);
			
			$urltgl=str_replace("-", "/", $data[5]);
			
					echo '
						 <li>
                                            <figure>
                                                <img src="images/artikel/'.$data['gambar'].'"  alt="'.$data[1].'">
                                            </figure>
                                            <div class="aside_fea_course_des">
                                                <h5 style="font-size:18px;">
                                                   <b> <a href="artikel/'.$data[0].'/'.$url.'.html" title="'.$data[1].'">'.$data[1].'</a></b>
                                                </h5> <span><i class="fa fa-calendar"></i> '.datetimess($data['tgl']).'</span>
												<p>'.limitTXT(strip_tags($data['konten']),180).' </p>
                                                
                                            </div>
                                        </li>							
											
					
					';
				}
			}else {
				echo '<div class="error" style="width:30%">Tidak Ada arsip...</div>';
			}
				
				if($jumlah>$limit){
					echo '<div class="border">';
					echo "<center>";
					
					echo  $a-> getPaging7($jumlah, $pg, $stg,$tagx);
					echo "</center>";
					echo '</div>';
					}
			
			
			echo ' </ul>';
			
		
}
?>