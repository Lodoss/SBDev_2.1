<?php
//error_reporting(E_ALL);
//ini_set( 'display_errors','1'); 
require_once("include/bittorrent.php");
require_once "include/benc.php";
require_once("include/Torrent.php");


dbconn();


if (@ini_get('output_handler') == 'ob_gzhandler' AND @ob_get_length() !== false)
{    // if output_handler = ob_gzhandler, turn it off and remove the header sent by PHP
    @ob_end_clean();
    header('Content-Encoding:');
}

$id = (int) $_GET["id"];

if (!is_numeric($id))
    stderr($tracker_lang['error'],$tracker_lang['invalid_id']);

$res = sql_query("SELECT category FROM torrents WHERE torrents.id = ".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
$row = mysql_fetch_assoc($res);
if (!$row)
stderr($tracker_lang['error'], $tracker_lang['invalid_id']);

if ($row["category"] == "6" && $CURUSER["view_xxx"] != "yes")
	stderr("Ошибка", "Вы не зарегистрированы на сайте чтобы скачивать с ХХХ раздела либо вы при регистрации указали что не желаете скачивать с ХХХ раздела!");


$fn = "$torrent_dir/$id.torrent"; 


$torrent = new Torrent("$torrent_dir/$id.torrent"); 

$name = $torrent->name(); //getting real torrent name

if (!$row || !is_file($fn) || !is_readable($fn))
    stderr($tracker_lang['error'], "Can not read torrent file");

$dict = bdec_file($fn, (1024*1024));


header ("Expires: Tue, 1 Jan 1980 00:00:00 GMT");
header ("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header ("Cache-Control: no-store, no-cache, must-revalidate");
header ("Cache-Control: post-check=0, pre-check=0", false);
header ("Pragma: no-cache");
header ("Accept-Ranges: bytes");
header ("Connection: close");
header ("Content-Transfer-Encoding: binary");
header ("Content-Disposition: attachment; filename=\"[SeedBay.net]_".$name.".torrent\"");
header ("Content-Type: application/x-bittorrent");
ob_implicit_flush(true);

print(benc($dict));


?>