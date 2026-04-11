<?php
$koneksi = @mysqli_connect('localhost', 'iais9713_mbkm', '~,1i);8U%LZRzo!.', 'iais9713_mbkm');
if (!$koneksi) { die("<h3 style='color:red'>Gagal koneksi ke database.</h3>"); }

echo "<div style='font-family:sans-serif; background:#f4f4f4; padding:20px; border-radius:8px; max-width:400px; margin:50px auto; border:1px solid #ddd;'>";
echo "<h3>Reset Akses Admin</h3>";

$query = "SELECT user FROM pengguna WHERE level='Administrator' LIMIT 1";
$result = mysqli_query($koneksi, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $username = $row['user'];
    $new_pass = md5('admin123'); // Password baru
    $update = "UPDATE pengguna SET password='$new_pass' WHERE user='$username'";
    mysqli_query($koneksi, $update);
    
    echo "<p>Akun administrator berhasil ditemukan dan password sudah saya reset.</p>";
    echo "<ul style='font-size:18px;'>";
    echo "<li><b>Username:</b> <code style='background:#fff;padding:2px 6px;'>$username</code></li>";
    echo "<li><b>Password:</b> <code style='background:#fff;padding:2px 6px;'>admin123</code></li>";
    echo "</ul>";
    echo "<p><a href='login.html' style='display:inline-block; margin-top:10px; background:#4CAF50; color:white; padding:8px 16px; text-decoration:none; border-radius:4px;'>Kembali ke Login</a></p>";
} else {
    echo "<p style='color:red;'>Tidak ada akun Administrator yang ditemukan di database.</p>";
}
echo "</div>";
?>
