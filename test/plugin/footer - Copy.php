<!-- START FOOTER -->
<footer class="bg-dark footer_dark">
	<div class="top_footer">
        <div class="container">
            <div class="row">
			
			<?php

global $koneksi_db, $maxkonten;
$perintah="SELECT * FROM mod_data_profil";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				$id = md5($data['id']);
				
 echo '
 
 <div class="col-lg-4 col-sm-8 mb-4 mb-lg-0">
                	<h6 class="widget_title">Hubungi Kami</h6>
                    <p style="text-transform:uppercase;">'.$data['nama'].'</p>
                    <ul class="contact_info contact_info_light list_none">
                        <li>
                            <i class="fa fa-map-marker-alt "></i>
                            <address>'.$data['alamat'].'</address>
                        </li>
                        <li>
                            <i class="fa fa-envelope"></i>
                            <a href="mailto:'.$data['email'].'">'.$data['email'].'</a>
                        </li>
                        <li>
                            <i class="fa fa-mobile-alt"></i>
                            <p>'.$data['telp'].'</p>
                        </li>
                    </ul>
                </div>
				
				
 
 
'; 
					
} ?>	
                
                        
     <?php 
global $koneksi_db;

$hasil3 = $koneksi_db->sql_query( "SELECT * FROM menu2 WHERE published=1 ORDER BY ordering" );
while ($datamenu3 = $koneksi_db->sql_fetchrow($hasil3)) {
$idmenu3 = $datamenu3['id'];
$menuidmenu3 = $datamenu3['menu2'];
$urlidmenu3 = $datamenu3['url'];
$adamenu3=$koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM submenu2 where parent='".$idmenu3."' AND published='1'"));

echo '
	<div class="col-lg-2 col-sm-4 mb-4 mb-lg-0">
                	<h6 class="widget_title">'.$menuidmenu3.'</h6>
									
							
		';



if ($adamenu3 > 0) {
	
	echo ' <ul class="list_none widget_links links_style1">';

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



						
						
						
	
$perintah="SELECT * FROM mod_data_profil";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				
					$url=str_replace(" ", "-", $data[1]);
					$tahun = date('Y');
	
					
					 echo '
	

 <div class="col-lg-3 col-md-6">
                    <h6 class="widget_title">Tentang Kami</h6>
                    <p>'.$data['desc'].'</p>
                    
                    <h6 class="widget_title">Follow Us</h6>
                    <ul class="list_none social_icons radius_social social_white social_style1">
                    	<li><a href="'.$data['fb'].'"><i class="ion-social-facebook"></i></a></li>
                        <li><a href="'.$data['tw'].'"><i class="ion-social-twitter"></i></a></li>
                        <li><a href="'.$data['in'].'"><i class="ion-social-instagram-outline"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_footer bg_black">
    	<div class="container">
        	<div class="row align-items-center">
            	<div class="col-md-6">
                	<p class="copyright m-md-0 text-center text-md-left">Copyright © '.$tahun.' '.$data['nama'].', All rights reserved.</p>
                </div>
                <div class="col-md-6">
                	
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- END FOOTER -->

                    



	
 
'; 
}			
	?>
				
				
				
				
				
				
				
				
				
				
				
   
               