<?php require_once("include/bittorrent.php");dbconn(true);gzip();$id = (isset($_GET["id"]) ? intval($_GET["id"]):0);$md5 = strval($_GET["secret"]);
if(!is_valid_id($id) || empty($id) || empty($md5)){print("<html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'></body></html>");}
$ip = getip();$ag = getenv("HTTP_USER_AGENT");$host = getenv("REQUEST_URI");$date = date("d.m.y");$time = date("H:i:s");
$comments = "Hakker? Don't break us!";$comment = trim($comments);$comment = sqlesc(htmlspecialchars_uni($comment));$added = sqlesc(get_date_time());$first = sqlesc(getip());
$res = sql_query("SELECT passhash, editsecret, status FROM users WHERE id = $id");$row = mysql_fetch_array($res);if(!$row){
$resr = sql_query("SELECT * FROM bans WHERE first=$first AND haker = 'yes'") or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($resr) > 0){stderr("<html><head><meta http-equiv='refresh' content='3;url=https://www.fbi.gov".$host."'></head>
<body style=\"background:black no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;\">
Hacker? Well, congratulations!</body></html>");}else{
mysql_query("INSERT INTO bans (added, addedby, first, comment, haker) VALUES($added, 2, $first, $comment, 'yes')");foreach(glob("include/cache/bans.cache") as $del_bans) unlink($del_bans);
logoutcookie();write_log("Попытка подбора подтверждения регистрации! Данные Хаккера: $ip , $ag<br>Код подбора: $host<br>$date в $time.","5DDB6E","bans");
stderr('Error', "<html lang='ru'><head><meta http-equiv='refresh' content='8;url=/'></head>
<body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'><center>
Hacker? Well, congratulations!<br><br>You are banned! Farewell!</center></body></html>");}}else{
/////////////////////
if(!$row["editsecret"]){
$resr = sql_query("SELECT * FROM bans WHERE first=$first AND haker = 'yes'") or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($resr) > 0){stderr("<html><head><meta http-equiv='refresh' content='3;url=https://www.fbi.gov".$host."'></head>
<body style=\"background:black no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;\">
Hacker? Well, congratulations!</body></html>");}else{
/////////////////////
mysql_query("INSERT INTO bans (added, addedby, first, comment, haker) VALUES($added, 2, $first, $comment, 'yes')");foreach(glob("include/cache/bans.cache") as $del_bans) unlink($del_bans);
logoutcookie();write_log("Попытка подбора подтверждения регистрации! Данные Хаккера: $ip , $ag<br>Код подбора: $host<br>$date в $time.","5DDB6E","bans");
stderr('Error', "<html lang='ru'><head><meta http-equiv='refresh' content='8;url=/'></head>
<body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'><center>
Hacker? Well, congratulations!<br><br>You are banned! Farewell!</center></body></html>");}
//////////////////////////
}else{if($md5 != md5($row["editsecret"])){
$resr = sql_query("SELECT * FROM bans WHERE first=$first AND haker = 'yes'") or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($resr) > 0){stderr("<html><head><meta http-equiv='refresh' content='3;url=https://www.fbi.gov".$host."'></head>
<body style=\"background:black no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;\">
Hacker? Well, congratulations!</body></html>");}else{
mysql_query("INSERT INTO bans (added, addedby, first, comment, haker) VALUES($added, 2, $first, $comment, 'yes')");foreach(glob("include/cache/bans.cache") as $del_bans) unlink($del_bans);
logoutcookie();write_log("Попытка подбора подтверждения регистрации! Данные Хаккера: $ip , $ag<br>Код подбора: $host<br>$date в $time.","5DDB6E","bans");
stderr('Error', "<html lang='ru'><head><meta http-equiv='refresh' content='8;url=/'></head>
<body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'><center>
Hacker? Well, congratulations!<br><br>You are banned! Farewell!</center></body></html>");}}else{
sql_query("UPDATE users SET status='confirmed', editsecret='' WHERE id = $id AND status = 'pending'");if(!mysql_affected_rows()){print("<html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style='background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'></body></html>");}else{
logincookie($id, $row["passhash"], $language);
$msg = sqlesc("Ваш аккаунт теперь активирован! Прежде чем начать использовать $SITENAME мы рекомендуем вам прочитать [url=rules][b]правила[/b][/url] и [url=faq][b]ЧаВо[/b][/url].");
$subject = sqlesc("Your account has been activated!");mysql_query("INSERT INTO messages (sender, receiver, msg, subject, added) VALUES (2, $id, $msg, $subject, $added)");header("Refresh: 0; url=/");}}}}?>
