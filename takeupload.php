<?
require_once("include/benc.php");
require_once("include/bittorrent.php");
require_once("include/Torrent.php");


ini_set("upload_max_filesize",$max_torrent_size);

function bark($msg) {
	stderr($tracker_lang['error'], $msg);
}

dbconn(); 

loggedinorreturn();

maxsysop();

foreach(explode(":","descr:type:screenshot1:screenshot2:screenshot3:screenshot4:name") as $v) {
	if (!isset($_POST[$v]))
		bark("missing form data");
}


$replace = array(", ", " , ", " ,");

$tags = trim(str_replace($replace, ",", mb_convert_case(unesc($_POST["tags"]), MB_CASE_LOWER, $mysql_charset)));


if (!empty($_POST['lang']))
$lang = unesc($_POST["lang"]);

if (!empty($_POST['tube']))
$tube = unesc($_POST["tube"]);

if (!empty($_POST['poster']))
$poster = unesc($_POST['poster']);

if (!isset($_FILES["file"]))
	bark("missing form data");

$f = $_FILES["file"];
$fname = unesc($f["name"]);
if (empty($fname))
	bark($tracker_lang['torrent_upload_failed']);
	

$descr = unesc($_POST["descr"]);
if (!$descr)
	bark($tracker_lang['torrent_need_desc']);

// 4 SCREENSHOT FIELDS BY SQUAD-G
// ==START
if (!empty($_POST['screenshot1']))
$screenshot1 = unesc($_POST["screenshot1"]);

if (!empty($_POST['screenshot2']))
$screenshot2 = unesc($_POST["screenshot2"]);
 
if (!empty($_POST['screenshot3']))
$screenshot3 = unesc($_POST["screenshot3"]);

if (!empty($_POST['screenshot4']))
$screenshot4 = unesc($_POST["screenshot4"]);

// ==END

$catid = (0 + $_POST["type"]);
if (!is_valid_id($catid))
	bark($tracker_lang['torrent_need_cat']);
	
if (!validfilename($fname))
	bark($tracker_lang['torrent_invalid_filename']);
if (!preg_match('/^(.+)\.torrent$/si', $fname, $matches))
	bark($tracker_lang['torrent_not_torrent']);
$shortfname = $torrent = $matches[1];
if (!empty($_POST["name"]))
$torrent = unesc($_POST["name"]);


$tmpname = $f["tmp_name"];
if (!is_uploaded_file($tmpname))
	bark("eek");
if (!filesize($tmpname))
	bark($tracker_lang['torrent_empty_file']);

$dict = bdec_file($tmpname, $max_torrent_size);
if (!isset($dict))
	bark($tracker_lang['torrent_not_binary']);


if ($_POST['uplver'] == 'yes') {
$anonymous = "yes";
} else {
$anonymous = "no";
}


if ($_POST['scrape'] == 'yes') {
$scrape = "yes";
} else {
$scrape = "no";
}


if (get_user_class() >= UC_UPLOADER) {
$modded = "yes";
} else {
$modded = "no";
}



// Replace punctuation characters with spaces

$torrent = htmlspecialchars(str_replace("_", " ", $torrent));

$seo = generate_chpu($torrent);

$ret = sql_query("INSERT INTO torrents (owner, modded, anonymous, scrape, name, lang, tags, tube, poster, screenshot1, screenshot2, screenshot3, screenshot4, descr, category, added) VALUES (" . implode(",", array_map("sqlesc", array($CURUSER["id"], $modded, $anonymous, $scrape, $torrent, $lang, $tags, $tube, $poster, $screenshot1, $screenshot2, $screenshot3, $screenshot4, $descr, 0 + $_POST["type"]))) . ", '" . get_date_time() . "')");

if (!$ret) {
	if (mysql_errno() == 1062)
		bark("torrent already uploaded!");
	bark("mysql puked: ".mysql_error());
}

$id = mysql_insert_id();

move_uploaded_file($tmpname, "$torrent_dir/$id.torrent");


$torrent2 = new Torrent("$torrent_dir/$id.torrent"); 

	$t_hash     = $torrent2->hash_info();
	$mag        = $torrent2->magnet(); ///generate magnet link
	$tor_size   = $torrent2->size( 2 );

$info_hash  = sqlesc($t_hash);
$magnet     = sqlesc($mag); ///generate magnet link
$fsize      = sqlesc($tor_size);

sql_query("UPDATE torrents SET magnet=$magnet, size=$fsize, info_hash=UNHEX($info_hash) WHERE id = $id")  or sqlerr(__FILE__,__LINE__);


 if ($scrape == 'yes') {	
				require_once ("include/Tupdate.php");
				scrape_check($id); //scrape peer info from external tracker
				}
/////////



header("Location: $DEFAULTBASEURL/details.php?id=$id");
?>
