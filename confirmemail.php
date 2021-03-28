<? require_once("include/bittorrent.php");dbconn();gzip();$id = (isset($_GET["id"]) ? intval($_GET["id"]):0);
if(!is_valid_id($_GET["id"]) || empty($_GET["id"]) || empty($_GET['confirmcode']) || empty($_GET['email'])){
stderr2($tracker_lang['error'],"<center>Не хватает данных Пользователя, что-то из этого: *ID / *E-mail / *Код подтверждения E-mail</center><html><head><meta http-equiv='refresh' content='4;url=/'></head></html>");}
$email = urldecode($_GET['email']);$res = sql_query("SELECT editsecret FROM users WHERE id = $id");$row = mysql_fetch_array($res);
if(!$row)stderr2($tracker_lang['error'],"<center>Нет пользователя с таким ID</center><html><head><meta http-equiv='refresh' content='4;url=/'></head></html>");$sec = hash_pad($row["editsecret"]);
if(preg_match('/^ *$/s', $sec))stderr2($tracker_lang['error'],"<center>Ошибка вычисления кода подтверждения</center><html><head><meta http-equiv='refresh' content='4;url=/'></head></html>");
if($_GET['confirmcode'] != md5($sec . $email . $sec))stderr2($tracker_lang['error'],"<center>Код подтверждения неверен</center><html><head><meta http-equiv='refresh' content='4;url=/'></head></html>");
sql_query("UPDATE users SET editsecret='', email=".sqlesc($email)." WHERE id = $id AND editsecret = ".sqlesc($row["editsecret"]));
if(!mysql_affected_rows())stderr2($tracker_lang['error'],"<center>Ошибка изменения адреса</center><html><head><meta http-equiv='refresh' content='4;url=/'></head></html>");
unlink("include/cache/".$CURUSER["id"]."_users.cache");header("Refresh: 0; url=usercp_emailch=1");?>
