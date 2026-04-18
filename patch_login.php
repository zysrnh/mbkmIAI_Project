<?php
/**
 * PATCH: Update cms_loginadmin agar User & Editor bisa login ke dashboard
 * Jalankan 1x lewat browser, lalu HAPUS file ini dari hosting!
 */
$file = __DIR__ . '/ikutan/fungsi.php';
$content = file_get_contents($file);

// Ganti query yang hanya allow Administrator jadi semua level aktif
$old = "AND tipe='aktif' AND level='Administrator'";
$new = "AND tipe='aktif'";
$content = str_replace($old, $new, $content);

// Ganti redirect kondisional jadi langsung ke dashboard
$old_redirect = 'if($_SESSION[\'LevelAkses\']==\"Administrator\"){' . "\n" . 'header (\"location:dashboard.php\");' . "\n" . 'exit;' . "\n" . '}else{' . "\n" . 'header (\"location:index.php\");' . "\n" . 'exit;' . "\n" . '}';
$new_redirect = 'header ("location:dashboard.php");' . "\n" . 'exit;';
$content = str_replace($old_redirect, $new_redirect, $content);

if (file_put_contents($file, $content)) {
    echo '<div style="font-family:sans-serif;padding:20px;background:#e8f5e9;border:1px solid #4caf50;border-radius:8px;max-width:600px;margin:40px auto;">';
    echo '<h2 style="color:#2e7d32;margin:0 0 10px">✅ Patch Berhasil!</h2>';
    echo '<p>File <code>ikutan/fungsi.php</code> berhasil diperbarui.</p>';
    echo '<p><strong>User & Editor sekarang bisa login ke dashboard!</strong></p>';
    echo '<p style="color:#e53935;font-weight:bold;">⚠️ SEGERA HAPUS file ini dari hosting setelah berhasil!</p>';
    echo '</div>';
} else {
    echo '<div style="font-family:sans-serif;padding:20px;background:#ffebee;border:1px solid #e53935;border-radius:8px;max-width:600px;margin:40px auto;">';
    echo '<h2 style="color:#c62828;margin:0 0 10px">❌ Patch Gagal</h2>';
    echo '<p>Tidak bisa menulis ke file. Cek permission folder <code>ikutan/</code>.</p>';
    echo '</div>';
}
?>
