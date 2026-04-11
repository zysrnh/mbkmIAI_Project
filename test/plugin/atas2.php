
			<?php
global $koneksi_db, $maxkonten;
$perintah="SELECT * FROM mod_data_profil";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				$id = md5($data['id']);
			
					
					
			
 echo '   
 
<div class="kingster-body-outer-wrapper " >
		<div class="kingster-body-wrapper clearfix  kingster-with-frame">
	<div class="kingster-top-bar" ><div class="kingster-top-bar-background"  style="background:'.$data['warnah'].';"></div><div class="kingster-top-bar-container kingster-container " ><div class="kingster-top-bar-container-inner clearfix" ><div class="kingster-top-bar-right kingster-item-pdlr"><ul id="kingster-top-bar-menu" class="sf-menu kingster-top-bar-menu kingster-top-bar-right-menu">
<li  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-9306 kingster-normal-menu" style="color:white;">Telp. '.$data['telp'].' | </li>
<li  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-9306 kingster-normal-menu" style="color:white;">Email : '.$data['email'].'</li>

</ul></div></div></div></div>	
<header class="kingster-header-wrap kingster-header-style-plain  kingster-style-menu-right kingster-sticky-navigation kingster-style-fixed" data-navigation-offset="75px"  >
	<div class="kingster-header-background" ></div>
	<div class="kingster-header-container  kingster-container">
			
		<div class="kingster-header-container-inner clearfix">
			<div class="kingster-logo  kingster-item-pdlr"><div class="kingster-logo-inner"><a class="" href="index.html" ><img  src="images/'.$data['foto'].'" width="120" height="50"  srcset="images/'.$data['foto'].' 400w, images/'.$data['foto'].' 600w, images/'.$data['foto'].' 722w"  sizes="(max-width: 767px) 100vw, (max-width: 1150px) 100vw, 1150px"  alt="" /></a></div></div>			<div class="kingster-navigation kingster-item-pdlr clearfix " >
			<div class="kingster-main-menu" id="kingster-main-menu" >
<ul id="menu-pmb-menu-1" class="sf-menu">






 
'; 
					
} ?>	
						