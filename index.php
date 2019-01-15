<?php
require_once("include/bittorrent.php");
require_once("include/torrenttable_function.php");

gzip();
dbconn(false);
maxsysop();



stdhead();


$sticky = sql_query("SELECT torrents.id, torrents.name, torrents.url, torrents.poster FROM torrents WHERE torrents.sticky = 'yes' ORDER BY torrents.added DESC LIMIT 0, 5") or die(mysql_error());



echo "<div class='sticky' align='center'>";

	while ($row = mysql_fetch_assoc($sticky)) {

$poster = htmlspecialchars($row["poster"]);
$title  = htmlspecialchars($row["name"]);
$seo = htmlspecialchars($row["url"]);


echo "<a href='$DEFAULTBASEURL/details.php?id=$row[id]'><img class='poster' width='160' height='224' src='" . $poster . "' title='" . $title . "'></a>";


	}
	
echo "</div>";





echo "<div class='spacer'></div>";
	
	
	


$cats = genrelist();
foreach ($cats as $row) {

$catid = $row["id"];


        $query = "SELECT torrents.seeders+ifnull(xbt_files.seeders,0) as seeders, torrents.leechers+ifnull(xbt_files.leechers,0) as leechers, torrents.id, torrents.modded, torrents.url, torrents.added, torrents.name, torrents.size, torrents.comments, torrents.owner FROM torrents LEFT JOIN users ON torrents.owner = users.id LEFT JOIN xbt_files ON torrents.info_hash = xbt_files.info_hash WHERE torrents.category = '$catid' ORDER BY torrents.id DESC LIMIT 0, 10";
        $res = sql_query($query) or die(mysql_error());




echo "<table class='bordered' width=\"100%\">";

echo "<thead><tr>";

echo "<th colspan='4'>";

echo "<a href='$DEFAULTBASEURL/rss.php?cat=$catid'><img border=\"0\" src=\"$DEFAULTBASEURL/pic/rssdl.png\" title=\"RSS\"></a> <a href=\"$DEFAULTBASEURL/browse.php?cat=" . $row["id"] . "\"><b>" . htmlspecialchars($row["name"]) . "</b></a>";

echo "</th>";

echo "</tr></thead>";



        torrenttable($res);



echo "</table>";

echo "<div class='spacer'></div>";


}  //end of foreach


stdfoot();

?>
