<?php

# IMPORTANT: Do not edit below unless you know what you are doing!
if(!defined('IN_TRACKER'))
  die('Hacking attempt!');

function torrenttable($res) {
		global $CURUSER, $tracker_lang;



	while ($row = mysql_fetch_assoc($res)) {

		$id = $row["id"];

if ($row["modded"] == "no" && get_user_class() < UC_MODERATOR && $row["owner"] != $CURUSER["id"]) {
            print "";
} else {

		
if (get_user_class() >= UC_MODERATOR) {
$edit = "<a href=\"$DEFAULTBASEURL/edit.php?id=".$id."\"><img border=\"0\" src=\"$DEFAULTBASEURL/pic/pen.gif\" title=\"Edit\"></a> ";
} else {
$edit = "";
}


if ($row["modded"] == "yes") {
            $modded = "";
    } else {
            $modded = " <font color='red'><i>" . $tracker_lang['need_mod'] . "</i></font>";
    }




$dispname = htmlspecialchars($row["name"]);

$seo = htmlspecialchars($row["url"]);



				echo "<tr class='browse'><td width='100%' class='clear h1name'>$edit<a href='$DEFAULTBASEURL/details.php?id=$id'>$dispname</a>$modded</td>";
         
        
        
        		echo "<td class='clear'>";
                 		if ($row["comments"] >=1){
         				echo "<nobr>" .$row["comments"] . " <img border=\"0\" src=\"$DEFAULTBASEURL/pic/comments.png\" title=\"Comments\">   </nobr>";
         				}
     			echo "</td>";  
     			
     			
     			
     			echo "<td class='clear' align='right'>";
         				echo "<nobr>" . $row["size"] . "</nobr>";
     			echo "</td>";  
        
         
         		echo "<td class='clear'><nobr>";

                echo "<img title=\"Seeders\" src=\"/pic/arrowup2.gif\"> <font color='green'><b>" . $row["seeders"] . "</b></font>";

			    echo " <img title=\"Leechers\" src=\"/pic/arrowdown2.gif\"> <font color='red'><b>" . $row["leechers"] . "</b></font>";

				echo "</nobr>";
        
				echo "</td></tr>\n";


	}
}
	return $rows;
}


?>
