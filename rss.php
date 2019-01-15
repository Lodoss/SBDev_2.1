<?
require "include/bittorrent.php";
dbconn();


// name a category
$res = sql_query("SELECT id, name FROM categories");
while($cat = mysql_fetch_assoc($res))
$category[$cat['id']] = $cat['name'];

// by category ?
if ($_GET['cat'])
$cats = explode(",", $_GET["cat"]);
if ($cats)
$where = "category IN (".implode(", ", array_map("sqlesc", $cats)).") AND";


if ($CURUSER["view_xxx"] != "yes") {
 $xxx = "AND category != '6'";
}

// start the RSS feed output
header("Content-Type: application/xml");
print("<?xml version=\"1.0\" encoding=\"utf8\" ?>\n<rss version=\"0.91\">\n<channel>\n" .
"<title>SeedBay.net RSS</title>\n<link>" . $DEFAULTBASEURL . "</link>\n" .
"<language>en-usde</language>\n<copyright>Copyright © 2012 " . $SITENAME . "</copyright>\n<webMaster>admin@russbay.com</webMaster>\n" .
"<image><title><![CDATA[" . $SITENAME . "]]></title>\n<url>" . $DEFAULTBASEURL . "/favicon.gif</url>\n<link>" . $DEFAULTBASEURL . "</link>\n" .
"<width>16</width>\n<height>16</height>\n<generator><![CDATA[SeedBay.net - http://seedbay.net]]></generator>\n</image>\n");

// get all vars
$res = sql_query("SELECT id,name,descr, poster FROM torrents WHERE $where modded='yes' $xxx ORDER BY added DESC LIMIT 15") or sqlerr(__FILE__, __LINE__);
while ($row = mysql_fetch_row($res)){
list($id,$name,$descr,$poster) = $row;

                if (!empty($poster))
                                $post="<img width=\"250\" border=\"0\" src=" . ($poster) . ">";
 				else
                                $post="<img src=/pic/poster.jpg>";



		$dispname = $name;




$link = "$DEFAULTBASEURL/details.php?id=$id";

// output of all data
echo("<item><title><![CDATA[" . $dispname . "]]></title>\n<link>" . $link . "</link>\n<description><![CDATA[\n" . $post . "<br><br>" . format_comment($descr) . "\n]]></description>\n</item>\n");
}

echo("</channel>\n</rss>\n");
?>
