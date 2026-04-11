
<?php
global $koneksi_db, $maxkonten;
$perintah="SELECT * FROM mod_data_profil";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				$id = md5($data['id']);
				
					
					
			
 echo '   

<div class="gdlr-core-pbf-wrapper " style="padding: 10px 0px 10px 0px;" >
<div class="gdlr-core-pbf-background-wrap" style="background-color: #93E8ED ;"  ></div>
<div class="gdlr-core-pbf-wrapper-content gdlr-core-js "   ><div class="gdlr-core-pbf-wrapper-container clearfix gdlr-core-pbf-wrapper-full-no-space" >
<div class="gdlr-core-pbf-element" ><div class="gdlr-core-title-item gdlr-core-item-pdb clearfix  gdlr-core-center-align gdlr-core-title-item-caption-bottom gdlr-core-item-pdlr" style="padding-bottom: 0px ;"  >
<div class="gdlr-core-title-item-title-wrap clearfix" ><marquee class="gdlr-core-title-item-title gdlr-core-skin-title " style="font-size: 20px ;color: #302b60 ;text-transform:uppercase;"  >'.$data['nama'].'</marquee>
</div><span class="gdlr-core-title-item-caption gdlr-core-info-font gdlr-core-skin-caption" style="font-size: 15px ;font-style: normal ;color: #302b60 ;margin-top: 0px ;"  >'.$data['alamat'].'</span>
</div>
</div>
</div>
</div>
</div>

<p style="text-align: center;"></p>
<div class="progress">


</div>







 
'; 
					
} ?>	

<div class="gdlr-core-pbf-wrapper " style="margin: 30px 30px 0px 30px;padding: 20px 0px 0px 0px;" >
<div class="gdlr-core-pbf-background-wrap"  ></div>
<div class="gdlr-core-pbf-wrapper-content gdlr-core-js "   >
<div class="gdlr-core-pbf-wrapper-container clearfix gdlr-core-container" >








		   				
<?php
$perintah="SELECT * FROM mod_data_layanan ORDER By id DESC LIMIT 12";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				
					$url=str_replace(" ", "-", $data[1]);
			
 echo '<div class="gdlr-core-pbf-column gdlr-core-column-15 gdlr-core-column" >
<div class="gdlr-core-pbf-column-content-margin gdlr-core-js " style="margin: 0px 5px 5px 0px;padding: 0px 0px 0px 0px;"   >
<div class="gdlr-core-pbf-background-wrap" style="background-color: #506498 ;"  ></div>



<div class="gdlr-core-pbf-column-content clearfix gdlr-core-js "   >
<div class="gdlr-core-pbf-element" ><div class="gdlr-core-image-item gdlr-core-item-pdlr gdlr-core-item-pdb  gdlr-core-center-align" style="padding-bottom: 10px ;"  >
<div class="gdlr-core-image-item-wrap gdlr-core-media-image  gdlr-core-image-item-style-rectangle" style="border-width: 0px;"  >
<a href="'.$data['link'].'" target="_self" ><i class="fa fa-'.$data['icon'].'"  style="color:white;font-size:84px;margin-top:40px;"></i></a>
</div>
</div>
</div>


<div class="gdlr-core-pbf-element" ><div class="gdlr-core-title-item gdlr-core-item-pdb clearfix  gdlr-core-center-align gdlr-core-title-item-caption-top gdlr-core-item-pdlr"  id="gdlr-core-title-item-id-22003"  >
<div class="gdlr-core-title-item-title-wrap clearfix" >
<h3 class="gdlr-core-title-item-title gdlr-core-skin-title " style="font-size: 15px ;letter-spacing: 0px ;text-transform: none ;color: #ffffff ;"  ><a href="'.$data['link'].'" target="_self" >'.$data['nama'].'</a></h3>
</div>
</div>
</div>
</div>

</div>
</div>
 



 
 
 
'; 
					
} ?>	         							





















</div>



</div>
</div>




<div class="gdlr-core-pbf-wrapper " style="padding: 0px 0px 0px 0px;" ><div class="gdlr-core-pbf-background-wrap"  >
</div>


<div class="gdlr-core-pbf-wrapper-content gdlr-core-js "   >
<div class="gdlr-core-pbf-wrapper-container clearfix gdlr-core-container" >
<div class="gdlr-core-pbf-column gdlr-core-column-60 gdlr-core-column-first" >


<div class="gdlr-core-pbf-column-content-margin gdlr-core-js " style="padding: 0px 0px 0px 0px;border-right-width: 1px;border-left-width: 1px;border-color: #ffffff ;border-style: solid ;"   ><div class="gdlr-core-pbf-column-content clearfix gdlr-core-js "   >
<div class="gdlr-core-pbf-element" ><div class="gdlr-core-title-item gdlr-core-item-pdb clearfix  gdlr-core-center-align gdlr-core-title-item-caption-bottom gdlr-core-item-pdlr" style="padding-bottom: 5px ;"  >
<div class="gdlr-core-title-item-title-wrap clearfix" ><h3 class="gdlr-core-title-item-title gdlr-core-skin-title " style="font-size: 10px ;color: #302b60 ;"  ></h3></div></div></div><div class="gdlr-core-pbf-element" ><div class="gdlr-core-divider-item gdlr-core-divider-item-small-center gdlr-core-item-pdlr" style="margin-top: 0px ;"  ><div class="gdlr-core-divider-line gdlr-core-skin-divider" style="border-color: #f68c19 ;"  ><div class="gdlr-core-divider-line-bold  gdlr-core-skin-divider" style="border-color: #f68c19 ;"  ></div></div></div></div></div></div>
<p style="text-align: center;"><span style="background-color: FF9900;"><a class="btn btn-info btn-large" style="background-color: 0099FF;" rel="noopener"><strong>MEDIA SOSIAL KAMPUS</strong></a></span></p>

</div>
</div>
</div>
</div>






<div class="gdlr-core-pbf-wrapper " style="padding: 10px 0px 30px 0px;" >
<div class="gdlr-core-pbf-background-wrap"  ></div>


<div class="gdlr-core-pbf-wrapper-content gdlr-core-js "   >
<div class="gdlr-core-pbf-wrapper-container clearfix gdlr-core-container" >






		   				
<?php
$perintah="SELECT * FROM mod_data_layanan2 ORDER By id DESC LIMIT 12";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				
					$url=str_replace(" ", "-", $data[1]);
			
 echo '
 
<div class="gdlr-core-pbf-column gdlr-core-column-12 gdlr-core-column" >

<div class="gdlr-core-pbf-column-content-margin gdlr-core-js " style="padding: 0px 0px 0px 0px;border-right-width: 1px;border-left-width: 1px;border-color: #ffffff ;border-style: solid ;"   >

<div class="gdlr-core-pbf-column-content clearfix gdlr-core-js "   >
<div class="gdlr-core-pbf-element" >
<div class="gdlr-core-image-item gdlr-core-item-pdlr gdlr-core-item-pdb  gdlr-core-center-align" style="padding-bottom: 10px ;"  >
<div class="gdlr-core-image-item-wrap gdlr-core-media-image  gdlr-core-image-item-style-rectangle" style="border-width: 0px;"  >
<a href="'.$data['link'].'" target="_self" ><i style="font-size:64px;" class="fa fa-'.$data['icon'].'"></i></a></div>
</div>
</div>

<div class="gdlr-core-pbf-element" >
<div class="gdlr-core-text-box-item gdlr-core-item-pdlr gdlr-core-item-pdb gdlr-core-center-align" style="padding-bottom: 10px ;"  >
<div class="gdlr-core-text-box-item-content" style="text-transform: none ;"  >
<p><a href="'.$data['link'].'"><span style="color: #000000;"><strong>'.$data['nama'].'</strong></span></a></p>
</div>
</div>
</div>
</div>
</div>


</div>



 
'; 
					
} ?>	         							















































</div></div>

</div>


<div class="gdlr-core-pbf-wrapper " style="padding: 0px 0px 0px 0px;" >
<div class="gdlr-core-pbf-background-wrap" style="background-color: #808080 ;"  ></div>
<div class="gdlr-core-pbf-wrapper-content gdlr-core-js "   >
<div class="gdlr-core-pbf-wrapper-container clearfix gdlr-core-pbf-wrapper-full" >
<div class="gdlr-core-pbf-column gdlr-core-column-30 gdlr-core-column-first" >



<div class="gdlr-core-pbf-column-content-margin gdlr-core-js " style="padding: 30px 0px 0px 0px;"   >
<div class="gdlr-core-pbf-column-content clearfix gdlr-core-js "   >





<div class="gdlr-core-pbf-element" >
<div class="gdlr-core-image-item gdlr-core-item-pdlr gdlr-core-item-pdb  gdlr-core-right"  >
<div class="gdlr-core-image-item-wrap gdlr-core-media-image  gdlr-core-image-item-style-rectangle" style="border-width: 0px;margin-left:30px;"  >





<div class="gdlr-core-pbf-element" >
<div class="gdlr-core-blog-item gdlr-core-item-pdb clearfix  gdlr-core-style-blog-list" style="padding-bottom: 10px ;"  >





<div class="gdlr-core-block-item-title-wrap  gdlr-core-left-align gdlr-core-item-mglr" style="margin-bottom: 5px ;"  >
<div class="gdlr-core-block-item-title-inner clearfix" ><h3 class="gdlr-core-block-item-title" style="font-size: 24px ;font-style: normal ;text-transform: none ;color: #163269 ;"  >Pertanyaan Seputar PCMB<br/><br/></h3>
<div class="gdlr-core-block-item-title-divider" style="font-size: 24px ;border-bottom-width: 3px ;"  ></div></div>
</div>



				
<div class="gdlr-core-accordion-item gdlr-core-item-mglr gdlr-core-item-mgb  gdlr-core-accordion-style-background-title-icon gdlr-core-left-align gdlr-core-icon-pos-right gdlr-core-allow-close-all"  >
	   				
<?php
$perintah="SELECT * FROM mod_data_faq ORDER By rand() LIMIT 5";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_ixx++;
				
					$url=str_replace(" ", "-", $data[1]);
			if($coint_ixx==1)
			{
				$show = 'show';
			} else {
				$show = '';
			}
 echo '
 




<div class="gdlr-core-accordion-item-tab clearfix "><div  class="gdlr-core-accordion-item-icon gdlr-core-js gdlr-core-skin-icon " ></div>

<div class="gdlr-core-accordion-item-content-wrapper" ><h5 class="gdlr-core-accordion-item-title gdlr-core-js  gdlr-core-skin-e-background gdlr-core-skin-e-content"   style="padding:12px;">'.$data['nama'].'</h5>
<div class="gdlr-core-accordion-item-content" style="padding:12px;"><p>'.$data['ket'].'</p>
</div>

</div>

</div>








 
 
'; 
					
} ?>	         									

 
  


</div>

















</div>
</div>


</div>
</div>
</div>
</div>
</div>

</div>

<div class="gdlr-core-pbf-column gdlr-core-column-30" >
<div class="gdlr-core-pbf-column-content-margin gdlr-core-js " style="margin: 10px 40px 0px 40px;padding: 20px 0px 0px 0px;"   >
<div class="gdlr-core-pbf-column-content clearfix gdlr-core-js "   >



<div class="gdlr-core-pbf-element" ><div class="gdlr-core-video-item gdlr-core-item-pdlr gdlr-core-item-pdb " style="padding-bottom: 10px ;"  >
<div class="gdlr-core-video-item-type-youtube" >		
<?php
$perintah="SELECT * FROM mod_data_video ORDER By id DESC LIMIT 1";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_ix++;
				
	
 echo '

 <iframe
src="https://www.youtube.com/embed/'.$data['video'].'" widht="100%">
</iframe>
 
 
'; 
					
} ?>	         	
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>