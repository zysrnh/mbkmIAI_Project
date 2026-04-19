<?php
/**
 * CKEditor Image Upload Handler
 */
include "ikutan/session.php";
include "ikutan/config.php";

if (!isset($_SESSION['UserName'])) {
    exit('Akses Ditolak');
}

if (isset($_FILES['upload'])) {
    $file = $_FILES['upload']['tmp_name'];
    $file_name = $_FILES['upload']['name'];
    $file_name_array = explode(".", $file_name);
    $extension = end($file_name_array);
    $new_image_name = 'content_' . time() . '.' . $extension;
    
    $allowed_extension = array("jpg", "gif", "png", "jpeg", "webp");
    
    if (in_array(strtolower($extension), $allowed_extension)) {
        // Buat folder jika belum ada
        if (!is_dir('images/content')) {
            mkdir('images/content', 0755, true);
        }
        
        move_uploaded_file($file, 'images/content/' . $new_image_name);
        
        $function_number = $_GET['CKEditorFuncNum'];
        $url = 'images/content/' . $new_image_name;
        $message = '';
        
        // Response format buat CKEditor 4
        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
    }
}
?>
