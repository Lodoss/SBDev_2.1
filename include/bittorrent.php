<?


# IMPORTANT: Do not edit below unless you know what you are doing!

// DEFINE IMPORTANT CONSTANTS
define('IN_TRACKER', true);

// SET PHP ENVIRONMENT
@error_reporting(E_ALL & ~E_NOTICE);
@ini_set('error_reporting', E_ALL & ~E_NOTICE);
@ini_set('display_errors', '1');
@ini_set('display_startup_errors', '0');
@ini_set('ignore_repeated_errors', '1');
@ignore_user_abort(1);
@set_time_limit(0);
@set_magic_quotes_runtime(0);
@session_start();
define ('ROOT_PATH', dirname(dirname(__FILE__))."/");

function timer() {
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}

// Variables for Start Time
$tstart = timer(); // Start time

// INCLUDE BACK-END
if (empty($rootpath))
	$rootpath = ROOT_PATH;
require_once($rootpath . 'include/core.php');
?>