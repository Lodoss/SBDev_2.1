<?
require_once("include/bittorrent.php");

function bark($msg) {
	stderr($tracker_lang['error'], $msg);
}

dbconn();

loggedinorreturn();

maxsysop();

if (!mkglobal("email:oldpassword:chpassword:passagain"))
	bark("missing form data");

// $set = array();

$updateset = array();
$changedemail = 0;

if ($chpassword != "") {
	if (strlen($chpassword) > 40)
		bark($tracker_lang['my_pass_too_long']);
	if ($chpassword != $passagain)
		bark($tracker_lang['my_pass_not_match']);
    if ($CURUSER["passhash"] != md5($CURUSER["secret"] . $oldpassword . $CURUSER["secret"]))
            bark($tracker_lang['my_old_pass_error']);


		$sec = mksecret();
		$passhash = md5($sec . $chpassword . $sec);
		$updateset[] = "secret = " . sqlesc($sec);
		$updateset[] = "passhash = " . sqlesc($passhash);
		
		logincookie($CURUSER["id"], $passhash);
		$passupdated = 1;
}

if ($email != $CURUSER["email"]) {
	if (!validemail($email))
		bark($tracker_lang['my_invalid_mail']);
  $r = sql_query("SELECT id FROM users WHERE email=" . sqlesc($email)) or sqlerr(__FILE__, __LINE__);
	if (mysql_num_rows($r) > 0)
		bark("" . $tracker_lang['my_allready_in_use'] . " (<b>$email</b>)");
	$changedemail = 1;
}

$view_xxx = ($_POST["view_xxx"] != "" ? "yes" : "no");


$updateset[] = "view_xxx = '$view_xxx'";


/* ****** */

$urladd = "";

if ($changedemail) {
	$sec = mksecret();
	$hash = md5($sec . $email . $sec);
	$obemail = urlencode($email);
	$updateset[] = "editsecret = " . sqlesc($sec);
	$thishost = $_SERVER["HTTP_HOST"];
	$thisdomain = preg_replace('/^www\./is', "", $thishost);
	$body = <<<EOD
You have requested that your user profile (username {$CURUSER["username"]})
on $thisdomain should be updated with this email address ($email) as
user contact.

If you did not do this, please ignore this email. The person who entered your
email address had the IP address {$_SERVER["REMOTE_ADDR"]}. Please do not reply.

To complete the update of your user profile, please follow this link:

http://$thishost/confirmemail.php?id={$CURUSER["id"]}&hash=$hash&email=$obemail

Your new email address will appear in your profile after you do this. Otherwise
your profile will remain unchanged.
EOD;

	mail($email, "$thisdomain profile change confirmation", $body, "From: $SITEEMAIL");

	$urladd .= "&mailsent=1";
}

sql_query("UPDATE users SET " . implode(",", $updateset) . " WHERE id = " . $CURUSER["id"]) or sqlerr(__FILE__,__LINE__);

header("Location: $DEFAULTBASEURL/my.php?edited=1" . $urladd);

?>