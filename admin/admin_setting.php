<h3 class="garis">Konfigurasi Website</h3><?php

    if (!defined('cms-ADMINISTRATOR')) {
        Header("Location: ../index.php");
        exit;
    }

    $admin = '';
    if (!cek_login ()){
       $admin .='<h4 class="bg">Akses di hentikan.</h4>';
    }else{
    define('HC_THM', 'thema'.'/');

    $admin .= '<div>';
    $err=0;
    if ( isset($_POST['submit']) && $_POST['submit']=="Update" ){
	
	
		foreach($_POST as $colname=>$colattr ){
			if ($colname!='submit') {
				$value = text_filter($_POST[''.$colname.'']);
				$set[] = $colname."='".$value."'";
			}
		}
		if (!empty($set)) $qry_add = implode(',', $set);
		
			$qry="UPDATE tb_setting SET $qry_add LIMIT 1";
            $exe=$koneksi_db->sql_query($qry);
            if ($exe){
                $admin .= '<div class="sukses">Edit Setting Success</div>';
                $style_include[] ='<meta http-equiv="refresh" content="3; url=admin.php?pilih=admin_setting" />';
            }
            else{
                $admin .= '<div class="error">Edit Setting Fail </div>';
                 $style_include[] ='<meta http-equiv="refresh" content="3; url=admin.php?pilih=admin_setting" />';
            }
			
       
    }
    $admin .= '<form style="margin-left:15px; margin-bottom:10px;" method="post" action="" >
    <table width="100%" border="0" cellspacing="2" cellpadding="1">';
    $qry="SELECT * FROM tb_setting LIMIT 1";
        $exe=$koneksi_db->sql_query($qry);
        $show=$koneksi_db->sql_fetchrow($exe);
       
        $qry2="DESCRIBE tb_setting";
        $exe2=$koneksi_db->sql_query($qry2);
       
        while($show2=$koneksi_db->sql_fetchrow($exe2)){
            $CONST = $show2[0];
            $VALUE = $show[$CONST];
            $admin .= " <tr>
        <td width='21%'><label>".$CONST." </label></td>
        <td width='1%'><strong>:</strong></td>";
            if ($CONST=='Themes_Name'){
                $admin .= "<td width='78%'><select name='$CONST' >";
                if ($handle = opendir("".HC_THM)) {
                    while (false !== ($file = readdir($handle))) {
                        $i++;
                        if ($file != "." && $file != "..") {
                            if (is_dir("".HC_THM."$file")) {
                                $sel="";
                                if ($file.""===$VALUE)    $sel="selected='selected'";
                                $admin .= "<option value='$file' $sel >$file</option>";
                            }
                        }
                    }
                    closedir($handle);
                }
                $admin .= "</select></td></tr>";
            }   
            else if (substr($show2[1],0,4)=='enum'){
                $admin .= "<td width='78%'><select name='$CONST' >";
                $x=str_replace("enum(",'',$show2[1]);
                $x=str_replace("')",'\'',$x);
                $arr=explode(",",$x);
                foreach ($arr as $ar){
                    $ar=str_replace("'","",$ar);
                    $sel="";
                    if ($ar===$VALUE)    $sel="selected='selected'";
                    $admin .= "<option value='$ar' $sel >$ar</option>";
                }
                $admin .= "</select></td></tr>";
            }
            else if (substr($show2[1],0,3)=='int')
                $admin .= "<td width='78%'><input type='text' name='$CONST' value='$VALUE' style='width:50px;' /></td></tr>";   
            else
                $admin .= "<td width='78%'><input type='text' name='$CONST' value='$VALUE' style='width:300px;' />";
            $admin .= "</td></tr>";
        }
    $admin .= " <tr>
        <td width='21%'></td>
        <td width='1%'></td><td width='78%'>";
        $admin .= '   
            <input type="submit" name="submit" value="Update" />   
          
    </td></tr></table></form>';
    }
    $admin .= '</div>';
    
    echo $admin;
    ?> 