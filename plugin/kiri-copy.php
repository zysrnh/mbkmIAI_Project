

































        <!-- Start About Section -->
        <section class="about">
            <div class="container" style="margin-top:90px; margin-bottom: 300px">
                <ul class="row our-links">

                    <?php
// --- BAGIAN 1: HALAMAN ID 2 ---
$perintah = "SELECT * FROM halaman WHERE id='2'";
$hasil = $koneksi_db->sql_query($perintah);
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
    $post = $data[2];
    $na = $data[3];
    $urlkat = str_replace(" ", "-", $data['judul']);
    echo '
    <li class="col-sm-4 apply-online clearfix equal-hight" style="background-color: #4CAF50;">
        <div class="icon">
            <i class="fa fa-graduation-cap" style="font-size: 60px; color: #ffffff;"></i>
        </div>
        <div class="detail">
            <h3>'.$data[1].'</h3>
            <p>'.limitTXT(strip_tags($data['konten']),130).'</p>
            <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="more" style="color: #ffffff;">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </a>
        </div>
    </li>';
}
?>
                    <?php
// --- BAGIAN 2: HALAMAN ID 3 ---
$perintah = "SELECT * FROM halaman WHERE id='3'";
$hasil = $koneksi_db->sql_query($perintah);
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
    $post = $data[2];
    $na = $data[3];
    $urlkat = str_replace(" ", "-", $data['judul']);
    echo '
    <li class="col-sm-4 apply-online clearfix equal-hight" style="background-color: #4CAF50;">
        <div class="icon">
            <i class="fa fa-certificate" style="font-size: 60px; color: #ffffff;"></i>
        </div>
        <div class="detail">
            <h3>'.$data[1].'</h3>
            <p>'.limitTXT(strip_tags($data['konten']), 130).'</p>
            <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="more" style="color: #ffffff;">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </a>
        </div>
    </li>';
}
?>

<?php
// --- BAGIAN 3: HALAMAN ID 4 ---
$perintah = "SELECT * FROM halaman WHERE id='4'";
$hasil = $koneksi_db->sql_query($perintah);
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
    $post = $data[2];
    $na = $data[3];
    $urlkat = str_replace(" ", "-", $data['judul']);
    echo '
    <li class="col-sm-4 apply-online clearfix equal-hight" style="background-color: #4CAF50;">
        <div class="icon">
            <i class="fa fa-user-plus" style="font-size: 60px; color: #ffffff;"></i>
        </div>
        <div class="detail">
            <h3>'.$data[1].'</h3>
            <p>'.limitTXT(strip_tags($data['konten']), 130).'</p>
            <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="more" style="color: #ffffff;">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </a>
        </div>
    </li>';
}
?>

                </ul>
            <style>
.our-links li.apply-online {
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
}

.our-links li.apply-online:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

.our-links li.apply-online .icon {
    transition: all 0.4s ease;
}

.our-links li.apply-online:hover .icon {
    transform: scale(1.1) rotate(5deg);
}

.our-links li.apply-online .icon i {
    animation: fadeInDown 0.6s ease;
}

.our-links li.apply-online:hover .icon i {
    animation: bounce 0.6s ease;
}

.our-links li.apply-online .detail h3 {
    transition: all 0.3s ease;
}

.our-links li.apply-online:hover .detail h3 {
    transform: translateX(5px);
}

.our-links li.apply-online .more {
    transition: all 0.3s ease;
    display: inline-block;
}

.our-links li.apply-online:hover .more {
    transform: translateX(10px);
}

.our-links li.apply-online::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: rgba(255,255,255,0.1);
    transform: rotate(45deg);
    transition: all 0.5s ease;
    opacity: 0;
}

.our-links li.apply-online:hover::before {
    opacity: 1;
    left: 100%;
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}
</style>

</div>
<div class="container" style="margin-top:90px; margin-bottom: 50px">
    <ul class="row our-links">
        <?php
        // --- TAMBAHAN BARU: HALAMAN ID 5 (Mengapa Memilih Kami) ---
        $perintah = "SELECT * FROM halaman WHERE id='5'";
        $hasil = $koneksi_db->sql_query($perintah);
        while ($data = $koneksi_db->sql_fetchrow($hasil)) {
            $post = $data[2];
            $na = $data[3];
            $urlkat = str_replace(" ", "-", $data['judul']);
            echo '
            <li class="col-sm-4 apply-online clearfix equal-hight" style="background-color: #4CAF50;">
                <div class="icon">
                    <i class="fa fa-thumbs-up" style="font-size: 60px; color: #ffffff;"></i>
                </div>
                <div class="detail">
                    <h3>'.$data[1].'</h3>
                    <p>'.limitTXT(strip_tags($data['konten']), 130).'</p>
                    <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="more" style="color: #ffffff;">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                </div>
            </li>';
        }
        ?>
        <?php
        // --- TAMBAHAN BARU: HALAMAN ID 6 (Prestasi) ---
        $perintah = "SELECT * FROM halaman WHERE id='6'";
        $hasil = $koneksi_db->sql_query($perintah);
        while ($data = $koneksi_db->sql_fetchrow($hasil)) {
            $post = $data[2];
            $na = $data[3];
            $urlkat = str_replace(" ", "-", $data['judul']);
            echo '
            <li class="col-sm-4 apply-online clearfix equal-hight" style="background-color: #4CAF50;">
                <div class="icon">
                    <i class="fa fa-trophy" style="font-size: 60px; color: #ffffff;"></i>
                </div>
                <div class="detail">
                    <h3>'.$data[1].'</h3>
                    <p>'.limitTXT(strip_tags($data['konten']), 130).'</p>
                    <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="more" style="color: #ffffff;">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                </div>
            </li>';
        }
        ?>
        <?php
        // --- TAMBAHAN BARU: HALAMAN ID 7 (Pengumuman) ---
        $perintah = "SELECT * FROM halaman WHERE id='7'";
        $hasil = $koneksi_db->sql_query($perintah);
        while ($data = $koneksi_db->sql_fetchrow($hasil)) {
            $post = $data[2];
            $na = $data[3];
            $urlkat = str_replace(" ", "-", $data['judul']);
            echo '
            <li class="col-sm-4 apply-online clearfix equal-hight" style="background-color: #4CAF50;">
                <div class="icon">
                    <i class="fa fa-bullhorn" style="font-size: 60px; color: #ffffff;"></i>
                </div>
                <div class="detail">
                    <h3>'.$data[1].'</h3>
                    <p>'.limitTXT(strip_tags($data['konten']), 130).'</p>
                    <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="more" style="color: #ffffff;">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                </div>
            </li>';
        }
        ?>
    </ul>
</div>
            <div class="container">
                <div class="row">
				
				
				<?php
$perintah="SELECT * FROM halaman WHERE id='1'";
$hasil = $koneksi_db->sql_query( $perintah );
				while ($data = $koneksi_db->sql_fetchrow($hasil)) {

				$post = $data[2];
							$na = $data[3];
				$urlkat=str_replace(" ", "-", $data['judul']);

				
								echo '
								
								
								 <div class="col-sm-7 col-sm-push-5 left-block"> <span class="sm-head">SAMBUTAN</span>
                        <h2>'.$data[1].'</h2>
                        <p>'.limitTXT(strip_tags($data['konten']),540).'</p>
                        <div class="know-more-wrapper"> <a href="pages/'.$data['id'].'/'.$urlkat.'.html" class="know-more">Read more <span class="icon-more-icon"></span></a> </div>
                    </div>
								
								
								
							
						';
				
			
					
								

					


				}					?>		
                   
                    <div class="col-sm-5 col-sm-pull-7">
                        <div class="video-block">
						
						
					      							
<?php
$perintah="SELECT * FROM mod_data_video ORDER By id DESC LIMIT 1";
$hasil = $koneksi_db->sql_query( $perintah );
$coint_i = 0;
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
				$coint_i++;
				
					$url=str_replace(" ", "-", $data[1]);
			
 echo '  <div id="thumbnail_container"> <img src="http://img.youtube.com/vi/'.$data['video'].'/hqdefault.jpg" alt="'.$data['nama'].'" id="thumbnail" class="img-responsive"> </div>
                            <a href="https://www.youtube.com/watch?v='.$data['video'].'" title="'.$data['nama'].'" class="start-video video"><img src="images/play-btn.png" alt=""></a> 
                        </div>
 
 
'; 
					
} ?>	         									
						
                          
                    </div>
                </div>
            </div>
        </section>







<!-- Start Campus News Section - BERITA KAMPUS -->
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
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
       
      
        
     