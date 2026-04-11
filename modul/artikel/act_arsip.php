<div><div class="color_transition_03"><?
/**
 *  Hari Pratomo, S.Pd.T  - http://www.klatenweb.com
 *  Produk Script Website Versi Kla 4.1
 *  Support. 08175499076/27F25DBC/admin@klatenweb.com
 *  FB: http://facebook.com/scriptkiddies
**/


$index_hal = 1;
if (!empty($_GET['date'])){
	if (preg_match('/\d{4}\.\d{2}/',$_GET['date'])) {
		list($tahun,$bulan) = explode('.',cleartext($_GET['date']));
		if (checkdate($bulan,1,$tahun)) {
			include 'modul/news/include/function.php';
			echo '<h1><span class="judul">Arsip pada bulan : '.$translateKal_1[$bulan].' '.$tahun.'</span></h4><br/><p>';
		
			
			
			$totals = $koneksi_db->sql_query( "SELECT * FROM `artikel` WHERE month(`tgl`) = '$bulan' AND year(`tgl`) = '$tahun' AND publikasi = 1" );
			$jumlah = $koneksi_db->sql_fetchrow ( $totals );
		$a = new paging ($limit);
		
					
			if ($jumlah > 0) {		
			$query = $koneksi_db->sql_query("SELECT * FROM `artikel` WHERE month(`tgl`) = '$bulan' AND year(`tgl`) = '$tahun' AND publikasi = 1 ORDER BY `tgl` DESC");
			while($data = $koneksi_db->sql_fetchrow($query)) {
				$url=str_replace(" ", "-", $data['judul']);
								echo '
				<h4>'.$data['judul'].'</h4>
<div class="news">
'.datetimes($data['tgl']).'<br/>
<span class="align-justify">'.limitTXT(strip_tags($data['konten']),480).'</span>
</div>		
			
<p class="post-footer">					
<a class="more-link" href="article-'.$data['id'].'-'.$url.'.html" title="'.$data['judul'].'">Read More &raquo;</a>


</p>';
				}
			}else {
				echo '<div class="error" style="width:30%">Tidak Ada arsip...</div>';
			}
				
			
			
			
			
			
		}else {
			echo '<h4 class="bg"><span class="judul">Error ...</h4>';
			echo '<div class="error" style="width:20%">format date salah</div>';
		}
		
	}else {
		echo '<h4 class="bg"><span class="judul">Error ...</h4>';
		echo '<div class="error" style="width:30%">Paramater date salah,<br/> contoh : 2008.01</div>';
	}
}
?></div></div>