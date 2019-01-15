<?
require_once("include/bittorrent.php");

dbconn();

if (!mkglobal("type"))
	die();

if ($type == "signup" && mkglobal("email")) {
	if (!validemail($email))
		stderr($tracker_lang['error'], $tracker_lang['invalid_email']);
        stderr($tracker_lang['signup_successful'],($use_email_act ? sprintf($tracker_lang['confirmation_mail_sent'], htmlspecialchars($email)) : sprintf($tracker_lang['thanks_for_registering'], $SITENAME)));
}
elseif ($type == "sysop") {
	if (isset($CURUSER))
		stdmsg($tracker_lang['sysop_activated'],sprintf($tracker_lang['sysop_account_activated'], $DEFAULTBASEURL));
	else
		stderr("Your account has been activated!", "However, it appears that you could not be logged in automatically. A possible reason is that you disabled cookies in your browser. You have to enable cookies to use your account. Please do that and then <a href=\"login.php\">log in</a> and try again.\n");
	}
elseif ($type == "confirmed") {
	stderr($tracker_lang['account_activated'], $tracker_lang['this_account_activated']);
}
elseif ($type == "confirm") {
	if (isset($CURUSER)) {
		stderr($tracker_lang['account_confirmed'], $tracker_lang['account_confirmed_desc']);
	}
	else {
		stderr("Account successfully confirmed!", "Your account has been activated! However, it appears that you could not be logged in automatically. A possible reason is that you disabled cookies in your browser. You have to enable cookies to use your account. Please do that and then <a href=\"login.php\">log in</a> and try again.\n");
	}
}
else
	die();

?>