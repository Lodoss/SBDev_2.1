<?php

# IMPORTANT: Do not edit below unless you know what you are doing!
if(!defined('IN_TRACKER'))
  die('Hacking attempt!');

function commenttable($rows, $redaktor = "comment") {
			global $CURUSER, $tracker_lang;



?>

  <script>
$(function(){
  	////zebra table
  $(".comments:odd").addClass("odd");	
});
  </script>

<?



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



echo "<div class='comments'>";


echo "<table width='100%' cellpadding=\"5\">";
  echo "<tr valign=\"top\">";
    echo "<td><img class='poster' src='$grav_url'></td>";
    echo "<td width='100%'>";
    
    
    
    	 		echo "<div class=\"bhinfo\">";
	 		
	 		echo "<ul class=\"isicons reset\">";
			
		echo ($row["user"] == $CURUSER["id"] || get_user_class() >= UC_MODERATOR ? " <li><a href=$DEFAULTBASEURL/".$redaktor.".php?action=edit&amp;cid=$row[id]><img src=\"$DEFAULTBASEURL/pic/pen.gif\" title=\"Edit\"></a></li>" : "");
				
		echo (get_user_class() >= UC_MODERATOR ? " <li><a href=\"$DEFAULTBASEURL/".$redaktor.".php?action=delete&amp;cid=$row[id]\"><img src=\"$DEFAULTBASEURL/pic/warned2.gif\" title=\"Delete\"></a></li>" : "");				
				
			echo "</ul>";
			
			
			
			
			
			
			if (get_user_class() >= UC_MODERATOR && $row["class"] < get_user_class()  && $row["user"] != $CURUSER["id"]) {
			$edit = "<a href='$DEFAULTBASEURL/edituser.php?id=$row[user]'><img src='$DEFAULTBASEURL/pic/pen.gif' alt=\"Edit user\" title=\"Edit user\" border=0></a>";
			} else {
			$edit = "";
			}
	 		
	 		
	 		
	 		echo "<span class=\"baseinfo radial\"><a name=comm". $row["id"]." href=$DEFAULTBASEURL/browse.php?user=" . $row["user"] . ">". get_user_class_color($row["class"], htmlspecialchars_uni($row["username"])) . "</a>".get_user_icons($row)."".$edit." | " . nicetime($row[added], true) . "</span>";
	 		
	 		
	 				echo "</div>";
    
    
        echo "" . $text . "";

    
    
    
    echo "</td>";
  echo "</tr>";

echo "</table>";

echo "</div>";



	}

  }

}

?>
