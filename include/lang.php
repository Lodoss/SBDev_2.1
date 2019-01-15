<?php
if(!defined('IN_TRACKER'))
  die('Hacking attempt!');

header('Cache-control: private'); // IE 6 FIX





$langs = array("ru","en");
$ls = $_GET['lang'];




if(isSet($_GET['lang']) && in_array($ls, $langs))
{
$lang = $_GET['lang'];

// register the session and set the cookie
$_SESSION['lang'] = $lang;

setcookie('lang', $lang, time() + (3600 * 24 * 30));
}
else if(isSet($_SESSION['lang']))
{
$lang = $_SESSION['lang'];
}
else if(isSet($_COOKIE['lang']))
{
$lang = $_COOKIE['lang'];
}
else
{
$lang = 'en';
}

switch ($lang) {
  case 'en':
  $default_language = 'english';
  break;

  case 'ru':
  $default_language = 'russian';
  break;

  default:
  $default_language = 'english';

}
	
include_once('languages/lang_' . $default_language . '/lang_main.php');
?>