
			<?php
global $koneksi_db, $maxkonten;
$perintah="SELECT * FROM mod_data_profil";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				$id = md5($data['id']);
				
 echo '   
 
 
  <div class="keo_top_wrap keo_bg_3 default_width" style="background:'.$data['warnah'].';">
                <div class="container">
                    <div class="keo_top_element">
                        <ul>
                           
                            <li>
                                <i class="fa fa-phone"></i>'.$data['telp'].'</li>
                            <li>
                                <i class="fa fa-envelope"></i>
                                <a href="#">'.$data['email'].'</a>
                            </li>
                        </ul>
                    </div>
                    <div class="keo_login_element">
                        <a href="login.html">
                            <i class="icon-lock"></i>Login &#38; Register</a>
                    </div>
                </div>
            </div>
 
 
 
				 
				 
				 
				 

 
 

 
'; 
					
} ?>	
						