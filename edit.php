<?
require_once("include/bittorrent.php");
include("include/torr_langs.php");
require_once("include/editor.php");


maxsysop ();
dbconn();
loggedinorreturn();

$id = (int)$_GET["id"];

if (!is_valid_id($id))
        stderr($tracker_lang['error'], $tracker_lang['invalid_id']);


$res = sql_query("SELECT * FROM torrents WHERE id = $id");
$row = mysql_fetch_array($res);
if (!$row)
        stderr($tracker_lang['error'], $tracker_lang['invalid_id']);







stdhead("" . $tracker_lang['torrent_edit'] . " \"" . $row["name"] . "\"");

if (!isset($CURUSER) || ($CURUSER["id"] != $row["owner"] && get_user_class() < UC_MODERATOR)) {
	stdmsg($tracker_lang['error'], $tracker_lang['torrent_cant_edit']);
} else {
	print("<form name=\"edit\" id=\"edit\" method=post action='$DEFAULTBASEURL/takeedit.php' enctype=multipart/form-data>\n");
	print("<input type=\"hidden\" name=\"id\" value=\"$id\">\n");

	print("<table class=\"bordered\" width=\"100%\">\n");
	
	
echo "<thead><tr>";

echo "<th colspan='2'>";

echo $tracker_lang['torrent_edit'];

echo "</th>";

echo "</tr></thead>";
	
	
	
tr($tracker_lang['torrent_name'], "<input type=\"text\" name=\"name\" value=\"" . htmlspecialchars($row["name"]) . "\" size=\"80\" />", 1);


tr($tracker_lang['torrent_poster'], "<input type=text name=poster size=80 value=\"" . htmlspecialchars($row["poster"]) . "\" placeholder='" . $tracker_lang['torrent_poster_descr'] . "'>", 1);
	
	
print("<tr><td colspan='2' align='center'>");
	textbbcode("edit","descr",$row["descr"]);
print("</td></tr>\n");




//////////torrent language selector
$tlang = "<select name=\"lang\"><option value=\"0\">(" . $tracker_lang['choose_lang'] . ")</option>";
foreach ($torrent_lang as $idss => $names)
$tlang .= "<option value=\"$idss\"".($row["lang"] == $idss ? " selected" : "").">$names</option>";
$tlang .= "</select>";
//////////torrent language selector

echo "<tr><td class='rowhead'>" . $tracker_lang['t_lang'] . "</td><td>$tlang</td></tr>";



tr($tracker_lang['torrent_trailer'], "<input type=\"text\" name=\"tube\" size=\"80\" value=\"" . htmlspecialchars($row["tube"]) . "\" placeholder='" . $tracker_lang['torrent_trailer_desc'] . "' />", 1);

tr($tracker_lang['torrent_screens'], "<input type=\"text\" name=\"screenshot1\" value=\"" . htmlspecialchars($row["screenshot1"]) . "\" size=\"80\" placeholder='" . $tracker_lang['torrent_screens_desc'] . " 1' /><div class='spacer'></div><input type=\"text\" name=\"screenshot2\" value=\"" . htmlspecialchars($row["screenshot2"]) . "\" size=\"80\" placeholder='" . $tracker_lang['torrent_screens_desc'] . " 2' /><div class='spacer'></div><input type=\"text\" name=\"screenshot3\" value=\"" . htmlspecialchars($row["screenshot3"]) . "\" size=\"80\" placeholder='" . $tracker_lang['torrent_screens_desc'] . " 3' /><div class='spacer'></div><input type=\"text\" name=\"screenshot4\" value=\"" . htmlspecialchars($row["screenshot4"]) . "\" size=\"80\" placeholder='" . $tracker_lang['torrent_screens_desc'] . " 4' />", 1);

	$s = "<select name=\"type\">\n";

	$cats = genrelist();
	foreach ($cats as $subrow) {
		$s .= "<option value=\"" . $subrow["id"] . "\"";
		if ($subrow["id"] == $row["category"])
			$s .= " selected=\"selected\"";
		$s .= ">" . htmlspecialchars($subrow["name"]) . "</option>\n";
	}

	$s .= "</select>\n";
	tr($tracker_lang['type'], $s, 1);
	
	
	  $s = "<input type=\"text\" id=\"tags\" name=\"tags\" value=\"" . htmlspecialchars($row["tags"]) ."\" size=\"80\" placeholder='" . $tracker_lang["torrent_tags_descr"] . "'>";
  tr($tracker_lang['torrent_tags'], $s, 1);





	tr($tracker_lang['torrent_external'], "<input type=\"checkbox\" name=\"scrape\"" . (($row["scrape"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" /> " . $tracker_lang["torrent_external_desc"] . "", 1);


	tr($tracker_lang['torrent_annonym'], "<input type=\"checkbox\" name=\"anonymous\"" . (($row["anonymous"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" /> " . $tracker_lang["torrent_annonym_desc"] . "", 1);
	
	
	
	if (get_user_class() >= UC_MODERATOR) {

	tr($tracker_lang['torrent_modded'], "<input type=\"checkbox\" name=\"modded\"" . (($row["modded"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" /> " . $tracker_lang['torrent_modded_desc'] . "", 1);
	
	tr($tracker_lang['torrent_sticky'], "<input type=\"checkbox\" name=\"sticky\"" . (($row["sticky"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" /> " . $tracker_lang['torrent_sticky_desc'] . "", 1);

	
	
	}
	
	
	print("</table>\n");
	
	print("<div class='spacer'></div>");
	
	print("<div align='center'>");
	
	print("<input type=\"submit\" value=\"" . $tracker_lang['torrent_edit_btn'] . "\" class=\"btn btn-blue\">");
	print("</form>\n");
	
	if (get_user_class() >= UC_MODERATOR) {
	print("<a href='$DEFAULTBASEURL/delete.php?id=$id' class=\"btn btn-red\">" . $tracker_lang['torrent_delete_btn'] . "</a>\n");
	}
	
	print("</div>");

	
	
	
	

}

stdfoot();

?>