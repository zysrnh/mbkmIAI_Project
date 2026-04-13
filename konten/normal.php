<?php
/*
 * normal.php — Landing Page utama
 * Tampilkan landing page biasa untuk semua user (termasuk admin).
 * Admin mengakses dashboard via dashboard.php.
 */

if (!defined('cms-KONTEN')) {
    header("Location: index.php");
    exit;
}

// Landing page konten ditampilkan langsung oleh template engine
// (header, kiri, tengah, kanan, footer sudah di-handle index.php)
// Tidak perlu output apapun di sini — konten utama sudah diurus oleh plugin/header.php dll.
?>