<h4>Direktori Links</h4><br/><p>
<?php

  $pilih = cleartext($_GET['pilih']);

$seo1= $koneksi_db->sql_query("SELECT * FROM mod_data_meta WHERE nama='$pilih'");
while($pr1xypd=$koneksi_db->sql_fetchrow($seo1)){
	$judulseo1 = $pr1xypd['judul'];
$desseo1 = $pr1xypd['meta'];
$keyseo1 = $pr1xypd['tags'];
}

$judul_situs = $judulseo1;
$_META['description'] = $desseo1;
$_META['keywords'] = $keyseo1;


$tengah='';
$tengah .= <<<ajax
<div id="load" style="display: none; width: 100px; color: #fff;  height: 17px; background-color: red;position:absolute;top:50%;left:50%;padding:2px;"> Loading<span id="ellipsis">...</span></div>
<div id="headerlink"></div>
<div id="respon"></div>

<script type="text/javascript" src="modul/links/js/link.uncompress-1.js"></script>
<script type="text/javascript">
window.onload = weblink.links;
</script>
ajax;


echo $tengah;

?>