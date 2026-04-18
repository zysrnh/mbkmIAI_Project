<?php
/**
 * Student Registration - Matching Admin Aesthetics
 */
if (session_status() === PHP_SESSION_NONE) {
    session_name("Login");
    session_start();
}

if (!isset($koneksi_db)) {
    if (!defined('cms-KOMPONEN')) define('cms-KOMPONEN', true);
    if (!defined('cms-KONTEN'))   define('cms-KONTEN', true);
    if (!defined('cms-FUNGSI'))   define('cms-FUNGSI', true);
    @include_once 'ikutan/config.php';
    @include_once 'ikutan/mysqli.php';
    @include_once 'ikutan/fungsi.php';
}

$msg = ''; $err = '';

if (isset($_POST['submit_register'])) {
    $nama  = trim(strip_tags($_POST['nama']));
    $uname = trim(strip_tags($_POST['username']));
    $email = trim(strip_tags($_POST['email']));
    $telp  = trim(strip_tags($_POST['telp']));
    $alamat= trim(strip_tags($_POST['alamat']));
    $pass  = md5(trim($_POST['password']));
    
    // Cek username unik
    $cek = $koneksi_db->sql_query("SELECT user FROM pengguna WHERE user='$uname'");
    if ($koneksi_db->sql_numrows($cek) > 0) {
        $err = "Username '$uname' sudah terpakai. Pilih yang lain.";
    } else {
        $ins = $koneksi_db->sql_query("INSERT INTO pengguna (user, password, email, level, tipe, nama, telp, alamat) VALUES ('$uname', '$pass', '$email', 'User', 'aktif', '$nama', '$telp', '$alamat')");
        if ($ins) {
            $msg = "Akun berhasil dibuat! Silakan login.";
        } else {
            $err = "Gagal mendaftar. Silakan hubungi admin.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa — MBKM IAI PI Bandung</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
        --primary-900: #1a3a20; --primary-800: #1e4d27; --primary-700: #256830;
        --primary-600: #2d7a3a; --primary-500: #38934a; --primary-400: #4caf5c;
        --primary-50: #e8f5e9; --white: #ffffff;
        --text-primary: #1b2e1f; --text-secondary: #5a6e5e; --text-muted: #8a9a8e;
        --ease: cubic-bezier(.4,1,.2,1);
    }
    body { font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; background: var(--primary-900); overflow-x: hidden; }
    .login-left { flex: 1; background: linear-gradient(160deg, var(--primary-900) 0%, #0d1f12 50%, var(--primary-800) 100%); display: flex; align-items: center; justify-content: center; position: relative; }
    .grid-dots { position: absolute; inset: 0; background-image: radial-gradient(rgba(255,255,255,.04) 1px, transparent 1px); background-size: 32px 32px; }
    .left-content { position: relative; z-index: 2; text-align: center; max-width: 420px; padding: 40px; }
    .left-icon { width: 72px; height: 72px; background: linear-gradient(135deg, var(--primary-500), var(--primary-300)); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 28px; box-shadow: 0 12px 40px rgba(56,147,74,.3); }
    .left-icon svg { width: 36px; height: 36px; fill: #fff; }
    .left-content h1 { font-size: 28px; font-weight: 900; color: #fff; margin-bottom: 12px; }
    .left-content p { font-size: 15px; color: rgba(255,255,255,.45); line-height: 1.7; }

    .login-right { width: 560px; flex-shrink: 0; background: var(--white); display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 50px; position: relative; overflow-y: auto; }
    .login-form-wrap { width: 100%; max-width: 400px; }
    .form-header { margin-bottom: 30px; }
    .form-header .badge { display: inline-flex; align-items: center; gap: 5px; background: var(--primary-50); color: var(--primary-600); font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 6px; margin-bottom: 12px; text-transform: uppercase; }
    .form-header h2 { font-size: 24px; font-weight: 800; color: var(--text-primary); margin-bottom: 6px; }
    .msg-ok { background: #e8f5e9; color: #2e7d32; padding: 12px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; margin-bottom: 20px; border: 1px solid #c8e6c9; }
    .msg-err { background: #fbe9e7; color: #bf360c; padding: 12px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; margin-bottom: 20px; border: 1px solid #ffccbc; }

    .field { margin-bottom: 15px; }
    .field label { display: block; font-size: 11px; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px; text-transform: uppercase; }
    .field input { width: 100%; padding: 11px 16px; background: #f8faf7; border: 2px solid #e8ede6; border-radius: 10px; font-size: 13.5px; outline: none; transition: all .2s; }
    .field input:focus { border-color: var(--primary-400); background: #fff; box-shadow: 0 0 0 4px rgba(76,175,92,.1); }

    .btn-submit { width: 100%; padding: 14px; background: linear-gradient(135deg, var(--primary-800), var(--primary-600)); color: #fff; border: none; border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer; transition: all .3s; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 16px rgba(30,77,39,.2); margin-top: 10px; }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(30,77,39,.3); }

    .form-footer { margin-top: 24px; text-align: center; font-size: 13px; color: var(--text-muted); }
    .form-footer a { color: var(--primary-600); text-decoration: none; font-weight: 700; }

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
        <h1>Registrasi Akun</h1>
        <p>Bergabunglah dengan program MBKM IAI PI Bandung untuk pengalaman belajar di luar kampus yang berkesan.</p>
    </div>
</div>

<div class="login-right">
    <div class="login-form-wrap">
        <div class="form-header">
            <div class="badge">Buat Akun Baru</div>
            <h2>Daftar Mahasiswa</h2>
            <p>Lengkapi data diri Anda sesuai identitas kampus.</p>
        </div>

        <?php if ($msg): ?><div class="msg-ok"><?php echo $msg; ?></div><?php endif; ?>
        <?php if ($err): ?><div class="msg-err"><?php echo $err; ?></div><?php endif; ?>

        <form method="post" action="">
            <div class="field">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Sesuai KTP/KTM" required>
            </div>
            <div class="field">
                <label>Username</label>
                <input type="text" name="username" placeholder="Gunakan NIM atau Nama Unik" required>
            </div>
            <div class="field">
                <label>Alamat Email</label>
                <input type="email" name="email" placeholder="contoh@iaipi.ac.id" required>
            </div>
            <div class="field">
                <label>Nomor Telepon / WA</label>
                <input type="text" name="telp" placeholder="0812xxxxxxxx" required>
            </div>
            <div class="field">
                <label>Alamat Rumah</label>
                <input type="text" name="alamat" placeholder="Alamat lengkap saat ini" required>
            </div>
            <div class="field">
                <label>Kata Sandi</label>
                <input type="password" name="password" placeholder="Buat sandi yang kuat" required>
            </div>

            <button type="submit" name="submit_register" class="btn-submit">Daftar Sekarang</button>
        </form>

        <div class="form-footer">
            Sudah punya akun? <a href="login.php">Login di sini</a><br><br>
            <a href="index.php">&larr; Beranda MBKM</a>
        </div>
    </div>
</div>

</body>
</html>
