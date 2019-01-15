<?
  function begin_frame($caption = "")
  {
global $DEFAULTBASEURL, $ss_uri;

echo "<TABLE cellSpacing=0 border=0 cellPadding=0 width=\"100%\">";
        echo "<TR>";
		echo "<TD class=\"clear\" vAlign=top width=14><IMG height=12 src=\"$DEFAULTBASEURL/themes/" . $ss_uri . "/images/images/1.gif\" width=14 border=0></TD>";
          echo "<TD class=\"clear\" vAlign=top width=152 background=$DEFAULTBASEURL/themes/" . $ss_uri . "/images/images/2.gif colspan=\"2\"></TD>";
          echo "<TD class=\"clear\" vAlign=top width=14><IMG height=12 src=\"$DEFAULTBASEURL/themes/" . $ss_uri . "/images/images/3.gif\" width=14 border=0></TD></TR>";
        echo "<TR>";

    if ($caption) {
          echo "<TD class=\"clear\" width=14 background=$DEFAULTBASEURL/themes/" . $ss_uri . "/images/images/4.gif></TD>";
          echo "<TD class=\"clear\" bgcolor=\"white\" width=\"1\"></TD>";
          echo "<TD class=\"clear\" width=\"100%\" bgcolor=\"white\"><b>$caption</b></TD>";
          echo "<TD class=\"clear\" width=14 background=$DEFAULTBASEURL/themes/" . $ss_uri . "/images/images/6.gif></TD></TR>";

                  echo "<tr>";
          echo "<TD class=\"clear\" width=14 background=$DEFAULTBASEURL/themes/" . $ss_uri . "/images/images/4.gif><IMG height=12 src=\"$DEFAULTBASEURL/themes/" . $ss_uri . "/images/images/block/8.gif\" width=14 border=0></TD>";
          echo "<TD class=\"clear\" background=$DEFAULTBASEURL/themes/" . $ss_uri . "/images/images/10.gif colspan=\"2\"></TD>";
          echo "<TD class=\"clear\" width=14 background=$DEFAULTBASEURL/themes/" . $ss_uri . "/images/images/6.gif><IMG height=12 src=\"$DEFAULTBASEURL/themes/" . $ss_uri . "/images/images/block/9.gif\" width=14 border=0></TD>";
		echo "</tr>";

                }
                         		echo "<tr>";
          echo "<TD class=\"clear\" width=14 background=$DEFAULTBASEURL/themes/" . $ss_uri . "/images/images/4.gif>";
			echo "<IMG height=14 src=\"$DEFAULTBASEURL/themes/" . $ss_uri . "/images/images/spacer.gif\" width=14 border=0></TD>";
         echo "<TD class=\"clear\" colspan=\"2\" bgcolor=\"white\">";
  }


  function end_frame()
  {
global $DEFAULTBASEURL, $ss_uri;  

echo "</TD>";
          echo "<TD class=\"clear\" width=14 background=$DEFAULTBASEURL/themes/" . $ss_uri . "/images/images/6.gif >";
			echo "<IMG height=14 src=\"$DEFAULTBASEURL/themes/" . $ss_uri . "/images/images/spacer.gif\" width=14 border=0></TD>";
		echo "</tr>";
        echo "<TR class=\"clear\">";
          echo "<TD class=\"clear\" vAlign=top width=14><IMG height=12 src=\"$DEFAULTBASEURL/themes/" . $ss_uri . "/images/images/8.gif\" width=14 border=0></TD>";
          echo "<TD class=\"clear\" vAlign=top width=152 background=$DEFAULTBASEURL/themes/" . $ss_uri . "/images/images/10.gif colspan=\"2\"></TD>";
          echo "<TD class=\"clear\" vAlign=top width=14><IMG height=12 src=\"$DEFAULTBASEURL/themes/" . $ss_uri . "/images/images/9.gif\" width=14 border=0></TD></TR>";
          echo "</TABLE>";
  }


?>
