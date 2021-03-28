<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER && get_user_class() >= UC_1080p){
parked();$userid = (isset($_GET["id"]) ? intval($_GET["id"]):0);$action = $_GET["action"];
if(!is_valid_id($userid) || empty($userid) || empty($_GET["action"])) stderr2($tracker_lang['error'], "<center>ID указан не верно</center><html><head><meta http-equiv='refresh' content='4;url=/'></head></html>");
if($action == "viewcomments"){global $CacheBlockus;$_cacheu = "user_".$userid.".cache";$arus = $CacheBlockus->Readus($_cacheu);
if($arus["id"] != $userid) stderr2("<center>Error!</center>", "<center>Нет пользователя с таким ID: $id.</center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");
$torrentcomments = $arus["comreliz"];
if($torrentcomments == 0){stderr2($tracker_lang['error'], "<center>Комментарии не найдены</center><html><head><meta http-equiv='refresh' content='4;url=/'></head></html>");}else{
////////////////////////
$perpage = 10;list($pagertop, $pagerbottom, $limit) = pager2($perpage, $torrentcomments, "userhistory.php?action=viewcomments&id=$userid&");
$res = sql_query("SELECT t.name, c.torrent AS t_id, c.id, c.added, c.text FROM comments AS c LEFT JOIN torrents as t ON c.torrent = t.id WHERE c.user = $userid ORDER BY c.id DESC $limit") or sqlerr(__FILE__, __LINE__);
$username = $arus["username"];if(!$arus["avatar"]){$avatar = "pic/noavatar.gif";}else{$avatar = $arus["avatar"];}
if(!$arus["class"]){$userclass = "";}else{$userclass = $arus["class"];}
if(strtotime($arus["last_access"]) > gmtime() - 600){$online = "online";$online_text = "В сети";}else{$online = "offline";$online_text = "Не в сети";}
stdhead("История комментариев $username");
?><table style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;'><tr>
<td align='center' style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;'><?
print ("<table style='background:none;margin-top:0;cellspacing:0;margin-top:7px;cellpadding:0;width:100%;float:center;'><tr>
<td style='border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='a'>
<table style='background:none;width:100%;float:center;border:0;'><tr>
<td class='zaliwka' style='color:#FFFFFF;colspan:14;height:15px;font-family:cursive;font-size:14px;text-align:center;border:0;border-radius:5px;'>
История комментариев <b>$username</b></td></tr></table></td></tr></table>");
if($torrentcomments > $perpage) echo $pagertop;while ($arr = mysql_fetch_assoc($res)){$commentid = $arr["id"];$torrent = $arr["name"];$torrentid = $arr["t_id"];
print ("<br><table style='background:none;' width='98%' border='0' cellspacing='0' cellpadding='3'><tr valign='top'><td style='padding:10px;width:150;background:none;'>
<table style='background:none;'border='0' cellspacing='0'><tr><td style='padding:10px;width:150;height:160;border-radius:10px;border:0;' class='b'><center><a href='user_$userid'>
<img src='$avatar' width='120' border='1' alt='".($username?($username):"Anonymous")."' title='".($username?($username):"Anonymous")."'></a><br>");
if(isset($username)){
print ("<a href='user_".$userid."' class='altlink_white'><b>".get_user_class_color($userclass, $username)."</b></a>
".($row["donor"] == "yes" ? "&nbsp;<img src=pic/star.gif alt='Donor'>" : "").($row["warned"] == "yes" ? "&nbsp;<img src=\"/pic/warned.gif\" alt=\"Warned\">" : "")."<hr width='120'>
<img src='pic/buttons/button_".$online.".gif' alt='".$online_text."' title='".$online_text."' style='position: relative; top: 2px;' border='0' height='14'>
&nbsp;<a href=\"#\" onclick=\"javascript:window.open('sendpm_".$userid."', 'Отправить PM', 'width=650, height=465');return false;\" title=\"Отправить ЛС\">
<img src='pic/pn_inbox.gif' border='0' title='PM'/></a>");}else{print ("<i>[Anonymous]</i>");}
print ("</center></td></tr><tr><td style='width:150;background:none;'></td></tr></table></td><td width='100%' style='padding:10px;border-radius:10px;border:0;' class='b'>
<table style='background:none;width:100%;border:0;'><tr><td class=\"zaliwka\" style='font-family:tahoma;color:#FFFFFF;colspan:16;font-size:14px;border:0;border-radius:5px;'>
<div style='font-size:14px;float:left;border:0;'>&nbsp;&nbsp;&nbsp;&nbsp;
.:: ".($torrent?("<a href='details_$torrentid&viewcomm=".$arr["id"]."#comm".$arr["id"]."'><font color='white'><b>$torrent</b></font></a>"):" [Удален] ")." ::.</div>");
print ("<div style='font-family:tahoma;font-size:11px;font-weight:10;color:#FFFFFF;margin-left:10px;letter-spacing:0;text-align:left;float:right;border:0;'>
".nicetime($arr["added"], true)."&nbsp;&nbsp;&nbsp;
</div></td></tr><tr><td style='background:none;width:100%;border:0;'>");
print ("<div style='margin-left:20px;border:0;'><br>".format_comment($arr['text'])."</div><div id='cleft' border='0'></div></td></tr></table></td></tr></table>");}
if ($torrentcomments > $perpage) echo $pagerbottom;?></td></tr></table><?stdfoot();die;}}
else{stderr2($tracker_lang['error'], "<center>Неверный или отсутствующий запрос.</center><html><head><meta http-equiv='refresh' content='4;url=/'></head></html>");}
}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
