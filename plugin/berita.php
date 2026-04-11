<div class="category">
    <h3 style="background-color: #1565C0; color: #ffffff; padding: 12px 15px; margin: 0;">Artikel</h3>

                           <ul>
<?php
$perintah="SELECT * FROM topik ORDER BY `id` ASC";
$hasil = $koneksi_db->sql_query($perintah );
				while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
			$urlxtopik=str_replace(" ", "-", $data['topik']);

			$adat=$koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM artikel where topik='".$data['id']."'"));
 echo '
					
		
					<li style="border-bottom: 1px solid #ccc; padding: 8px 0;">
    <a href="kategori/'.$data['id'].'/'.$urlxtopik.'.html"  
       title="'.$data['topik'].'"
       style="color: #1565C0; font-weight: bold;"> 
       '.$data['topik'].' ('.$adat.')
    </a>
</li>
				
	';  } ?>




                            </ul>
                        </div>

                            <div class="recent-post" style="margin-top:-30px;">
                            <h3>Artikel Terkini</h3>

                    <ul style="margin-top:-10px;">
								
								
								
									
								
								
								
								
							
											
			
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
					 <li class="clearfix"> <a href="artikel/'.$data[0].'/'.$url.'.html" title="'.$data[1].'">
                                    <div class="img-block"><img src="images/artikel/'.$gambar.'" class="img-responsive" alt="'.$data[1].'"></div>
                                    <div class="detail">
                                        <h4>'.$data[1].'</h4>
                                        <p><span class="icon-date-icon ico"></span><span>'.datetimess($data[5]).' </span></p>
                                    </div>
                                    </a> </li>
		

					'; ?>
<?php } ?>						  
				  		
		
</ul>
                          
                        </div>

								