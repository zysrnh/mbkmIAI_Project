<?php
/**
 * Sidebar — Artikel Terkini
 * Konsisten dengan design system halaman utama
 * (Plus Jakarta Sans, palette #1B4332 / #2D6A4F)
 */
?>

<style>
/* ── Sidebar Artikel Terkini ── */
.sb-art-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(27,67,50,.08);
    border: 1px solid rgba(0,0,0,.05);
    overflow: hidden;
    font-family: "Plus Jakarta Sans", sans-serif;
    margin-bottom: 20px;
}
.sb-art-head {
    background: #1B4332;
    padding: 13px 18px;
    display: flex; align-items: center; gap: 9px;
}
.sb-art-head h4 {
    margin: 0;
    font-size: 12.5px; font-weight: 800;
    color: #fff; text-transform: uppercase; letter-spacing: 1.5px;
    font-family: "Plus Jakarta Sans", sans-serif;
}

/* ── Item row ── */
.sb-art-item {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 13px 16px;
    border-bottom: 1px solid #f0f5f2;
    text-decoration: none !important;
    transition: background .18s;
    cursor: pointer;
}
.sb-art-item:last-child { border-bottom: none; }
.sb-art-item:hover { background: #f5faf7; }

/* Thumbnail */
.sb-art-img {
    width: 68px; height: 58px; border-radius: 8px;
    object-fit: cover; flex-shrink: 0;
}
.sb-art-img-ph {
    width: 68px; height: 58px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, #1B4332, #2D6A4F);
    display: flex; align-items: center; justify-content: center;
}
.sb-art-img-ph svg { width: 22px; height: 22px; fill: rgba(255,255,255,.35); }

/* Text */
.sb-art-body { flex: 1; min-width: 0; }
.sb-art-title {
    font-size: 12.5px; font-weight: 700; color: #212529;
    line-height: 1.45; margin: 0 0 5px;
    display: -webkit-box;
    -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    text-decoration: none !important;
    font-family: "Plus Jakarta Sans", sans-serif;
}
.sb-art-item:hover .sb-art-title { color: #1B4332; }
.sb-art-meta {
    font-size: 10.5px; color: #9aab9c;
    display: flex; flex-wrap: wrap; gap: 8px; align-items: center;
}
.sb-art-meta span { display: flex; align-items: center; gap: 3px; }
</style>

<div class="sb-art-card">

    <div class="sb-art-head">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="rgba(255,255,255,.7)">
            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/>
        </svg>
        <h4>Artikel Terkini</h4>
    </div>

    <?php
    $query2 = $koneksi_db->sql_query("SELECT * FROM `artikel` WHERE publikasi=1 ORDER BY `id` DESC LIMIT 4");
    while ($data = $koneksi_db->sql_fetchrow($query2)):
        $url_art = trim(preg_replace('/-+/', '-', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $data[1]))), '-');
        if (empty($url_art)) $url_art = 'artikel-' . $data[0];

        $tgl = datetimess($data[5]);
        $na  = catch_that_image($data[2]);
        $hits = $data[9];
    ?>
    <a class="sb-art-item" href="artikel/<?= $data[0] ?>/<?= $url_art ?>.html" title="<?= htmlspecialchars($data[1]) ?>">

        <?php if ($na): ?>
            <img src="<?= htmlspecialchars($na) ?>" class="sb-art-img" alt="<?= htmlspecialchars($data[1]) ?>">
        <?php elseif (!empty($data['gambar'])): ?>
            <img src="images/artikel/<?= htmlspecialchars($data['gambar']) ?>" class="sb-art-img" alt="<?= htmlspecialchars($data[1]) ?>">
        <?php else: ?>
            <div class="sb-art-img-ph">
                <svg viewBox="0 0 24 24">
                    <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12zM6 10h2v2H6zm0 4h8v2H6zm4-4h8v2h-8z"/>
                </svg>
            </div>
        <?php endif; ?>

        <div class="sb-art-body">
            <div class="sb-art-title"><?= htmlspecialchars($data[1]) ?></div>
            <div class="sb-art-meta">
                <span>
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="#9aab9c"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
                    <?= $tgl ?>
                </span>
                <span>
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="#9aab9c"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <?= $hits ?> dilihat
                </span>
            </div>
        </div>

    </a>
    <?php endwhile; ?>

</div>