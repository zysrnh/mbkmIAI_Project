<?php
/**
 * ROLLBACK: Mengembalikan ikutan/fungsi.php ke aslinya
 * Jalankan 1x lewat browser, lalu HAPUS file ini!
 */
$file = __DIR__ . '/ikutan/fungsi.php';
$content = file_get_contents($file);

// 1. Kembalikan filter Administrator agar login cms_loginadmin kaku lagi (hanya level Admin)
$old_query = 'AND tipe=\'aktif\'';
$new_query = 'AND tipe=\'aktif\' AND level=\'Administrator\'';
// Kita pakai str_replace yang sangat spesifik biar gak salah sasaran
$content = str_replace($old_query, $new_query, $content);

// 2. Kembalikan redirect kondisional (Administrator ke dashboard, selain itu ke index)
$old_redirect = 'header ("location:dashboard.php");' . "\n" . 'exit;';
$new_redirect = 'if($_SESSION[\'LevelAkses\']=="Administrator"){' . "\n" . 'header ("location:dashboard.php");' . "\n" . 'exit;' . "\n" . '}else{' . "\n" . 'header ("location:index.php");' . "\n" . 'exit;' . "\n" . '}';
$content = str_replace($old_redirect, $new_redirect, $content);

if (file_put_contents($file, $content)) {
    echo '<div style="font-family:sans-serif;padding:20px;background:#e3f2fd;border:1px solid #2196f3;border-radius:8px;max-width:600px;margin:40px auto;">';
    echo '<h2 style="color:#1565c0;margin:0 0 10px">✅ Rollback Berhasil!</h2>';
    echo '<p>File <code>ikutan/fungsi.php</code> sudah kembali ke kondisi aslinya.</p>';
    echo '<p>Sekarang sistem login menggunakan logika baru di <code>admin-login.php</code>.</p>';
    echo '<p style="color:#e53935;font-weight:bold;">⚠️ Hapus file ini sekarang!</p>';
    echo '</div>';
} else {
    echo "Gagal mengupdate file. Cek permission.";
}
?>
