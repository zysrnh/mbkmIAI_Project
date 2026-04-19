<h4>Manajemen Program MBKM</h4><br/><p>
<a href="admin.php?pilih=program&amp;modul=yes">List Program</a> | 
<a href="admin.php?pilih=program&amp;modul=yes&amp;action=add">Tambah Program</a>

<?php
/**
 * Admin Module for Managing MBKM Programs
 */

if (!defined('cms-ADMINISTRATOR')) {
    Header("Location: ../index.php");
    exit;
}

include 'modul/functions.php';

$JS_SCRIPT = <<<js
<!-- TinyMCE -->
<script src="js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
        selector: "textarea#elm1",
        theme: "modern",
        width: "100%",
        height: 350,
        plugins: [
             "advlist autolink link image lists charmap print preview hr anchor pagebreak",
             "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
             "save table contextmenu directionality emoticons template paste textcolor"
       ],
       content_css: "css/content.css",
       paste_data_images: true,
       toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor emoticons",
    }); 
</script>
js;

$content = '';
$script_include[] = $JS_SCRIPT;

function create_slug($string) {
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9\-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    return trim($string, '-');
}

switch (@$_GET['action']) {

    case 'add':
        if (isset($_POST['submit'])) {
            $judul = cleantext($_POST['judul']);
            $isi = $_POST['isi'];
            $deskripsi = cleantext($_POST['deskripsi']);
            $slug = create_slug($judul);
            
            $foto = "";
            if (!empty($_FILES['image']['name'])) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $foto = $slug . "." . $ext;
                copy($_FILES['image']['tmp_name'], "./images/pages/" . $foto);
            }

            $insert = $koneksi_db->sql_query("INSERT INTO `mod_program` (`judul`, `slug`, `deskripsi_singkat`, `isi`, `gambar`) VALUES ('$judul', '$slug', '$deskripsi', '$isi', '$foto')");
            
            if ($insert) {
                $content .= '<div class="sukses">Program berhasil ditambahkan!</div>';
            } else {
                $content .= '<div class="error">Gagal menambah data: ' . mysql_error() . '</div>';
            }
        }

        $content .= '
        <form method="POST" action="" enctype="multipart/form-data">
        <table class="table">
            <tr><td>Judul Program</td><td>:</td><td><input type="text" name="judul" class="form-control" required></td></tr>
            <tr><td>Deskripsi Singkat</td><td>:</td><td><textarea name="deskripsi" class="form-control" rows="3"></textarea></td></tr>
            <tr><td colspan="3"><textarea id="elm1" name="isi" style="width:100%"></textarea></td></tr>
            <tr><td>Gambar Utama</td><td>:</td><td><input name="image" type="file" class="form-control"></td></tr>
            <tr><td></td><td></td><td><input type="submit" name="submit" value="Simpan Program" class="btn btn-primary"></td></tr>
        </table>
        </form>';
        break;

    case 'edit':
        $id = int_filter($_GET['id']);
        if (isset($_POST['submit'])) {
            $judul = cleantext($_POST['judul']);
            $isi = $_POST['isi'];
            $deskripsi = cleantext($_POST['deskripsi']);
            $slug = create_slug($judul);
            
            $foto_sql = "";
            if (!empty($_FILES['image']['name'])) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $foto = $slug . "." . $ext;
                copy($_FILES['image']['tmp_name'], "./images/pages/" . $foto);
                $foto_sql = ", `gambar`='$foto'";
            }

            $update = $koneksi_db->sql_query("UPDATE `mod_program` SET `judul`='$judul', `slug`='$slug', `deskripsi_singkat`='$deskripsi', `isi`='$isi' $foto_sql WHERE `id`='$id'");
            
            if ($update) {
                $content .= '<div class="sukses">Program berhasil diupdate!</div>';
            } else {
                $content .= '<div class="error">Gagal update data.</div>';
            }
        }

        $res = $koneksi_db->sql_query("SELECT * FROM `mod_program` WHERE `id`='$id'");
        $data = $koneksi_db->sql_fetchrow($res);

        $content .= '
        <form method="POST" action="" enctype="multipart/form-data">
        <table class="table">
            <tr><td>Judul Program</td><td>:</td><td><input type="text" name="judul" value="'.$data['judul'].'" class="form-control" required></td></tr>
            <tr><td>Deskripsi Singkat</td><td>:</td><td><textarea name="deskripsi" class="form-control" rows="3">'.$data['deskripsi_singkat'].'</textarea></td></tr>
            <tr><td colspan="3"><textarea id="elm1" name="isi" style="width:100%">'.htmlspecialchars($data['isi']).'</textarea></td></tr>
            <tr><td>Gambar Utama</td><td>:</td><td>';
        if($data['gambar']) $content .= '<img src="images/pages/'.$data['gambar'].'" width="100"><br>';
        $content .= '<input name="image" type="file" class="form-control"></td></tr>
            <tr><td></td><td></td><td><input type="submit" name="submit" value="Update Program" class="btn btn-primary"></td></tr>
        </table>
        </form>';
        break;

    case 'delete':
        $id = int_filter($_GET['id']);
        $koneksi_db->sql_query("DELETE FROM `mod_program` WHERE `id`='$id'");
        header("Location: admin.php?pilih=program&modul=yes");
        break;

    default:
        $content .= '<table class="table table-striped">
            <thead><tr><th>No</th><th>Judul</th><th>Slug</th><th>Aksi</th></tr></thead>
            <tbody>';
        $res = $koneksi_db->sql_query("SELECT * FROM `mod_program` ORDER BY id DESC");
        $no = 1;
        while ($row = $koneksi_db->sql_fetchrow($res)) {
            $content .= '<tr>
                <td>'.$no++.'</td>
                <td>'.$row['judul'].'</td>
                <td>'.$row['slug'].'</td>
                <td>
                    <a href="admin.php?pilih=program&modul=yes&action=edit&id='.$row['id'].'" class="btn btn-xs btn-warning">Edit</a>
                    <a href="admin.php?pilih=program&modul=yes&action=delete&id='.$row['id'].'" onclick="return confirm(\'Yakin hapus?\')" class="btn btn-xs btn-danger">Hapus</a>
                </td>
            </tr>';
        }
        $content .= '</tbody></table>';
        break;
}

echo $content;
?>
