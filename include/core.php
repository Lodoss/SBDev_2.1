<?
# IMPORTANT: Do not edit below unless you know what you are doing!
if (!defined("IN_TRACKER"))
  die("Hacking attempt!");

// INCLUDE/REQUIRE BACK-END
require_once($rootpath . 'include/init.php');
require_once($rootpath . 'include/global.php');
require_once($rootpath . 'include/config.php');
require_once($rootpath . 'include/functions.php');
require_once($rootpath . 'include/lang.php');
require_once($rootpath . 'include/functions_global.php');


// INCLUDE SECURITY BACK-END 
if ($ctracker == "1") 
        require_once($rootpath . 'include/ctracker.php'); 

define ("DEBUG_MODE", 0); // Shows the queries at the bottom of the page. 

if (!isset($HTTP_POST_VARS) && isset($_POST)) { 
    $HTTP_POST_VARS = $_POST; 
    $HTTP_GET_VARS = $_GET; 
    $HTTP_SERVER_VARS = $_SERVER; 
    $HTTP_COOKIE_VARS = $_COOKIE; 
    $HTTP_ENV_VARS = $_ENV; 
    $HTTP_POST_FILES = $_FILES; 
} 

if (get_magic_quotes_gpc()) { 
    if (!empty($_GET))    { $_GET    = strip_magic_quotes($_GET);    } 
    if (!empty($_POST))   { $_POST   = strip_magic_quotes($_POST);   } 
    if (!empty($_COOKIE)) { $_COOKIE = strip_magic_quotes($_COOKIE); } 
} 

if (!get_magic_quotes_gpc()) { 
    if (is_array($HTTP_GET_VARS)) { 
        while (list($k, $v) = each($HTTP_GET_VARS)) { 
            if (is_array($HTTP_GET_VARS[$k])) { 
                while (list($k2, $v2) = each($HTTP_GET_VARS[$k])) { 
                    $HTTP_GET_VARS[$k][$k2] = addslashes($v2); 
                } 
                @reset($HTTP_GET_VARS[$k]); 
            } else { 
                $HTTP_GET_VARS[$k] = addslashes($v); 
            } 
        } 
        @reset($HTTP_GET_VARS); 
    } 

    if (is_array($HTTP_POST_VARS)) { 
        while (list($k, $v) = each($HTTP_POST_VARS)) { 
            if (is_array($HTTP_POST_VARS[$k])) { 
                while (list($k2, $v2) = each($HTTP_POST_VARS[$k])) { 
                    $HTTP_POST_VARS[$k][$k2] = addslashes($v2); 
                } 
                @reset($HTTP_POST_VARS[$k]); 
            } else { 
                $HTTP_POST_VARS[$k] = addslashes($v); 
            } 
        } 
        @reset($HTTP_POST_VARS); 
    } 

    if (is_array($HTTP_COOKIE_VARS)) { 
        while (list($k, $v) = each($HTTP_COOKIE_VARS)) { 
            if (is_array($HTTP_COOKIE_VARS[$k])) { 
                while (list($k2, $v2) = each($HTTP_COOKIE_VARS[$k])) { 
                    $HTTP_COOKIE_VARS[$k][$k2] = addslashes($v2); 
                } 
                @reset($HTTP_COOKIE_VARS[$k]); 
            } else { 
                $HTTP_COOKIE_VARS[$k] = addslashes($v); 
            } 
        } 
        @reset($HTTP_COOKIE_VARS); 
    } 
} 
?>