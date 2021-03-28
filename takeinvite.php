<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){$id = (isset($_GET["id"]) ? intval($_GET["id"]):0);
if($id != $CURUSER["id"] || empty($id)) stderr2("Error!", "<center>Hakker?</center><html><head><meta http-equiv=refresh content='3;url=/'></head></html>");
function bark($msg){stdhead();stdmsg("Ошибка", $msg);stdfoot();die;}
$re = mysql_query("SELECT invites FROM users WHERE id = $id") or sqlerr(__FILE__,__LINE__);$tes = mysql_fetch_assoc($re);
if($tes[invites] <= 0) bark("У вас больше не осталось приглашений!");$hash  = md5(mt_rand(1, 1000000));
mysql_query("INSERT INTO invites (inviter, invite, time_invited) VALUES (".implode(", ", array_map("sqlesc", array($id, $hash, get_date_time()))).")") or sqlerr(__FILE__,__LINE__);
mysql_query("UPDATE users SET invites = invites - 1 WHERE id = $id") or sqlerr(__FILE__, __LINE__);
header("Refresh: 0; url=invite");}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
