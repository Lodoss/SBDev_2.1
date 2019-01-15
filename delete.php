<?

require_once("include/bittorrent.php");

dbconn();

loggedinorreturn();

maxsysop();

function bark($msg) {
	stderr($tracker_lang['error'], $msg);
}

if (get_user_class() < UC_MODERATOR)
bark($tracker_lang['access_denied']);



$id = (int)$_GET["id"];

if (!is_valid_id($id))
        stderr($tracker_lang['error'], $tracker_lang['invalid_id']);



$res = sql_query("SELECT name,owner,seeders FROM torrents WHERE id = $id");
$row = mysql_fetch_array($res);
if (!$row)
	stderr($tracker_lang['error'], $tracker_lang['invalid_id']);
	
	
	
	
	

$sure = (int)$_GET["sure"];

  if (!$sure) {
  
		stderr($tracker_lang['delete'], sprintf($tracker_lang['you_want_to_delete_x_click_here'],$tracker_lang['torrent'],"?id=$id&sure=1"));
 
  } else {

deletetorrent($id);

header ("Refresh: 1; url=/browse.php");

bark("Torrent ($row[name]) deleted!");

}

?>
