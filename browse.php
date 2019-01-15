<?
require_once("include/bittorrent.php");
require_once("include/torrenttable_function.php");
require_once("include/torr_langs.php");


gzip();
dbconn(false);
maxsysop();

$cats = genrelist();

$searchstr = unesc($_GET["search"]);
$cleansearchstr = htmlspecialchars($searchstr);
if (empty($cleansearchstr))
unset($cleansearchstr);


$tagstr = unesc($_GET["tag"]);
$cleantagstr = htmlspecialchars($tagstr);
if (empty($cleantagstr))
unset($cleantagstr);


$userstr = (int)$_GET["user"];
$cleanuserstr = htmlspecialchars($userstr);
if (empty($cleanuserstr))
unset($cleanuserstr);


$category = (int)$_GET["cat"];

$language = (int)$_GET["t_lang"];





if ($_GET['sort'] && $_GET['type']) {

$column = '';
$ascdesc = '';

switch($_GET['sort']) {
	case '1': $column = "name"; break;
	case '3': $column = "comments"; break;
	case '4': $column = "added"; break;
	case '5': $column = "size"; break;
	case '6': $column = "times_completed"; break;
	case '7': $column = "seeders"; break;
	case '8': $column = "leechers"; break;
	case '9': $column = "owner"; break;
	default: $column = "id"; break;
}

switch($_GET['type']) {
  case 'asc': $ascdesc = "ASC"; $linkascdesc = "asc"; break;
  case 'desc': $ascdesc = "DESC"; $linkascdesc = "desc"; break;
  default: $ascdesc = "DESC"; $linkascdesc = "desc"; break;
}


$orderby = "ORDER BY torrents." . $column . " " . $ascdesc;
$pagerlink = "sort=" . intval($_GET['sort']) . "&type=" . $linkascdesc . "&";

} else {

$orderby = "ORDER BY torrents.id DESC";
$pagerlink = "";

}

$addparam = "";
$wherea = array();
$wherecatina = array();



if ($CURUSER["view_xxx"] != "yes") {
 $wherea[] = "category != '6'";
}



if ($category)
        {
          if (!is_valid_id($category))
        	stderr($tracker_lang['error'], "Invalid category ID.");
          $wherecatina[] = $category;
          $addparam .= "cat=$category&amp;";
        }
        
if ($language)
	{
	    if (!is_valid_id($language))
        	stderr($tracker_lang['error'], "Invalid Language ID.");
        	
		$addparam .= "t_lang=" . $language . "&amp;";
		$wherea[] = "lang = " . $language . "";
	}


if (count($wherecatina) > 1)
        $wherecatin = implode(",",$wherecatina);
elseif (count($wherecatina) == 1)
        $wherea[] = "category = $wherecatina[0]";

$wherebase = $wherea;



if (isset($_GET['modded'])) {
	if ($_GET["modded"] == 1) {
		$addparam .= "modded=1&amp;";
		if (get_user_class() >= UC_MODERATOR)
			$wherea[] = "modded != 'yes'";
		}
	}


if (isset($cleansearchstr))
{
		$wherea[] = "torrents.name LIKE '%" . sqlwildcardesc($searchstr) . "%'";
        $addparam .= "search=" . urlencode($searchstr) . "&amp;";
}


if (isset($cleantagstr))
{
		$wherea[] = "torrents.tags LIKE '%" . sqlwildcardesc($tagstr) . "%'";
        $addparam .= "tag=" . urlencode($tagstr) . "&";
}



if (isset($cleanuserstr))
{

	if ($CURUSER["id"] == sqlwildcardesc($userstr) || get_user_class() >= UC_MODERATOR)
		$anon = "";
	else
		$anon = " AND torrents.anonymous = 'no'";


		$wherea[] = "torrents.owner = " . sqlwildcardesc($userstr) . "" . $anon . "";
        $addparam .= "user=" . urlencode($userstr) . "&";
}



$where = implode(" AND ", $wherea);
if ($wherecatin)
        $where .= ($where ? " AND " : "") . "category IN (" . $wherecatin . ")";

if ($where != "")
        $where = "WHERE $where";

$res = sql_query("SELECT COUNT(*) FROM torrents $where") or die(mysql_error());
$row = mysql_fetch_array($res);
$count = $row[0];
$num_torrents = $count;

if (!$count && isset($cleansearchstr)) {
        $wherea = $wherebase;
        $searcha = explode(" ", $cleansearchstr);
        $sc = 0;
        foreach ($searcha as $searchss) {
                if (strlen($searchss) <= 1)
                        continue;
                $sc++;
                if ($sc > 5)
                        break;
                $ssa = array();
                $ssa[] = "torrents.name LIKE '%" . sqlwildcardesc($searchss) . "%'";
        }
        if ($sc) {
                $where = implode(" AND ", $wherea);
                if ($where != "")
                        $where = "WHERE $where";
                $res = sql_query("SELECT COUNT(*) FROM torrents $where");
                $row = mysql_fetch_array($res);
                $count = $row[0];
        }
}

$torrentsperpage = 35;

if ($count)
{
    if ($addparam != "") {
 if ($pagerlink != "") {
  if ($addparam{strlen($addparam)-1} != ";") { // & = &amp;
    $addparam = $addparam . "&" . $pagerlink;
  } else {
    $addparam = $addparam . $pagerlink;
  }
 }
    } else {
 $addparam = $pagerlink;
    }
        list($pagertop, $pagerbottom, $limit) = pager($torrentsperpage, $count, "$DEFAULTBASEURL/browse.php?" . $addparam);
        $query = "SELECT torrents.seeders+ifnull(xbt_files.seeders,0) as seeders, torrents.leechers+ifnull(xbt_files.leechers,0) as leechers, torrents.id, torrents.modded, torrents.url, torrents.added, torrents.name, torrents.size, torrents.magnet, torrents.comments, torrents.owner, torrents.anonymous FROM torrents LEFT JOIN xbt_files ON torrents.info_hash = xbt_files.info_hash $where $orderby $limit";
        $res = sql_query($query) or die(mysql_error());
}
else
unset($res);
        
      


//////////torrent language selector
$torr_lang = "<select name=\"t_lang\"><option value=\"0\">(" . $tracker_lang['t_lang'] . ")</option>";

	foreach ($torrent_lang as $id => $name) {
		$torr_lang .= "<option value=\"$id\"";
	if (isset($_GET['t_lang']) && $id == $_GET["t_lang"])
		$torr_lang .= " selected=\"selected\"";
	$torr_lang .= ">$name</option>\n";
	}
	
$torr_lang .= "</select>";
//////////torrent language selector    

//////////$cats = genrelist();
$catdropdown = "";
foreach ($cats as $cat) {
	$catdropdown .= "<option value=\"" . $cat["id"] . "\"";
	if (isset($_GET['cat']) && $cat["id"] == $_GET["cat"])
		$catdropdown .= " selected=\"selected\"";
	$catdropdown .= ">" . htmlspecialchars($cat["name"]) . "</option>\n";
} 
//////////$cats = genrelist();
 
////////change header title
$head_title = $tracker_lang['t_browse'];     

if (isset($cleansearchstr)) {
$head_title = "".$tracker_lang['search_results_for']." \"" . htmlspecialchars($searchstr) . "\"";
} elseif (isset($cleantagstr)) {
$head_title = "".$tracker_lang['search_results_tags']." \"" . htmlspecialchars($tagstr) . "\"";
} elseif (isset($cleanuserstr)) {

	$result = mysql_query("SELECT username FROM users WHERE id = '$userstr'") or sqlerr(__FILE__, __LINE__); 
	$user = mysql_fetch_assoc($result); 

	$username = $user["username"];

$head_title = "".$tracker_lang['search_results_user']." $username";
} elseif ($category) {

	$result = mysql_query("SELECT name FROM categories WHERE id = '$category'") or sqlerr(__FILE__, __LINE__); 
	$categor = mysql_fetch_assoc($result); 

$head_title = $categor["name"];

}
////////change header title
   
    
        

stdhead($head_title);
               
?>


<form method="get" action="<?=$DEFAULTBASEURL?>/browse.php">
   
<center>
<input type="text" id="searchinput" name="search" size="80" placeholder="<?=$tracker_lang['search_holder'];?>" value="<?= htmlspecialchars($searchstr) ?>" />
<?=$tracker_lang['in'];?> 



<select name="cat">
<option value="0">(<?=$tracker_lang['all_types'];?>)</option>
<?
echo $catdropdown;
?>
</select>


<? echo $torr_lang; ?>

<input class="btn" type="submit" value="<?=$tracker_lang['search'];?>" />
</center>
</form>

  
<div class="spacer"></div>

<?      
        
      


if (isset($cleansearchstr)) {
begin_frame();
print("".$tracker_lang['search_results_for']." \"" . htmlspecialchars($searchstr) . "\"");
end_frame();
print("<br>");
}


if (isset($cleantagstr)) {
begin_frame();
print("".$tracker_lang['search_results_tags']." \"" . htmlspecialchars($tagstr) . "\"");
end_frame();
print("<br>");
}


if (isset($cleanuserstr)) {

	$result = mysql_query("SELECT id, class, username, enabled, comment, ip FROM users WHERE id = '$userstr'") or sqlerr(__FILE__, __LINE__); 
	$user = mysql_fetch_assoc($result); 

$username = (isset($user["username"]) ? ("<nobr>" . get_user_class_color($user["class"], htmlspecialchars_uni($user["username"])) . "".get_user_icons($user)."</nobr>") : "<i>(unknown)</i>");
begin_frame();
print("".$tracker_lang['search_results_user']." $username");
end_frame();
print("<br>");
}








if ($num_torrents) {



$count_get = 0;

foreach ($_GET as $get_name => $get_value) {

$get_name = mysql_real_escape_string(strip_tags(str_replace(array("\"","'"),array("",""),$get_name)));

$get_value = mysql_real_escape_string(strip_tags(str_replace(array("\"","'"),array("",""),$get_value)));

if ($get_name != "sort" && $get_name != "type") {
if ($count_get > 0) {
$oldlink = $oldlink . "&" . $get_name . "=" . $get_value;
} else {
$oldlink = $oldlink . $get_name . "=" . $get_value;
}
$count_get++;
}

}

if ($count_get > 0) {
$oldlink = $oldlink . "&";
}


if ($_GET['sort'] == "1") {
if ($_GET['type'] == "desc") {
$link1 = "asc";
} else {
$link1 = "desc";
}
}

if ($_GET['sort'] == "2") {
if ($_GET['type'] == "desc") {
$link2 = "asc";
} else {
$link2 = "desc";
}
}

if ($_GET['sort'] == "3") {
if ($_GET['type'] == "desc") {
$link3 = "asc";
} else {
$link3 = "desc";
}
}

if ($_GET['sort'] == "4") {
if ($_GET['type'] == "desc") {
$link4 = "asc";
} else {
$link4 = "desc";
}
}

if ($_GET['sort'] == "5") {
if ($_GET['type'] == "desc") {
$link5 = "asc";
} else {
$link5 = "desc";
}
}

if ($_GET['sort'] == "7") {
if ($_GET['type'] == "desc") {
$link7 = "asc";
} else {
$link7 = "desc";
}
}

if ($_GET['sort'] == "8") {
if ($_GET['type'] == "desc") {
$link8 = "asc";
} else {
$link8 = "desc";
}
}

if ($_GET['sort'] == "9") {
if ($_GET['type'] == "desc") {
$link9 = "asc";
} else {
$link9 = "desc";
}
}

if ($_GET['sort'] == "10") {
if ($_GET['type'] == "desc") {
$link10 = "asc";
} else {
$link10 = "desc";
}
}

if ($link1 == "") { $link1 = "asc"; } // for torrent name
if ($link2 == "") { $link2 = "desc"; }
if ($link3 == "") { $link3 = "desc"; }
if ($link4 == "") { $link4 = "desc"; }
if ($link5 == "") { $link5 = "desc"; }
if ($link7 == "") { $link7 = "desc"; }
if ($link8 == "") { $link8 = "desc"; }
if ($link9 == "") { $link9 = "desc"; }
if ($link10 == "") { $link10 = "desc"; }


echo "<table class='bordered' width=\"100%\">";

echo "<thead><tr>\n";

?>
<th colspan="4">


<?=$tracker_lang['sort'];?> <a href="<? $DEFAULTBASEURL ?>/browse.php?<? print $oldlink; ?>sort=1&type=<? print $link1; ?>"><?=$tracker_lang['s_name'];?></a> | 

<a href="<? $DEFAULTBASEURL ?>/browse.php?<? print $oldlink; ?>sort=4&type=<? print $link4; ?>"><?=$tracker_lang['s_date'];?></a> | 

<a href="<? $DEFAULTBASEURL ?>/browse.php?<? print $oldlink; ?>sort=3&type=<? print $link3; ?>"><?=$tracker_lang['s_comments'];?></a> | 

<a href="<? $DEFAULTBASEURL ?>/browse.php?<? print $oldlink; ?>sort=7&type=<? print $link7; ?>"><?=$tracker_lang['s_seeders'];?></a> | 

<a href="<? $DEFAULTBASEURL ?>/browse.php?<? print $oldlink; ?>sort=8&type=<? print $link8; ?>"><?=$tracker_lang['s_leechers'];?></a>


</th>


<?

echo "</tr></thead>\n";

        torrenttable($res);

echo "</table>";



if ($num_torrents > 25) {
print($pagerbottom);
}

}
else {

        if (isset($cleansearchstr)) {
                print("<div align=\"center\" class=\"error\"><b>".$tracker_lang['nothing_found']."</b></div>\n");
        }
        else {
                print("<div align=\"center\" class=\"error\"><b>".$tracker_lang['nothing_found']."</b></div>\n");
        }
}





stdfoot();

?>
