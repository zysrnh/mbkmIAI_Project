<?php
if (!defined('cms-ADMINISTRATOR')) {
    Header("Location: ../index.php");
    exit;
}

include 'modul/functions.php';

// Auto-create table if not exists
global $koneksi_db;
$sql_create = "CREATE TABLE IF NOT EXISTS `mod_tim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `instansi` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(50) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `urutan` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$koneksi_db->sql_query($sql_create);

$content = '<h4>Manajemen Tim MBKM</h4><br/><p>
<a href="admin.php?pilih=tim&amp;modul=yes">List Tim</a> | 
<a href="admin.php?pilih=tim&amp;modul=yes&amp;action=add">Tambah Tim</a>
</p><hr/>';

// --- SCRIPTS ---
$JS_SCRIPT = '
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script type="text/javascript">
function initCropper() {
    const input = document.getElementById("imageInput");
    const previewArea = document.getElementById("cropperArea");
    const cropImg = document.getElementById("cropImg");
    const base64Input = document.getElementById("image_base64");
    let cropper;

    if(!input) return;

    input.addEventListener("change", function(e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const reader = new FileReader();
            reader.onload = function(event) {
                cropImg.src = event.target.result;
                previewArea.style.display = "block";
                if (cropper) cropper.destroy();
                cropper = new Cropper(cropImg, {
                    aspectRatio: 1, // KITA MAH FOTONYA PERSEGI AJA
                    viewMode: 1,
                    ready: function() { updateBase64(); }
                });
                cropper.on("cropend", updateBase64);
                cropper.on("zoom", updateBase64);
            };
            reader.readAsDataURL(files[0]);
        }
    });

    function updateBase64() {
        const canvas = cropper.getCroppedCanvas({ width: 600, height: 600 });
        base64Input.value = canvas.toDataURL("image/jpeg", 0.9);
    }
}
window.onload = initCropper;
</script>
<style>
#cropperArea { max-width: 400px; margin-top: 15px; border: 1px solid #ddd; padding: 10px; background: #f9f9f9; }
#cropImg { max-width: 100%; display: block; }
</style>
';

global $script_include;
if(!isset($script_include)) $script_include = array();
$script_include[] = $JS_SCRIPT;

function create_slug($string) {
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9\-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    return trim($string, '-');
}

function save_base64_image($base64_string, $output_file) {
    $data = explode(',', $base64_string);
    if (count($data) > 1) {
        file_put_contents($output_file, base64_decode($data[1]));
        return true;
    }
    return false;
}

switch (@$_GET['action']) {

    case 'add':
        if (isset($_POST['submit'])) {
            $nama = cleantext($_POST['nama']);
            $jabatan = cleantext($_POST['jabatan']);
            $instansi = cleantext($_POST['instansi']);
            $whatsapp = cleantext($_POST['whatsapp']);
            $urutan = intval($_POST['urutan']);
            $slug = create_slug($nama);
            
            $foto = "";
            if (!empty($_POST['image_base64'])) {
                $foto = "tim_".$slug."_".time().".jpg";
                save_base64_image($_POST['image_base64'], "./images/pages/" . $foto);
            } elseif (!empty($_FILES['image']['name'])) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $foto = "tim_".$slug."_".time().".".$ext;
                copy($_FILES['image']['tmp_name'], "./images/pages/" . $foto);
            }

            $insert = $koneksi_db->sql_query("INSERT INTO `mod_tim` (`nama`, `jabatan`, `instansi`, `whatsapp`, `urutan`, `slug`, `foto`) VALUES ('$nama', '$jabatan', '$instansi', '$whatsapp', '$urutan', '$slug', '$foto')");
            if ($insert) { $content .= '<div class="sukses">Anggota Tim berhasil ditambahkan!</div>'; }
            else { $content .= '<div class="error">Gagal menambah data.</div>'; }
        }

        $content .= '
        <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="image_base64" id="image_base64">
        <table class="table">
            <tr><td>Nama Lengkap (beserta gelar)</td><td>:</td><td><input type="text" name="nama" class="form-control" required></td></tr>
            <tr><td>Jabatan (Contoh: Staf Biro MBKM)</td><td>:</td><td><input type="text" name="jabatan" class="form-control" required></td></tr>
            <tr><td>Instansi / Kampus</td><td>:</td><td><input type="text" name="instansi" class="form-control"></td></tr>
            <tr><td>No WhatsApp (628...)</td><td>:</td><td><input type="text" name="whatsapp" class="form-control" placeholder="628123456789"></td></tr>
            <tr><td>Urutan Tampil (Angka)</td><td>:</td><td><input type="number" name="urutan" value="0" class="form-control"></td></tr>
            <tr><td>Foto Pribadi (Persegi)</td><td>:</td><td>
                <input id="imageInput" name="image" type="file" class="form-control">
                <div id="cropperArea" style="display:none;">
                    <p style="font-size:11px; color:green;">* Geser kotak untuk mengatur potongan gambar (Crop 1:1 Persegi)</p>
                    <img id="cropImg">
                </div>
            </td></tr>
            <tr><td></td><td></td><td><input type="submit" name="submit" value="Simpan Anggota" class="btn btn-primary"></td></tr>
        </table>
        </form>';
        break;

    case 'edit':
        $id = int_filter($_GET['id']);
        if (isset($_POST['submit'])) {
            $nama = cleantext($_POST['nama']);
            $jabatan = cleantext($_POST['jabatan']);
            $instansi = cleantext($_POST['instansi']);
            $whatsapp = cleantext($_POST['whatsapp']);
            $urutan = intval($_POST['urutan']);
            $slug = create_slug($nama);
            
            $foto_sql = "";
            if (!empty($_POST['image_base64'])) {
                $foto = "tim_".$slug."_".time().".jpg";
                save_base64_image($_POST['image_base64'], "./images/pages/" . $foto);
                $foto_sql = ", `foto`='$foto'";
            } elseif (!empty($_FILES['image']['name'])) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $foto = "tim_".$slug."_".time().".".$ext;
                copy($_FILES['image']['tmp_name'], "./images/pages/" . $foto);
                $foto_sql = ", `foto`='$foto'";
            }

            $update = $koneksi_db->sql_query("UPDATE `mod_tim` SET `nama`='$nama', `jabatan`='$jabatan', `instansi`='$instansi', `whatsapp`='$whatsapp', `urutan`='$urutan', `slug`='$slug' $foto_sql WHERE `id`='$id'");
            if ($update) { $content .= '<div class="sukses">Anggota Tim berhasil diupdate!</div>'; }
            else { $content .= '<div class="error">Gagal update data.</div>'; }
        }

        $res = $koneksi_db->sql_query("SELECT * FROM `mod_tim` WHERE `id`='$id'");
        $data = $koneksi_db->sql_fetchrow($res);

        $content .= '
        <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="image_base64" id="image_base64">
        <table class="table">
            <tr><td>Nama Lengkap</td><td>:</td><td><input type="text" name="nama" value="'.htmlspecialchars($data['nama']).'" class="form-control" required></td></tr>
            <tr><td>Jabatan</td><td>:</td><td><input type="text" name="jabatan" value="'.htmlspecialchars($data['jabatan']).'" class="form-control" required></td></tr>
            <tr><td>Instansi</td><td>:</td><td><input type="text" name="instansi" value="'.htmlspecialchars($data['instansi']).'" class="form-control"></td></tr>
            <tr><td>No WhatsApp</td><td>:</td><td><input type="text" name="whatsapp" value="'.htmlspecialchars($data['whatsapp']).'" class="form-control"></td></tr>
            <tr><td>Urutan Tampil</td><td>:</td><td><input type="number" name="urutan" value="'.$data['urutan'].'" class="form-control"></td></tr>
            <tr><td>Foto Pribadi</td><td>:</td><td>';
        if($data['foto']) $content .= '<img src="images/pages/'.$data['foto'].'" width="150" style="border-radius:4px; margin-bottom:10px;"><br>';
        $content .= '   <input id="imageInput" name="image" type="file" class="form-control">
                        <div id="cropperArea" style="display:none;">
                            <p style="font-size:11px; color:green;">* Geser kotak untuk mengatur potongan gambar (Crop 1:1 Persegi)</p>
                            <img id="cropImg">
                        </div>
                    </td></tr>
            <tr><td></td><td></td><td><input type="submit" name="submit" value="Update Anggota" class="btn btn-primary"></td></tr>
        </table>
        </form>';
        break;

    case 'delete':
        $id = int_filter($_GET['id']);
        $koneksi_db->sql_query("DELETE FROM `mod_tim` WHERE `id`='$id'");
        header("Location: admin.php?pilih=tim&modul=yes");
        exit;
        break;

    default:
        $content .= '<table class="table table-striped">
            <thead><tr><th>No</th><th>Foto</th><th>Nama</th><th>Jabatan</th><th>Urutan</th><th>Aksi</th></tr></thead>
            <tbody>';
        $res = $koneksi_db->sql_query("SELECT * FROM `mod_tim` ORDER BY urutan ASC, id DESC");
        $no = 1;
        while ($row = $koneksi_db->sql_fetchrow($res)) {
            $img = !empty($row['foto']) ? 'images/pages/'.$row['foto'] : 'images/no-image.jpg';
            $content .= '<tr>
                <td>'.$no++.'</td>
                <td><img src="'.$img.'" width="50" height="50" style="object-fit:cover; border-radius:50%;"></td>
                <td>'.$row['nama'].'</td>
                <td>'.$row['jabatan'].'</td>
                <td>'.$row['urutan'].'</td>
                <td>
                    <a href="admin.php?pilih=tim&modul=yes&action=edit&id='.$row['id'].'" class="btn btn-xs btn-warning">Edit</a>
                    <a href="admin.php?pilih=tim&modul=yes&action=delete&id='.$row['id'].'" onclick="return confirm(\'Yakin hapus anggota ini?\')" class="btn btn-xs btn-danger">Hapus</a>
                </td>
            </tr>';
        }
        $content .= '</tbody></table>';
        break;
}

echo $content;
?>
