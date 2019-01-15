<?
require_once("include/bittorrent.php");
dbconn();

if ($CURUSER) {
header("Location: $DEFAULTBASEURL/index.php");	
}	



if(isset($_POST['submit'])) {

	//Check to make sure that the name field is not empty
	if(trim($_POST['username']) == '') {
		$hasError = true;
	} else {
		$username = trim($_POST['username']);
	}

	//Check to make sure that the subject field is not empty
	if(trim($_POST['password']) == '') {
		$hasError = true;
	} else {
		$password = trim($_POST['password']);
	}



	if(!isset($hasError)) {


if (!mkglobal("username:password"))
	die();

function bark($msg) {
	stderr($tracker_lang['error'], $msg);
}

function is_password_correct($password, $secret, $hash) {
	return ($hash == md5($secret . $password . $secret) || $hash == md5($secret . trim($password) . $secret));
}


$res = sql_query("SELECT id, passhash, secret, enabled, status FROM users WHERE username = " . sqlesc($username));
$row = mysql_fetch_array($res);

if (!$row)
	bark("You are not registered!");

if ($row["status"] == 'pending')
	bark($tracker_lang['account_pennding']);

if (!is_password_correct($password, $row['secret'], $row['passhash']))
	bark("Incorrect Password");
	
if ($row["enabled"] == "no")
	bark($tracker_lang['account_banned']);

logincookie($row["id"], $row["passhash"]);


	header("Location: $DEFAULTBASEURL/my.php");	

			
		
	}	

}






stdhead($tracker_lang['authorization']);

?>

<script type="text/javascript">
$(document).ready(function(){
	// validate signup form on keyup and submit
	var validator = $("#contactform").validate({
		rules: {
			username: {
				required: true,
			},
			password: {
				required: true,
			},
		},
		messages: {
			username: {
				required: "Please enter your username"
			},
			password: {
				required: "Please enter your password"
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
					<label for="username"><?=$tracker_lang['signup_username'];?></label>
                    <input type="text" name="username" value="" tabindex="1" placeholder="<?=$tracker_lang['signup_username_desc'];?>" />		
				</div>
				
				<div class="field">
					<label for="password"><?=$tracker_lang['signup_password'];?></label>
					<input type="password" name="password" value="" tabindex="2" placeholder="<?=$tracker_lang['signup_password_desc'];?>" />			
				</div>
				   

		</div> <!-- .login_fields -->
			<div class="login_actions">            
                               		<button type="submit" class="btn btn-grey" name="submit" tabindex="3"><?=$tracker_lang['login_btn'];?></button>
					     
							</div>
		</div> <!-- #login_panel -->	

</form>


	</div>
	
</div>


<?

stdfoot();

?>
