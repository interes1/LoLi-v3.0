<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER && get_user_class() >= UC_MODERATOR && $CURUSER['override_class'] == 255){global $rootpath;
if($_GET['action'] == 'editclass'){$newclass = 0+$_GET['class'];$returnto = $_GET['returnto'];
mysql_query("UPDATE users SET override_class = ".sqlesc($newclass)." WHERE id = ".$CURUSER['id']);
$flist = $rootpath."include/user_cache/user_".$CURUSER["id"].".cache";if(file_exists($flist)){unlink($rootpath."include/user_cache/user_".$CURUSER["id"].".cache");}
header("Refresh: 0; url=/");}stdhead("Смена класса");begin_frame(".:: Cмена класса ::.");?>
<form method='get' action='setclass.php'><table width='100'%' border='0' cellspacing='5' cellpadding='5'><center>
<input type='hidden' name='action' value='editclass'>
<input type='hidden' name='returnto' value='user_<?=$CURUSER['id']?>'><tr><td align='center'>Kласс:&nbsp;&nbsp;<select name=class><?
$maxclass = get_user_class() - 1;for ($i = 0; $i <= $maxclass; ++$i)print("<option value=$i" .">" . get_user_class_name($i) . "");?>
</select></td></tr><tr><td colspan='3' align='center'><input type='submit' class='button4' value='Cмена класса'></td></tr></center></table></form>
<?end_frame ();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
