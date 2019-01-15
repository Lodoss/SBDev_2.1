<?

require "include/bittorrent.php";

dbconn(false);

maxsysop();


function bark($msg) {
	global $tracker_lang;
	stdhead($tracker_lang['error']);
	stdmsg($tracker_lang['error'], $msg);
	stdfoot();
	exit;
}

if (get_user_class() < UC_MODERATOR)
	bark($tracker_lang['access_denied']);

$id = (int)$_GET["id"];

if (!is_valid_id($id))
  bark($tracker_lang['invalid_id']);



if (get_user_class() >= UC_MODERATOR && $user["class"] < get_user_class())
{


$r = @sql_query("SELECT * FROM users WHERE id=$id") or sqlerr(__FILE__, __LINE__);
$user = mysql_fetch_array($r) or bark("Нет пользователя с таким ID $id.");

if ($user["ip"]) {
  $ip = $user["ip"];
  $dom = @gethostbyaddr($user["ip"]);
  if ($dom == $user["ip"] || @gethostbyname($dom) != $user["ip"])
    $addr = $ip;
  else
  {
    $dom = strtoupper($dom);
    $domparts = explode(".", $dom);
    $domain = $domparts[count($domparts) - 2];
    if ($domain == "COM" || $domain == "CO" || $domain == "NET" || $domain == "NE" || $domain == "ORG" || $domain == "OR" )
      $l = 2;
    else
      $l = 1;
    $addr = "<a href=\"http://whois.domaintools.com/$ip\" target=\"_blank\">$ip</a> ($dom)";
  }
}


if ($user[added] == "0000-00-00 00:00:00")
	$joindate = 'N/A';
else
	$joindate = nicetime($user[added], true);

if ($user[last_access] == "0000-00-00 00:00:00")
  $lastseen = $tracker_lang['never'];
else 
  $lastseen = nicetime($user[last_access], true);

			     if (strtotime($user["last_access"]) > gmtime() - 600) {
			     	$online = "<img border=\"0\" src=\"pic/online_ru.gif\" title=\"В сети\">";
			     }



stdhead("Просмотр профиля " . $user["username"]);


print("<table class='bordered' width=\"100%\">\n");


echo "<thead><tr>";

echo "<th colspan='2'>";

echo "<div style=\"float: left; width: auto;\">Просмотр профиля - " . $user[username] . "</div><div align=\"right\">" . $online . "</div>";

echo "</th>";

echo "</tr></thead>";


$enabled = $user["enabled"] == 'yes';
if (!$enabled)
print("<tr><td colspan=2><div class=error align=\"center\"><b>Этот аккаунт отключен</b></div></td></tr>\n");
?>
<tr><td class=rowhead width=1%>Зарегистрирован</td><td align=left width=99%><?=$joindate?></td></tr>
<tr><td class=rowhead>Был на трекере</td><td align=left><?=$lastseen?></td></tr>
<?

if ($addr)
print("<tr><td class=\"rowhead\">IP</td><td align=\"left\">$addr</td></tr>\n");
print("<tr><td class=\"rowhead\">Email</td><td align=\"left\"><a href=\"mailto:$user[email]\">$user[email]</a></td></tr>\n");




  print("<form method=\"post\" action=\"$DEFAULTBASEURL/modtask.php\">\n");
  print("<input type=\"hidden\" name=\"action\" value=\"edituser\">\n");
  print("<input type=\"hidden\" name=\"userid\" value=\"$id\">\n");
  print("<input type=\"hidden\" name=\"returnto\" value=\"edituser.php?id=$id\">\n");

	if (get_user_class() == UC_MODERATOR && $user["class"] > UC_UPLOADER)
	  print("<input type=\"hidden\" name=\"class\" value=\"$user[class]\">\n");
	else
	{
	  print("<tr><td class=\"rowhead\">Класс</td><td align=\"left\"><select name=\"class\">\n");
	  if (get_user_class() == UC_SYSOP)
	  	$maxclass = UC_SYSOP;
	  elseif (get_user_class() == UC_MODERATOR)
	    $maxclass = UC_UPLOADER;
	  else
	    $maxclass = get_user_class() - 1;
	  for ($i = 0; $i <= $maxclass; ++$i)
	    print("<option value=\"$i\"" . ($user["class"] == $i ? " selected" : "") . ">$prefix" . get_user_class_name($i) . "\n");
	  print("</select></td></tr>\n");
	}
	$modcomment = htmlspecialchars($user["modcomment"]);
	print("<tr><td class=rowhead>История пользователя</td><td align=left><textarea cols=60 rows=6".(get_user_class() < UC_SYSOP ? " readonly" : " name=modcomment").">$modcomment</textarea></td></tr>\n");
	print("<tr><td class=rowhead>Добавить заметку</td><td align=left><textarea cols=60 rows=3 name=modcomm></textarea></td></tr>\n");

print("<tr><td class=\"rowhead\">Может комментировать</td><td align=\"left\"><input type=\"radio\" name=\"comment\" value=\"yes\"" . ($user["comment"] == "yes" ? " checked" : "") . ">Да <input type=\"radio\" name=\"comment\" value=\"no\"" . ($user["comment"] == "no" ? " checked" : "") . ">Нет</td></tr>\n");
print("<tr><td class=\"rowhead\" rowspan=\"2\">Включен</td><td align=\"left\"><input name=\"enabled\" value=\"yes\" type=\"radio\"" . ($enabled ? " checked" : "") . ">Да <input name=\"enabled\" value=\"no\" type=\"radio\"" . (!$enabled ? " checked" : "") . ">Нет</td></tr>\n");
    if ($enabled)
    	print("<tr><td align=\"left\">Причина отключения:&nbsp;<input type=\"text\" name=\"disreason\" size=\"60\" /></td></tr>");
	else
		print("<tr><td align=\"left\">Причина включения:&nbsp;<input type=\"text\" name=\"enareason\" size=\"60\" /></td></tr>");
if ($CURUSER["class"] < UC_SYSOP)
  	print("<input type=\"hidden\" name=\"deluser\">");
  else
  	print("<tr><td class=\"rowhead\">Удалить</td><td align=\"left\"><input type=\"checkbox\" name=\"deluser\"></td></tr>");
  	print("</table>\n");
  	
  	
  print("<div class='spacer'></div>\n");

  print("<div align='center'><input type=\"submit\" class=\"btn\" value=\"ОК\"></div>\n");
  print("</form>\n");
}




stdfoot();

?>