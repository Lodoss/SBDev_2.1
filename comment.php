<?

require_once("include/bittorrent.php");

$action = $_GET["action"];

dbconn(false);
loggedinorreturn();
maxsysop();


if ($CURUSER["comment"] == 'no' || !$CURUSER)
{
stderr($tracker_lang['error'], $tracker_lang['comments_disable']);
}

if ($action == "add")
{
  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
    $torrentid = 0 + $_POST["tid"];
	  if (!is_valid_id($torrentid))
			stderr($tracker_lang['error'], $tracker_lang['invalid_id']);
		$res = sql_query("SELECT name FROM torrents WHERE id = $torrentid") or sqlerr(__FILE__,__LINE__);
		$arr = mysql_fetch_array($res);
		if (!$arr)
		  stderr($tracker_lang['error'], $tracker_lang['no_torrent_with_such_id']);


	$res2 = sql_query("SELECT user, id FROM comments WHERE torrent = $torrentid ORDER BY id DESC LIMIT 1") or sqlerr(__FILE__,__LINE__);
	$arr2 = mysql_fetch_array($res2);
	if ($arr2[user] == $CURUSER[id])
	stderr($tracker_lang['your_comment_was_last'], "" . $tracker_lang['to_change_comment_click'] . " [<a href=?action=edit&cid=$arr2[id]>" . $tracker_lang['btn_edit_comment'] . "</a>]");

$userid = $CURUSER["id"];
$wantusername = $CURUSER["username"];



	  $text = trim($_POST["text"]);
	  if (!$text)
			stderr($tracker_lang['error'], $tracker_lang['comment_cant_be_empty']);

if ($CURUSER && get_user_class() < UC_MODERATOR) {
  $minutes = 10;
  $limit = 5;
  $res = mysql_query("SELECT COUNT(*) FROM comments WHERE user = $CURUSER[id] AND added > '".get_date_time(gmtime() - ($minutes * 60))."'") or sqlerr(__FILE__,__LINE__);
  $row = mysql_fetch_row($res);

  if ($row[0] > $limit)
    stderr($tracker_lang['error'], sprintf($tracker_lang['comments_flood'], $limit, $minutes));
    
}

	  sql_query("INSERT INTO comments (user, torrent, added, text, ip) VALUES ($userid,$torrentid, '" . get_date_time() . "', " . sqlesc($text) . "," . sqlesc(getip()) . ")");

	  $newid = mysql_insert_id();

	  sql_query("UPDATE torrents SET comments = comments + 1 WHERE id = $torrentid");


	  header("Refresh: 0; url=details.php?id=$torrentid");
	  die;
	}
}
elseif ($action == "edit")
{
  $commentid = 0 + $_GET["cid"];
  if (!is_valid_id($commentid))
		stderr($tracker_lang['error'], $tracker_lang['invalid_id']);

  $res = sql_query("SELECT c.*, t.name, t.id AS tid FROM comments AS c LEFT JOIN torrents AS t ON c.torrent = t.id WHERE c.id=$commentid") or sqlerr(__FILE__,__LINE__);
  $arr = mysql_fetch_array($res);
  if (!$arr)
  	stderr($tracker_lang['error'], $tracker_lang['invalid_id']);

	if ($arr["user"] != $CURUSER["id"] && get_user_class() < UC_MODERATOR)
		stderr($tracker_lang['error'], $tracker_lang['access_denied']);

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
	  $text = $_POST["text"];
    $returnto = $_POST["returnto"];

	  if ($text == "")
	  	stderr($tracker_lang['error'], $tracker_lang['comment_cant_be_empty']);

	  $text = sqlesc($text);

	  $editedat = sqlesc(get_date_time());

	  sql_query("UPDATE comments SET text=$text, editedat=$editedat, editedby=$CURUSER[id] WHERE id=$commentid") or sqlerr(__FILE__, __LINE__);

		if ($returnto)
	  	header("Location: $returnto");
		else
		  header("Location: $DEFAULTBASEURL/");      // change later ----------------------
		die;
	}

 	stdhead("" . $tracker_lang['edit_comment_for'] . " \"" . $arr["name"] . "\"");

	print("<form method=\"post\" name=\"comment\" action=\"comment.php?action=edit&amp;cid=$commentid\">\n");
	print("<input type=\"hidden\" name=\"returnto\" value=\"details.php?id={$arr["tid"]}&amp;viewcomm=$commentid#comm$commentid\" />\n");
	print("<input type=\"hidden\" name=\"cid\" value=\"$commentid\" />\n");

echo "<div align='center'>";


echo "<textarea name='text' rows='10' cols='60'>" . htmlspecialchars($arr["text"]) . "</textarea>";


	//textbbcode("comment","text",htmlspecialchars($arr["text"]));

echo "<p></p>";

	print("<input class='btn' type=\"submit\" value=\"" . $tracker_lang['btn_edit_comment'] . "\" />\n");

echo "</div>";

echo "</form>";
	stdfoot();
	die;
}
elseif ($action == "delete")
{
	if (get_user_class() < UC_MODERATOR)
		stderr($tracker_lang['error'], $tracker_lang['access_denied']);

  $commentid = 0 + $_GET["cid"];

  if (!is_valid_id($commentid))
		stderr($tracker_lang['error'], $tracker_lang['invalid_id']);

  $sure = $_GET["sure"];

  if (!$sure)
  {
		stderr($tracker_lang['delete']." ".$tracker_lang['comment'], sprintf($tracker_lang['you_want_to_delete_x_click_here'],$tracker_lang['comment'],"?action=delete&cid=$commentid&sure=1"));
  }


	$res = sql_query("SELECT torrent FROM comments WHERE id=$commentid")  or sqlerr(__FILE__,__LINE__);
	$arr = mysql_fetch_array($res);
	if ($arr)
		$torrentid = $arr["torrent"];

	sql_query("DELETE FROM comments WHERE id=$commentid") or sqlerr(__FILE__,__LINE__);
	if ($torrentid && mysql_affected_rows() > 0)
		sql_query("UPDATE torrents SET comments = comments - 1 WHERE id = $torrentid");

	list($commentid) = mysql_fetch_row(sql_query("SELECT id FROM comments WHERE torrent = $torrentid ORDER BY added DESC LIMIT 1"));

	$returnto = "details.php?id=$torrentid&amp;viewcomm=$commentid#comm$commentid";

	if ($returnto)
	  header("Location: $returnto");
	else
	  header("Location: $DEFAULTBASEURL/");      // change later ----------------------
	die;
}
else
	stderr($tracker_lang['error'], "Unknown action");

die;
?>
