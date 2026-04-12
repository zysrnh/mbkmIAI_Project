<?php
/**
 * Admin Panel - Manajemen Flipbook / E-Book Pedoman
 * File: modul/flipbook/admin/admin_flipbook.php
 * Dipanggil via: admin.php?pilih=flipbook&modul=yes
 */

if (!defined('cms-ADMINISTRATOR')) {
    Header("Location: ../index.php");
    exit;
}
if (!cek_login()) { exit; }

global $koneksi_db;

// Auto-create table jika belum ada
$koneksi_db->sql_query("
    CREATE TABLE IF NOT EXISTS `mod_data_flipbook` (
      `id`        INT(11) NOT NULL AUTO_INCREMENT,
      `judul`     VARCHAR(255) NOT NULL,
      `deskripsi` TEXT,
      `cover`     VARCHAR(255) DEFAULT NULL COMMENT 'nama file gambar cover',
      `file_pdf`  VARCHAR(255) NOT NULL COMMENT 'path relatif ke PDF',
      `kategori`  VARCHAR(100) DEFAULT NULL,
      `ordering`  INT(5) DEFAULT 0,
      `status`    TINYINT(1) DEFAULT 1 COMMENT '1=aktif, 0=nonaktif',
      `tanggal`   DATETIME DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// Folder upload
$upload_dir_pdf   = '../files/flipbook/';   // path relatif dari root
$upload_dir_cover = '../images/flipbook/';

// Pastikan folder ada
if (!is_dir($upload_dir_pdf))   @mkdir($upload_dir_pdf, 0755, true);
if (!is_dir($upload_dir_cover)) @mkdir($upload_dir_cover, 0755, true);

$aksi   = isset($_GET['aksi'])  ? $_GET['aksi']  : '';
$msg    = '';
$error  = '';
$admin  = '';

// ──────────────────────────────────────────────
// ACTION: TAMBAH
// ──────────────────────────────────────────────
if ($aksi === 'tambah' && isset($_POST['submit'])) {
    $judul     = isset($_POST['judul'])     ? trim(mysqli_real_escape_string($koneksi_db->_db_link, $_POST['judul'])) : '';
    $deskripsi = isset($_POST['deskripsi']) ? trim(mysqli_real_escape_string($koneksi_db->_db_link, $_POST['deskripsi'])) : '';
    $kategori  = isset($_POST['kategori']) ? trim(mysqli_real_escape_string($koneksi_db->_db_link, $_POST['kategori'])) : '';

    if (empty($judul)) { $error = 'Judul tidak boleh kosong.'; }

    // Upload PDF
    $pdf_name = '';
    if (!$error && isset($_FILES['file_pdf']) && $_FILES['file_pdf']['error'] === 0) {
        $ext_pdf = strtolower(pathinfo($_FILES['file_pdf']['name'], PATHINFO_EXTENSION));
        if ($ext_pdf !== 'pdf') {
            $error = 'File harus berformat PDF.';
        } else {
            $pdf_name = time() . '_' . preg_replace('/[^a-z0-9_.]/', '_', strtolower($_FILES['file_pdf']['name']));
            if (!move_uploaded_file($_FILES['file_pdf']['tmp_name'], $upload_dir_pdf . $pdf_name)) {
                $error = 'Gagal upload PDF. Periksa permission folder files/flipbook/';
            }
        }
    } else if (!$error) {
        $error = 'File PDF wajib diupload.';
    }

    // Upload Cover (opsional)
    $cover_name = '';
    if (!$error && isset($_FILES['cover']) && $_FILES['cover']['error'] === 0) {
        $ext_img = strtolower(pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext_img, ['jpg','jpeg','png','webp'])) {
            $error = 'Cover harus berformat JPG/PNG/WEBP.';
        } else {
            $cover_name = 'cover_' . time() . '.' . $ext_img;
            if (!move_uploaded_file($_FILES['cover']['tmp_name'], $upload_dir_cover . $cover_name)) {
                $error = 'Gagal upload cover. Periksa permission folder images/flipbook/';
            }
        }
    }

    if (!$error) {
        $pdf_path = 'files/flipbook/' . $pdf_name;
        $q_max = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT MAX(ordering) as mx FROM mod_data_flipbook"));
        $ordering = (int)$q_max['mx'] + 1;

        $koneksi_db->sql_query("
            INSERT INTO mod_data_flipbook (judul, deskripsi, cover, file_pdf, kategori, ordering, status, tanggal)
            VALUES ('$judul', '$deskripsi', '$cover_name', '$pdf_path', '$kategori', '$ordering', 1, NOW())
        ");
        $msg = 'Buku berhasil ditambahkan!';
        $aksi = ''; // kembali ke list
    }
}

// ──────────────────────────────────────────────
// ACTION: HAPUS
// ──────────────────────────────────────────────
if ($aksi === 'hapus') {
    $id = (int)$_GET['id'];
    $row = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM mod_data_flipbook WHERE id='$id'"));
    if ($row) {
        // Hapus file
        if (!empty($row['file_pdf'])  && file_exists('../' . $row['file_pdf']))  @unlink('../' . $row['file_pdf']);
        if (!empty($row['cover'])    && file_exists($upload_dir_cover . $row['cover'])) @unlink($upload_dir_cover . $row['cover']);
        $koneksi_db->sql_query("DELETE FROM mod_data_flipbook WHERE id='$id'");
        $msg = 'Buku berhasil dihapus.';
    }
    $aksi = '';
}

// ──────────────────────────────────────────────
// ACTION: TOGGLE STATUS
// ──────────────────────────────────────────────
if ($aksi === 'toggle') {
    $id = (int)$_GET['id'];
    $row = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT status FROM mod_data_flipbook WHERE id='$id'"));
    if ($row) {
        $new_status = $row['status'] == 1 ? 0 : 1;
        $koneksi_db->sql_query("UPDATE mod_data_flipbook SET status='$new_status' WHERE id='$id'");
    }
    header("location:admin.php?pilih=flipbook&modul=yes");
    exit;
}

// ──────────────────────────────────────────────
// ACTION: EDIT SAVE
// ──────────────────────────────────────────────
if ($aksi === 'edit' && isset($_POST['submit'])) {
    $id        = (int)$_POST['id'];
    $judul     = trim(mysqli_real_escape_string($koneksi_db->_db_link, $_POST['judul']));
    $deskripsi = trim(mysqli_real_escape_string($koneksi_db->_db_link, $_POST['deskripsi']));
    $kategori  = trim(mysqli_real_escape_string($koneksi_db->_db_link, $_POST['kategori']));
    $row       = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM mod_data_flipbook WHERE id='$id'"));

    // Re-upload PDF (opsional, jika ada file baru)
    $pdf_path = $row['file_pdf'];
    if (isset($_FILES['file_pdf']) && $_FILES['file_pdf']['error'] === 0) {
        $ext_pdf = strtolower(pathinfo($_FILES['file_pdf']['name'], PATHINFO_EXTENSION));
        if ($ext_pdf === 'pdf') {
            if (!empty($row['file_pdf']) && file_exists('../' . $row['file_pdf'])) @unlink('../' . $row['file_pdf']);
            $pdf_name = time() . '_' . preg_replace('/[^a-z0-9_.]/', '_', strtolower($_FILES['file_pdf']['name']));
            move_uploaded_file($_FILES['file_pdf']['tmp_name'], $upload_dir_pdf . $pdf_name);
            $pdf_path = 'files/flipbook/' . $pdf_name;
        }
    }

    // Re-upload Cover (opsional)
    $cover_name = $row['cover'];
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === 0) {
        $ext_img = strtolower(pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION));
        if (in_array($ext_img, ['jpg','jpeg','png','webp'])) {
            if (!empty($row['cover']) && file_exists($upload_dir_cover . $row['cover'])) @unlink($upload_dir_cover . $row['cover']);
            $cover_name = 'cover_' . time() . '.' . $ext_img;
            move_uploaded_file($_FILES['cover']['tmp_name'], $upload_dir_cover . $cover_name);
        }
    }

    $koneksi_db->sql_query("
        UPDATE mod_data_flipbook 
        SET judul='$judul', deskripsi='$deskripsi', cover='$cover_name', file_pdf='$pdf_path', kategori='$kategori'
        WHERE id='$id'
    ");
    $msg = 'Buku berhasil diperbarui.';
    $aksi = '';
}

// ─────────────────────── RENDER HTML ──────────────────────────────
ob_start();
?>
<style>
/* ─── Layout override ─── */
.blog-right { display:none !important; }
.col-sm-8.blog-left { width:100% !important; padding:0 !important; }
.blog-wrapper { background:transparent !important; padding:0 !important; margin-top:0 !important; }

/* ─── CSS Variables ─── */
:root {
    --moss-dark : #306238; --moss-mid : #618D4F; --moss-light: #9EBB97;
    --moss-bg   : #DDE5CD; --moss-olive: #545837; --white: #ffffff;
    --shadow-sm : 0 2px 12px rgba(48,98,56,.10);
    --shadow-md : 0 6px 28px rgba(48,98,56,.16);
    --radius-md : 14px; --transition: all .28s cubic-bezier(.4,0,.2,1);
}

/* ─── Admin Hero ─── */
.adm-hero {
    background: linear-gradient(135deg, var(--moss-dark) 0%, var(--moss-olive) 100%);
    padding: 40px 0 32px; text-align: center; margin-bottom: 0;
    position: relative; overflow: hidden;
}
.adm-hero::before {
    content:''; position:absolute; top:-60px; right:-60px;
    width:260px; height:260px; border-radius:50%;
    background: rgba(255,255,255,.04);
}
.adm-hero-label {
    display:inline-block; color:var(--moss-bg);
    font-size:10.5px; font-weight:700; text-transform:uppercase;
    letter-spacing:3px; background:rgba(255,255,255,.1);
    padding:3px 14px; border-radius:20px; margin-bottom:12px;
}
.adm-hero h1 {
    color:#fff; font-size:26px; font-weight:900;
    margin:0 0 20px; letter-spacing:-0.5px;
}
.adm-btns { display:flex; gap:10px; justify-content:center; flex-wrap:wrap; }
.adm-btn {
    display:inline-flex; align-items:center; gap:7px;
    padding:10px 22px; border-radius:30px;
    font-weight:700; font-size:13px; text-decoration:none;
    transition:var(--transition); box-shadow:0 3px 12px rgba(0,0,0,.2);
}
.adm-btn:hover { transform:translateY(-2px); text-decoration:none; }
.adm-btn-primary { background:#fff; color:var(--moss-dark); }
.adm-btn-primary:hover { background:var(--moss-bg); color:var(--moss-dark); }
.adm-btn-add { background:var(--moss-mid); color:#fff; }
.adm-btn-add:hover { background:#7fad6e; color:#fff; }
.adm-btn-view { background:rgba(255,255,255,.15); color:#fff; border:1px solid rgba(255,255,255,.3); }
.adm-btn-view:hover { background:rgba(255,255,255,.25); color:#fff; }

/* ─── Content area ─── */
.adm-body { background:linear-gradient(180deg,#f0f4ed,#e8ece4); min-height:50vh; padding:36px 0 60px; }
.adm-card {
    background:#fff; border-radius:var(--radius-md);
    box-shadow:var(--shadow-md); padding:32px;
}
.adm-card h4 {
    color:var(--moss-dark); font-size:18px; font-weight:800;
    margin:0 0 22px; padding-bottom:14px;
    border-bottom:2px solid var(--moss-bg);
}

/* ─── Form fields ─── */
.adm-form-group { margin-bottom:18px; }
.adm-form-group label {
    display:block; font-size:13px; font-weight:700;
    color:#444; margin-bottom:6px;
}
.adm-form-group input[type=text],
.adm-form-group textarea,
.adm-form-group select {
    width:100%; padding:10px 14px;
    border:1.5px solid #d8e4d0; border-radius:8px;
    font-size:14px; color:#333; background:#fafef9;
    transition:var(--transition); box-sizing:border-box;
}
.adm-form-group input:focus,
.adm-form-group textarea:focus { border-color:var(--moss-mid); outline:none; }
.adm-file-hint { font-size:11.5px; color:#888; margin-top:5px; }
.adm-form-actions { display:flex; gap:10px; margin-top:24px; flex-wrap:wrap; }
.adm-submit {
    padding:11px 28px; background:var(--moss-dark); color:#fff;
    border:none; border-radius:30px; font-weight:700; font-size:14px;
    cursor:pointer; transition:var(--transition);
}
.adm-submit:hover { background:var(--moss-mid); }
.adm-cancel {
    padding:11px 24px; background:#f0f4ed; color:var(--moss-dark);
    border-radius:30px; font-weight:600; font-size:14px;
    text-decoration:none; transition:var(--transition);
}
.adm-cancel:hover { background:var(--moss-bg); text-decoration:none; color:var(--moss-dark); }

/* ─── Table ─── */
.adm-table { width:100%; border-collapse:collapse; font-size:13.5px; }
.adm-table thead tr { background:var(--moss-dark); color:#fff; }
.adm-table th { padding:12px 14px; font-weight:700; text-align:left; }
.adm-table tbody tr { border-bottom:1px solid #eef3e8; transition:background .15s; }
.adm-table tbody tr:hover { background:#f7faf4; }
.adm-table td { padding:11px 14px; vertical-align:middle; }
.adm-badge-aktif  { color:#2e7d32; font-weight:700; font-size:12px; }
.adm-badge-nonaktif { color:#c62828; font-weight:700; font-size:12px; }
.adm-action-btn {
    display:inline-block; padding:5px 12px; border-radius:20px;
    font-size:11.5px; font-weight:700; text-decoration:none;
    margin:2px; transition:var(--transition);
}
.adm-btn-edit   { background:#fff3cd; color:#856404; }
.adm-btn-edit:hover   { background:#ffc107; color:#fff; text-decoration:none; }
.adm-btn-toggle { background:#e3f2fd; color:#1565c0; }
.adm-btn-toggle:hover { background:#2196f3; color:#fff; text-decoration:none; }
.adm-btn-del    { background:#ffebee; color:#c62828; }
.adm-btn-del:hover    { background:#f44336; color:#fff; text-decoration:none; }

.adm-msg-ok  { background:#e8f5e9; border-left:4px solid var(--moss-mid); color:#2e7d32; padding:14px 18px; border-radius:8px; margin-bottom:20px; font-weight:600; }
.adm-msg-err { background:#ffebee; border-left:4px solid #f44336; color:#c62828; padding:14px 18px; border-radius:8px; margin-bottom:20px; font-weight:600; }
.adm-empty { text-align:center; padding:60px 20px; color:#9eac9e; font-size:14px; }
.adm-empty span { display:block; font-size:48px; margin-bottom:12px; }
</style>

<!-- ADMIN HERO -->
<div class="adm-hero">
    <div class="container">
        <span class="adm-hero-label">Panel Admin</span>
        <h1>📚 Manajemen E-Book &amp; Flipbook</h1>
        <div class="adm-btns">
            <a href="admin.php?pilih=flipbook&modul=yes" class="adm-btn adm-btn-primary">📋 Daftar Buku</a>
            <a href="admin.php?pilih=flipbook&modul=yes&aksi=tambah" class="adm-btn adm-btn-add">&#43; Tambah Buku</a>
            <a href="index.php?pilih=flipbook&modul=yes" target="_blank" class="adm-btn adm-btn-view">👁 Lihat Halaman Publik</a>
        </div>
    </div>
</div>

<!-- ADMIN BODY -->
<div class="adm-body">
<div class="container">
<div class="adm-card">

<?php if ($msg):   ?><div class="adm-msg-ok"><?= $msg ?></div><?php endif; ?>
<?php if ($error): ?><div class="adm-msg-err"><?= $error ?></div><?php endif; ?>

<?php
// ──── FORM TAMBAH ─────
if ($aksi === 'tambah'): ?>
    <h4>Tambah Buku Baru</h4>
    <form method="post" action="admin.php?pilih=flipbook&modul=yes&aksi=tambah" enctype="multipart/form-data">
        <div class="adm-form-group">
            <label>Judul Buku <span style="color:red">*</span></label>
            <input type="text" name="judul" placeholder="Nama buku..." required>
        </div>
        <div class="adm-form-group">
            <label>Kategori</label>
            <input type="text" name="kategori" placeholder="Contoh: Magang, Pertukaran Mahasiswa, dll">
        </div>
        <div class="adm-form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="3" placeholder="Deskripsi singkat buku..."></textarea>
        </div>
        <div class="adm-form-group">
            <label>Upload File PDF <span style="color:red">*</span></label>
            <input type="file" name="file_pdf" accept=".pdf" required style="padding:8px;">
            <div class="adm-file-hint">Format: PDF | Maks sesuai batas server</div>
        </div>
        <div class="adm-form-group">
            <label>Cover Buku <small style="font-weight:400;color:#888">(opsional)</small></label>
            <input type="file" name="cover" accept=".jpg,.jpeg,.png,.webp" style="padding:8px;">
            <div class="adm-file-hint">Format: JPG/PNG | Rekomendasi: 220×300px</div>
        </div>
        <div class="adm-form-actions">
            <button type="submit" name="submit" class="adm-submit">💾 Simpan Buku</button>
            <a href="admin.php?pilih=flipbook&modul=yes" class="adm-cancel">Batal</a>
        </div>
    </form>

<?php
// ──── FORM EDIT ─────
elseif ($aksi === 'edit' && isset($_GET['id'])):
    $id  = (int)$_GET['id'];
    $row = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM mod_data_flipbook WHERE id='$id'"));
    if ($row):
        $jdl = htmlspecialchars($row['judul']);
        $dsk = htmlspecialchars($row['deskripsi']);
        $kat = htmlspecialchars($row['kategori']);
?>
    <h4>Edit Buku</h4>
    <form method="post" action="admin.php?pilih=flipbook&modul=yes&aksi=edit" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="adm-form-group">
            <label>Judul Buku</label>
            <input type="text" name="judul" value="<?= $jdl ?>" required>
        </div>
        <div class="adm-form-group">
            <label>Kategori</label>
            <input type="text" name="kategori" value="<?= $kat ?>">
        </div>
        <div class="adm-form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="3"><?= $dsk ?></textarea>
        </div>
        <div class="adm-form-group">
            <label>Ganti PDF <small style="font-weight:400;color:#888">(kosongkan jika tidak diganti)</small></label>
            <input type="file" name="file_pdf" accept=".pdf" style="padding:8px;">
            <div class="adm-file-hint">File saat ini: <b><?= htmlspecialchars($row['file_pdf']) ?></b></div>
        </div>
        <div class="adm-form-group">
            <label>Ganti Cover <small style="font-weight:400;color:#888">(kosongkan jika tidak diganti)</small></label>
            <?php if (!empty($row['cover'])): ?>
                <img src="../images/flipbook/<?= htmlspecialchars($row['cover']) ?>" height="80" style="border-radius:6px;margin-bottom:10px;display:block;">
            <?php endif; ?>
            <input type="file" name="cover" accept=".jpg,.jpeg,.png,.webp" style="padding:8px;">
        </div>
        <div class="adm-form-actions">
            <button type="submit" name="submit" class="adm-submit">💾 Update Buku</button>
            <a href="admin.php?pilih=flipbook&modul=yes" class="adm-cancel">Batal</a>
        </div>
    </form>
<?php
    else: ?>
    <div class="adm-msg-err">Data tidak ditemukan.</div>
<?php endif;

// ──── LIST DATA ─────
else:
    $rows = [];
    $q_list = $koneksi_db->sql_query("SELECT * FROM mod_data_flipbook ORDER BY ordering ASC, id DESC");
    while ($r = $koneksi_db->sql_fetchrow($q_list)) $rows[] = $r;
?>
    <h4>Daftar Buku (<?= count($rows) ?> buku)</h4>
    <?php if (empty($rows)): ?>
    <div class="adm-empty">
        <span>📚</span>
        Belum ada buku. Klik <b>+ Tambah Buku</b> untuk mulai upload.
    </div>
    <?php else: ?>
    <div style="overflow-x:auto;">
    <table class="adm-table">
        <thead>
            <tr>
                <th style="width:40px">No</th>
                <th style="width:70px">Cover</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>PDF</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $i => $r):
            $thumb = !empty($r['cover'])
                ? '<img src="../images/flipbook/' . htmlspecialchars($r['cover']) . '" height="50" style="border-radius:4px;">'
                : '<span style="color:#ccc;font-size:22px;">📄</span>';
            $status = $r['status'] == 1
                ? '<span class="adm-badge-aktif">✔ Aktif</span>'
                : '<span class="adm-badge-nonaktif">✘ Non</span>';
        ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td><?= $thumb ?></td>
            <td><b><?= htmlspecialchars($r['judul']) ?></b></td>
            <td><small><?= htmlspecialchars($r['kategori']) ?: '-' ?></small></td>
            <td><a href="../<?= htmlspecialchars($r['file_pdf']) ?>" target="_blank" class="adm-action-btn" style="background:#e8f5e9;color:var(--moss-dark);">📄 Lihat</a></td>
            <td style="font-size:12px;"><?= date('d M Y', strtotime($r['tanggal'])) ?></td>
            <td><?= $status ?></td>
            <td>
                <a href="admin.php?pilih=flipbook&modul=yes&aksi=edit&id=<?= $r['id'] ?>" class="adm-action-btn adm-btn-edit">✏ Edit</a>
                <a href="admin.php?pilih=flipbook&modul=yes&aksi=toggle&id=<?= $r['id'] ?>" class="adm-action-btn adm-btn-toggle"><?= $r['status']==1 ? '⏸ Non' : '▶ Aktif' ?></a>
                <a href="admin.php?pilih=flipbook&modul=yes&aksi=hapus&id=<?= $r['id'] ?>" class="adm-action-btn adm-btn-del" onclick="return confirm('Yakin hapus buku ini?')">🗑 Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <?php endif; ?>
<?php endif; ?>

</div><!-- /.adm-card -->
</div><!-- /.container -->
</div><!-- /.adm-body -->

<?php
$admin = ob_get_clean();
echo $admin;
?>

