<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){stdhead("Стол заказов");
function bark($msg){genbark($msg, $tracker_lang['error']);}?>
<?if(isset($_REQUEST['id'])) $id = intval($_REQUEST['id']);else $id = "";if($_REQUEST['action'] == "zakaz" and $id){
$raw = sql_query("SELECT z.cat_id, z.incat_id,z.text, z.user_id, z.class, z.user, z.cl_user_id, z.cl_user_class, z.cl_user, z.image1, z.status, z.name, 
z.bonus, z.data, z.url, c.name AS cat_name, c.image AS cat_pic, i.name AS incat_name, i.image AS incat_pic FROM zakaz AS z 
LEFT JOIN categories AS c ON z.cat_id = c.id LEFT JOIN incategories AS i ON z.incat_id = i.id WHERE z.id = '$id'") or sqlerr(__FILE__, __LINE__);
while($row = mysql_fetch_array($raw)){?>
<table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><tr><td style="border-radius:15px;border:none;" class='a'>
<table style="background:none;width:100%;float:center;border:0;"><tr>
<td class="zaliwka" style="color:#FFFFFF;colspan:14;height:30px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">
.: <?=$row['name'];?> ::.</td></tr><tr><td align="center" style="background:none;width:100%;border:0;"><table width='100%' style='border:0;'><tr><?
print("<td align='center' style='border:0;' width='340px' valign='top'>");?>
<script src="js/highslide/highslide-full.js"></script><script src="js/highslide/highslide.russian.js"></script>
<script src="js/highslide/easing_equations.js"></script><link rel="stylesheet" type="text/css" href="js/highslide/highslide.css">
<script>hs.graphicsDir = 'js/highslide/graphics/';hs.align = 'center';hs.transitions = ["fade"];hs.outlineType = 'rounded-white';hs.showCredits = false;hs.easing = 'linearTween';hs.fadeInOut = true;hs.wrapperClassName = 'controls-in-heading';hs.outlineWhileAnimating = true;hs.dimmingOpacity = 0.75;hs.numberPosition = "heading";hs.lang.number = "Изображение %1 из %2";if (hs.addSlideshow) hs.addSlideshow({interval: 5000, repeat: false, useControls: true, fixedControls: false, overlayOptions:{opacity: 1, position:'top right',}});
</script><?if(!$row ['image1']){print("<img width='300px' style='border:0;' src='pic/poster_none.png' title='Нет постера'/>");}else{
print("<a href='torrents/zakaz/{$row['image1']}' class='highslide' onclick='return hs.expand(this)' title='{$row['name']}'>
<img width='300px' src='torrents/zakaz/{$row['image1']}' title='{$row['name']}'/></a>");}
$cats = "<a href='?janr=".$row["cat_id"]."'><img border='0' align='right' src='pic/cats/".$row["cat_pic"]."' alt='".$row["cat_name"]."'/></a>";
$incats = "<a href='?tip=".$row["incat_id"]."'><img border='0' align='right' src='pic/cats/".$row["incat_pic"]."' alt='".$row["incat_name"]."'/></a>";
print("</td><td valign='top' style='border:0;'>$cats$incats<br><span style=\"color:#006699\">".format_comment($row['text'])."</span><hr align='left' width='300px'>
<span style=\"color:#999966\"><b>Заказал:</b></span> <b><a href='user_{$row["user_id"]}'>".get_user_class_color($row["class"], $row["user"])."</a></b>
&nbsp;<a href=\"#\" onclick=\"javascript:window.open('sendpm_".$row['user_id']."', 'Отправить PM', 'width=650, height=465');return false;\" 
title=\"Отправить ЛС\"><img src='pic/pn_inbox.gif' border='0' title='PM'/></a>
<br><span style=\"color:#999966\"><b>Дата заказа:</b></span> <span style=\"color:#006699\">{$row['data']}</span>
<br><span style=\"color:#999966\"><b>Награда:</b></span> <span style=\"color:#006699\">{$row['bonus']} бонусов</span></b><br>");
if($row["status"] == "4"){print("<span style=\"color:#999966\"><b>Готовый релиз:</b></span> <span style=\"color:#006699\">
<a href='{$row["url"]}'>{$row["url"]}</a></span><br>");}
if($row["status"] == "3"){print("<span style=\"color:#999966\"><b>Готовый релиз:</b></span> <span style=\"color:#006699\">
<a href='{$row["url"]}'>{$row["url"]}</a></span> - <span style=\"color:red\"><b>НЕ ПОДТВЕРЖДЕНО !</b></span><br>");}
print("<span style=\"color:#999966\"><b>Статус:</b></span> <span style=\"color:#006699\">");
if($row["status"] == "1"){print("В ожидании</span>");}if($row["status"] == "2"){print("Принято</span>");}
if($row["status"] == "3"){print("Выполнено</span>");}if($row["status"] == "4"){print("Подтверждено</span>");}
if($CURUSER["id"] == "{$row['user_id']}" and $row['status'] == "1" or get_user_class() >= UC_MODERATOR){
print("<hr align='left' width='300px'><a href=\"?action=edit&id={$id}\"><img src=\"pic/button_edit.gif\" title=\"Редактировать\"/></a>&nbsp;&nbsp;
<a href=\"?action=del&id={$id}\" ><img src=\"pic/button_delete.gif\" title=\"Удалить\"/></a>" );}
if($CURUSER["id"] == "{$row['user_id']}" and $row['status'] == "3" or get_user_class() >= UC_MODERATOR and $row['status'] == "3"){
print("&nbsp;&nbsp;<a href=\"?action=ok&id={$id}\"><span style=\"color:red\"><b>Подтвердить</b></span></a>");}
if($CURUSER["id"] == "{$row['cl_user_id']}" and $row['status'] == "2" or get_user_class() >= UC_MODERATOR and $row['status'] == "2"){
print("&nbsp;&nbsp;<a href=\"?action=url&id={$id}\"><img src=\"pic/booksm.png\" title=\"Ввести URL релиза\"/></a>" );}
if($CURUSER["id"] != "{$row['user_id']}" and $row['status'] == "1"){
print("&nbsp;&nbsp;<a href=\"?action=plus&id={$id}\"><span style=\"color:green\"><b>Принять заказ</b></span></a>");}
if($CURUSER["id"] == "{$row['cl_user_id']}" and $row['status'] == "2" or get_user_class() >= UC_MODERATOR and $row['status'] == "2"){
print("&nbsp;&nbsp;<a href=\"?action=minus&id={$id}\"><span style=\"color:red\"><b>Анулировать заказ</b></span></a>");}
if($row["status"] == "2" or $row ["status"] == "3" or $row["status"] == "4"){
print("<hr align='left' width='300px'><span style=\"color:#999966\"><b>Принял:</b></span> <b><a href='user_{$row["cl_user_id"]}'>".get_user_class_color($row["cl_user_class"], $row["cl_user"])."</a></b>&nbsp;<a href=\"#\" onclick=\"javascript:window.open('sendpm_".$row['cl_user_id']."', 'Отправить PM', 'width=650, height=465');return false;\" 
title=\"Отправить ЛС\"><img src='pic/pn_inbox.gif' border='0' title='PM'/></a>");}
print("</td></tr></table></td></tr></table></td></tr></table>");
}}elseif($_REQUEST['action'] == "ok" and $id){
$raw = mysql_query("SELECT * FROM zakaz WHERE id='$id'") or sqlerr(__FILE__, __LINE__);while($row = mysql_fetch_array($raw)){
if($CURUSER ["id"] == "{$row['user_id']}" and $row['status'] == "3" or get_user_class() >= UC_MODERATOR and $row ['status'] == "3"){
$name = $row['name'];
mysql_query("UPDATE zakaz set status='4' WHERE id = '$id'") or sqlerr(__FILE__, __LINE__);
$ros = mysql_query("SELECT bonus FROM users WHERE id=".$row['user_id']) or sqlerr(__FILE__, __LINE__);$orrr = mysql_fetch_array($ros);
$bonus_upp = $orrr['bonus'] - $row['bonus'];
mysql_query("UPDATE users set bonus='$bonus_upp' WHERE id=".$row['user_id']) or sqlerr(__FILE__, __LINE__);
$ros = mysql_query("SELECT bonus FROM users WHERE id=".$row['cl_user_id']) or sqlerr(__FILE__, __LINE__);$orr = mysql_fetch_array($ros);
$bonus_up = $orr['bonus'] + $row['bonus'];
mysql_query("UPDATE users set bonus='$bonus_up' WHERE id=".$row['cl_user_id']) or sqlerr (__FILE__, __LINE__);
mysql_query("INSERT INTO messages (sender, receiver, added, subject, msg, unread, location, saved) values ('0', '{$row['cl_user_id']}', 
'".get_date_time()."', 'Заказ $name подтвержден.', 'Заказ <b>$name</b> каторый Вы выполнили, успешно подтвержден, Вы получили {$row['bonus']} бонусов', 'yes', '1', 'no')") or sqlerr (__FILE__, __LINE__);
stderr2("Заказ <b>$name</b>", "<center>Вы подтвердили договор. Вернуться <a href=\"zakaz.php\">назад</a></center><script>setTimeout('document.location.href=\"zakaz.php\"', 10000);</script>" );
}}}elseif($_REQUEST['action'] == "url_add" and $id){$url_r = $_REQUEST['url'];if($url_r == ""){
stderr2("Ошибка", "<center>Вы должны заполнить все поля правильно.</center><script>setTimeout('document.location.href=\"zakaz.php\"', 5000);</script>");}else{
$raw = mysql_query("SELECT * FROM zakaz WHERE id = '$id'") or sqlerr(__FILE__, __LINE__);while($row = mysql_fetch_array($raw)){$name = $row['name'];
if($CURUSER["id"] == "{$row['cl_user_id']}" and $row['status'] == "2" or get_user_class() >= UC_MODERATOR and $row ['status'] == "2"){
mysql_query("UPDATE zakaz set status='3', url='$url_r' WHERE id = '$id'") or sqlerr(__FILE__, __LINE__);
mysql_query("INSERT INTO messages (sender, receiver, added, subject, msg, unread, location, saved) values ('0', '{$row['user_id']}', 
'".get_date_time()."', 'Заказ $name выполнен.', 'Заказ <b>$name</b> каторый Вы запросили, успешно выполнен.', 'yes', '1', 'no')") or sqlerr (__FILE__, __LINE__);
stderr2("Успешно", "<center>Операция прошла успешно. Вернуться <a href=\"zakaz.php\">назад</a></center><script>setTimeout('document.location.href=\"zakaz.php\"', 5000);</script>" );
}}}}elseif($_REQUEST['action'] == "url" and $id){$raw = sql_query("SELECT * FROM zakaz WHERE id = '$id'") or sqlerr(__FILE__, __LINE__);
while($row = mysql_fetch_array($raw)){
if($CURUSER["id"] == "{$row['cl_user_id']}" and $row['status'] == "2" or get_user_class() >= UC_MODERATOR and $row['status'] == "2"){?>
<table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><tr>
<td style="border-radius:15px;border:none;" class='a'><table style="background:none;width:100%;float:center;border:0;"><tr>
<td class="zaliwka" style="color:#FFFFFF;colspan:14;height:20px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">
.:: Ввод URL релиза ::.</td></tr><tr><td align="center" style="background:none;width:100%;float:center;border:0;"><?
print("<table width=\"100%\" align='center'><form name=\"zakaz\" action=\"?action=url_add&amp;id=$id\" method=\"post\">");
?><tr><td align='center' style='border:0;'><b>URL выложенного релиза:=></b> <input type="text" name="url" value="" size="100" style="width:500px" required />
<br><input type="submit" value="Подтвердить"><br></td></tr></form></table></td></tr></table></td></tr></table>
<?}}}elseif($_REQUEST['action'] == "minus" and $id){
$raw = mysql_query("SELECT * FROM zakaz WHERE id = '$id'") or sqlerr(__FILE__, __LINE__);while($row = mysql_fetch_array($raw)){$name = $row['name'];
if($CURUSER["id"] == "{$row['cl_user_id']}" and $row['status'] == "2"){
mysql_query("UPDATE zakaz set status='1', cl_user='', cl_user_id='' WHERE id = '$id'") or sqlerr(__FILE__, __LINE__);
mysql_query("INSERT INTO messages (sender, receiver, added, subject, msg, unread, location, saved) values ('0', '{$row['user_id']}', 
'".get_date_time()."', 'Заказ $name анулирован.', 'Заказ <b>$name</b> каторый Вы запросили, анулирован.', 'yes', '1', 'no')") or sqlerr(__FILE__, __LINE__);
stderr2("Анулировать заказ <b>$name</b>", "<center>Вы анулировали заказ. Вернуться <a href=\"zakaz.php\">назад</a></center><script>setTimeout('document.location.href=\"zakaz.php\"', 5000);</script>" );
}}}elseif($_REQUEST['action'] == "plus" and $id){
$raw = mysql_query("SELECT * FROM zakaz WHERE id = '$id'") or sqlerr(__FILE__, __LINE__);while($row = mysql_fetch_array($raw)){if($row['status'] == "1"){
mysql_query("UPDATE zakaz set status='2', cl_user='".$CURUSER["username"]."', cl_user_id='".$CURUSER["id"]."', cl_user_class='".$CURUSER["class"]."' WHERE id = '$id'") or sqlerr(__FILE__, __LINE__);$name = $row['name'];
mysql_query("INSERT INTO messages (sender, receiver, added, subject, msg, unread, location, saved) values ('0', '{$row['user_id']}', 
'".get_date_time()."', 'Заказ $name принят.', 'Заказ <b>$name</b> каторый Вы запросили, принят.', 'yes', '1', 'no')") or sqlerr(__FILE__, __LINE__);
stderr2("Принят заказ <b>$name</b>", "<center>Вы приняли заказ, теперь вы обязанны выполнить условия или анулируйте договор. Вернуться <a href=\"zakaz.php\">назад</a></center><script>setTimeout('document.location.href=\"zakaz.php\"', 5000);</script>");
}}}elseif($_REQUEST['action'] == "del" and $id){
$raw = mysql_query("SELECT * FROM zakaz WHERE id = '$id'") or sqlerr(__FILE__, __LINE__);while($row = mysql_fetch_array($raw)){
if($_REQUEST['action'] == "del" and $CURUSER["id"] == "{$row['user_id']}" and $row['status'] == "1" or $_REQUEST['action'] == "del" and get_user_class() >= UC_MODERATOR){
$res = mysql_query("DELETE FROM zakaz WHERE id = '$id'") or sqlerr(__FILE__, __LINE__);$name = $row['name'];
stderr2("Внимание", "<center>Заказ под номером <b>$name</b> успешно удален, вернуться <a href=\"zakaz.php\">назад</a></center><script>setTimeout('document.location.href=\"zakaz.php\"', 5000);</script>");
}}}elseif($_REQUEST['action'] == "doadd" or $_REQUEST['action'] == "doedit"){
if($_REQUEST['action'] == "doadd"){
$name = $_REQUEST['name'];
$or_name = $_REQUEST['or_name'];
$yearsd = (isset($_REQUEST['god']) ? intval($_REQUEST['god']):0);
$years = unesc($yearsd);if (!$years)bark("Вы должны ввести Год выхода!");
$god = htmlspecialchars_uni(strval($_REQUEST['god']));
$text = unesc($_REQUEST['text']);
$texts = "[color=#999966][b]Название:[/b][/color] [color=#006699]".$name."[/color]\n[color=#999966][b]Оригинальное название:[/b][/color] [color=#006699]".$or_name."[/color]\n[color=#999966][b]Год выхода:[/b][/color] [color=#006699]".$god."[/color]\n\n[color=#999966][b]Описание:[/b][/color]\n[color=#006699]".$text."[/color]";
$names = $name." / ".$or_name." (".$god.")";
}elseif($_REQUEST['action'] == "doedit"){$names = $_REQUEST['name'];$texts = unesc($_REQUEST['text']);}
$cat_id = intval($_REQUEST['cat_id']);if(!is_valid_id($cat_id))bark("Вы должны выбрать Жанр!");
$incat_id = intval($_REQUEST['incat_id']);if(!is_valid_id($incat_id))bark("Вы должны выбрать Качество!");
$bonuss = is_numeric($_REQUEST['bonus']);$bonus = $_REQUEST['bonus'];$status = $_REQUEST['status'];$url_r = $_REQUEST['url'];
if($names == "" || $texts == "" || $bonuss == "" || $CURUSER ["bonus"] < $bonus){
stderr2("Ошибка", "<center>Вы должны заполнить все поля правильно.</center><script>setTimeout('document.location.href=\"zakaz.php\"', 5000);</script>");
}else{if($_REQUEST['action'] == "doadd"){$maxfilesize = $max_image_size; // default 1mb
$allowed_types = array(
"image/gif" => "gif",
"image/pjpeg" => "jpg",
"image/jpeg" => "jpg",
"image/jpg" => "jpg",
"image/png" => "png");
///////////////////
for ($x=0; $x < 5; $x++){if(!($_FILES['image'.$x]['name'] == "")){$y = $x + 1;
if (!array_key_exists($_FILES['image'.$x]['type'], $allowed_types))bark("Invalid file type! Image $y (".htmlspecialchars_uni($_FILES['image'.$x]['type']).")");
if (!preg_match('/^(.+)\.(jpg|jpeg|png|gif)$/si', $_FILES['image'.$x]['name']))bark("Неверное имя файла (не картинка).");
if ($_FILES['image'.$x]['size'] > $maxfilesize)bark("Превышен размер файла! Картинка $y - Должна быть меньше ".mksize($maxfilesize));
$uploaddir = "torrents/zakaz/";
$ifile = $_FILES['image'.$x]['tmp_name'];
$ret = mysql_query("SHOW TABLE STATUS LIKE 'zakaz'");
$row = mysql_fetch_array($ret);
$next_id = $row['Auto_increment'];
$files = explode('.', $_FILES[ 'image' . $x ]['name']);
$ifilename = $next_id.'.'.end($files);
$copy = copy($ifile, $uploaddir.$ifilename);
if(!$copy)bark("Error occured uploading image! - Image $y");
$inames[] = $ifilename;}}
//////////////////////////////
$insert_into = "name, image1, text, data, cat_id, incat_id, user, user_id, class, bonus, status";
$insert_values = "".sqlesc($names).", '$inames[0]', ".sqlesc($texts).", '".get_date_time ()."', '$cat_id', '$incat_id', '".$CURUSER["username"]."', '".$CURUSER["id"]."', '".$CURUSER["class"]."', '".sqlesc($bonus)."', '1'";
mysql_query("INSERT INTO zakaz ($insert_into) values ($insert_values)" ) or sqlerr ( __FILE__, __LINE__ );
stderr2("Создание нового заказа", "<center>Новый заказ создан, вернуться <a href=\"zakaz.php\">назад</a></center><script>setTimeout('document.location.href=\"zakaz.php\"', 20000);</script>");
}else{
////////////////////
function uploadimage($x, $imgname, $tid){
$maxfilesize = 51200000; // 5MB
	$allowed_types = array(
	"image/gif" => "gif",
	"image/pjpeg" => "jpg",
	"image/jpeg" => "jpg",
	"image/jpg" => "jpg",
	"image/png" => "png");
if(!($_FILES['image'.$x]['name'] == "")){$y = $x + 1;
if(!array_key_exists($_FILES['image'.$x]['type'], $allowed_types)) bark("Invalid file type! Image $y (".htmlspecialchars_uni($_FILES['image'.$x]['type']).")");
if(!preg_match('/^(.+)\.(jpg|jpeg|png|gif)$/si', $_FILES['image'.$x]['name'])) bark("Неверное имя файла (не картинка).");
if($_FILES['image'.$x]['size'] > $maxfilesize) bark("Invalid file size! Image $y - Must be less than 500kb");$uploaddir = "torrents/zakaz/";
$ifile = $_FILES['image'.$x]['tmp_name'];$files = explode('.', $_FILES['image'.$x]['name']);$ifilename = $tid.'.'.end($files);
$copy = copy($ifile, $rootpath.$uploaddir.$ifilename);if(!$copy) bark("Error occured uploading image! - Image $y");return $ifilename;}}
$id = intval($id);if(!$id) die();$res = mysql_query("SELECT image1 FROM zakaz WHERE id = $id");$row = mysql_fetch_array($res);if(!$row) die();
for ($x=1; $x <= 5; $x++){$_GLOBALS['img'.$x.'action'] = $_POST['img'.$x.'action'];
if($_GLOBALS['img'.$x.'action'] == 'keep'){$image1 = sqlesc($row["image1"]);}
if($_GLOBALS['img'.$x.'action'] == 'update'){if($row["image1"] != ""){unlink($rootpath."torrents/zakaz/".$row["image1"]);}
$image1 = sqlesc(uploadimage($x - 1, $row['image'.$x], $id));}}
//////////////
$update_zakaz = "name=".sqlesc($names).", image1=$image1, text=".sqlesc($texts).", cat_id='$cat_id', incat_id='$incat_id', bonus=".sqlesc($bonus)."";
if(get_user_class() >= UC_MODERATOR){$update_zakaz_m = ", status='$status', url='$url_r'";}
mysql_query("UPDATE zakaz set {$update_zakaz}{$update_zakaz_m} WHERE id = '$id'") or sqlerr(__FILE__, __LINE__);
stderr2("Редактирование заказа", "<center>Редактирование заказа прошло успешно, вернуться <a href=\"zakaz.php\">назад</a></center><script>setTimeout('document.location.href=\"zakaz.php\"', 2000);</script>");
}}}elseif($_REQUEST['action'] == "add" or $_REQUEST['action'] == "edit"){
if($_REQUEST['action'] == "add"){
$form_action = "?action=doadd";$value = "Подтвердить добавление заказа";$begin_f = "Добавить заказ релиза";}
if($_REQUEST['action'] == "edit"){
$raw = sql_query("SELECT * FROM zakaz WHERE id = '$id'") or sqlerr(__FILE__, __LINE__);while($row = mysql_fetch_array($raw)){
if($_REQUEST['action'] == "edit" and $CURUSER["id"] == "{$row['user_id']}" and $row['status'] == "1" or $_REQUEST['action'] == "edit" and get_user_class() >= UC_MODERATOR){
$form_action = "?action=doedit&amp;id=$id";$value = "Подтвердить редактирование заказа";$name = $row['name'];$begin_f = "Редактирование заказа <b>$name</b>";
$CURUSER_id = $row['user_id'];$image1 = $row['image1'];
$text = $row['text'];$cat_id = $row['cat_id'];$incat_id = $row['incat_id'];$bonus = $row['bonus'];$status = $row['status'];$url_r = $row['url_r'];}}}
if($_REQUEST['action'] == "add" or $_REQUEST['action'] == "edit" and $CURUSER["id"] == $CURUSER_id and $status == "1" or $_REQUEST['action'] == "edit" and get_user_class() >= UC_MODERATOR){
?><table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><tr>
<td style="border-radius:15px;border:none;" class='a'><table style="background:none;width:100%;float:center;border:0;"><tr>
<td class="zaliwka" style="color:#FFFFFF;colspan:14;height:20px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">
.:: <?=$begin_f?> ::.</td></tr><tr><td align="center" style="background:none;width:100%;float:center;border:0;"><?
print("<div style=\"border:0;\" class=\"win_post\">
<form name=\"zakaz\" action=\"{$form_action}\" method=\"post\" enctype='multipart/form-data'><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">");?>
<tr><td align="right" style="border:0;"><b>Название</b></td><td style="border:0;"><input type="text" name="name" value="<?=$name?>" placeholder="Название" size="100" style="width:500px" required /></td></tr>
<?if($_REQUEST['action'] == "add"){?>
<tr><td align="right" style="border:0;"><b>Оригинальное название</b></td>
<td style="border:0;"><input type="text" name="or_name" value="<?=$or_name?>" placeholder="Оригинальное название" size="100" style="width:500px" required /></td></tr>	
<tr><td align="right" style="border:0;"><b>Год выхода</b></td><td style="border:0;">
<input type="text" name="god" value="<?=$god?>" placeholder="Год выхода" size="10" MAXLENGTH="4" style="width:80px" required /></td></tr>
<?}if($_REQUEST['action'] == "edit"){?>
<tr><td align="right" style="border:0;"><b>Постер</b></td><td style="border:0;">
<input type='radio' name='img1action' value='keep' checked>Оставить постер <input type='radio' name='img1action' value='update'>Обновить постер<br>
<b>Постер:</b>&nbsp&nbsp<input type='file' name='image0' size='80'></td></tr><?}else{?>
<tr><td align="right" style="border:0;"><b><?=$tracker_lang['img_poster'];?></b></td><td style="border:0;"><input type='file' name='image0' size='80'></td></tr><?}?>
<tr><td align="right" style="border:0;"><b>Опишите подробней Ваш заказ</b></td><td style="border:0;"><?textbbcode2("zakaz","text",htmlspecialchars_uni($text));?></td></tr>
<?if($_REQUEST['action'] == "edit"){?>
<tr><td align="right" style="border:0;"><b>Жанр</b></td><td style="border:0;"><?$s = "<select name=\"cat_id\">";$cats = get_list(categories);
foreach ($cats as $subrow){$s .= "<option value=\"".$subrow["id"]."\"";if($subrow["id"] == $cat_id)$s .= " selected=\"selected\"";
$s .= ">".htmlspecialchars_uni($subrow["name"])."</option>";}$s .= "</select>";?><?=$s?></td></tr>
<tr><td align="right" style="border:0;"><b>Качество</b></td><td style="border:0;"><?$j = "<select name=\"incat_id\">";$incats = get_list(incategories);
foreach ($incats as $subrow){$j .= "<option value=\"".$subrow["id"]."\"";if($subrow["id"] == $incat_id)$j .= " selected=\"selected\"";
$j .= ">".htmlspecialchars_uni($subrow["name"])."</option>";}$j .= "</select>";?><?=$j?></td></tr>
<?}else{?>
<tr><td align="right" style="border:0;"><b>Жанр</b></td><td style="border:0;"><?$s = "<select name=\"cat_id\"><option value=\"0\">(".$tracker_lang['choose'].")</option>";
$cats = get_list('categories');foreach ($cats as $catt) $s .= "<option value=\"".$catt["id"]."\">".htmlspecialchars_uni($catt["name"])."</option>";$s .= "</select>";?><?=$s?></td></tr>
<tr><td align="right" style="border:0;"><b>Качество</b></td><td style="border:0;">
<?$j = "<select name=\"incat_id\"><option value=\"0\">(".$tracker_lang['choose'].")</option>";
$incats = get_list('incategories');foreach ($incats as $incatt) $j .= "<option value=\"".$incatt["id"]."\">".htmlspecialchars_uni($incatt["name"])."</option>";$j .= "</select>";?><?=$j?></td></tr><?}?>
<tr><td align="right" style="border:0;"><b>Сколько хотите отдать бонусов?</b></td><td style="border:0;">
<input onkeyup="this.value = this.value.replace (/\D/, '')" type="text" name="bonus" value="<?=$bonus?>" placeholder="Сколько хотите отдать бонусов?" size="12" style="width:200px"></td></tr>
<?if(get_user_class() >= UC_MODERATOR and $_REQUEST['action'] == "edit"){?>
<tr><td align="right" style="border:0;"><b>Статус заказа</b></td><td style="border:0;"><select style="width:100px;" class='bros' name='status'>
<option value='1' <?if($status == "1"){print(" selected ");}?>>В ожидании</option><option value='2' <? if($status == "2"){
print(" selected ");}?>>Принято</option><option value='3' <?if($status == "3"){print(" selected ");}?>>Выполнено</option>
<option value='4' <?if($status == "4"){print(" selected ");}?>>Подтверждено</option></select></td></tr>
<?if($status == "1"){?><tr><td align="right" style="border:0;"><b>URL выложенного релиза</b></td><td style="border:0;">
<input type="text" name="url" value="<?=$url_r?>" placeholder="URL выложенного релиза" size="100" style="width:500px"></td></tr><?}}?>
</table><center><input type="submit" value="<?=$value?>"></center><br></form></div></td></tr></table></td></tr></table><?}else{
stderr2("Внимание", "<center>В данный момент вы не можете совершить это действие, вернуться <a href=\"zakaz.php\">назад</a></center><script>setTimeout('document.location.href=\"zakaz.php\"', 1000);</script>");}}else{
$janr = $_GET['janr'];$tip = $_GET['tip'];
if($janr){$query = "WHERE zakaz.cat_id LIKE '$janr' ORDER BY zakaz.data DESC";$querys = "WHERE zakaz.cat_id LIKE '$janr' ORDER BY zakaz.data DESC";$q = "&janr=$janr";}
elseif($tip){$query = "WHERE zakaz.incat_id LIKE '$tip' ORDER BY zakaz.data DESC";$querys = "WHERE zakaz.incat_id LIKE '$tip' ORDER BY zakaz.data DESC";$q = "&tip=$tip";}
else{$query = "ORDER BY zakaz.data DESC";$querys = "";}
$user = $_GET['user'];if($user){$query = "WHERE zakaz.user_id LIKE '$user' ORDER BY zakaz.data DESC";$querys = "WHERE zakaz.user_id LIKE '$user' ORDER BY zakaz.data DESC";
$q = "&user=$user";}
$status = $_GET['status'];if($status){$query = "WHERE zakaz.status LIKE '$status' ORDER BY zakaz.data DESC";
$querys = "WHERE zakaz.status LIKE '$status' ORDER BY zakaz.data DESC";$q = "&status=$status";}
$search = $_GET["search"];if($search){$query = "WHERE zakaz.name LIKE '%".sqlwildcardesc($search)."%' ORDER BY zakaz.data DESC";
$querys = "WHERE zakaz.name LIKE '%".sqlwildcardesc($search)."%' ORDER BY zakaz.data DESC";$q = "&search=$search";}
$page = (int) $_GET['page'];$perpage = 10;$cats = get_list('categories');$incats = get_list('incategories');
$res = mysql_query("SELECT COUNT(id) FROM zakaz $querys") or die(mysql_error());$arr = mysql_fetch_row($res);$count = $arr[0];
list($pagertop, $pagerbottom, $limit) = pager2($perpage, $count, "zakaz.php?".$q);
$res = sql_query("SELECT zakaz.id, zakaz.cat_id, zakaz.incat_id, zakaz.user_id, zakaz.cl_user_id, zakaz.class, zakaz.user, zakaz.status, zakaz.name, zakaz.bonus, zakaz.data, 
c.name AS cat_name, c.image AS cat_pic, i.name AS incat_name, i.image AS incat_pic FROM zakaz LEFT JOIN categories AS c ON zakaz.cat_id = c.id 
LEFT JOIN incategories AS i ON zakaz.incat_id = i.id $query $limit") or sqlerr(__FILE__, __LINE__);?>
<table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;border:0;"><tr>
<td style="border-radius:15px;border:none;" class='a'><table style="background:none;width:100%;float:center;border:0;"><tr>
<td class="zaliwka" style="color:#FFFFFF;colspan:14;height:20px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">
.:: Стол заказов ::.</td></tr><tr><td align="center" style="background:none;width:100%;float:center;border:0;">
<table style="background:none;border:0;" class="embedded" align="center"><form method="get" action="zakaz.php"><tr><td valign="top" class="bottom">
<table valign="top" class="embedded" cellspacing="0" style='border:0;background:none;' cellpadding="5" width="100%"><tr><td valign="top" class="bottom">
<table class="bottom" width="250px" style='border:0;' align="center">
<tr><td valign="top" class="zaliwka" style="font-family:tahoma;color:#FFFFFF;font-size:14px;text-align:center;border:0;border-radius:5px;"><center>.:: Genre ::.</center></td></tr>
</table><table class="bottom" style='border:0;' align="center"><tr>
<? $i = 0;foreach ($cats as $cat){$catsperrow = 2;print(($i && $i % $catsperrow == 0) ? "</tr><tr>" : "");
print("<td class=\"bottom\" style=\"padding-bottom:2px;padding-left:7px\">
<a class='catlink' href='zakaz.php?janr=$cat[id]'>•&nbsp;".htmlspecialchars_uni($cat[name])."</a></td>");$i++;}
$ncats = count($cats);$nrows = ceil($ncats / $catsperrow);$lastrowcols = $ncats % $catsperrow;
if($lastrowcols != 0){if($catsperrow - $lastrowcols != 1){print("<td class=\"bottom\" rowspan=\"".($catsperrow - $lastrowcols - 1)."\">&nbsp;</td>");}}?></tr></table>
</td><td valign="top" style='border:0;' class="bottom"><table valign="top" style='border:0;' class="bottom" width="550px" align="center">
<tr><td valign="top" class="zaliwka" style="font-family:tahoma;color:#FFFFFF;font-size:14px;text-align:center;border:0;border-radius:5px;"><center>.:: Quality ::.</center></td></tr>
</table><table class="bottom" align="center"><tr><? $j = 0;foreach ($incats as $incat){$incatsperrow = 4;print(($j && $j % $incatsperrow == 0) ? "</tr><tr>" : "");
print("<td class=\"bottom\" style=\"padding-bottom:2px;padding-left:7px\">
<a class='catlink' href='zakaz.php?tip=$incat[id]'>•&nbsp;".htmlspecialchars_uni($incat[name])."</a></td>");$j++;}
$nincats = count($incats);$ninrows = ceil($nincats / $incatsperrow);$lastrowcolsin = $nincats % $incatsperrow;
if($lastrowcolsin != 0){if($incatsperrow - $lastrowcolsin != 1){print("<td class=\"bottom\" rowspan=\"".($incatsperrow - $lastrowcolsin - 1)."\">&nbsp;</td>");}}?></tr></table></td>
</tr></table></td></tr><tr><td class="bottom"><table class="embedded" cellspacing="0" style='border:0;background:none;' cellpadding="5" width="100%"><tr>
<td valign="top" class="bottom"><table valign="top" style="background:none;border:0;" class="bottom" width="500px" align="center">
<tr><td valign="top" class="zaliwka" style="font-family:tahoma;color:#FFFFFF;font-size:14px;text-align:left;border:0;border-radius:5px;"><center>.:: SEARCH ::.</center></td></tr>
</table><table class="embedded" style="background:none;border:0;" align="center"><tr><td style="text-align:center;border:0;border-radius:5px;"><script src="js/suggestz.js"></script>
<input id="suggestinputz" name="search" type="text" size="60" value="<?=htmlspecialchars_uni($search)?>" placeholder="Search in 'Title'"/>
<input class="btn" type="submit" value="<?=$tracker_lang['search'];?>!"><div id="suggestz"></div></td></tr></table></td></tr></table></td></tr>
<?if(isset($search)){print("<tr><td style='background:none;border:0;text-align:center;font-weight:bold;' class=\"index\" colspan=\"12\"><hr>".$tracker_lang['search_results_for'].": '<font color=red>".htmlspecialchars_uni($search)."</font>'</td></tr>");}
if(isset($user)){print("<tr><td style='background:none;border:0;text-align:center;font-weight:bold;' class=\"index\" colspan=\"12\"><hr>".$tracker_lang['search_results_for'].": '<font color=red>Ваши заказы</font>'</td></tr>");}
if(isset($status)){print("<tr><td style='background:none;border:0;text-align:center;font-weight:bold;' class=\"index\" colspan=\"12\">
<hr>".$tracker_lang['search_results_for'].": '<font color=red>");
if($status == "1"){?>В ожидании<?}elseif($status == "2"){?>Принято<?}elseif($status == "3"){?>Выполнено<?}elseif($status == "4"){?>Подтверждено<?}
print("</font>'</td></tr>");}?></form></table></td></tr></table></td></tr></table>
<?if($count){if($count > 10){?>
<table style="margin-top:0px;background:none;cellspacing:0;cellpadding:0;width:100%;float:center;align:center;border:0;">
<tr><td align='center' style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;border:0;'><?=$pagertop?></td></tr></table><?}?>
<table style='background:none;margin-top:7px;cellspacing:0;cellpadding:0;width:100%;float:center;'><tr>
<td style='border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px;border:1px solid #E0FFFF;display:block;' class='a'><table style='background:none;width:100%;float:center;border:0;'>
<tr><td class='zaliwka' style='color:#FFFFFF;colspan:14;height:20px;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;'>
<table style='background:none;width:100%;float:center;border:0;'><tr><td align="center" style="min-width:70px;border:0"><u><b>Жанр</b></u></td>
<td align="center" style='border:0;background:none;min-width:70px;'><u><b>Качество</b></u></td><td style='background:none;border:0;min-width:70px;' align='center'></td>
<td align='left' style="width:100%;border:0">&nbsp;&nbsp;&nbsp;&nbsp;<u><b>Название</b></u></td>
<td align='right' style="border:0"><a href='?action=add'><input type="submit" value="Заказать"/></a></td>
<td align='right' style="border:0"><a href='?user=<?=$CURUSER ["id"]?>'><input type="submit" value="Мои заказы"/></a></td>
<td align='right' style="border:0"><a href='?status=1'><input type="submit" value="В ожидании"/></a></td>
<td align='right' style="border:0"><a href='?status=2'><input type="submit" value="Принято"/></a></td>
<td align='right' style="border:0"><a href='?status=3'><input type="submit" value="Выполнено"/></a></td>
<td align='right' style="border:0"><a href='?status=4'><input type="submit" value="Подтверждено"/></a></td>
</tr></table></td></tr><tr><td align='left' style='background:none;width:100%;float:center;border:0;'></td></tr></table></td></tr></table>
<table style="background:none;cellspacing:0;margin-top:0;cellpadding:0;width:100%;float:center;align:center;border:0;"><tr><td style="background:none;border:none;">
<?while($arr = mysql_fetch_array($res)){	
$cats = "<a href='?janr=".$arr["cat_id"]."'><img border='0' src='pic/cats/".$arr["cat_pic"]."' alt='".$arr["cat_name"]."'/></a>";
$incats = "<a href='?tip=".$arr["incat_id"]."'><img border='0' src='pic/cats/".$arr["incat_pic"]."' alt='".$arr["incat_name"]."'/></a>";
print("<table style='background:none;border:none;cellspacing:0;cellpadding:0;margin-top:7px;width:100%;float:center;'><tr>
<td style='border-radius:5px;-webkit-border-radius:5px;-moz-border-radius:5px;-khtml-border-radius:5px;border:1px solid white;display:block;' class='a'>
<table style='background:none;width:100%;float:center;border:0;'><tr><td align='center' style='background:none;width:100%;float:center;border:0;'>
<table style='background:none;cellspacing:0;cellpadding:0;margin-top:0;width:100%;float:center;'><tr>
<td style='background:none;margin-left:20px;border:0;width:70px;' align='left'>$cats</td><td style='background:none;border:0;width:70px;' align='center'>$incats</td>
<td style='background:none;border:0;width:10px;' align='center'></td><td style='background:none;border:0;' align='left'>
<a href='?action=zakaz&id={$arr['id']}' target=\"_blank\" alt='Подробнее о ".$arr["name"]."'><b>{$arr ['name']}</a>
<hr width='300px' align='left'><b>Заказал:&nbsp;<a href='user_{$arr["user_id"]}'>".get_user_class_color($arr["class"], $arr["user"])."</a></b>
&nbsp;<a href=\"#\" onclick=\"javascript:window.open('sendpm_".$arr['user_id']."', 'Отправить PM', 'width=650, height=465');return false;\" 
title=\"Отправить ЛС\"><img src='pic/pn_inbox.gif' border='0' title='PM'/></a>
&nbsp;&nbsp;<img src='pic/icon_topic.gif' border='0'/>&nbsp;<font size='1' color='grey'><i>".nicetime($arr["data"], true)."</i></font>");
if($CURUSER["id"] == "{$arr['user_id']}" && $arr ['status'] == "1" or get_user_class() >= UC_MODERATOR){
print("&nbsp;&nbsp;<a href=\"?action=edit&id={$arr['id']}\" ><img src=\"pic/button_edit.gif\" title=\"Редактировать\"/></a>
&nbsp;&nbsp;<a href=\"?action=del&id={$arr['id']}\"><img src=\"pic/button_delete.gif\" title=\"Удалить\"/></a>");}
print("</td><td style='width:160px;background:none;border:0;'>
<div style='width:150px;height:40px;background:white;text-align:center;border-radius:8px;-webkit-border-radius:8px;
-moz-border-radius:8px;-khtml-border-radius:8px;border:2px solid #E0FFFF;display:block;'>");
if($CURUSER["id"] == "{$arr['user_id']}" and $arr ['status'] == "3" or get_user_class() >= UC_MODERATOR and $arr ['status'] == "3"){
print("<div style='margin-top:10px;'><a href=\"?action=ok&id={$arr['id']}\"><span style='color:#008B8B;'><b>Подтвердить!</b></span></a>");}
if($CURUSER["id"] == "{$arr['cl_user_id']}" and $arr ['status'] == "2" or get_user_class() >= UC_MODERATOR and $arr ['status'] == "2"){
print("<div style='margin-top:0;'><a href=\"?action=url&id={$arr['id']}\"><span style='color:blue;'><b>Ввести URL релиза</b></span></a>");}

if($arr ['status'] == "2" and get_user_class() < UC_MODERATOR and $CURUSER["id"] != "{$arr['cl_user_id']}"){
print("<div style='margin-top:10px;'><span style='color:darkgreen;'><b>Заказ Принят!</b></span>");}

if($arr ['status'] == "3" and get_user_class() < UC_MODERATOR and $CURUSER["id"] != "{$arr['cl_user_id']}"){
print("<div style='margin-top:5px;'><span style='color:red;'><b>Заказ НЕ ПОДТВЕРЖДЕН!</b></span>");}
if($CURUSER["id"] > "{$arr['user_id']}" and $arr ['status'] == "1" or $CURUSER["id"] < "{$arr['user_id']}" and $arr ['status'] == "1"){
print("<div style='margin-top:10px;'><a href='?action=plus&id={$arr['id']}'><span style='color:green;'><b>Принять заказ</b></span></a>");}
if($CURUSER["id"] == "{$arr['user_id']}" and $arr ['status'] == "1"){print("<div style='margin-top:5px;'><span style='color:#999966;'><b>Заказ ждет исполнителя</b></span>");}
if($CURUSER["id"] == "{$arr['cl_user_id']}" and $arr ['status'] == "2" or get_user_class() >= UC_MODERATOR and $arr ['status'] == "2"){
print("<hr style='width:140px;'><a href=\"?action=minus&id={$arr['id']}\"><span style='color:#FF0000;'><b>Анулировать заказ</b></span></a>");}
if($arr ['status'] == "4"){print("<div style='margin-top:10px;'><span style='color:darkred;'><b>Заказ Выполнен!</b></span>");}
print("</div></div></td><td style='width:90px;background:none;border:0;'>
<div style='width:80px;height:40px;background:white;text-align:center;border-radius:8px;-webkit-border-radius:8px;
-moz-border-radius:8px;-khtml-border-radius:8px;border:2px solid #E0FFFF;display:block;'><b>".$arr['bonus']."</b>
<hr style='width:70px;'><span style=\"color:#999966\"><b>Бонус</b></span></div></td><td style='width:110px;background:none;border:0;'>
<div style='width:100px;height:40px;background:white;text-align:center;border-radius:8px;-webkit-border-radius:8px;
-moz-border-radius:8px;-khtml-border-radius:8px;border:2px solid #E0FFFF;display:block;'>");
if($arr["status"] == "1"){print("<span style=\"color:#800080\"><b>В ожидании</b></span>");}if($arr["status"] == "2"){
print("<span style=\"color:#B8860B\"><b>Принято</b></span>");}
if($arr["status"] == "3"){print("<span style=\"color:#FF4500\"><b>Выполнено</b></span>");}if($arr["status"] == "4"){
print("<span style=\"color:#008000\">Подтверждено</span>");}
print("<hr style='width:80px;'><span style=\"color:#999966\"><b>Статус</b></span></div></td></tr></table></td></tr></table></td></tr></table>");}
print("</td></tr></table>");?>
<table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;align:center;border:0;">
<tr><td align='center' style='background:none;cellspacing:0;cellpadding:0;width:100%;float:center;border:0;'><?=$pagerbottom?></td></tr></table><?}else{
if(isset($search)){print("<table style='background:none;margin-top:7px;cellspacing:0;cellpadding:0;width:300px;float:center;'><tr>
<td style='border-radius:15px;border:none;' class='a'><table style='background:none;width:100%;float:center;border:0;'><tr>
<td class='zaliwka' style='color:#FFFFFF;colspan:14;height:40px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;'>
".$tracker_lang['nothing_found']."</td></tr><tr><td align='center' style='background:none;width:100%;float:center;border:0;'></td></tr></table></td></tr></table>");}
if(isset($user)){print("<table style='background:none;margin-top:7px;cellspacing:0;cellpadding:0;width:300px;float:center;'><tr>
<td style='border-radius:15px;border:none;' class='a'><table style='background:none;width:100%;float:center;border:0;'><tr>
<td class='zaliwka' style='color:#FFFFFF;colspan:14;height:40px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;'>
".$tracker_lang['nothing_found']."</td></tr><tr><td align='center' style='background:none;width:100%;float:center;border:0;'></td></tr></table></td></tr></table>");}
if(isset($status)){print("<table style='background:none;margin-top:7px;cellspacing:0;cellpadding:0;width:300px;float:center;'><tr>
<td style='border-radius:15px;border:none;' class='a'><table style='background:none;width:100%;float:center;border:0;'><tr>
<td class='zaliwka' style='color:#FFFFFF;colspan:14;height:40px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;'>
".$tracker_lang['nothing_found']."</td></tr><tr><td align='center' style='background:none;width:100%;float:center;border:0;'></td></tr></table></td></tr></table>");}}?>
<table style='background:none;border:none;cellspacing:0;cellpadding:0;margin-top:7px;width:70%;float:center;'><tr>
<td style='border-radius:5px;-webkit-border-radius:5px;-moz-border-radius:5px;-khtml-border-radius:5px;border:1px solid white;display:block;' class='a'>
<table style='background:none;width:100%;float:center;border:0;'><tr><td align='left' style='background:none;width:100%;float:left;border:0;'>
<table style='background:none;cellspacing:0;cellpadding:0;margin-top:0;width:100%;float:left;'>
<font color='red'><b>В момент заказа, пользователь соглашается с тем, что он должен будет отдать определенную часть бонусов, которую он определил сам.</b></font>
<hr><b><u>Как заказать:</u></b><br><b>1.</b> Нажимаем на кнопочку <b>Заказать</b> (она выше)<br>
<b>2.</b> Вводим данные о заказе и подтверждаем заказ. Ждём когда ваш заказ примут!<br>
<b>3.</b> Как только ваш заказ обретёт статус <span style="color:#FF4500"><b>Выполнено</b></span>, 
Вы должны нажать на <span style="color:#008B8B"><b>Подтвердить!</b></span><hr><b><u>Как принять заказ:</u></b><br>
<b>1.</b> Принимаем заказ нажатием на <span style='color:green;'><b>Принять заказ</b></span>. После этого, никто не сможет забрать этот заказ и 
<b>Вы</b>, будете должны его выполнить или анулировать нажатием на <span style='color:#FF0000;'><b>Анулировать заказ</b></span><br>
<b>2.</b> После того как Вы приняли заказ, нужно залить на трекер релиз, каторый просит пользователь и скопировать его адрес в строке браузера. 
Теперь нажимаем на <span style='color:blue;'><b>Ввести URL релиза</b></span>, вставляем скопированный адрес и подтверждаем!<br>
<b>3.</b> Пользователь, который выложил заказ, проверит - тот ли это релиз и если тот, то он должен нажать на <span style="color:#008B8B"><b>Подтвердить!</b></span><br>
<b>4.</b> Если <b>Заказчик</b> не подтвердил выполненый заказ, <b>Исполнитель</b> (выполнивший релиз) может пожаловаться 
<a href='team'><span style="color:#FF4500"><b>Администрации</b></span></a> и они после проверки подтвердят заказ, 
а <b>Заказчик</b> получит пи***... в общем - карательные операции (аппендицит покажется легким насморком).
<?if(get_user_class() >= UC_MODERATOR){
print("<hr><b style='color:#ff0000'>Учтите - ВЫ сейчас имеете права модератора! Можете одобрить, поменять статус, удалить, отредактировать любой заказ!</b>");
}print("</table></td></tr></table></td></tr></table>");}stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
