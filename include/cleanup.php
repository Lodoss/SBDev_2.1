<?
if(!defined('IN_TRACKER'))
  die('Hacking attempt!');

function docleanup() {
	global $torrent_dir, $autoclean_interval, $tracker_lang, $use_xbtt, $signup_timeout;

	@set_time_limit(0);
	@ignore_user_abort(1);
	
	do {
		$res = sql_query("SELECT id FROM torrents") or sqlerr(__FILE__,__LINE__);
		$ar = array();
		while ($row = mysql_fetch_array($res)) {
			$id = $row[0];
			$ar[$id] = 1;
		}

		if (!count($ar))
			break;

		$dp = @opendir($torrent_dir);
		if (!$dp)
			break;

		$ar2 = array();
		while (($file = readdir($dp)) !== false) {
			if (!preg_match('/^(\d+)\.torrent$/', $file, $m))
				continue;
			$id = $m[1];
			$ar2[$id] = 1;
			if (isset($ar[$id]) && $ar[$id])
				continue;
			$ff = $torrent_dir . "/$file";
			unlink($ff);
		}
		closedir($dp);

		if (!count($ar2))
			break;

		$delids = array();
		foreach (array_keys($ar) as $k) {
			if (isset($ar2[$k]) && $ar2[$k])
				continue;
			$delids[] = $k;
			unset($ar[$k]);
		}
		if (count($delids))
			sql_query("DELETE FROM torrents WHERE id IN (" . join(",", $delids) . ")") or sqlerr(__FILE__,__LINE__);

	} while (0);

	



//Delete inactive peers
mysql_query("DELETE FROM `xbt_files_users` WHERE `active` = '0'") or sqlerr(__FILE__, __LINE__);


	// delete unconfirmed users if timeout.
	$deadtime = TIMENOW - $signup_timeout;
	$res = sql_query("SELECT id FROM users WHERE status = 'pending' AND added < FROM_UNIXTIME($deadtime) AND last_login < FROM_UNIXTIME($deadtime) AND last_access < FROM_UNIXTIME($deadtime)") or sqlerr(__FILE__,__LINE__);
	if (mysql_num_rows($res) > 0) {
		while ($arr = mysql_fetch_array($res)) {
			sql_query("DELETE FROM users WHERE id = ".sqlesc($arr["id"]));
		}
	}
	



}


?>
