
<?php

$hasil = $koneksi_db->sql_query( "SELECT * FROM menu WHERE published=1 ORDER BY ordering" );

while ($data = $koneksi_db->sql_fetchrow($hasil)) {

        $parent= $data['id'];
        $target= "";

        $link_menu = $data['menu'];
        $link_url = $data['url'];
$subhasil = $koneksi_db->sql_query( "SELECT * FROM submenu WHERE published=1 AND parent='$parent' ORDER BY ordering" );
        $jmlsub = $koneksi_db->sql_numrows( $subhasil );
		
	
		
		
if ($jmlsub>0) {
        echo '<li  class="dropdown"><a data-toggle="dropdown" href="#" title="'.$link_menu.'">'.$link_menu.'  <i class="fa fa-angle-down" aria-hidden="true"></i></a>  ';
            	
} else {
	
	 echo '
            	<li><a href="'.$link_url.'" title="'.$link_menu.'">'.$link_menu.'</a>  ';
}



        

       if ($jmlsub>0) {
            echo ' 
 <ul  class="dropdown-menu">';

            while ($subdata = $koneksi_db->sql_fetchrow($subhasil)) {
                $target="";
				$parent2= $subdata['id'];
  
				
				
				
				
				
            
				
				$subhasil2 = $koneksi_db->sql_query( "SELECT * FROM submenumenu WHERE published=1 AND parent='$parent2' ORDER BY ordering" );
        $jmlsub2 = $koneksi_db->sql_numrows($subhasil2);	
				
				
				
				

	
	 echo '
       <li><a  class="dropdown-item"  href="'.$subdata['url'].'" '.$target.' title="'.$subdata[1].'"> '.$subdata['menu'].'</a>';
				
		
							   if ($jmlsub2>0) {
				   
				   
				   
				   

			   
				   
				   
				   
				   
				   
				   
				   
				   
				   
				   
				   
            echo '  
 <ul style="margin-left:20px;padding:4px;"> ';

            while ($subdata2 = $koneksi_db->sql_fetchrow($subhasil2)) {	

                                  echo '      <li><a    class="dropdown-item"   href="'.$subdata2['url'].'" title="'.$subdata2[1].'" style="color:blue;">- '.$subdata2['menu'].'</a></li> ';
										
										
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