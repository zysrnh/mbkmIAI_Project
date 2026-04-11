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

<li  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-16192 kingster-normal-menu">
                        <a href="#">Konten  </a>
            
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


<li  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-16192 kingster-normal-menu">
                        <a href="#">Modul  </a>
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
		
		
		
<li  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-16192 kingster-normal-menu">
                        <a href="#">Interaktif  </a>
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
		


		
		
<li  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-16192 kingster-normal-menu">
                        <a href="#">Gallery  </a>
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


} elseif ($_SESSION['LevelAkses']=="PMB"){ 
$user = $_SESSION['UserName'];

echo '
<li><a href="index.php?pilih=user&amp;aksi=change"> Password</a></li>

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
					                       									   
		}	elseif ($_SESSION['LevelAkses']=="Editor"){ 
$user = $_SESSION['UserName'];

echo '
<li><a href="index.php?pilih=user&amp;aksi=change"> Password</a></li>
<li><a href="admin.php?pilih=artikel&modul=yes"> Artikel</a></li>
<li><a href="forum.html"> Forum</a></li>
<li><a href="index.php?aksi=logout">Keluar</a></li>
';
					                       									   
		}								   
										   
			else { 
$user = $_SESSION['UserName'];
$nomorx = md5($user);		


		
$propinsi12xx2us = $koneksi_db->sql_query("SELECT * FROM pengguna WHERE user='$user'");
while($p11xx2us=$koneksi_db->sql_fetchrow($propinsi12xx2us)){
	$berkasnama = $p11xx2us['nama'];

}		






echo '










<li><a href="admin.php?pilih=pmb&modul=yes" > Edit Data '.$berkasnama.'</a></li>


 <li><a href="admin.php?pilih=konfirmasi&modul=yes" > Pembayaran</a></li>


<li  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-16192 kingster-normal-menu"><a href="#"><i class="fa fa-print"></i>
            Cetak Data </a>
        <ul class="sub-menu">
			
<li><a href="#" onclick=\'event.stopPropagation(); bukajendela("bukti.php?id='.$nomorx.'");\'><i class="fa fa-print"></i> Bukti Pendaftaran</a></li>
<li><a href="#" onclick=\'event.stopPropagation(); bukajendela("usm.php?id='.$nomorx.'");\'><i class="fa fa-print"></i> Kartu USMs</a></li>
				
            </ul>
        </li>
		






		 <li><a href="admin.php?pilih=usm&modul=yes" >Status USM</a>
        </li>





















<li><a href="index.php?aksi=logout">Keluar</a></li>
';
					                       									   
		}								   
										   


} 
	


?>