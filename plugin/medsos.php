
										<?php

global $koneksi_db, $maxkonten;
$perintah="SELECT * FROM mod_data_profil";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				$id = md5($data['id']);
				
 echo '
 <ul class="header-social-icons social-icons d-none d-sm-block">
											<li class="social-icons-facebook"><a href="'.$data['fb'].'" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>
													<li class="social-icons-instagram"><a href="'.$data['tw'].'" target="_blank" title="Instagram"><i class="fa fa-instagram"></i></a></li>
											<li class="social-icons-twitter"><a href="'.$data['in'].'" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>
									
										</ul>
 

'; 
					
} ?>	
										
										
						