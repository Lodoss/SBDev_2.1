<?
require_once("include/bittorrent.php");
require_once("include/email.inc.php");
dbconn();

if ($CURUSER) {
header("Location: $DEFAULTBASEURL/index.php");	
}	


if(isset($_POST['submit'])) {

	//Check to make sure that the name field is not empty
	if(trim($_POST['wantusername']) == '') {
		$hasError = true;
	} else {
		$wantusername = trim($_POST['wantusername']);
	}

	//Check to make sure that the subject field is not empty
	if(trim($_POST['wantpassword']) == '') {
		$hasError = true;
	} else {
		$wantpassword = trim($_POST['wantpassword']);
	}
	
	
	//Check to make sure that the subject field is not empty
	if(trim($_POST['passagain']) == '') {
		$hasError = true;
	} else {
		$passagain = trim($_POST['passagain']);
	}

	//Check to make sure sure that a valid email address is submitted
	if(trim($_POST['email']) == '')  {
		$hasError = true;
	} else if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", trim($_POST['email']))) {
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}


	//If there is no error, send the email
	if(!isset($hasError)) {



if ($deny_signup)
	stderr($tracker_lang['error'], $tracker_lang['signup_disabled']);

$users = get_row_count("users");
if ($users >= $maxusers)
	stderr($tracker_lang['error'], sprintf($tracker_lang['signup_users_limit'], number_format($maxusers)));

if (!mkglobal("wantusername:wantpassword:passagain:email"))
	stderr($tracker_lang['error'], $tracker_lang['signup_direct_access']);

if ($users > 0 && $use_email_act == 1)
	define ('ACTIVATION', 'yes');
else
	define ('ACTIVATION', 'no');

function bark($msg) {
	stderr($tracker_lang['error'], $msg);
}

function validusername($username)
{
	if ($username == "")
	  return false;

	// The following characters are allowed in user names
	$allowedchars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_";

	for ($i = 0; $i < strlen($username); ++$i)
	  if (strpos($allowedchars, $username[$i]) === false)
	    return false;

	return true;
}


$view_xxx = 'no';


/* if (strlen($wantusername) > 12)
	bark($tracker_lang['username_too_long']);


if ($wantpassword != $passagain)
	bark($tracker_lang['password_mismatch']);

 if (strlen($wantpassword) < 6)
	bark($tracker_lang['password_too_short']);


if (strlen($wantpassword) > 40)
	bark($tracker_lang['password_too_long']);
*/

if ($wantpassword == $wantusername)
	bark($tracker_lang['password_cant_be_as_username']);

/* if (!validemail($email))
	bark($tracker_lang['invalid_email']);
*/

if (!validusername($wantusername))
	bark($tracker_lang['invalid_username']);



// check if email addy is already in use
$a = (@mysql_fetch_row(@sql_query("SELECT COUNT(*) FROM users WHERE email=".sqlesc($email)))) or die(mysql_error());
if ($a[0] != 0)
	bark(sprintf($tracker_lang['email_allready_registered'], $email));

$ip = getip();

if (isset($_COOKIE["uid"]) && is_numeric($_COOKIE["uid"]) && $users) {
    $cid = intval($_COOKIE["uid"]);
    $c = sql_query("SELECT enabled FROM users WHERE id = $cid ORDER BY id DESC LIMIT 1");
    $co = @mysql_fetch_row($c);
    if ($co[0] == 'no') {
		sql_query("UPDATE users SET ip = '$ip', last_access = NOW() WHERE id = $cid");
		bark($tracker_lang['your_ip_banned']);
    } else
		bark($tracker_lang['unable_to_signup']);
} else {
    $b = (@mysql_fetch_row(@sql_query("SELECT enabled, id FROM users WHERE ip LIKE '$ip' ORDER BY last_access DESC LIMIT 1")));
    if ($b[0] == 'no') {
		$banned_id = $b[1];
        setcookie("uid", $banned_id, "0x7fffffff", "/");
		bark($tracker_lang['your_ip_banned']);
    }
}

$secret = mksecret();
$wantpasshash = md5($secret . $wantpassword . $secret);
$editsecret = (!$users?"":mksecret());

if ((!$users) || (!$use_email_act == true))
	$status = 'confirmed';
else
	$status = 'pending';

$ret = sql_query("INSERT INTO users (username, passhash, secret, editsecret, view_xxx, email, status, ". (!$users?"class, ":"") ."added) VALUES (" .
		implode(",", array_map("sqlesc", array($wantusername, $wantpasshash, $secret, $editsecret, $view_xxx, $email, $status))).
		", ". (!$users?UC_SYSOP.", ":""). "'". get_date_time() ."')");// or sqlerr(__FILE__, __LINE__);

if (!$ret) {
	if (mysql_errno() == 1062)
	bark(sprintf($tracker_lang['username_allready_taken'], $wantusername));
	bark("Unknown error. Answer from mySQL: ".htmlspecialchars(mysql_error()));
}

$id = mysql_insert_id();


$psecret = md5($editsecret);

$body = <<<EOD
You have requested a new user account on RussBay.com and you have
specified this address ($email) as user contact.

If you did not do this, please ignore this email. The person who entered your
email address had the IP address $ip. Please do not reply.

To confirm your user registration, you have to follow this link:

$DEFAULTBASEURL/confirm.php?id=$id&secret=$psecret

After you do this, you will be able to use your new account. If you fail to
do this, you account will be deleted within a few days.
EOD;

if($use_email_act && $users) {
	if (!email($email,"Confirmation from RussBay.com",$body,"From: $SITEEMAIL", "-f$SITEEMAIL")) {
		stderr($tracker_lang['error'], "Unable to send an E-Mail. Try later");
	}
} else {
	logincookie($id, $wantpasshash);
}

header("Refresh: 0; url=$DEFAULTBASEURL/ok.php?type=". (!$users?"sysop":("signup&email=" . urlencode($email))));






	}
}





	stdhead($tracker_lang['signup_btn']);

?>

<script type="text/javascript">
$(document).ready(function(){
	// validate signup form on keyup and submit
	var validator = $("#contactform").validate({
		rules: {
			wantusername: {
				required: true,
				rangelength: [3, 12]
			},
			wantpassword: {
				required: true,
				rangelength: [6, 24]
			},
			passagain: {
				equalTo: "#wantpassword"
			},
			email: {
				required: true,
				email: true
			}
		},
		messages: {
			wantusername: {
				required: "Please enter your username",
				rangelength: "Required, minium length 3, maximum length 12"
			},
			wantpassword: {
				required: "Please enter your password",
				rangelength: "Required, minium length 6, maximum length 24"
			},
			passagain: {
				equalTo: "Passwords does not match"
			},
			email: {
				required: "<?=$tracker_lang['invalid_email'];?>",
				minlength: "<?=$tracker_lang['invalid_email'];?>"
			}
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
			<p class="error"><?=$tracker_lang['signup_all_fields'];?></p>
		<?php } ?>


<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="contactform">

      	<div id="login_panel">
			<div class="login_fields">
				<div class="field">    
					<label for="username"><?=$tracker_lang['signup_username'];?></label>
                    <input type="text" name="wantusername" value="" tabindex="1" placeholder="<?=$tracker_lang['signup_username_desc'];?>" />		
				</div>
				
				<div class="field">
					<label for="password"><?=$tracker_lang['signup_password'];?></label>
					<input type="password" name="wantpassword" id="wantpassword" value="" tabindex="2" placeholder="<?=$tracker_lang['signup_password_desc'];?>" />			
				</div>

				<div class="field">
					<label for="passagain"><?=$tracker_lang['signup_password_again'];?></label>
					<input type="password" name="passagain" id="passagain" value="" tabindex="3" placeholder="<?=$tracker_lang['signup_password_again_desc'];?>" />			
				</div>                

				<div class="field">
					<label for="email"><?=$tracker_lang['signup_email'];?></label>
					<input type="text" name="email" value="" tabindex="4" placeholder="<?=$tracker_lang['signup_email_desc'];?>" />			
				</div>   
				   

		</div> <!-- .login_fields -->
			<div class="login_actions">            
                               		<button type="submit" class="btn btn-blue" name="submit" tabindex="5"><?=$tracker_lang['signup_btn'];?></button>
					     
							</div>
		</div> <!-- #login_panel -->	

</form>


	</div>
	
</div>




<?

stdfoot();

?>
