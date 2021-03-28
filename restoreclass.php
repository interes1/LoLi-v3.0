<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER && $CURUSER['override_class'] != 255){global $rootpath;
mysql_query("UPDATE users SET override_class = 255 WHERE id = ".$CURUSER['id']);$flist = $rootpath."include/user_cache/user_".$CURUSER["id"].".cache";
if(file_exists($flist)){unlink($rootpath."include/user_cache/user_".$CURUSER["id"].".cache");}
header("Refresh: 0; url=/");}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
