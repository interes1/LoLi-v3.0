<?php require_once("include/bittorrent.php");dbconn(true);gzip();if ($CURUSER && get_user_class() >= UC_ADMINISTRATOR){
stdhead("Забаненые пользователи");begin_frame(".:: Забаненые пользователи ::.");
echo '<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">';
echo "<tr><td class=zaliwka align=\"center\">Пользователь</td><td class=zaliwka align=\"center\">Рейтинг</td>
<td class=zaliwka align=\"center\">IP</td><td class=zaliwka align=\"center\">Зарегистрирован</td>
<td class=zaliwka align=\"center\">Последний раз был</td><td class=zaliwka align=\"center\">Скачал</td><td class=zaliwka align=\"center\">Раздал</td></tr>";
$result = sql_query ("SELECT id, username, uploaded, downloaded, ip, added, last_access FROM users WHERE enabled = 'no' ORDER BY last_access DESC ");
if($row = mysql_fetch_array($result)){do{if($row["uploaded"] == "0"){$ratio = "inf";}
elseif($row["downloaded"] == "0"){$ratio = "inf";}else{$ratio = number_format($row["uploaded"] / $row["downloaded"], 3);
$ratio = "<font color=" . get_ratio_color($ratio) . ">$ratio</font>";}
echo "<tr><td align=\"center\"><a href=user_".$row["id"]."><b>".$row["username"]."</b></a></td>
<td align=\"center\"><strong>".$ratio."</strong></td><td align=\"center\">".$row["ip"]."</td><td align=\"center\">".$row["added"]."</td>
<td align=\"center\">".$row["last_access"]."</td><td align=\"center\">".mksize($row["downloaded"])."</td><td align=\"center\">".mksize($row["uploaded"])."</td></tr>";
}while($row = mysql_fetch_array($result));}else{print "<tr><td colspan=7 align=\"center\">Извините, записей не обнаружено!</td></tr>";}
echo "</table>";end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
