<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER && get_user_class() >= UC_ADMINISTRATOR){$remove = intval($_GET['remove']);
if (is_valid_id($remove)){$res = sql_query("SELECT first FROM bans WHERE id=$remove") or sqlerr(__FILE__, __LINE__);$ip = mysql_fetch_array($res);
$first = $ip["first"];sql_query("DELETE FROM bans WHERE id=$remove") or sqlerr(__FILE__, __LINE__);
foreach(glob("include/cache/bans.cache") as $del_bans) unlink($del_bans);
write_log("Бан IP адреса <b>$first</b> был убран пользователем <b>$CURUSER[username]</b>.", "5DDB6E", "bans");header("Location: $DEFAULTBASEURL/bans.php");die;}
if($_SERVER["REQUEST_METHOD"] == "POST"){$first = $_POST["first"];$comment = trim($_POST["comment"]);
if($_POST["haker"] == "haker"){$haker = "yes";$r = @sql_query("SELECT * FROM users WHERE ip=".sqlesc($first)) or sqlerr(__FILE__, __LINE__);
$user = mysql_fetch_array($r);if($user){sql_query("UPDATE users SET enabled = 'no' WHERE id=".$user["id"]);
foreach(glob("include/cache/bans.cache") as $del_bans) unlink($del_bans);
write_log("IP юзера ".$user["username"]." попало в бан, так как совпало с IP забаненного нарушителя.", "5DDB6E", "bans");}}else{$haker = "no";}
if($_POST["system"] == "system"){$system = "2";$username = $CURUSER['username'];}else{$system = $CURUSER['id'];$username = $CURUSER['username'];}
if(!$first || !$comment)stderr($tracker_lang['error'], $tracker_lang['missing_form_data']."<html><head><meta http-equiv=refresh content='4;url=bans.php'></head></html>");
$comment = sqlesc(htmlspecialchars_uni($comment));$added = sqlesc(get_date_time());
sql_query("INSERT INTO bans (added, addedby, first, comment, haker) VALUES($added, $system, ".sqlesc($first).", $comment, '$haker')") or sqlerr(__FILE__, __LINE__);
foreach(glob("include/cache/bans.cache") as $del_bans) unlink($del_bans); 
write_log("IP адресc <b>$first</b> был забанен пользователем <b>$username</b>.", "5DDB6E", "bans");header("Location: $DEFAULTBASEURL/bans.php");die;}
$res = sql_query("SELECT bans.*, users.username, users.class FROM bans LEFT JOIN users ON bans.addedby = users.id ORDER BY bans.added DESC") or sqlerr(__FILE__, __LINE__);
stdhead($tracker_lang['bans']." IP");begin_frame(".:: Забаненые IP ::.");
print("<table border=1 cellspacing=0 cellpadding=5 width=100%>");
if(mysql_num_rows($res) == 0){print("<p align=\"center\"><b>".$tracker_lang['nothing_found']."</b></p>");}else{
print("<tr><td style='background:#4ca1e4;color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;'>Дата Бана</td>
<td style='background:#4ca1e4;color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;'>IP</center></td>
<td style='background:#4ca1e4;color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;'>Кем</td>
<td style='background:#4ca1e4;color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;'>Комментарий</td>
<td style='background:#4ca1e4;color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;'>Снять бан</td>
<td style='background:#4ca1e4;color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;'>haker?</td></tr>");
while($arr = mysql_fetch_assoc($res)){
print("<tr><td style='colspan:14;font-weight:bold;font-size:12px;text-align:center;'>$arr[added]</td>
<td style='colspan:14;font-weight:bold;font-size:12px;text-align:center;'>$arr[first]</td>
<td style='colspan:14;font-weight:bold;font-size:12px;text-align:center;'><a href='users_$arr[addedby]'>".get_user_class_color($arr['class'], $arr['username'])."</a></td>
<td style='colspan:14;font-weight:bold;font-size:12px;text-align:center;'>".$arr["comment"]."</td>
<td style='colspan:14;font-weight:bold;font-size:12px;text-align:center;'><a href='bans.php?remove=$arr[id]'><font color='red'>Снять бан</font></a></td>
<td style='colspan:14;font-weight:bold;font-size:12px;text-align:center;'><font color='green'>$arr[haker]</font></td></tr>");}}
print("</table>");end_frame();begin_frame(".:: Забанить IP адрес ::.");
print("<table border=1 cellspacing=0 cellpadding=5 width=100%><form method=\"post\" action=\"bans.php\">
<tr><td style='background:#4ca1e4;color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;'>IP</td>
<td style='background:#4ca1e4;color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;'>Комментарий</center></td>
<td style='background:#4ca1e4;color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;'>Хаккер?</td>
<td style='background:#4ca1e4;color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;'>Бан от System ?</td>
<td style='background:#4ca1e4;color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;'>Выдать бан</td></tr>
<tr><td style='colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;'><input type=\"text\" name=\"first\" size=\"40\"></td>
<td style='colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;'><input type=\"text\" name=\"comment\" size=\"80\"></td>
<td style='colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;'><input type='radio' name='haker' value='haker'></td>
<td style='colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;'><input type='radio' name='system' value='system'></td>
<td style='colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;'><input type=\"submit\" value=\"Забанить\" class=\"btn\"></td></tr>
</form></table>");end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
