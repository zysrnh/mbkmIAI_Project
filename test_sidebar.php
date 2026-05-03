<?php
define('cms-KONTEN', true);
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'ikutan/session.php';
include 'ikutan/config.php';
include 'ikutan/mysqli.php';
include 'ikutan/template.php';
include 'ikutan/fungsi.php';
global $koneksi_db;

ob_start();
include "plugin/berita.php";
echo "\n--- MODUL ---\n";
modul(1);
echo "\n--- BLOK ---\n";
blok(1);
$out = ob_get_clean();
echo $out;
?>
