<?php
include 'ikutan/config.php';
include 'ikutan/mysqli.php';
global $koneksi_db;
$res = $koneksi_db->sql_query("SHOW TABLES LIKE 'mod_tim'");
if ($koneksi_db->sql_numrows($res) > 0) {
    echo "EXISTS";
} else {
    echo "NOT EXISTS";
}
?>
