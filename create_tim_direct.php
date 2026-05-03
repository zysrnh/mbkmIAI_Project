<?php
$koneksi = mysqli_connect('localhost', 'iais9713_mbkm', '~,1i);8U%LZRzo!.', 'iais9713_mbkm');
if (!$koneksi) { die("DB Error"); }

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

mysqli_query($koneksi, $sql);
echo "SUCCESS";
?>
