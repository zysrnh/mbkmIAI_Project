<?php
/*
 * Modern Admin Login — Standalone Fullpage
 * Pointed by .htaccess: admin.html → admin-login.php
 */

// Session should already be started by CMS, but guard for standalone access
if (session_status() === PHP_SESSION_NONE) {
    session_name("Login");
    session_start();
}

// DB + fungsi might already be loaded by CMS
if (!isset($koneksi_db)) {
    if (!defined('cms-KOMPONEN')) define('cms-KOMPONEN', true);
    if (!defined('cms-KONTEN'))   define('cms-KONTEN', true);
    if (!defined('cms-FUNGSI'))   define('cms-FUNGSI', true);
    @include_once $_SERVER['DOCUMENT_ROOT'] . '/ikutan/config.php';
    @include_once $_SERVER['DOCUMENT_ROOT'] . '/ikutan/mysqli.php';
    @include_once $_SERVER['DOCUMENT_ROOT'] . '/ikutan/fungsi.php';
}

// Auto redirect jika sudah login sebagai admin
if (function_exists('cek_login') && cek_login() && isset($_SESSION['LevelAkses']) && $_SESSION['LevelAkses'] === 'Administrator') {
    header("Location: /dashboard.php");
    exit;
}

// Proses login Custom (Multi-Role)
$login_error = '';
if (isset($_POST['submit_login']) && @$_POST['loguser'] == 1) {
    $user     = $_POST['username'];
    $password = md5($_POST['password']);
    $portal   = isset($_POST['portal']) ? $_POST['portal'] : 'admin';
    
    // Gunakan fungsi bawaan CMS agar kompatibel 100%
    $query = $koneksi_db->sql_query("SELECT user, password, level, email FROM pengguna WHERE user='$user' AND password='$password' AND tipe='aktif'");
    $total = $koneksi_db->sql_numrows($query);
    $data  = $koneksi_db->sql_fetchrow($query);
    
    if ($total > 0) {
        $level = $data['level'];
        
        // Cek Pintu Masuk (Portal Restriction)
        if ($portal === 'admin') {
            // Admin pintu utama: Izinkan Administrator, admin (tutup mata dikit), atau Editor
            if (strtolower($level) !== 'administrator' && strtolower($level) !== 'admin' && strtolower($level) !== 'editor') {
                $login_error = "Maaf, akun abang levelnya '$level'. Portal ini khusus buat Admin. Silakan login lewat Portal Mahasiswa ya.";
            }
        } else {
            // Mahasiswa pintu samping: Khusus User atau Mahasiswa
            if (strtolower($level) === 'administrator' || strtolower($level) === 'admin' || strtolower($level) === 'editor') {
                $login_error = "Nah lho, akun abang itu '$level' (Admin). Silakan login lewat portal khusus Admin (admin.html).";
            }
        }
        
        // Jika tidak ada error portal, baru set session & redirect
        if (!$login_error) {
            $_SESSION['UserName']   = $data['user'];
            $_SESSION['LevelAkses'] = $data['level'];
            $_SESSION['UserEmail']  = $data['email'];
            
            if ($level === 'Administrator' || $level === 'Editor') {
                header("Location: dashboard.php");
            } else {
                header("Location: dashboard.php?page=upload_user");
            }
            exit;
        } else {
            // Jika ada error portal (salah pintu), arahkan balik dengan error
            if ($portal === 'user') {
                header("Location: login.php?err=" . urlencode($login_error));
                exit;
            }
        }
    } else {
        $login_error = 'Username atau Password Salah, atau akun belum aktif.';
        if ($portal === 'user') {
            header("Location: login.php?err=" . urlencode($login_error));
            exit;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — MBKM IAI PI Bandung</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --primary-900: #1a3a20; --primary-800: #1e4d27; --primary-700: #256830;
        --primary-600: #2d7a3a; --primary-500: #38934a; --primary-400: #4caf5c;
        --primary-300: #81c784; --primary-200: #a5d6a7; --primary-100: #c8e6c9;
        --primary-50: #e8f5e9;
        --surface: #f4f6f3; --white: #ffffff;
        --text-primary: #1b2e1f; --text-secondary: #5a6e5e; --text-muted: #8a9a8e;
        --ease: cubic-bezier(.4,0,.2,1);
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        min-height: 100vh;
        display: flex;
        background: var(--primary-900);
        overflow: hidden;
    }

    /* ── LEFT PANEL (decorative) ── */
    .login-left {
        flex: 1;
        background: linear-gradient(160deg, var(--primary-900) 0%, #0d1f12 40%, var(--primary-800) 100%);
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        position: relative; overflow: hidden;
        padding: 60px;
    }
    .login-left::before {
        content: '';
        position: absolute; width: 600px; height: 600px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(56,147,74,.12) 0%, transparent 70%);
        top: -100px; right: -100px;
    }
    .login-left::after {
        content: '';
        position: absolute; width: 400px; height: 400px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(76,175,92,.08) 0%, transparent 70%);
        bottom: -80px; left: -60px;
    }
    /* Decorative grid dots */
    .grid-dots {
        position: absolute; inset: 0;
        background-image: radial-gradient(rgba(255,255,255,.04) 1px, transparent 1px);
        background-size: 32px 32px;
        pointer-events: none;
    }

    .left-content {
        position: relative; z-index: 2;
        text-align: center; max-width: 400px;
    }
    .left-icon {
        width: 72px; height: 72px;
        background: linear-gradient(135deg, var(--primary-500), var(--primary-300));
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 28px;
        box-shadow: 0 12px 40px rgba(56,147,74,.3);
    }
    .left-icon svg { width: 36px; height: 36px; fill: #fff; }
    .left-content h1 {
        font-size: 28px; font-weight: 900; color: #fff;
        margin-bottom: 12px; letter-spacing: -.5px; line-height: 1.2;
    }
    .left-content p {
        font-size: 15px; color: rgba(255,255,255,.45);
        line-height: 1.7; max-width: 340px; margin: 0 auto;
    }
    .left-features {
        margin-top: 48px;
        display: flex; flex-direction: column; gap: 16px;
        text-align: left;
    }
    .left-feature {
        display: flex; align-items: center; gap: 14px;
        color: rgba(255,255,255,.5); font-size: 13.5px; font-weight: 500;
    }
    .left-feature-icon {
        width: 36px; height: 36px; border-radius: 10px;
        background: rgba(255,255,255,.06);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .left-feature-icon svg { width: 16px; height: 16px; fill: var(--primary-400); }

    /* ── RIGHT PANEL (form) ── */
    .login-right {
        width: 520px; flex-shrink: 0;
        background: var(--white);
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        padding: 60px 56px;
        position: relative;
    }

    .login-form-wrap { width: 100%; max-width: 380px; }

    .form-header { margin-bottom: 36px; }
    .form-header .badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: var(--primary-50); color: var(--primary-600);
        font-size: 11px; font-weight: 700; padding: 4px 12px;
        border-radius: 6px; margin-bottom: 16px;
        text-transform: uppercase; letter-spacing: .5px;
    }
    .form-header .badge svg { width: 12px; height: 12px; fill: currentColor; }
    .form-header h2 {
        font-size: 24px; font-weight: 800; color: var(--text-primary);
        margin-bottom: 6px; letter-spacing: -.3px;
    }
    .form-header p {
        font-size: 14px; color: var(--text-muted); line-height: 1.5;
    }

    /* Error msg */
    .login-error {
        background: #fbe9e7; border: 1px solid #ffccbc;
        color: #bf360c; padding: 12px 16px;
        border-radius: 10px; font-size: 13px; font-weight: 600;
        margin-bottom: 20px;
        display: flex; align-items: center; gap: 8px;
    }
    .login-error svg { width: 18px; height: 18px; fill: #e53935; flex-shrink: 0; }

    /* Fields */
    .field { margin-bottom: 22px; }
    .field label {
        display: flex; align-items: center; gap: 6px;
        font-size: 12.5px; font-weight: 700; color: var(--text-secondary);
        margin-bottom: 7px;
    }
    .field label svg { width: 14px; height: 14px; fill: var(--text-muted); }
    .field-input-wrap {
        position: relative;
    }
    .field input {
        width: 100%; padding: 13px 16px; padding-right: 44px;
        background: #f8faf7; border: 2px solid #e8ede6;
        border-radius: 10px; font-size: 14px; font-family: inherit;
        color: var(--text-primary);
        transition: all .25s var(--ease); outline: none;
    }
    .field input:focus {
        background: #fff; border-color: var(--primary-400);
        box-shadow: 0 0 0 4px rgba(76,175,92,.1);
    }
    .field input::placeholder { color: #b5c4b8; }
    .field-icon {
        position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
        width: 18px; height: 18px; fill: var(--text-muted); pointer-events: none;
    }
    .toggle-pass {
        position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer; padding: 0; color: var(--text-muted);
    }
    .toggle-pass svg { width: 18px; height: 18px; fill: currentColor; }

    .btn-submit {
        width: 100%; padding: 14px;
        background: linear-gradient(135deg, var(--primary-800), var(--primary-600));
        color: #fff; border: none; border-radius: 10px;
        font-size: 15px; font-weight: 700; font-family: inherit;
        cursor: pointer; transition: all .3s var(--ease);
        display: flex; align-items: center; justify-content: center; gap: 8px;
        margin-top: 6px;
        box-shadow: 0 4px 16px rgba(30,77,39,.2);
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(30,77,39,.3);
    }
    .btn-submit:active { transform: translateY(0); }
    .btn-submit svg { width: 18px; height: 18px; fill: currentColor; }

    .form-footer {
        margin-top: 28px; text-align: center;
    }
    .form-footer a {
        font-size: 13px; color: var(--primary-600); text-decoration: none;
        font-weight: 600; display: inline-flex; align-items: center; gap: 5px;
        transition: color .2s;
    }
    .form-footer a:hover { color: var(--primary-800); }
    .form-footer a svg { width: 14px; height: 14px; fill: currentColor; }

    .login-copyright {
        position: absolute; bottom: 24px; left: 0; right: 0;
        text-align: center; font-size: 11px; color: var(--text-muted);
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 960px) {
        .login-left { display: none; }
        body { background: var(--white); }
        .login-right { width: 100%; padding: 40px 28px; }
    }
    @media (max-width: 480px) {
        .login-right { padding: 32px 20px; }
        .form-header h2 { font-size: 20px; }
    }

    /* ── Animations ── */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeLeft { from { opacity: 0; transform: translateX(-20px); } to { opacity: 1; transform: translateX(0); } }
    .left-content { animation: fadeLeft .6s var(--ease) .1s both; }
    .login-form-wrap { animation: fadeUp .5s var(--ease) .15s both; }
    </style>
</head>
<body>

<!-- ── LEFT DECORATIVE PANEL ── -->
<div class="login-left">
    <div class="grid-dots"></div>
    <div class="left-content">
        <div class="left-icon">
            <svg viewBox="0 0 24 24"><path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/></svg>
        </div>
        <h1>MBKM IAI PI Bandung</h1>
        <p>Sistem Informasi Merdeka Belajar Kampus Merdeka — Institut Agama Islam Persatuan Islam Bandung</p>
    </div>
</div>

<!-- ── RIGHT LOGIN FORM ── -->
<div class="login-right">
    <div class="login-form-wrap">
        <div class="form-header">
            <div class="badge">
                <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                Admin Area
            </div>
            <h2>Masuk ke Dashboard</h2>
            <p>Masukkan kredensial admin untuk mengakses panel pengelolaan.</p>
        </div>

        <?php if ($login_error): ?>
        <div class="login-error">
            <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
            <?= $login_error ?>
        </div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="field">
                <label>
                    <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    Username
                </label>
                <div class="field-input-wrap">
                    <input type="text" name="username" placeholder="Masukkan username" required autofocus autocomplete="off">
                    <svg class="field-icon" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
            </div>

            <div class="field">
                <label>
                    <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                    Password
                </label>
                <div class="field-input-wrap">
                    <input type="password" name="password" id="passInput" placeholder="Masukkan kata sandi" required>
                    <button type="button" class="toggle-pass" onclick="togglePassword()">
                        <svg id="eyeIcon" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    </button>
                </div>
            </div>

            <input type="hidden" value="1" name="loguser">
            <input type="hidden" value="admin" name="portal">
            <button type="submit" name="submit_login" class="btn-submit">
                <svg viewBox="0 0 24 24"><path d="M11 7l-1.41 1.41L12.17 11H4v2h8.17l-2.58 2.58L11 17l5-5z"/></svg>
                Masuk
            </button>
        </form>

        <div class="form-footer">
            <a href="index.php">
                <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                Kembali ke Website
            </a>
        </div>
    </div>

    <div class="login-copyright">
        &copy; <?= date('Y') ?> MBKM IAI PI Bandung
    </div>
</div>

<script>
function togglePassword() {
    var inp = document.getElementById('passInput');
    var icon = document.getElementById('eyeIcon');
    if (inp.type === 'password') {
        inp.type = 'text';
        icon.innerHTML = '<path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>';
    } else {
        inp.type = 'password';
        icon.innerHTML = '<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>';
    }
}
</script>
</body>
</html>