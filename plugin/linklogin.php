<script language="JavaScript">
function bukajendela(url) {
 window.open(url, "window_baru", "width=800,height=700,left=120,top=10,resizable=0,scrollbars=1");
}

</script><?php

if (!cek_login ())
{
include 'konten/beranda.php';
}else{
if ($_SESSION['LevelAkses']=="Administrator"){

echo '

<li  class="dropdown"><a data-toggle="dropdown" href="#">Konten  <i class="fa fa-angle-down" aria-hidden="true"></i></a>
            
		 <ul  class="dropdown-menu">
		 	<li><a   href="admin.php?pilih=profil&modul=yes"> Data Profil</a></li>
		<li><a   href="admin.php?pilih=admin_info"> Rubah Password</a></li>
<li><a   href="admin.php?pilih=pages&modul=yes"> Halaman Dinamis</a></li>
<li><a   href="admin.php?pilih=admin_menu"> Header Menu</a></li>
<li><a   href="admin.php?pilih=admin_submenumenu"> Multi Menu</a></li>
<li><a   href="admin.php?pilih=admin_menu2"> Footer Menu</a></li>
<li><a   href="admin.php?pilih=topik&modul=yes"> Topik Artikel</a></li>
<li><a   href="admin.php?pilih=artikel&modul=yes"> Buat Artikel</a></li>

<li><a   href="admin.php?pilih=slider&modul=yes"> Pengaturan Slider</a></li>
<li><a   href="admin.php?pilih=admin_setting"> Konfigurasi Website</a></li>
<li><a   href="admin.php?pilih=backup&modul=yes"> Backup dan Restore</a></li>  
            </ul>
			
</li>


<li  class="dropdown"><a data-toggle="dropdown" href="#">Modul  <i class="fa fa-angle-down" aria-hidden="true"></i></a>
           <ul  class="dropdown-menu">
			
			<li><a   href="admin.php?pilih=admin_modul"> Menejemen Modul</a></li>
<li><a   href="admin.php?pilih=admin_blok"> Widget HTML</a></li>
		
				<li><a   href="admin.php?pilih=testi&modul=yes"> Data Testimonial</a></li>
				<li><a   href="admin.php?pilih=file&modul=yes"> Penyimpanan Files</a></li>
				<li><a   href="admin.php?pilih=links&modul=yes"> Direktori  Link</a></li>
					<li><a   href="admin.php?pilih=calendar&modul=yes"> Event Kalender</a></li>
		<li><a   href="admin.php?pilih=polling&modul=yes"> Data Polling</a></li>
		<li><a   href="admin.php?pilih=shoutbox&modul=yes"> Shoutbox</a></li>		
<li><a   href="admin.php?pilih=client&modul=yes"> Banner Client</a></li>  
<li><a   href="admin.php?pilih=dosen&modul=yes"> Dosen dan Karyawan</a></li>  
<li><a   href="admin.php?pilih=meta&modul=yes"> SEO Meta Pages</a></li>  
       <li><a href="admin.php?pilih=pengaduan&modul=yes"> Pengaduan</a></li>  
	        <li><a href="admin.php?pilih=stat&modul=yes"> Statistik Layanan</a></li> 
            </ul>
        </li>
		
		
		


		
		
<li  class="dropdown"><a data-toggle="dropdown" href="#">Gallery  <i class="fa fa-angle-down" aria-hidden="true"></i></a>
           <ul  class="dropdown-menu">
		  <li><a   href="admin.php?pilih=fotokat&modul=yes"> Kategori Foto</a></li>
		<li><a   href="admin.php?pilih=foto&modul=yes"> Gallery Foto</a></li>
		<li><a   href="admin.php?pilih=video&modul=yes"> Gallery Video</a></li>

       
            </ul>
        </li>		
		
		
		
		
		
		
		
		







<li><a   href="admin.php?pilih=pengguna&modul=yes"> Pengguna</a></li>  
 





<li><a   href="index.php?aksi=logout">Keluar</a></li>




			



'; 


} elseif ($_SESSION['LevelAkses']=="Editor"){ 
$user = $_SESSION['UserName'];

echo '
<li><a   href="index.php?pilih=user&amp;aksi=change"> Password</a></li>
<li><a   href="admin.php?pilih=artikel&modul=yes"> Artikel</a></li>
<li><a   href="forum.html"> Forum</a></li>
<li><a   href="index.php?aksi=logout">Keluar</a></li>
';
					                       									   
		}								   
										   
			else { 
$user = $_SESSION['UserName'];

echo '
<li><a   href="index.php?pilih=user&amp;aksi=change"> Password</a></li>
<li><a   href="admin.php?pilih=artikel&modul=yes"> Artikel</a></li>

<li  class="dropdown"><a data-toggle="dropdown" href="#">Interaktif  <i class="fa fa-angle-down" aria-hidden="true"></i></a>
           <ul  class="dropdown-menu">
			
			
		
			<li><a   href="testimonial.html">Testimonial</a></li>
						<li><a    href="direktori-link">Weblinks</a></li>
       	<li><a    href="file-sharing.html">File Sharing</a></li>
		    	<li><a    href="gallery.html">Gallery Foto</a></li>
            </ul>
        </li>
		


						
											
<li><a   href="forum.html"> Forum</a></li>
<li><a   href="index.php?aksi=logout">Keluar</a></li>
';
					                       									   
		}								   
										   


} 
	


?>