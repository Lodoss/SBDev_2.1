<?
require "include/bittorrent.php";

dbconn();
maxsysop();


stdhead($tracker_lang['t_comments']);



function commenttable($rows, $redaktor = "comment") {
		global $CURUSER, $tracker_lang;

	$count = 0;
	foreach ($rows as $row)	{



$email = $row["email"];
$default = "http://www.gravatar.com/avatar/";
$size = 80;

$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;

    if (isset($row["username"]))
		{
	 		
	 		
	 $text = format_comment($row["text"]);

	if ($row["editedby"]) {
	       $text .= "<p align=right class=small>" . $tracker_lang['edited_by'] . " <a href=$DEFAULTBASEURL/browse.php?user=$row[editedby]><b>$row[editedbyname]</b></a> $row[editedat]</p>\n";
	 }


echo "<div><a href='/details.php?id=" . $row[torrentid] . "'><b>" .  $row[torrentname] . "</b></a></div>";

echo "<div class='browse'>";

echo "<table width='100%' cellpadding=\"5\">";
echo "<tr valign=\"top\">";
echo "<td><img class='poster' src='$grav_url'></td>";
echo "<td width='100%'>";




	 		echo "<div class=\"bhinfo\">";
	 		
	 		echo "<ul class=\"isicons reset\">";
			
		echo ($row["user"] == $CURUSER["id"] || get_user_class() >= UC_MODERATOR ? " <li><a href=$DEFAULTBASEURL/".$redaktor.".php?action=edit&amp;cid=$row[id]><img src=\"$DEFAULTBASEURL/pic/pen.gif\" title=\"Edit\"></a></li>" : "");
				
		echo (get_user_class() >= UC_MODERATOR ? " <li><a href=\"$DEFAULTBASEURL/".$redaktor.".php?action=delete&amp;cid=$row[id]\"><img src=\"$DEFAULTBASEURL/pic/warned2.gif\" title=\"Delete\"></a></li>" : "");				
				
			echo "</ul>";
			
			
			if (get_user_class() >= UC_MODERATOR && $row["class"] < get_user_class()) {
			$edit = "<a href='$DEFAULTBASEURL/edituser.php?id=$row[user]'><img src='$DEFAULTBASEURL/pic/pen.gif' alt=\"Edit user\" title=\"Edit user\" border=0></a>";
			}
	 		
	 		
	 		
	 		echo "<span class=\"baseinfo radial\"><a name=comm". $row["id"]." href=$DEFAULTBASEURL/browse.php?user=" . $row["user"] . ">". get_user_class_color($row["class"], htmlspecialchars_uni($row["username"])) . "</a>".get_user_icons($row)."".$edit." | " . nicetime($row[added], true) . "</span>";
	 		
	 		
	 				echo "</div>";
    
    
        echo $text;

    
    
    
    echo "</td>";
  echo "</tr>";

echo "</table>";

echo "</div> \n";

echo "<div class='spacer'></div>";
		


	}

  }

}




        $subres = mysql_query("SELECT COUNT(*) FROM comments");
        $subrow = mysql_fetch_array($subres);
        $count = $subrow[0];

        $limited = 10;
        
        

if ($count) {

                list($pagertop, $pagerbottom, $limit) = pager($limited, $count, "$DEFAULTBASEURL/comments.php?", array(firstpagedefault == 0));
                

$subres = sql_query("SELECT t.name AS torrentname, t.id AS torrentid, t.url AS torrentseo, c.id, c.torrent, c.ip, c.text, c.user, c.added, c.editedby, c.editedat, u.username, u.class, u.email, u.enabled, u.comment, e.username AS editedbyname FROM comments AS c LEFT JOIN users AS u ON c.user = u.id LEFT JOIN users AS e ON c.editedby = e.id LEFT JOIN torrents AS t ON c.torrent = t.id WHERE t.category != '6' ORDER BY c.id  DESC $limit") or sqlerr(__FILE__, __LINE__);
                $allrows = array();
                while ($subrow = mysql_fetch_array($subres))
   
                        $allrows[] = $subrow;


echo "<h3>" . $tracker_lang['t_comments'] . ": " . $count . "</h3> \n";

         commenttable($allrows);



if ($count > 10) {
        echo $pagerbottom;
                }
                
                

}



stdfoot();

?>
