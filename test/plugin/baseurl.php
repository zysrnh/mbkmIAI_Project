<?php
		$actual_linkwa = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
echo '<link rel="canonical" href="'.$actual_linkwa.'" />';

$pilih = $_GET['pilih'];
if($pilih=='artikel')
{
    
    $idb = $_GET['id'];
 $prop1xy22b= $koneksi_db->sql_query("SELECT * FROM artikel WHERE id='$idb'");
while($pr1xy22b=$koneksi_db->sql_fetchrow($prop1xy22b)){
$namakat22b = $pr1xy22b['judul'];
$kontenb = $pr1xy22b['konten'];
$gambarb = $pr1xy22b['gambar'];
}   
    
    echo '
      <meta property="og:url"           content="'.$actual_linkwa.'" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="'.$namakat22b.'" />
  <meta property="og:description"   content="'.limittxt(htmlentities(strip_tags($kontenb)),140).'" />
  <meta property="og:image"         content="https://'.$_SERVER['SERVER_NAME'].'/images/artikel/'.$gambarb.'" />
  
  	 <meta property="og:image" itemprop="image" content="https://'.$_SERVER['SERVER_NAME'].'/images/artikel/'.$gambarb.'" />
<meta itemprop="thumbnailUrl" content="https://'.$_SERVER['SERVER_NAME'].'/'.catch_that_image($kontenb).'" />
<meta itemprop="publisher" itemscope itemtype="http://schema.org/Organization" content="https://'.$_SERVER['SERVER_NAME'].'">
<meta itemprop="name" content="https://'.$_SERVER['SERVER_NAME'].'">
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="@haripratomo" />
<meta name="twitter:image" content="https://'.$_SERVER['SERVER_NAME'].'/images/artikel/'.$gambarb.'" />
<meta name="twitter:description" content="'.limittxt(htmlentities(strip_tags($kontenb)),140).'" />

			 

    ';
    
    
}


?>

