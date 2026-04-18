<?php
/**
 * Dashboard Admin — Standalone SPA-like Shell
 * Fixed: define names, duplicate keys, PHP 5.4+ compat
 */
error_reporting(E_ALL);
ini_set('display_errors', 0);

if (session_status() === PHP_SESSION_NONE) {
    session_name("Login");
    session_start();
}

// Proteksi — Admin & User level diizinkan
$_level = isset($_SESSION['LevelAkses']) ? $_SESSION['LevelAkses'] : '';
if (!in_array($_level, array('Administrator', 'User', 'Editor'))) {
    header('Location: admin.html');
    exit;
}
$isAdmin = ($_level === 'Administrator');
$isUser  = ($_level === 'User');

// User hanya boleh akses halaman upload_user
$_page_check = isset($_GET['page']) ? $_GET['page'] : 'home';
if ($isUser && !in_array($_page_check, array('home', 'upload_user'))) {
    header('Location: dashboard.php?page=upload_user');
    exit;
}

// Logout
if (isset($_GET['aksi']) && $_GET['aksi'] === 'logout') {
    $_SESSION['UserName']   = '';
    $_SESSION['LevelAkses'] = '';
    $_SESSION['UserEmail']  = '';
    session_destroy();
    header('Location: admin.html');
    exit;
}

$userName = htmlspecialchars(isset($_SESSION['UserName']) ? $_SESSION['UserName'] : 'Admin');

// Active page
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// DB connection
$db_ready    = false;
$koneksi_db  = null;
try {
    if (!defined('cms_KOMPONEN'))      define('cms_KOMPONEN', true);
    if (!defined('cms_KONTEN'))        define('cms_KONTEN', true);
    if (!defined('cms_ADMINISTRATOR')) define('cms_ADMINISTRATOR', true);
    if (!defined('cms_FUNGSI'))        define('cms_FUNGSI', true);
    @include_once 'ikutan/config.php';
    @include_once 'ikutan/mysqli.php';
    @include_once 'ikutan/fungsi.php';
    @include_once 'modul/functions.php';
    if (isset($koneksi_db)) $db_ready = true;
} catch (Exception $e) { /* silent */ }

// Quick stats for home
$totalBooks = 0; $totalUsers = 0; $totalPages = 0; $totalVisits = 0;
if ($db_ready) {
    $r = @$koneksi_db->sql_query("SELECT COUNT(*) as c FROM mod_data_flipbook");
    if ($r) { $d = $koneksi_db->sql_fetchrow($r); $totalBooks = (int)$d['c']; }
    $r = @$koneksi_db->sql_query("SELECT COUNT(*) as c FROM pengguna");
    if ($r) { $d = $koneksi_db->sql_fetchrow($r); $totalUsers = (int)$d['c']; }
    $r = @$koneksi_db->sql_query("SELECT COUNT(*) as c FROM berita");
    if ($r) { $d = $koneksi_db->sql_fetchrow($r); $totalPages = (int)$d['c']; }
    $r = @$koneksi_db->sql_query("SELECT SUM(jumlah) as c FROM statistik");
    if ($r) { $d = $koneksi_db->sql_fetchrow($r); $totalVisits = (int)$d['c']; }
}

// ══════════════════════════════════════════════════════════════
// FLIPBOOK ACTIONS
// ══════════════════════════════════════════════════════════════
$fb_msg = ''; $fb_error = '';
$fb_aksi = '';
if ($page === 'flipbook' && $db_ready) {
    $koneksi_db->sql_query("
        CREATE TABLE IF NOT EXISTS `mod_data_flipbook` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `judul` VARCHAR(255) NOT NULL,
          `deskripsi` TEXT,
          `cover` VARCHAR(255) DEFAULT NULL,
          `file_pdf` VARCHAR(255) NOT NULL,
          `kategori` VARCHAR(100) DEFAULT NULL,
          `ordering` INT(5) DEFAULT 0,
          `status` TINYINT(1) DEFAULT 1,
          `tanggal` DATETIME DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    $doc_root         = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\');
    $upload_dir_pdf   = $doc_root . '/files/flipbook/';
    $upload_dir_cover = $doc_root . '/images/flipbook/';
    if (!is_dir($upload_dir_pdf))   @mkdir($upload_dir_pdf,   0755, true);
    if (!is_dir($upload_dir_cover)) @mkdir($upload_dir_cover, 0755, true);

    $fb_aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';
    if (isset($_GET['msg']) && $_GET['msg'] === 'hapus_ok') $fb_msg = 'Buku berhasil dihapus.';

    // TAMBAH
    if ($fb_aksi === 'tambah' && isset($_POST['submit'])) {
        $judul     = isset($_POST['judul'])     ? trim(strip_tags($_POST['judul']))     : '';
        $deskripsi = isset($_POST['deskripsi']) ? trim(strip_tags($_POST['deskripsi'])) : '';
        $kategori  = isset($_POST['kategori'])  ? trim(strip_tags($_POST['kategori']))  : '';
        if (empty($judul)) $fb_error = 'Judul tidak boleh kosong.';
        $pdf_name = '';
        if (!$fb_error && isset($_FILES['file_pdf']) && $_FILES['file_pdf']['error'] === UPLOAD_ERR_OK) {
            $ext_pdf = strtolower(pathinfo($_FILES['file_pdf']['name'], PATHINFO_EXTENSION));
            if ($ext_pdf !== 'pdf') {
                $fb_error = 'File harus berformat PDF.';
            } else {
                $pdf_name = time() . '_' . preg_replace('/[^a-z0-9_.]/', '_', strtolower($_FILES['file_pdf']['name']));
                if (!move_uploaded_file($_FILES['file_pdf']['tmp_name'], $upload_dir_pdf . $pdf_name))
                    $fb_error = 'Gagal menyimpan PDF.';
            }
        } elseif (!$fb_error) {
            $fb_error = 'File PDF wajib diupload.';
        }
        $cover_name = '';
        $cover_b64  = isset($_POST['cover_base64']) ? trim($_POST['cover_base64']) : '';
        if (!$fb_error && !empty($cover_b64) && strpos($cover_b64, 'data:image') === 0) {
            $b64_data   = preg_replace('#^data:image/\w+;base64,#', '', $cover_b64);
            $img_binary = base64_decode($b64_data);
            if ($img_binary) {
                $cover_name = 'cover_' . time() . '.jpg';
                file_put_contents($upload_dir_cover . $cover_name, $img_binary);
            }
        } elseif (!$fb_error && isset($_FILES['cover']) && $_FILES['cover']['error'] === 0) {
            $ext_img = strtolower(pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION));
            if (in_array($ext_img, array('jpg','jpeg','png','webp'))) {
                $cover_name = 'cover_' . time() . '.' . $ext_img;
                move_uploaded_file($_FILES['cover']['tmp_name'], $upload_dir_cover . $cover_name);
            }
        }
        if (!$fb_error) {
            $pdf_path = 'files/flipbook/' . $pdf_name;
            $q_max    = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT MAX(ordering) as mx FROM mod_data_flipbook"));
            $ordering = (int)$q_max['mx'] + 1;
            $koneksi_db->sql_query("INSERT INTO mod_data_flipbook (judul,deskripsi,cover,file_pdf,kategori,ordering,status,tanggal) VALUES ('$judul','$deskripsi','$cover_name','$pdf_path','$kategori','$ordering',1,NOW())");
            $fb_msg  = 'Buku berhasil ditambahkan!';
            $fb_aksi = '';
        }
    }

    // BULK HAPUS
    if (isset($_POST['bulk_delete_fb']) && is_array($_POST['fb_delete'])) {
        $deleted_count = 0;
        foreach ($_POST['fb_delete'] as $del_id) {
            $del_id = (int)$del_id;
            $row    = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM mod_data_flipbook WHERE id='$del_id'"));
            if ($row) {
                if (!empty($row['file_pdf'])) { $f = $doc_root.'/'.ltrim($row['file_pdf'],'/'); if (file_exists($f)) @unlink($f); }
                if (!empty($row['cover']))    { $f = $upload_dir_cover.$row['cover']; if (file_exists($f)) @unlink($f); }
                $koneksi_db->sql_query("DELETE FROM mod_data_flipbook WHERE id='$del_id'");
                $deleted_count++;
            }
        }
        $fb_msg = $deleted_count . ' buku berhasil dihapus.';
    }

    // HAPUS SINGLE
    if ($fb_aksi === 'hapus') {
        $id  = (int)(isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
        $row = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM mod_data_flipbook WHERE id='$id'"));
        if ($row) {
            if (!empty($row['file_pdf'])) { $f = $doc_root.'/'.ltrim($row['file_pdf'],'/'); if (file_exists($f)) @unlink($f); }
            if (!empty($row['cover']))    { $f = $upload_dir_cover.$row['cover']; if (file_exists($f)) @unlink($f); }
            $koneksi_db->sql_query("DELETE FROM mod_data_flipbook WHERE id='$id'");
        }
        header("Location: dashboard.php?page=flipbook&msg=hapus_ok");
        exit;
    }

    // TOGGLE STATUS
    if ($fb_aksi === 'toggle') {
        $id  = (int)$_GET['id'];
        $row = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT status FROM mod_data_flipbook WHERE id='$id'"));
        if ($row) {
            $ns = $row['status'] == 1 ? 0 : 1;
            $koneksi_db->sql_query("UPDATE mod_data_flipbook SET status='$ns' WHERE id='$id'");
        }
        header("Location: dashboard.php?page=flipbook");
        exit;
    }

    // EDIT SAVE
    if ($fb_aksi === 'edit' && isset($_POST['submit'])) {
        $id        = (int)$_POST['id'];
        $judul     = trim(strip_tags($_POST['judul']));
        $deskripsi = trim(strip_tags($_POST['deskripsi']));
        $kategori  = trim(strip_tags($_POST['kategori']));
        $row       = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM mod_data_flipbook WHERE id='$id'"));
        $pdf_path  = $row['file_pdf'];
        if (isset($_FILES['file_pdf']) && $_FILES['file_pdf']['error'] === 0) {
            $ext_pdf = strtolower(pathinfo($_FILES['file_pdf']['name'], PATHINFO_EXTENSION));
            if ($ext_pdf === 'pdf') {
                $pdf_name = time().'_'.preg_replace('/[^a-z0-9_./]/', '_', strtolower($_FILES['file_pdf']['name']));
                move_uploaded_file($_FILES['file_pdf']['tmp_name'], $upload_dir_pdf . $pdf_name);
                $pdf_path = 'files/flipbook/' . $pdf_name;
            }
        }
        $cover_name = $row['cover'];
        if (isset($_FILES['cover']) && $_FILES['cover']['error'] === 0) {
            $ext_img = strtolower(pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION));
            if (in_array($ext_img, array('jpg','jpeg','png','webp'))) {
                $cover_name = 'cover_'.time().'.'.$ext_img;
                move_uploaded_file($_FILES['cover']['tmp_name'], $upload_dir_cover . $cover_name);
            }
        }
        $koneksi_db->sql_query("UPDATE mod_data_flipbook SET judul='$judul',deskripsi='$deskripsi',cover='$cover_name',file_pdf='$pdf_path',kategori='$kategori' WHERE id='$id'");
        $fb_msg  = 'Buku berhasil diperbarui.';
        $fb_aksi = '';
    }
}

// ══════════════════════════════════════════════════════════════
// PENGGUNA ACTIONS (Admin only)
// ══════════════════════════════════════════════════════════════
$peng_msg    = ''; $peng_error  = '';
$peng_action = '';
if ($page === 'pengguna' && $db_ready && $isAdmin) {
    $peng_action = isset($_GET['action']) ? $_GET['action'] : '';

    // DELETE bulk
    if (isset($_POST['deleted']) && isset($_POST['delete']) && is_array($_POST['delete'])) {
        foreach ($_POST['delete'] as $v) {
            $id = (int)$v;
            $koneksi_db->sql_query("DELETE FROM `pengguna` WHERE `UserId`='$id'");
        }
        $peng_msg = 'Akun berhasil dihapus.';
    }

    // TOGGLE AKTIF
    if ($peng_action === 'toggle') {
        $id = (int)$_GET['id'];
        $st = (isset($_GET['st']) && $_GET['st'] === 'aktif') ? 'aktif' : 'nonaktif';
        $koneksi_db->sql_query("UPDATE `pengguna` SET `tipe`='$st' WHERE `UserId`='$id'");
        header('Location: dashboard.php?page=pengguna');
        exit;
    }

    // RESET PASSWORD
    if ($peng_action === 'reset' && isset($_POST['submit_reset'])) {
        $id      = (int)$_GET['id'];
        $newpass = md5(trim($_POST['new_password']));
        $koneksi_db->sql_query("UPDATE `pengguna` SET `password`='$newpass' WHERE `UserId`='$id'");
        $peng_msg    = 'Password berhasil direset.';
        $peng_action = '';
    }

    // ADD
    if ($peng_action === 'add' && isset($_POST['submit'])) {
        $uname = trim(strip_tags($_POST['uname']));
        $namal = trim(strip_tags($_POST['nama']));
        $email = trim(strip_tags($_POST['email']));
        $level = in_array($_POST['level'], array('Administrator','User','Editor')) ? $_POST['level'] : 'User';
        $pass  = md5(trim($_POST['password']));
        if (empty($uname) || empty($_POST['password'])) {
            $peng_error = 'Username & Password wajib diisi.';
        } else {
            $cek_u = $koneksi_db->sql_query("SELECT UserId FROM `pengguna` WHERE user='$uname'");
            if ($koneksi_db->sql_numrows($cek_u) > 0) {
                $peng_error = 'Username sudah dipakai, pilih username lain.';
            } else {
                $ins = $koneksi_db->sql_query("INSERT INTO `pengguna` (`user`,`password`,`email`,`level`,`tipe`,`nama`) VALUES ('$uname','$pass','$email','$level','aktif','$namal')");
                if ($ins) { $peng_msg = "Akun '$uname' berhasil dibuat."; $peng_action = ''; }
                else $peng_error = 'Gagal membuat akun.';
            }
        }
    }

    // EDIT
    if ($peng_action === 'edit' && isset($_POST['submit'])) {
        $id    = (int)$_GET['id'];
        $namal = trim(strip_tags($_POST['nama']));
        $email = trim(strip_tags($_POST['email']));
        $level = in_array($_POST['level'], array('Administrator','User','Editor')) ? $_POST['level'] : 'User';
        $koneksi_db->sql_query("UPDATE `pengguna` SET `email`='$email',`level`='$level',`nama`='$namal' WHERE `UserId`='$id'");
        $peng_msg    = 'Akun berhasil diperbarui.';
        $peng_action = '';
    }
}

// ══════════════════════════════════════════════════════════════
// UPLOAD KONTEN USER ACTIONS
// ══════════════════════════════════════════════════════════════
$upload_msg = ''; $upload_error = '';
$up_action  = '';
if ($page === 'upload_user' && $db_ready) {
    @$koneksi_db->sql_query("
        CREATE TABLE IF NOT EXISTS `user_uploads` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `user` VARCHAR(100) NOT NULL,
            `judul` VARCHAR(255) NOT NULL,
            `jenis` VARCHAR(100) DEFAULT 'Laporan',
            `file_path` VARCHAR(255) DEFAULT NULL,
            `keterangan` TEXT,
            `status` ENUM('pending','disetujui','ditolak') DEFAULT 'pending',
            `catatan_admin` TEXT,
            `tgl_upload` DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    $up_action = isset($_GET['action']) ? $_GET['action'] : '';

    // Admin: update status
    if ($isAdmin && $up_action === 'setstatus' && isset($_GET['id'], $_GET['st'])) {
        $id      = (int)$_GET['id'];
        $st      = in_array($_GET['st'], array('pending','disetujui','ditolak')) ? $_GET['st'] : 'pending';
        $catatan = isset($_POST['catatan']) ? trim(strip_tags($_POST['catatan'])) : '';
        $koneksi_db->sql_query("UPDATE `user_uploads` SET `status`='$st', `catatan_admin`='$catatan' WHERE `id`='$id'");
        header('Location: dashboard.php?page=upload_user');
        exit;
    }

    // Admin: delete bulk
    if ($isAdmin && isset($_POST['deleted']) && isset($_POST['delete']) && is_array($_POST['delete'])) {
        foreach ($_POST['delete'] as $v) {
            $id = (int)$v;
            $fr = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT file_path FROM `user_uploads` WHERE id='$id'"));
            if ($fr && $fr['file_path']) @unlink('files/uploads/' . $fr['file_path']);
            $koneksi_db->sql_query("DELETE FROM `user_uploads` WHERE `id`='$id'");
        }
        $upload_msg = 'Upload berhasil dihapus.';
    }

    // User: tambah upload
    if ($up_action === 'add' && isset($_POST['submit_upload']) && $isUser) {
        $judul = trim(strip_tags($_POST['judul']));
        $jenis = trim(strip_tags($_POST['jenis']));
        $ket   = trim(strip_tags($_POST['keterangan']));
        $uname = $userName;
        if (empty($judul)) {
            $upload_error = 'Judul wajib diisi.';
        } else {
            $file_path = '';
            if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] === 0) {
                @mkdir($_SERVER['DOCUMENT_ROOT'].'/files/uploads/', 0755, true);
                $ext     = strtolower(pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION));
                $allowed = array('pdf','doc','docx','jpg','jpeg','png','zip');
                if (!in_array($ext, $allowed)) {
                    $upload_error = 'Format file tidak diizinkan (pdf, doc, docx, jpg, png, zip).';
                } else {
                    $file_path = time().'_'.$uname.'.'.$ext;
                    if (!move_uploaded_file($_FILES['file_upload']['tmp_name'], 'files/uploads/'.$file_path)) {
                        $upload_error = 'Gagal menyimpan file.';
                    }
                }
            }
            if (!$upload_error) {
                $ins = $koneksi_db->sql_query("INSERT INTO `user_uploads` (`user`,`judul`,`jenis`,`keterangan`,`file_path`) VALUES ('$uname','$judul','$jenis','$ket','$file_path')");
                if ($ins) $upload_msg = 'Upload berhasil dikirim dan menunggu persetujuan admin.';
                else $upload_error = 'Gagal menyimpan data.';
            }
        }
    }
}

// ══════════════════════════════════════════════════════════════
// PROGRAM MBKM ACTIONS
// ══════════════════════════════════════════════════════════════
$prog_msg    = ''; $prog_error  = '';
$prog_action = '';
if ($page === 'program' && $db_ready) {
    @$koneksi_db->sql_query("ALTER TABLE `halaman` ADD COLUMN `icon` VARCHAR(100) DEFAULT 'fa-star'");
    @$koneksi_db->sql_query("ALTER TABLE `halaman` ADD COLUMN `aktif` ENUM('Y','N') DEFAULT 'Y'");

    $prog_action = isset($_GET['action']) ? $_GET['action'] : '';

    if (isset($_POST['deleted']) && isset($_POST['delete']) && is_array($_POST['delete'])) {
        foreach ($_POST['delete'] as $v) {
            $id = (int)$v;
            $koneksi_db->sql_query("DELETE FROM `halaman` WHERE `id`='$id'");
        }
        $prog_msg = 'Halaman Program berhasil dihapus.';
    }

    if ($prog_action === 'toggle') {
        $id = (int)$_GET['id'];
        $st = (isset($_GET['st']) && $_GET['st'] === 'Y') ? 'Y' : 'N';
        $koneksi_db->sql_query("UPDATE `halaman` SET `aktif`='$st' WHERE `id`='$id'");
        header("Location: dashboard.php?page=program");
        exit;
    }

    if ($prog_action === 'add' && isset($_POST['submit'])) {
        $judul  = trim(strip_tags($_POST['judul']));
        $icon   = trim(strip_tags($_POST['icon']));
        $konten = trim($_POST['konten']);
        $aktif  = isset($_POST['aktif']) ? $_POST['aktif'] : 'Y';
        if (empty($judul)) {
            $prog_error = "Judul tidak boleh kosong.";
        } else {
            $ins = $koneksi_db->sql_query("INSERT INTO `halaman` (`judul`,`icon`,`konten`,`aktif`) VALUES ('$judul','$icon','$konten','$aktif')");
            if ($ins) { $prog_msg = "Program berhasil ditambahkan."; $prog_action = ''; }
            else $prog_error = "Gagal menambah data.";
        }
    }

    if ($prog_action === 'edit' && isset($_POST['submit'])) {
        $id     = (int)$_GET['id'];
        $judul  = trim(strip_tags($_POST['judul']));
        $icon   = trim(strip_tags($_POST['icon']));
        $konten = trim($_POST['konten']);
        $aktif  = isset($_POST['aktif']) ? $_POST['aktif'] : 'Y';
        if (empty($judul)) {
            $prog_error = "Judul tidak boleh kosong.";
        } else {
            $upd = $koneksi_db->sql_query("UPDATE `halaman` SET `judul`='$judul',`icon`='$icon',`konten`='$konten',`aktif`='$aktif' WHERE `id`='$id'");
            if ($upd) { $prog_msg = "Program berhasil diperbarui."; $prog_action = ''; }
            else $prog_error = "Gagal memperbarui data.";
        }
    }
}

// ══════════════════════════════════════════════════════════════
// TENTANG & PROFIL ACTIONS
// ══════════════════════════════════════════════════════════════
$prof_msg = ''; $prof_error = '';
if ($page === 'sambutan' && $db_ready) {
    if (isset($_POST['submit_profil'])) {
        $slogan   = trim(strip_tags($_POST['slogan']));
        $sambutan = $_POST['sambutan'];
        $nama     = trim(strip_tags($_POST['nama']));
        $video_id = trim(strip_tags($_POST['video_id']));
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w-]+)/', $video_id, $m)) {
            $video_id = $m[1];
        }
        $koneksi_db->sql_query("UPDATE `mod_data_profil` SET `nama`='$nama', `slogan`='$slogan', `sambutan`='$sambutan' WHERE `id`='1'");
        $existing_vid = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT id FROM `mod_data_video` ORDER BY id DESC LIMIT 1"));
        if ($existing_vid) {
            $koneksi_db->sql_query("UPDATE `mod_data_video` SET `video`='$video_id', `nama`='Video Profil' WHERE `id`='".$existing_vid['id']."'");
        } elseif (!empty($video_id)) {
            $koneksi_db->sql_query("INSERT INTO `mod_data_video` (`nama`,`video`,`ket`) VALUES ('Video Profil','$video_id','Video profil MBKM')");
        }
        $prof_msg = "Profil & Tentang berhasil diperbarui.";
    }
}

// ══════════════════════════════════════════════════════════════
// GALERI KEGIATAN ACTIONS
// ══════════════════════════════════════════════════════════════
$galeri_msg    = ''; $galeri_error  = '';
$galeri_action = '';
if ($page === 'galeri' && $db_ready) {
    $galeri_action = isset($_GET['action']) ? $_GET['action'] : '';

    if (isset($_POST['deleted']) && isset($_POST['delete']) && is_array($_POST['delete'])) {
        foreach ($_POST['delete'] as $v) {
            $id = (int)$v;
            $koneksi_db->sql_query("DELETE FROM `mod_data_foto` WHERE `id`='$id'");
        }
        $galeri_msg = 'Foto berhasil dihapus.';
    }

    if ($galeri_action === 'add' && isset($_POST['submit'])) {
        $nama = trim(strip_tags($_POST['nama']));
        $ket  = $_POST['ket'];
        if (empty($nama)) {
            $galeri_error = 'Nama foto wajib diisi.';
        } else {
            $foto_name = 'na.jpg';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, array('jpg','jpeg','png','webp'))) {
                    $foto_name = 'galeri_'.time().'.'.$ext;
                    move_uploaded_file($_FILES['image']['tmp_name'], 'images/foto/'.$foto_name);
                }
            }
            $ins = $koneksi_db->sql_query("INSERT INTO `mod_data_foto` (`nama`,`foto`,`ket`,`tanggal`) VALUES ('$nama','$foto_name','$ket',NOW())");
            if ($ins) { $galeri_msg = 'Foto berhasil ditambahkan.'; $galeri_action = ''; }
            else $galeri_error = 'Gagal menambah foto.';
        }
    }

    if ($galeri_action === 'edit' && isset($_POST['submit'])) {
        $id   = (int)$_GET['id'];
        $nama = trim(strip_tags($_POST['nama']));
        $ket  = $_POST['ket'];
        $row  = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM `mod_data_foto` WHERE id='$id'"));
        $foto_name = $row['foto'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, array('jpg','jpeg','png','webp'))) {
                $foto_name = 'galeri_'.time().'.'.$ext;
                move_uploaded_file($_FILES['image']['tmp_name'], 'images/foto/'.$foto_name);
            }
        }
        $koneksi_db->sql_query("UPDATE `mod_data_foto` SET `nama`='$nama',`foto`='$foto_name',`ket`='$ket' WHERE `id`='$id'");
        $galeri_msg    = 'Foto berhasil diperbarui.';
        $galeri_action = '';
    }
}

// ══════════════════════════════════════════════════════════════
// TESTIMONI ACTIONS
// ══════════════════════════════════════════════════════════════
$testi_msg    = ''; $testi_error  = '';
$testi_action = '';
if ($page === 'testimoni' && $db_ready) {
    $testi_action = isset($_GET['action']) ? $_GET['action'] : '';

    if (isset($_POST['deleted']) && isset($_POST['delete']) && is_array($_POST['delete'])) {
        foreach ($_POST['delete'] as $v) {
            $id = (int)$v;
            $koneksi_db->sql_query("DELETE FROM `mod_data_testi` WHERE `id`='$id'");
        }
        $testi_msg = 'Testimoni berhasil dihapus.';
    }

    if ($testi_action === 'pub') {
        $id  = (int)$_GET['id'];
        $pub = (int)$_GET['pub'];
        $koneksi_db->sql_query("UPDATE `mod_data_testi` SET `status`='$pub' WHERE `id`='$id'");
        $testi_msg    = 'Status publikasi berhasil diperbarui.';
        $testi_action = '';
    }

    if ($testi_action === 'add' && isset($_POST['submit'])) {
        $nama  = trim(strip_tags($_POST['nama']));
        $email = trim(strip_tags($_POST['email']));
        $ket   = $_POST['ket'];
        if (empty($nama)) {
            $testi_error = 'Nama wajib diisi.';
        } else {
            $foto_name = 'na.jpg';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, array('jpg','jpeg','png','webp'))) {
                    $foto_name = 'testi_'.time().'.'.$ext;
                    move_uploaded_file($_FILES['image']['tmp_name'], 'images/testi/'.$foto_name);
                }
            }
            $ins = $koneksi_db->sql_query("INSERT INTO `mod_data_testi` (`nama`,`ket`,`email`,`tanggal`,`foto`,`status`) VALUES ('$nama','$ket','$email',CURDATE(),'$foto_name','1')");
            if ($ins) { $testi_msg = 'Testimoni berhasil ditambahkan.'; $testi_action = ''; }
            else $testi_error = 'Gagal menambah testimoni.';
        }
    }

    if ($testi_action === 'edit' && isset($_POST['submit'])) {
        $id    = (int)$_GET['id'];
        $nama  = trim(strip_tags($_POST['nama']));
        $email = trim(strip_tags($_POST['email']));
        $ket   = $_POST['ket'];
        $row   = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM `mod_data_testi` WHERE id='$id'"));
        $foto_name = $row['foto'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, array('jpg','jpeg','png','webp'))) {
                $foto_name = 'testi_'.time().'.'.$ext;
                move_uploaded_file($_FILES['image']['tmp_name'], 'images/testi/'.$foto_name);
            }
        }
        $koneksi_db->sql_query("UPDATE `mod_data_testi` SET `nama`='$nama',`foto`='$foto_name',`ket`='$ket',`email`='$email' WHERE `id`='$id'");
        $testi_msg    = 'Testimoni berhasil diperbarui.';
        $testi_action = '';
    }
}

// ══════════════════════════════════════════════════════════════
// BERITA & KEGIATAN ACTIONS
// ══════════════════════════════════════════════════════════════
$berita_msg    = ''; $berita_error  = '';
$berita_action = '';
if ($page === 'berita' && $db_ready) {
    $berita_action = isset($_GET['action']) ? $_GET['action'] : '';

    if (isset($_POST['deleted']) && isset($_POST['delete']) && is_array($_POST['delete'])) {
        foreach ($_POST['delete'] as $v) {
            $id = (int)$v;
            $koneksi_db->sql_query("DELETE FROM `artikel` WHERE `id`='$id'");
        }
        $berita_msg = 'Artikel berhasil dihapus.';
    }

    if ($berita_action === 'pub') {
        $id  = (int)$_GET['id'];
        $pub = (int)$_GET['pub'];
        $koneksi_db->sql_query("UPDATE `artikel` SET `publikasi`='$pub' WHERE `id`='$id'");
        $berita_msg    = 'Status publikasi berhasil diperbarui.';
        $berita_action = '';
    }

    if ($berita_action === 'add' && isset($_POST['submit'])) {
        $judul  = trim(strip_tags($_POST['judul']));
        $konten = $_POST['konten'];
        $tags   = trim(strip_tags($_POST['tags']));
        if (empty($judul)) {
            $berita_error = 'Judul wajib diisi.';
        } else {
            $foto_name = '';
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
                $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, array('jpg','jpeg','png','webp'))) {
                    $foto_name = 'berita_'.time().'.'.$ext;
                    move_uploaded_file($_FILES['gambar']['tmp_name'], 'images/artikel/'.$foto_name);
                }
            }
            $user = $userName;
            $ins  = $koneksi_db->sql_query("INSERT INTO `artikel` (`judul`,`gambar`,`konten`,`tgl`,`user`,`publikasi`,`tags`) VALUES ('$judul','$foto_name','$konten',NOW(),'$user','1','$tags')");
            if ($ins) { $berita_msg = 'Artikel berhasil ditambahkan.'; $berita_action = ''; }
            else $berita_error = 'Gagal menambah artikel.';
        }
    }

    if ($berita_action === 'edit' && isset($_POST['submit'])) {
        $id     = (int)$_GET['id'];
        $judul  = trim(strip_tags($_POST['judul']));
        $konten = $_POST['konten'];
        $tags   = trim(strip_tags($_POST['tags']));
        $row    = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM `artikel` WHERE id='$id'"));
        $foto_name = $row['gambar'];
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
            $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, array('jpg','jpeg','png','webp'))) {
                $foto_name = 'berita_'.time().'.'.$ext;
                move_uploaded_file($_FILES['gambar']['tmp_name'], 'images/artikel/'.$foto_name);
            }
        }
        $koneksi_db->sql_query("UPDATE `artikel` SET `judul`='$judul',`gambar`='$foto_name',`konten`='$konten',`tags`='$tags' WHERE `id`='$id'");
        $berita_msg    = 'Artikel berhasil diperbarui.';
        $berita_action = '';
    }
}

// ══════════════════════════════════════════════════════════════
// PAGE TITLES — no duplicate keys
// ══════════════════════════════════════════════════════════════
$pageTitles = array(
    'home'        => array('Dashboard',          'Overview'),
    'flipbook'    => array('E-Book Manager',      'Kelola E-Book'),
    'pengguna'    => array('Kelola Akun',         'Manajemen Pengguna'),
    'program'     => array('Program MBKM',        'Kelola Program MBKM'),
    'sambutan'    => array('Konfigurasi Website', 'Profil & Tentang'),
    'galeri'      => array('Galeri Kegiatan',     'Kelola Galeri Foto'),
    'testimoni'   => array('Testimoni',           'Kelola Testimoni'),
    'berita'      => array('Berita & Kegiatan',   'Kelola Artikel'),
    'upload_user' => array('Upload Konten',       'Upload & Review Konten'),
);
$pageTitle = isset($pageTitles[$page]) ? $pageTitles[$page] : array('Dashboard', 'Overview');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle[0]; ?> - MBKM IAI PI Bandung</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <?php if ($page === 'flipbook' && $fb_aksi === 'tambah'): ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <?php endif; ?>
    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --sidebar-w: 264px;
        --primary-900: #1a3a20; --primary-800: #1e4d27; --primary-700: #256830;
        --primary-600: #2d7a3a; --primary-500: #38934a; --primary-400: #4caf5c;
        --primary-300: #81c784; --primary-200: #a5d6a7; --primary-100: #c8e6c9;
        --primary-50: #e8f5e9; --accent-500: #f9a825;
        --surface: #f4f6f3; --surface-card: #ffffff;
        --text-primary: #1b2e1f; --text-secondary: #5a6e5e; --text-muted: #8a9a8e;
        --border: rgba(37,104,48,.08);
        --shadow-sm: 0 1px 3px rgba(0,0,0,.04);
        --shadow-md: 0 4px 12px rgba(0,0,0,.05);
        --shadow-lg: 0 10px 25px rgba(0,0,0,.06);
        --radius-sm: 8px; --radius-md: 12px; --radius-lg: 16px; --radius-xl: 20px;
        --ease: cubic-bezier(.4,0,.2,1);
    }

    body {
        font-family: 'Inter', -apple-system, sans-serif;
        background: var(--surface); color: var(--text-primary);
        min-height: 100vh; display: flex; overflow-x: hidden;
    }

    /* ═══ SIDEBAR ═══ */
    .sidebar {
        width: var(--sidebar-w); height: 100vh; position: fixed; left: 0; top: 0;
        background: linear-gradient(180deg, var(--primary-900) 0%, #122615 100%);
        display: flex; flex-direction: column; z-index: 200;
        transition: transform .35s var(--ease);
    }
    .sidebar::before {
        content:''; position:absolute; inset:0;
        background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.015'%3E%3Cpath d='M20 20.5V18H0v-2h20v-2l4 3-4 3z'/%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }
    .sidebar-brand {
        padding: 24px 20px 20px; border-bottom: 1px solid rgba(255,255,255,.06);
        display: flex; align-items: center; gap: 12px; flex-shrink: 0; position: relative;
    }
    .sidebar-brand-icon {
        width: 40px; height: 40px;
        background: linear-gradient(135deg, var(--primary-500), var(--primary-300));
        border-radius: 10px; display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; box-shadow: 0 4px 12px rgba(56,147,74,.25);
    }
    .sidebar-brand-icon svg { width: 20px; height: 20px; fill: #fff; }
    .sidebar-brand h2 { font-size: 14px; font-weight: 800; color: #fff; letter-spacing: -.2px; line-height: 1.3; }
    .sidebar-brand span { font-size: 10px; color: rgba(255,255,255,.4); font-weight: 600; letter-spacing: 1px; text-transform: uppercase; display: block; }

    .sidebar-nav { flex: 1; overflow-y: auto; padding: 14px 10px; scrollbar-width: thin; scrollbar-color: rgba(255,255,255,.08) transparent; }
    .nav-label {
        font-size: 9.5px; font-weight: 700; color: rgba(255,255,255,.25);
        text-transform: uppercase; letter-spacing: 1.5px; padding: 12px 14px 6px;
    }
    .nav-item {
        display: flex; align-items: center; gap: 11px; padding: 9px 14px;
        border-radius: var(--radius-sm); color: rgba(255,255,255,.55);
        text-decoration: none; font-size: 13px; font-weight: 500;
        transition: all .2s var(--ease); position: relative; margin-bottom: 1px;
    }
    .nav-item:hover { background: rgba(255,255,255,.06); color: rgba(255,255,255,.9); }
    .nav-item.active { background: rgba(255,255,255,.1); color: #fff; font-weight: 600; }
    .nav-item.active::before {
        content:''; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
        width: 3px; height: 18px; background: var(--primary-400); border-radius: 0 3px 3px 0;
    }
    .nav-item svg { width: 18px; height: 18px; fill: currentColor; flex-shrink: 0; opacity: .65; }
    .nav-item.active svg, .nav-item:hover svg { opacity: 1; }
    .nav-badge { margin-left: auto; background: var(--primary-500); color: #fff; font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 8px; }

    .sidebar-footer { padding: 14px; border-top: 1px solid rgba(255,255,255,.06); flex-shrink: 0; }
    .sidebar-user { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: var(--radius-sm); background: rgba(255,255,255,.04); }
    .sidebar-avatar {
        width: 34px; height: 34px; border-radius: 9px;
        background: linear-gradient(135deg, var(--primary-500), var(--accent-500));
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 800; color: #fff; flex-shrink: 0;
    }
    .sidebar-user-name { font-size: 12.5px; font-weight: 600; color: #fff; }
    .sidebar-user-role { font-size: 10.5px; color: rgba(255,255,255,.35); font-weight: 500; }
    .sidebar-logout {
        margin-left: auto; width: 30px; height: 30px; border-radius: 7px;
        background: rgba(255,255,255,.05); border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        color: rgba(255,255,255,.35); transition: all .2s;
    }
    .sidebar-logout:hover { background: rgba(239,83,80,.15); color: #ef5350; }
    .sidebar-logout svg { width: 15px; height: 15px; fill: currentColor; }

    /* ═══ MAIN ═══ */
    .main-wrapper {
        margin-left: var(--sidebar-w); flex: 1; min-height: 100vh;
        display: flex; flex-direction: column; transition: margin-left .35s var(--ease);
    }
    .topbar {
        height: 56px; background: var(--surface-card); border-bottom: 1px solid var(--border);
        display: flex; align-items: center; padding: 0 28px;
        position: sticky; top: 0; z-index: 100; gap: 12px;
    }
    .topbar-toggle {
        display: none; width: 36px; height: 36px; border-radius: 8px;
        border: 1px solid var(--border); background: var(--surface-card); cursor: pointer;
        align-items: center; justify-content: center; color: var(--text-secondary);
    }
    .topbar-toggle svg { width: 18px; height: 18px; fill: currentColor; }
    .topbar-title { font-size: 14px; font-weight: 700; color: var(--text-primary); }
    .topbar-title span { color: var(--text-muted); font-weight: 400; }
    .topbar-right { margin-left: auto; display: flex; align-items: center; gap: 10px; }
    .topbar-clock {
        font-size: 12px; font-weight: 600; color: var(--text-secondary);
        background: var(--surface); padding: 5px 12px; border-radius: 16px;
        display: flex; align-items: center; gap: 5px;
    }
    .topbar-clock svg { width: 13px; height: 13px; fill: var(--text-muted); }
    .topbar-visit {
        font-size: 11.5px; font-weight: 600; color: var(--primary-600);
        background: var(--primary-50); padding: 6px 12px; border-radius: 8px;
        text-decoration: none; display: flex; align-items: center; gap: 5px; transition: all .2s;
    }
    .topbar-visit:hover { background: var(--primary-100); }
    .topbar-visit svg { width: 13px; height: 13px; fill: currentColor; }

    .content { padding: 28px; flex: 1; }

    /* ═══ HOME ═══ */
    .welcome-card {
        background: linear-gradient(135deg, var(--primary-800) 0%, var(--primary-600) 50%, #2e7d32 100%);
        border-radius: var(--radius-xl); padding: 36px 40px; color: #fff;
        position: relative; overflow: hidden; margin-bottom: 28px;
        box-shadow: 0 12px 40px rgba(30,77,39,.18);
    }
    .welcome-card::before {
        content:''; position: absolute; right: -50px; top: -70px;
        width: 300px; height: 300px; border-radius: 50%;
        background: radial-gradient(circle, rgba(255,255,255,.07) 0%, transparent 70%);
    }
    .welcome-inner { position: relative; z-index: 1; display: flex; align-items: center; justify-content: space-between; }
    .welcome-text h1 { font-size: 24px; font-weight: 800; margin-bottom: 6px; letter-spacing: -.3px; }
    .welcome-text p { font-size: 13px; color: rgba(255,255,255,.65); max-width: 420px; line-height: 1.5; }
    .welcome-clock-big { font-size: 44px; font-weight: 900; color: rgba(255,255,255,.8); letter-spacing: -2px; line-height: 1; }
    .welcome-date-big { font-size: 12px; color: rgba(255,255,255,.4); font-weight: 500; text-align: right; margin-top: 4px; }

    .stats-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-bottom: 28px; }
    .stat-card {
        background: var(--surface-card); border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: 22px;
        transition: all .3s var(--ease); position: relative; overflow: hidden;
    }
    .stat-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-2px); }
    .stat-card::before {
        content:''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        border-radius: var(--radius-lg) var(--radius-lg) 0 0; opacity: 0; transition: opacity .3s;
    }
    .stat-card:hover::before { opacity: 1; }
    .stat-card:nth-child(1)::before { background: linear-gradient(90deg,var(--primary-500),var(--primary-300)); }
    .stat-card:nth-child(2)::before { background: linear-gradient(90deg,#5c6bc0,#9fa8da); }
    .stat-card:nth-child(3)::before { background: linear-gradient(90deg,#f57c00,#ffb74d); }
    .stat-card:nth-child(4)::before { background: linear-gradient(90deg,#00acc1,#80deea); }
    .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; }
    .stat-icon svg { width: 20px; height: 20px; fill: currentColor; }
    .stat-card:nth-child(1) .stat-icon { background: var(--primary-50); color: var(--primary-600); }
    .stat-card:nth-child(2) .stat-icon { background: #e8eaf6; color: #5c6bc0; }
    .stat-card:nth-child(3) .stat-icon { background: #fff3e0; color: #f57c00; }
    .stat-card:nth-child(4) .stat-icon { background: #e0f7fa; color: #00acc1; }
    .stat-value { font-size: 28px; font-weight: 800; letter-spacing: -1px; font-variant-numeric: tabular-nums; }
    .stat-label { font-size: 11.5px; font-weight: 600; color: var(--text-muted); margin-top: 4px; text-transform: uppercase; letter-spacing: .4px; }

    .home-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

    /* ═══ PANEL / CARD ═══ */
    .panel {
        background: var(--surface-card); border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden; margin-bottom: 20px;
    }
    .panel-header {
        padding: 18px 22px; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
    }
    .panel-title { font-size: 13.5px; font-weight: 700; display: flex; align-items: center; gap: 7px; }
    .panel-title svg { width: 16px; height: 16px; fill: var(--text-muted); }
    .panel-body { padding: 0; }
    .panel-body-padded { padding: 22px; }

    .quick-action {
        display: flex; align-items: center; gap: 12px; padding: 14px 22px;
        text-decoration: none; color: var(--text-primary);
        border-bottom: 1px solid var(--border); transition: all .15s;
    }
    .quick-action:last-child { border-bottom: none; }
    .quick-action:hover { background: var(--primary-50); }
    .qa-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .qa-icon svg { width: 18px; height: 18px; fill: currentColor; }
    .qa-icon.green { background: var(--primary-50); color: var(--primary-600); }
    .qa-icon.blue  { background: #e3f2fd; color: #1976d2; }
    .qa-icon.teal  { background: #e0f2f1; color: #00897b; }
    .qa-title { font-size: 13px; font-weight: 600; }
    .qa-desc { font-size: 11.5px; color: var(--text-muted); margin-top: 1px; }
    .qa-arrow {
        margin-left: auto; width: 26px; height: 26px; border-radius: 6px;
        background: var(--surface); display: flex; align-items: center; justify-content: center;
        color: var(--text-muted); transition: all .2s; flex-shrink: 0;
    }
    .quick-action:hover .qa-arrow { background: var(--primary-600); color: #fff; }
    .qa-arrow svg { width: 13px; height: 13px; fill: currentColor; }

    .info-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 22px; border-bottom: 1px solid var(--border); font-size: 12.5px;
    }
    .info-item:last-child { border-bottom: none; }
    .info-label { color: var(--text-muted); font-weight: 500; display: flex; align-items: center; gap: 7px; }
    .info-label svg { width: 14px; height: 14px; fill: var(--text-muted); }
    .info-value { font-weight: 600; }
    .info-badge { font-size: 10.5px; font-weight: 700; padding: 2px 9px; border-radius: 5px; }
    .info-badge.green { background: var(--primary-50); color: var(--primary-600); }
    .info-badge.blue  { background: #e3f2fd; color: #1565c0; }

    /* ═══ PAGE HEADER ═══ */
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 22px; flex-wrap: wrap; gap: 12px;
    }
    .page-header h2 { font-size: 20px; font-weight: 800; letter-spacing: -.3px; display: flex; align-items: center; }
    .page-header p { font-size: 13px; color: var(--text-muted); margin-top: 2px; }
    .add-btn {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 22px; border-radius: 10px; font-size: 13px; font-weight: 700;
        background: var(--primary-600); color: #fff; text-decoration: none;
        border: none; cursor: pointer; transition: all .25s var(--ease);
        box-shadow: 0 2px 8px rgba(48,98,56,.18);
    }
    .add-btn:hover { background: var(--primary-700); transform: translateY(-1px); box-shadow: 0 4px 14px rgba(48,98,56,.25); text-decoration: none; color: #fff; }
    .add-btn svg { width: 16px; height: 16px; fill: currentColor; }
    .btn-group { display: flex; gap: 8px; flex-wrap: wrap; }
    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 18px; border-radius: 8px; font-size: 12.5px; font-weight: 600;
        text-decoration: none; border: none; cursor: pointer; transition: all .2s;
    }
    .btn-primary { background: var(--primary-600); color: #fff; }
    .btn-primary:hover { background: var(--primary-700); color: #fff; }
    .btn-outline { background: var(--surface-card); color: var(--text-primary); border: 1px solid var(--border); }
    .btn-outline:hover { background: var(--surface); }
    .btn svg { width: 15px; height: 15px; fill: currentColor; }

    /* ═══ ALERTS / MESSAGES ═══ */
    .msg-ok, .alert, .alert-success {
        background: var(--primary-50); border-left: 4px solid var(--primary-500);
        color: #2e7d32; padding: 12px 16px; border-radius: 8px; margin-bottom: 18px;
        font-size: 13px; font-weight: 600;
    }
    .msg-err, .alert-error {
        background: #fbe9e7; border-left: 4px solid #f44336;
        color: #c62828; padding: 12px 16px; border-radius: 8px; margin-bottom: 18px;
        font-size: 13px; font-weight: 600;
    }

    /* ═══ TABLE ═══ */
    .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .data-table, .table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .data-table thead th, .table thead th {
        padding: 12px 16px; font-weight: 700; text-align: left; font-size: 11.5px;
        text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted);
        background: var(--surface); border-bottom: 2px solid var(--border); white-space: nowrap;
    }
    .data-table tbody tr, .table tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
    .data-table tbody tr:hover, .table.table-hover tbody tr:hover { background: #f8faf7; }
    .data-table td, .table td { padding: 12px 16px; vertical-align: middle; color: var(--text-secondary); }
    .data-table td b, .table td b { color: var(--text-primary); font-weight: 600; }
    .text-center { text-align: center; }

    .badge {
        display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px;
        border-radius: 6px; font-size: 11px; font-weight: 700;
        text-decoration: none; transition: all .2s; white-space: nowrap;
    }
    .badge:hover { text-decoration: none; filter: brightness(.92); }
    .badge-aktif    { background: var(--primary-50); color: var(--primary-600); }
    .badge-nonaktif { background: #fbe9e7; color: #c62828; }
    .badge-level    { background: #e8eaf6; color: #5c6bc0; }

    .action-btn {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 5px 12px; border-radius: 6px; font-size: 11px; font-weight: 600;
        text-decoration: none; margin: 2px; transition: all .2s; border: none; cursor: pointer;
    }
    .action-edit   { background: #fff8e1; color: #f57f17; }
    .action-edit:hover   { background: #ffc107; color: #fff; }
    .action-toggle { background: #e3f2fd; color: #1565c0; }
    .action-toggle:hover { background: #2196f3; color: #fff; }
    .action-del    { background: #ffebee; color: #c62828; }
    .action-del:hover    { background: #f44336; color: #fff; border-color: #f44336; }
    .action-reset  { background: #f3e5f5; color: #7b1fa2; }
    .action-reset:hover  { background: #9c27b0; color: #fff; }
    .action-delete {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 6px 14px; border-radius: 6px; font-size: 11.5px; font-weight: 600;
        border: 1.5px solid #ef9a9a; background: #fff; color: #c62828;
        cursor: pointer; transition: all .2s;
    }
    .action-delete:hover { background: #f44336; color: #fff; border-color: #f44336; }

    .empty-state { text-align: center; padding: 48px 20px; color: var(--text-muted); }
    .empty-state span { display: block; font-size: 42px; margin-bottom: 10px; }

    /* ═══ FORM ═══ */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-group { margin-bottom: 16px; }
    .form-group.full { grid-column: 1 / -1; }
    .form-group label { display: block; font-size: 12px; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px; }
    .form-group label .req { color: #e53935; }
    .form-control {
        width: 100%; padding: 9px 13px; border: 1.5px solid var(--border);
        border-radius: 8px; font-size: 13px; font-family: inherit;
        background: #fafdf9; transition: border .2s;
    }
    .form-control:focus { border-color: var(--primary-400); outline: none; background: #fff; }
    select.form-control {
        -webkit-appearance: none; -moz-appearance: none; appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='%238a9a8e'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 12px center; padding-right: 32px;
    }
    .form-hint { font-size: 11px; color: var(--text-muted); margin-top: 4px; }
    .form-actions { display: flex; gap: 8px; margin-top: 22px; }

    input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--primary-600); cursor: pointer; vertical-align: middle; }

    input[type="file"].form-control { padding: 8px 12px; font-size: 12.5px; cursor: pointer; }
    input[type="file"].form-control::-webkit-file-upload-button {
        padding: 5px 14px; border: 1px solid var(--border); border-radius: 6px;
        background: var(--surface); color: var(--text-secondary); font-size: 12px;
        font-weight: 600; cursor: pointer; margin-right: 10px; transition: all .2s;
    }
    input[type="file"].form-control::-webkit-file-upload-button:hover {
        background: var(--primary-50); border-color: var(--primary-400); color: var(--primary-600);
    }

    /* Cover upload */
    .cover-drop {
        border: 2px dashed var(--border); border-radius: 10px; padding: 20px;
        text-align: center; background: #fafdf9; min-height: 160px;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
    }
    .cover-drop-label { font-size: 12px; color: var(--text-muted); margin-bottom: 10px; }
    .cover-preview { max-width: 180px; border-radius: 6px; margin-top: 10px; }

    /* Modal */
    .modal-overlay {
        display: none; position: fixed; inset: 0; z-index: 9000;
        background: rgba(0,0,0,.5); align-items: center; justify-content: center;
    }
    .modal-overlay.show { display: flex; }
    .modal-box {
        background: #fff; border-radius: var(--radius-lg); padding: 28px;
        max-width: 400px; width: 92%;
        box-shadow: 0 20px 60px rgba(0,0,0,.2); text-align: center;
    }
    .modal-box h3 { font-size: 16px; margin: 10px 0 6px; }
    .modal-box p { font-size: 13px; color: var(--text-muted); line-height: 1.5; margin-bottom: 20px; }
    .modal-btns { display: flex; gap: 8px; justify-content: center; }

    /* Crop modal */
    .crop-modal { display: none; position: fixed; inset: 0; z-index: 99999; background: rgba(0,0,0,.85); align-items: center; justify-content: center; }
    .crop-modal.open { display: flex; }
    .crop-box { background: #1e2e20; border-radius: 14px; padding: 22px; max-width: 90vw; width: 520px; display: flex; flex-direction: column; align-items: center; gap: 14px; }
    .crop-box h5 { color: #fff; margin: 0; font-size: 15px; }
    #cropImgEl { max-width: 100%; max-height: 50vh; display: block; }
    .crop-actions { display: flex; gap: 8px; }
    .crop-actions button { padding: 8px 20px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 12.5px; }
    .crop-ok { background: var(--primary-600); color: #fff; }
    .crop-cancel { background: #444; color: #ccc; }

    /* ═══ FOOTER ═══ */
    .dash-footer {
        padding: 20px 28px; text-align: center; color: var(--text-muted);
        font-size: 11.5px; border-top: 1px solid var(--border); margin-top: auto;
    }
    .dash-footer a { color: var(--primary-600); text-decoration: none; font-weight: 600; }

    /* Icon picker */
    .icon-item { display:flex; flex-direction:column; align-items:center; justify-content:center; padding:8px 4px; border-radius:8px; cursor:pointer; border:2px solid transparent; transition:all .18s; gap:4px; min-width:46px; }
    .icon-item:hover { background:#e8f5e9; border-color:#618D4F; }
    .icon-item.selected { background:#306238; border-color:#306238; }
    .icon-item.selected i, .icon-item.selected span { color:#fff !important; }
    .icon-item i { font-size:18px; color:#444; }
    .icon-item span { font-size:8.5px; color:#888; text-align:center; word-break:break-all; max-width:40px; }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- ═══ SIDEBAR ═══ -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-icon">
            <svg viewBox="0 0 24 24"><path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/></svg>
        </div>
        <div>
            <h2>MBKM IAI PI</h2>
            <span>Admin Panel</span>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="dashboard.php" class="nav-item <?php echo $page==='home'?'active':''; ?>">
            <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg> Dashboard
        </a>

        <?php if ($isAdmin): ?>
        <a href="dashboard.php?page=flipbook" class="nav-item <?php echo $page==='flipbook'?'active':''; ?>">
            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
            E-Book / Flipbook
            <?php if ($totalBooks > 0): ?><span class="nav-badge"><?php echo $totalBooks; ?></span><?php endif; ?>
        </a>

        <div class="nav-label">Kelola Beranda</div>
        <a href="dashboard.php?page=program" class="nav-item <?php echo $page==='program'?'active':''; ?>">
            <svg viewBox="0 0 24 24"><path d="M4 10h3v7H4zM10.5 10h3v7h-3zM2 19h20v3H2zM17 10h3v7h-3zM12 1L2 6v2h20V6z"/></svg> Program MBKM
        </a>
        <a href="dashboard.php?page=sambutan" class="nav-item <?php echo $page==='sambutan'?'active':''; ?>">
            <svg viewBox="0 0 24 24"><path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24-1.13-.56-1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg> Konfigurasi Website
        </a>
        <a href="dashboard.php?page=galeri" class="nav-item <?php echo $page==='galeri'?'active':''; ?>">
            <svg viewBox="0 0 24 24"><path d="M22 16V4c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2zm-11-4l2.03 2.71L16 11l4 5H8l3-4zM2 6v14c0 1.1.9 2 2 2h14v-2H4V6H2z"/></svg> Galeri Kegiatan
        </a>
        <a href="dashboard.php?page=testimoni" class="nav-item <?php echo $page==='testimoni'?'active':''; ?>">
            <svg viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm8 5H6v-2h8v2zm4-6H6V6h12v2z"/></svg> Testimoni
        </a>
        <a href="dashboard.php?page=berita" class="nav-item <?php echo $page==='berita'?'active':''; ?>">
            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg> Berita & Kegiatan
        </a>
        <?php endif; ?>

        <?php if ($isUser): ?>
        <div class="nav-label">Menu Mahasiswa</div>
        <a href="dashboard.php?page=upload_user" class="nav-item <?php echo $page==='upload_user'?'active':''; ?>">
            <svg viewBox="0 0 24 24"><path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/></svg> Upload Laporan
        </a>
        <?php endif; ?>

        <?php if ($isAdmin): ?>
        <div class="nav-label">Pengaturan</div>
        <a href="dashboard.php?page=pengguna" class="nav-item <?php echo $page==='pengguna'?'active':''; ?>">
            <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg> Kelola Akun
        </a>
        <a href="dashboard.php?page=upload_user" class="nav-item <?php echo $page==='upload_user'?'active':''; ?>">
            <svg viewBox="0 0 24 24"><path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/></svg> Upload dari User
        </a>
        <?php endif; ?>

        <div class="nav-label">Lainnya</div>
        <a href="index.php" target="_blank" class="nav-item">
            <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
            Lihat Website
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-avatar"><?php echo strtoupper(substr($userName,0,1)); ?></div>
            <div>
                <div class="sidebar-user-name"><?php echo $userName; ?></div>
                <div class="sidebar-user-role"><?php echo htmlspecialchars($_level); ?></div>
            </div>
            <a href="dashboard.php?aksi=logout" class="sidebar-logout" title="Keluar">
                <svg viewBox="0 0 24 24"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
            </a>
        </div>
    </div>
</aside>

<!-- ═══ MAIN ═══ -->
<div class="main-wrapper">
    <header class="topbar">
        <button class="topbar-toggle" onclick="toggleSidebar()">
            <svg viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
        </button>
        <div class="topbar-title"><?php echo $pageTitle[0]; ?> <span>/ <?php echo $pageTitle[1]; ?></span></div>
        <div class="topbar-right">
            <div class="topbar-clock">
                <svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
                <span id="clock">--:--</span>
            </div>
            <a href="index.php" target="_blank" class="topbar-visit">
                <svg viewBox="0 0 24 24"><path d="M19 19H5V5h7V3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/></svg>
                Kunjungi Situs
            </a>
        </div>
    </header>

    <main class="content">
<?php
// ══════════════════════════════════════════════════════════════
// PAGE: HOME
// ══════════════════════════════════════════════════════════════
if ($page === 'home'):
?>
        <div class="welcome-card">
            <div class="welcome-inner">
                <div class="welcome-text">
                    <h1>Selamat datang, <?php echo $userName; ?>!</h1>
                    <p>Kelola konten Sistem Informasi MBKM IAI PI Bandung dari dashboard ini.</p>
                </div>
                <div class="welcome-graphic">
                    <div class="welcome-clock-big" id="clockBig">--:--</div>
                    <div class="welcome-date-big" id="dateBig">-</div>
                </div>
            </div>
        </div>

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon"><svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg></div>
                <div class="stat-value"><?php echo $totalBooks; ?></div>
                <div class="stat-label">Total E-Book</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg></div>
                <div class="stat-value"><?php echo $totalUsers; ?></div>
                <div class="stat-label">Total Pengguna</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zM6 20V4h7v5h5v11H6z"/></svg></div>
                <div class="stat-value"><?php echo $totalPages; ?></div>
                <div class="stat-label">Total Artikel</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><svg viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg></div>
                <div class="stat-value"><?php echo number_format($totalVisits); ?></div>
                <div class="stat-label">Total Kunjungan</div>
            </div>
        </div>

        <div class="home-grid">
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <svg viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg> Akses Cepat
                    </div>
                </div>
                <div class="panel-body">
                    <?php if ($isAdmin): ?>
                    <a href="dashboard.php?page=flipbook" class="quick-action">
                        <div class="qa-icon green"><svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg></div>
                        <div><div class="qa-title">Kelola E-Book</div><div class="qa-desc">Upload dan atur buku flipbook PDF</div></div>
                        <div class="qa-arrow"><svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg></div>
                    </a>
                    <a href="dashboard.php?page=pengguna" class="quick-action">
                        <div class="qa-icon blue"><svg viewBox="0 0 24 24"><path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg></div>
                        <div><div class="qa-title">Kelola Akun Pengguna</div><div class="qa-desc">Tambah, edit, dan atur hak akses</div></div>
                        <div class="qa-arrow"><svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg></div>
                    </a>
                    <?php endif; ?>
                    
                    <a href="dashboard.php?page=upload_user" class="quick-action">
                        <div class="qa-icon teal"><svg viewBox="0 0 24 24"><path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/></svg></div>
                        <div><div class="qa-title">Upload Laporan</div><div class="qa-desc">Kirim dan pantau status laporan MBKM</div></div>
                        <div class="qa-arrow"><svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg></div>
                    </a>
                </div>
            </div>
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg> Informasi Sistem
                    </div>
                </div>
                <div class="panel-body">
                    <div class="info-item">
                        <span class="info-label"><svg viewBox="0 0 24 24"><path d="M20 18c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z"/></svg> Platform</span>
                        <span class="info-badge green">CMS Custom</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><svg viewBox="0 0 24 24"><path d="M9.4 16.6L4.8 12l4.6-4.6L8 6l-6 6 6 6z"/></svg> PHP Version</span>
                        <span class="info-value"><?php echo phpversion(); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20 10 10 0 000-20zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> Status DB</span>
                        <span class="info-badge <?php echo $db_ready ? 'green' : 'blue'; ?>"><?php echo $db_ready ? '● Online' : '● Offline'; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg> Sesi</span>
                        <span class="info-value"><?php echo date('H:i'); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg> Akun</span>
                        <span class="info-badge blue"><?php echo $userName; ?></span>
                    </div>
                </div>
            </div>
        </div>

<?php
// ══════════════════════════════════════════════════════════════
// PAGE: FLIPBOOK
// ══════════════════════════════════════════════════════════════
elseif ($page === 'flipbook' && $db_ready):
?>
        <div class="page-header">
            <div>
                <h2><svg viewBox="0 0 24 24" style="width:22px;height:22px;fill:var(--primary-600);vertical-align:middle;margin-right:4px"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg> Manajemen E-Book</h2>
                <p>Upload dan kelola buku panduan MBKM</p>
            </div>
            <div class="btn-group">
                <a href="dashboard.php?page=flipbook" class="btn btn-outline">
                    <svg viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg> Daftar
                </a>
                <a href="dashboard.php?page=flipbook&aksi=tambah" class="btn btn-primary">
                    <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg> Tambah Buku
                </a>
            </div>
        </div>

        <?php if ($fb_msg): ?><div class="msg-ok"><?php echo $fb_msg; ?></div><?php endif; ?>
        <?php if ($fb_error): ?><div class="msg-err"><?php echo $fb_error; ?></div><?php endif; ?>

<?php if ($fb_aksi === 'tambah'): ?>
        <!-- Crop Modal -->
        <div class="crop-modal" id="cropModal">
            <div class="crop-box">
                <h5>Potong Gambar Cover</h5>
                <img id="cropImgEl" src="" alt="crop">
                <div class="crop-actions">
                    <button class="crop-ok" onclick="applyCrop()">Pakai</button>
                    <button class="crop-cancel" onclick="cancelCrop()">Batal</button>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header"><div class="panel-title">Tambah Buku Baru</div></div>
            <div class="panel-body-padded">
                <form method="post" action="dashboard.php?page=flipbook&aksi=tambah" enctype="multipart/form-data">
                    <div class="form-grid">
                        <div>
                            <div class="form-group"><label>Judul Buku <span class="req">*</span></label><input type="text" name="judul" class="form-control" placeholder="Nama buku..." required></div>
                            <div class="form-group"><label>Kategori</label><input type="text" name="kategori" class="form-control" placeholder="Magang, Pertukaran, dll"></div>
                            <div class="form-group"><label>Deskripsi</label><textarea name="deskripsi" rows="3" class="form-control" placeholder="Deskripsi singkat..."></textarea></div>
                            <div class="form-group"><label>Upload PDF <span class="req">*</span></label><input type="file" name="file_pdf" accept=".pdf" class="form-control" required><div class="form-hint">Format: PDF</div></div>
                        </div>
                        <div>
                            <div class="form-group">
                                <label>Cover Buku <span style="font-weight:400;color:var(--text-muted)">(opsional)</span></label>
                                <div class="cover-drop" id="coverWrap">
                                    <div class="cover-drop-label">Pilih gambar untuk dipotong</div>
                                    <button type="button" class="btn btn-outline" onclick="document.getElementById('rawCoverInput').click()">Pilih Gambar</button>
                                    <input type="file" id="rawCoverInput" accept="image/*" style="display:none" onchange="initCrop(this)">
                                    <img id="coverPreviewImg" class="cover-preview" style="display:none" alt="cover preview">
                                </div>
                                <input type="hidden" name="cover_base64" id="coverBase64">
                                <div class="form-hint">Otomatis dipotong ke rasio 220:300</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="submit" class="btn btn-primary">Simpan Buku</button>
                        <a href="dashboard.php?page=flipbook" class="btn btn-outline">Batal</a>
                    </div>
                </form>
            </div>
        </div>

<?php elseif ($fb_aksi === 'edit' && isset($_GET['id'])):
    $id  = (int)$_GET['id'];
    $row = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM mod_data_flipbook WHERE id='$id'"));
    if ($row):
?>
        <div class="panel">
            <div class="panel-header"><div class="panel-title">Edit Buku</div></div>
            <div class="panel-body-padded">
                <form method="post" action="dashboard.php?page=flipbook&aksi=edit" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-grid">
                        <div class="form-group"><label>Judul</label><input type="text" name="judul" class="form-control" value="<?php echo htmlspecialchars($row['judul']); ?>" required></div>
                        <div class="form-group"><label>Kategori</label><input type="text" name="kategori" class="form-control" value="<?php echo htmlspecialchars($row['kategori']); ?>"></div>
                        <div class="form-group full"><label>Deskripsi</label><textarea name="deskripsi" rows="3" class="form-control"><?php echo htmlspecialchars($row['deskripsi']); ?></textarea></div>
                        <div class="form-group">
                            <label>Ganti PDF <span style="font-weight:400;color:var(--text-muted)">(opsional)</span></label>
                            <input type="file" name="file_pdf" accept=".pdf" class="form-control">
                            <div class="form-hint">Saat ini: <?php echo htmlspecialchars($row['file_pdf']); ?></div>
                        </div>
                        <div class="form-group">
                            <label>Ganti Cover <span style="font-weight:400;color:var(--text-muted)">(opsional)</span></label>
                            <?php if (!empty($row['cover'])): ?>
                            <img src="/images/flipbook/<?php echo htmlspecialchars($row['cover']); ?>" style="height:70px;border-radius:6px;margin-bottom:8px;display:block;" alt="cover">
                            <?php endif; ?>
                            <input type="file" name="cover" accept=".jpg,.jpeg,.png,.webp" class="form-control">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                        <a href="dashboard.php?page=flipbook" class="btn btn-outline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
<?php else: ?><div class="msg-err">Data tidak ditemukan.</div><?php endif; ?>

<?php else:
    // LIST FLIPBOOK
    $rows       = array();
    $search_fb  = '';
    if (isset($_GET['q'])) $search_fb = htmlspecialchars(strip_tags(trim($_GET['q'])));
    $where_fb   = '';
    if ($search_fb !== '') {
        $where_fb = " WHERE judul LIKE '%$search_fb%' OR deskripsi LIKE '%$search_fb%' OR kategori LIKE '%$search_fb%'";
    }
    $q = $koneksi_db->sql_query("SELECT * FROM mod_data_flipbook $where_fb ORDER BY ordering ASC, id DESC");
    while ($r = $koneksi_db->sql_fetchrow($q)) $rows[] = $r;
?>
        <div class="panel">
            <div class="panel-header" style="justify-content:space-between;flex-wrap:wrap;gap:10px;">
                <div class="panel-title">Daftar Buku (<?php echo count($rows); ?>)</div>
                <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                    <form method="get" action="dashboard.php" style="display:flex;gap:4px;margin:0;">
                        <input type="hidden" name="page" value="flipbook">
                        <input type="text" name="q" value="<?php echo htmlspecialchars($search_fb); ?>" placeholder="Cari buku..." class="form-control" style="padding:6px 12px;width:200px;">
                        <button type="submit" class="btn btn-primary" style="padding:6px 12px;">Cari</button>
                        <?php if ($search_fb): ?><a href="dashboard.php?page=flipbook" class="btn btn-outline" style="padding:6px 10px;">X</a><?php endif; ?>
                    </form>
                    <button type="submit" name="bulk_delete_fb" form="fbBulkForm" class="btn btn-outline" style="color:#c62828;border-color:#ffcdd2;"
                        onclick="return confirm('Hapus semua buku yang dipilih?')">Hapus Terpilih</button>
                </div>
            </div>
            <?php if (empty($rows)): ?>
            <div class="empty-state"><span>&#128218;</span>Belum ada buku. Klik <b>+ Tambah Buku</b> untuk memulai.</div>
            <?php else: ?>
            <form method="POST" action="dashboard.php?page=flipbook" id="fbBulkForm">
            <div style="overflow-x:auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:36px"><input type="checkbox" onclick="toggleAllFb(this)"></th>
                        <th>No</th><th>Cover</th><th>Judul</th><th>Kategori</th>
                        <th>PDF</th><th>Tanggal</th><th>Status</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($rows as $i => $r):
                    $thumb = !empty($r['cover'])
                        ? '<img src="/images/flipbook/'.htmlspecialchars($r['cover']).'" style="width:100px;height:141px;object-fit:cover;border-radius:2px;box-shadow:0 4px 10px rgba(0,0,0,.15);border:1px solid #eee;" alt="cover">'
                        : '<div style="width:100px;height:141px;background:#f0f0f0;border-radius:2px;display:flex;align-items:center;justify-content:center;border:1px solid #eee;color:#ccc;font-size:11px;">No Cover</div>';
                    $stat = $r['status'] == 1
                        ? '<span class="badge badge-aktif">Aktif</span>'
                        : '<span class="badge badge-nonaktif">Non</span>';
                ?>
                <tr>
                    <td><input type="checkbox" name="fb_delete[]" value="<?php echo $r['id']; ?>"></td>
                    <td><?php echo $i+1; ?></td>
                    <td><?php echo $thumb; ?></td>
                    <td><b><?php echo htmlspecialchars($r['judul']); ?></b></td>
                    <td><small><?php echo htmlspecialchars($r['kategori']) ? htmlspecialchars($r['kategori']) : '-'; ?></small></td>
                    <td><a href="/<?php echo htmlspecialchars($r['file_pdf']); ?>" target="_blank" class="action-btn action-toggle">Preview</a></td>
                    <td style="font-size:12px"><?php echo date('d M Y', strtotime($r['tanggal'])); ?></td>
                    <td><?php echo $stat; ?></td>
                    <td>
                        <a href="dashboard.php?page=flipbook&aksi=edit&id=<?php echo $r['id']; ?>" class="action-btn action-edit">Edit</a>
                        <a href="dashboard.php?page=flipbook&aksi=toggle&id=<?php echo $r['id']; ?>" class="action-btn action-toggle"><?php echo $r['status']==1 ? 'Non' : 'Aktif'; ?></a>
                        <button type="button" onclick="showDeleteModal(<?php echo $r['id']; ?>,'<?php echo addslashes(htmlspecialchars($r['judul'])); ?>')" class="action-btn action-del">Hapus</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
            </form>
            <?php endif; ?>
        </div>
<?php endif; ?>

<?php
// ══════════════════════════════════════════════════════════════
// PAGE: PENGGUNA (Admin only)
// ══════════════════════════════════════════════════════════════
elseif ($page === 'pengguna' && $db_ready && $isAdmin):
?>
        <div class="page-header">
            <div>
                <h2>Kelola Akun Pengguna</h2>
                <p>Tambah, edit, dan atur hak akses pengguna</p>
            </div>
            <div class="btn-group">
                <a href="dashboard.php?page=pengguna" class="btn btn-outline">Daftar</a>
                <a href="dashboard.php?page=pengguna&action=add" class="btn btn-primary">
                    <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg> Tambah Akun
                </a>
            </div>
        </div>

        <?php if ($peng_msg): ?><div class="msg-ok"><?php echo $peng_msg; ?></div><?php endif; ?>
        <?php if ($peng_error): ?><div class="msg-err"><?php echo $peng_error; ?></div><?php endif; ?>

<?php if ($peng_action === 'add'): ?>
        <div class="panel">
            <div class="panel-header"><div class="panel-title">Tambah Akun Baru</div></div>
            <div class="panel-body-padded">
                <form method="post" action="dashboard.php?page=pengguna&action=add">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama asli pengguna">
                        </div>
                        <div class="form-group">
                            <label>Username <span class="req">*</span></label>
                            <input type="text" name="uname" class="form-control" required placeholder="Contoh: mahasiswa01">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@example.com">
                        </div>
                        <div class="form-group">
                            <label>Level / Hak Akses <span class="req">*</span></label>
                            <select name="level" class="form-control">
                                <option value="User">User — Hanya bisa upload konten</option>
                                <option value="Editor">Editor</option>
                                <option value="Administrator">Administrator — Akses penuh</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Password <span class="req">*</span></label>
                            <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="submit" class="btn btn-primary">Tambah Akun</button>
                        <a href="dashboard.php?page=pengguna" class="btn btn-outline">Batal</a>
                    </div>
                </form>
            </div>
        </div>

<?php elseif ($peng_action === 'edit' && !empty($_GET['id'])):
    $id      = (int)$_GET['id'];
    $er      = $koneksi_db->sql_query("SELECT * FROM `pengguna` WHERE UserId='$id'");
    $ed      = array('UserId'=>0,'user'=>'','email'=>'','level'=>'User','tipe'=>'aktif','nama'=>'');
    if ($er) { $fet = $koneksi_db->sql_fetchrow($er); if ($fet) $ed = array_merge($ed, (array)$fet); }
?>
        <div class="panel">
            <div class="panel-header"><div class="panel-title">Edit Akun: <?php echo htmlspecialchars($ed['user']); ?></div></div>
            <div class="panel-body-padded">
                <form method="post" action="dashboard.php?page=pengguna&action=edit&id=<?php echo $id; ?>">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($ed['nama']); ?>">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($ed['email']); ?>">
                        </div>
                        <div class="form-group">
                            <label>Level</label>
                            <select name="level" class="form-control">
                                <option value="User" <?php echo $ed['level']==='User'?'selected':''; ?>>User</option>
                                <option value="Editor" <?php echo $ed['level']==='Editor'?'selected':''; ?>>Editor</option>
                                <option value="Administrator" <?php echo $ed['level']==='Administrator'?'selected':''; ?>>Administrator</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                        <a href="dashboard.php?page=pengguna" class="btn btn-outline">Batal</a>
                    </div>
                </form>
            </div>
        </div>

<?php elseif ($peng_action === 'reset' && !empty($_GET['id'])):
    $id   = (int)$_GET['id'];
    $ru_q = $koneksi_db->sql_query("SELECT user FROM `pengguna` WHERE UserId='$id'");
    $ru   = $koneksi_db->sql_fetchrow($ru_q);
?>
        <div class="panel">
            <div class="panel-header"><div class="panel-title">Reset Password: <?php echo htmlspecialchars(isset($ru['user']) ? $ru['user'] : ''); ?></div></div>
            <div class="panel-body-padded">
                <form method="post" action="dashboard.php?page=pengguna&action=reset&id=<?php echo $id; ?>">
                    <div class="form-group" style="max-width:400px">
                        <label>Password Baru <span class="req">*</span></label>
                        <input type="text" name="new_password" class="form-control" required placeholder="Masukkan password baru...">
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="submit_reset" class="btn btn-primary">Reset Password</button>
                        <a href="dashboard.php?page=pengguna" class="btn btn-outline">Batal</a>
                    </div>
                </form>
            </div>
        </div>

<?php else:
    // LIST PENGGUNA
    $users       = array();
    $search_user = '';
    if (isset($_GET['q'])) $search_user = htmlspecialchars(strip_tags(trim($_GET['q'])));
    $where_user  = '';
    if ($search_user !== '') {
        $where_user = " WHERE email LIKE '%$search_user%' OR nama LIKE '%$search_user%' OR user LIKE '%$search_user%'";
    }
    $q = $koneksi_db->sql_query("SELECT * FROM `pengguna` $where_user ORDER BY level ASC, UserId ASC");
    while ($d = $koneksi_db->sql_fetchrow($q)) $users[] = $d;
?>
        <div class="panel">
            <div class="panel-header" style="justify-content:space-between;flex-wrap:wrap;gap:10px;">
                <div class="panel-title">Daftar Pengguna (<?php echo count($users); ?>)</div>
                <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                    <form method="get" action="dashboard.php" style="display:flex;gap:4px;margin:0;">
                        <input type="hidden" name="page" value="pengguna">
                        <input type="text" name="q" value="<?php echo htmlspecialchars($search_user); ?>" placeholder="Cari pengguna..." class="form-control" style="padding:6px 12px;width:200px;">
                        <button type="submit" class="btn btn-primary" style="padding:6px 12px;">Cari</button>
                        <?php if ($search_user): ?><a href="dashboard.php?page=pengguna" class="btn btn-outline" style="padding:6px 10px;">X</a><?php endif; ?>
                    </form>
                    <button type="submit" name="deleted" form="pengBulkForm" class="btn btn-outline" style="color:#c62828;border-color:#ffcdd2;"
                        onclick="return confirm('Hapus akun yang dipilih?')">Hapus Terpilih</button>
                </div>
            </div>
            <?php if (empty($users)): ?>
            <div class="empty-state"><span>&#128100;</span>Belum ada data pengguna.</div>
            <?php else: ?>
            <form method="POST" action="dashboard.php?page=pengguna" id="pengBulkForm">
            <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th><th>Username / Nama</th><th>Email</th><th>Level</th><th>Status</th><th>Aksi</th>
                        <th><input type="checkbox" onclick="toggleAll(this)"></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $i => $u):
                    $aktif = isset($u['tipe']) ? $u['tipe'] : 'aktif';
                    $namal = isset($u['nama']) ? $u['nama'] : '';
                ?>
                <tr>
                    <td><?php echo $i+1; ?></td>
                    <td>
                        <b><?php echo htmlspecialchars($u['user']); ?></b><br>
                        <small style="color:var(--text-muted)"><?php echo htmlspecialchars($namal); ?></small>
                    </td>
                    <td><small><?php echo htmlspecialchars($u['email']); ?></small></td>
                    <td>
                        <?php if ($u['level']==='Administrator'): ?>
                        <span class="badge" style="background:#e8f5e9;color:#2e7d32;">Admin</span>
                        <?php elseif ($u['level']==='Editor'): ?>
                        <span class="badge" style="background:#fff9c4;color:#f57f17;">Editor</span>
                        <?php else: ?>
                        <span class="badge badge-level">User</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($aktif === 'aktif'): ?>
                        <span class="badge badge-aktif">Aktif</span>
                        <?php else: ?>
                        <span class="badge badge-nonaktif">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="dashboard.php?page=pengguna&action=edit&id=<?php echo (int)$u['UserId']; ?>" class="action-btn action-edit">Edit</a>
                        <a href="dashboard.php?page=pengguna&action=reset&id=<?php echo (int)$u['UserId']; ?>" class="action-btn action-reset">Reset</a>
                        <?php if ($aktif === 'aktif'): ?>
                        <a href="dashboard.php?page=pengguna&action=toggle&st=nonaktif&id=<?php echo (int)$u['UserId']; ?>" class="action-btn action-del">Non</a>
                        <?php else: ?>
                        <a href="dashboard.php?page=pengguna&action=toggle&st=aktif&id=<?php echo (int)$u['UserId']; ?>" class="action-btn action-toggle">Aktif</a>
                        <?php endif; ?>
                    </td>
                    <td><input type="checkbox" name="delete[]" value="<?php echo (int)$u['UserId']; ?>"></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
            </form>
            <?php endif; ?>
        </div>
<?php endif; ?>

<?php
// ══════════════════════════════════════════════════════════════
// PAGE: GALERI
// ══════════════════════════════════════════════════════════════
elseif ($page === 'galeri' && $db_ready):
?>
    <div class="page-header">
        <div>
            <h2>Galeri Kegiatan</h2>
            <p>Kelola foto dokumentasi kegiatan MBKM.</p>
        </div>
        <?php if ($galeri_action === ''): ?>
        <a href="dashboard.php?page=galeri&action=add" class="add-btn">
            <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg> Tambah Foto
        </a>
        <?php else: ?>
        <a href="dashboard.php?page=galeri" class="btn btn-outline">Kembali</a>
        <?php endif; ?>
    </div>
    <?php if ($galeri_msg): ?><div class="msg-ok"><?php echo $galeri_msg; ?></div><?php endif; ?>
    <?php if ($galeri_error): ?><div class="msg-err"><?php echo $galeri_error; ?></div><?php endif; ?>

    <?php if ($galeri_action === 'add' || $galeri_action === 'edit'):
        $ed = array('nama'=>'','foto'=>'','ket'=>'');
        if ($galeri_action === 'edit') {
            $id  = (int)$_GET['id'];
            $res = $koneksi_db->sql_query("SELECT * FROM `mod_data_foto` WHERE id='$id'");
            $ed  = $koneksi_db->sql_fetchrow($res);
        }
    ?>
    <div class="panel">
        <div class="panel-body-padded">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group"><label>Nama / Judul Foto</label><input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($ed['nama']); ?>" required></div>
            <div class="form-group"><label>Keterangan</label><textarea name="ket" class="form-control" rows="4"><?php echo htmlspecialchars($ed['ket']); ?></textarea></div>
            <div class="form-group">
                <label>Upload Foto (JPG/PNG/WebP)</label>
                <input type="file" name="image" accept="image/*" class="form-control">
                <?php if ($galeri_action === 'edit' && !empty($ed['foto'])): ?>
                <div style="margin-top:10px"><img src="images/foto/<?php echo $ed['foto']; ?>" style="max-width:160px;border-radius:8px;" alt="foto"></div>
                <?php endif; ?>
            </div>
            <div class="form-actions">
                <button type="submit" name="submit" class="btn btn-primary">Simpan Foto</button>
                <a href="dashboard.php?page=galeri" class="btn btn-outline">Batal</a>
            </div>
        </form>
        </div>
    </div>
    <?php else: ?>
    <div class="panel">
        <form method="POST" action="">
        <div class="panel-header" style="justify-content:flex-end">
            <button type="submit" name="deleted" class="action-delete" onclick="return confirm('Hapus foto yang dipilih?')">Hapus Terpilih</button>
        </div>
        <div class="table-responsive">
        <table class="data-table">
            <thead><tr>
                <th>No</th><th>Foto</th><th>Judul</th><th>Keterangan</th><th>Aksi</th>
                <th><input type="checkbox" onclick="toggleAll(this)"></th>
            </tr></thead>
            <tbody>
            <?php
            $res = $koneksi_db->sql_query("SELECT * FROM `mod_data_foto` ORDER BY id DESC");
            $i   = 0;
            if ($res) while ($r = $koneksi_db->sql_fetchrow($res)):
                $i++;
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><img src="images/foto/<?php echo htmlspecialchars($r['foto']); ?>" style="width:60px;height:60px;object-fit:cover;border-radius:6px;" alt="foto"></td>
                    <td><b><?php echo htmlspecialchars($r['nama']); ?></b></td>
                    <td><small><?php echo mb_substr(strip_tags($r['ket']),0,80); ?>...</small></td>
                    <td><a href="dashboard.php?page=galeri&action=edit&id=<?php echo $r['id']; ?>" class="action-btn action-edit">Edit</a></td>
                    <td><input type="checkbox" name="delete[]" value="<?php echo $r['id']; ?>"></td>
                </tr>
            <?php endwhile; ?>
            <?php if ($i === 0): ?><tr><td colspan="6" class="text-center" style="padding:30px;color:#aaa;">Belum ada data galeri.</td></tr><?php endif; ?>
            </tbody>
        </table>
        </div>
        </form>
    </div>
    <?php endif; ?>

<?php
// ══════════════════════════════════════════════════════════════
// PAGE: TESTIMONI
// ══════════════════════════════════════════════════════════════
elseif ($page === 'testimoni' && $db_ready):
?>
    <div class="page-header">
        <div>
            <h2>Kelola Testimoni</h2>
            <p>Atur testimoni mahasiswa yang tampil di beranda.</p>
        </div>
        <?php if ($testi_action === ''): ?>
        <a href="dashboard.php?page=testimoni&action=add" class="add-btn">
            <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg> Tambah Testimoni
        </a>
        <?php else: ?>
        <a href="dashboard.php?page=testimoni" class="btn btn-outline">Kembali</a>
        <?php endif; ?>
    </div>
    <?php if ($testi_msg): ?><div class="msg-ok"><?php echo $testi_msg; ?></div><?php endif; ?>
    <?php if ($testi_error): ?><div class="msg-err"><?php echo $testi_error; ?></div><?php endif; ?>

    <?php if ($testi_action === 'add' || $testi_action === 'edit'):
        $ed = array('nama'=>'','email'=>'','ket'=>'','foto'=>'');
        if ($testi_action === 'edit') {
            $id  = (int)$_GET['id'];
            $res = $koneksi_db->sql_query("SELECT * FROM `mod_data_testi` WHERE id='$id'");
            $ed  = $koneksi_db->sql_fetchrow($res);
        }
    ?>
    <div class="panel">
        <div class="panel-body-padded">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="form-group"><label>Nama</label><input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($ed['nama']); ?>" required></div>
                <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($ed['email']); ?>"></div>
            </div>
            <div class="form-group"><label>Isi Testimoni</label><textarea name="ket" class="form-control" rows="5"><?php echo htmlspecialchars($ed['ket']); ?></textarea></div>
            <div class="form-group">
                <label>Foto Profil (JPG/PNG)</label>
                <input type="file" name="image" accept="image/*" class="form-control">
                <?php if ($testi_action === 'edit' && !empty($ed['foto']) && $ed['foto'] !== 'na.jpg'): ?>
                <div style="margin-top:10px"><img src="images/testi/<?php echo $ed['foto']; ?>" style="width:60px;height:60px;object-fit:cover;border-radius:50%;" alt="foto"></div>
                <?php endif; ?>
            </div>
            <div class="form-actions">
                <button type="submit" name="submit" class="btn btn-primary">Simpan Testimoni</button>
                <a href="dashboard.php?page=testimoni" class="btn btn-outline">Batal</a>
            </div>
        </form>
        </div>
    </div>
    <?php else: ?>
    <div class="panel">
        <form method="POST" action="">
        <div class="panel-header" style="justify-content:flex-end">
            <button type="submit" name="deleted" class="action-delete" onclick="return confirm('Hapus testimoni yang dipilih?')">Hapus Terpilih</button>
        </div>
        <div class="table-responsive">
        <table class="data-table">
            <thead><tr>
                <th>No</th><th>Foto</th><th>Nama</th><th>Testimoni</th><th>Status</th><th>Aksi</th>
                <th><input type="checkbox" onclick="toggleAll(this)"></th>
            </tr></thead>
            <tbody>
            <?php
            $res = $koneksi_db->sql_query("SELECT * FROM `mod_data_testi` ORDER BY id DESC");
            $i   = 0;
            if ($res) while ($r = $koneksi_db->sql_fetchrow($res)):
                $i++;
                $pub_badge = $r['status'] == '1'
                    ? '<a href="dashboard.php?page=testimoni&action=pub&id='.$r['id'].'&pub=0" class="badge" style="background:#c8e6c9;color:#2e7d32;cursor:pointer">Aktif</a>'
                    : '<a href="dashboard.php?page=testimoni&action=pub&id='.$r['id'].'&pub=1" class="badge" style="background:#ffcdd2;color:#c62828;cursor:pointer">Nonaktif</a>';
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><img src="images/testi/<?php echo htmlspecialchars($r['foto']); ?>" style="width:40px;height:40px;object-fit:cover;border-radius:50%;" alt="foto"></td>
                    <td><b><?php echo htmlspecialchars($r['nama']); ?></b><br><small><?php echo htmlspecialchars($r['email']); ?></small></td>
                    <td><small><i><?php echo mb_substr(strip_tags($r['ket']),0,80); ?>...</i></small></td>
                    <td><?php echo $pub_badge; ?></td>
                    <td><a href="dashboard.php?page=testimoni&action=edit&id=<?php echo $r['id']; ?>" class="action-btn action-edit">Edit</a></td>
                    <td><input type="checkbox" name="delete[]" value="<?php echo $r['id']; ?>"></td>
                </tr>
            <?php endwhile; ?>
            <?php if ($i === 0): ?><tr><td colspan="7" class="text-center" style="padding:30px;color:#aaa;">Belum ada data testimoni.</td></tr><?php endif; ?>
            </tbody>
        </table>
        </div>
        </form>
    </div>
    <?php endif; ?>

<?php
// ══════════════════════════════════════════════════════════════
// PAGE: BERITA & KEGIATAN
// ══════════════════════════════════════════════════════════════
elseif ($page === 'berita' && $db_ready):
?>
    <div class="page-header">
        <div>
            <h2>Berita &amp; Kegiatan</h2>
            <p>Tulis dan kelola artikel berita kegiatan MBKM.</p>
        </div>
        <?php if ($berita_action === ''): ?>
        <a href="dashboard.php?page=berita&action=add" class="add-btn">
            <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg> Tulis Artikel
        </a>
        <?php else: ?>
        <a href="dashboard.php?page=berita" class="btn btn-outline">Kembali</a>
        <?php endif; ?>
    </div>
    <?php if ($berita_msg): ?><div class="msg-ok"><?php echo $berita_msg; ?></div><?php endif; ?>
    <?php if ($berita_error): ?><div class="msg-err"><?php echo $berita_error; ?></div><?php endif; ?>

    <?php if ($berita_action === 'add' || $berita_action === 'edit'):
        $ed = array('judul'=>'','gambar'=>'','konten'=>'','tags'=>'');
        if ($berita_action === 'edit') {
            $id  = (int)$_GET['id'];
            $res = $koneksi_db->sql_query("SELECT * FROM `artikel` WHERE id='$id'");
            $ed  = $koneksi_db->sql_fetchrow($res);
        }
    ?>
    <div class="panel">
        <div class="panel-body-padded">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group"><label>Judul Artikel</label><input type="text" name="judul" class="form-control" value="<?php echo htmlspecialchars($ed['judul']); ?>" required></div>
            <div class="form-group"><label>Konten Artikel</label><textarea name="konten" id="kontenBerita" class="form-control" rows="10"><?php echo htmlspecialchars($ed['konten']); ?></textarea></div>
            <div class="form-grid">
                <div class="form-group"><label>Tags / Kategori</label><input type="text" name="tags" class="form-control" value="<?php echo htmlspecialchars($ed['tags']); ?>" placeholder="MBKM, Pendidikan, dst"></div>
                <div class="form-group">
                    <label>Gambar Cover</label>
                    <input type="file" name="gambar" accept="image/*" class="form-control">
                    <?php if ($berita_action === 'edit' && !empty($ed['gambar'])): ?>
                    <div style="margin-top:10px"><img src="images/artikel/<?php echo $ed['gambar']; ?>" style="max-width:140px;border-radius:8px;" alt="cover"></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" name="submit" class="btn btn-primary">Publikasikan Artikel</button>
                <a href="dashboard.php?page=berita" class="btn btn-outline">Batal</a>
            </div>
        </form>
        </div>
    </div>
    <script src="plugin/ckeditor/ckeditor.js"></script>
    <script>if (typeof CKEDITOR !== 'undefined') { CKEDITOR.replace('kontenBerita', { height: 350 }); }</script>
    <?php else: ?>
    <div class="panel">
        <form method="POST" action="">
        <div class="panel-header" style="justify-content:flex-end">
            <button type="submit" name="deleted" class="action-delete" onclick="return confirm('Hapus artikel yang dipilih?')">Hapus Terpilih</button>
        </div>
        <div class="table-responsive">
        <table class="data-table">
            <thead><tr>
                <th>No</th><th>Cover</th><th>Judul</th><th>Penulis</th><th>Tanggal</th><th>Status</th><th>Aksi</th>
                <th><input type="checkbox" onclick="toggleAll(this)"></th>
            </tr></thead>
            <tbody>
            <?php
            $search_berita = isset($_GET['q']) ? htmlspecialchars(strip_tags(trim($_GET['q']))) : '';
            $where_berita  = $search_berita ? "WHERE `judul` LIKE '%$search_berita%'" : '';
            $res = $koneksi_db->sql_query("SELECT * FROM `artikel` $where_berita ORDER BY id DESC LIMIT 50");
            $i   = 0;
            if ($res) while ($r = $koneksi_db->sql_fetchrow($res)):
                $i++;
                $cover     = $r['gambar'] ? '<img src="images/artikel/'.htmlspecialchars($r['gambar']).'" style="width:50px;height:35px;object-fit:cover;border-radius:4px;" alt="cover">' : '&mdash;';
                $pub_badge = $r['publikasi'] == '1'
                    ? '<a href="dashboard.php?page=berita&action=pub&id='.$r['id'].'&pub=0" class="badge" style="background:#c8e6c9;color:#2e7d32;cursor:pointer">Publik</a>'
                    : '<a href="dashboard.php?page=berita&action=pub&id='.$r['id'].'&pub=1" class="badge" style="background:#fff9c4;color:#f57f17;cursor:pointer">Draft</a>';
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $cover; ?></td>
                    <td>
                        <b><?php echo htmlspecialchars(mb_substr($r['judul'],0,60)); ?></b>
                        <?php if ($r['tags']): ?><br><small style="color:var(--text-muted)"><?php echo htmlspecialchars($r['tags']); ?></small><?php endif; ?>
                    </td>
                    <td><small><?php echo htmlspecialchars($r['user']); ?></small></td>
                    <td><small><?php echo date('d M Y', strtotime($r['tgl'])); ?></small></td>
                    <td><?php echo $pub_badge; ?></td>
                    <td><a href="dashboard.php?page=berita&action=edit&id=<?php echo $r['id']; ?>" class="action-btn action-edit">Edit</a></td>
                    <td><input type="checkbox" name="delete[]" value="<?php echo $r['id']; ?>"></td>
                </tr>
            <?php endwhile; ?>
            <?php if ($i === 0): ?><tr><td colspan="8" class="text-center" style="padding:30px;color:#aaa;">Belum ada artikel.</td></tr><?php endif; ?>
            </tbody>
        </table>
        </div>
        </form>
    </div>
    <?php endif; ?>

<?php
// ══════════════════════════════════════════════════════════════
// PAGE: UPLOAD USER
// ══════════════════════════════════════════════════════════════
elseif ($page === 'upload_user' && $db_ready):
?>
    <div class="page-header">
        <div>
            <h2><?php echo $isUser ? 'Upload Konten Saya' : 'Semua Upload dari User'; ?></h2>
            <p><?php echo $isUser ? 'Upload laporan atau dokumen Anda di sini.' : 'Review dan kelola konten yang diupload oleh user.'; ?></p>
        </div>
        <?php if ($isUser): ?>
        <a href="dashboard.php?page=upload_user&action=add" class="add-btn">
            <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg> Upload Baru
        </a>
        <?php endif; ?>
    </div>
    <?php if ($upload_msg): ?><div class="msg-ok"><?php echo $upload_msg; ?></div><?php endif; ?>
    <?php if ($upload_error): ?><div class="msg-err"><?php echo $upload_error; ?></div><?php endif; ?>

    <?php if ($isUser && $up_action === 'add'): ?>
    <div class="panel">
        <div class="panel-body-padded">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group"><label>Judul Konten / Dokumen</label><input type="text" name="judul" class="form-control" required placeholder="Judul file yang diupload"></div>
            <div class="form-group">
                <label>Jenis Dokumen</label>
                <select name="jenis" class="form-control">
                    <option>Laporan Kegiatan</option>
                    <option>Laporan Akhir</option>
                    <option>Sertifikat</option>
                    <option>Dokumentasi Foto</option>
                    <option>Lainnya</option>
                </select>
            </div>
            <div class="form-group"><label>Keterangan (Opsional)</label><textarea name="keterangan" class="form-control" rows="4" placeholder="Tambahkan catatan jika perlu"></textarea></div>
            <div class="form-group"><label>File (PDF, DOC, JPG, PNG, ZIP)</label><input type="file" name="file_upload" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip"></div>
            <div class="form-actions">
                <button type="submit" name="submit_upload" class="btn btn-primary">Kirim Upload</button>
                <a href="dashboard.php?page=upload_user" class="btn btn-outline">Batal</a>
            </div>
        </form>
        </div>
    </div>
    <?php else: ?>
    <div class="panel">
        <?php if ($isAdmin): ?><form method="POST" action=""><?php endif; ?>
        <?php if ($isAdmin): ?>
        <div class="panel-header" style="justify-content:flex-end">
            <button type="submit" name="deleted" class="action-delete" onclick="return confirm('Hapus upload terpilih?')">Hapus Terpilih</button>
        </div>
        <?php endif; ?>
        <div class="table-responsive">
        <table class="data-table">
            <thead><tr>
                <th>No</th><th>Judul</th><th>Jenis</th><th>Pengirim</th><th>File</th><th>Status</th><th>Tanggal</th>
                <?php if ($isAdmin): ?><th>Aksi Admin</th><th><input type="checkbox" onclick="toggleAll(this)"></th><?php endif; ?>
            </tr></thead>
            <tbody>
            <?php
            $where_up = $isUser ? "WHERE user='$userName'" : '';
            $res      = @$koneksi_db->sql_query("SELECT * FROM `user_uploads` $where_up ORDER BY id DESC");
            $i        = 0;
            if ($res) while ($r = $koneksi_db->sql_fetchrow($res)):
                $i++;
                $st_key    = isset($r['status']) ? $r['status'] : 'pending';
                $st_colors = array('pending'=>array('#fff9c4','#f57f17'),'disetujui'=>array('#e8f5e9','#2e7d32'),'ditolak'=>array('#ffebee','#c62828'));
                $st_col    = isset($st_colors[$st_key]) ? $st_colors[$st_key] : $st_colors['pending'];
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><b><?php echo htmlspecialchars($r['judul']); ?></b></td>
                    <td><small><?php echo htmlspecialchars($r['jenis']); ?></small></td>
                    <td><small><?php echo htmlspecialchars($r['user']); ?></small></td>
                    <td>
                        <?php if ($r['file_path']): ?>
                        <a href="files/uploads/<?php echo htmlspecialchars($r['file_path']); ?>" target="_blank" class="action-btn action-toggle">Unduh</a>
                        <?php else: ?><span style="color:#aaa">Tidak ada file</span><?php endif; ?>
                    </td>
                    <td><span class="badge" style="background:<?php echo $st_col[0]; ?>;color:<?php echo $st_col[1]; ?>;"><?php echo ucfirst($st_key); ?></span></td>
                    <td><small><?php echo date('d M Y', strtotime($r['tgl_upload'])); ?></small></td>
                    <?php if ($isAdmin): ?>
                    <td>
                        <a href="dashboard.php?page=upload_user&action=setstatus&st=disetujui&id=<?php echo $r['id']; ?>" class="action-btn action-toggle">Setuju</a>
                        <a href="dashboard.php?page=upload_user&action=setstatus&st=ditolak&id=<?php echo $r['id']; ?>" class="action-btn action-del">Tolak</a>
                    </td>
                    <td><input type="checkbox" name="delete[]" value="<?php echo $r['id']; ?>"></td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
            <?php if ($i === 0): ?><tr><td colspan="9" class="text-center" style="padding:30px;color:#aaa;">Belum ada upload.</td></tr><?php endif; ?>
            </tbody>
        </table>
        </div>
        <?php if ($isAdmin): ?></form><?php endif; ?>
    </div>
    <?php endif; ?>

<?php
// ══════════════════════════════════════════════════════════════
// PAGE: PROGRAM MBKM
// ══════════════════════════════════════════════════════════════
elseif ($page === 'program' && $db_ready):
?>
    <div class="page-header">
        <div>
            <h2>Kelola Program MBKM</h2>
            <p>Atur indikator atau daftar program yang tampil di beranda.</p>
        </div>
        <?php if ($prog_action === ''): ?>
        <a href="dashboard.php?page=program&action=add" class="add-btn">
            <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg> Tambah Program
        </a>
        <?php else: ?>
        <a href="dashboard.php?page=program" class="btn btn-outline">Kembali</a>
        <?php endif; ?>
    </div>
    <?php if ($prog_msg): ?><div class="msg-ok"><?php echo $prog_msg; ?></div><?php endif; ?>
    <?php if ($prog_error): ?><div class="msg-err"><?php echo $prog_error; ?></div><?php endif; ?>

    <?php if ($prog_action === 'add' || $prog_action === 'edit'):
        $edit_data = array('judul'=>'','icon'=>'fa-star','konten'=>'','aktif'=>'Y');
        if ($prog_action === 'edit') {
            $id  = (int)$_GET['id'];
            $res = $koneksi_db->sql_query("SELECT * FROM `halaman` WHERE id='$id'");
            if ($h_data = $koneksi_db->sql_fetchrow($res)) {
                $edit_data['judul']  = $h_data['judul'];
                $edit_data['konten'] = $h_data['konten'];
                $edit_data['icon']   = isset($h_data['icon'])  ? $h_data['icon']  : 'fa-star';
                $edit_data['aktif']  = isset($h_data['aktif']) ? $h_data['aktif'] : 'Y';
            }
        }
    ?>
    <div class="panel">
        <div class="panel-body-padded">
        <form method="POST" action="">
            <div class="form-group"><label>Judul Program</label><input type="text" name="judul" class="form-control" value="<?php echo htmlspecialchars($edit_data['judul']); ?>" required></div>
            <div class="form-group">
                <label>Status</label>
                <select name="aktif" class="form-control">
                    <option value="Y" <?php echo $edit_data['aktif']==='Y'?'selected':''; ?>>Tampil (Aktif)</option>
                    <option value="N" <?php echo $edit_data['aktif']==='N'?'selected':''; ?>>Sembunyikan (Draft)</option>
                </select>
            </div>
            <div class="form-group"><label>Isi Konten</label><textarea name="konten" class="form-control" rows="8"><?php echo htmlspecialchars($edit_data['konten']); ?></textarea></div>
            <div class="form-group">
                <label>Pilih Icon (Font Awesome)</label>
                <input type="hidden" name="icon" id="selectedIconInput" value="<?php echo htmlspecialchars($edit_data['icon']); ?>">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;padding:12px 16px;background:#f8f9fa;border-radius:8px;border:1px solid #e0e0e0;">
                    <div style="width:44px;height:44px;border-radius:10px;background:var(--primary-600);display:flex;align-items:center;justify-content:center;">
                        <i id="iconPreviewEl" class="fa <?php echo htmlspecialchars($edit_data['icon']); ?>" style="font-size:20px;color:#fff;"></i>
                    </div>
                    <div>
                        <div style="font-weight:700;font-size:13px;" id="iconPreviewName"><?php echo htmlspecialchars($edit_data['icon']); ?></div>
                        <div style="font-size:11px;color:#888;">Klik icon di bawah untuk ganti</div>
                    </div>
                </div>
                <input type="text" id="iconSearchInput" placeholder="Cari icon..." style="width:100%;padding:9px 14px;border:1.5px solid #ddd;border-radius:8px;font-size:13px;margin-bottom:10px;font-family:inherit;outline:none;" oninput="filterIcons(this.value)">
                <div id="iconPickerGrid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(48px,1fr));gap:6px;max-height:280px;overflow-y:auto;padding:8px;background:#fff;border:1.5px solid #e0e0e0;border-radius:8px;"></div>
                <div id="iconNoResult" style="display:none;text-align:center;padding:24px;color:#aaa;font-size:13px;">Tidak ada icon yang cocok.</div>
            </div>
            <div class="form-actions">
                <button type="submit" name="submit" class="btn btn-primary">Simpan Program</button>
                <a href="dashboard.php?page=program" class="btn btn-outline">Batal</a>
            </div>
        </form>
        </div>
    </div>
    <script>
    var _iconList = ['fa-home','fa-user','fa-users','fa-user-graduate','fa-star','fa-heart','fa-thumbs-up','fa-trophy','fa-award','fa-check','fa-check-circle','fa-cog','fa-cogs','fa-chart-bar','fa-chart-line','fa-envelope','fa-phone','fa-map-marker-alt','fa-calendar','fa-calendar-alt','fa-file','fa-file-pdf','fa-file-word','fa-folder','fa-folder-open','fa-laptop','fa-desktop','fa-image','fa-images','fa-camera','fa-video','fa-music','fa-lock','fa-key','fa-shield-alt','fa-shopping-cart','fa-store','fa-dollar-sign','fa-coins','fa-plane','fa-car','fa-bus','fa-rocket','fa-flask','fa-atom','fa-tree','fa-leaf','fa-sun','fa-moon','fa-cloud','fa-pen','fa-pencil-alt','fa-search','fa-eye','fa-link','fa-download','fa-upload','fa-sync','fa-plus','fa-minus','fa-bars','fa-code','fa-bug','fa-robot','fa-running','fa-hands-helping','fa-handshake','fa-mosque','fa-book','fa-book-open','fa-graduation-cap','fa-school','fa-university','fa-chalkboard-teacher','fa-medal','fa-info-circle','fa-exclamation-triangle','fa-wrench','fa-tools','fa-chart-pie','fa-poll','fa-paper-plane','fa-headset','fa-comments','fa-comment-dots','fa-map','fa-globe','fa-compass','fa-clock','fa-history','fa-file-alt','fa-file-excel','fa-archive','fa-save','fa-database','fa-video','fa-headphones','fa-microphone','fa-fingerprint','fa-id-card','fa-tag','fa-tags','fa-receipt','fa-train','fa-bicycle','fa-ship','fa-stethoscope','fa-heartbeat','fa-hospital','fa-pills','fa-seedling','fa-fire','fa-water','fa-coffee','fa-utensils','fa-highlighter','fa-eraser','fa-ruler','fa-paint-brush','fa-palette','fa-list','fa-share-alt','fa-copy','fa-random','fa-binoculars','fa-arrow-up','fa-arrow-down','fa-arrow-left','fa-arrow-right','fa-expand','fa-compress','fa-plus-circle','fa-times-circle','fa-ellipsis-h','fa-layer-group','fa-sitemap','fa-wifi','fa-signal','fa-rss','fa-terminal','fa-laptop-code','fa-microchip','fa-football-ball','fa-basketball-ball','fa-dumbbell','fa-donate','fa-hand-sparkles','fa-pray','fa-quran','fa-place-of-worship'];
    var _currentIcon = document.getElementById('selectedIconInput').value || 'fa-star';
    function buildIconGrid(filter) {
        var grid = document.getElementById('iconPickerGrid');
        var noResult = document.getElementById('iconNoResult');
        var filtered = filter ? _iconList.filter(function(ic){ return ic.indexOf(filter.toLowerCase()) !== -1; }) : _iconList;
        grid.innerHTML = '';
        if (!filtered.length) { noResult.style.display='block'; grid.style.display='none'; return; }
        noResult.style.display='none'; grid.style.display='grid';
        filtered.forEach(function(ic) {
            var el = document.createElement('div');
            el.className = 'icon-item' + (ic === _currentIcon ? ' selected' : '');
            el.title = ic;
            el.innerHTML = '<i class="fa '+ic+'"></i><span>'+ic.replace('fa-','')+'</span>';
            el.onclick = function() {
                _currentIcon = ic;
                document.getElementById('selectedIconInput').value = ic;
                document.getElementById('iconPreviewEl').className = 'fa '+ic;
                document.getElementById('iconPreviewName').textContent = ic;
                var items = document.querySelectorAll('.icon-item');
                for (var j = 0; j < items.length; j++) items[j].classList.remove('selected');
                el.classList.add('selected');
            };
            grid.appendChild(el);
        });
    }
    function filterIcons(val) { buildIconGrid(val.trim()); }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function(){ buildIconGrid(''); });
    } else {
        buildIconGrid('');
    }
    </script>
    <?php else: ?>
    <div class="panel">
        <form method="POST" action="" id="progForm">
        <div class="panel-header" style="justify-content:flex-end">
            <button type="submit" name="deleted" class="action-delete" onclick="return confirm('Hapus program yang dipilih?')">Hapus Terpilih</button>
        </div>
        <div class="table-responsive">
        <table class="data-table">
            <thead><tr>
                <th>No</th><th>Judul Program</th><th>Konten</th><th>Icon</th><th>Status</th><th>Aksi</th>
                <th><input type="checkbox" onclick="toggleAll(this)"></th>
            </tr></thead>
            <tbody>
            <?php
            $res = $koneksi_db->sql_query("SELECT * FROM `halaman` ORDER BY id DESC");
            $i   = 0;
            if ($res) while ($r = $koneksi_db->sql_fetchrow($res)):
                $i++;
                $icon  = isset($r['icon'])  ? $r['icon']  : 'fa-star';
                $aktif = isset($r['aktif']) ? $r['aktif'] : 'Y';
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>
                        <b><?php echo htmlspecialchars($r['judul']); ?></b>
                        <?php if ($aktif === 'N'): ?> <span style="background:#ffd54f;color:#b26a00;padding:2px 6px;border-radius:4px;font-size:10px;font-weight:700;">DRAFT</span><?php endif; ?>
                    </td>
                    <td><small><?php echo mb_substr(strip_tags($r['konten']), 0, 60); ?>...</small></td>
                    <td><i class="fa <?php echo htmlspecialchars($icon); ?>" style="font-size:18px;"></i></td>
                    <td><?php echo $aktif === 'Y' ? '<span class="badge badge-aktif">Aktif</span>' : '<span class="badge badge-nonaktif">Draft</span>'; ?></td>
                    <td>
                        <a href="dashboard.php?page=program&action=edit&id=<?php echo $r['id']; ?>" class="action-btn action-edit">Edit</a>
                        <?php if ($aktif === 'Y'): ?>
                        <a href="dashboard.php?page=program&action=toggle&st=N&id=<?php echo $r['id']; ?>" class="action-btn action-del">Sembunyikan</a>
                        <?php else: ?>
                        <a href="dashboard.php?page=program&action=toggle&st=Y&id=<?php echo $r['id']; ?>" class="action-btn action-toggle">Tampilkan</a>
                        <?php endif; ?>
                    </td>
                    <td><input type="checkbox" name="delete[]" value="<?php echo $r['id']; ?>"></td>
                </tr>
            <?php endwhile; ?>
            <?php if ($i === 0): ?><tr><td colspan="7" class="text-center" style="padding:30px;color:#aaa;">Belum ada data program.</td></tr><?php endif; ?>
            </tbody>
        </table>
        </div>
        </form>
    </div>
    <?php endif; ?>

<?php
// ══════════════════════════════════════════════════════════════
// PAGE: SAMBUTAN / KONFIGURASI
// ══════════════════════════════════════════════════════════════
elseif ($page === 'sambutan' && $db_ready):
    $res     = $koneksi_db->sql_query("SELECT * FROM `mod_data_profil` WHERE id='1'");
    $profil  = $koneksi_db->sql_fetchrow($res);
    if (!$profil) $profil = array('nama'=>'','slogan'=>'','sambutan'=>'');
    $vid_row = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM `mod_data_video` ORDER BY id DESC LIMIT 1"));
    $current_video = $vid_row ? $vid_row['video'] : '';
?>
    <div class="page-header">
        <div>
            <h2>Konfigurasi Website</h2>
            <p>Atur teks tentang, nama institusi, video profil.</p>
        </div>
    </div>
    <?php if ($prof_msg): ?><div class="msg-ok"><?php echo $prof_msg; ?></div><?php endif; ?>
    <?php if ($prof_error): ?><div class="msg-err"><?php echo $prof_error; ?></div><?php endif; ?>

    <div class="panel">
        <div class="panel-body-padded">
        <form method="POST" action="">
            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Institusi / Judul Tentang</label>
                    <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($profil['nama']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Sub Judul / Slogan</label>
                    <input type="text" name="slogan" class="form-control" value="<?php echo htmlspecialchars($profil['slogan']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label>Teks Tentang</label>
                <textarea name="sambutan" id="sambutan" class="form-control" rows="8"><?php echo htmlspecialchars($profil['sambutan']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Video YouTube (ID atau URL)</label>
                <div style="display:flex;gap:12px;align-items:flex-start">
                    <div style="flex:1">
                        <input type="text" name="video_id" class="form-control" value="<?php echo htmlspecialchars($current_video); ?>" placeholder="Contoh: dQw4w9WgXcQ atau URL YouTube">
                        <div class="form-hint">Masukkan YouTube Video ID atau URL lengkap.</div>
                    </div>
                    <?php if ($current_video): ?>
                    <div style="flex-shrink:0;width:160px">
                        <img src="https://img.youtube.com/vi/<?php echo htmlspecialchars($current_video); ?>/mqdefault.jpg" style="width:100%;border-radius:8px;border:1px solid #eee;" alt="video thumbnail">
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" name="submit_profil" class="btn btn-primary">Simpan Konfigurasi</button>
            </div>
        </form>
        </div>
    </div>
    <script src="plugin/ckeditor/ckeditor.js"></script>
    <script>if (typeof CKEDITOR !== 'undefined') { CKEDITOR.replace('sambutan', { height: 300 }); }</script>

<?php else: ?>
    <div class="msg-err">Halaman tidak ditemukan atau database tidak tersambung.</div>
<?php endif; ?>
    </main>

    <footer class="dash-footer">
        &copy; <?php echo date('Y'); ?> MBKM IAI PI Bandung &mdash; Sistem Informasi.
        <a href="dashboard.php?aksi=logout">Keluar</a>
    </footer>
</div>

<!-- Delete Confirm Modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div><svg viewBox="0 0 24 24" style="width:48px;height:48px;fill:#e53935"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg></div>
        <h3>Hapus Buku?</h3>
        <p id="deleteModalText"></p>
        <div class="modal-btns">
            <button onclick="closeDeleteModal()" class="btn btn-outline">Batal</button>
            <button id="deleteConfirmBtn" class="btn" style="background:#e53935;color:#fff">Ya, Hapus</button>
        </div>
    </div>
</div>
<form id="deleteForm" method="post" action="" style="display:none"></form>

<script>
// Clock
function tick() {
    var n = new Date();
    var h = String(n.getHours()).padStart(2,'0');
    var m = String(n.getMinutes()).padStart(2,'0');
    var t = h + ':' + m;
    var el = document.getElementById('clock');
    if (el) el.textContent = t;
    var el2 = document.getElementById('clockBig');
    if (el2) el2.textContent = t;
    var days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    var months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    var ds = days[n.getDay()] + ', ' + n.getDate() + ' ' + months[n.getMonth()] + ' ' + n.getFullYear();
    var el3 = document.getElementById('dateBig');
    if (el3) el3.textContent = ds;
}
tick();
setInterval(tick, 1000);

// Sidebar toggle
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('show');
}

// Delete modal
function showDeleteModal(id, title) {
    document.getElementById('deleteModalText').textContent = 'Buku "' + title + '" akan dihapus permanen.';
    document.getElementById('deleteModal').classList.add('show');
    document.getElementById('deleteConfirmBtn').onclick = function() {
        var f = document.getElementById('deleteForm');
        f.action = 'dashboard.php?page=flipbook&aksi=hapus&id=' + id;
        f.submit();
    };
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('show');
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});

// Checkbox helpers
function toggleAll(el) {
    var cbs = document.querySelectorAll('input[name="delete[]"]');
    for (var i = 0; i < cbs.length; i++) cbs[i].checked = el.checked;
}
function toggleAllFb(el) {
    var cbs = document.querySelectorAll('input[name="fb_delete[]"]');
    for (var i = 0; i < cbs.length; i++) cbs[i].checked = el.checked;
}

// Animate stat numbers
(function() {
    var cards = document.querySelectorAll('.stat-value');
    for (var i = 0; i < cards.length; i++) {
        (function(el) {
            var v = parseInt(el.textContent.replace(/\D/g,'')) || 0;
            if (v > 0) {
                var start = null;
                function step(ts) {
                    if (!start) start = ts;
                    var p = Math.min((ts - start) / 900, 1);
                    var val = Math.floor((1 - Math.pow(1 - p, 3)) * v);
                    el.textContent = val.toLocaleString('id-ID');
                    if (p < 1) requestAnimationFrame(step);
                }
                requestAnimationFrame(step);
            }
        })(cards[i]);
    }
})();

// Cropper
var _cropper = null;
function initCrop(input) {
    if (!input.files || !input.files[0]) return;
    var reader = new FileReader();
    reader.onload = function(e) {
        var img = document.getElementById('cropImgEl');
        img.src = e.target.result;
        document.getElementById('cropModal').classList.add('open');
        if (_cropper) _cropper.destroy();
        img.onload = function() {
            _cropper = new Cropper(img, { aspectRatio: 220/300, viewMode: 1, dragMode: 'move', autoCropArea: .9 });
        };
    };
    reader.readAsDataURL(input.files[0]);
}
function applyCrop() {
    if (!_cropper) return;
    var c = _cropper.getCroppedCanvas({ width: 440, height: 600, imageSmoothingQuality: 'high' });
    var b = c.toDataURL('image/jpeg', .88);
    document.getElementById('coverBase64').value = b;
    var prev = document.getElementById('coverPreviewImg');
    prev.src = b;
    prev.style.display = 'block';
    cancelCrop();
}
function cancelCrop() {
    document.getElementById('cropModal').classList.remove('open');
    if (_cropper) { _cropper.destroy(); _cropper = null; }
    var ri = document.getElementById('rawCoverInput');
    if (ri) ri.value = '';
}
</script>
</body>
</html>