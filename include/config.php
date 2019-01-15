<?
# IMPORTANT: Do not edit below unless you know what you are doing!
if(!defined('IN_TRACKER') && !defined('IN_ANNOUNCE'))
  die('Hacking attempt!');

$SITE_ONLINE = true;
//$SITE_ONLINE = local_user();
//$SITE_ONLINE = false;

$max_torrent_size = 1024 * 1024;
$signup_timeout = 86400 * 3;

// Max users on site
$maxusers = 10000000; // LoL Who we kiddin' here?

$torrent_dir = "torrents";    # FOR UNIX ONLY - must be writable for httpd user
//$torrent_dir = "C:/web/Apache2/htdocs/tbsource/torrents";    # FOR WINDOWS ONLY - must be writable for httpd user


// Email for sender/return path.
$SITEEMAIL = "noreply@" . $_SERVER["HTTP_HOST"];

$SITENAME = "SBDev v2.1";

$autoclean_interval = 900;


$ctracker = 1; // Use CrackerTracker - anti-cracking system. I personaly think it's un-needed...
$default_theme = "default"; // Default theme
$deny_signup = 0; // 1 = disable signup
$use_email_act = 0; // 0 = disable signup via email
$use_gzip = 1; // use GZIP?
$use_ipbans = 1; // use IP ban?
$smtptype = "advanced";



/////data base config
$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_pass = 'root';
$mysql_db = 'seedbay';
$mysql_charset = 'utf8';


?>
