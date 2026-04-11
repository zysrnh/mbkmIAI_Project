<?php



function lastpost_forum ($forumId, $threadId, $id,$header = true){
	global $koneksi_db;
$was = $koneksi_db->sql_query ("SELECT count(*) AS total FROM mod_forum_t WHERE forum_id='$forumId' AND thread_parent='$threadId'");
$fetch = $koneksi_db->sql_fetchrow ($was);
$jumlah = $fetch['total'];
//mysql_free_result ($was);             
$limit = 10;             

$pg = intval($jumlah/$limit);
if ($jumlah%$limit) { 
$pg++; 
} 

$stg = 1;

$offset = 0;
for ($i=1;$i<$pg;$i++) {
$offset = $offset + $limit;
if ($i >= 5 && ($i%$limit) == 0){
$stg++;
}
}
if ($header) {
if ($jumlah <= $limit) {
header ("location:index.php?pilih=forum&modul=yes&action=viewthread&forum_id=$forumId&thread_id=$threadId");	
}else {
header ("location:index.php?pilih=forum&modul=yes&action=viewthread&forum_id=$forumId&thread_id=$threadId&pg=$pg&stg=$stg&offset=$offset#$id");
}
exit;
}else {
	if ($jumlah <= $limit) {
return "index.php?pilih=forum&amp;modul=yes&amp;action=viewthread&amp;forum_id=$forumId&amp;thread_id=$threadId";	
}else {
return "index.php?pilih=forum&amp;modul=yes&amp;action=viewthread&amp;forum_id=$forumId&amp;thread_id=$threadId&amp;pg=$pg&amp;stg=$stg&amp;offset=$offset#$id";
}
}
}


function lastthread_forum ($forumId, $id,$header = true){
global $koneksi_db;	
$was = $koneksi_db->sql_query ("SELECT count(*) AS total FROM mod_forum_t WHERE forum_id='$forumId' AND thread_parent='0'");
$fetch = $koneksi_db->sql_fetchrow ($was);
$jumlah = $fetch['total'];
//mysql_free_result ($was);             
$limit = 10;             

$pg = intval($jumlah/$limit);
if ($jumlah%$limit) { 
$pg++; 
} 

$stg = 1;

$offset = 0;
for ($i=1;$i<$pg;$i++) {
$offset = $offset + $limit;
if ($i >= 5 && ($i%$limit) == 0){
$stg++;
}
}
if ($header) {
if ($jumlah <= $limit) {
header ("location:index.php?pilih=forum&modul=yes&action=viewtopic&forum_id=$forumId");	
}else {
header ("location:index.php?pilih=forum&modul=yes&action=viewtopic&forum_id=$forumId&pg=$pg&stg=$stg&offset=$offset#$id");
}
exit;
}else {
	if ($jumlah <= $limit) {
return "index.php?pilih=forum&amp;modul=yes&amp;action=viewtopic&amp;forum_id=$forumId";	
}else {
return "index.php?pilih=forum&amp;modul=yes&amp;action=viewtopic&amp;forum_id=$forumId&amp;pg=$pg&amp;stg=$stg&amp;offset=$offset#$id";
}
}
}

if (!function_exists('auto_link')){
function auto_link($str) { 
  # don't use target if tail is follow 
  $regex['file'] = "gz|tgz|tar|gzip|zip|rar|mpeg|mpg|exe|rpm|dep|rm|ram|asf|ace|viv|avi|mid|gif|jpg|png|bmp|eps|mov"; 
  $regex['file'] = "(\.($regex[file])\") TARGET=\"_blank\""; 

  # define URL ( include korean character set ) 
  $regex['http'] = "(http|https|ftp|telnet|news|mms):\/\/(([\xA1-\xFEa-z0-9:_\-]+\.[\xA1-\xFEa-z0-9:;&#=_~%\[\]\?\/\.\,\+\-]+)([\.]*[\/a-z0-9\[\]]|=[\xA1-\xFE]+))"; 

  # define E-mail address ( include korean character set ) 
  $regex['mail'] = "([\xA1-\xFEa-z0-9_\.\-]+)@([\xA1-\xFEa-z0-9_\-]+\.[\xA1-\xFEa-z0-9\-\._\-]+[\.]*[a-z0-9]\??[\xA1-\xFEa-z0-9=]*)"; 

  # If use "wrap=hard" option in TEXTAREA tag, 
  # connected link tag that devided sevral lines 
  $src[] = "/<([^<>\n]*)\n([^<>\n]+)\n([^<>\n]*)>/i"; 
  $tar[] = "<\\1\\2\\3>"; 
  $src[] = "/<([^<>\n]*)\n([^\n<>]*)>/i"; 
  $tar[] = "<\\1\\2>"; 
  $src[] = "/<(a|img)[^>]*(href|src)[^=]*=[ '\"\n]*($regex[http]|mailto:$regex[mail])[^>]*>/i"; 
  $tar[] = "<\\1 \\2=\"\\3\">"; 

  # replaceed @ charactor include email form in URL 
  $src[] = "/(http|https|ftp|telnet|news|mms):\/\/([^ \n@]+)@/i"; 
  $tar[] = "\\1://\\2_HTTPAT_\\3"; 

  # replaced special char and delete target 
  # and protected link when use html link code 
  $src[] = "/&(quot|gt|lt)/i"; 
  $tar[] = "!\\1"; 
  $src[] = "/<a([^>]*)href=[\"' ]*($regex[http])[\"']*[^>]*>/i"; 
  $tar[] = "<A\\1href=\"\\3_orig://\\4\" target=\"_blank\">"; 
  $src[] = "/href=[\"' ]*mailto:($regex[mail])[\"']*>/i"; 
  $tar[] = "href=\"mailto:\\2#-#\\3\">"; 
  $src[] = "/<([^>]*)(background|codebase|src)[ \n]*=[\n\"' ]*($regex[http])[\"']*/i"; 
  $tar[] = "<\\1\\2=\"\\4_orig://\\5\""; 

  # auto linked url and email address that unlinked 
  $src[] = "/((src|href|base|ground)[ ]*=[ ]*|[^=]|^)($regex[http])/i"; 
  $tar[] = "\\1<a href=\"\\3\" target=\"_blank\">\\3</a>"; 
  $src[] = "/($regex[mail])/i"; 
  $tar[] = "<a href=\"mailto:\\1\">\\1</a>"; 
  $src[] = "/<a href=[^>]+>(<a href=[^>]+>)/i"; 
  $tar[] = "\\1"; 
  $src[] = "/<\/A><\/A>/i"; 
  $tar[] = "</A>"; 

  # restored code that replaced for protection 
  $src[] = "/!(quot|gt|lt)/i"; 
  $tar[] = "&\\1"; 
  $src[] = "/(http|https|ftp|telnet|news|mms)_orig/i"; 
  $tar[] = "\\1"; 
  $src[] = "'#-#'"; 
  $tar[] = "@"; 
  $src[] = "/$regex[file]/i"; 
  $tar[] = "\\1"; 

  # restored @ charactor include Email form in URL 
  $src[] = "/_HTTPAT_/"; 
  $tar[] = "@"; 

  # put border value 0 in IMG tag 
  $src[] = "/<(img src=\"[^\"]+\")>/i"; 
  $tar[] = "<\\1 border=0>"; 

  # If not MSIE, disable embed tag 
  if(!ereg("MSIE", @$_SERVER['HTTP_USER_AGENT'])) {
    $src[] = "/<embed/i"; 
    $tar[] = "&lt;embed"; 
  } 
   
  $str = preg_replace($src,$tar,$str); 
  return $str; 
}
}
function clear_att_html ($text) {
$search = array ("/onmouseover=[\"|'].*?[\"|']/i",
                     "/onmouseover=.*?[ ]/i",
                     "/onmouseout=[\"|'].*?[\"|']/i",
                     "/onmouseout=.*?[ ]/i",
                     "/onclick=[\"|'].*?[\"|']/i",
                     "/onclick=.*?[ ]/i",
                     "/onload=[\"|'].*?[\"|']/i",
                     "/onload=.*?[ ]/i"
                    );                    // evaluate as php

$replace = array (
                  "",
                  "",
                  "",
                  "",
                  "",
                  "",
                  "",
                  ""
                 );

return preg_replace($search, $replace, $text);	
}
function clear_att($html_body) {
	return strip_tags(preg_replace("/(<\/?)(\w+)([^>]*>)/e", 
             "stripslashes('\\1\\2').clear_att_html(stripslashes('\\3'))", 
             $html_body),'<a><b><font><i><br>');
}

function bbcode($text) {
$text = htmlspecialchars($text,ENT_NOQUOTES);
$search[] = '/(\[font color=["|\'])(.*)(["|\']\])(.*)(\[\/font\])/i';
$replace[] = '<span style="color:${2}">${4}</span>';
$search[] = '/(\[a href=["|\'])(.*)(["|\']\])(.*)(\[\/a\])/i';
$replace[] = '<a href="${2}" target="_blank">${4}</a>';

$search[] = '/(\[font color=)(.*)(\])(.*)(\[\/font\])/i';
$replace[] = '<span style="color:${2}">${4}</span>';
$text = preg_replace($search, $replace, $text);	

	$text = str_ireplace('[b]','<b>',$text);
	$text = str_ireplace('[/b]','</b>',$text);
	$text = str_ireplace('[i]','<i>',$text);
	$text = str_ireplace('[/i]','</i>',$text);
	$text = str_ireplace('[blockquote]','<blockquote>',$text);
	$text = str_ireplace('[/blockquote]','</blockquote>',$text);
	$text = nl2br($text);
	return strip_tags($text,'<a><b><i><br><span><blockquote>');
	
}

function forum_login() {
	global $_LOGIN_NOTIFY;
	$tengah = null;
		if (isset($_LOGIN_NOTIFY)) {
		$tengah .= $_LOGIN_NOTIFY;
	}
	
	
	$redirect = str_replace('&','&amp;',$_SERVER["REQUEST_URI"]);
	$ses_id = session_id();
	
	$tengah .= '<form method="post" action="'.$redirect.'"><table border="0" cellpadding="2" cellspacing="1">
  <tr>
    <td>Username</td><td> : </td><td><input type="text" name="username" size="20" value="'.htmlentities(stripslashes(@$_POST['username'])).'" /></td>
  </tr>
  <tr>
    <td>Password</td><td> : </td><td><input type="password" name="password" size="20" /></td>
  </tr>
  <tr>
    <td></td><td>  </td><td><input type="hidden" value="1" name="loguser" /><input type="submit" value="Login" name="forum_login_'.$ses_id.'" /> atau <a href="register.html" title="Daftar">Daftar</a></td>
  </tr>
  
</table></form>';
return $tengah;
}
?>