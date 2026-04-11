<?php


if (!function_exists('menu_tabs')) {
function menu_tabs ($link,$url){
/*
$path = "/home/httpd/html/index.php?id=ad";
echo $file = basename($path);        // $file is set to "index.php"
*/	


$data = '<DIV id="tabsB"><UL>';
if (is_array ($link)){
	foreach ($link as $key=>$value){
		parse_str(str_replace ('&amp;','&',$value),$output);
		if (@$output['action'] == $url){
		$data .= '<LI id="current"><A href="'.$value.'"><SPAN>'.$key.'</SPAN></A></LI>';
			}else {
				$data .= '<LI><A href="'.$value.'"><SPAN>'.$key.'</SPAN></A></LI>';
				  }
	}
  
}  
$data .= '</UL></DIV>
<br>
';	
return $data;	
}
}

if (!function_exists('input_text')) {
function input_text ($name,$value,$type='text',$size=33,$opt=''){
	global $_input;
	$value = cleantext(stripslashes($value));

	$focus =  ' onblur="this.style.color=\'#6A8FB1\'; this.className=\'\'" onfocus="this.style.color=\'#FB6101\'; this.className=\'inputfocus\'"';
return '<input type="'.$type.'" name="'.$name.'" size="'.$size.'" '.@$_input[$name].' value="'.$value.'"'.$opt.$focus.' />';	
}
}
if (!function_exists('input_alert')) {
function input_alert($name){
	global $_input;
$_input[$name] = ' class="inputfocus_alert"';	
}
}
if (!function_exists('savedate')) {
function savedate ($date){
$date = empty ($date) ? 'NOW' : $date;
return date ('Y-m-d',strtotime($date));	
}
}

if (!function_exists('select_value')) {
function select_value ($name, $selected, $value = array (),$opt='',$alert='',$pilihan='-- Choose --') {
	

$admin ="<select name='$name' size='1' $opt $alert>"; 
$admin .="<option value=''>$pilihan</option>";
if (is_array ($value)){
foreach ($value as $k=>$v) {
		
					if (strtolower($k) == strtolower($selected)){
						$admin .="<option value=\"".$k."\" selected>$v</option>";
						}else {
							$admin .="<option value=\"".$k."\">$v</option>";
							}

}

}  
   
$admin .="</select>";     	
	
return $admin;	
}
}


function rentangTGL($dari, $sampai){


$admin .= '
<form method="POST" action="" name="pilih">
<table >
</tr>
<td>From Date</td>
<td>:</td>
<td><input type="text" name="daritgl" value="'.$dari.'"  class="tcal date required" id=""  >
</td>
<td>Until Date</td>
<td>:</td>
<td><input type="text" name="sampaitgl" value="'.$sampai.'"  class="tcal date required" id="" > 
	</td>

</tr>
<tr>
<td></td>
<td></td>
<td><input type="submit" name="submit" value="Process" style="margin-bottom:20px;" ></td>
</tr>
</table>';

return $admin;	
}

?>