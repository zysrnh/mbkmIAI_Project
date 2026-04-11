				<div class="element-size-33"><div class="col-md-12"><div class="cs-section-title"> <h2>Gallery Foto</h2> </div>
						<p>														Koleksi foto kegiatan dan kenang-kenangan yang terangkum dalam sebuah album gallery.		Klik nama album foto untuk melihat foto didalamnya.																				</p> <div class="cs_categories cat-multicolor">  
						<ul>
						
				

<?php

global $koneksi_db, $maxkonten;
$perintah="SELECT * FROM mod_gallery_kat order by rand() LIMIT 8";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				$no++;
				$id = $data['id'];
	
	$ada=$koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM mod_gallery where kid='".$id."'"));
	
	
	if ($no==1)
	{
		$xx = '51087f';
	} elseif ($no==2)
	{
		$xx = '08387f';
	}elseif ($no==3)
	{
		$xx = '876a90';
	}elseif ($no==4)
	{
		$xx = '78aaf0';
	}elseif ($no==5)
	{
		$xx = 'fcc109';
	}elseif ($no==6)
	{
		$xx = 'e01729';
	}elseif ($no==7)
	{$xx = '9cc72b';
		
	}elseif ($no==8)
	{
		$xx = '999999';
	}
	
 echo '    

				
				
 <li><a href="index.php?pilih=foto&modul=yes&action=filter&kid='.$data['id'].'" style="color:#'.$xx.'">'.$data['name'].'</a> ('.$ada.')</li>
 

	';		  
}		  
         ?> 
			
				
						
					
						
						
						</ul>

						</div></div></div>
						
						
						
						
						
						
						
						
						<div class="element-size-33"> 
								<div class="cs-section-title col-md-12">
									<h2>Kategori Pengumuman</h2>
		                      	 
							  </div> 
 <div class="cs-campunews custom-fig col-md-12">
 <ul>
 
 
 
 
 
	             					<?php
global $koneksi_db, $maxkonten;
$perintah="SELECT * FROM artikel WHERE publikasi='1' AND topik='3' ORDER BY `id` DESC limit 3";
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
$ada=$koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM komentar where artikel='".$idzz."'"));

$propinsi4 = $koneksi_db->sql_query("SELECT * FROM topik WHERE id='$topik'");
while($p4=$koneksi_db->sql_fetchrow($propinsi4)){
	$kelas24 = $p4['topik'];
}

				?>
			
					<?php echo '
					
				  <li>
                                                  <figure>
				 <a href="artikel-'.$data[0].'-'.$url.'.html" title="'.$data[1].'">
			
					   
              
				
		';
			if ($na!=''){	
				echo '<img src="'.catch_that_image($post).'" width="300" height="132">';
			} else {
				
							echo '<img  src="images/np1.jpg" width="300" height="132">';
				
			}
					
				echo '	
				
				 <figcaption>
				
						</figcaption>
                          
                          
                          </figure>
                                                    <div class="cs-campus-info">
                            <div class="cs-newscategorie">  <a href="artikel-'.$data[0].'-'.$url.'.html" title="'.$data[1].'" rel="tag">'.$kelas24.'</a> </div>
                            <h6><a href="artikel-'.$data[0].'-'.$url.'.html" title="'.$data[1].'">'.$data['judul'].'</a></h6>
                            <time datetime="'.datetimess($data['tgl']).'">'.datetimess($data['tgl']).' </time>
                            <a href="artikel-'.$data[0].'-'.$url.'.html" title="'.$data[1].'" class="cmp-comment">
                            
									 '.$ada.' Comments                             </a>
                          </div>
                        </li>
				
				
				
               
 
				
				
			
					'; ?>
<?php } ?>						  
				  							
				
				
				  
 
 
 
 
 
 
 
                        
                          
                         
                        
                                 







								 
                        
                                                
                        
                            </ul>
 
    <a class="viewall-btn csbg-hovercolor" href="topik-3-Pengumuman.html">
    	<i class="icon-angle-double-right"></i> 
			Lihat Semua Artikel    </a>
</div>
 







</div>




		
						<div class="element-size-33"> 
								<div class="cs-section-title col-md-12">
									<h2>Kategori Lain-lain</h2>
		                      	 
							  </div> 
 <div class="cs-campunews custom-fig col-md-12">
 <ul>
 
 
 
 
 
	             					<?php
global $koneksi_db, $maxkonten;
$perintah="SELECT * FROM artikel WHERE publikasi='1' AND topik='4' ORDER BY `id` DESC limit 3";
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
$ada=$koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM komentar where artikel='".$idzz."'"));

$propinsi4 = $koneksi_db->sql_query("SELECT * FROM topik WHERE id='$topik'");
while($p4=$koneksi_db->sql_fetchrow($propinsi4)){
	$kelas24 = $p4['topik'];
}

				?>
			
					<?php echo '
					
				  <li>
                                                  <figure>
				 <a href="artikel-'.$data[0].'-'.$url.'.html" title="'.$data[1].'">
			
					   
              
				
		';
			if ($na!=''){	
				echo '<img src="'.catch_that_image($post).'" width="300" height="132">';
			} else {
				
							echo '<img  src="images/np1.jpg" width="300" height="132">';
				
			}
					
				echo '	
				
				 <figcaption>
				
						</figcaption>
                          
                          
                          </figure>
                                                    <div class="cs-campus-info">
                            <div class="cs-newscategorie">  <a href="artikel-'.$data[0].'-'.$url.'.html" title="'.$data[1].'" rel="tag">'.$kelas24.'</a> </div>
                            <h6><a href="artikel-'.$data[0].'-'.$url.'.html" title="'.$data[1].'">'.$data['judul'].'</a></h6>
                            <time datetime="'.datetimess($data['tgl']).'">'.datetimess($data['tgl']).' </time>
                            <a href="artikel-'.$data[0].'-'.$url.'.html" title="'.$data[1].'" class="cmp-comment">
                            
									 '.$ada.' Comments                             </a>
                          </div>
                        </li>
				
				
				
               
 
				
				
			
					'; ?>
<?php } ?>						  
				  							
				
				
				  
 
 
 
 
 
 
 
                        
                          
                         
                        
                                 







								 
                        
                                                
                        
                            </ul>
 
    <a class="viewall-btn csbg-hovercolor" href="topik-4-Lain-lain.html">
    	<i class="icon-angle-double-right"></i> 
			Lihat Semua Artikel    </a>
</div>
 







</div>
