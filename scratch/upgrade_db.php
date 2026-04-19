<?php
include "../ikutan/config.php";
include "../ikutan/mysqli.php";

$sql = "ALTER TABLE `mod_data_profil` MODIFY `sambutan` LONGTEXT";
if($koneksi_db->sql_query($sql)) {
    echo "Kapasitas Teks Berhasil Ditambahkan!";
} else {
    echo "Gagal: " . mysqli_error($koneksi_db->db_connect_id);
} 
?>
