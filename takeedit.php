<?
require_once("include/bittorrent.php");
dbconn();
maxsysop();
loggedinorreturn();

function bark($msg) {
	stderr($tracker_lang['error'], $msg);
}



if (!mkglobal("id:name:tube:poster:descr:screenshot1:screenshot2:screenshot3:screenshot4:type"))
	bark("missing form data");

$id = 0 + $id;
if (!$id)
	die();



$res = sql_query("SELECT owner FROM torrents WHERE id = $id");
$row = mysql_fetch_array($res);
if (!$row)
	die();

if ($CURUSER["id"] != $row["owner"] && get_user_class() < UC_MODERATOR)
	bark($tracker_lang['torrent_cant_edit']);


///generate url from name
$seo = generate_chpu($name);


$updateset = array();




if (!$name)
	bark($tracker_lang['torrent_add_tname']);
	
if (!$descr)
	bark($tracker_lang['torrent_need_desc']);


$lang = unesc($_POST["lang"]);


$replace = array(", ", " , ", " ,");
$tags = trim(str_replace($replace, ",", mb_convert_case(unesc($_POST["tags"]), MB_CASE_LOWER, $mysql_charset)));

if (get_user_class() >= UC_UPLOADER) {
$updateset[] = "modded = '" . ($_POST["modded"] ? "yes" : "no") . "'";
$updateset[] = "sticky = '" . ($_POST["sticky"] ? "yes" : "no") . "'";
}
$updateset[] = "lang = " . sqlesc($lang);
$updateset[] = "scrape = '" . ($_POST["scrape"] ? "yes" : "no") . "'";
$updateset[] = "anonymous = '" . ($_POST["anonymous"] ? "yes" : "no") . "'";
$updateset[] = "name = " . sqlesc(htmlspecialchars($name));
$updateset[] = "tags = " . sqlesc(htmlspecialchars($tags));
$updateset[] = "tube = ".sqlesc(htmlspecialchars($tube));
$updateset[] = "descr = " . sqlesc($descr);
$updateset[] = "screenshot1 = " . sqlesc(htmlspecialchars($screenshot1));
$updateset[] = "screenshot2 = " . sqlesc(htmlspecialchars($screenshot2));
$updateset[] = "screenshot3 = " . sqlesc(htmlspecialchars($screenshot3));
$updateset[] = "screenshot4 = " . sqlesc(htmlspecialchars($screenshot4));
$updateset[] = "category = " . (0 + $type);
$updateset[] = "poster = " . sqlesc(htmlspecialchars($poster));
$updateset[] = "url = " . sqlesc(htmlspecialchars($seo));


sql_query("UPDATE torrents SET " . join(",", $updateset) . " WHERE id = $id");



$returl = "$DEFAULTBASEURL/details.php?id=$id";


header("Refresh: 0; url=$returl");

?>
