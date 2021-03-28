<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
if($_SERVER ["REQUEST_METHOD"] == "GET"){$hidebid = $_COOKIE ["hidebid"];if(empty($_GET["bid"])){stderr2($tracker_lang["error"], "<b>Что забыл тут?</b>");} 
$bid = "b".intval(str_replace("b", "", $_GET ["bid"]));$bidpos = strrpos($hidebid, "$bid.");if($_GET["type"] == "hide" && ! $bidpos){setcookie("hidebid", "$hidebid$bid."); 
}elseif($_GET["type"] == "show"){setcookie("hidebid", str_replace("$bid.", "", $hidebid));}}}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
