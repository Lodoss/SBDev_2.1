<?
require_once("include/bittorrent.php");

dbconn(false);

loggedinorreturn();

maxsysop();

stdhead($tracker_lang['my_my']);



print("<form method=\"post\" action=\"$DEFAULTBASEURL/takeprofedit.php\">");


print("<table class='bordered' width=\"100%\">");


echo "<thead><tr>";

echo "<th colspan='2'>";

echo $tracker_lang['my_my'];

echo "</th>";

echo "</tr></thead>";



if ($_GET["edited"]) {
	print("<tr><td colspan=\"2\"><div class=success align='center'><h1>".$tracker_lang['my_updated']."</h1></div></td></tr>\n");
	if ($_GET["mailsent"])
		print("<tr><td colspan=\"2\"><div class=success align='center'><h1>".$tracker_lang['my_mail_sent']."</h1></div></td></tr>\n");
}
elseif ($_GET["emailch"])
	print("<tr><td colspan=\"2\"><div class=success><h1>".$tracker_lang['my_mail_updated']."</h1></div></td></tr>\n");


tr($tracker_lang['my_mail'], "<input type=\"text\" name=\"email\" size='50' value=\"" . htmlspecialchars($CURUSER["email"]) . "\" />", 1);

tr($tracker_lang['my_old_pass'], "<input type=\"password\" name=\"oldpassword\" size='50' />", 1);
tr($tracker_lang['my_new_pass'], "<input type=\"password\" name=\"chpassword\" size='50' />", 1);
tr($tracker_lang['my_new_pass_again'], "<input type=\"password\" name=\"passagain\" size='50' />", 1);
tr($tracker_lang['my_xxx_torrents'], "<input type=checkbox name=view_xxx" . ($CURUSER["view_xxx"] == "yes" ? " checked" : "") . "> " . $tracker_lang['my_xxx_descr'] . "",1);

print("<tr><td colspan=\"2\" background=\"/pic/lined_bg.gif\" align=left>" . $tracker_lang['my_mail_update_descr'] . "</td></tr>\n");


print("</table>");

print("<div class='spacer'></div>");

print("<div align='center'><input class=\"btn\" type=\"submit\" value=\"" . $tracker_lang['update'] . "\"></div>");

print("</form>");


stdfoot();
?>
