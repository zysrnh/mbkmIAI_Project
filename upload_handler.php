<?php
/**
 * CKEditor Image Upload Handler
 */
include "ikutan/session.php";
include "ikutan/config.php";

// Restrict to Administrator or Editor roles only
if (!isset($_SESSION['UserName']) || !isset($_SESSION['LevelAkses']) || !in_array($_SESSION['LevelAkses'], array('Administrator', 'Editor'))) {
    header('HTTP/1.1 403 Forbidden');
    exit('Akses Ditolak');
}

if (isset($_FILES['upload'])) {
    $file = $_FILES['upload']['tmp_name'];
    $file_name = $_FILES['upload']['name'];
    
    // Validate image format with getimagesize
    $image_info = @getimagesize($file);
    if ($image_info === false) {
        header('HTTP/1.1 400 Bad Request');
        exit('File bukan gambar valid');
    }
    
    $file_name_array = explode(".", $file_name);
    $extension = strtolower(end($file_name_array));
    $new_image_name = 'content_' . time() . '.' . $extension;
    
    $allowed_extension = array("jpg", "gif", "png", "jpeg", "webp");
    
    if (in_array($extension, $allowed_extension)) {
        // Create directory if not exists
        if (!is_dir('images/content')) {
            mkdir('images/content', 0755, true);
        }
        
        $dest_path = 'images/content/' . $new_image_name;
        $uploaded = false;
        
        // Re-create the image using GD library to strip any hidden PHP polyglot payloads/metadata
        if (function_exists('imagecreatefromjpeg') && ($extension === 'jpg' || $extension === 'jpeg')) {
            $img = @imagecreatefromjpeg($file);
            if ($img) {
                $uploaded = @imagejpeg($img, $dest_path, 90);
                @imagedestroy($img);
            }
        } elseif (function_exists('imagecreatefrompng') && $extension === 'png') {
            $img = @imagecreatefrompng($file);
            if ($img) {
                // Keep transparency
                imagealphablending($img, false);
                imagesavealpha($img, true);
                $uploaded = @imagepng($img, $dest_path);
                @imagedestroy($img);
            }
        } elseif (function_exists('imagecreatefromgif') && $extension === 'gif') {
            $img = @imagecreatefromgif($file);
            if ($img) {
                $uploaded = @imagegif($img, $dest_path);
                @imagedestroy($img);
            }
        } elseif (function_exists('imagecreatefromwebp') && $extension === 'webp') {
            $img = @imagecreatefromwebp($file);
            if ($img) {
                $uploaded = @imagewebp($img, $dest_path);
                @imagedestroy($img);
            }
        }
        
        // Fallback to standard upload if GD is not available or failed, but still restricted to allowed extensions
        if (!$uploaded) {
            $uploaded = move_uploaded_file($file, $dest_path);
        }
        
        if ($uploaded) {
            $function_number = intval($_GET['CKEditorFuncNum']);
            $url = 'images/content/' . $new_image_name;
            $message = '';
            
            // Response format for CKEditor 4
            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            exit('Gagal menyimpan file');
        }
    } else {
        header('HTTP/1.1 400 Bad Request');
        exit('Ekstensi file tidak diizinkan');
    }
}
?>
