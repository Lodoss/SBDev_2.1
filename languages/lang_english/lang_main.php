<?php

class lang implements arrayaccess {
	private $tlr = array();
	public function __construct() {
		$this->tlr = array(

'language_charset' => 'utf-8',

////header info
'header_desc' => 'International Torrent Tracker. Download with NO LIMITS',
'header_keywords' => 'torrents, free, download, movies, games, tv shows, applications, music, cartoons, xxx',


////main menu (stdheader.php)
'homepage' => 'Home',
'browse' => 'Torrents',
'cats' => 'Categories',
'upload' => 'Upload',
'comments' => 'Comments',
'contact' => 'Contact',
'forum' => 'Forum',



////user small menu
'login' => 'Login',
'signup' => 'Signup',
'logout' => 'Logout',
'profile' => 'Profile',
'my_torrents' => 'My Torrents',


////search box
'search_holder' => 'Torrent Search',
'in' => 'in',
'all_types' => 'All types',
'search' => 'Search',

't_lang' => 'Language',
'russian' => 'Russian',
'latvian' => 'Latvian',
'english' => 'English',
'lang_other' => 'Other',
'choose_lang' => 'Choose',



////moderator message (torrents that need to bee checked)
'need_modded' => 'Added [<b>%d</b>] new torrents that should be <a href="/browse.php?modded=1"><b>checked</b></a>',


////footer
'page_generated' => 'Loaded in %f seconds with %d queries',
'stats' => '%d peers (%d seeders + %d leechers) in %d torrents',


////main page (index.php)
'torrents_in_24h' => 'Top torrents in last 24 hours',
'no_torrents_in_24h' => 'There are no uploaded torrents in the last 24 hours!',


////browse page (browse.php)
't_browse' => 'Torrents list',
'search_results_for' => 'Search results for',
'search_results_tags' => 'Search result by tag:',
'search_results_user' => 'Torrents uploaded by:',
'need_mod' => 'Not checked',
'sort' => 'Sort by:',
's_name' => 'Name',
's_date' => 'Date',
's_comments' => 'Comments',
's_seeders' => 'Seeders',
's_leechers' => 'Leechers',
'nothing_found' => 'Nothing found',


////details page (details.php)
'invalid_id' => 'Invalid ID.',
'not_modded' => 'Torrent is currently under review',
'show_xxx' => 'You are not registered to view XXX torrents and / or you have chose to disabled it in account settings',
'annonym' => 'Anonymous',
'uploader' => 'Author',
'category' => 'Category',
'size' => 'Size',
'tracker_leechers' => 'Leechers',
'tracker_seeders' => 'Seeders',
'snatched' => 'Downloads',
'download' => 'Download',
'tags' => 'Tags',
'screens' => 'Screenshots',
'trailer' => 'Trailer',
'add_comment' => 'Add comment',
'edited_by' => 'Edited by',
'comments_disable' => 'Comments are disabled!',
'comment_cant_be_empty' => 'Please add comment!',
'you_want_to_delete_x_click_here' => 'You want to delete %s. Click <a href="%s">here</a> to confirm.',
'delete' => 'Delete',
'comment' => 'comment',
'your_comment_was_last' => 'We detected that the last comment was added by you',
'to_change_comment_click' => 'To change your comment please use the link',
'btn_edit_comment' => 'Edit',
'edit_comment_for' => 'Editing comment for',
'comments_flood' => 'You can not add more than <b>%d</b> comments in time interval of <b>%d</b> minutes!',


////account page (my.php)
'my_my' => 'Account',
'my_updated' => 'Account updated!',
'my_mail_sent' => 'Confirmation email has been sent!',
'my_mail_updated' => 'E-mail has been updated!',
'my_mail' => 'Email',
'my_old_pass' => 'Old password',
'my_new_pass' => 'New password',
'my_new_pass_again' => 'Confirm new password',
'my_xxx_torrents' => 'XXX torrents',
'my_xxx_descr' => 'Please check to enable XXX torrents',
'my_mail_update_descr' => '<b>Note:</b> In order to change your account email, you will receive confirmation letter to your new email',
'my_pass_too_long' => 'Sorry, but your password is too long (40 characters Max)',
'my_pass_not_match' => 'Passwords do not match.',
'my_old_pass_error' => 'You entered wrong old password.',
'my_invalid_mail' => 'Looks like invalid email.',
'my_allready_in_use' => 'This email address has been registered by another user.',


////upload and edit page (add.php and edit.php)
'upload_torrent' => 'Upload torrent',
'add_user_class_notif' => '<b>Your class is lower than VIP. In order to view this torrent in the listing, it has to bee approved by our staff!</b>',
'add_announce_url' => 'Announce url',
'torrent_file' => 'Torrent file',
'torrent_name' => 'Name',
'torrent_poster' => 'Poster',
'torrent_poster_descr' => 'Poster link',
'type' => 'Type',
'choose_cat' => 'Choose',
'torrent_trailer' => 'Trailer',
'torrent_trailer_desc' => 'Link from youtube.com',
'torrent_screens' => 'Screenshots',
'torrent_screens_desc' => 'Screenshot link nr.',
'torrent_tags' => 'Tags',
'torrent_tags_descr' => 'Example: tag1, tag2, tag3',
'torrent_external' => 'External',
'torrent_external_desc' => 'Check if this torrent is from external tracker',
'torrent_annonym' => 'Anonymous',
'torrent_annonym_desc' => 'Check to hide your nickname',
'torrent_upload' => 'Upload',
'torrent_upload_failed' => 'Empty filename!',
'torrent_need_desc' => 'Please add description to your torrent!',
'torrent_need_cat' => 'You need to choose type of torrent!',
'torrent_invalid_filename' => 'Invalid filename!',
'torrent_not_torrent' => 'Not a torrent (.torrent).',
'torrent_empty_file' => 'Empty file!',
'torrent_not_binary' => 'We can not upload file that is not binary coded!',
'torrent_edit' => 'Editing torrent',
'torrent_cant_edit' => 'You have no permissions to edit this torrent.',
'torrent_modded' => 'Checked',
'torrent_modded_desc' => 'Checked by staff?',
'torrent_edit_btn' => 'Edit',
'torrent_delete_btn' => 'Delete',
'torrent_add_tname' => 'Please add torrent name',
'torrent' => 'torrent',
'torrent_sticky' => 'Sticky',
'torrent_sticky_desc' => 'Add this torrent to main page?',



////login and signup and recover pages
'authorization' => 'Authorization',
'signup_username' => 'Username',
'signup_username_desc' => 'enter your username',
'signup_password' => 'Password',
'signup_password_desc' => 'enter your password',
'login_btn' => 'Login',
'signup_password_again' => 'Confirm password',
'signup_password_again_desc' => 're-enter your password',
'signup_email' => 'Email',
'signup_email_desc' => 'enter your email',
'signup_btn' => 'Signup',
'recover_btn' => 'Recover',
'recover_email_desc' => 'enter your registered email',
'login_failed' => 'Login failed!',
'account_pennding' => 'Your account is still pending. Please activate your account.',
'account_banned' => 'Your account is banned.',
'login_failed_desc' => 'Username or password failed! To recover your password please click <a href="/login.php">here</a>.',
'login_banned' => 'Login is banned!',
'login_banned_desc' => 'You failed <b>4</b> logins and that is why we banned your IP for today!',
'signup_disabled' => 'Sorry, but registration is disabled by administration.',
'signup_users_limit' => 'Users limit of (%d) is reached. Please try later...',
'signup_already_registered' => 'You are already registered user %s!',
'signup_direct_access' => 'Direct access to this file is disabled.',
'signup_all_fields' => 'All fields must be filled.',
'username_too_long' => 'Sorry, but your username is too long (12 characters Max.)',
'password_mismatch' => 'Passwords does not match.',
'password_too_short' => 'Sorry, but your password is too short (6 characters Min.)',
'password_too_long' => 'Sorry, but your password is too long (40 characters Max.)',
'password_cant_be_as_username' => 'Sorry, but you can not use your username as a password.',
'invalid_email' => 'Looks like invalid email.',
'invalid_username' => 'Looks like invalid username.',
'email_allready_registered' => 'E-mail address <b>%s</b> is already registered.',
'your_ip_banned' => 'Your IP is banned on this tracker.',
'unable_to_signup' => 'Unable to signup!',
'username_allready_taken' => 'Username <b>%s</b> is already taken!',
'recover_unable_s_mail' => 'Unable to send an email. Please contact administration.',
'recover_mail_sent' => 'Information for your account is sent to an E-Mail <b>%s</b>.',
'recover_email_missing' => 'Please enter email',
'recover_cat_find_email' => 'We can not find this email on our tracker',
'recover_mysql_error' => 'Database error. Please contact administration.',
'recover_first_mail_sent' => 'Confirmation email was sent to <b>%s</b>. After few minutes you will receive an email with further instructions.',
'recover_cant_update' => 'We could not update your information. Please contact administration.',
'signup_successful' => 'Thank you for registration!',
'confirmation_mail_sent' => 'Confirmation email was sent to (%s). You need to confirm your account before you can login to our tracker. If you do not do so, your new account will be deleted in few days!',
'thanks_for_registering' => 'Thank you for registration on %s! Now you can <a href="/my.php">login</a> and enjoy our community.',
'sysop_account_activated' => 'SYSOP account activated. Please proceed to <a href="%s/"><b>main</b></a> page.',
'sysop_activated' => 'SYSOP account is activated',
'account_activated' => 'Account activated',
'this_account_activated' => 'This account is activated. Please proceed <a href="/index.php">here</a>.',
'account_confirmed' => 'Account confirmed',
'account_confirmed_desc' => 'Please proceed to <a href="%s/"><b>main</b></a> page.',


////contact form
'c_name' => 'Name',
'c_email' => 'Email',
'c_subject' => 'Subject',
'c_message' => 'Message',
'c_req' => 'Denotes a required field',
'c_send_message' => 'Send Message',

'c_need_name' => 'Please enter your name',
'c_name_min_char' => 'Your name needs to be at least',
'c_char' => 'characters',
'c_valid_email' => 'Please enter a valid email address',
'c_need_subject' => 'You need to enter a subject!',
'c_min_char' => 'Enter at least',
'c_need_message' => 'You need to enter a message',
'c_error_all' => 'Please check if you have filled all the fields with valid information and try again. Thank you.',
'c_mail_sent' => 'Email Successfully Sent!',
'c_thank_you' => 'Thank you for using our contact form! Your email was successfully sent and we will be in touch with you soon.',


////global
't_comments' => 'Comments',
'error' => 'Error!',
'success' => 'Success!',
'add' => 'Add',
'update' => 'Update',
'access_denied' => 'Access denied.',
'class_moderator' => 'Moderator',
'class_sysop' => 'SYSOP',
'class_uploader' => 'VIP',
'class_user' => 'Leecher',
'admin_cheat' => 'Not existing staff account detected!',

		);
	}

    public function offsetSet($offset, $value) {
        $this->tlr[$offset] = $value;
    }
    public function offsetExists($offset) {
        return isset($this->tlr[$offset]);
    }
    public function offsetUnset($offset) {
        unset($this->tlr[$offset]);
    }
    public function offsetGet($offset) {
        return isset($this->tlr[$offset]) ? $this->tlr[$offset] : 'NO_LANG_'.strtoupper($offset);
    }
}

$tracker_lang = new lang;


?>