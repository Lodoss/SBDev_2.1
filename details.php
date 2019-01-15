<?
require_once("include/bittorrent.php");
require_once("include/commenttable_function.php");

gzip();

dbconn(false);

maxsysop ();


$id = (int)$_GET["id"];

if (!is_valid_id($id))
        stderr($tracker_lang['error'], $tracker_lang['invalid_id']);
        
        
        


$res = sql_query("SELECT torrents.seeders+ifnull(xbt_files.seeders,0) as seeders, torrents.leechers+ifnull(xbt_files.leechers,0) as leechers, torrents.times_completed+ifnull(xbt_files.completed,0) as times_completed, torrents.lang, torrents.scrape_time, torrents.url, torrents.scrape, torrents.magnet, torrents.modded, torrents.tags, torrents.name, torrents.info_hash, torrents.owner, torrents.descr, torrents.size, torrents.added, torrents.id, torrents.poster, torrents.screenshot1, torrents.screenshot2, torrents.screenshot3, torrents.screenshot4, torrents.anonymous, torrents.tube, categories.id AS catid, categories.name AS catname, users.enabled, users.comment, users.username, users.class FROM torrents LEFT JOIN categories ON torrents.category = categories.id LEFT JOIN users ON torrents.owner = users.id LEFT JOIN xbt_files ON torrents.info_hash = xbt_files.info_hash WHERE torrents.id = $id")
        or sqlerr(__FILE__, __LINE__);
$row = mysql_fetch_array($res);

if (!$row)
        stderr($tracker_lang['error'], $tracker_lang['invalid_id']);


if ($row["modded"] == "no" && $row["owner"] != $CURUSER["id"] && get_user_class() < UC_MODERATOR)
	stderr($tracker_lang['error'], $tracker_lang['not_modded']);


if ($row["catid"] == "6" && $CURUSER["view_xxx"] != "yes")
	stderr($tracker_lang['error'], $tracker_lang['show_xxx']);
	
	
	
		$dispname = htmlspecialchars($row["name"]);

    	stdhead("$dispname");
    	
?>


	<script>
	
$(function(){


		$('.tabss').liteTabs({ borders: true });

    	         
});
    </script>	

<?
    	
    	
    	
    	
if ($CURUSER["id"] == $row["owner"] || get_user_class() >= UC_MODERATOR)
$edit = "<a href=\"$DEFAULTBASEURL/edit.php?id=$row[id]\"><img border=\"0\" src=\"$DEFAULTBASEURL/pic/pen.gif\" title=\"" . $tracker_lang['torrent_edit'] . "\"></a>";



echo "<div class='dwidth'>";


echo "<table width='100%'><tr valign='top'><td class='clear'>";


echo "<div class='h1name'>" . $dispname . "</div>\n";


///// generate SEO url from title if empty row[url]
if(!$row['url']) {
$seo = generate_chpu($dispname);
$seo = sqlesc($seo);
mysql_query("UPDATE torrents SET url=$seo WHERE id = $id") or sqlerr(__FILE__,__LINE__);
}
///// building SEO urls from title 




		echo "<div class=\"bhinfo\">";
			echo "<ul class=\"isicons reset\">";
			
				if ($CURUSER["id"] == $row["owner"] || get_user_class() >= UC_MODERATOR)
				echo "<li>$edit</li>";
				
			echo "</ul>";
			

			
			
			if (get_user_class() >= UC_MODERATOR && $row["class"] < get_user_class()) {
			$edituser = "<a href='$DEFAULTBASEURL/edituser.php?id=$row[owner]'><img src='$DEFAULTBASEURL/pic/pen.gif' alt=\"Edit user\" title=\"Edit user\" border='0'></a>";
			}
			
			
			
			
			
			
			
			echo "<span class=\"baseinfo radial\">";
			
			
			
			
			if($row['anonymous'] == 'yes') {
				if (get_user_class() < UC_UPLOADER)
				$uprow = "<i>" . $tracker_lang['annonym'] . "</i>";
				else
				$uprow = "<i>" . $tracker_lang['annonym'] . "</i> (<a href=$DEFAULTBASEURL/browse.php?user=" . $row["owner"] . ">" . get_user_class_color($row["class"], $row["username"]) . "</a>".get_user_icons($row)."".$edituser.")";
				} else {
				$uprow = (isset($row["username"]) ? ("<a href=$DEFAULTBASEURL/browse.php?user=" . $row["owner"] . ">" . get_user_class_color($row["class"], $row["username"]) . "</a>".get_user_icons($row)."".$edituser."") : "<i>" . $tracker_lang['annonym'] . "</i>");
				}
			
				echo "" . nicetime($row[added], false) . " | ";
				
				echo "" . $tracker_lang['uploader'] . ": $uprow | ";
			
				echo "" . $tracker_lang['category'] . ": <a href=\"$DEFAULTBASEURL/browse.php?cat=$row[catid]\">$row[catname]</a> | ";
				
				echo "" . $tracker_lang['size'] . ": " . $row[size] . " | ";

				echo "" . $tracker_lang['tracker_seeders'] . ": <font color=green><b>$row[seeders]</b></font> | ";

				echo "" . $tracker_lang['tracker_leechers'] . ": <font color=red><b>$row[leechers]</b></font> | ";

				echo "" . $tracker_lang['snatched'] . ": $row[times_completed]";
				

			
		if ($row["scrape"] == "yes"){
		
				echo " <a href='" . $DEFAULTBASEURL . "/recheck.php?id=" . $id . "'> [update]</a>";
			
		}
				
			echo "</span>";
			
		echo "</div>";
		
		
echo "</td>";


echo "<td class='clear' align='right'>";


//$magnet = $row["magnet"];

echo "<a class='btn btn-grey' href=\"/download.php?id=" . $id . "\">" . $tracker_lang['download'] . "</a>";




echo "</td></tr></table>";

echo "</div>";   //end of (dwidth)




// begin_frame();

                echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"4\">\n";

                echo "<tr valign=\"top\">";
                
    $poster = htmlspecialchars($row["poster"]);           
    if ($poster) {               
                echo "<td class=\"clear\" align=\"center\" width=\"250\">";
	
  		      	echo "<img width=\"250\" border=\"0\" class=\"poster\" src=" . ($poster) . ">\n";

				echo "</td>\n";
				}

				echo "<td class='clear' valign=\"top\">";


		$descr = $row["descr"];
		
				if ($descr)
					echo format_comment($descr);


		$tags = htmlspecialchars($row["tags"]);
                if ($tags)
					echo "<p align='right' class='small'> <img src=\"$DEFAULTBASEURL/pic/tag.png\"> " . $tracker_lang['tags'] . ": " . addtags($tags) . "</p>\n";



                echo "</td></tr>\n";

                echo "</table>\n";
                
                
            

 //end_frame();

		$screenshot1 = htmlspecialchars($row["screenshot1"]);
		$screenshot2 = htmlspecialchars($row["screenshot2"]);
		$screenshot3 = htmlspecialchars($row["screenshot3"]);
		$screenshot4 = htmlspecialchars($row["screenshot4"]);
		
		
		


echo "<div class=\"tabss\" align='center'>";
    echo "<ul>";
    
    
   		if ($screenshot1 || $screenshot2 || $screenshot3 || $screenshot4) {
        echo "<li><a href=\"#1\">" . $tracker_lang['screens'] . "</a></li>";
        }
        
        if($row['tube']) {
        echo "<li><a href=\"#2\">" . $tracker_lang['trailer'] . "</a></li>";
        }
        
        echo "<li><a href=\"#3\">" . $tracker_lang['add_comment'] . "</a></li>";


    echo "</ul>";


		
if ($screenshot1 || $screenshot2 || $screenshot3 || $screenshot4)
{
	echo "<div name=\"#1\">";


if ($screenshot1)
echo "<a href=" . ($screenshot1) . " rel=\"facebox\"><img class='poster' width='198' src=" . ($screenshot1) . "></a>";

if ($screenshot2)
echo "<a href=" . ($screenshot2) . " rel=\"facebox\"><img class='poster' width='198' src=" . ($screenshot2) . "></a>";

if ($screenshot3)
echo "<a href=" . ($screenshot3) . " rel=\"facebox\"><img class='poster' width='198' src=" . ($screenshot3) . "></a>";

if ($screenshot4)
echo "<a href=" . ($screenshot4) . " rel=\"facebox\"><img class='poster' width='198' src=" . ($screenshot4) . "></a>";

		echo "</div>";



}

    
    
    
    
    
if($row['tube']) {
    echo "<div name=\"#2\">";
    echo "<embed src='". str_replace("watch?v=", "v/", htmlspecialchars($row["tube"])) ."' type=\"application/x-shockwave-flash\" width=\"650\" height=\"370\"></embed>";
    echo "</div>";
}






echo "<div name=\"#3\">";
  echo "<form name=comment method=\"post\" action=\"$DEFAULTBASEURL/comment.php?action=add\">";


  echo "<textarea name='text' rows='10' cols='60'></textarea>";
  echo "<p></p>";
  echo "<input type=\"hidden\" name=\"tid\" value=\"$id\"/>";
  echo "<input class='btn btn-grey' type=\"submit\" value=\"" . $tracker_lang['add'] . "\" />";
  echo "</form>";


  echo "</div>";










echo "</div>"; // end of tabs




        $subres = mysql_query("SELECT COUNT(*) FROM comments WHERE torrent = $id");
        $subrow = mysql_fetch_array($subres);
        $count = $subrow[0];

        $limited = 10;

if ($count) {

                list($pagertop, $pagerbottom, $limit) = pager($limited, $count, "$DEFAULTBASEURL/details.php?id=$id&", array(lastpagedefault => 1));

                $subres = sql_query("SELECT c.id, c.ip, c.text, c.user, c.added, c.editedby, c.editedat, ".
                  "u.username, u.email, u.last_access, u.class, u.enabled, u.comment, e.username AS editedbyname FROM comments AS c LEFT JOIN users AS u ON c.user = u.id LEFT JOIN users AS e ON c.editedby = e.id WHERE torrent = " .
                  "$id ORDER BY c.id $limit") or sqlerr(__FILE__, __LINE__);
                $allrows = array();
                while ($subrow = mysql_fetch_array($subres))
                        $allrows[] = $subrow;
                        
                        
                        
                        
        echo "<h3>" . $tracker_lang['t_comments'] . ": " . $count . "</h3>\n";

         commenttable($allrows);


if ($count > 10) {

        print($pagerbottom);

                		}
                
                

}

stdfoot();

?>
