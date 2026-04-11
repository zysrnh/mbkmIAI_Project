
										
										<?php
										
										
     
	
$perintah="SELECT * FROM mod_data_profil";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				
				
echo '      
<link rel="shortcut icon" type="image/x-icon" href="images/'.$data['foto2'].'">
';				
				
}

     
 ?>	
										
										
								