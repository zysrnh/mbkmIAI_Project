<?php
/**
 * Database Cleanup Script for MBKM IAI PI Bandung
 * This script sanitizes the tb_setting table to remove SEO spam keywords.
 * IMPORTANT: Delete this file from the server after running it!
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database configuration
$config_path = __DIR__ . '/ikutan/config.php';
if (!file_exists($config_path)) {
    die("Error: config.php tidak ditemukan di: " . $config_path);
}

// Read database configuration variables from config.php
$config_content = file_get_contents($config_path);
preg_match('/\$mysql_host\s*=\s*[\'"]([^\'"]+)[\'"]/', $config_content, $host_match);
preg_match('/\$mysql_user\s*=\s*[\'"]([^\'"]+)[\'"]/', $config_content, $user_match);
preg_match('/\$mysql_password\s*=\s*[\'"]([^\'"]+)[\'"]/', $config_content, $pass_match);
preg_match('/\$mysql_database\s*=\s*[\'"]([^\'"]+)[\'"]/', $config_content, $db_match);

$mysql_host = isset($host_match[1]) ? $host_match[1] : 'localhost';
$mysql_user = isset($user_match[1]) ? $user_match[1] : '';
$mysql_password = isset($pass_match[1]) ? $pass_match[1] : '';
$mysql_database = isset($db_match[1]) ? $db_match[1] : '';

echo "<h3>Database Cleanup Tool</h3>";
echo "Menghubungkan ke database <b>$mysql_database</b> di <b>$mysql_host</b>...<br>";

$conn = @mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);
if (!$conn) {
    die("<span style='color:red;'>Koneksi database gagal: " . mysqli_connect_error() . "</span>");
}

echo "<span style='color:green;'>Koneksi berhasil!</span><br><br>";

// Clean metadata values
$clean_title = 'MBKM IAI Persis Bandung';
$clean_desc = 'Portal Merdeka Belajar Kampus Merdeka (MBKM) Institut Agama Islam Persis Bandung.';
$clean_keys = 'mbkm, iai persis bandung, iaipi bandung, kampus merdeka, merdeka belajar, portal mahasiswa';

// Sanitize inputs for MySQL
$title_escaped = mysqli_real_escape_string($conn, $clean_title);
$desc_escaped = mysqli_real_escape_string($conn, $clean_desc);
$keys_escaped = mysqli_real_escape_string($conn, $clean_keys);

// Check if tb_setting table exists
$check_table = mysqli_query($conn, "SHOW TABLES LIKE 'tb_setting'");
if (mysqli_num_rows($check_table) == 0) {
    die("<span style='color:red;'>Error: Tabel tb_setting tidak ditemukan di database!</span>");
}

// Update the setting
$update_query = "UPDATE tb_setting SET 
    Web_Title = '$title_escaped',
    Meta_Desc = '$desc_escaped',
    Meta_Key = '$keys_escaped'";

if (mysqli_query($conn, $update_query)) {
    echo "<span style='color:green; font-weight:bold;'>Sukses! Tabel tb_setting berhasil dibersihkan dari SEO Spam.</span><br>";
    echo "<b>Web_Title baru:</b> $clean_title<br>";
    echo "<b>Meta_Desc baru:</b> $clean_desc<br>";
    echo "<b>Meta_Key baru:</b> $clean_keys<br><br>";
} else {
    echo "<span style='color:red;'>Gagal mengupdate database: " . mysqli_error($conn) . "</span><br><br>";
}

mysqli_close($conn);

// Self-destruct for security
echo "Menghapus file script ini secara otomatis demi keamanan... ";
if (@unlink(__FILE__)) {
    echo "<span style='color:green; font-weight:bold;'>Berhasil dihapus!</span><br>";
} else {
    echo "<span style='color:orange; font-weight:bold;'>Gagal menghapus otomatis. Harap HAPUS file 'clean_db.php' ini secara manual sekarang juga!</span><br>";
}
?>
