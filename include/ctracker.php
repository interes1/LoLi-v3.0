<?php if(!defined('IN_TRACKER'))die('Hacking attempt!');
$cracktrack = strtolower(urldecode($_SERVER['QUERY_STRING']));
$wormprotector = array('chr(', 'chr=', 'chr%20', '%20chr', 'wget%20', '%20wget', 'wget(', 'cmd=', '%20cmd', 'cmd%20', 'rush=', '%20rush', 'rush%20',
'union%20', '%20union', 'union(', 'union=', 'union+', 'echr(', '%20echr', 'echr%20', 'echr=', 'esystem(', 'esystem%20', 'cp%20', '%20cp', 'cp(', 'mdir%20',
'%20mdir', 'mdir(', 'mcd%20', 'mrd%20', 'rm%20', '%20mcd', '%20mrd', '%20rm', 'mcd(', 'mrd(', 'rm(', 'mcd=', 'mrd=', 'mv%20', 'rmdir%20',
'mv(', 'rmdir(', 'chmod(', 'chmod%20', '%20chmod', 'chmod(', 'chmod=', 'chown%20', 'chgrp%20', 'chown(', 'chgrp(', 'locate%20', 'grep%20',
'locate(', 'grep(', 'diff%20', 'kill%20', 'kill(', 'killall', 'passwd%20', '%20passwd', 'passwd(', 'telnet%20', 'vi(', 'vi%20', 'insert%20into',
'select%20', 'nigga(', '%20nigga', 'nigga%20', 'fopen', 'fwrite', '%20like', 'like%20', '$_request', '$_get', '$request', '$get', '.system',
'HTTP_PHP', '&aim', '%20getenv', 'getenv%20', 'new_password', '&icq', '/etc/password', '/etc/shadow', '/etc/groups', '/etc/gshadow', 'HTTP_USER_AGENT',
'HTTP_HOST', '/bin/ps', 'wget%20', 'uname\x20-a', '/usr/bin/id', '/bin/echo', '/bin/kill', '/bin/', '/chgrp', '/chown', '/usr/bin', 'g\+\+',
'bin/python', 'bin/tclsh', 'bin/nasm', 'perl%20', 'traceroute%20', 'ping%20', '.pl', '/usr/X11R6/bin/xterm', 'lsof%20', '/bin/mail', '.conf',
'motd%20', 'HTTP/1.', '.inc.php', 'conf.php', 'cgi-', '.eml', 'file\://', 'window.open', '<script>', 'javascript\://', 'img src', 'img%20src',
'.jsp', 'ftp.exe', 'xp_enumdsn', 'xp_availablemedia', 'xp_filelist', 'xp_cmdshell', 'nc.exe', '.htpasswd', 'servlet', '/etc/passwd', 'wwwacl',
'~root', '~ftp', '.js', '.jsp', 'admin_', '.history', 'bash_history', '.bash_history', '~nobody', 'server-info', 'server-status', 'reboot%20',
'halt%20', 'powerdown%20', '/home/ftp', '/home/www', 'secure_site, ok', 'chunked', 'org.apache', '/servlet/con', '<script', '/robot.txt', '/XSS/',
'/perl', 'mod_gzip_status', 'db_mysql.inc', '.inc', 'select%20from', 'select from', 'drop%20', '.system', 'getenv', 'http_', '_php', 'php_', 'HelloThinkPHP21',
'/Index/\think\app/invokefunction&function=call_user_func_array&vars[0]=md5&vars[1][]=HelloThinkPHP21', 
'/index.php?s=/Index/\think\app/invokefunction&function=call_user_func_array&vars[0]=md5&vars[1][]=HelloThinkPHP21',
'index.php?s=/Index/\think\app/invokefunction&function=call_user_func_array&vars[0]=md5&vars[1][]=HelloThinkPHP21', 
'user_func_array', 'phpinfo()', '@md5', 'phpstorm', '/?XDEBUG_SESSION_START=phpstorm', '?XDEBUG_SESSION_START=phpstorm', 'XDEBUG', 'SESSION', 'XDEBUG_SESSION_START', 
'?a=fetch&content=<php>die(@md5(HelloThinkCMF))</php>', '/?a=fetch&content=die(@md5(HelloThinkCMF))', '?a=fetch&content=die(@md5(HelloThinkCMF))', 'HelloThinkCMF',
'</php>', '<php>', '<?php', '?>', '/EN/_vti_bin/WebPartPages.asmx', '_vti_bin/WebPartPages.asmx', 'WebPartPages.asmx', '.asmx', 'sql=');
$checkworm = str_ireplace($wormprotector, '*', $cracktrack);
if($cracktrack != $checkworm){global $CURUSER, $rootpath;$cremotead = $_SERVER['REMOTE_ADDR'];$cuseragent = $_SERVER['HTTP_USER_AGENT'];
$ip = getip();$ag = getenv("HTTP_USER_AGENT");$host = getenv("REQUEST_URI");$date = date("d.m.y");$time = date("H:i:s");dbconn();$first = sqlesc(getip());
$res = sql_query("SELECT * FROM bans WHERE first=$first AND haker = 'yes'") or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($res) > 0){stderr("<html><head><meta http-equiv='refresh' content='3;url=https://www.fbi.gov".$host."'></head>
<body style=\"background:black no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;\">
Hacker? Well, congratulations!</body></html>");}else{if($CURUSER){$modcomment = "Hakker? Don't break us!";
$flist = $rootpath."include/user_cache/user_".$CURUSER["id"].".cache";if(file_exists($flist)){unlink($rootpath."include/user_cache/user_".$CURUSER["id"].".cache");}
mysql_query("UPDATE users SET enabled='no', modcomment = ".sqlesc($modcomment)." WHERE id = ".$CURUSER["id"]);mysql_query("DELETE FROM sessions WHERE ip = ".sqlesc(getip()));
$userr = $CURUSER["username"];logoutcookie();}else{$userr = "Гость";}$comments = "Hakker? Don't break us!";$comment = trim($comments);
$comment = sqlesc(htmlspecialchars_uni($comment));$added = sqlesc(get_date_time());
mysql_query("INSERT INTO bans (added, addedby, first, comment, haker) VALUES($added, 2, $first, $comment, 'yes')");
mysql_query("DELETE FROM sessions WHERE ip = ".sqlesc(getip()));unlink("include/cache/bans.cache");
write_log("Атака остановлена! Отаковал(а): $userr! Его(её) данные: $ip ; $ag<br>URL SQL-inection: $host<br>$date ; $time.","5DDB6E","bans");
stderr("<html><head><meta http-equiv='refresh' content='3;url=https://www.fbi.gov".$host."'></head>
<body style=\"background:black no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;\">
Attack detected! <br><br><b>Youre attack was blocked:</b><br>$cremotead - $cuseragent<br><br>Hacker? Well, congratulations!<br><br>You are banned! Farewell!</body></html>");}}?>
