








<div id="gdlr-core-recent-post-widget-2" class="widget widget_gdlr-core-recent-post-widget kingster-widget">
<div class="gdlr-core-block-item-title-inner clearfix" ><h3 class="gdlr-core-block-item-title" style="font-size: 24px ;font-style: normal ;text-transform: none ;color: #163269 ;"  >INFO PCMB</h3><hr/>
<div class="gdlr-core-block-item-title-divider" style="font-size: 24px ;border-bottom-width: 3px ;color:black;"  ></div></div>
<div class="gdlr-core-recent-post-widget-wrap gdlr-core-style-4">




<ul id="menu-about-umsida" class="gdlr-core-custom-menu-widget gdlr-core-menu-style-list">


                                      
								
							
											
			
<?php
global $koneksi_db, $maxkonten;
$perintah="SELECT * FROM artikel WHERE publikasi='1' ORDER BY `id` DESC limit 5";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
?>
<?php
				while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				$id = $data[0];
$url=str_replace(" ", "-", $data[1]);
$post   = $data[2];
	$na = catch_that_image($post);
	$idzz = $data['id'];
	$topik = $data['topik'];
	$gambar = $data['gambar'];
$ada=$koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM komentar where artikel='".$idzz."'"));

$propinsi4 = $koneksi_db->sql_query("SELECT * FROM topik WHERE id='$topik'");
while($p4=$koneksi_db->sql_fetchrow($propinsi4)){
	$kelas24 = $p4['topik'];
}

				?>
			
					<?php echo '
<li  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-28294 kingster-normal-menu"><a href="artikel/'.$data[0].'/'.$url.'.html" title="'.$data[1].'" style="font-size:14px;">'.limitTXT(strip_tags($data[1]),50).'</a></li>

					
					
					

					'; ?>
<?php } ?>						  
				  		</ul>
</div>
</div>

									
								