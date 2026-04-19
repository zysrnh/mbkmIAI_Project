<?php
if (!defined('cms-KOMPONEN')) {
    Header("Location: ../index.php");
    exit;
}

$ikon_2 = '';
$ikon_3 = '';
$index_hal = 1;

$_GET['aksi'] = !isset($_GET['aksi']) ? null : $_GET['aksi'];
$_GET['id'] = !isset($_GET['id']) ? null : int_filter($_GET['id']);

$tengah = '';

if($_GET['aksi'] == "") {
    $tengah .= '<div class="element-size-67"><div class="cs-campunews custom-fig col-md-12"><div class="error">Harus sesuai prosedur.</div>';
    $tengah .= '<meta http-equiv="refresh" content="3; url=">';
}

if($_GET['aksi'] == "lihat") {
    $id = int_filter($_GET['id']);

    if (file_exists("gambar/6.gif")) {
        $ikon_2 = "<img src=\"gambar/6.gif\" alt=\"\" border=\"0\" />";
    }
    if (file_exists("gambar/7.gif")) {
        $ikon_3 = "<img src=\"gambar/7.gif\" alt=\"\" border=\"0\" />";
    }

    $hasil = $koneksi_db->sql_query("SELECT * FROM artikel WHERE id='$id' AND publikasi=1");
    $data = $koneksi_db->sql_fetchrow($hasil);

    $judulnya = $data['judul'];
    $topik = $data['topik'];
    $tagx = $data['tags'];
    $tgll = $data['tgl'];
    $gambar = $data['gambar'];
    $hits = $data['hits'];
    $hitx = $data['hits'] . ' view';
    $link = $data['link'];
    $kont = $data['konten'];
    $urlkonten = str_replace(" ", "-", $judulnya);
    $urltgl = str_replace("-", "/", $data['tgl']);
    $meta = $data['meta'];

    $judul_situs = $data['judul'];
    if(!$meta) {
        $_META['description'] = limittxt(htmlentities(strip_tags($data['konten'])), 140);
    } else {
        $_META['description'] = $meta;
    }
    $_META['keywords'] = empty($data['tags']) ? implode(',', explode(' ', htmlentities(strip_tags($data['judul'])))) : $data['tags'];

    $hits = $hits + 1;
    $updatehits = $koneksi_db->sql_query("UPDATE artikel SET hits='$hits' WHERE id='$id'");

    $titlenya = "$data[judul]";
    $data[5] = $data['tgl'];
    $ket = "$data[5]";
    $by = '';

    if($data['gambar']) {
        $isinya .= '<img src="images/artikel/' . $data['gambar'] . '" width="100%" alt="' . $data['judul'] . '">';
    }

    $isinya .= $data['konten'];
    $isinya .= "<a href=\"cetak.php?id=$data[id]\" title=\"$data[judul]\"><i class='fa fa-print'></i> Versi cetak</a><br/>";

    include 'modul/function.php';

    $urltagx = str_replace(" ", ",", $judulnya);

    if(!$tagx) {
        $hasil = $koneksi_db->sql_query("SELECT tags FROM `artikel` WHERE id='$id' AND publikasi = 1");
        $TampungData = array();
        while ($data = $koneksi_db->sql_fetchrow($hasil)) {
            $tags = explode(',', strtolower(trim($urltagx)));
            foreach($tags as $val) {
                $TampungData[] = $val;
            }
        }
    } else {
        $hasil = $koneksi_db->sql_query("SELECT tags FROM `artikel` WHERE id='$id' AND publikasi = 1");
        $TampungData = array();
        while ($data = $koneksi_db->sql_fetchrow($hasil)) {
            $tags = explode(',', strtolower(trim($data['tags'])));
            foreach($tags as $val) {
                $TampungData[] = $val;
            }
        }
    }

    $totalTags = count($TampungData);
    $jumlah_tag = array_count_values($TampungData);
    ksort($jumlah_tag);
    
    if ($totalTags > 0) {
        $output = array();
        $tag_mod = array();
        $tag_mod['fontsize']['max'] = 20;
        $tag_mod['fontsize']['min'] = 9;

        $min_count = min($jumlah_tag);
        $spread = max($jumlah_tag) - $min_count;
        if ($spread <= 0) $spread = 1;
        
        $font_spread = $tag_mod['fontsize']['max'] - $tag_mod['fontsize']['min'];
        if ($font_spread <= 0) $font_spread = 1;
        
        $font_step = $font_spread / $spread;

        foreach($jumlah_tag as $key => $val) {
            $font_size = ($tag_mod['fontsize']['min'] + (($val - $min_count) * $font_step));
            $output[] = '<a href="tags/' . urlencode($key) . '.html" title="' . $val . ' artikel"><span>#' . $key . '</span></a>';
        }
        $isinya .= implode(', ', $output);
    }

    themenews($id, $titlenya, $ket, $isinya, datetimess($tgll));

    // Artikel Terkait
    $query = $koneksi_db->sql_query("SELECT * FROM topik WHERE id='$topik'");
    while ($data1 = $koneksi_db->sql_fetchrow($query)) {
        $rubrik = $data1[1];
    }
    
    $hitungjumlah = $koneksi_db->sql_query("SELECT id FROM artikel WHERE id!='$id' AND publikasi=1 AND topik='$topik'");
    $jumlah = $koneksi_db->sql_numrows($hitungjumlah);
    
    $tengah .= '<div style="background: linear-gradient(135deg, #1e4d27 0%, #306238 100%); padding: 16px 24px; margin: 0 0 20px 0; border-radius: 12px; box-shadow: 0 10px 25px rgba(30,77,39,0.15);">
        <h4 style="margin: 0; color: #ffffff; font-size: 18px; font-weight: 700; letter-spacing: 0.5px;">
            <i class="fa fa-newspaper-o" style="margin-right: 8px;"></i>Artikel Terkait
        </h4>
    </div>';
    
    $tengah .= '<div class="artikel-terkait-wrapper" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px;">';
    
    $query2 = $koneksi_db->sql_query("SELECT id, judul, tgl, gambar, konten, hits FROM artikel WHERE id!='$id' AND publikasi=1 AND topik=$topik ORDER BY tgl DESC LIMIT 6");
    
    while ($data = $koneksi_db->sql_fetchrow($query2)) {
        $url = str_replace(" ", "-", $data[1]);
        $id2 = $data[0];
        $judul2 = $data[1];
        $gambar2 = $data[3];
        
        $tengah .= '
        <div class="artikel-card" style="background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: all 0.3s ease; border: 1px solid #f0f0f0;">
            <figure style="margin: 0; width: 100%; height: 180px; overflow: hidden; position: relative;">
                <img src="images/artikel/' . $data['gambar'] . '" alt="' . $data[1] . '" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
            </figure>
            <div style="padding: 16px;">
                <h5 style="font-size: 15px; margin: 0 0 10px 0; line-height: 1.5; font-weight: 600; min-height: 45px;">
                    <a href="artikel/' . $data[0] . '/' . $url . '.html" title="' . $data[1] . '" style="color: #333; text-decoration: none; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">' . $data[1] . '</a>
                </h5>
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px; color: #999; font-size: 12px; flex-wrap: wrap;">
                    <span style="display: flex; align-items: center; gap: 4px;">
                        <i class="fa fa-calendar"></i> ' . datetimess($data['tgl']) . '
                    </span>
                    <span style="display: flex; align-items: center; gap: 4px;">
                        <i class="fa fa-eye"></i> ' . $data['hits'] . ' views
                    </span>
                </div>
                <p style="margin: 0; color: #666; font-size: 13px; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">' . limitTXT(strip_tags($data['konten']), 100) . '</p>
            </div>
        </div>';
    }
    
    $tengah .= '</div>';
    
    // CSS untuk hover effect
    $tengah .= '<style>
        .artikel-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.12) !important;
        }
        .artikel-card:hover img {
            transform: scale(1.05);
        }
        @media (max-width: 768px) {
            .artikel-terkait-wrapper {
                grid-template-columns: 1fr !important;
            }
        }
    </style>';
}

if($_GET['aksi'] == "arsip") {
    $topik = int_filter($_GET['topik']);

    $hasil = $koneksi_db->sql_query("SELECT * FROM topik WHERE id=$topik");
    $data = $koneksi_db->sql_fetchrow($hasil);
    $rubrik = $data['topik'];
    $ket = $data['ket'];
    $urlkontenx = str_replace(" ", ", ", $rubrik);
    $judul_situs = $data['topik'];
    $_META['description'] = $ket;
    $_META['keywords'] = 'Artikel ' . $rubrik . ', ' . $urlkontenx;

    if (empty($rubrik)) {
        $tengah .= '<div class="error">Halaman tidak tersedia.</div>';
        $tengah .= '<meta http-equiv="refresh" content="3; url=index.php">';
    } else {
        $tengah .= '<div style="background: linear-gradient(135deg, #1e4d27 0%, #306238 100%); padding: 30px 40px; margin: 0 0 40px 0; border-radius: 20px; box-shadow: 0 10px 30px rgba(30,77,39,0.15); color: #fff; position: relative; overflow: hidden;">
            <div style="position: absolute; top:0; right: 0; opacity: 0.1;"><svg width="150" height="150" viewBox="0 0 24 24" fill="#fff"><path d="M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"/></svg></div>
            <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; opacity: 0.8; margin-bottom: 8px; font-weight: 700;">Arsip Berita</div>
            <h4 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 800; letter-spacing: -0.5px;">' . $rubrik . '</h4>
        </div>';

        $limit = 10;
        $offset = int_filter(@$_GET['offset']);
        $pg = int_filter(@$_GET['pg']);
        $stg = int_filter(@$_GET['stg']);

        $totals = $koneksi_db->sql_query("SELECT id FROM artikel WHERE publikasi=1 AND topik=$topik");
        $jumlah = $koneksi_db->sql_numrows($totals);
        $a = new paging($limit);

        if ($jumlah > 0) {
            $hasil = $koneksi_db->sql_query("SELECT * FROM artikel WHERE publikasi=1 AND topik=$topik ORDER BY id DESC LIMIT $offset, $limit");

            $tengah .= '<div class="artikel-list-wrapper" style="display: flex; flex-direction: column; gap: 30px;">';

            while ($data = $koneksi_db->sql_fetchrow($hasil)) {
                $url = str_replace(" ", "-", $data[1]);
                $tengah .= '
                <div class="artikel-list-item" style="display: flex; gap: 25px; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 25px rgba(0,0,0,0.04); transition: all 0.4s ease; border: 1px solid #f0f0f0; padding: 20px;">
                    <figure style="margin: 0; width: 300px; min-width: 300px; height: 210px; overflow: hidden; border-radius: 12px;">
                        <img src="images/artikel/' . $data['gambar'] . '" alt="' . $data[1] . '" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;">
                    </figure>
                    <div style="flex: 1; display: flex; flex-direction: column; justify-content: center;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px; color: #306238; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                            <i class="fa fa-calendar"></i> ' . datetimess($data['tgl']) . '
                        </div>
                        <h5 style="font-size: 22px; margin: 0 0 15px 0; line-height: 1.3; font-weight: 800;">
                            <a href="artikel/' . $data[0] . '/' . $url . '.html" title="' . $data[1] . '" style="color: #111; text-decoration: none; transition: color 0.3s;">' . $data[1] . '</a>
                        </h5>
                        <p style="margin: 0; color: #666; font-size: 15px; line-height: 1.7; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">' . limitTXT(strip_tags($data['konten']), 160) . '</p>
                        
                        <div style="margin-top: 20px;">
                            <a href="artikel/' . $data[0] . '/' . $url . '.html" style="display: inline-flex; align-items: center; gap: 8px; color: #fff; background: #1e4d27; padding: 8px 18px; border-radius: 8px; font-size: 13px; font-weight: 700; text-decoration: none; transition: transform 0.3s;">
                                Baca Lengkap <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>';
            }

            $tengah .= '</div>';

            if($jumlah > 10) {
                $tengah .= '<div style="margin-top: 30px;">';
                $tengah .= "<center>";
                
                if (empty($_GET['offset']) && !isset($_GET['offset'])) {
                    $offset = 0;
                }
                if (empty($_GET['pg']) && !isset($_GET['pg'])) {
                    $pg = 1;
                }
                if (empty($_GET['stg']) && !isset($_GET['stg'])) {
                    $stg = 1;
                }
                
                $tengah .= $a->getPaging6($jumlah, $pg, $stg, $topik, $rubrik);
                $tengah .= "</center>";
                $tengah .= '</div>';
            }
            
            // CSS untuk responsive dan hover
            $tengah .= '<style>
                .artikel-list-item:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 20px rgba(0,0,0,0.12) !important;
                }
                .artikel-list-item:hover img {
                    transform: scale(1.05);
                }
                @media (max-width: 768px) {
                    .artikel-list-item {
                        flex-direction: column !important;
                    }
                    .artikel-list-item figure {
                        width: 100% !important;
                        min-width: 100% !important;
                    }
                }
            </style>';
            
        } else {
            $tengah .= '<div class="error">Artikel tidak tersedia.</div>';
            $style_include[] = '<meta http-equiv="refresh" content="3; url=index.php" />';
        }
    }
}

echo $tengah;
?>