<?
# IMPORTANT: Do not edit below unless you know what you are doing!
if(!defined('IN_TRACKER') && !defined('IN_ANNOUNCE'))
  die("Hacking attempt!");

if (!function_exists("htmlspecialchars_uni")) {
	function htmlspecialchars_uni($message) {
		$message = preg_replace("#&(?!\#[0-9]+;)#si", "&amp;", $message); // Fix & but allow unicode
		$message = str_replace("<","&lt;",$message);
		$message = str_replace(">","&gt;",$message);
		$message = str_replace("\"","&quot;",$message);
		$message = str_replace("  ", "&nbsp;&nbsp;", $message);
		return $message;
	}
}

// DEFINE IMPORTANT CONSTANTS
define ('TIMENOW', time());
$url = explode('/', htmlspecialchars_uni($_SERVER['PHP_SELF']));
array_pop($url);
$DEFAULTBASEURL = (($_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://").htmlspecialchars_uni($_SERVER['HTTP_HOST']).implode('/', $url);
$BASEURL = $DEFAULTBASEURL;


// SECURITY
define ('COOKIE_SALT', 'sEEdBayV2');
define ('COOKIE_UID', 'uid');
define ('COOKIE_PASSHASH', 'pass');


// DEFINE TRACKER GROUPS
define ("UC_USER", 0);
define ("UC_UPLOADER", 1);
define ("UC_MODERATOR", 2);
define ("UC_SYSOP", 3);
?>
