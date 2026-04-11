<?php


ob_start();
header("content-type: text/xml; charset=utf-8");

include "ikutan/config.php";
include "ikutan/mysqli.php";
include 'ikutan/feedcreator.class.php'; 

global $koneksi_db;
$_GET['aksi'] = isset($_GET['aksi']) ? $_GET['aksi'] : 'rss20';
$rss = new UniversalFeedCreator(); 
$rss->useCached(); 
$rss->title 		= $judul_situs; 
$rss->description 	= $slogan; 
$rss->link 		= $url_situs; 
$rss->feedURL 		= $url_situs."/".$_SERVER['PHP_SELF'];
$rss->syndicationURL 	= $url_situs; 
$rss->cssStyleSheet 	= NULL; 

$image = new FeedImage(); 
$image->title 		= $slogan; 
$image->url 		= "$url_situs/images/browser-48x48.png"; 
$image->link 		= $url_situs; 
$image->description 	= "Feed, Support by Administrator."; 

$rss->image = $image; 

// Ngambil dari database 

$hasil = $koneksi_db->sql_query( "SELECT * FROM artikel WHERE publikasi=1 ORDER BY id DESC LIMIT 10" );

while ($data = $koneksi_db->sql_fetchrow($hasil)) {

	$tanggal  = $data['tgl'];		
	$judulnya = $data[1];
	$isinya   = $data[2];
	$id	  = $data[0];
	$author   = $data[3];

$urltgl=str_replace("-", "/", $data[5]);
$url=str_replace(" ", "-", $data[1]);

	$item = new FeedItem(); 
	$item->title 		= $judulnya;
	$item->link 		= ''.$url_situs.'/artikel/'.$data[0].'/'.$url.'.html';
	$item->description 	= limitTXT(strip_tags($isinya),450); 	
	$item->date   = strtotime($tanggal); 
	$item->source = $url_situs;
	$item->author = $author;
		 
	$rss->addItem($item); 

} 

// valid format strings are: RSS0.91, RSS1.0, RSS2.0, PIE0.1 (deprecated),
// MBOX, OPML, ATOM, ATOM10, ATOM0.3, HTML, JS


if($_GET['aksi'] =='rss091'){
	$info['feed'] 		= 'RSS0.91';
	echo $rss->saveFeed( $info['feed'], 'modul/xml/rss091.xml');		
}elseif($_GET['aksi'] =='rss10'){
	$info[ 'feed' ] 		= 'RSS1.0';
	echo $rss->saveFeed( $info[ 'feed' ], 'modul/xml/rss10.xml');		
}elseif($_GET['aksi'] =='rss20'){
	$info[ 'feed' ] 		= 'RSS2.0';
	echo $rss->saveFeed( $info[ 'feed' ], 'modul/xml/rss20.xml');		
}elseif($_GET['aksi'] =='atom03'){
	$info[ 'feed' ] 		= 'ATOM0.3';
	echo $rss->saveFeed( $info[ 'feed' ], 'modul/xml/atom03.xml');		
}elseif($_GET['aksi'] =='opml'){
	$info[ 'feed' ] 		= 'OPML';
	echo $rss->saveFeed( $info[ 'feed' ], 'modul/xml/opml.xml');		
}elseif($_GET['aksi'] =='pie01'){
	$info[ 'feed' ] 		= 'PIE0.1';
	echo $rss->saveFeed( $info[ 'feed' ],'modul/xml/pie01.xml');		
}elseif($_GET['aksi'] =='mbox'){
	$info[ 'feed' ] 		= 'MBOX';
	echo $rss->saveFeed( $info[ 'feed' ], 'modul/xml/mbox.xml');		
}elseif($_GET['aksi'] =='html'){
	$info[ 'feed' ] 		= 'HTML';
	echo $rss->saveFeed( $info[ 'feed' ], 'modul/xml/html.xml');		
}elseif($_GET['aksi'] =='js'){
	$info[ 'feed' ] 		= 'JS';
	echo $rss->saveFeed( $info[ 'feed' ], 'modul/xml/js.xml');		
}elseif($_GET['aksi'] =='atom'){
	$info[ 'feed' ] 		= 'ATOM';
	echo $rss->saveFeed( $info[ 'feed' ], 'modul/xml/atom.xml');		
}elseif($_GET['aksi'] =='atom10'){
	$info[ 'feed' ] 		= 'ATOM10';
	echo $rss->saveFeed( $info[ 'feed' ], 'modul/xml/atom10.xml');		
}		
	

?>