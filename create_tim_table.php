<?php
include 'ikutan/config.php';
include 'ikutan/mysqli.php';
global $koneksi_db;

$sql = "CREATE TABLE IF NOT EXISTS `mod_tim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `instansi` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(50) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `urutan` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

$res = $koneksi_db->sql_query($sql);
if ($res) {
    echo "Table mod_tim created successfully.\n";
} else {
    echo "Error creating table mod_tim.\n";
}
?>
