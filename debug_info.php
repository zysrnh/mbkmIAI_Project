<?php
/**
 * DEBUG FILE — HAPUS SETELAH SELESAI!
 * Upload ke hosting lalu buka di browser
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo '<pre style="font-family:monospace;font-size:13px;padding:20px;">';
echo '<b>PHP Version:</b> ' . PHP_VERSION . "\n";
echo '<b>PHP Major:</b> ' . PHP_MAJOR_VERSION . "\n\n";

// Cek koneksi DB
define('cms-KOMPONEN', true);
define('cms-KONTEN', true);
define('cms-ADMINISTRATOR', true);
define('cms-FUNGSI', true);
include_once 'ikutan/config.php';
include_once 'ikutan/mysqli.php';

if (isset($koneksi_db)) {
    echo "<b>DB:</b> Terhubung ✓\n\n";
    
    // Cek struktur tabel pengguna
    $res = $koneksi_db->sql_query("DESCRIBE pengguna");
    if ($res) {
        echo "<b>Kolom tabel pengguna:</b>\n";
        while ($row = $koneksi_db->sql_fetchrow($res)) {
            echo "  - " . $row['Field'] . " (" . $row['Type'] . ")\n";
        }
    } else {
        echo "<b>TABEL PENGGUNA: ERROR atau tidak ada!</b>\n";
    }
} else {
    echo "<b>DB:</b> GAGAL KONEK ✗\n";
}

echo '</pre>';
?>
