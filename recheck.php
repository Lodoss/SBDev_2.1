<? 

require_once("include/Tupdate.php"); 

dbconn();

$id = (int)$_GET["id"];

if (!is_valid_id($id))
        stderr($tracker_lang['error'], $tracker_lang['invalid_id']);



$res = sql_query("SELECT scrape_time, scrape FROM torrents WHERE id = $id")
        or sqlerr(__FILE__, __LINE__);
$row = mysql_fetch_array($res);

if (!$row)
        stderr($tracker_lang['error'], $tracker_lang['invalid_id']);
			
	if ($row["scrape"] == 'yes'){
		
   scrape_check($id);
      
   header("Location: details.php?id=$id"); 
   
   die();

		} else {
		
	header("Location: details.php?id=$id"); 
		
		}


?>