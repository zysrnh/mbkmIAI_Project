   <!-- Start Footer -->
 
					
					
			
                   
     <?php 
     
     
     
     
     
	
$perintah="SELECT * FROM mod_data_profil";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				
				
echo '       <footer class="footer" style="background:'.$data['warnaf'].';"> 
         
            <div class="container">
                <div class="row row1">
                    <div class="col-sm-12 clearfix">';				
				
}

     
     
     
     
     
global $koneksi_db;

$hasil3 = $koneksi_db->sql_query( "SELECT * FROM menu2 WHERE published=1 ORDER BY ordering" );
while ($datamenu3 = $koneksi_db->sql_fetchrow($hasil3)) {
$idmenu3 = $datamenu3['id'];
$menuidmenu3 = $datamenu3['menu2'];
$urlidmenu3 = $datamenu3['url'];
$adamenu3=$koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM submenu2 where parent='".$idmenu3."' AND published='1'"));

echo '
	<div class="foot-nav">
                            <h3>'.$menuidmenu3.'</h3> 
									
							
		';



if ($adamenu3 > 0) {
	
	echo '<ul>';

$hasil23 = $koneksi_db->sql_query( "SELECT * FROM `submenu2` WHERE published='1' AND  parent='".$idmenu3."' ORDER By `ordering` ASC");
while ($datamenu23 = $koneksi_db->sql_fetchrow($hasil23)) {
$idmenu23 = $datamenu23['id'];

$menuidmenu23 = $datamenu23['menu2'];
$urlidmenu23 = $datamenu23['url'];




echo '
                      <li><a href="'.$urlidmenu23.'" title="'.$menuidmenu23.'">'.$menuidmenu23.'</a></li>                  
                         
                   
				';


}
echo ' 
                          
                         
                       
                 </ul>
				';
}



echo ' 
                        
                    </div>
					';

}









                 
                           
?>					
					               
                    
  <?php
						
						
						
	
$perintah="SELECT * FROM mod_data_profil";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				
					$url=str_replace(" ", "-", $data[1]);
					$tahun = date('Y');
	
					
					 echo '
	



                        <div class="foot-nav">
                            <h3>Hubungi Kami</h3> 
                        <ul style="color: #8eb6d6;font-size: 12px;">
                            <li>'.$data['alamat'].'</li>
                            <li>Telp. '.$data['telp'].'</li>
                            <li>'.$data['email'].'</li>
							    <li>Jam Operasional: '.$data['slogan'].'</li>
                        </ul>
						</div>
                  
                </div>
            </div>
			 </div>
            <!-- End Footer Top --> 
            <!-- Start Footer Bottom -->
            <div class="bottom" style="background:'.$data['warnaf2'].';color:#333333;">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                         <center> <p style="color:#333333;">Copyright © '.$tahun.' '.$data['nama'].'. All rights reserved</p></center>
                        </div>
                      
                    </div>
                </div>
            </div>
            <!-- End Footer Bottom --> 
        </footer>



















	
 
'; 
}			
	?>
								                  
                  