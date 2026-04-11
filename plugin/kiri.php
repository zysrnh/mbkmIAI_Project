<!-- Start About Section -->
<style>
/* Fix gap dari bawah slider/banner */
section.about {
    padding-top: 0 !important;
    margin-top: 0 !important;
}

.kotak-wrapper {
    padding-top: 20px;
    padding-bottom: 50px;
}

.kotak-col {
    padding-left: 10px;
    padding-right: 10px;
    margin-bottom: 50px;
}

.kotak-inner {
    position: relative;
    padding: 30px 25px 55px 25px;
    min-height: 230px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.kotak-inner:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
}

.kotak-inner .k-icon {
    font-size: 55px;
    color: #ffffff;
    margin-bottom: 15px;
    display: block;
    transition: transform 0.3s ease;
}

.kotak-inner:hover .k-icon {
    transform: scale(1.15) rotate(5deg);
}

.kotak-inner h3 {
    color: #ffffff;
    font-size: 18px;
    font-weight: bold;
    text-transform: uppercase;
    margin: 0 0 12px 0;
    line-height: 1.3;
}

.kotak-inner p {
    color: rgba(255,255,255,0.92);
    font-size: 13px;
    line-height: 1.7;
    margin: 0;
}

/* Tombol panah lingkaran - DALAM kotak bagian bawah tengah */
.kotak-btn {
    position: absolute;
    bottom: -22px;
    left: 50%;
    margin-left: -25px; /* manual center tanpa transform agar tidak bug */
    width: 50px;
    height: 50px;
    background: #ffffff;
    border-radius: 50%;
    display: block;
    text-align: center;
    line-height: 48px;
    font-size: 24px;
    font-weight: bold;
    text-decoration: none;
    box-shadow: 0 3px 12px rgba(0,0,0,0.25);
    transition: box-shadow 0.3s ease, opacity 0.3s ease;
    z-index: 99;
}

.kotak-btn:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.35);
    opacity: 0.85;
    text-decoration: none;
}

/* Pastikan col tidak clip */
.kotak-row {
    overflow: visible !important;
}
</style>

<section class="about">
    <div class="container kotak-wrapper" style="margin-top:0;">

        <!-- BARIS 1: Fakultas, Akreditasi, PCMB -->
        <div class="row kotak-row" style="margin-bottom:30px;">

            <?php
            $perintah = "SELECT * FROM halaman WHERE id='2'";
            $hasil = $koneksi_db->sql_query($perintah);
            while ($data = $koneksi_db->sql_fetchrow($hasil)) {
                $urlkat = str_replace(" ", "-", $data['judul']);
                echo '
                <div class="col-sm-4 kotak-col">
                    <div class="kotak-inner" style="background-color:#1a3a5c;">
                        <i class="fa fa-graduation-cap k-icon"></i>
                        <h3>'.$data[1].'</h3>
                        <p>'.limitTXT(strip_tags($data['konten']),130).'</p>
                        <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="kotak-btn" style="color:#1a3a5c;">&#8250;</a>
                    </div>
                </div>';
            }
            ?>

            <?php
            $perintah = "SELECT * FROM halaman WHERE id='3'";
            $hasil = $koneksi_db->sql_query($perintah);
            while ($data = $koneksi_db->sql_fetchrow($hasil)) {
                $urlkat = str_replace(" ", "-", $data['judul']);
                echo '
                <div class="col-sm-4 kotak-col">
                    <div class="kotak-inner" style="background-color:#1a7a5c;">
                        <i class="fa fa-certificate k-icon"></i>
                        <h3>'.$data[1].'</h3>
                        <p>'.limitTXT(strip_tags($data['konten']),130).'</p>
                        <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="kotak-btn" style="color:#1a7a5c;">&#8250;</a>
                    </div>
                </div>';
            }
            ?>

            <?php
            $perintah = "SELECT * FROM halaman WHERE id='4'";
            $hasil = $koneksi_db->sql_query($perintah);
            while ($data = $koneksi_db->sql_fetchrow($hasil)) {
                $urlkat = str_replace(" ", "-", $data['judul']);
                echo '
                <div class="col-sm-4 kotak-col">
                    <div class="kotak-inner" style="background-color:#5a3a7c;">
                        <i class="fa fa-user-plus k-icon"></i>
                        <h3>'.$data[1].'</h3>
                        <p>'.limitTXT(strip_tags($data['konten']),130).'</p>
                        <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="kotak-btn" style="color:#5a3a7c;">&#8250;</a>
                    </div>
                </div>';
            }
            ?>

        </div><!-- end baris 1 -->
    </div><!-- end container kotak-wrapper -->

    <!-- Sambutan + Video -->
    <div class="container" style="margin-top:20px; margin-bottom:40px;">
        <div class="row">

            <?php
            $perintah = "SELECT * FROM halaman WHERE id='1'";
            $hasil = $koneksi_db->sql_query($perintah);
            while ($data = $koneksi_db->sql_fetchrow($hasil)) {
                $post = $data[2];
                $na = $data[3];
                $urlkat = str_replace(" ", "-", $data['judul']);
                echo '
                <div class="col-sm-7 col-sm-push-5 left-block">
                    <span class="sm-head">SAMBUTAN</span>
                    <h2>'.$data[1].'</h2>
                    <p style="color: black">'.limitTXT(strip_tags($data['konten']),540).'</p>
                    <div class="know-more-wrapper">
                        <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="know-more">Read more <span class="icon-more-icon"></span></a>
                    </div>
                </div>';
            }
            ?>

            <div class="col-sm-5 col-sm-pull-7">
                <div class="video-block">
                    <?php
                    $perintah = "SELECT * FROM mod_data_video ORDER By id DESC LIMIT 1";
                    $hasil = $koneksi_db->sql_query($perintah);
                    while ($data = $koneksi_db->sql_fetchrow($hasil)) {
                        $url = str_replace(" ", "-", $data[1]);
                        echo '
                        <div id="thumbnail_container">
                            <img src="http://img.youtube.com/vi/'.$data['video'].'/hqdefault.jpg" alt="'.$data['nama'].'" id="thumbnail" class="img-responsive">
                        </div>
                        <a href="https://www.youtube.com/watch?v='.$data['video'].'" title="'.$data['nama'].'" class="start-video video">
                            <img src="images/play-btn.png" alt="">
                        </a>
                        </div>';
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>

</section>
<!-- End About Section -->

<!-- Start Campus News Section - BERITA KAMPUS -->
<!-- Start Pedoman Flipbook Section (embedded from database) -->
<style>
/* ===================== BOOKSHELF - BERANDA ===================== */
.bookshelf-home-wrap {
    background: #f4f6f9;
    padding: 50px 0 60px;
}
.bookshelf-home-header {
    text-align: center;
    margin-bottom: 35px;
}
.bookshelf-home-header .label-top {
    color: #42a5f5;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 600;
}
.bookshelf-home-header h2 {
    color: #0d47a1;
    font-size: 32px;
    font-weight: 800;
    margin: 8px 0 0;
}
.bookshelf-row-home {
    position: relative;
    padding: 20px 20px 30px;
    margin-bottom: 30px;
    background: linear-gradient(to bottom, #c8a97e, #a0784a);
    border-radius: 4px;
    border-bottom: 12px solid #7a5430;
    box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    min-height: 170px;
    align-items: flex-end;
}
.bookshelf-row-home::before {
    content: '';
    position: absolute;
    bottom: -26px; left: -8px; right: -8px;
    height: 18px;
    background: linear-gradient(to bottom, #5c3b1a, #3d2510);
    border-radius: 0 0 6px 6px;
    box-shadow: 0 6px 12px rgba(0,0,0,0.3);
}
.book-home-card {
    width: 100px;
    cursor: pointer;
    transition: transform 0.3s ease;
    position: relative;
    flex-shrink: 0;
    text-decoration: none;
}
.book-home-card:hover { transform: translateY(-12px) scale(1.06); text-decoration:none; }
.book-home-cover {
    width: 100px; height: 140px;
    border-radius: 2px 6px 6px 2px;
    overflow: hidden;
    box-shadow: -4px 4px 10px rgba(0,0,0,0.4), inset -3px 0 5px rgba(0,0,0,0.15);
    position: relative;
    background: #1a3a6c;
}
.book-home-cover img { width:100%; height:100%; object-fit:cover; display:block; }
.book-home-cover .spine { position:absolute; left:0; top:0; bottom:0; width:10px; background:rgba(0,0,0,0.2); border-right:1px solid rgba(255,255,255,0.1); }
.book-home-cover .no-cover-txt {
    display:flex; align-items:center; justify-content:center;
    width:100%; height:100%; background:linear-gradient(135deg,#1565c0,#0d47a1);
    color:#fff; font-size:10px; text-align:center; padding:6px; font-weight:600; line-height:1.4;
}
.book-home-cover .book-hover-overlay {
    position:absolute; top:0; left:0; right:0; bottom:0;
    background:rgba(13,71,161,0); transition:background 0.3s;
    display:flex; align-items:center; justify-content:center;
    border-radius:2px 6px 6px 2px;
}
.book-home-card:hover .book-hover-overlay { background:rgba(13,71,161,0.55); }
.book-hover-overlay span { color:#fff; font-size:11px; font-weight:bold; opacity:0; transition:opacity 0.3s; }
.book-home-card:hover .book-hover-overlay span { opacity:1; }
.book-home-title { font-size:10px; color:#3d2510; font-weight:600; text-align:center; margin-top:6px; line-height:1.3; max-height:2.6em; overflow:hidden; }
.bookshelf-see-all { text-align:center; margin-top:30px; }
.bookshelf-see-all a {
    display:inline-block; background:#0d47a1; color:#fff;
    padding:12px 30px; border-radius:30px; font-weight:600;
    text-decoration:none; font-size:14px; transition:background 0.3s;
}
.bookshelf-see-all a:hover { background:#1565c0; text-decoration:none; color:#fff; }
</style>

<!-- FLIPBOOK MODAL (juga digunakan di beranda) -->
<div class="flipbook-modal-overlay" id="flipbookOverlayHome">
    <div class="flipbook-modal">
        <div class="flipbook-modal-header">
            <h4 id="flipbookTitleHome">Judul Buku</h4>
            <button class="btn-close-flipbook" onclick="closeFlipbookHome()" title="Tutup">&times;</button>
        </div>
        <div class="flipbook-modal-toolbar">
            <button onclick="prevPageHome()">&#9664; Prev</button>
            <button onclick="prevSpreadHome()">&#171; 2 Hal</button>
            <span class="page-info" id="pageInfoHome">Hal 1 / 1</span>
            <button onclick="nextSpreadHome()">2 Hal &#187;</button>
            <button onclick="nextPageHome()">Next &#9654;</button>
            <button onclick="zoomInHome()">&#43; Zoom</button>
            <button onclick="zoomOutHome()">&#8722; Zoom</button>
        </div>
        <div class="flipbook-canvas-wrap" id="flipbookCanvasWrapHome">
            <div class="flipbook-pages-container" id="pagesContainerHome" style="opacity:1;">
                <canvas id="canvasLeftHome"></canvas>
                <canvas id="canvasRightHome"></canvas>
            </div>
            <div class="flipbook-loading" id="flipbookLoadingHome" style="display:none;">Memuat dokumen...</div>
        </div>
        <a href="#" id="flipbookDownloadHome" class="flipbook-download-link" target="_blank">
            &#11015; Download PDF
        </a>
    </div>
</div>

<section class="bookshelf-home-wrap">
    <div class="container">
        <div class="bookshelf-home-header">
            <div class="label-top">Pedoman</div>
            <h2>PEDOMAN MBKM IAI PI BANDUNG</h2>
        </div>

        <?php
        $all_home_books = [];
        $q_home = $koneksi_db->sql_query("SELECT * FROM mod_data_flipbook WHERE status='1' ORDER BY ordering ASC, id DESC LIMIT 12");
        while ($bk = $koneksi_db->sql_fetchrow($q_home)) $all_home_books[] = $bk;

        if (!empty($all_home_books)):
            $chunks = array_chunk($all_home_books, 6);
            foreach ($chunks as $row_books):
                echo '<div class="bookshelf-row-home">';
                foreach ($row_books as $bk):
                    $cover_h = !empty($bk['cover']) ? 'images/flipbook/' . htmlspecialchars($bk['cover']) : '';
                    $judul_h = htmlspecialchars($bk['judul']);
                    $pdf_h   = htmlspecialchars($bk['file_pdf']);
                    echo '
                    <div class="book-home-card" onclick="openFlipbookHome(\'' . $pdf_h . '\', \'' . addslashes($judul_h) . '\')">
                        <div class="book-home-cover">
                            <div class="spine"></div>';
                    if ($cover_h) {
                        echo '<img src="' . $cover_h . '" alt="' . $judul_h . '">';
                    } else {
                        echo '<div class="no-cover-txt">' . $judul_h . '</div>';
                    }
                    echo '<div class="book-hover-overlay"><span>&#128214; Buka</span></div>
                        </div>
                        <div class="book-home-title">' . $judul_h . '</div>
                    </div>';
                endforeach;
                echo '</div>';
            endforeach;
        else:
            echo '<p style="text-align:center; color:#aaa; padding:40px 0;">Belum ada buku pedoman yang tersedia.</p>';
        endif;
        ?>

        <div class="bookshelf-see-all">
            <a href="index.php?pilih=flipbook&modul=yes">Lihat Semua Pedoman &raquo;</a>
        </div>
    </div>
</section>
<!-- End Pedoman Flipbook Section -->

<!-- PDF.js CDN (untuk beranda) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
if (typeof pdfjsLib !== 'undefined') {
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
}
var _pdfDocHome = null, _curPageHome = 1, _totalPagesHome = 0, _scaleHome = 1.2;

function openFlipbookHome(pdfUrl, title) {
    document.getElementById('flipbookTitleHome').textContent = title;
    document.getElementById('flipbookDownloadHome').href = pdfUrl;
    document.getElementById('flipbookOverlayHome').classList.add('active');
    document.getElementById('flipbookLoadingHome').style.display = 'block';
    document.getElementById('pagesContainerHome').style.opacity = '0';
    _curPageHome = 1;
    pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
        _pdfDocHome = pdf;
        _totalPagesHome = pdf.numPages;
        document.getElementById('flipbookLoadingHome').style.display = 'none';
        document.getElementById('pagesContainerHome').style.opacity = '1';
        _renderSpreadHome(_curPageHome);
    }).catch(function(err) {
        document.getElementById('flipbookLoadingHome').textContent = 'Gagal memuat PDF.';
        document.getElementById('flipbookLoadingHome').style.display = 'block';
    });
}
function closeFlipbookHome() {
    document.getElementById('flipbookOverlayHome').classList.remove('active');
    _pdfDocHome = null;
}
function _renderPageHome(n, cid) {
    if (!_pdfDocHome || n < 1 || n > _totalPagesHome) {
        document.getElementById(cid).style.display = 'none';
        return;
    }
    _pdfDocHome.getPage(n).then(function(page) {
        var vp = page.getViewport({ scale: _scaleHome });
        var c = document.getElementById(cid);
        c.style.display = 'block';
        c.height = vp.height; c.width = vp.width;
        page.render({ canvasContext: c.getContext('2d'), viewport: vp });
    });
}
function _renderSpreadHome(p) {
    if (!_pdfDocHome) return;
    _renderPageHome(p, 'canvasLeftHome');
    if (p + 1 <= _totalPagesHome) {
        _renderPageHome(p + 1, 'canvasRightHome');
    } else {
        document.getElementById('canvasRightHome').style.display = 'none';
    }
    document.getElementById('pageInfoHome').textContent = 'Hal ' + p + (p+1 <= _totalPagesHome ? '-'+(p+1) : '') + ' / ' + _totalPagesHome;
}
function nextPageHome()   { if (_pdfDocHome && _curPageHome < _totalPagesHome) { _curPageHome++; _renderSpreadHome(_curPageHome); } }
function prevPageHome()   { if (_pdfDocHome && _curPageHome > 1) { _curPageHome--; _renderSpreadHome(_curPageHome); } }
function nextSpreadHome() { if (_pdfDocHome && _curPageHome+2 <= _totalPagesHome) { _curPageHome+=2; _renderSpreadHome(_curPageHome); } }
function prevSpreadHome() { if (_pdfDocHome && _curPageHome-2 >= 1) { _curPageHome-=2; _renderSpreadHome(_curPageHome); } }
function zoomInHome()  { _scaleHome += 0.2; if (_pdfDocHome) _renderSpreadHome(_curPageHome); }
function zoomOutHome() { if (_scaleHome > 0.4) { _scaleHome -= 0.2; if (_pdfDocHome) _renderSpreadHome(_curPageHome); } }
document.getElementById('flipbookOverlayHome').addEventListener('click', function(e) { if (e.target===this) closeFlipbookHome(); });
document.addEventListener('keydown', function(e) {
    if (!document.getElementById('flipbookOverlayHome').classList.contains('active')) return;
    if (e.key==='ArrowRight') nextPageHome();
    if (e.key==='ArrowLeft') prevPageHome();
    if (e.key==='Escape') closeFlipbookHome();
});
</script>


<style>
.cs-style-3 figure img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    object-position: center;
}
</style>
<section class="news-events padding-lg">
    <div class="container">
        <h2><span style="color: #109bc5;">Berita dan Informasi Seputar Kampus</span> BERITA KAMPUS</h2>
        <ul class="row cs-style-3">
            <?php
            $query2 = $koneksi_db->sql_query("SELECT * FROM `artikel` WHERE publikasi=1 AND topik=1 ORDER BY `id` DESC LIMIT 3");
            while ($data = $koneksi_db->sql_fetchrow($query2)) {
                $id2 = $data[0];
                $judul2 = $data[1];
                $gambar = $data['gambar'];
                $post = $data[2];
                // Buat URL yang lebih aman dan bersih
                $url = str_replace(" ", "-", $data[1]);
                $url = preg_replace('/[^A-Za-z0-9\-]/', '', $url); // Hapus karakter khusus
                $url = preg_replace('/-+/', '-', $url); // Hapus double dash
                $url = trim($url, '-'); // Hapus dash di awal/akhir
                
                // Jika URL kosong setelah dibersihkan, gunakan ID
                if (empty($url)) {
                    $url = 'artikel-'.$data[0];
                }
                $idzz = $data['id'];
                $topik = $data['topik'];
                $adaxc = $koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM komentar where artikel='".$idzz."'"));
                $propinsi4 = $koneksi_db->sql_query("SELECT * FROM topik WHERE id='$topik'");
                while($p4 = $koneksi_db->sql_fetchrow($propinsi4)){
                    $kelas24 = $p4['topik'];
                }
                
                // Logika penentuan gambar
                if (!empty($gambar)) {
                    // Jika ada gambar dari admin
                    $image_src = 'images/artikel/'.$gambar;
                } else {
                    // Jika tidak ada, coba ambil dari konten
                    $na = catch_that_image($post);
                    
                    // Validasi gambar yang diambil dari konten
                    if (!empty($na) && 
                        strpos($na, 'images/') !== false && 
                        (strpos($na, '.jpg') !== false || strpos($na, '.jpeg') !== false || strpos($na, '.png') !== false)) {
                        $image_src = $na;
                    } else {
                        // Gunakan gambar placeholder untuk berita kampus
                        $image_src = 'images/berita-kampus-placeholder.jpg';
                    }
                }
                
                echo '
                <li class="col-sm-4">
                    <div class="inner">
                        <figure> <img src="'.$image_src.'" class="img-responsive" alt="'.$data[1].'">
                            <figcaption>
                                <div class="cnt-block"> <a href="artikel/'.$data[0].'/'.$url.'.html" title="'.$data[1].'" class="plus-icon">+</a>
                                    <a href="artikel/'.$data[0].'/'.$url.'.html" title="'.$data[1].'"><h3> '.$data[1].'</h3></a>
                                    <div class="bottom-block clearfix">
                                        <div class="date">
                                            <div class="icon"><span class="icon-calander-icon"></span></div>
                                            <span>'.datetimess($data[5]).' </span></div>
                                        <div class="comment">
                                            <span>'.$data['hits'].'</span> View</div>
                                    </div>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </li>';
            }
            ?>
        </ul>
        <div class="know-more-wrapper"> <a href="kategori/1/Berita-Kampus.html" class="know-more">Berita Kampus Lainnya <span class="icon-more-icon"></span></a> </div>
    </div>
</section>

        <!-- End How Study Section --> 






		
	  <!-- Start Why Choose Section -->
        <section class="why-choose padding-lg">
            <div class="container">
                <h2><span>Mengapa Memilih Kami</span>Data Statistik Layanan</h2>
                <ul class="our-strength">
				
				<?php
$perintah="SELECT * FROM mod_data_stat ORDER By id ASC LIMIT 4";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				
					$url=str_replace(" ", "-", $data[1]);
			
 echo '<li>
                        <div class="icon">'.$data['ket'].'</div>
                        <span class="counter">'.$data['jum'].'</span>
                        <div class="title">'.$data['nama'].'</div>
                    </li>
			
					
 
'; 
					
} ?>	                 			
				
				
                    
                    
                </ul>
            </div>
        </section>
        <!-- End Why Choose Section --> 
	
		
		
        
		
		
		
		
		        <!-- Start Browse Teacher -->
        <section class="browse-teacher padding-lg" >
            <div class="container">
                <h2><span style="color: #109bc5;">BIODATA DOSEN</span>Dosen</h2>
                <ul class="row browse-teachers-list clearfix">
				
				
				
		<?php
$perintah="SELECT * FROM mod_data_dosen ORDER By rand() DESC LIMIT 4";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				
					$url=str_replace(" ", "-", $data[1]);
			
 echo '
  <li class="col-xs-6 col-sm-3">
                        <figure> <img src="images/dosen/'.$data['foto'].'" alt="'.$data['nama'].'" width="124" height="124" alt=""> </figure>
                         <a href="dosen/'.$data['id'].'/'.$url.'.html"><h3>'.$data['nama'].'</h3></a>
                        <span class="designation">'.$data['pekerjaan'].'</span>
                        <p class="equal-hight">'.limitTXT(strip_tags($data['ket']),160).'</p>
                        <ul class="teachers-follow">
                            <li><a href="'.$data['fb'].'"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="'.$data['tw'].'"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="'.$data['in'].'"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
						 
                    </li>
					
					
 
'; 
					
} ?>	                 				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
                   
             
                </ul>
            </div>
        </section>
		
		
		
		
    <!-- Start logos Section -->
<style>
.logos {
    background-color: #f8f9fa;
    padding: 40px 0;
}

.logos ul li {
    overflow: hidden;
    border-radius: 8px;
    transition: all 0.3s ease;
    background-color: #ffffff;
    padding: 15px;
}

.logos ul li a {
    display: block;
    overflow: hidden;
}

.logos ul li img {
    transition: transform 0.4s ease;
    display: block;
    width: 100%;
}

.logos ul li:hover img {
    transform: scale(1.15);
}

.logos ul li:hover {
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}
</style>

<section class="logos">
    <div class="container">
        <ul class="owl-carousel clearfix">
            <?php
            $perintah = "SELECT * FROM mod_data_client ORDER By id DESC LIMIT 8";
            $hasil = $koneksi_db->sql_query($perintah);
            $coint_i = 0;
            while ($data = $koneksi_db->sql_fetchrow($hasil)) {
                $coint_i++;
                $url = str_replace(" ", "-", $data[1]);
                
                echo '
                <li>
                    <a href="'.$data['link'].'" target="_blank" rel="noopener">
                        <img src="images/client/'.$data['foto'].'" class="img-responsive" alt="'.$data['nama'].'">
                    </a>
                </li>';
            } 
            ?>	       
        </ul>
    </div>
</section>
<!-- End logos Section -->
		
		
		
		
		
		
		
	
		

<!-- Start Campus Tour Section - POJOK KAMPUS -->
<style>
.cs-style-3 figure img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    object-position: center;
}
</style>
<section class="news-events padding-lg">
    <div class="container">
        <h2><span style="color: #109bc5;">Goresan Tangan Civitas IAI Persis Bandung </span>POJOK KAMPUS</h2>
        <ul class="row cs-style-3">
            <?php
            $query2 = $koneksi_db->sql_query("SELECT * FROM `artikel` WHERE topik=6 ORDER BY `id` DESC LIMIT 3");
            while ($data = $koneksi_db->sql_fetchrow($query2)) {
                $id2 = $data[0];
                $judul2 = $data[1];
                $gambar = $data['gambar'];
                $post = $data[2];
                // Buat URL yang lebih aman dan bersih
                $url = str_replace(" ", "-", $data[1]);
                $url = preg_replace('/[^A-Za-z0-9\-]/', '', $url); // Hapus karakter khusus
                $url = preg_replace('/-+/', '-', $url); // Hapus double dash
                $url = trim($url, '-'); // Hapus dash di awal/akhir
                
                // Jika URL kosong setelah dibersihkan, gunakan ID
                if (empty($url)) {
                    $url = 'artikel-'.$data[0];
                }
                $idzz = $data['id'];
                $topik = $data['topik'];
                $adaxc = $koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM komentar where artikel='".$idzz."'"));
                $propinsi4 = $koneksi_db->sql_query("SELECT * FROM topik WHERE id='$topik'");
                while($p4 = $koneksi_db->sql_fetchrow($propinsi4)){
                    $kelas24 = $p4['topik'];
                }
                
                // Jika gambar kosong, ambil gambar dari konten artikel menggunakan catch_that_image
                // Logika penentuan gambar
                if (!empty($gambar)) {
                    // Jika admin upload gambar
                    $image_src = 'images/artikel/'.$gambar;
                } else {
                    // Jika artikel dari user/mahasiswa, coba ambil gambar dari konten
                    $na = catch_that_image($post);
                    
                    // Validasi gambar yang diambil dari konten
                    if (!empty($na) && 
                        strpos($na, 'images/') !== false && 
                        (strpos($na, '.jpg') !== false || strpos($na, '.jpeg') !== false || strpos($na, '.png') !== false)) {
                        $image_src = $na;
                    } else {
                        // Gunakan gambar placeholder untuk artikel pojok kampus
                        $image_src = 'images/pojok-kampus-placeholder.jpg';
                    }
                }
                
                echo '
                <li class="col-sm-4">
                    <div class="inner">
                        <figure> <img src="'.$image_src.'" class="img-responsive" alt="'.$data[1].'">
                            <figcaption>
                                <div class="cnt-block"> <a href="artikel/'.$data[0].'/'.$url.'.html" title="'.$data[1].'" class="plus-icon">+</a>
                                    <a href="artikel/'.$data[0].'/'.$url.'.html" title="'.$data[1].'"><h3> '.$data[1].'</h3></a>
                                    <div class="bottom-block clearfix">
                                        <div class="date">
                                            <div class="icon"><span class="icon-calander-icon"></span></div>
                                            <span>'.datetimess($data[5]).' </span></div>
                                        <div class="comment">
                                            <span>'.$data['hits'].'</span> View</div>
                                    </div>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </li>';
            }
            ?>
        </ul>
        <div class="know-more-wrapper"> <a href="kategori/6/Pojok-Kampus.html" class="know-more">Pojok Kampus Lainnya <span class="icon-more-icon"></span></a> </div>
    </div>
</section>

<!-- Start New & Events Section - KEGIATAN KAMPUS -->
<section class="news-events padding-lg">
    <div class="container">
        <h2><span style="color: #109bc5;">Tri Dharma Perguruan Tinggi</span>Penelitian Dan Publikasi Ilmiah</h2>
        <ul class="row cs-style-3">
            <?php
            $query2 = $koneksi_db->sql_query("SELECT * FROM `artikel` WHERE publikasi=1 AND topik=9 ORDER BY `id` DESC LIMIT 3");
            while ($data = $koneksi_db->sql_fetchrow($query2)) {
                $id2 = $data[0];
                $judul2 = $data[1];
                $gambar = $data['gambar'];
                $post = $data[2];
                $na = catch_that_image($post);
                $url = str_replace(" ", "-", $data[1]);
                $idzz = $data['id'];
                $topik = $data['topik'];
                $adaxc = $koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM komentar where artikel='".$idzz."'"));
                $propinsi4 = $koneksi_db->sql_query("SELECT * FROM topik WHERE id='$topik'");
                while($p4 = $koneksi_db->sql_fetchrow($propinsi4)){
                    $kelas24 = $p4['topik'];
                }
                
                echo '
                <li class="col-sm-4">
                    <div class="inner">
                        <figure> <img src="images/artikel/'.$gambar.'" class="img-responsive" alt="'.$data[1].'">
                            <figcaption>
                                <div class="cnt-block"> <a href="artikel/'.$data[0].'/'.$url.'.html" title="'.$data[1].'" class="plus-icon">+</a>
                                    <a href="artikel/'.$data[0].'/'.$url.'.html" title="'.$data[1].'"><h3> '.$data[1].'</h3></a>
                                    <div class="bottom-block clearfix">
                                        <div class="date">
                                            <div class="icon"><span class="icon-calander-icon"></span></div>
                                            <span>'.datetimess($data[5]).' </span></div>
                                        <div class="comment">
                                            <span>'.$data['hits'].'</span> View</div>
                                    </div>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </li>';
            }
            ?>         			
        </ul>
        <div class="know-more-wrapper"> <a href="kategori/2/Even-Kegiatan.html" class="know-more">Event Kegiatan Lainnya <span class="icon-more-icon"></span></a> </div>
    </div>
</section>
<!-- End New & Events Section -->
    
		
		<!-- Start New & Events Section -->
        <section class="news-events padding-lg">
            <div class="container">
                <h2><span style="color: #109bc5;">EVENT KAMPUS</span>kegiatan kampus</h2>
                <ul class="row cs-style-3">
				
				
	<?php

						$query2 = $koneksi_db->sql_query( "SELECT * FROM `artikel` WHERE publikasi=1  AND topik=2 ORDER BY `id` DESC LIMIT 3" );	
						while ($data = $koneksi_db->sql_fetchrow($query2)) {
						$id2    = $data[0];
						$judul2    = $data[1];
					$gambar = $data['gambar'];
				      	$post = $data[2];
					$na = catch_that_image($post);
						$url=str_replace(" ", "-", $data[1]);
						$idzz = $data['id'];

	$topik = $data['topik'];
$adaxc=$koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM komentar where artikel='".$idzz."'"));

$propinsi4 = $koneksi_db->sql_query("SELECT * FROM topik WHERE id='$topik'");
while($p4=$koneksi_db->sql_fetchrow($propinsi4)){
	$kelas24 = $p4['topik'];
}


						
						
											echo '
		<li class="col-sm-4">
                        <div class="inner">
                            <figure> <img src="images/artikel/'.$gambar.'" class="img-responsive">
                                <figcaption>
                                    <div class="cnt-block"> <a href="artikel/'.$data[0].'/'.$url.'.html" title="'.$data[1].'" class="plus-icon">+</a>
                                        <a href="artikel/'.$data[0].'/'.$url.'.html" title="'.$data[1].'"><h3> '.$data[1].'</h3></a>
                                        <div class="bottom-block clearfix">
                                            <div class="date">
                                                <div class="icon"><span class="icon-calander-icon"></span></div>
                                                <span>'.datetimess($data[5]).' </span></div>
                                            <div class="comment">
                                             
                                                <span>'.$data['hits'].'</span> View</div>
                                        </div>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                    </li>

				
     ';
						
						}
						?>         			
				
				
                    
      
	  
	  
              
                </ul>
                <div class="know-more-wrapper"> <a href="kategori/2/Even-Kegiatan.html" class="know-more">Event Kegiatan Lainnya <span class="icon-more-icon"></span></a> </div>
            </div>
        </section>
        <!-- End New & Events Section --> 		
		
		
		
		
		
		
		
		
		
		
        <!-- Start Testimonial -->
        <section class="testimonial padding-lg" >
            <div class="container">
                <div class="wrapper">
                  <h2>Testimonial</h2>
                    <ul class="testimonial-slide">
					
					
					
					            							
<?php
$perintah="SELECT * FROM mod_data_testi ORDER By id DESC LIMIT 4";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				
					$url=str_replace(" ", "-", $data[1]);
			
 echo ' <li>
                            <p>'.$data['ket'].'</p>
                            <span>'.$data['nama'].'<span> '.$data['email'].'</span></span> </li>
                        
 
 
'; 
					
} ?>	         							
					
			
                    </ul>
                    <div id="bx-pager"> 
			<?php
$perintah="SELECT * FROM mod_data_testi WHERE status='1' ORDER By id DESC LIMIT 4";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				
					$url=str_replace(" ", "-", $data[1]);
			
 echo ' 
 	<a data-slide-index="'.$coint_i.'" href="#"><img src="images/testi/thumb/'.$data['foto'].'" class="img-circle" alt=""/></a> 

                        
 
 
'; 
					
} ?>	         			
				
				 </div>
					
					
					
                </div>
            </div>
        </section>
        <!-- End Testimonial --> 
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
       
      
        
     