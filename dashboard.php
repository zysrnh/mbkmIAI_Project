<?php
/**
 * Dashboard Admin — Standalone
 * Tidak tergantung routing CMS. Cukup upload file ini + ikutan/fungsi.php
 */
if (session_status() === PHP_SESSION_NONE) {
    session_name("Login");
    session_start();
}

// Proteksi: harus login sebagai Administrator
if (!isset($_SESSION['LevelAkses']) || $_SESSION['LevelAkses'] !== 'Administrator') {
    header('Location: admin.html');
    exit;
}

// Logout
if (isset($_GET['aksi']) && $_GET['aksi'] === 'logout') {
    $_SESSION['UserName']    = '';
    $_SESSION['LevelAkses']  = '';
    $_SESSION['UserEmail']   = '';
    session_destroy();
    header('Location: admin.html');
    exit;
}

$userName = htmlspecialchars(isset($_SESSION['UserName']) ? $_SESSION['UserName'] : 'Admin');

// --- Fetch quick stats from DB (optional, wrapped in try/catch) ---
$totalBooks = 0;
$totalUsers = 0;
$totalPages = 0;
$totalVisits = 0;
try {
    if (file_exists('ikutan/config.php') && file_exists('ikutan/mysqli.php')) {
        define('cms-KOMPONEN', true);
        define('cms-KONTEN', true);
        @include 'ikutan/config.php';
        @include 'ikutan/mysqli.php';
        if (isset($koneksi_db)) {
            // Count flipbooks
            $r = @$koneksi_db->sql_query("SELECT COUNT(*) as c FROM flipbook");
            if ($r) { $d = $koneksi_db->sql_fetchrow($r); $totalBooks = (int)$d['c']; }
            // Count users
            $r = @$koneksi_db->sql_query("SELECT COUNT(*) as c FROM pengguna");
            if ($r) { $d = $koneksi_db->sql_fetchrow($r); $totalUsers = (int)$d['c']; }
            // Count pages/berita
            $r = @$koneksi_db->sql_query("SELECT COUNT(*) as c FROM berita");
            if ($r) { $d = $koneksi_db->sql_fetchrow($r); $totalPages = (int)$d['c']; }
            // Count visits
            $r = @$koneksi_db->sql_query("SELECT SUM(jumlah) as c FROM statistik");
            if ($r) { $d = $koneksi_db->sql_fetchrow($r); $totalVisits = (int)$d['c']; }
        }
    }
} catch (Exception $e) { /* silent */ }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - MBKM IAI PI Bandung</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --sidebar-w: 272px;
        --sidebar-collapsed: 72px;
        --primary-900: #1a3a20;
        --primary-800: #1e4d27;
        --primary-700: #256830;
        --primary-600: #2d7a3a;
        --primary-500: #38934a;
        --primary-400: #4caf5c;
        --primary-300: #81c784;
        --primary-200: #a5d6a7;
        --primary-100: #c8e6c9;
        --primary-50 : #e8f5e9;
        --accent-500 : #f9a825;
        --accent-400 : #fbc02d;
        --surface    : #f5f7f4;
        --surface-card: #ffffff;
        --text-primary: #1b2e1f;
        --text-secondary: #5a6e5e;
        --text-muted : #8a9a8e;
        --border     : rgba(37,104,48,.08);
        --shadow-sm  : 0 1px 3px rgba(0,0,0,.04), 0 1px 2px rgba(0,0,0,.06);
        --shadow-md  : 0 4px 6px -1px rgba(0,0,0,.05), 0 2px 4px -2px rgba(0,0,0,.05);
        --shadow-lg  : 0 10px 25px -3px rgba(0,0,0,.06), 0 4px 10px -4px rgba(0,0,0,.04);
        --shadow-xl  : 0 20px 50px -12px rgba(0,0,0,.1);
        --radius-sm  : 8px;
        --radius-md  : 12px;
        --radius-lg  : 16px;
        --radius-xl  : 20px;
        --ease       : cubic-bezier(.4,0,.2,1);
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: var(--surface);
        color: var(--text-primary);
        min-height: 100vh;
        display: flex;
        overflow-x: hidden;
    }

    /* ═══════════════════════════════════════════
       SIDEBAR
       ═══════════════════════════════════════════ */
    .sidebar {
        width: var(--sidebar-w);
        height: 100vh;
        position: fixed;
        left: 0; top: 0;
        background: linear-gradient(180deg, var(--primary-900) 0%, #162e1a 100%);
        display: flex; flex-direction: column;
        z-index: 200;
        transition: transform .35s var(--ease);
        overflow: hidden;
    }
    .sidebar::before {
        content: '';
        position: absolute; inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

    .sidebar-brand {
        padding: 28px 24px 24px;
        border-bottom: 1px solid rgba(255,255,255,.07);
        display: flex; align-items: center; gap: 14px;
        flex-shrink: 0;
        position: relative;
    }
    .sidebar-brand-icon {
        width: 44px; height: 44px;
        background: linear-gradient(135deg, var(--primary-500), var(--primary-300));
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(56,147,74,.3);
    }
    .sidebar-brand-icon svg { width: 22px; height: 22px; fill: #fff; }
    .sidebar-brand-info h2 {
        font-size: 15px; font-weight: 800; color: #fff;
        letter-spacing: -.2px; line-height: 1.2;
    }
    .sidebar-brand-info span {
        font-size: 11px; color: rgba(255,255,255,.45);
        font-weight: 500; letter-spacing: .5px; text-transform: uppercase;
    }

    /* Nav groups */
    .sidebar-nav {
        flex: 1; overflow-y: auto; padding: 16px 12px;
        scrollbar-width: thin;
        scrollbar-color: rgba(255,255,255,.1) transparent;
    }
    .nav-group { margin-bottom: 24px; }
    .nav-group-title {
        font-size: 10px; font-weight: 700; color: rgba(255,255,255,.3);
        text-transform: uppercase; letter-spacing: 1.5px;
        padding: 0 12px; margin-bottom: 8px;
    }
    .nav-item {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 12px;
        border-radius: var(--radius-sm);
        color: rgba(255,255,255,.6);
        text-decoration: none;
        font-size: 13.5px; font-weight: 500;
        transition: all .2s var(--ease);
        position: relative;
        margin-bottom: 2px;
    }
    .nav-item:hover {
        background: rgba(255,255,255,.07);
        color: rgba(255,255,255,.95);
    }
    .nav-item.active {
        background: rgba(255,255,255,.1);
        color: #fff;
        font-weight: 600;
    }
    .nav-item.active::before {
        content: '';
        position: absolute; left: 0; top: 50%;
        transform: translateY(-50%);
        width: 3px; height: 20px;
        background: var(--primary-400);
        border-radius: 0 4px 4px 0;
    }
    .nav-item svg {
        width: 20px; height: 20px; fill: currentColor; flex-shrink: 0;
        opacity: .7;
    }
    .nav-item.active svg, .nav-item:hover svg { opacity: 1; }
    .nav-badge {
        margin-left: auto;
        background: var(--primary-500);
        color: #fff;
        font-size: 10px; font-weight: 700;
        padding: 2px 8px; border-radius: 10px;
        min-width: 20px; text-align: center;
    }

    /* Sidebar footer */
    .sidebar-footer {
        padding: 16px;
        border-top: 1px solid rgba(255,255,255,.07);
        flex-shrink: 0;
    }
    .sidebar-user {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 12px;
        border-radius: var(--radius-sm);
        background: rgba(255,255,255,.05);
    }
    .sidebar-avatar {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--primary-500), var(--accent-500));
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; font-weight: 800; color: #fff;
        flex-shrink: 0;
    }
    .sidebar-user-info {
        flex: 1; min-width: 0;
    }
    .sidebar-user-name {
        font-size: 13px; font-weight: 600; color: #fff;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .sidebar-user-role {
        font-size: 11px; color: rgba(255,255,255,.4); font-weight: 500;
    }
    .sidebar-logout {
        width: 32px; height: 32px; border-radius: 8px;
        background: rgba(255,255,255,.06);
        border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        color: rgba(255,255,255,.4);
        transition: all .2s;
    }
    .sidebar-logout:hover {
        background: rgba(239,83,80,.15); color: #ef5350;
    }
    .sidebar-logout svg { width: 16px; height: 16px; fill: currentColor; }

    /* ═══════════════════════════════════════════
       MAIN CONTENT
       ═══════════════════════════════════════════ */
    .main-wrapper {
        margin-left: var(--sidebar-w);
        flex: 1; min-height: 100vh;
        display: flex; flex-direction: column;
        transition: margin-left .35s var(--ease);
    }

    /* Topbar */
    .topbar {
        height: 64px;
        background: var(--surface-card);
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center;
        padding: 0 32px;
        position: sticky; top: 0; z-index: 100;
        gap: 16px;
    }
    .topbar-toggle {
        display: none;
        width: 40px; height: 40px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border);
        background: var(--surface-card);
        cursor: pointer;
        align-items: center; justify-content: center;
        color: var(--text-secondary);
        transition: all .2s;
    }
    .topbar-toggle:hover { background: var(--primary-50); color: var(--primary-600); }
    .topbar-toggle svg { width: 20px; height: 20px; fill: currentColor; }
    .topbar-title {
        font-size: 16px; font-weight: 700; color: var(--text-primary);
    }
    .topbar-title span {
        color: var(--text-muted); font-weight: 400;
    }
    .topbar-right {
        margin-left: auto;
        display: flex; align-items: center; gap: 12px;
    }
    .topbar-clock {
        font-size: 13px; font-weight: 600;
        color: var(--text-secondary);
        background: var(--surface);
        padding: 6px 14px; border-radius: 20px;
        display: flex; align-items: center; gap: 6px;
    }
    .topbar-clock svg { width: 14px; height: 14px; fill: var(--text-muted); }
    .topbar-date {
        font-size: 12px; color: var(--text-muted);
        font-weight: 500;
    }
    .topbar-visit-site {
        font-size: 12px; font-weight: 600;
        color: var(--primary-600);
        background: var(--primary-50);
        padding: 7px 14px; border-radius: 8px;
        text-decoration: none;
        display: flex; align-items: center; gap: 6px;
        transition: all .2s;
        border: 1px solid transparent;
    }
    .topbar-visit-site:hover {
        background: var(--primary-100); border-color: var(--primary-200);
    }
    .topbar-visit-site svg { width: 14px; height: 14px; fill: currentColor; }

    /* Content */
    .content { padding: 32px; flex: 1; max-width: 1200px; }

    /* Welcome Card */
    .welcome-card {
        background: linear-gradient(135deg, var(--primary-800) 0%, var(--primary-600) 50%, #2e7d32 100%);
        border-radius: var(--radius-xl);
        padding: 40px 44px;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-bottom: 32px;
        box-shadow: 0 12px 40px rgba(30,77,39,.2);
    }
    .welcome-card::before {
        content: '';
        position: absolute; right: -40px; top: -60px;
        width: 320px; height: 320px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255,255,255,.08) 0%, transparent 70%);
    }
    .welcome-card::after {
        content: '';
        position: absolute; left: -30px; bottom: -80px;
        width: 240px; height: 240px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255,255,255,.05) 0%, transparent 70%);
    }
    .welcome-inner { position: relative; z-index: 1; display: flex; align-items: center; justify-content: space-between; }
    .welcome-text h1 {
        font-size: 26px; font-weight: 800; margin-bottom: 8px;
        line-height: 1.3; letter-spacing: -.3px;
    }
    .welcome-text p {
        font-size: 14px; color: rgba(255,255,255,.7);
        max-width: 440px; line-height: 1.6;
    }
    .welcome-graphic {
        display: flex; flex-direction: column; align-items: flex-end; gap: 4px;
    }
    .welcome-clock {
        font-size: 48px; font-weight: 900; color: rgba(255,255,255,.85);
        letter-spacing: -2px; line-height: 1;
        font-variant-numeric: tabular-nums;
    }
    .welcome-date {
        font-size: 13px; color: rgba(255,255,255,.45); font-weight: 500;
    }

    /* Stat Cards */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 32px;
    }
    .stat-card {
        background: var(--surface-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 24px;
        transition: all .3s var(--ease);
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0;
        height: 3px;
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        opacity: 0;
        transition: opacity .3s;
    }
    .stat-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-2px); }
    .stat-card:hover::before { opacity: 1; }

    .stat-card:nth-child(1)::before { background: linear-gradient(90deg, var(--primary-500), var(--primary-300)); }
    .stat-card:nth-child(2)::before { background: linear-gradient(90deg, #5c6bc0, #9fa8da); }
    .stat-card:nth-child(3)::before { background: linear-gradient(90deg, #f57c00, #ffb74d); }
    .stat-card:nth-child(4)::before { background: linear-gradient(90deg, #00acc1, #80deea); }

    .stat-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 16px;
    }
    .stat-icon {
        width: 44px; height: 44px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
    }
    .stat-icon svg { width: 22px; height: 22px; fill: currentColor; }
    .stat-card:nth-child(1) .stat-icon { background: var(--primary-50); color: var(--primary-600); }
    .stat-card:nth-child(2) .stat-icon { background: #e8eaf6; color: #5c6bc0; }
    .stat-card:nth-child(3) .stat-icon { background: #fff3e0; color: #f57c00; }
    .stat-card:nth-child(4) .stat-icon { background: #e0f7fa; color: #00acc1; }

    .stat-value {
        font-size: 32px; font-weight: 800; color: var(--text-primary);
        letter-spacing: -1px; line-height: 1;
        font-variant-numeric: tabular-nums;
    }
    .stat-label {
        font-size: 12.5px; font-weight: 600; color: var(--text-muted);
        margin-top: 6px; text-transform: uppercase; letter-spacing: .5px;
    }

    /* Main Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    /* Panel cards */
    .panel {
        background: var(--surface-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
    }
    .panel-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
    }
    .panel-title {
        font-size: 14px; font-weight: 700; color: var(--text-primary);
        display: flex; align-items: center; gap: 8px;
    }
    .panel-title svg { width: 18px; height: 18px; fill: var(--text-muted); }
    .panel-body { padding: 0; }

    /* Quick actions */
    .quick-actions { list-style: none; }
    .quick-action-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 24px;
        text-decoration: none;
        color: var(--text-primary);
        border-bottom: 1px solid var(--border);
        transition: all .2s var(--ease);
    }
    .quick-action-item:last-child { border-bottom: none; }
    .quick-action-item:hover {
        background: var(--primary-50);
    }
    .qa-icon {
        width: 42px; height: 42px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: transform .3s var(--ease);
    }
    .quick-action-item:hover .qa-icon { transform: scale(1.08); }
    .qa-icon svg { width: 20px; height: 20px; fill: currentColor; }
    .qa-icon.green  { background: var(--primary-50); color: var(--primary-600); }
    .qa-icon.blue   { background: #e3f2fd; color: #1976d2; }
    .qa-icon.purple { background: #ede7f6; color: #7b1fa2; }
    .qa-icon.amber  { background: #fff8e1; color: #f9a825; }
    .qa-icon.teal   { background: #e0f2f1; color: #00897b; }
    .qa-info { flex: 1; min-width: 0; }
    .qa-title { font-size: 13.5px; font-weight: 600; color: var(--text-primary); }
    .qa-desc  { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
    .qa-arrow {
        width: 28px; height: 28px; border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        background: var(--surface);
        color: var(--text-muted);
        transition: all .2s;
        flex-shrink: 0;
    }
    .quick-action-item:hover .qa-arrow {
        background: var(--primary-600); color: #fff;
    }
    .qa-arrow svg { width: 14px; height: 14px; fill: currentColor; }

    /* Server Info */
    .info-list { list-style: none; }
    .info-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 14px 24px;
        border-bottom: 1px solid var(--border);
        font-size: 13px;
    }
    .info-item:last-child { border-bottom: none; }
    .info-label { color: var(--text-muted); font-weight: 500; display: flex; align-items: center; gap: 8px; }
    .info-label svg { width: 16px; height: 16px; fill: var(--text-muted); }
    .info-value { font-weight: 600; color: var(--text-primary); font-variant-numeric: tabular-nums; }
    .info-badge {
        font-size: 11px; font-weight: 700;
        padding: 3px 10px; border-radius: 6px;
    }
    .info-badge.green { background: var(--primary-50); color: var(--primary-600); }
    .info-badge.blue { background: #e3f2fd; color: #1565c0; }

    /* Footer */
    .dash-footer {
        padding: 24px 32px;
        text-align: center;
        color: var(--text-muted);
        font-size: 12px;
        border-top: 1px solid var(--border);
        margin-top: 40px;
    }
    .dash-footer a { color: var(--primary-600); text-decoration: none; font-weight: 600; }

    /* Mobile overlay */
    .sidebar-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(0,0,0,.4);
        z-index: 199;
        opacity: 0;
        transition: opacity .35s;
    }
    .sidebar-overlay.show { display: block; opacity: 1; }

    /* ═══════════════════════════════════════════
       RESPONSIVE
       ═══════════════════════════════════════════ */
    @media (max-width: 1024px) {
        .stats-row { grid-template-columns: repeat(2, 1fr); }
        .dashboard-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }
        .sidebar.open { transform: translateX(0); }
        .sidebar-overlay.show { display: block; }
        .main-wrapper { margin-left: 0; }
        .topbar-toggle { display: flex; }
        .content { padding: 20px 16px; }
        .welcome-card { padding: 28px 24px; }
        .welcome-clock { font-size: 36px; }
        .welcome-text h1 { font-size: 20px; }
        .welcome-graphic { display: none; }
        .stats-row { grid-template-columns: 1fr 1fr; gap: 12px; }
        .stat-card { padding: 18px; }
        .stat-value { font-size: 24px; }
    }
    @media (max-width: 480px) {
        .stats-row { grid-template-columns: 1fr; }
        .topbar-date, .topbar-visit-site { display: none; }
    }

    /* ═══════════════════════════════════════════
       ANIMATIONS
       ═══════════════════════════════════════════ */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .welcome-card  { animation: fadeInUp .5s var(--ease) both; }
    .stat-card:nth-child(1) { animation: fadeInUp .5s var(--ease) .08s both; }
    .stat-card:nth-child(2) { animation: fadeInUp .5s var(--ease) .14s both; }
    .stat-card:nth-child(3) { animation: fadeInUp .5s var(--ease) .20s both; }
    .stat-card:nth-child(4) { animation: fadeInUp .5s var(--ease) .26s both; }
    .panel { animation: fadeInUp .5s var(--ease) .32s both; }
    </style>
</head>
<body>

<!-- SIDEBAR OVERLAY (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- ═══════════ SIDEBAR ═══════════ -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-icon">
            <svg viewBox="0 0 24 24"><path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/></svg>
        </div>
        <div class="sidebar-brand-info">
            <h2>MBKM IAI PI</h2>
            <span>Admin Panel</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-group">
            <div class="nav-group-title">Menu Utama</div>
            <a href="dashboard.php" class="nav-item active">
                <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                Dashboard
            </a>
            <a href="admin.php?pilih=flipbook&modul=yes" class="nav-item">
                <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                E-Book / Flipbook
                <?php if($totalBooks > 0): ?>
                <span class="nav-badge"><?= $totalBooks ?></span>
                <?php endif; ?>
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-group-title">Pengaturan</div>
            <a href="admin.php?pilih=pengguna&modul=yes" class="nav-item">
                <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                Kelola Akun
            </a>
            <a href="admin.php" class="nav-item">
                <svg viewBox="0 0 24 24"><path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.07.62-.07.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg>
                Panel Admin CMS
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-group-title">Lainnya</div>
            <a href="index.php" target="_blank" class="nav-item">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                Lihat Website
                <svg viewBox="0 0 24 24" style="width:14px;height:14px;margin-left:auto;opacity:.4"><path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/></svg>
            </a>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-avatar"><?= strtoupper(substr($userName, 0, 1)) ?></div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name"><?= $userName ?></div>
                <div class="sidebar-user-role">Administrator</div>
            </div>
            <a href="dashboard.php?aksi=logout" class="sidebar-logout" title="Keluar">
                <svg viewBox="0 0 24 24"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
            </a>
        </div>
    </div>
</aside>

<!-- ═══════════ MAIN ═══════════ -->
<div class="main-wrapper">
    <!-- Topbar -->
    <header class="topbar">
        <button class="topbar-toggle" onclick="toggleSidebar()">
            <svg viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
        </button>
        <div class="topbar-title">Dashboard <span>/ Overview</span></div>
        <div class="topbar-right">
            <div class="topbar-date" id="dateStr">-</div>
            <div class="topbar-clock">
                <svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
                <span id="clock">--:--</span>
            </div>
            <a href="index.php" target="_blank" class="topbar-visit-site">
                <svg viewBox="0 0 24 24"><path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/></svg>
                Kunjungi Situs
            </a>
        </div>
    </header>

    <!-- Content -->
    <main class="content">

        <!-- Welcome Card -->
        <div class="welcome-card">
            <div class="welcome-inner">
                <div class="welcome-text">
                    <h1>Selamat datang kembali, <?= $userName ?>! 👋</h1>
                    <p>Kelola konten dan pengaturan Sistem Informasi MBKM IAI PI Bandung dari dashboard ini.</p>
                </div>
                <div class="welcome-graphic">
                    <div class="welcome-clock" id="clockBig">--:--</div>
                    <div class="welcome-date" id="dateBig">-</div>
                </div>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                </div>
                <div class="stat-value"><?= $totalBooks ?></div>
                <div class="stat-label">Total E-Book</div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                    </div>
                </div>
                <div class="stat-value"><?= $totalUsers ?></div>
                <div class="stat-label">Total Pengguna</div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zM6 20V4h7v5h5v11H6z"/></svg>
                    </div>
                </div>
                <div class="stat-value"><?= $totalPages ?></div>
                <div class="stat-label">Total Halaman</div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    </div>
                </div>
                <div class="stat-value"><?= number_format($totalVisits) ?></div>
                <div class="stat-label">Total Kunjungan</div>
            </div>
        </div>

        <!-- Dashboard Grid -->
        <div class="dashboard-grid">

            <!-- Quick Actions -->
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <svg viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Akses Cepat
                    </div>
                </div>
                <div class="panel-body">
                    <div class="quick-actions">
                        <a href="admin.php?pilih=flipbook&modul=yes" class="quick-action-item">
                            <div class="qa-icon green">
                                <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                            </div>
                            <div class="qa-info">
                                <div class="qa-title">Kelola E-Book</div>
                                <div class="qa-desc">Upload dan atur buku flipbook PDF</div>
                            </div>
                            <div class="qa-arrow">
                                <svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
                            </div>
                        </a>
                        <a href="admin.php?pilih=pengguna&modul=yes" class="quick-action-item">
                            <div class="qa-icon blue">
                                <svg viewBox="0 0 24 24"><path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            </div>
                            <div class="qa-info">
                                <div class="qa-title">Kelola Akun Pengguna</div>
                                <div class="qa-desc">Tambah, edit dan atur hak akses pengguna</div>
                            </div>
                            <div class="qa-arrow">
                                <svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
                            </div>
                        </a>
                        <a href="admin.php" class="quick-action-item">
                            <div class="qa-icon purple">
                                <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                            </div>
                            <div class="qa-info">
                                <div class="qa-title">Panel Admin CMS</div>
                                <div class="qa-desc">Akses semua modul sistem CMS</div>
                            </div>
                            <div class="qa-arrow">
                                <svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
                            </div>
                        </a>
                        <a href="index.php" target="_blank" class="quick-action-item">
                            <div class="qa-icon teal">
                                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                            </div>
                            <div class="qa-info">
                                <div class="qa-title">Lihat Halaman Publik</div>
                                <div class="qa-desc">Buka website MBKM di tab baru</div>
                            </div>
                            <div class="qa-arrow">
                                <svg viewBox="0 0 24 24"><path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/></svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                        Informasi Sistem
                    </div>
                </div>
                <div class="panel-body">
                    <ul class="info-list">
                        <li class="info-item">
                            <span class="info-label">
                                <svg viewBox="0 0 24 24"><path d="M20 18c1.1 0 1.99-.9 1.99-2L22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z"/></svg>
                                Platform
                            </span>
                            <span class="info-badge green">CMS Custom</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">
                                <svg viewBox="0 0 24 24"><path d="M9.4 16.6L4.8 12l4.6-4.6L8 6l-6 6 6 6 1.4-1.4zm5.2 0l4.6-4.6-4.6-4.6L16 6l6 6-6 6-1.4-1.4z"/></svg>
                                PHP Version
                            </span>
                            <span class="info-value"><?= phpversion() ?></span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">
                                <svg viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                                Server
                            </span>
                            <span class="info-value" style="font-size:12px"><?= php_uname('s') ?></span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">
                                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                Status
                            </span>
                            <span class="info-badge green">● Online</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">
                                <svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
                                Login Terakhir
                            </span>
                            <span class="info-value"><?= date('d M Y, H:i') ?></span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">
                                <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                Akun Aktif
                            </span>
                            <span class="info-badge blue"><?= $userName ?></span>
                        </li>
                    </ul>
                </div>
            </div>

        </div><!-- .dashboard-grid -->
    </main>

    <footer class="dash-footer">
        &copy; <?= date('Y') ?> MBKM IAI PI Bandung &mdash; Sistem Informasi.
        <a href="dashboard.php?aksi=logout">Keluar</a>
    </footer>
</div><!-- .main-wrapper -->

<script>
/* Clock */
function tick() {
    var now = new Date();
    var h = String(now.getHours()).padStart(2,'0');
    var m = String(now.getMinutes()).padStart(2,'0');
    var s = String(now.getSeconds()).padStart(2,'0');
    var timeStr = h + ':' + m;
    document.getElementById('clock').textContent = timeStr;
    document.getElementById('clockBig').textContent = timeStr;

    var days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    var months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    var dateStr = days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();
    document.getElementById('dateStr').textContent = dateStr;
    document.getElementById('dateBig').textContent = dateStr;
}
tick();
setInterval(tick, 1000);

/* Sidebar toggle (mobile) */
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('show');
}

/* Animate stat numbers */
function animateValue(el, end, duration) {
    var start = 0;
    var startTime = null;
    function step(timestamp) {
        if (!startTime) startTime = timestamp;
        var progress = Math.min((timestamp - startTime) / duration, 1);
        var eased = 1 - Math.pow(1 - progress, 3);
        el.textContent = Math.floor(eased * end).toLocaleString('id-ID');
        if (progress < 1) window.requestAnimationFrame(step);
    }
    if (end > 0) window.requestAnimationFrame(step);
}

document.addEventListener('DOMContentLoaded', function() {
    var statEls = document.querySelectorAll('.stat-value');
    statEls.forEach(function(el) {
        var val = parseInt(el.textContent.replace(/\D/g, '')) || 0;
        if (val > 0) animateValue(el, val, 1200);
    });
});
</script>
</body>
</html>
