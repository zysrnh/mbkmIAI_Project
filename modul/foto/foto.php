<style>
.gallery-foto-wrapper {
    padding: 0;
    margin: 0;
}

.gallery-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    flex-wrap: wrap;
    gap: 15px;
}

.gallery-title {
    font-size: 24px;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.category-select {
    padding: 10px 35px 10px 15px;
    border: 2px solid #e0e0e0;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    color: #2c3e50;
    background: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%232c3e50' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    min-width: 200px;
}

.category-select:hover {
    border-color: #3498db;
}

.category-select:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
}

.foto-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
    padding: 20px 0;
}

.foto-card {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.foto-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.foto-thumbnail {
    position: relative;
    width: 100%;
    padding-top: 75%; /* 4:3 Aspect Ratio */
    overflow: hidden;
    background: #f5f5f5;
}

.foto-thumbnail img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.foto-card:hover .foto-thumbnail img {
    transform: scale(1.08);
}

.foto-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.6) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.foto-card:hover .foto-overlay {
    opacity: 1;
}

.zoom-icon {
    width: 50px;
    height: 50px;
    background: rgba(255,255,255,0.95);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transform: scale(0.8);
    transition: transform 0.3s ease;
    color: #3498db;
    font-size: 20px;
}

.foto-card:hover .zoom-icon {
    transform: scale(1);
}

.foto-content {
    padding: 16px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.foto-title {
    font-size: 14px;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    min-height: 40px;
}

.pagination-wrapper {
    text-align: center;
    padding: 40px 0 20px 0;
    margin-top: 20px;
}

.error-message {
    background: #fee;
    border-left: 4px solid #e74c3c;
    padding: 15px 20px;
    border-radius: 4px;
    color: #c0392b;
    font-weight: 500;
    margin: 20px 0;
}

@media (max-width: 768px) {
    .gallery-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .category-select {
        width: 100%;
    }
    
    .foto-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
    }
}

@media (max-width: 480px) {
    .foto-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .gallery-title {
        font-size: 20px;
    }
}
</style>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<div class="gallery-foto-wrapper">
    <?php
    $content = '';
    $index_hal = 1;
    include 'modul/functions.php';
    
    switch (@$_GET['action']){
        
    case 'filter':
        $kid = int_filter($_GET['kid']);
        
        $query_add = '';
        if (isset($_GET['str']) && !empty($_GET['str'])){
            $str = substr($_GET['str'], 0, 1);
            $query_add .= "WHERE LEFT(nama, 1) = '$str'";
        }
        
        $num = $koneksi_db->sql_query("SELECT `id` FROM `mod_data_foto` WHERE kat='$kid' $query_add");
        $jumlah = $koneksi_db->sql_numrows($num);
        
        $limit = 12;
        if (empty($_GET['offset']) and !isset($_GET['offset'])) {
            $offset = 0;
        } else {
            $offset = int_filter($_GET['offset']);	
        }
        
        $a = new paging($limit);
        
        if (!isset($_GET['pg'], $_GET['stg'])){
            $_GET['pg'] = 1;
            $_GET['stg'] = 1;
        }
        
        $qs = '';
        $arr = explode("&", $_SERVER["QUERY_STRING"]);
        
        if (is_array($arr)) {
            for ($i = 0; $i < count($arr); $i++) {
                if (!is_int(strpos($arr[$i], "str=")) && trim($arr[$i]) != "") {
                    list($kunci, $isi) = explode('=', $arr[$i]);
                    $isi = urldecode($isi);
                    $isi = urlencode($isi);
                    $qs .= $kunci . '=' . $isi . "&amp;";
                }
            }
        }
        
        $referer = referer_encode();
        
        // Get categories
        $asal4 = '';
        $propinsi = $koneksi_db->sql_query("SELECT * FROM mod_data_fotokat ORDER BY id");
        while($p = $koneksi_db->sql_fetchrow($propinsi)){
            $id = $p['id'];
            $nama = $p['nama'];
            $urlkat = str_replace(" ", "-", $nama);
            $asal4 .= '<option value="gallery/'.$p['id'].'/'.$urlkat.'.html">'.$nama.'</option>';
        }
        
        // Get current category
        $namax = '';
        $propinsix = $koneksi_db->sql_query("SELECT * FROM mod_data_fotokat WHERE id='$kid'");
        while($px = $koneksi_db->sql_fetchrow($propinsix)){
            $namax = $px['nama'];
        }
        
        // SEO
        $pilih = cleartext($_GET['pilih']);
        $seo1 = $koneksi_db->sql_query("SELECT * FROM mod_data_meta WHERE nama='$pilih'");
        while($pr1xypd = $koneksi_db->sql_fetchrow($seo1)){
            $judulseo1 = $pr1xypd['judul'];
            $desseo1 = $pr1xypd['meta'];
            $keyseo1 = $pr1xypd['tags'];
        }
        
        $judul_situs = $judulseo1.' '.$namax;
        $_META['description'] = $desseo1;
        $_META['keywords'] = $keyseo1;
        
        if (empty($namax)){
            $content .= '<div class="error-message">Halaman tidak tersedia.</div>';
        } else {
            $content .= '
            <div class="gallery-header">
                <h4 class="gallery-title">Gallery Foto</h4>
                <form method="GET" action="">
                    <select name="kid" class="category-select" onChange="MM_jumpMenu(\'parent\',this,0)">
                        <option value="">'.$namax.'</option>
                        '.$asal4.'
                    </select>
                </form>
            </div>';
            
            $query = $koneksi_db->sql_query("SELECT * FROM `mod_data_foto` WHERE kat='$kid' $query_add $SORT_SQL ORDER BY `id` DESC LIMIT $offset, $limit");
            
            $content .= '<div class="foto-grid">';
            
            while ($data = $koneksi_db->sql_fetchrow($query)){
                $id = md5($data['id']);
                $foto_title = htmlspecialchars($data['nama']);
                $foto_path = 'images/foto/'.$data['foto'];
                
                $content .= '
                <div class="foto-card">
                    <a href="'.$foto_path.'" data-rel="prettyPhoto">
                        <div class="foto-thumbnail">
                            <img src="'.$foto_path.'" alt="'.$foto_title.'">
                            <div class="foto-overlay">
                                <div class="zoom-icon">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="foto-content">
                        <h3 class="foto-title">'.$foto_title.'</h3>
                    </div>
                </div>';
            }
            
            $content .= '</div>';
            
            $content .= '<div class="pagination-wrapper">';
            $content .= $a->getPagingkatfoto($jumlah, $_GET['pg'], $_GET['stg'], $kid);
            $content .= '</div>';
        }
        break;	
        
    default:
        // SEO
        $pilih = cleartext($_GET['pilih']);
        $seo1 = $koneksi_db->sql_query("SELECT * FROM mod_data_meta WHERE nama='$pilih'");
        while($pr1xypd = $koneksi_db->sql_fetchrow($seo1)){
            $judulseo1 = $pr1xypd['judul'];
            $desseo1 = $pr1xypd['meta'];
            $keyseo1 = $pr1xypd['tags'];
        }
        
        $judul_situs = $judulseo1;
        $_META['description'] = $desseo1;
        $_META['keywords'] = $keyseo1;
        
        $query_add = '';
        if (isset($_GET['str']) && !empty($_GET['str'])){
            $str = substr($_GET['str'], 0, 1);
            $query_add .= "WHERE LEFT(nama, 1) = '$str'";
        }
        
        $num = $koneksi_db->sql_query("SELECT `id` FROM `mod_data_foto` $query_add");
        $jumlah = $koneksi_db->sql_numrows($num);
        
        $limit = 12;
        if (empty($_GET['offset']) and !isset($_GET['offset'])) {
            $offset = 0;
        } else {
            $offset = int_filter($_GET['offset']);	
        }
        
        $a = new paging($limit);
        
        if (!isset($_GET['pg'], $_GET['stg'])){
            $_GET['pg'] = 1;
            $_GET['stg'] = 1;
        }
        
        $qs = '';
        $arr = explode("&", $_SERVER["QUERY_STRING"]);
        
        if (is_array($arr)) {
            for ($i = 0; $i < count($arr); $i++) {
                if (!is_int(strpos($arr[$i], "str=")) && trim($arr[$i]) != "") {
                    list($kunci, $isi) = explode('=', $arr[$i]);
                    $isi = urldecode($isi);
                    $isi = urlencode($isi);
                    $qs .= $kunci . '=' . $isi . "&amp;";
                }
            }
        }
        
        $referer = referer_encode();
        
        // Get categories
        $asal4 = '';
        $propinsi = $koneksi_db->sql_query("SELECT * FROM mod_data_fotokat ORDER BY id");
        while($p = $koneksi_db->sql_fetchrow($propinsi)){
            $id = $p['id'];
            $nama = $p['nama'];
            $urlkat = str_replace(" ", "-", $nama);
            $asal4 .= '<option value="gallery/'.$p['id'].'/'.$urlkat.'.html">'.$nama.'</option>';
        }
        
        $content .= '
        <div class="gallery-header">
            <h4 class="gallery-title">Gallery Foto</h4>
            <form method="GET" action="">
                <select name="kid" class="category-select" onChange="MM_jumpMenu(\'parent\',this,0)">
                    <option value="">-- Pilih Kategori --</option>
                    '.$asal4.'
                </select>
            </form>
        </div>';
        
        $query = $koneksi_db->sql_query("SELECT * FROM `mod_data_foto` $query_add $SORT_SQL ORDER BY `id` DESC LIMIT $offset, $limit");
        
        $content .= '<div class="foto-grid">';
        
        while ($data = $koneksi_db->sql_fetchrow($query)){
            $id = md5($data['id']);
            $foto_title = htmlspecialchars($data['nama']);
            $foto_path = 'images/foto/'.$data['foto'];
            
            $content .= '
            <div class="foto-card">
                <a href="'.$foto_path.'" data-rel="prettyPhoto">
                    <div class="foto-thumbnail">
                        <img src="'.$foto_path.'" alt="'.$foto_title.'">
                        <div class="foto-overlay">
                            <div class="zoom-icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="foto-content">
                    <h3 class="foto-title">'.$foto_title.'</h3>
                </div>
            </div>';
        }
        
        $content .= '</div>';
        
        $content .= '<div class="pagination-wrapper">';
        $content .= $a->getPagingfoto($jumlah, $_GET['pg'], $_GET['stg']);
        $content .= '</div>';
        
        break;	
    }
    
    echo $content;
    ?>
</div>

<script src="js/jquery2x.js"></script>