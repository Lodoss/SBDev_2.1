<?

require "include/bittorrent.php";
dbconn();



///if ($_SERVER["REQUEST_METHOD"] == "POST") {
if(isset($_POST['submit'])) {


	if(trim($_POST['email']) == '')  {
		$hasError = true;
	} else if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", trim($_POST['email']))) {
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}
	
	
	
	
	
		if(!isset($hasError)) {
	
	$res = sql_query("SELECT * FROM users WHERE email = " . sqlesc($email) . " LIMIT 1") or sqlerr(__FILE__, __LINE__);
	$arr = mysql_fetch_assoc($res) or stderr($tracker_lang['error'], $tracker_lang['recover_cat_find_email']);

	$sec = mksecret();

	sql_query("UPDATE users SET editsecret = " . sqlesc($sec) . " WHERE id = " . $arr["id"]) or sqlerr(__FILE__, __LINE__);
	if (!mysql_affected_rows())
		stderr($tracker_lang['error'], $tracker_lang['recover_mysql_error']);


	$email = $arr['email'];
	$hash = md5($sec . $email . $arr["passhash"] . $sec);

  $body = <<<EOD
Hi,

Someone, hopefully you, requested that the password for the account
associated with this email address ($email) be reset.

The request originated from {$_SERVER["REMOTE_ADDR"]}.

If you did not do this ignore this email. Please do not reply.

Should you wish to confirm this request, please follow this link:

$DEFAULTBASEURL/recover.php?id={$arr["id"]}&secret=$hash

After you do this, your password will be reset and emailed back
to you.

--
$SITENAME
EOD;


	sent_mail($arr["email"],$SITENAME,$SITEEMAIL,"Password recover: $SITENAME",$body)
		or stderr($tracker_lang['error'], $tracker_lang['recover_unable_s_mail']);
	stderr($tracker_lang['success'], sprintf($tracker_lang['recover_first_mail_sent'], htmlspecialchars($email)));
	
	
	
	} ///if(!isset($hasError))
}
elseif($_GET)
{
	$id = intval($_GET["id"]);
	$md5 = $_GET["secret"];

	if (!$id)
	  httperr();

	$res = sql_query("SELECT username, email, passhash, editsecret FROM users WHERE id = $id");
	$arr = mysql_fetch_array($res) or httperr();

  $email = $arr["email"];

	$sec = hash_pad($arr["editsecret"]);
	if (preg_match('/^ *$/s', $sec))
	  httperr();
	if ($md5 != md5($sec . $email . $arr["passhash"] . $sec))
	  httperr();

	// generate new password;
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

  $newpassword = "";
  for ($i = 0; $i < 10; $i++)
    $newpassword .= $chars[mt_rand(0, strlen($chars) - 1)];

 	$sec = mksecret();

  $newpasshash = md5($sec . $newpassword . $sec);

	sql_query("UPDATE users SET secret=" . sqlesc($sec) . ", editsecret='', passhash=" . sqlesc($newpasshash) . " WHERE id=$id AND editsecret=" . sqlesc($arr["editsecret"]));

	if (!mysql_affected_rows())
		stderr($tracker_lang['error'], $tracker_lang['recover_cant_update']);

	$body = <<<EOD
As per your request we have generated a new password for your account.

Here is the information we now have on file for this account:

    User name: {$arr["username"]}
    Password: $newpassword

You may login at: $DEFAULTBASEURL/login.php

--
$SITENAME
EOD;

	sent_mail($email,$SITENAME,$SITEEMAIL,"New Password: $SITENAME",$body)
		or stderr($tracker_lang['error'], $tracker_lang['recover_unable_s_mail']);
		stderr($tracker_lang['success'], sprintf($tracker_lang['recover_mail_sent'], htmlspecialchars($email)));
} else {

 	stdhead($tracker_lang['recover_btn']);
	?>
	
<script type="text/javascript">
$(document).ready(function(){
	// validate signup form on keyup and submit
	var validator = $("#contactform").validate({
		rules: {
			email: {
				required: true,
				email: true
			},
		},
		messages: {
			email: {
				required: "<?=$tracker_lang['recover_email_missing'];?>",
				minlength: "<?=$tracker_lang['invalid_email'];?>"
			},
		},
		// set this class to error-labels to indicate valid fields
		success: function(label) {
			label.addClass("checked");
		}
	});
});
</script>



<div class="wrapper" align="center">
	<div id="contactWrapper" role="form" align="left">


		<?php if(isset($hasError)) { //If errors are found ?>
			<p class="error">All fields should be filled out!</p>
		<?php } ?>

		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="contactform">

	      	<div id="login_panel">
			<div class="login_fields">
				<div class="field">    
					<label for="email"><?=$tracker_lang['signup_email'];?></label>
                    <input type="text" name="email" value="" tabindex="1" placeholder="<?=$tracker_lang['recover_email_desc'];?>" />		
				</div>
				   

		</div> <!-- .login_fields -->
			<div class="login_actions">            
                               		<button type="submit" class="btn btn-red" name="submit" tabindex="2"><?=$tracker_lang['recover_btn'];?></button>
					     
							</div>
		</div> <!-- #login_panel -->		
	
	</form>
	
	
	</div>
	
</div>	
	
	
	
	
	<?
	stdfoot();
}
?>
