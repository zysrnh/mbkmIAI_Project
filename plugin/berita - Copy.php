<div class="widget widget_categories">
                    	<h5 class="widget_title">Kategori Artikel</h5>

                           <ul>
<?php
$perintah="SELECT * FROM topik ORDER BY `id` ASC";
$hasil = $koneksi_db->sql_query($perintah );
				while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
			$urlxtopik=str_replace(" ", "-", $data['topik']);
			
			$adat=$koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM artikel where topik='".$data['id']."'"));
 echo '
					
		
					<li><a href="kategori/'.$data['id'].'/'.$urlxtopik.'.html"  title="'.$data['topik'].'"> '.$data['topik'].' ('.$adat.')</a></li>
				
	';  } ?>										
								
						
						
						
                           	</ul>
                    </div>

                              <div class="widget widget_recent_post">
                    	<h5 class="widget_title">Artikel Terkini</h5>

                    <ul class="recent_post border_bottom_dash list_none">
                           
								
									
								
								
								
								
							
											
			
<?php
global $koneksi_db, $maxkonten;
$perintah="SELECT * FROM artikel WHERE publikasi='1' ORDER BY `id` DESC limit 5";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
?>
<?php
				while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				$id = $data[0];
$url=str_replace(" ", "-", $data[1]);
$post   = $data[2];
	$na = catch_that_image($post);
	$idzz = $data['id'];
	$topik = $data['topik'];
	$gambar = $data['gambar'];
$ada=$koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM komentar where artikel='".$idzz."'"));

$propinsi4 = $koneksi_db->sql_query("SELECT * FROM topik WHERE id='$topik'");
while($p4=$koneksi_db->sql_fetchrow($propinsi4)){
	$kelas24 = $p4['topik'];
}

				?>
			
					<?php echo '
					<li>
                                <div class="post_footer">
                                    <div class="post_img">
                                        <a href="artikel/'.$data[0].'/'.$url.'.html" title="'.$data[1].'"><img src="images/artikel/'.$gambar.'"  alt="'.$data[1].'"></a>
                                    </div>
                                    <div class="post_content">
                                        <h6><a href="artikel/'.$data[0].'/'.$url.'.html" title="'.$data[1].'">'.$data[1].'</a></h6>
                                        <span class="post_date">'.datetimess($data[5]).' </span>
                                    </div>
                                </div>
                            </li>
					
					

					'; ?>
<?php } ?>						  
				  		
		
</ul>
                          
                        </div>

								