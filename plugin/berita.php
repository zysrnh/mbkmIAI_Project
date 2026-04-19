<div class="modern-sidebar">
    <style>
        .modern-sidebar { display: flex; flex-direction: column; gap: 30px; }
        .sidebar-section { background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #f0f0f0; }
        .sidebar-header { background: #1e4d27; color: #fff; padding: 15px 20px; font-weight: 700; font-size: 15px; display: flex; align-items: center; gap: 10px; }
        .sidebar-header svg { width: 18px; height: 18px; fill: currentColor; }
        
        /* Category List */
        .cat-list { list-style: none; padding: 10px 0; margin: 0; }
        .cat-item a { display: flex; justify-content: space-between; align-items: center; padding: 12px 20px; color: #444; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.3s; border-bottom: 1px solid #f9f9f9; }
        .cat-item:last-child a { border-bottom: none; }
        .cat-item a:hover { background: #f8fcf9; color: #306238; padding-left: 25px; }
        .cat-badge { background: #e8f5e9; color: #2e7d32; padding: 2px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
        
        /* Featured Programs */
        .featured-prog { padding: 15px; display: flex; flex-direction: column; gap: 15px; }
        .prog-mini-card { display: flex; gap: 12px; text-decoration: none; color: inherit; }
        .prog-mini-img { width: 70px; height: 50px; border-radius: 8px; object-fit: cover; }
        .prog-mini-info h4 { margin: 0; font-size: 13px; font-weight: 700; color: #222; line-height: 1.3; }
        .prog-mini-info p { margin: 3px 0 0; font-size: 11px; color: #888; }
    </style>

    <!-- Kategori Section -->
    <div class="sidebar-section">
        <div class="sidebar-header">
            <svg viewBox="0 0 24 24"><path d="M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"/></svg>
            Kategori Berita
        </div>
        <ul class="cat-list">
            <?php
            $hasil = $koneksi_db->sql_query("SELECT * FROM topik ORDER BY id ASC");
            while ($data = $koneksi_db->sql_fetchrow($hasil)) {
                $count = $koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT id FROM artikel WHERE topik='".$data['id']."' AND publikasi=1"));
                $url = str_replace(" ", "-", $data['topik']);
                echo '<li class="cat-item">
                    <a href="kategori/'.$data['id'].'/'.$url.'.html">
                        <span>'.$data['topik'].'</span>
                        <span class="cat-badge">'.$count.'</span>
                    </a>
                </li>';
            }
            ?>
        </ul>
    </div>

    <!-- Featured Programs Section -->
    <div class="sidebar-section">
        <div class="sidebar-header">
            <svg viewBox="0 0 24 24"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/></svg>
            Program Unggulan
        </div>
        <div class="featured-prog">
            <?php
            $res_p = $koneksi_db->sql_query("SELECT judul, slug, gambar FROM mod_program ORDER BY id DESC LIMIT 3");
            while($p = $koneksi_db->sql_fetchrow($res_p)) {
                $img = !empty($p['gambar']) ? 'images/pages/'.$p['gambar'] : 'images/no-image.jpg';
                echo '<a href="index.php?pilih=program&modul=yes&id='.$p['slug'].'" class="prog-mini-card">
                    <img src="'.$img.'" class="prog-mini-img">
                    <div class="prog-mini-info">
                        <h4>'.$p['judul'].'</h4>
                    </div>
                </a>';
            }
            ?>
        </div>
    </div>
</div>

								