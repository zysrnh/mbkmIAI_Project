<style>
.gallery-video-wrapper {
    padding: 0;
    margin: 0;
}

.video-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 25px;
    padding: 20px 0;
}

.video-card {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.video-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.video-thumbnail {
    position: relative;
    width: 100%;
    padding-top: 56.25%; /* 16:9 Aspect Ratio */
    overflow: hidden;
    background: #000;
}

.video-thumbnail img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.video-card:hover .video-thumbnail img {
    transform: scale(1.05);
}

.video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.3);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.video-card:hover .video-overlay {
    opacity: 1;
}

.play-icon {
    width: 60px;
    height: 60px;
    background: rgba(255,255,255,0.95);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transform: scale(0.8);
    transition: transform 0.3s ease;
}

.video-card:hover .play-icon {
    transform: scale(1);
}

.play-icon::after {
    content: '';
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 10px 0 10px 18px;
    border-color: transparent transparent transparent #e74c3c;
    margin-left: 4px;
}

.video-content {
    padding: 18px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.video-title {
    font-size: 15px;
    font-weight: 600;
    color: #2c3e50;
    margin: 0 0 15px 0;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    min-height: 42px;
}

.video-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #e74c3c;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    margin-top: auto;
    width: fit-content;
}

.video-button:hover {
    background: #c0392b;
    transform: translateX(2px);
    color: #fff;
    text-decoration: none;
}

.video-button i {
    font-size: 12px;
}

.pagination-wrapper {
    text-align: center;
    padding: 40px 0 20px 0;
    margin-top: 20px;
}

.pagination-wrapper a,
.pagination-wrapper span {
    display: inline-block;
    padding: 8px 14px;
    margin: 0 4px;
    border-radius: 4px;
    transition: all 0.2s ease;
}

@media (max-width: 768px) {
    .video-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .video-title {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .video-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
}
</style>

<div class="gallery-video-wrapper">
    <h4 style="font-size: 24px; font-weight: 700; color: #2c3e50; margin: 0 0 5px 0; text-transform: uppercase; letter-spacing: 0.5px;">Gallery Video</h4>
    
    <?php
    $content = '';
    $index_hal = 1;
    include 'modul/functions.php';
    
    switch (@$_GET['action']){
        
    default:
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
        
        $num = $koneksi_db->sql_query("SELECT `id` FROM `mod_data_video` $query_add");
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
        $query = $koneksi_db->sql_query("SELECT * FROM `mod_data_video` $query_add $SORT_SQL ORDER BY `id` DESC LIMIT $offset, $limit");
        
        $content .= '<div class="video-grid">';
        
        while ($data = $koneksi_db->sql_fetchrow($query)){
            $id = md5($data['id']);
            $video_title = htmlspecialchars($data['nama']);
            $video_id = $data['video'];
            
            $content .= '
            <div class="video-card">
                <a href="https://www.youtube.com/embed/'.$video_id.'" target="_blank" style="text-decoration: none;">
                    <div class="video-thumbnail">
                        <img src="https://img.youtube.com/vi/'.$video_id.'/hqdefault.jpg" alt="'.$video_title.'">
                        <div class="video-overlay">
                            <div class="play-icon"></div>
                        </div>
                    </div>
                </a>
                <div class="video-content">
                    <h3 class="video-title">'.$video_title.'</h3>
                    <a href="https://www.youtube.com/embed/'.$video_id.'" target="_blank" class="video-button">
                        <i class="fa fa-play"></i> Tonton Video
                    </a>
                </div>
            </div>';
        }
        
        $content .= '</div>';
        
        $content .= '<div class="pagination-wrapper">';
        $content .= $a->getPagingvideo($jumlah, $_GET['pg'], $_GET['stg']);
        $content .= '</div>';
        
        break;	
    }
    
    echo $content;
    ?>
</div>