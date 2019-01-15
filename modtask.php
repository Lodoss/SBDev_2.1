<?

require "include/bittorrent.php";

dbconn(false);

loggedinorreturn();

maxsysop();

function puke($text = "You have forgotten here someting?") {
	global $tracker_lang;
	stderr($tracker_lang['error'], $text);
}

function barf($text = "Пользователь удален") {
	global $tracker_lang;
	stderr($tracker_lang['success'], $text);
}

if (get_user_class() < UC_MODERATOR)
	puke($tracker_lang['access_denied']);

$action = $_POST["action"];

if ($action == "edituser") {
	$userid = $_POST["userid"];
	$comment = $_POST["comment"];
	$enabled = $_POST["enabled"];
	$modcomm = htmlspecialchars($_POST["modcomm"]);
	$deluser = $_POST["deluser"];
	$why = $_POST['why']; 
	$select = $_POST['unit'];

	$class = 0 + $_POST["class"];
	if (!is_valid_id($userid) || !is_valid_user_class($class))
		stderr($tracker_lang['error'], "Неверный идентификатор пользователя или класса.");
	// check target user class
	$res = sql_query("SELECT enabled, username, comment, class, modcomment, ip FROM users WHERE id = $userid") or sqlerr(__FILE__, __LINE__);
	$arr = mysql_fetch_assoc($res) or puke("Ошибка MySQL: " . mysql_error());
	$curenabled = $arr["enabled"];
	$curcomment = $arr["comment"];
	$curclass = $arr["class"];
	
	
	$ip = $arr["ip"];
	$banip = ip2long($ip);
	
	
	if (get_user_class() == UC_SYSOP)
		$modcomment = $_POST["modcomment"];
	else
		$modcomment = $arr["modcomment"];
	// User may not edit someone with same or higher class than himself!
	if ($curclass >= get_user_class() || $class >= get_user_class())
		puke("Так нельзя делать!");
    }



	if ($curclass != $class) {
		$updateset[] = "class = $class";
		$what = ($class > $curclass ? "Повышен" : "Пониженен");
 		$modcomment = date("Y-m-d") . " - $what до класса \"" . get_user_class_name($class) . "\" пользователем $CURUSER[username].\n". $modcomment;
	}

if ($comment != $curcomment)
{
if ($comment == 'yes')
{
$modcomment = gmdate("Y-m-d") . " - Комментарии были разрешены пользователем " . $CURUSER['username'] . ".\n" . $modcomment;
}
else
{
$modcomment = gmdate("Y-m-d") . " - Комментарии были отключенны пользователем " . $CURUSER['username'] . ".\n" . $modcomment;
}
}

	if ($enabled != $curenabled) {
		$modifier = (int) $CURUSER['id'];
		if ($enabled == 'yes') {
			if (!isset($_POST["enareason"]) || empty($_POST["enareason"]))
				puke("Введите причину почему вы включаете пользователя!");
			$enareason = htmlspecialchars($_POST["enareason"]);
			$modcomment = date("Y-m-d") . " - Включен пользователем " . $CURUSER['username'] . ".\nПричина: $enareason\n" . $modcomment;
			sql_query('DELETE FROM bans WHERE first = '.$banip.' AND last = '.$banip) or sqlerr();
			$updateset[] = "enabled = 'yes'";
		} else {
			if (!isset($_POST["disreason"]) || empty($_POST["disreason"]))
				puke("Введите причину почему вы отключаете пользователя!");
			$disreason = htmlspecialchars($_POST["disreason"]);
			$modcomment = date("Y-m-d") . " - Отключен пользователем " . $CURUSER['username'] . ".\nПричина: $disreason\n" . $modcomment;
			$added = get_date_time();
			sql_query('INSERT INTO bans (added, addedby, first, last, comment) VALUES ('.implode(', ', array_map('sqlesc', array($added, $CURUSER[id], $banip, $banip, $disreason))).')') or sqlerr();
			$updateset[] = "enabled = 'no'";
		}
	}

	$updateset[] = "comment = " . sqlesc($comment);
	
	if (!empty($modcomm))
		$modcomment = date("Y-m-d") . " - Заметка от $CURUSER[username]: $modcomm\n" . $modcomment;
	$updateset[] = "modcomment = " . sqlesc($modcomment);

	sql_query("UPDATE users SET	" . implode(", ", $updateset) . " WHERE id = $userid") or sqlerr(__FILE__, __LINE__);
	if (!empty($_POST["deluser"])) {
		$res=@sql_query("SELECT * FROM users WHERE id = $userid") or sqlerr(__FILE__, __LINE__);
		$user = mysql_fetch_array($res);
		$username = $user["username"];
		$email=$user["email"];
		sql_query("DELETE FROM users WHERE id = $userid") or sqlerr(__FILE__, __LINE__);
		sql_query("DELETE FROM comments WHERE user = $userid") or sqlerr(__FILE__, __LINE__);
		$deluserid=$CURUSER["username"];
		barf();
	} else {
		$returnto = htmlentities($_POST["returnto"]);
		header("Refresh: 0; url=$DEFAULTBASEURL/$returnto");
		die;
}

puke();

?>