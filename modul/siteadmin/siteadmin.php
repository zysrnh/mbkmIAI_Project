<?php
/*
 * Modern Admin Login Page
 */

global $koneksi_db;

// Jika disubmit
$login = '';
if (isset($_POST['submit_login']) && @$_POST['loguser'] == 1) {
    $login .= cms_loginadmin();
}

$is_logged_in = cek_login();

// Auto redirect jika sudah login
if ($is_logged_in && !isset($_POST['submit_login'])) {
    header("Location: admin.php");
    exit;
}
?>

<?php /* ── CSS Override untuk Fullpage / Hilangkan Sidebar ── */ ?>
<style>
/* Sembunyikan container sidebar dan elemen lain yang tidak perlu di page login admin */
.blog-right { display: none !important; }
.col-sm-8.blog-left { width: 100% !important; padding: 0 !important; }
.blog-wrapper { margin: 0 !important; padding: 0 !important; background: transparent !important; border: none !important; }
.container-bg { background: transparent !important; box-shadow: none !important; }
.breadcrumb-wrapper { display: none !important; }
.inner-page-header { display: none !important; } /* Hilangkan header Halaman Dashboard hijau */

/* Variables dari Tema Utama */
:root {
    --moss-dark   : #306238;
    --moss-mid    : #618D4F;
    --moss-light  : #9EBB97;
    --moss-bg     : #DDE5CD;
    --moss-olive  : #545837;
    --text-dark   : #1e2d20;
    --text-muted  : #5a6b5c;
    --white       : #ffffff;
}

.login-page-wrap {
    min-height: calc(100vh - 80px);
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--moss-bg) 0%, rgba(255,255,255,1) 100%);
    padding: 40px 20px;
    position: relative;
    overflow: hidden;
}

/* Dekorasi background halus */
.login-page-wrap::before, .login-page-wrap::after {
    content: ''; position: absolute; border-radius: 50%; z-index: 0;
}
.login-page-wrap::before {
    width: 600px; height: 600px;
    background: linear-gradient(135deg, var(--moss-light), transparent);
    opacity: 0.15; top: -200px; left: -200px;
}
.login-page-wrap::after {
    width: 400px; height: 400px;
    background: linear-gradient(135deg, var(--moss-dark), transparent);
    opacity: 0.08; bottom: -100px; right: -100px;
}

.login-card {
    background: var(--white);
    width: 100%;
    max-width: 440px;
    border-radius: 20px;
    padding: 50px 40px;
    box-shadow: 0 20px 40px rgba(48,98,56,0.12), 0 1px 3px rgba(0,0,0,0.05);
    position: relative;
    z-index: 10;
    text-align: center;
}

.login-header h2 {
    font-size: 26px;
    font-weight: 800;
    color: var(--moss-dark);
    margin: 0 0 8px;
    letter-spacing: -0.5px;
}

.login-header p {
    color: var(--text-muted);
    font-size: 14.5px;
    margin: 0 0 32px;
    line-height: 1.5;
}

/* Form Styles */
.login-form { text-align: left; }
.form-group { margin-bottom: 22px; position: relative; }
.form-group label {
    display: block; font-size: 13px; font-weight: 700;
    color: var(--text-dark); margin-bottom: 8px;
}
.form-group input {
    width: 100%;
    background: #f7f9f6;
    border: 2px solid transparent;
    padding: 14px 16px;
    border-radius: 12px;
    font-size: 15px;
    color: var(--text-dark);
    transition: all 0.3s ease;
    outline: none;
}
.form-group input:focus {
    background: var(--white);
    border-color: var(--moss-mid);
    box-shadow: 0 0 0 4px rgba(97,141,79,0.15);
}

.btn-login {
    width: 100%;
    background: linear-gradient(135deg, var(--moss-dark), var(--moss-olive));
    color: var(--white);
    border: none;
    padding: 16px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 10px;
}
.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(48,98,56,0.25);
}
.btn-login:active { transform: translateY(0); }

/* System errors */
.system-msg {
    margin-bottom: 20px; font-size: 14px;
}
</style>

<div class="login-page-wrap">
    <div class="login-card">
        
        <div class="login-header">
            <h2>Admin Portal</h2>
            <p>Silakan masuk untuk mengelola konten dan sistem manajemen IAI PI Bandung.</p>
        </div>

        <div class="system-msg">
            <?= $login ?>
        </div>

        <form method="post" action="" class="login-form">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required autofocus autocomplete="off">
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan kata sandi" required>
            </div>
            
            <input type="hidden" value="1" name="loguser">
            <button type="submit" name="submit_login" class="btn-login">
                <svg viewBox="0 0 24 24" style="width:20px;height:20px;fill:currentColor"><path d="M10 17l5-5-5-5v10z"/><path d="M0 24V0h24v24H0z" fill="none"/></svg>
                Masuk ke Dashboard
            </button>
        </form>

    </div>
</div>
