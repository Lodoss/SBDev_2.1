<?
if (!defined('UC_SYSOP'))
die('Direct access denied.');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?= $title ?></title>
<meta name="description" content="<?=$tracker_lang['header_desc'];?>" />
<meta name="keywords" content="<?=$tracker_lang['header_keywords'];?>" />
<meta name="generator" content="SBDev v2.1 (http://seedbay.net)" />
<link rel="stylesheet" href="<?=$DEFAULTBASEURL?>/themes/<?=$ss_uri?>/style.css" type="text/css">
<link href="<?=$DEFAULTBASEURL?>/facebox/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="<?=$DEFAULTBASEURL?>/js/litetabs.jquery.js"></script>
<script language="javascript" type="text/javascript" src="<?=$DEFAULTBASEURL?>/js/tooltips.js"></script>
<script src="<?=$DEFAULTBASEURL?>/facebox/facebox.js" type="text/javascript"></script> 
<script src="<?=$DEFAULTBASEURL?>/js/jquery.ae.image.resize.min.js"></script>
<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.pack.js" type="text/javascript"></script>


  <script type="text/javascript">
  
  /// this for main menu
$(function(){
		$('#topmenu li.sublnk').hover(
		function() {
			$(this).addClass("selected");
			$(this).find('ul').stop(true, true);
			$(this).find('ul').show('fast');
		},
		function() {
			$(this).find('ul').hide('fast');
			$(this).removeClass("selected");
		}
	);
	
	  	//// this for image resizing
  $( ".linked-image" ).aeImageResize({ height: 600, width: 600 });  
  

	  	////zebra table
  $(".browse:odd").addClass("odd");	

	
});



  /// this for image and ajax box
	    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loading_image : 'loading.gif',
        close_image   : 'closelabel.gif'
      })
      });


  </script>



</head>

<body>



<div class="headerwidth">


	<div class="mbar" id="menubar"><div class="mbar"><div class="mbar dpad">
		<div class="menubar">

			
<ul id="topmenu" class="lcol reset">
	<li><a href="<?=$DEFAULTBASEURL?>"><b><?=$tracker_lang['homepage'];?></b></a></li>
	<li><a href="<?=$DEFAULTBASEURL?>/browse.php"><b><?=$tracker_lang['search'];?></b></a></li>
	<li class="sublnk"><a href="#"><b><?=$tracker_lang['cats'];?></b></a>
		<ul>
		
			<?
		
		

$cats = genrelist();
foreach ($cats as $row)
	echo "<li><a href=\"$DEFAULTBASEURL/browse.php?cat=" . $row["id"] . "\"><b>" . htmlspecialchars($row["name"]) . "</b></a></li>";

	
		
		?>
			
		</ul>
	</li>
	
	<?
	
	if ($CURUSER) {
	
	echo "<li><a href=\"" . $DEFAULTBASEURL . "/add.php\"><b>" . $tracker_lang['upload'] . "</b></a></li>";
	
	}
	
	?>
	<li><a href="<?=$DEFAULTBASEURL?>/comments.php"><b><?=$tracker_lang['comments'];?></b></a></li>

</ul>
			
			
<a class="thide hrss" href="/rss.php" title="RSS">RSS</a>			
			
		</div>
	</div></div></div>




<div class="logo" style="float: left; width: auto;"><a href="<?=$DEFAULTBASEURL?>"><img src="<?=$DEFAULTBASEURL?>/themes/<?=$ss_uri?>/images/logo.png"></a></div>


<div align="right" class="smlmenu">
		
<?


$lang = "<a href='$DEFAULTBASEURL/?lang=ru'><img src=\"$DEFAULTBASEURL/themes/$ss_uri/images/RU0.gif\" title='Russian'></a> <a href='$DEFAULTBASEURL/?lang=en'><img src=\"$DEFAULTBASEURL/themes/$ss_uri/images/GB0.gif\" title='English'></a>";


if ($CURUSER) {
echo "<nobr>".$CURUSER['username']."".get_user_icons($CURUSER)." <a href=\"$DEFAULTBASEURL/logout.php\"><img src=\"$DEFAULTBASEURL/themes/$ss_uri/images/logout.png\" width=\"11\" height=\"11\" title=\"" . $tracker_lang['logout'] . "\"></a> | <a href=\"$DEFAULTBASEURL/my.php\">" . $tracker_lang['profile'] . "</a> | <a href=\"$DEFAULTBASEURL/browse.php?user=$CURUSER[id]\">" . $tracker_lang['my_torrents'] . "</a> " . $lang . "</nobr>";
} else {
echo "<nobr><a href=\"$DEFAULTBASEURL/login.php\">" . $tracker_lang['login'] . "</a> | <a href=\"$DEFAULTBASEURL/signup.php\">" . $tracker_lang['signup'] . "</a> | <a href=\"$DEFAULTBASEURL/recover.php\">" . $tracker_lang['recover_btn'] . "</a> " . $lang . "</nobr>";
}
?>

</div>


			</div>



<div id="mainbox">
  
  
  
<div class="main_frame">  
  

<?



if (get_user_class() >= UC_MODERATOR) {
$count = get_row_count("torrents", "WHERE modded='no'");
if ($count && get_user_class() >= UC_MODERATOR)
{		
		echo "<div class='error'>" . sprintf($tracker_lang["need_modded"], $count) . "</div>";
		echo "<div class='spacer'></div>";
}
}
?>
