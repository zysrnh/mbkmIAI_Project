
										<?php

global $koneksi_db, $maxkonten;
$perintah="SELECT * FROM mod_data_profil";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				$id = md5($data['id']);
				
 echo '
 
    <link rel="shortcut icon" type="image/x-icon" href="images/'.$data['foto2'].'">
 

'; 
					
} ?>	
										
										
						