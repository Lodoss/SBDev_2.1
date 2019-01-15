<?php
# IMPORTANT: Do not edit below unless you know what you are doing!
if(!defined('IN_TRACKER'))
  die('Hacking attempt!');

function textbbcode($form, $name, $text='') {
global $DEFAULTBASEURL;
?>
<table border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="clear">
<script type=text/javascript>
var text_enter_url       = "Введите полный URL ссылки";
var text_enter_page      = "Введите номер страницы";
var text_enter_url_name  = "Введите название сайта";
var text_enter_page_name = "Введите описание ссылки";
var text_enter_image    = "Введите полный URL изображения";
var text_enter_email    = "Введите e-mail адрес";
var text_code           = "Использование: [code] Здесь Ваш код.. [/code]";
var text_quote          = "Использование: [quote] Здесь Ваша Цитата.. [/quote]";
var error_no_url        = "Вы должны ввести URL";
var error_no_title      = "Вы должны ввести название";
var error_no_email      = "Вы должны ввести e-mail адрес";
var prompt_start        = "Введите текст для форматирования";
var img_title           = "Введите по какому краю выравнивать картинку (left, center, right)";
var email_title          = "Введите описание ссылки (необязательно)";
var text_pages          = "Страница";
var image_align          = "left";

var selField  = "<?= $name ?>";
var fombj    = document.getElementById( '<?= $form ?>' );

function smiley ( text ){
    doInsert(' ' + text + ' ', '', false);

    document.getElementById('dle_emo').style.visibility = "hidden";
    document.getElementById('dle_emo').style.display    = "none";
    ie_range_cache = null;
}
</script>
<script type="text/javascript" src="<?=$DEFAULTBASEURL?>/js/bbcodes.js"></script>
<div style="width:544px; height:25px; border:1px solid #BBB; background-image:url('<?=$DEFAULTBASEURL?>/pic/bbcodes/bg.gif')">
<div id="b_b" class="editor_button" onclick="simpletag('b')"><img title="Полужирный" src="<?=$DEFAULTBASEURL?>/pic/bbcodes/b.gif" width="23" height="25" border="0"></div>
<div id="b_i" class="editor_button" onclick="simpletag('i')"><img title="Наклонный текст" src="<?=$DEFAULTBASEURL?>/pic/bbcodes/i.gif" width="23" height="25" border="0"></div>
<div id="b_u" class="editor_button" onclick="simpletag('u')"><img title="Подчеркнутый текст" src="<?=$DEFAULTBASEURL?>/pic/bbcodes/u.gif" width="23" height="25" border="0"></div>
<div id="b_s" class="editor_button" onclick="simpletag('s')"><img title="Зачеркнутый текст" src="<?=$DEFAULTBASEURL?>/pic/bbcodes/s.gif" width="23" height="25" border="0"></div>
<div class="editor_button"><img src="<?=$DEFAULTBASEURL?>/pic/bbcodes/brkspace.gif" width="5" height="25" border="0"></div>

<div id="b_left" class="editor_button" onclick="simpletag('left')"><img title="Выравнивание по левому краю" src="<?=$DEFAULTBASEURL?>/pic/bbcodes/l.gif" width="23" height="25" border="0"></div>
<div id="b_center" class="editor_button" onclick="simpletag('center')"><img title="По центру" src="<?=$DEFAULTBASEURL?>/pic/bbcodes/c.gif" width="23" height="25" border="0"></div>
<div id="b_right"class="editor_button" onclick="simpletag('right')"><img title="Выравнивание по правому краю" src="<?=$DEFAULTBASEURL?>/pic/bbcodes/r.gif" width="23" height="25" border="0"></div>
<div class="editor_button"><img src="<?=$DEFAULTBASEURL?>/pic/bbcodes/brkspace.gif" width="5" height="25" border="0"></div>
<div class="editor_button"  onclick="tag_url()"><img title="Вставка ссылки" src="<?=$DEFAULTBASEURL?>/pic/bbcodes/link.gif" width="23" height="25" border="0"></div>
<div class="editor_button"  onclick="tag_email()"><img title="Вставка E-Mail" src="<?=$DEFAULTBASEURL?>/pic/bbcodes/email.gif" width="23" height="25" border="0"></div>
<div id="b_color" class="editor_button" onclick="ins_color();"><img src="<?=$DEFAULTBASEURL?>/pic/bbcodes/color.gif" width="23" height="25" border="0"></div>
<div class="editor_button"><img src="<?=$DEFAULTBASEURL?>/pic/bbcodes/brkspace.gif" width="5" height="25" border="0"></div>
<div id="b_quote" class="editor_button" onclick="simpletag('quote')"><img title="Вставка цитаты" src="<?=$DEFAULTBASEURL?>/pic/bbcodes/quote.gif" width="23" height="25" border="0"></div>
<div class="editbclose" onclick="closeall()"><img title="Закрыть все открытые теги" src="<?=$DEFAULTBASEURL?>/pic/bbcodes/close.gif" width="23" height="25" border="0"></div>
</div>
<iframe width="154" height="104" id="cp" src="<?=$DEFAULTBASEURL?>/pic/bbcodes/color.html" frameborder="0" vspace="0" hspace="0" marginwidth="0" marginheight="0" scrolling="no" style="visibility:hidden; display: none; position: absolute;"></iframe>
</tr>
<tr>
<td class="clear"><textarea name="<?= $name ?>" id="<?= $name ?>" class="f_textarea" onclick="setNewField(this.name, document.getElementById( '<?= $form ?>' ))" /><?=$text;?></textarea>
</td>
</tr>
</table>
<?
}

?>
