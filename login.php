<?php
/**
 * Student Login Portal — Matching Admin Aesthetics
 */
if (session_status() === PHP_SESSION_NONE) {
    session_name("Login");
    session_start();
}

// Redirect jika sudah login
if (isset($_SESSION['UserName']) && !empty($_SESSION['UserName'])) {
    header("Location: dashboard.php");
    exit;
}

$login_error = isset($_GET['err']) ? $_GET['err'] : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Mahasiswa — MBKM IAI PI Bandung</title>
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

    /* ── LEFT PANEL ── */
    .login-left {
        flex: 1;
        background: linear-gradient(160deg, var(--primary-900) 0%, #0d1f12 40%, var(--primary-800) 100%);
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        position: relative; overflow: hidden;
        padding: 60px;
    }
    .grid-dots {
        position: absolute; inset: 0;
        background-image: radial-gradient(rgba(255,255,255,.04) 1px, transparent 1px);
        background-size: 32px 32px;
        pointer-events: none;
    }
    .left-content { position: relative; z-index: 2; text-align: center; max-width: 400px; }
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

    /* ── RIGHT PANEL ── */
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
    .form-header h2 { font-size: 24px; font-weight: 800; color: var(--text-primary); margin-bottom: 6px; }
    .form-header p { font-size: 14px; color: var(--text-muted); line-height: 1.5; }

    .login-error {
        background: #fbe9e7; border: 1px solid #ffccbc;
        color: #bf360c; padding: 12px 16px;
        border-radius: 10px; font-size: 13px; font-weight: 600;
        margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
    }

    .field { margin-bottom: 22px; }
    .field label {
        display: flex; align-items: center; gap: 6px;
        font-size: 12.5px; font-weight: 700; color: var(--text-secondary); margin-bottom: 7px;
    }
    .field input {
        width: 100%; padding: 13px 16px;
        background: #f8faf7; border: 2px solid #e8ede6;
        border-radius: 10px; font-size: 14px; outline: none; transition: all .2s;
    }
    .field input:focus { border-color: var(--primary-400); background: #fff; box-shadow: 0 0 0 4px rgba(76,175,92,.1); }

    .btn-submit {
        width: 100%; padding: 14px;
        background: linear-gradient(135deg, var(--primary-800), var(--primary-600));
        color: #fff; border: none; border-radius: 10px;
        font-size: 15px; font-weight: 700; cursor: pointer; transition: all .3s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        box-shadow: 0 4px 16px rgba(30,77,39,.2);
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(30,77,39,.3); }

    .form-footer { margin-top: 28px; text-align: center; font-size: 13px; color: var(--text-muted); }
    .form-footer a { color: var(--primary-600); text-decoration: none; font-weight: 700; }
    .form-footer a:hover { color: var(--primary-800); }

    @media (max-width: 960px) { .login-left { display: none; } .login-right { width: 100%; } }
    </style>
</head>
<body>

<div class="login-left">
    <div class="grid-dots"></div>
    <div class="left-content">
        <div class="left-icon">
            <svg viewBox="0 0 24 24"><path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/></svg>
        </div>
        <h1>Portal Mahasiswa</h1>
        <p>Akses pelaporan dan upload dokumen MBKM IAI PI Bandung</p>
    </div>
</div>

<div class="login-right">
    <div class="login-form-wrap">
        <div class="form-header">
            <div class="badge">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                Portal Mahasiswa
            </div>
            <h2>Selamat Datang</h2>
            <p>Silakan masuk menggunakan akun MBKM Anda.</p>
        </div>

        <?php if ($login_error): ?>
        <div class="login-error">
            <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:#e53935"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
            <?php echo htmlspecialchars($login_error); ?>
        </div>
        <?php endif; ?>

        <form method="post" action="admin-login.php">
            <input type="hidden" name="loguser" value="1">
            <input type="hidden" name="portal" value="user">
            
            <div class="field">
                <label>Username</label>
                <input type="text" name="username" placeholder="Username Mahasiswa" required autofocus>
            </div>

            <div class="field">
                <label>Password</label>
                <input type="password" name="password" placeholder="Kata Sandi" required>
            </div>

            <button type="submit" name="submit_login" class="btn-submit">
                Masuk Sekarang
            </button>
        </form>

        <div class="form-footer">
            Belum punya akun? <a href="register.php">Daftar Di Sini</a><br><br>
            <a href="index.php">&larr; Kembali ke Situs</a>
        </div>
    </div>
</div>

</body>
</html>
