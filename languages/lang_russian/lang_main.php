<?php

class lang implements arrayaccess {
	private $tlr = array();
	public function __construct() {
		$this->tlr = array(

'language_charset' => 'utf-8',

////header info
'header_desc' => 'Международный торрент трекер. Торренты без регистраций и рейтинга.',
'header_keywords' => 'торренты, скачать, без регистраций, без рейтинга, фильмы, музыка, клипы, программы, книги, аниме, игры, мультфильмы, тв передачи',


////main menu (stdheader.php)
'homepage' => 'Главная',
'browse' => 'Торренты',
'cats' => 'Категорий',
'upload' => 'Загрузить',
'comments' => 'Комментарии',
'contact' => 'Контакты',
'forum' => 'Форум',


////user small menu
'login' => 'Вход',
'signup' => 'Регистрация',
'logout' => 'Выход',
'profile' => 'Профиль',
'my_torrents' => 'Мои торренты',


////search box
'search_holder' => 'Поиск торрентов',
'in' => 'в',
'all_types' => 'Все типы',
'search' => 'Поиск',

't_lang' => 'Язык',
'russian' => 'Русский',
'latvian' => 'Латышский',
'english' => 'Английский',
'lang_other' => 'Другой',
'choose_lang' => 'Выбрать',

////moderator message (torrents that need to bee checked)
'need_modded' => 'Добавлено [<b>%d</b> торрентов которые нужно <a href="/browse.php?modded=1"><b>проверить</b></a>',


////footer
'page_generated' => 'Сгенерировано за %f секунд с %d запросами',
'stats' => '%d пиров (%d сидеров + %d личеров) на %d торрентов',


////main page (index.php)
'torrents_in_24h' => 'Топ торренты за последние 24 часа',
'no_torrents_in_24h' => 'За последние 24 часа не было загружено ни одного торрента!',


////browse page (browse.php)
't_browse' => 'Список торрентов',
'search_results_for' => 'Результаты поиска для',
'search_results_tags' => 'Результат поиска по тегу:',
'search_results_user' => 'Торренты пользователя:',
'need_mod' => 'Не проверен',
'sort' => 'Сортировать:',
's_name' => 'Название',
's_date' => 'Дата',
's_comments' => 'Комментарии',
's_seeders' => 'Раздают',
's_leechers' => 'Качают',
'nothing_found' => 'Ничего не найдено',


////details page (details.php)
'invalid_id' => 'Неверный идентификатор.',
'not_modded' => 'Раздача ожидает проверки',
'show_xxx' => 'Вы не зарегистрирован на сайте чтобы просматривать ХХХ раздел либо вы при регистрации указали что не желаете просматривать ХХХ раздел!',
'annonym' => 'Аноним',
'uploader' => 'Автор',
'category' => 'Категория',
'size' => 'Размер',
'tracker_leechers' => 'Качают',
'tracker_seeders' => 'Раздают',
'snatched' => 'Скачан',
'download' => 'Скачать',
'tags' => 'Теги',
'screens' => 'Скриншоты',
'trailer' => 'Трейлер',
'add_comment' => 'Добавить коммент.',
'edited_by' => 'Последний раз редактировал',
'comments_disable' => 'Вам заблокировали комментарии!',
'comment_cant_be_empty' => 'Комментарий не может быть пустым!',
'you_want_to_delete_x_click_here' => 'Вы хотите удалить %s. Нажмите <a href="%s">сюда</a> если вы уверены.',
'delete' => 'Удалить',
'comment' => 'комментарий',
'your_comment_was_last' => 'Ваш комментарий был последний',
'to_change_comment_click' => 'Для изменения комментария воспользуйтесь ссылкой',
'btn_edit_comment' => 'Изменить',
'edit_comment_for' => 'Редактирование комментария к',
'comments_flood' => 'Больше чем <b>%d</b> комментариев за последние <b>%d</b> минут запрещены!',


////account page (my.php)
'my_my' => 'Панель управления',
'my_updated' => 'Профиль обновлён!',
'my_mail_sent' => 'Подтверждающее письмо отппавлено!',
'my_mail_updated' => 'E-mail адрес обновлен!',
'my_mail' => 'Email',
'my_old_pass' => 'Старый пароль',
'my_new_pass' => 'Новый пароль',
'my_new_pass_again' => 'Новый пароль еще раз',
'my_xxx_torrents' => 'XXX торренты',
'my_xxx_descr' => 'Отоброжать торренты для взрослых?',
'my_mail_update_descr' => '<b>Примечание:</b> Если вы смените ваш Email адрес, то вам придет запрос о подтверждении на ваш новый Email-адрес. Если вы не подтвердите письмо, то Email адрес не будет изменен.',
'my_pass_too_long' => 'Извините, ваш пароль слишком длинный (максимум 40 символов)',
'my_pass_not_match' => 'Пароли не совпадают. Попробуйте еще раз.',
'my_old_pass_error' => 'Вы ввели неправильный старый пароль.',
'my_invalid_mail' => 'Это не похоже на настоящий E-Mail.',
'my_allready_in_use' => 'Этот e-mail адрес уже используется одним из пользователей трекера.',


////upload and edit page (add.php and edit.php)
'upload_torrent' => 'Загрузить торрент',
'add_user_class_notif' => '<b>Так как ваш класс ниже аплоудера то ваш данный торрент не будет виден в списке торрентов и не будет доступен к скачиванию пока его не проверит один из модераторов сайта!</b>',
'add_announce_url' => 'Наш announce',
'torrent_file' => 'Torrent файл',
'torrent_name' => 'Название',
'torrent_poster' => 'Постер',
'torrent_poster_descr' => 'Ссылка на постер',
'type' => 'Тип',
'choose_cat' => 'Выбрать',
'torrent_trailer' => 'Трейлер / Сэмпл',
'torrent_trailer_desc' => 'Ссылка с youtube.com',
'torrent_screens' => 'Скриншоты',
'torrent_screens_desc' => 'Ссылка на скриншот нр.',
'torrent_tags' => 'Тэги',
'torrent_tags_descr' => 'Пример: тег1, тег2, тег3',
'torrent_external' => 'Мультираздача',
'torrent_external_desc' => 'Торрент является мультитрекерным?',
'torrent_annonym' => 'Аноним',
'torrent_annonym_desc' => 'Спрятать мой ник в списке торрентов?',
'torrent_upload' => 'Загрузить',
'torrent_upload_failed' => 'Файл не загружен. Пустое имя файла!',
'torrent_need_desc' => 'Вы должны ввести описание!',
'torrent_need_cat' => 'Вы должны выбрать категорию, в которую поместить торрент!',
'torrent_invalid_filename' => 'Неверное имя файла!',
'torrent_not_torrent' => 'Неверное имя файла (не .torrent).',
'torrent_empty_file' => 'Пустой файл!',
'torrent_not_binary' => 'Что за хрень ты загружаешь? Это не бинарно-кодированый файл!',
'torrent_edit' => 'Редактирование торрента',
'torrent_cant_edit' => 'Вы не можете редактировать этот торрент.',
'torrent_modded' => 'Проверенный',
'torrent_modded_desc' => 'Проверен модератором?',
'torrent_edit_btn' => 'Отредактровать',
'torrent_delete_btn' => 'Удалить',
'torrent_add_tname' => 'Введите название торрента',
'torrent' => 'торрент',
'torrent_sticky' => 'Важный',
'torrent_sticky_desc' => 'Прикрепить торрент на главной странице?',


////login and signup and recover pages
'authorization' => 'Авторизация',
'signup_username' => 'Пользователь',
'signup_username_desc' => 'Впишите ваш логин',
'signup_password' => 'Пароль',
'signup_password_desc' => 'Впишите ваш пароль',
'login_btn' => 'Вход',
'signup_password_again' => 'Повторите пароль',
'signup_password_again_desc' => 'Впишите ваш пароль повторно',
'signup_email' => 'Email',
'signup_email_desc' => 'Впишите ваш email',
'signup_btn' => 'Регистрация',
'recover_btn' => 'Восстановить',
'recover_email_desc' => 'Впишите ваш зарегистрированный email',
'login_failed' => 'Вход не удался!',
'account_pennding' => 'Вы еще не активировали свой аккаунт! Активируйте ваш аккаунт и попробуйте снова.',
'account_banned' => 'Этот аккаунт отключен.',
'login_failed_desc' => 'Имя пользователя или пароль не верны! Если вы забыли пароль тогда попробуйте <a href="/login.php">восстановить</a>.',
'login_banned' => 'Вход заблокирован!',
'login_banned_desc' => 'Вы исчерпали <b>4</b> попыток входа, теперь ваш IP адрес забанен',
'signup_disabled' => 'Извините, но регистрация отключена администрацией.',
'signup_users_limit' => 'Текущщий лимит пользователей (%d) достигнут. Неактивные пользователи постоянно удаляются, пожалуста вернитесь попозжее...',
'signup_already_registered' => 'Вы уже зарегистрированый пользователь %s!',
'signup_direct_access' => 'Прямой доступ к этому файлу не разрешен.',
'signup_all_fields' => 'Все поля обязательны для заполнения.',
'username_too_long' => 'Извините, имя пользователя слишком длинное (максимум 12 символов)',
'password_mismatch' => 'Пароли не совпадают.',
'password_too_short' => 'Извините, пароль слишком коротки (минимум 6 символов)',
'password_too_long' => 'Извините, пароль слишком длинный (максимум 40 символов)',
'password_cant_be_as_username' => 'Извините, пароль не может быть такой-же как имя пользователя.',
'invalid_email' => 'Это не похоже на реальный email адрес.',
'invalid_username' => 'Неверное имя пользователя.',
'email_allready_registered' => 'E-mail адрес %s уже зарегистрирован в системе.',
'your_ip_banned' => 'Ваш IP забанен на этом трекере. Регистрация невозможна.',
'unable_to_signup' => 'Регистрация невозможна!',
'username_allready_taken' => 'Пользователь %s уже зарегистрирован!',
'recover_unable_s_mail' => 'Невозможно отправить E-mail. Пожалуста сообщите администрации об ошибке.',
'recover_mail_sent' => 'Новые данные по аккаунту отправлены на E-Mail <b>%s</b>. Через несколько минут (обычно сразу) вы получите ваши новые данные.',
'recover_email_missing' => 'Вы должны ввести email адрес',
'recover_cat_find_email' => 'Email адрес не найден в базе данных',
'recover_mysql_error' => 'Ошибка базы данных. Свяжитесь с администратором относительно этой ошибки.',
'recover_first_mail_sent' => 'Подтверждающее письмо было отправлено на E-Mail <b>%s</b>. Через несколько минут (обычно сразу) вам прийдет письмо с дальнейшими указаниями.',
'recover_cant_update' => 'Невозможно обновить данные пользователя. Пожалуста свяжитесь с администратором относительно этой ошибки.',
'signup_successful' => 'Успешная регистрация',
'confirmation_mail_sent' => 'Подтверждающее письмо отправлено на указаный вами адрес (%s). Вам необходимо прочитать и отреагировать на письмо прежде чем вы сможете использовать ваш аккаунт. Если вы этого не сделаете, новый аккаунт будет автоматически удален через несколько дней.',
'thanks_for_registering' => 'Спасибо что зарегистрировались на %s! Теперь вы можете <a href="/my.php">войти</a> в систему.',
'sysop_account_activated' => 'Ваш аккаунт активирован! Вы автоматически вошли. Теперь вы можете <a href="%s/"><b>перейти на главную</b></a> и начать использовать ваш уккаунт.',
'sysop_activated' => 'Аккаунт администратора успешно активирован',
'account_activated' => 'Аккаунт активирован',
'this_account_activated' => 'Этот аккаунт уже активирован. Вы можете <a href="/index.php">войти</a> с ним.',
'account_confirmed' => 'Ваш аккаунт успешно подтвержден',
'account_confirmed_desc' => 'Ваш аккаунт теперь активирован! Вы автоматически вошли. Теперь вы можете перейти на главную и начать использовать ваш уккаунт.',



////contact form
'c_name' => 'Имя',
'c_email' => 'Email',
'c_subject' => 'Заголовок',
'c_message' => 'Сообщение',
'c_req' => 'Все поля обязательны',
'c_send_message' => 'Отправить',
'c_need_name' => 'Введите ваше имя',
'c_name_min_char' => 'Ваше имя должно бить хотя бы',
'c_char' => 'символов',
'c_valid_email' => 'Введите существующий email',
'c_need_subject' => 'Введите заголовок !',
'c_min_char' => 'Минимум',
'c_need_message' => 'Введите сообщение',
'c_error_all' => 'Проверти ли все поля заполнены с правильной информацией.',
'c_mail_sent' => 'Сообщение отправлено!',
'c_thank_you' => 'Ваше сообщение было успешно отправлено. Мы свяжемся с вами в ближайшие время.',

////global
't_comments' => 'Комментарии',
'error' => 'Ошибка',
'success' => 'Успешно',
'add' => 'Добавить',
'update' => 'Обновить',
'access_denied' => 'Доступ запрещен.',
'class_moderator' => 'Модератор',
'class_sysop' => 'SYSOP',
'class_uploader' => 'VIP',
'class_user' => 'Личер',
'admin_cheat' => 'Наша система безопасности решила что вы используете несуществующий админ аккаунт!',

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