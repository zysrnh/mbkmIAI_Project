<?php
include 'ikutan/config.php';
include 'ikutan/mysqli.php';
$koneksi_db->sql_query("ALTER TABLE halaman ADD COLUMN icon VARCHAR(100) DEFAULT 'fa-star'");
echo "DONE Alteration";
?>
