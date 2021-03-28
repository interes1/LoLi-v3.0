<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
define('PM_DELETED',0); // Message was deleted
define('PM_INBOX',1); // Message located in Inbox for reciever
define('PM_SENTBOX',-1); // GET value for sent box
// Determine action
$action = (string) $_GET['action'];if(!$action){$action = (string) $_POST['action'];if(!$action){$action = 'viewmailbox';}}
// начало просмотр почтового ящика
if($action == "viewmailbox"){$mailbox = (int) $_GET['box'];if(!$mailbox){$mailbox = PM_INBOX;}
if($mailbox == PM_INBOX){$mailbox_name = $tracker_lang['inbox'];
$mailbox_names = "<font color='red'>".$tracker_lang['inbox']."</font>&nbsp;<img height='16px' style='border:none' alt='Полученные' title='Полученные' src='pic/pn_inbox.gif'>&nbsp;::&nbsp;перейти&nbsp;в&nbsp;<a class='but' href='mess_out'><u>".$tracker_lang['outbox']."</u></a>";}
else{$mailbox_name = $tracker_lang['outbox'];
$mailbox_names = "<font color='red'>".$tracker_lang['outbox']."</font>&nbsp;<img height='16px' style='border:none' alt='Отправленые' title='Отправленые' src='pic/pn_sentbox.gif'>&nbsp;::&nbsp;перейти&nbsp;в&nbsp;<a class='but' href='mess_in'><u>".$tracker_lang['inbox']."</u></a>";}
stdhead($mailbox_name);?><table style="background:none;cellspacing:0;margin-top:0;cellpadding:0;width:100%;float:center;align:center;border:0;"><tr>
<td style="background:none;border:none;"><FORM action="message.php" method="post" name="form1"><INPUT type="hidden" name="action" value="moveordel">
<table style='background:none;margin-top:0;cellspacing:0;margin-top:7px;cellpadding:0;width:100%;float:center;'><tr>
<td style='border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='a'>
<table style='background:none;width:100%;float:center;border:0;'><tr>
<td class='zaliwka' style='color:#FFFFFF;colspan:14;height:15px;font-family:cursive;font-size:14px;text-align:left;border:0;border-radius:5px;'>
<table style='background:none;border:none;width:100%;float:center;'><tr>
<td style='background:none;border:none;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;'>
<?=$mailbox_names?></td><td style='background:none;border:none;width:40px;'>
<INPUT type="checkbox" title="<?=$tracker_lang['mark_all'];?>" value="<?=$tracker_lang['mark_all'];?>" onClick="this.value=check(document.form1.elements);">
</td></tr></table></td></tr><tr><td align="center" style="background:none;width:100%;float:center;border:0;"></td></tr></table></td></tr></table>
<script>var checkflag = "false";var marked_row = new Array;function check(field){if(checkflag == "false"){for(i = 0; i < field.length; i++){field[i].checked = true;}checkflag = "true";}else{for(i = 0; i < field.length; i++){field[i].checked = false;}checkflag = "false";}}
</script>
<?if($mailbox != PM_SENTBOX){
$res = sql_query("SELECT m.*, m.sender_username AS sender_username, m.sender_class AS userclass, s.id AS sfid, r.id AS rfid FROM messages m 
LEFT JOIN friends r ON r.userid = {$CURUSER["id"]} AND r.friendid = m.receiver 
LEFT JOIN friends s ON s.userid = {$CURUSER["id"]} AND s.friendid = m.sender 
WHERE receiver=".sqlesc($CURUSER['id'])." AND location=".sqlesc($mailbox)." ORDER BY id DESC") or sqlerr(__FILE__,__LINE__);}else{
$res = sql_query("SELECT m.*, m.receiver_username AS receiver_username, m.receiver_class AS userclass, s.id AS sfid, r.id AS rfid FROM messages m 
LEFT JOIN friends r ON r.userid = {$CURUSER["id"]} AND r.friendid = m.receiver 
LEFT JOIN friends s ON s.userid = {$CURUSER["id"]} AND s.friendid = m.sender 
WHERE sender=".sqlesc($CURUSER['id'])." AND saved='yes' ORDER BY id DESC") or sqlerr(__FILE__,__LINE__);}
if(mysql_num_rows($res) == 0){echo("<center><table style='background:none;border:none;cellspacing:0;cellpadding:0;margin-top:7px;width:200px;float:center;'><tr>
<td style='border-radius:5px;-webkit-border-radius:5px;-moz-border-radius:5px;-khtml-border-radius:5px;border:1px solid white;display:block;' class='a'>
<center><font style='font-family:tahoma;font-size:14px;font-weight:10;color:red;'><b>".$tracker_lang['no_messages'].".</b></font></center></td></tr></table></center>");
}else{while($row = mysql_fetch_assoc($res)){
if($row['sender'] != 0){$username = "<A href=\"user_".$row['sender']."\">".get_user_class_color($row["userclass"], $row["sender_username"])."</A>";
$id = $row['sender'];$friend = $row['sfid'];
if($friend && $CURUSER['id'] != $row['sender']){$username .= "&nbsp;<a href=delfriends_$id>[удалить из друзей]</a>&nbsp;";}
elseif($CURUSER['id'] != $row['sender']){$username .= "&nbsp;<a href=addfriends_$id>[добавить в друзья]</a>&nbsp;";}}else{$username = $tracker_lang['from_system'];}
if($row['receiver'] != 0){$receiver = "<A href=\"user_".$row['receiver']."\">".get_user_class_color($row["userclass"], $row["receiver_username"])."</A>";
$id_r = $row['receiver'];$friend = $row['rfid'];
if($friend && $CURUSER['id'] != $row['receiver']){$receiver .= "&nbsp;<a href=delfriends_$id_r>[удалить из друзей]</a>&nbsp;";
}elseif($CURUSER['id'] != $row['receiver']){$receiver .= "&nbsp;<a href=addfriends_$id_r>[добавить в друзья]</a>&nbsp;";}}else{$receiver = $tracker_lang['from_system'];}
$subject = htmlspecialchars_uni($row['subject']);
if(strlen($subject) <= 0){$subject = $tracker_lang['no_subject'];}
if($row['unread'] == 'yes' && $mailbox != PM_SENTBOX){
print ("<table style='background:none;border:none;cellspacing:0;cellpadding:0;margin-top:7px;width:100%;float:center;'><tr>
<td style='border-radius:5px;-webkit-border-radius:5px;-moz-border-radius:5px;-khtml-border-radius:5px;border:1px solid white;display:block;' class='a'>
<table style='background:none;width:100%;float:center;border:0;'><tr><td align='center' style='background:none;width:100%;float:center;border:0;'>
<table style='background:none;cellspacing:0;cellpadding:0;margin-top:0;width:100%;float:center;'><tr>
<td style='background:none;border:0;width:40px;' align='center'><IMG src='pic/pn_inboxnew.gif' alt='".$tracker_lang['mail_unread']."'>");
}else{
print ("<table style='background:none;border:none;cellspacing:0;cellpadding:0;margin-top:7px;width:100%;float:center;'><tr>
<td style='border-radius:5px;-webkit-border-radius:5px;-moz-border-radius:5px;-khtml-border-radius:5px;border:1px solid white;display:block;' class='a'>
<table style='background:none;width:100%;float:center;border:0;'><tr><td align='center' style='background:none;width:100%;float:center;border:0;'>
<table style='background:none;cellspacing:0;cellpadding:0;margin-top:0;width:100%;float:center;'><tr>
<td style='background:none;border:0;width:40px;' align='center'><IMG src='pic/pn_inbox.gif' alt='".$tracker_lang['mail_read']."'>");}
echo("</td><td style='background:none;border:0;' align='left'><b>".$tracker_lang['subject'].":</b>&nbsp;
<A href=\"mess_".$row['id']."\">".$subject."</A><hr width='300px' align='left'><font size='1'><b>");
if($mailbox == PM_INBOX){echo ($tracker_lang['sender']);}else{echo ($tracker_lang['receiver']);}echo(":</b>&nbsp;");
if ($mailbox != PM_SENTBOX){echo($username);}else{echo($receiver);}
echo("</font>&nbsp;<font size='1' color='grey'><img src='pic/icon_topic.gif' border='0'/>&nbsp;<i>".nicetime($row["added"], true)."</i></font></td>
<td style='background:none;width:60px;border:0;' align='center'>
<INPUT type=\"checkbox\" name=\"messages[]\" title=\"".$tracker_lang['mark']."\" value=\"".$row['id']."\" id=\"checkbox_tbl_".$row['id']."\"></td>
</tr></table></td></tr></table></td></tr></table>");}}?>
<br><table style='background:none;border:none;width:100%;float:center;'><tr>
<td class="zaliwka" style='height:30px;color:#FFFFFF;colspan:16;font-size:14px;text-align:center;border:0;border-radius:5px;' colspan="12">
<?if(mysql_num_rows($res) == 0){}else{?>
<table style='background:none;border:none;width:100%;float:center;'><tr><td style='background:none;border:none;width:80px;float:right;'>
<input type="hidden" name="box" value="<?=$mailbox?>">
<input type="submit" name="delete" title="<?=$tracker_lang['delete_marked_messages'];?>" value="<?=$tracker_lang['delete'];?>" onClick="return confirm('<?=$tracker_lang['sure_mark_delete'];?>')">
</td><td style='background:none;border:none;width:80px;float:right;'>
<input type="submit" name="markread" title="<?=$tracker_lang['mark_as_read'];?>" value="<?=$tracker_lang['mark_read'];?>" onClick="return confirm('<?=$tracker_lang['sure_mark_read'];?>')">
</td></tr></table><?}?></td></tr></table></form></td></tr></table><?stdfoot();}
// конец просмотр почтового ящика
// начало просмотр тела сообщения
if ($action == "viewmessage") {
        $pm_id = (int) $_GET['id'];
        if (!$pm_id)
        {
                stderr2($tracker_lang['error'], "У вас нет прав для просмотра этого сообщения.");
        }
        // Get the message
$res = sql_query('SELECT * FROM messages WHERE id='.sqlesc($pm_id).' AND (receiver='.sqlesc($CURUSER['id']).' OR (sender='.sqlesc($CURUSER['id']).' AND saved=\'yes\')) LIMIT 1') or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($res) == 0){stderr2($tracker_lang['error'],"Такого сообщения не существует.");}
// Prepare for displaying message
$message = mysql_fetch_assoc($res);
if ($message['sender'] == $CURUSER['id']){
// Display to
if(!$message['sender_avatar']){$avatar=("<a href='user_".$message['sender']."'><img width='100' border='0' src='pic/default_avatar.gif' title='".$message['sender_username']."'></a>
<br><b>".get_user_class_color($message["sender_class"], $message[sender_username])."</b>");}else{
$avatar=("<a href='user_".$message['sender']."'><img width='100' border='0' src='".$message['sender_avatar']."' title='".$message['sender_username']."'></a><br>
<b>".get_user_class_color($message["sender_class"], $message['sender_username'])."</b>");}
$sender = $avatar;$senderr = "<a href='user_".$message['receiver']."'>".get_user_class_color($message["receiver_class"], $message['receiver_username'])."</a>";
$reply = "";
$from = "Кому:";
$froms = "От кого:";
$fromsa = "<tr>
<td class=\"zaliwka\" style='background:#5F9EA0;color:#FFFFFF;colspan:14;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;float:center;cellpadding:0;cellspacing:0;width:100%;border-radius:5px;'>
<b>Вы сейчас читаете свое сообщение, отправленное для: ".$senderr."</b></td></tr>";
}else{
$from = "От кого:";
$froms = "Кому:";
$fromsa = "";
if ($message['sender'] == 0 || $message['sender'] == 2){
$sender = "<a href='user_2'><img width='100' border='0' src='pic/avatar/2.jpg' title='System'></a><br><b>".get_user_class_color(6, 'System')."</b>";
$senderr = "<a href='user_2'><b>".get_user_class_color(6, 'System')."</b></a>";
$reply = "";
}else{
if(!$message['sender_avatar']){$avatar=("<a href='user_".$message['sender']."'><img width='100' border='0' src='pic/default_avatar.gif' title='".$message['sender_username']."'></a>
<br><b>".get_user_class_color($message["sender_class"], $message[sender_username])."</b>");}else{
$avatar=("<a href='user_".$message['sender']."'><img width='100' border='0' src='".$message['sender_avatar']."' title='".$message['sender_username']."'></a><br>
<b>".get_user_class_color($message["sender_class"], $message['sender_username'])."</b>");}$sender = $avatar;
$senderr = "<a href='user_".$message['sender']."'>".get_user_class_color($message["sender_class"], $message['sender_username'])."</a>";
$reply = "&nbsp;&nbsp;&nbsp;<A href=\"message.php?action=sendmessage&amp;receiver=".$message['sender']."&amp;replyto=".$pm_id."\"><img border='0' src='pic/mail-reply.gif' title='Ответить'></A>";}}
$body = htmlspecialchars_uni($message['msg']);
if (get_user_class() >= UC_MODERATOR && $message['sender'] == $CURUSER['id']){
$unread = ($message['unread'] == 'yes' ? "<SPAN style=\"color: #FF0000;\"><b>(Новое)</b></A>" : "");}else{$unread = "";}
$subject = htmlspecialchars_uni($message['subject']);
if (strlen($subject) <= 0){$subject = "Без темы";}
// Mark message unread
if ($message['unread'] == "yes"){sql_query("UPDATE messages SET unread='no' WHERE id=".sqlesc($pm_id)." AND receiver=".sqlesc($CURUSER['id'])." LIMIT 1");}
// Display message
stdhead("$subject");?>
<table style='background:none;' width='98%' border='0' cellspacing='0' cellpadding='3'><?
print("<tr valign='top'><td style='padding:10px;width:150;background:none;'><table style='background:none;'border='0' cellspacing='0'><tr>
<td style='padding:10px;width:150;height:160;border-radius:10px;border:0;' class='b'><center>".$sender."<br>");
print("</center></td></tr><tr><td style='width:150;background:none;'></td></tr></table></td><td style='padding:10px;width:10;background:none;'></td>
<td width='100%' style='padding:10px;border-radius:10px;border:0;' class='b'><table style='background:none;width:100%;border:0;'><tr>
<td class=\"zaliwka\" style='font-family:tahoma;height:30px;color:#FFFFFF;colspan:16;font-size:14px;border:0;border-radius:5px;'>
<div style='font-family:tahoma;font-size:11px;font-weight:10;color:#FFFFFF;margin-left:10px;letter-spacing:0;text-align:left;float:left;border:0;'>
(".nicetime($message["added"], true).")</div>
<div style='font-family:tahoma;color:#FFFFFF;margin-left:10px;letter-spacing:0;text-align:left;float:left;border:0;'>
<u><b>Тема:</b></u>&nbsp;&nbsp;".$subject."&nbsp;</div>");
if($CURUSER["lsoff"] == 'no'){
print"<div align='right' border='0'><a href='message.php?action=deletemessage&id=".$pm_id."' class=\"altlink_white\"><font color=red>Delete</font></a>&nbsp;&nbsp;&nbsp;
</div></td></tr>".$fromsa."<tr><td style='background:none;width:100%;border:0;'>";}else{
print"<div align='right' border='0'><a href=\"message.php?action=sendmessage&amp;receiver=".$message['sender']."&amp;replyto=".$pm_id."\" class=\"altlink_white\">Quote</a>
&nbsp;&nbsp;&nbsp;<a href='message.php?action=deletemessage&id=".$pm_id."' class=\"altlink_white\"><font color=red>Delete</font></a>&nbsp;&nbsp;&nbsp;
</div></td></tr>".$fromsa."<tr><td style='background:none;width:100%;border:0;'>";}
print("<div style='margin-left:20px;border:0;'><br>".format_comment($message['msg'])."</div><div id=\"cleft\" border='0'></div></td></tr></table></td></tr></table>");
stdfoot();}
// конец просмотр тела сообщения
// начало просмотр посылка сообщения
if($action == "sendmessage"){
if($CURUSER["lsoff"] == 'no'){ 
stdhead("Личное Сообщение");?>
<table style='background:none;border:none;cellspacing:0;cellpadding:0;margin-top:7px;width:200px;float:center;'><tr>
<td style='border-radius:5px;-webkit-border-radius:5px;-moz-border-radius:5px;-khtml-border-radius:5px;border:1px solid white;display:block;' class='a'>
<center><font style='font-family:tahoma;font-size:14px;font-weight:10;color:red;'><b>Вам запрещено отправлять ЛС!</b></font></center></td></tr></table>
<?stdfoot();}else{$receiver = $_GET["receiver"];if(!is_valid_id($receiver))stderr2($tracker_lang['error'], "Неверное ID получателя");
$replyto = $_GET["replyto"];if($replyto && !is_valid_id($replyto))stderr2($tracker_lang['error'], "Неверное ID сообщения");
$auto = $_GET["auto"];$std = $_GET["std"];
if (($auto || $std ) && get_user_class() < UC_MODERATOR)stderr2($tracker_lang['error'], "Досступ запрещен.");
if($auto)$body = $pm_std_reply[$auto];if($std)$body = $pm_template[$std][1];
if($replyto){$res = sql_query("SELECT * FROM messages WHERE id=$replyto") or sqlerr(__FILE__, __LINE__);$msga = mysql_fetch_assoc($res);
if ($msga["receiver"] != $CURUSER["id"])stderr2($tracker_lang['error'], "Вы пытаетесь ответить не на свое сообщение!");
$body = "[quote=$msga[sender_username]]\n".htmlspecialchars_uni($msga['msg'])."\n[/quote]\n\n";
$subject = "Re: ".htmlspecialchars_uni($msga['subject']);}
///////////////////////////////
stdhead("Отправка сообщения", false);?>
<table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><tr>
<td style="border-radius:15px;border:none;" class='a'><table style="background:none;width:100%;float:center;border:0;"><tr>
<td class="zaliwka" style="color:#FFFFFF;colspan:14;height:20px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">
.:: Отправка сообщения для <a class='altlink_white' href='user_<?=$receiver?>'><?=$msga["receiver_username"]?></a> ::.</td></tr><tr>
<td align="center" style="background:none;width:100%;float:center;border:0;">
<form name='message' method='post' action='message'><input type='hidden' name='action' value='takemessage'>    
<TR><TD style="background:none;width:100%;border:0;" colspan="2"><B>Тема:&nbsp;&nbsp;</B><INPUT name="subject" type="text" size="60" value="<?=$subject?>" maxlength="255"></TD>
</TR><tr><td<?=$replyto?" colspan=2":""?> style="background:none;width:100%;border:0;"><?textbbcode2("message","msg","$body");?>
</td></tr><tr><td style="background:none;width:100%;border:0;" align=center><?if($replyto){?>
<input type=checkbox name='delete' value='yes' <?=$CURUSER['deletepms'] == 'yes'?"checked":""?>>Удалить сообщение после ответа&nbsp;&nbsp;&nbsp;
<input type='hidden' name='origmsg' value='<?=$replyto?>'><?}?>
<input type='checkbox' name='save' value='yes' <?=$CURUSER['savepms'] == 'yes'?"checked":""?>>Сохранить сообщение в отправленных&nbsp;&nbsp;&nbsp;
<input type='hidden' name='receiver' value='<?=$receiver?>'><input type='submit' value="Отправить!" class='btn'></td></tr></form>
</td></tr></table></td></tr></table>
<?stdfoot();}}
///////////// конец Отправка сообщения ////////////////////////////////
// начало прием посланного сообщения
if($action == 'takemessage'){
$receiver = $_POST["receiver"];$origmsg = $_POST["origmsg"];$save = $_POST["save"];$returnto = $_POST["returnto"];
if(!is_valid_id($receiver) || ($origmsg && !is_valid_id($origmsg)))stderr2($tracker_lang['error'],"Неверный ID");
$msg = trim($_POST["msg"]);if(!$msg)stderr2($tracker_lang['error'],"Пожалуйста введите сообщение!");
$subject = trim($_POST['subject']);if(!$subject)stderr2($tracker_lang['error'],"Пожалуйста введите тему сообщения!");
// Change
$save = ($save == 'yes') ? "yes" : "no";
// End of Change
$res = sql_query("SELECT acceptpms, parked, UNIX_TIMESTAMP(last_access) as la FROM users WHERE id=$receiver") or sqlerr(__FILE__, __LINE__);
$user = mysql_fetch_assoc($res);
if(!$user)stderr2($tracker_lang['error'], "Нет пользователя с таким ID $receiver.");
//Make sure recipient wants this message
if($user["parked"] == "yes")stderr2($tracker_lang['error'], "Этот аккаунт припаркован.");
if(get_user_class() < UC_MODERATOR){
if($user["acceptpms"] == "yes"){
$res2 = sql_query("SELECT * FROM blocks WHERE userid=$receiver AND blockid=" . $CURUSER["id"]) or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($res2) == 1)sttderr("Отклонено", "Этот пользователь добавил вас в черный список.");}elseif($user["acceptpms"] == "friends"){
$res2 = sql_query("SELECT * FROM friends WHERE userid=$receiver AND friendid=" . $CURUSER["id"]) or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($res2) != 1)stderr2("Отклонено", "Этот пользователь принимает сообщение только из списка своих друзей");}
elseif ($user["acceptpms"] == "no")stderr2("Отклонено", "Этот пользователь не принимает сообщения.");}
$resd = sql_query("SELECT class, avatar, username FROM users WHERE id=$receiver");$userd = mysql_fetch_assoc($resd);
$receiver_class = $userd['class'];$receiver_avatar = $userd['avatar'];$receiver_username = $userd['username'];
sql_query("INSERT INTO messages (sender, sender_class, sender_username, sender_avatar, receiver, receiver_class, receiver_username, receiver_avatar, added, msg, subject, saved) VALUES 
(".$CURUSER["id"].", ".$CURUSER["class"].", ".sqlesc($CURUSER["username"]).", ".sqlesc($CURUSER["avatar"]).", $receiver, $receiver_class, ".sqlesc($receiver_username).", 
".sqlesc($receiver_avatar).", '".get_date_time()."', ".sqlesc($msg).", ".sqlesc($subject).", ".sqlesc($save).")") or sqlerr(__FILE__, __LINE__);
$sended_id = mysql_insert_id();$delete = $_POST["delete"];
if($origmsg){
if($delete == "yes"){
// Make sure receiver of $origmsg is current user
$res = sql_query("SELECT * FROM messages WHERE id=$origmsg") or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($res) == 1){
$arr = mysql_fetch_assoc($res);
if($arr["receiver"] != $CURUSER["id"])stderr2($tracker_lang['error'],"Вы пытаетесь удалить не свое сообщение!");
if ($arr["saved"] == "no"){sql_query("DELETE FROM messages WHERE id=$origmsg") or sqlerr(__FILE__, __LINE__);}elseif($arr["saved"] == "yes")
sql_query("UPDATE messages SET unread = 'no', location = '0' WHERE id=$origmsg") or sqlerr(__FILE__, __LINE__);}}
if(!$returnto)$returnto = "$DEFAULTBASEURL/message";}
if($returnto){header("Location: message");die;}else{header ("Refresh: 2; url=message");stderr2($tracker_lang['success'] , "Сообщение было успешно отправлено!");}}
// конец прием посланного сообщения
//начало перемещение, помечание как прочитанного
if($action == "moveordel"){$pm_id = (int) $_POST['id'];$pm_box = (int) $_POST['box'];$pm_messages = $_POST['messages'];if ($_POST['move']){if($pm_id){
// Move a single message
@sql_query("UPDATE messages SET location=".sqlesc($pm_box).", saved = 'yes' WHERE id=".sqlesc($pm_id)." AND receiver=".$CURUSER['id']." LIMIT 1");}else{
// Move multiple messages
@sql_query("UPDATE messages SET location=".sqlesc($pm_box).", saved = 'yes' 
WHERE id IN (".implode(", ", array_map("sqlesc", array_map("intval", $pm_messages))).') AND receiver='.$CURUSER['id']);}
// Check if messages were moved
if(@mysql_affected_rows() == 0){stderr2($tracker_lang['error'], "Не возможно переместить сообщения!");}header("Location: mess_in");exit();
}elseif($_POST['delete']){if($pm_id){
// Delete a single message
$res = sql_query("SELECT * FROM messages WHERE id=".sqlesc($pm_id)) or sqlerr(__FILE__,__LINE__);$message = mysql_fetch_assoc($res);
if ($message['receiver'] == $CURUSER['id'] && $message['saved'] == 'no'){sql_query("DELETE FROM messages WHERE id=".sqlesc($pm_id)) or sqlerr(__FILE__,__LINE__);
}elseif($message['sender'] == $CURUSER['id'] && $message['location'] == PM_DELETED){sql_query("DELETE FROM messages WHERE id=".sqlesc($pm_id)) or sqlerr(__FILE__,__LINE__);
}elseif ($message['receiver'] == $CURUSER['id'] && $message['saved'] == 'yes'){sql_query("UPDATE messages SET location=0 WHERE id=".sqlesc($pm_id)) or sqlerr(__FILE__,__LINE__);}
elseif($message['sender'] == $CURUSER['id'] && $message['location'] != PM_DELETED){sql_query("UPDATE messages SET saved='no' WHERE id=".sqlesc($pm_id)) or sqlerr(__FILE__,__LINE__);}}else{
// Delete multiple messages
if (is_array($pm_messages))foreach ($pm_messages as $id){
$res = sql_query("SELECT * FROM messages WHERE id=".sqlesc((int) $id));$message = mysql_fetch_assoc($res);
if ($message['receiver'] == $CURUSER['id'] && $message['saved'] == 'no'){
sql_query("DELETE FROM messages WHERE id=".sqlesc((int) $id)) or sqlerr(__FILE__,__LINE__);}
elseif($message['sender'] == $CURUSER['id'] && $message['location'] == PM_DELETED){
sql_query("DELETE FROM messages WHERE id=".sqlesc((int) $id)) or sqlerr(__FILE__,__LINE__);}
elseif($message['receiver'] == $CURUSER['id'] && $message['saved'] == 'yes'){
sql_query("UPDATE messages SET location=0 WHERE id=".sqlesc((int) $id)) or sqlerr(__FILE__,__LINE__);
}elseif($message['sender'] == $CURUSER['id'] && $message['location'] != PM_DELETED){
sql_query("UPDATE messages SET saved='no' WHERE id=".sqlesc((int) $id)) or sqlerr(__FILE__,__LINE__);}}}
// Check if messages were moved
if(@mysql_affected_rows() == 0){stderr2($tracker_lang['error'],"Сообщение не может быть удалено!");
}else{header("Location: message");exit();}}elseif ($_POST["markread"]){
//помечаем одно сообщение
if($pm_id){sql_query("UPDATE messages SET unread='no' WHERE id = ".sqlesc($pm_id)) or sqlerr(__FILE__,__LINE__);}
//помечаем множество сообщений
else{if (is_array($pm_messages))foreach ($pm_messages as $id){
$res = sql_query("SELECT * FROM messages WHERE id=".sqlesc((int) $id));$message = mysql_fetch_assoc($res);
sql_query("UPDATE messages SET unread='no' WHERE id = ".sqlesc((int) $id)) or sqlerr(__FILE__,__LINE__);}}
// Проверяем, были ли помечены сообщения
if(@mysql_affected_rows() == 0){header ("Refresh: 4; url=message");stderr2($tracker_lang['error'], "<center>Сообщение не может быть помечено как прочитанное!</center>");
}else{header("Location: mess_in");exit();}}stderr2($tracker_lang['error'],"Нет действия.");}
//конец перемещение, помечание как прочитанного
//начало удаление сообщения
if ($action == "deletemessage") {
        $pm_id = (int) $_GET['id'];
        // Delete message
        $res = sql_query("SELECT * FROM messages WHERE id=" . sqlesc($pm_id)) or sqlerr(__FILE__,__LINE__);
        if (!$res) {
                stderr2($tracker_lang['error'],"Сообщения с таким ID не существует.");
        }
        if (mysql_num_rows($res) == 0) {
                stderr2($tracker_lang['error'],"Сообщения с таким ID не существует.");
        }
        $message = mysql_fetch_assoc($res);
        if ($message['receiver'] == $CURUSER['id'] && $message['saved'] == 'no') {
                $res2 = sql_query("DELETE FROM messages WHERE id=" . sqlesc($pm_id)) or sqlerr(__FILE__,__LINE__);
        }
elseif ($message['sender'] == $CURUSER['id'] && $message['location'] == PM_DELETED) {
                $res2 = sql_query("DELETE FROM messages WHERE id=".sqlesc($pm_id)) or sqlerr(__FILE__,__LINE__);
        }
        elseif ($message['receiver'] == $CURUSER['id'] && $message['saved'] == 'yes') {
$res2 = sql_query("UPDATE messages SET location=0 WHERE id=" . sqlesc($pm_id)) or sqlerr(__FILE__,__LINE__);
        }
elseif ($message['sender'] == $CURUSER['id'] && $message['location'] != PM_DELETED) {
                $res2 = sql_query("UPDATE messages SET saved='no' WHERE id=".sqlesc($pm_id)) or sqlerr(__FILE__,__LINE__);
        }
        if (!$res2) {
                stderr2($tracker_lang['error'],"Невозможно удалить сообщение.");
        }
        if (mysql_affected_rows() == 0) {
                stderr2($tracker_lang['error'],"Невозможно удалить сообщение.");
        }
        else {
                header("Location: mess_in");
                exit();
        }
}
//конец удаление сообщения
}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
