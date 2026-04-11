
<?php

$hasil = $koneksi_db->sql_query( "SELECT * FROM menu WHERE published=1 ORDER BY ordering" );

while ($data = $koneksi_db->sql_fetchrow($hasil)) {

        $parent= $data['id'];
        $target= "";
    $target="target=_blank";
        $link_menu = $data['menu'];
        $link_url = $data['url'];
$subhasil = $koneksi_db->sql_query( "SELECT * FROM submenu WHERE published=1 AND parent='$parent' ORDER BY ordering" );
        $jmlsub = $koneksi_db->sql_numrows( $subhasil );
		
	
		
		
if ($jmlsub>0) {
        echo ' <li  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-16192 kingster-normal-menu">
                        <a href="#">'.$link_menu.'</a>  ';
            	
} else {
	
	 echo '
            	<li>
                        <a href="'.$link_url.'" title="'.$link_menu.'">'.$link_menu.'</a>  ';
}



        

       if ($jmlsub>0) {
            echo ' 
 
                            <ul class="sub-menu">';

            while ($subdata = $koneksi_db->sql_fetchrow($subhasil)) {
                $target="";
				$parent2= $subdata['id'];
               $target="target=\"_blank\"";

				
				
				
				
				
            
				
				$subhasil2 = $koneksi_db->sql_query( "SELECT * FROM submenumenu WHERE published=1 AND parent='$parent2' ORDER BY ordering" );
        $jmlsub2 = $koneksi_db->sql_numrows($subhasil2);	
				
				
				
				
				
			if ($jmlsub2>0) {
    echo '<li  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-16193" >
                                    <a href="javascript:avoid(0);" > '.$subdata['menu'].'</a>';
				
            	
} else {
	
	 echo '
       <li><a  href="'.$subdata['url'].'" title="'.$subdata[1].'"> '.$subdata['menu'].'</a>';
				
}		
					
			   if ($jmlsub2>0) {
				   
				   
				   
				   

			   
				   
				   
				   
				   
				   
				   
				   
				   
				   
				   
				   
            echo '  

                                        <ul class="sub-menu"> ';

            while ($subdata2 = $koneksi_db->sql_fetchrow($subhasil2)) {	

                                  echo '      <li><a   href="'.$subdata2['url'].'" title="'.$subdata2[1].'"> '.$subdata2['menu'].'</a></li> ';
										
										
			}	
										
										
                              echo '      </ul> ';
									
			   }	
					
			echo '	</li>';

            }
          echo "</ul>
                    
                
                   ";


        }

}

?>      </li>