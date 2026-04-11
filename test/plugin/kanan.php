 <h4 class="post-title" style="text-transform: uppercase;">INFO PCMB</h4><hr class="main-section-divider" style="margin-bottom:10px;">


<?php

						$query2 = $koneksi_db->sql_query( "SELECT * FROM `artikel` WHERE publikasi=1 ORDER BY `id` DESC LIMIT 3" );	
						while ($data = $koneksi_db->sql_fetchrow($query2)) {
						$id2    = $data[0];
						$judul2    = $data[1];
						$data[5]= datetimess($data[5]);
				      	$post = $data[2];
					$na = catch_that_image($post);
						$gambar = ($data['gambar'] == '') ? '' : '<img src="'.$data['gambar'].'" border="0" alt="'.$data['judul'].'" width="50" height="70"  />';
						$url=str_replace(" ", "-", $data[1]);
						



						
						
											echo '
										
                       <h4 class="title"><a href="article-'.$data[0].'-'.$url.'.html" title="'.$data[1].'">'.$data[1].'</a></h4>
    <figure>
        <a href="article-'.$data[0].'-'.$url.'.html" title="'.$data[1].'">
						
					
																		
																		
									';
			if ($na!=''){	
				echo '<img src="'.catch_that_image($post).'" class="thumbnail-image" width=100%>';
			} else {
				
								echo '<img src="images/np1.jpg" class="thumbnail-image" width=100%/>';
				
			}
					
				echo '										
																		
										    </a>
 <h6><time><i class="fa fa-calendar"></i> '.datetimess($data[5]).'</time> <span class="view-count" title="Dilihat 51 kali"><i class="fa fa-eye"></i> '.$data[9].' Kali Dilihat </span> </h6>
   
 <p>'.limitTXT(strip_tags($data['konten']),140).'</p>

       								
																		
																		
																		
																		
																		
								
						
						
				
						
						
						
						
                    ';
						
						}
						?>



		