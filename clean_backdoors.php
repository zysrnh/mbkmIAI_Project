<?php
/**
 * Backdoor Automatic Cleanup Script for MBKM IAI PI Bandung
 * This script recursively scans the upload directories and deletes known PHP backdoors and polyglot files.
 * IMPORTANT: Delete this file from the server after running it!
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h3>Automatic Backdoor Cleanup Tool</h3>";

// List of exact file paths to delete if found relative to root
$targets_to_delete = [
    'zz_cek_admin.php',
    'patch_login.php',
    'rollback_login.php',
    'test_db.php',
    'images/slides/ada.php',
    'images/pages/aa.php'
];

$deleted_count = 0;

// Delete specific target files
foreach ($targets_to_delete as $target) {
    if (file_exists($target)) {
        if (@unlink($target)) {
            echo "<span style='color:green;'>[Dihapus]</span> File target utama: $target<br>";
            $deleted_count++;
        } else {
            echo "<span style='color:red;'>[Gagal]</span> Gagal menghapus file target: $target<br>";
        }
    }
}

// Recursive scan function for images and files directory
function scan_and_clean($dir) {
    global $deleted_count;
    
    if (!is_dir($dir)) return;
    
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        
        $path = $dir . '/' . $item;
        
        if (is_dir($path)) {
            scan_and_clean($path);
        } else {
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $filename = strtolower($item);
            
            $should_delete = false;
            $reason = "";
            
            // 1. Check for PHP/script extensions inside upload folders
            if (in_array($ext, ['php', 'php56', 'phtml', 'php5', 'phps', 'pht'])) {
                // Keep standard empty index.php files
                if ($filename === 'index.php') {
                    $content = @file_get_contents($path);
                    if (trim($content) !== '' && !preg_match('/^\s*<\?php\s*(\/\/\s*Silence\s+is\s+golden)?\s*\?>?\s*$/i', $content)) {
                        $should_delete = true;
                        $reason = "index.php berisi script mencurigakan";
                    }
                } else {
                    $should_delete = true;
                    $reason = "File script PHP berada di folder upload ($ext)";
                }
            } 
            // 2. Check for double extension bypasses (e.g. index.php.jpg, ucing.php.jpg)
            elseif (preg_match('/\.php\.[a-z]+$/i', $item)) {
                $should_delete = true;
                $reason = "File bypass ekstensi ganda (.php.jpg)";
            }
            // 3. Scan JPEG/PNG files for PHP polyglot signatures
            elseif (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                $content = @file_get_contents($path);
                if ($content !== false) {
                    // Check for common backdoor tags in image files
                    if (strpos($content, '<?php') !== false || strpos($content, 'Anarcho}{ploit') !== false || strpos($content, 'eval("?>"') !== false) {
                        $should_delete = true;
                        $reason = "Polyglot image (mengandung tag PHP atau signature backdoor)";
                    }
                }
            }
            
            // Execute deletion
            if ($should_delete) {
                if (@unlink($path)) {
                    echo "<span style='color:green;'>[Dihapus]</span> $path ($reason)<br>";
                    $deleted_count++;
                } else {
                    echo "<span style='color:red;'>[Gagal]</span> Gagal menghapus: $path ($reason)<br>";
                }
            }
        }
    }
}

echo "Memindai direktori <b>images/</b>...<br>";
scan_and_clean('images');

echo "Memindai direktori <b>files/</b>...<br>";
scan_and_clean('files');

echo "<br><b>Total file backdoor/berbahaya yang berhasil dihapus: $deleted_count</b><br><br>";

// Self-destruct for security
echo "Menghapus file script pembersih ini secara otomatis demi keamanan... ";
if (@unlink(__FILE__)) {
    echo "<span style='color:green; font-weight:bold;'>Berhasil dihapus!</span><br>";
} else {
    echo "<span style='color:orange; font-weight:bold;'>Gagal menghapus otomatis. Harap HAPUS file 'clean_backdoors.php' ini secara manual sekarang juga!</span><br>";
}
?>
