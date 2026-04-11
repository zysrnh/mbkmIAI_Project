<h4>Detail Event</h4><br/><p>
<?php

 

$seldate = (int)int_filter ($_GET['sel_date']);	
$t = getdate($seldate);
$_GET['waktu_akhir'] = isset($_GET['waktu_akhir']) ? $_GET['waktu_akhir'] : null;
$u = getdate((int)int_filter ($_GET['waktu_akhir']));
if (isset ($_GET['sel_date'])){

$content .='<div>';	
$content .= '<table width="100%">';	
	
	
	
 $JUDULCAL = array ();
    $TMPpesan = array() ;
    $awalbulandengannol = $t['mon'] >= 10 ? $t['mon'] : '0'.$t['mon'];
    $varwaktucalender = $t['year'] . '-' . $awalbulandengannol . '-' . $t['mday'];
    
    $awalbulandengannol2 = $u['mon'] >= 10 ? $u['mon'] : '0'.$u['mon'];
    $varwaktucalender2 = $u['year'] . '-' . $awalbulandengannol2 . '-' . $u['mday'];
  

   
    $cekdate = $koneksi_db->sql_query ("SELECT `judul`,`waktu_mulai`,`waktu_akhir`,`isi` FROM `tbl_kalender` WHERE `waktu_mulai` = '$varwaktucalender' OR `waktu_akhir` = '$varwaktucalender2' ORDER BY `waktu_mulai`");
    while ($getdate = $koneksi_db->sql_fetchrow($cekdate)){
	   // print_r($getdate);
	    $WKTMULAI = $getdate['waktu_mulai'];
	    $WKTAKHIR = $getdate['waktu_akhir'];
	    $GTTGL = (int)substr($WKTMULAI, -2, 2);
	    $TGLMULAI[$GTTGL] = $GTTGL; // 
	    $JUDULCAL[$GTTGL] = $getdate['judul'];
	    $idssss =  '<b><h4>'.$getdate['judul'].'</h4><br/><p></b><br><small>Periode Awal : '.converttgl ($WKTMULAI).'<br>Periode Akhir : '.converttgl ($WKTAKHIR).'</small>
                        <br>'.limitTXT($getdate['isi'],150).'';
	    
	 
	    $content .= '<tr><td style="font-weight:bold;border-bottom:solid 1px #efefef">'.$getdate['judul'].'</td></tr>';
	     $content .= '<tr><td style="color:orange;padding-top:5px;">'.converttgl ($WKTMULAI).' S/D '.converttgl ($WKTAKHIR).'</td></tr>';
	    $content .= '<tr><td style="border-bottom:solid 1px #efefef;">'.nl2br($getdate['isi']).'</td></tr>';
			   
    	
    		
    	
    	
    		
    		
    }


$content .= '</table>';	
$content .= '</div>';	



}

echo $content;

?>

