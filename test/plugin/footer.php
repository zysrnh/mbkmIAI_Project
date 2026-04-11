






























			<?php
global $koneksi_db, $maxkonten;
$perintah="SELECT * FROM mod_data_profil";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				$id = md5($data['id']);
				
 echo '    



<footer>

<div class="kingster-footer-wrapper " style="background:'.$data['warnaf'].';">
<div class="kingster-footer-container kingster-container clearfix" >



<div class="kingster-footer-column kingster-item-pdlr kingster-column-20" style="margin-bottom:30px;"><div id="text-38" class="widget widget_text kingster-widget">
<h3 class="kingster-widget-title">Tentang Kami</h3><span class="clear"></span>			
<div class="textwidget"><p>'.$data['desc'].'<br/><ul style="margin-left:16px;">
												<li><a style="color:white;"><i class="fa fa-map-marker"></i> '.$data['alamat'].'</a></li>
												<li><a style="color:white;"><i class="fa fa-phone"></i> '.$data['telp'].'</a></li>
												<li><a style="color:white;"><i class="fa fa-envelope-open-o"></i> '.$data['email'].'</a></li>
												<li><a style="color:white;"><i class="fa fa-clock-o"></i> '.$data['slogan'].'</a></li>
												
                                               </ul></p>

</div>
		</div>
</div>



<div class="kingster-footer-column kingster-item-pdlr kingster-column-20" ><div id="text-38" class="widget widget_text kingster-widget">
<h3 class="kingster-widget-title">Social Media</h3><span class="clear"></span>			
<div class="textwidget"><ul style="margin-left:16px;">
                                                              <li><a class="bg_fb" href="'.$data['fb'].'"><i class="fa fa-facebook"></i> Facebook</a></li>
                                    <li><a class="bg_twitter" href="'.$data['tw'].'"><i class="fa fa-twitter"></i> Twitter</a></li>
									       <li><a class="bg_behance" href="'.$data['in'].'"><i class="fa fa-instagram"></i> Instagram</a></li>
                                    <li><a class="bg_gp" href="'.$data['tele'].'"><i class="fa fa-telegram"></i> Telegram</a></li>
                                <li><a class="bg_gp" href="https://api.whatsapp.com/send?phone='.$data['wa'].'&amp;text="><i class="fa fa-whatsapp"></i> Whatsapp</a></li>
                                </ul>

</div>
		</div>
</div>















 

 
'; 
					
} ?>	
						
							
										
										
						<div class="kingster-footer-column kingster-item-pdlr kingster-column-20" ><div id="text-38" class="widget widget_text kingster-widget">
<h3 class="kingster-widget-title">Quick Link</h3><span class="clear"></span>			
<div class="textwidget">

			
									
	<?php 
global $koneksi_db;

$hasil3 = $koneksi_db->sql_query( "SELECT * FROM menu2 WHERE published=1 ORDER BY ordering" );
while ($datamenu3 = $koneksi_db->sql_fetchrow($hasil3)) {
$idmenu3 = $datamenu3['id'];
$menuidmenu3 = $datamenu3['menu2'];
$urlidmenu3 = $datamenu3['url'];
$adamenu3=$koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM submenu2 where parent='".$idmenu3."' AND published='1'"));

echo '
		
		';



if ($adamenu3 > 0) {
	
	echo ' <ul>';

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
                   ';

}









                 
                           
?>						
										
										
										
										
										
										
										
			</div>
		</div>
</div>								
										
                 </div>	                          
                                          
						
									
									
									
				




				
									
									
									
									
									
		

</div></footer></div></div>




						
<?php
global $koneksi_db, $maxkonten;
$perintah="SELECT * FROM mod_data_profil";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				$id = md5($data['id']);
				$tahun = date('Y');
				
				
				
				$propinsixw = $koneksi_db->sql_query("SELECT * FROM mod_data_warna WHERE id='1'");
while($pxw=$koneksi_db->sql_fetchrow($propinsixw)){
		$warna = $pxw['nama'];
	$warna2 = $pxw['nama2'];
}

 echo '   
<div class="kingster-copyright-wrapper"   style="background:'.$data['warnaf2'].';"><div class="kingster-copyright-container kingster-container clearfix"><div class="kingster-copyright-left kingster-item-pdlr">Copyright '.$tahun.' ©
                            '.$data['nama'].'. All rights reserved.</div>

				 
                          
			
			
			
		
 
 

 
'; 
					
} ?>					



<div style="position:fixed;left:20px;bottom:20px;">
<a href="https://wa.link/xwzqx1">
<button style="background:#32C03C;vertical-align:center;height:36px;border-radius:5px">
<img src="images/wa.jpg"> Kontak Kami</button></a>
</div>



















<a href="#kingster-top-anchor" class="kingster-footer-back-to-top-button" id="kingster-footer-back-to-top-button"><i class="fa fa-angle-up" ></i></a>
<style>@media only screen and (max-width: 999px){#gdlr-core-column-1 .gdlr-core-pbf-column-content-margin{padding-bottom: 5px !important;}}@media only screen and (max-width: 999px){#gdlr-core-column-1 .gdlr-core-pbf-column-content-margin{margin-bottom: 5px !important;}}@media only screen and (max-width: 767px){#gdlr-core-column-1 .gdlr-core-pbf-column-content-margin{padding-bottom: 5px !important;}}@media only screen and (max-width: 767px){#gdlr-core-column-1 .gdlr-core-pbf-column-content-margin{margin-bottom: 5px !important;}}#gdlr-core-title-item-id-22003 .gdlr-core-title-item-title a{ color:#ffffff; }#gdlr-core-title-item-id-22003 .gdlr-core-title-item-title a:hover{ color:#ff4800; }@media only screen and (max-width: 999px){#gdlr-core-column-2 .gdlr-core-pbf-column-content-margin{padding-bottom: 5px !important;}}@media only screen and (max-width: 999px){#gdlr-core-column-2 .gdlr-core-pbf-column-content-margin{margin-bottom: 5px !important;}}@media only screen and (max-width: 767px){#gdlr-core-column-2 .gdlr-core-pbf-column-content-margin{padding-bottom: 5px !important;}}@media only screen and (max-width: 767px){#gdlr-core-column-2 .gdlr-core-pbf-column-content-margin{margin-bottom: 5px !important;}}#gdlr-core-title-item-id-47003 .gdlr-core-title-item-title a{ color:#ffffff; }#gdlr-core-title-item-id-47003 .gdlr-core-title-item-title a:hover{ color:#ff4800; }@media only screen and (max-width: 999px){#gdlr-core-column-3 .gdlr-core-pbf-column-content-margin{padding-bottom: 5px !important;}}@media only screen and (max-width: 999px){#gdlr-core-column-3 .gdlr-core-pbf-column-content-margin{margin-bottom: 5px !important;}}@media only screen and (max-width: 767px){#gdlr-core-column-3 .gdlr-core-pbf-column-content-margin{padding-bottom: 5px !important;}}@media only screen and (max-width: 767px){#gdlr-core-column-3 .gdlr-core-pbf-column-content-margin{margin-bottom: 5px !important;}}#gdlr-core-title-item-id-18789 .gdlr-core-title-item-title a{ color:#ffffff; }#gdlr-core-title-item-id-18789 .gdlr-core-title-item-title a:hover{ color:#ff4800; }@media only screen and (max-width: 999px){#gdlr-core-column-4 .gdlr-core-pbf-column-content-margin{padding-bottom: 5px !important;}}@media only screen and (max-width: 999px){#gdlr-core-column-4 .gdlr-core-pbf-column-content-margin{margin-bottom: 5px !important;}}@media only screen and (max-width: 767px){#gdlr-core-column-4 .gdlr-core-pbf-column-content-margin{padding-bottom: 5px !important;}}@media only screen and (max-width: 767px){#gdlr-core-column-4 .gdlr-core-pbf-column-content-margin{margin-bottom: 5px !important;}}#gdlr-core-title-item-id-6087 .gdlr-core-title-item-title a{ color:#ffffff; }#gdlr-core-title-item-id-6087 .gdlr-core-title-item-title a:hover{ color:#ff4800; }@media only screen and (max-width: 999px){#gdlr-core-column-5 .gdlr-core-pbf-column-content-margin{padding-bottom: 5px !important;}}@media only screen and (max-width: 999px){#gdlr-core-column-5 .gdlr-core-pbf-column-content-margin{margin-bottom: 5px !important;}}@media only screen and (max-width: 767px){#gdlr-core-column-5 .gdlr-core-pbf-column-content-margin{padding-bottom: 5px !important;}}@media only screen and (max-width: 767px){#gdlr-core-column-5 .gdlr-core-pbf-column-content-margin{margin-bottom: 5px !important;}}#gdlr-core-title-item-id-5841 .gdlr-core-title-item-title a{ color:#ffffff; }#gdlr-core-title-item-id-5841 .gdlr-core-title-item-title a:hover{ color:#ff4800; }@media only screen and (max-width: 999px){#gdlr-core-column-6 .gdlr-core-pbf-column-content-margin{padding-bottom: 5px !important;}}@media only screen and (max-width: 999px){#gdlr-core-column-6 .gdlr-core-pbf-column-content-margin{margin-bottom: 5px !important;}}@media only screen and (max-width: 767px){#gdlr-core-column-6 .gdlr-core-pbf-column-content-margin{padding-bottom: 5px !important;}}@media only screen and (max-width: 767px){#gdlr-core-column-6 .gdlr-core-pbf-column-content-margin{margin-bottom: 5px !important;}}#gdlr-core-title-item-id-33979 .gdlr-core-title-item-title a{ color:#ffffff; }#gdlr-core-title-item-id-33979 .gdlr-core-title-item-title a:hover{ color:#ff4800; }@media only screen and (max-width: 999px){#gdlr-core-column-7 .gdlr-core-pbf-column-content-margin{padding-bottom: 5px !important;}}@media only screen and (max-width: 999px){#gdlr-core-column-7 .gdlr-core-pbf-column-content-margin{margin-bottom: 5px !important;}}@media only screen and (max-width: 767px){#gdlr-core-column-7 .gdlr-core-pbf-column-content-margin{padding-bottom: 5px !important;}}@media only screen and (max-width: 767px){#gdlr-core-column-7 .gdlr-core-pbf-column-content-margin{margin-bottom: 5px !important;}}#gdlr-core-title-item-id-76371 .gdlr-core-title-item-title a{ color:#ffffff; }#gdlr-core-title-item-id-76371 .gdlr-core-title-item-title a:hover{ color:#ff4800; }@media only screen and (max-width: 999px){#gdlr-core-column-8 .gdlr-core-pbf-column-content-margin{padding-bottom: 5px !important;}}@media only screen and (max-width: 999px){#gdlr-core-column-8 .gdlr-core-pbf-column-content-margin{margin-bottom: 5px !important;}}@media only screen and (max-width: 767px){#gdlr-core-column-8 .gdlr-core-pbf-column-content-margin{padding-bottom: 5px !important;}}@media only screen and (max-width: 767px){#gdlr-core-column-8 .gdlr-core-pbf-column-content-margin{margin-bottom: 5px !important;}}#gdlr-core-title-item-id-80471 .gdlr-core-title-item-title a{ color:#ffffff; }#gdlr-core-title-item-id-80471 .gdlr-core-title-item-title a:hover{ color:#ff4800; }#gdlr-core-button-id-30852{font-size: 20px ;color: #302b60 ;padding-top: 25px;padding-bottom: 25px;border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background: #ffcc00 ;}#gdlr-core-button-id-30852:hover{color: #ff4800 ;}#gdlr-core-title-item-id-32422 .gdlr-core-title-item-title a{ color:#302b60; }</style>			<script type="text/javascript">
				function revslider_showDoubleJqueryError(sliderID) {
					var errorMessage = "Revolution Slider Error: You have some jquery.js library include that comes after the revolution files js include.";
					errorMessage += "<br> This includes make eliminates the revolution slider libraries, and make it not work.";
					errorMessage += "<br><br> To fix it you can:<br>&nbsp;&nbsp;&nbsp; 1. In the Slider Settings -> Troubleshooting set option:  <strong><b>Put JS Includes To Body</b></strong> option to true.";
					errorMessage += "<br>&nbsp;&nbsp;&nbsp; 2. Find the double jquery.js include and remove it.";
					errorMessage = "<span style='font-size:16px;color:#BC0C06;'>" + errorMessage + "</span>";
						jQuery(sliderID).show().html(errorMessage);
				}
			</script>
			<script type='text/javascript' src='wp-content/plugins/goodlayers-core/plugins/combine/script6a4d.js?ver=6.1.1' id='gdlr-core-plugin-js'></script>
			<script type='text/javascript' id='gdlr-core-page-builder-js-extra'>
/* <![CDATA[ */
var gdlr_core_pbf = {"admin":"","video":{"width":"640","height":"360"},"ajax_url":"wp-admin\/admin-ajax.php"};
/* ]]> */
</script>
<script type='text/javascript' src='wp-content/plugins/goodlayers-core/include/js/page-builderd36b.js?ver=1.3.9' id='gdlr-core-page-builder-js'></script>
<script type='text/javascript' src='wp-includes/js/jquery/ui/effect.min3f14.js?ver=1.13.2' id='jquery-effects-core-js'></script>

<script type='text/javascript' src='wp-content/themes/kingster/js/script-core8a54.js?ver=1.0.0' id='kingster-script-core-js'></script>




							
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									