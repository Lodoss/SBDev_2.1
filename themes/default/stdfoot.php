<?
if (!defined('UC_SYSOP'))
die('Direct access denied.');


echo "</div>";  ///main_fraim

echo "</div>";  ///mainbox




echo "<div align='center'>";


$catlist = genrelist();
foreach ($catlist as $row)
	echo "| <a href=\"$DEFAULTBASEURL/browse.php?cat=" . $row["id"] . "\"><b>" . htmlspecialchars($row["name"]) . "</b></a> |";



echo "<div class='spacer'></div>\n";




if (get_user_class() == UC_SYSOP) {


// Variables for End Time
$seconds = (timer() - $tstart);

$phptime = 		$seconds - $querytime;
$query_time = 	$querytime;
$seconds = 		substr($seconds, 0, 8);


echo "<b class=small>".sprintf($tracker_lang["page_generated"], $seconds, $queries)."</b><br>\n";
}

/// Please don't remove this line (code is free, please be respectful)
echo "<span class='small'><a href='http://sourceforge.net/projects/seedbay/' target='_blank' title='Powered by SBDev v2.1'><b>Powered by SBDev v2.1</b></a></span>\n";




echo "</div>\n";


        echo "</body></html>\n";
?>