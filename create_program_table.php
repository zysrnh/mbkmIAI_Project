<?php
/**
 * Script untuk membuat Tabel Program MBKM Baru
 */
include 'ikutan/config.php';
include 'ikutan/mysqli.php';

global $koneksi_db;

$sql = "CREATE TABLE IF NOT EXISTS `mod_program` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `deskripsi_singkat` text DEFAULT NULL,
  `isi` longtext NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

if ($koneksi_db->sql_query($sql)) {
    echo "<h1>Sukses Bos!</h1><p>Tabel <b>mod_program</b> berhasil dibuat atau sudah ada. Sekarang kita bisa lanjut isi data.</p>";
} else {
    echo "<h1>Error Bang!</h1><p>Gagal buat tabel: " . mysql_error() . "</p>";
}
?>
