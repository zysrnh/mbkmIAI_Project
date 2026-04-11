<?php
// LANGKAH 1: SEMUA LOGIKA PHP KITA TARUH DI ATAS
// Variabel ini akan kita isi nanti di dalam blok if/else
$nomorx = '';

// Cek status login
if (cek_login()) {
    // Jika user sudah login, tentukan nilai $nomorx jika level aksesnya adalah pengguna biasa
    if ($_SESSION['LevelAkses'] != "Administrator" && $_SESSION['LevelAkses'] != "Editor") {
        $user = $_SESSION['UserName'];
        $nomorx = md5($user);
    }
}
?>

    <script language="JavaScript">
        // Fungsi ini bisa kita letakkan di sini.
        function bukajendela(url) {
            window.open(url, "window_baru", "width=800,height=700,left=120,top=10,resizable=0,scrollbars=1");
        }
    </script>

    <script type="text/javascript">
        // Gunakan jQuery. Tanda $ adalah alias untuk jQuery.
        jQuery(document).ready(function($) {

            // Beri penundaan untuk memastikan menu seluler selesai dibuat.
            setTimeout(function() {

                // Definisikan URL di sini. Sekarang $nomorx PASTI sudah ada isinya.
                var urlBukti = "bukti.php?id=<?php echo $nomorx; ?>";
                var urlUsm = "usm.php?id=<?php echo $nomorx; ?>";

                // Hanya jalankan kode ini jika $nomorx tidak kosong (artinya ini pengguna biasa)
                if ("<?php echo $nomorx; ?>" !== "") {
                    // Cari span di dalam menu seluler yang berisi teks "Bukti Pendaftaran"
                    var spanBukti = $(".mm-listview span:contains('Bukti Pendaftaran')");

                    if (spanBukti.length > 0) {
                        spanBukti.css('cursor', 'pointer');
                        spanBukti.on('click', function(e) {
                            e.stopPropagation();
                            bukajendela(urlBukti);
                        });
                    }

                    // Lakukan hal yang sama untuk "Kartu USM"
                    var spanUsm = $(".mm-listview span:contains('Kartu USM')");

                    if (spanUsm.length > 0) {
                        spanUsm.css('cursor', 'pointer');
                        spanUsm.on('click', function(e) {
                            e.stopPropagation();
                            bukajendela(urlUsm);
                        });
                    }
                }

            }, 1000); // Kita beri waktu 1 detik untuk amannya.
        });
    </script>

<?php
// LANGKAH 3: BLOK ECHO UNTUK MENAMPILKAN KONTEN SESUAI KONDISI
if (!cek_login()) {
    include 'konten/beranda-mobile.php';
} else {
    if ($_SESSION['LevelAkses'] == "Administrator") {

        echo '
            <li  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-16192 kingster-normal-menu"><a href="#">Konten  </a>
                <ul class="sub-menu">
                  <li><a href="admin.php?pilih=profil&modul=yes"> Data Profil</a></li>
                  <li><a href="admin.php?pilih=admin_info"> Rubah Password</a></li>
                  <li><a href="admin.php?pilih=pages&modul=yes"> Halaman Dinamis</a></li>
                  <li><a href="admin.php?pilih=admin_menu"> Header Menu</a></li>
                  <li><a href="admin.php?pilih=admin_submenumenu"> Multi Menu</a></li>
                  <li><a href="admin.php?pilih=admin_menu2"> Footer Menu</a></li>
                  <li><a href="admin.php?pilih=topik&modul=yes"> Topik Artikel</a></li>
                  <li><a href="admin.php?pilih=artikel&modul=yes"> Buat Artikel</a></li>
                  <li><a href="admin.php?pilih=slider&modul=yes"> Pengaturan Slider</a></li>
                  <li><a href="admin.php?pilih=admin_setting"> Konfigurasi Website</a></li>
                  <li><a href="admin.php?pilih=backup&modul=yes"> Backup dan Restore</a></li>  
                </ul>
            </li>
            <li  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-16192 kingster-normal-menu"><a href="#">Modul  </a>
                <ul class="sub-menu">
                  <li><a href="admin.php?pilih=admin_modul"> Menejemen Modul</a></li>
                  <li><a href="admin.php?pilih=admin_blok"> Widget HTML</a></li>
                  <li><a href="admin.php?pilih=testi&modul=yes"> Data Testimonial</a></li>
                  <li><a href="admin.php?pilih=file&modul=yes"> Penyimpanan Files</a></li>
                  <li><a href="admin.php?pilih=links&modul=yes"> Direktori  Link</a></li>
                  <li><a href="admin.php?pilih=meta&modul=yes"> SEO Meta Pages</a></li>  
                  <li><a href="admin.php?pilih=pengguna&modul=yes"> Pengguna</a></li>  
                </ul>
            </li>
            <li  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-16192 kingster-normal-menu"><a href="#">Interaktif  </a>
                <ul class="sub-menu">
                   <li><a href="index.php?pilih=forum&modul=yes"> Forum Diskusi</a></li>
                   <li><a href="admin.php?pilih=layanan&modul=yes"> Data Layanan</a></li> 
                   <li><a href="admin.php?pilih=statistik&modul=yes"> Data Statistik</a></li>  
                   <li><a href="admin.php?pilih=calendar&modul=yes"> Event Kalender</a></li>
                   <li><a href="admin.php?pilih=polling&modul=yes"> Data Polling</a></li>
                   <li><a href="admin.php?pilih=shoutbox&modul=yes"> Shoutbox</a></li>       
                   <li><a href="admin.php?pilih=layanan2&modul=yes"> Banner Link</a></li> 
                   <li><a href="admin.php?pilih=faq&modul=yes"> FAQ</a></li>     
                   <li><a href="admin.php?pilih=pengaduan&modul=yes"> Pengaduan</a></li>  
                </ul>
            </li>
            <li  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-16192 kingster-normal-menu"><a href="#">Gallery  </a>
                <ul class="sub-menu">
                 <li><a href="admin.php?pilih=fotokat&modul=yes"> Kategori Foto</a></li>
                 <li><a href="admin.php?pilih=foto&modul=yes"> Gallery Foto</a></li>
                 <li><a href="admin.php?pilih=video&modul=yes"> Gallery Video</a></li>
                </ul>
            </li>      
            <li  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-16192 kingster-normal-menu">
                <a href="#">Data PMB </a>
                 <ul class="sub-menu"> 
                    <li><a  href="admin.php?pilih=periode&modul=yes"> Periode PMB</a></li>
                    <li><a  href="admin.php?pilih=prodi&modul=yes"> Program Studi</a></li>
                    <li><a  href="admin.php?pilih=aspek&modul=yes"> Aspek Penilaian</a></li>
                    <li><a  href="admin.php?pilih=berkas&modul=yes"> Berkas Persyaratan</a></li>
                    <li><a  href="admin.php?pilih=bayar&modul=yes"> Tagihan Pembayaran</a></li>
                    <li><a  href="admin.php?pilih=pmb&modul=yes"> Data PMB</a></li>
                    <li><a  href="admin.php?pilih=nilai&modul=yes"> Entry Nilai USM</a></li>      
                    <li><a  href="admin.php?pilih=lulus&modul=yes"> Kelulusan</a></li>    
                </ul>
            </li>
            <li  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-16192 kingster-normal-menu">
                <a href="#">Laporan </a>
                  <ul class="sub-menu"> 
                    <li><a  href="admin.php?pilih=lapbayar&modul=yes"> Pembayaran</a></li>
                    <li><a  href="admin.php?pilih=laporan&modul=yes"> Pendaftar</a></li>
                  </ul>
            </li>
            <li><a href="index.php?aksi=logout">Keluar</a></li>
        ';

    } elseif ($_SESSION['LevelAkses'] == "Editor") {

        echo '
            <li><a href="index.php?pilih=user&amp;aksi=change"> Password</a></li>
            <li><a href="admin.php?pilih=artikel&modul=yes"> Artikel</a></li>
            <li><a href="forum.html"> Forum</a></li>
            <li><a href="index.php?aksi=logout">Keluar</a></li>
        ';

    } else { // Ini adalah blok untuk pengguna biasa

        echo '
            <li><a href="index.php?pilih=user&amp;aksi=change"> Password</a></li>
            <li><a href="admin.php?pilih=pmb&modul=yes" > Edit Data </a></li>
            <li><a href="admin.php?pilih=konfirmasi&modul=yes" > Pembayaran</a></li>
            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-16192 kingster-normal-menu">
                <a href="#"><i class="fa fa-print"></i> Cetak Data</a>
                <ul class="sub-menu">
                    <li>
                        <a href="#" onclick=\'bukajendela("bukti.php?id='.$nomorx.'");\'>
                            <i class="fa fa-print"></i> Bukti Pendaftaran
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick=\'bukajendela("usm.php?id='.$nomorx.'");\'>
                            <i class="fa fa-print"></i> Kartu USM
                        </a>
                    </li>
                </ul>
            </li>
            <li><a href="admin.php?pilih=usm&modul=yes" >Status USM</a></li>
            <li><a href="index.php?aksi=logout">Keluar</a></li>
        ';
    }
}
?>