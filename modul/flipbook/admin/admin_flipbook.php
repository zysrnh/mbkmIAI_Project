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
// ─────────────────────── RENDER HTML ──────────────────────────────
$admin .= '<div style="background:var(--white); padding:30px; border-radius:12px; box-shadow:var(--shadow-md);">';
$admin .= '<h3 style="color:var(--moss-dark); font-weight:bold; margin-top:0; margin-bottom:20px; font-size:24px;">Manajemen E-Book / Flipbook</h3>';
$admin .= '<p style="margin-bottom:25px;"><a href="admin.php?pilih=flipbook&modul=yes" style="display:inline-block; padding:8px 16px; background:#f4f4f4; color:#333; text-decoration:none; border-radius:4px; font-weight:600; margin-right:10px;">📋 Daftar Buku</a> <a href="admin.php?pilih=flipbook&modul=yes&aksi=tambah" style="display:inline-block; padding:8px 16px; background:var(--moss-dark); color:white; text-decoration:none; border-radius:4px; font-weight:600;">&#43; Tambah Buku</a></p>';

if ($msg)   $admin .= '<div class="sukses">' . $msg . '</div>';
if ($error) $admin .= '<div class="error">' . $error . '</div>';

// ──── FORM TAMBAH ─────
if ($aksi === 'tambah') {
    $admin .= '
    <div style="border:1px solid #ddd; padding:20px; border-radius:8px; background:#fafafa; margin-bottom:30px;">
        <h4 style="margin-top:0; font-weight:bold;">Tambah Buku Baru</h4>
        <form method="post" action="admin.php?pilih=flipbook&modul=yes&aksi=tambah" enctype="multipart/form-data">
        <table width="100%" cellpadding="6">
            <tr>
                <td width="150">Judul Buku <span style="color:red">*</span></td>
                <td><input type="text" name="judul" style="width:100%;" required></td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td><input type="text" name="kategori" style="width:100%;" placeholder="Contoh: Magang, Pertukaran, dll"></td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td><textarea name="deskripsi" rows="3" style="width:100%;"></textarea></td>
            </tr>
            <tr>
                <td>Upload PDF <span style="color:red">*</span></td>
                <td>
                    <input type="file" name="file_pdf" accept=".pdf" required>
                    <br><small style="color:#999">Format: PDF | Max: sesuai php.ini</small>
                </td>
            </tr>
            <tr>
                <td>Cover Buku</td>
                <td>
                    <input type="file" name="cover" accept=".jpg,.jpeg,.png,.webp">
                    <br><small style="color:#999">Opsional. Format: JPG/PNG. Rekomendasi: 220x300px</small>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="submit" value="Simpan Buku" class="btn btn-primary">
                    <a href="admin.php?pilih=flipbook&modul=yes" class="btn btn-default">Batal</a>
                </td>
            </tr>
        </table>
    </form>
    </div>';
}

// ──── FORM EDIT ─────
elseif ($aksi === 'edit' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $row = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM mod_data_flipbook WHERE id='$id'"));
    if ($row) {
        $jdl  = htmlspecialchars($row['judul']);
        $dsk  = htmlspecialchars($row['deskripsi']);
        $kat  = htmlspecialchars($row['kategori']);
        $admin .= '
        <div style="border:1px solid #ddd; padding:20px; border-radius:8px; background:#fafafa; margin-bottom:30px;">
            <h4 style="margin-top:0; font-weight:bold;">Edit Buku</h4>
            <form method="post" action="admin.php?pilih=flipbook&modul=yes&aksi=edit" enctype="multipart/form-data">
            <input type="hidden" name="id" value="' . $id . '">
            <table width="100%" cellpadding="6">
                <tr>
                    <td width="150">Judul Buku</td>
                    <td><input type="text" name="judul" value="' . $jdl . '" style="width:100%;" required></td>
                </tr>
                <tr>
                    <td>Kategori</td>
                    <td><input type="text" name="kategori" value="' . $kat . '" style="width:100%;"></td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td><textarea name="deskripsi" rows="3" style="width:100%;">' . $dsk . '</textarea></td>
                </tr>
                <tr>
                    <td>Ganti PDF</td>
                    <td>
                        <input type="file" name="file_pdf" accept=".pdf">
                        <br><small style="color:#999">Kosongkan jika tidak ingin mengganti. File saat ini: <b>' . htmlspecialchars($row['file_pdf']) . '</b></small>
                    </td>
                </tr>
                <tr>
                    <td>Ganti Cover</td>
                    <td>
                        ' . (!empty($row['cover']) ? '<img src="../images/flipbook/' . htmlspecialchars($row['cover']) . '" height="80" style="margin-bottom:8px;display:block;"><br>' : '') . '
                        <input type="file" name="cover" accept=".jpg,.jpeg,.png,.webp">
                        <br><small style="color:#999">Kosongkan jika tidak ingin mengganti.</small>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" value="Update Buku" class="btn btn-primary">
                        <a href="admin.php?pilih=admin_flipbook" class="btn btn-default">Batal</a>
                    </td>
                </tr>
            </table>
        </form>
        </div>';
    } else {
        $admin .= '<div class="error">Data tidak ditemukan.</div>';
    }
}

// ──── LIST DATA ─────
else {
    $rows = [];
    $q_list = $koneksi_db->sql_query("SELECT * FROM mod_data_flipbook ORDER BY ordering ASC, id DESC");
    while ($r = $koneksi_db->sql_fetchrow($q_list)) $rows[] = $r;

    $admin .= '
    <div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Cover</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>PDF</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>';

    if (empty($rows)) {
        $admin .= '<tr><td colspan="8" style="text-align:center;">Belum ada data.</td></tr>';
    }

    foreach ($rows as $i => $r) {
        $status_label = $r['status'] == 1
            ? '<span style="color:green;">&#10004; Aktif</span>'
            : '<span style="color:red;">&#10006; Nonaktif</span>';
        $thumb = !empty($r['cover'])
            ? '<img src="../images/flipbook/' . htmlspecialchars($r['cover']) . '" height="50" style="border-radius:3px;">'
            : '<span style="color:#bbb; font-size:12px;">No Cover</span>';

        $admin .= '
            <tr>
                <td>' . ($i+1) . '</td>
                <td>' . $thumb . '</td>
                <td><b>' . htmlspecialchars($r['judul']) . '</b></td>
                <td>' . htmlspecialchars($r['kategori']) . '</td>
                <td><a href="../' . htmlspecialchars($r['file_pdf']) . '" target="_blank" style="font-size:12px;">&#128196; Lihat PDF</a></td>
                <td style="font-size:12px;">' . date('d M Y', strtotime($r['tanggal'])) . '</td>
                <td>' . $status_label . '</td>
                <td>
                    <a href="admin.php?pilih=flipbook&modul=yes&aksi=edit&id=' . $r['id'] . '" class="btn btn-xs btn-warning" style="margin:2px;">Edit</a>
                    <a href="admin.php?pilih=flipbook&modul=yes&aksi=toggle&id=' . $r['id'] . '" class="btn btn-xs btn-info" style="margin:2px;">' . ($r['status']==1 ? 'Nonaktifkan' : 'Aktifkan') . '</a>
                    <a href="admin.php?pilih=flipbook&modul=yes&aksi=hapus&id=' . $r['id'] . '" class="btn btn-xs btn-danger" style="margin:2px;" onclick="return confirm(\'Yakin hapus buku ini?\')">Hapus</a>
                </td>
            </tr>';
    }

    $admin .= '</tbody></table></div>';
}

$admin .= '</div>'; // End wrapper div
echo $admin;
?>
