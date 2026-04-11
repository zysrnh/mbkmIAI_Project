<?php



if (!defined('cms-KONTEN')) {
	Header("Location: ../index.php");
	exit;
}
 

global $koneksi_db,$maxdata;

$query = cleartext($_GET['query']);



if($query=='' or !isset($query)){
	$tengah .="<div class=\"error\">No Result</div>";
}else{

	$limit = 10;
	$s1 = '';
	$query = htmlentities($query);
	
	
	$hasil= $koneksi_db->sql_query("SELECT * FROM artikel WHERE ((judul LIKE '%$query%' OR konten LIKE '%$query%' OR user LIKE '%$query%')AND publikasi=1)");
	$jumlah= $koneksi_db->sql_numrows($hasil);

	if ($jumlah<1){
		$s1="tidak ada";
	}

	$a = new paging ($limit);

if (!$s1) {
$urlkontenxc=str_replace(" ", ", ", $query);

$judul_situs = ucwords($query);
$_META['description'] = ucwords($query);
$_META['keywords'] = $urlkontenxc;





	$tengah .='<h4>'.ucwords($query).'</h4>   ';

	
	
	$offset = int_filter(@$_GET['offset']);
	$pg		= int_filter(@$_GET['pg']);
	$stg	= int_filter(@$_GET['stg']);
	
	$hasil2= $koneksi_db->sql_query("SELECT * FROM artikel WHERE ((judul LIKE '%$query%' OR konten LIKE '%$query%' OR user LIKE '%$query%')AND publikasi=1) ORDER By id LIMIT $offset,$limit");

	



	$tengah .= "Found <b>".$jumlah."</b> article containing words: <b>$query</b><br/><br/> ";



	while($data = $koneksi_db->sql_fetchrow($hasil2)){
	$id = $data[0];
		$url=str_replace(" ", "-", $data[1]);
	$urltgl=str_replace("-", "/", $data[5]);
	$gambar = $data['gambar'];
	
		$tengah .= '
		
		
		                
                                            
                                                <h5 style="font-size:18px;margin-bottom:0px;">
                                                   <b> <a href="artikel/'.$data[0].'/'.$url.'.html" title="'.$data[1].'">'.$data[1].'</a></b>
                                                </h5> <span><i class="fa fa-calendar"></i> '.datetimess($data[5]).'</span>
												<p>'.limitTXT(strip_tags($data['konten']),180).' </p>
                                                
                                        
					
			
		
		
		
		
		
		
		
		
		
		

';	
		}



	if($jumlah>=10){

	if (empty($_GET['offset']) and !isset ($_GET['offset'])) {
	$offset = 0;
	}
	if (empty($_GET['pg']) and !isset ($_GET['pg'])) {
	$pg = 1;
	}
	if (empty($_GET['stg']) and !isset ($_GET['stg'])) {
	$stg = 1;
	}
	
	
	
	$tengah .='<div class="border" style="text-align:center;">';
	
	$queryx = $query;
	$tengah .= $a-> getPaging3($jumlah, $pg, $stg,$queryx);
	$tengah .='</div>';

	}
} //akhir if $s1


if ($s1) {
		$tengah.='<div class="error">Result with keyword : <b>'.$query.'</b> <br />not found.</div>';

}

}

echo $tengah;

?>