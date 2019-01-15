<?
require_once("include/bittorrent.php");
require_once("include/torr_langs.php");
require_once("include/editor.php");


dbconn(false);
loggedinorreturn();
maxsysop();




//////////torrent language selector
$torr_lang = "<select name=\"lang\"><option value=\"0\">(" . $tracker_lang['choose_lang'] . ")</option>";
	foreach ($torrent_lang as $id => $name)
		$torr_lang .= "<option value=\"$id\">$name</option>";
$torr_lang .= "</select>";
//////////torrent language selector



stdhead($tracker_lang['upload_torrent']);
?>
<form name="upload" id="upload" enctype="multipart/form-data" action="<?=$DEFAULTBASEURL?>/takeupload.php" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="<?=$max_torrent_size?>" />

<? if (get_user_class() < UC_UPLOADER) { ?>
<div class="error" align="center">
<?=$tracker_lang['add_user_class_notif'];?>
</div>
<div class="spacer"></div>

<?
}




echo "<table width=\"100%\" class=\"bordered\">";


echo "<thead><tr>";

echo "<th colspan='2'>";

echo "<center><b>" . $tracker_lang['add_announce_url'] . " ". $DEFAULTBASEURL . ":2710/announce</b></center>";

echo "</th>";

echo "</tr></thead>";





echo "<tr><td class='rowhead'>" .$tracker_lang['torrent_file'] . "</td><td><input type='file' name='file' size='70'></td></tr>";
//tr($tracker_lang['torrent_file'], "<input type=file name=file size=70>\n", 1);


echo "<tr><td class='rowhead'>" .$tracker_lang['torrent_name'] . "</td><td><input type=\"text\" name=\"name\" size=\"80\" /></td></tr>";
//tr($tracker_lang['torrent_name'], "<input type=\"text\" name=\"name\" size=\"80\" />\n", 1);


echo "<tr><td class='rowhead'>" . $tracker_lang['torrent_poster'] . "</td><td><input type=text name=poster size=80 placeholder='" . $tracker_lang['torrent_poster_descr'] . "'></td></tr>";
//tr("Постер", "<input type=text name=poster size=80><br><span class='small'>(Сюда вставляем ссылку на картинку (постер))</span>", 1);


echo "<tr><td colspan='2' align='center'>";
textbbcode("upload","descr");
echo "</td></tr>";


echo "<tr><td class='rowhead'>" . $tracker_lang['t_lang'] . "</td><td>" . $torr_lang . "</td></tr>";


$k = "<select name=\"type\">\n<option value=\"0\">(" . $tracker_lang['choose_cat'] . ")</option>\n";

$cats = genrelist();
foreach ($cats as $row)
	$k .= "<option value=\"" . $row["id"] . "\">" . htmlspecialchars($row["name"]) . "</option>\n";

$k .= "</select>\n";

echo "<tr><td class='rowhead'>" . $tracker_lang['type'] . "</td><td>" . $k . "</td></tr>";
//tr($tracker_lang['type'], $k, 1);


echo "<tr><td class='rowhead'>" . $tracker_lang['torrent_trailer'] . "</td><td><input type=\"text\" name=\"tube\" size=\"80\" placeholder='" . $tracker_lang['torrent_trailer_desc'] . "' /></td></tr>";
//tr("Трейлер / Сэмпл", "<input type=\"text\" name=\"tube\" size=\"80\" /><br><span class='small'>Ссылка с youtube.com</span>", 1);


echo "<tr><td class='rowhead'>" . $tracker_lang['torrent_screens'] . "</td><td><input type=\"text\" name=\"screenshot1\" size=\"80\" placeholder='" . $tracker_lang['torrent_screens_desc'] . " 1' /><div class='spacer'></div><input type=\"text\" name=\"screenshot2\" size=\"80\" placeholder='" . $tracker_lang['torrent_screens_desc'] . " 2' /><div class='spacer'></div><input type=\"text\" name=\"screenshot3\" size=\"80\" placeholder='" . $tracker_lang['torrent_screens_desc'] . " 3' /><div class='spacer'></div><input type=\"text\" name=\"screenshot4\" size=\"80\" placeholder='" . $tracker_lang['torrent_screens_desc'] . " 4' /></td></tr>";
//tr("Скриншоты", "<span class='small'>Ссылка на скриншот нр.1</span><br><input type=\"text\" name=\"screenshot1\" size=\"80\" /><br><span class='small'>Ссылка на скриншот нр.2</span><br><input type=\"text\" name=\"screenshot2\" size=\"80\" /><br><span class='small'>Ссылка на скриншот нр.3</span><br><input type=\"text\" name=\"screenshot3\" size=\"80\" /><br><span class='small'>Ссылка на скриншот нр.4</span><br><input type=\"text\" name=\"screenshot4\" size=\"80\" />", 1);

      
echo "<tr><td class='rowhead'>" . $tracker_lang['torrent_tags'] . "</td><td><input type=\"text\" id=\"tags\" name=\"tags\" size=\"80\" placeholder='" . $tracker_lang['torrent_tags_descr'] . "'></td></tr>";


echo "<tr><td class='rowhead'>" . $tracker_lang['torrent_external'] . "</td><td><input type=checkbox name=scrape value=yes>" . $tracker_lang['torrent_external_desc'] . "</td></tr>";
//tr("Мультираздача", "<input type=checkbox name=scrape value=yes>Торрент является мультитрекерным?", 1);

echo "<tr><td class='rowhead'>" . $tracker_lang['torrent_annonym'] . "</td><td><input type=checkbox name=uplver value=yes>" . $tracker_lang['torrent_annonym_desc'] . "</td></tr>";
//tr("Аноним", "<input type=checkbox name=uplver value=yes>Спрятать мой ник в списке торрентов?", 1);


?>
</table>

<div class="spacer"></div>

<div align="center"><input type="submit" class=btn value="<?=$tracker_lang['torrent_upload'];?>" /></div>

</form>
<?

stdfoot();

?>
