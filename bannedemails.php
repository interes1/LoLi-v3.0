<?php require_once("include/bittorrent.php");dbconn(false);gzip();if ($CURUSER && get_user_class() >= UC_SYSOP){
$remove = $_GET['remove'] + 0; 
if($remove){sql_query("DELETE FROM bannedemails WHERE id = '$remove'") or sqlerr(__FILE__, __LINE__);
write_log("Бан $remove был снят пользавателям $CURUSER[username]");} 
if($_SERVER["REQUEST_METHOD"] == "POST"){$email = trim($_POST["email"]);$comment = trim($_POST["comment"]);
if(!$email || !$comment) stderr("Error", "Missing form data."); 
sql_query("INSERT INTO bannedemails (added, addedby, comment, email) VALUES(".sqlesc(get_date_time()).", $CURUSER[id],
 ".sqlesc($comment).", ".sqlesc($email).")") or sqlerr(__FILE__, __LINE__); 
header("Location: $_SERVER[REQUEST_URI]");die;} 
$res = sql_query("SELECT id, added, addedby, comment, email FROM bannedemails ORDER BY added DESC") or sqlerr(__FILE__, __LINE__); 
stdhead("Бан Емайлов");begin_frame (".:: Бан Емайлов ::.");print("<h1>Список банов</h1>");if (mysql_num_rows($res) == 0){
print("<p align=center><b>Пусто</b></p>");}else{ 
print("<table border='1' width='100%' cellspacing='0' cellpadding='5'><tr><td class='colhead' align='center'>Поставлен</td>
<td class='colhead' align='center'>Email</td><td class='colhead' align='center'>Кем</td>
<td class='colhead' align='center'>Коментарий</td><td class='colhead' align='center'>Снять БАН</td></tr>"); 
while ($arr = mysql_fetch_assoc($res)){$r2 = mysql_query("SELECT username, class FROM users WHERE id = $arr[addedby]") or sqlerr(__FILE__, __LINE__);
$a2 = mysql_fetch_assoc($r2); 
print("<tr><td align='center'>$arr[added]</td><td align='center'>$arr[email]</td>
<td align='center'><a href=user_$arr[addedby]>".get_user_class_color($a2['class'], $a2['username'])."</a>
</td><td align='center'>$arr[comment]</td><td align='center'>
<a title='Снять бан' href='bannedemails.php?remove=$arr[id]'><font color='red'><b>Снять бан</b></font></a></td></tr>");} 
print("</table>");}
print("<h2>Забанить</h2><table border='0' align='center' width='100%' cellspacing='0' cellpadding='5'>
<form method=\"post\" action=\"bannedemails.php\"><tr><td style='border:0;'><center><b>Email:</b>&nbsp;&nbsp;
<input type=\"text\" name=\"email\" size=\"40\"></center></td><tr><td style='border:0;'><center><b>Коментарий:</b>&nbsp;&nbsp;
<input type=\"text\" name=\"comment\" size=\"40\"></center></td><tr><td style='border:0;'>
<center><b>Изпользуйте *@email.com чтобы забанить весь домейн</b></center></td></tr><tr>
<td style='border:0;'><center><input type=\"submit\" value=\"Забанить\" class=\"btn\"></center></td></tr></form></table>"); 
end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
