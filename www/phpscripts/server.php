<?php
//т.к. я заебался просто так блуждать в коде каждой страницы, выношу серверную логику сюда, и постараюсь снабдить ее комментами
session_start();//тут все понятно)
$location = parse_url($_SERVER['REQUEST_URI']);
$justLocation = ltrim( $location['path'], '/');
if ($justLocation == '') {
    $justLocation = 'index';
    if ($_GET['id'] != '') {
        header('location: /');
    }
}
if ($location['query'] != '') {
    $qu = '?'.$location['query'];
}
if ($location['fragment'] != '') {
    $ht = '#'.$location['fragment'];
}
if ($location['path'] != '/') {
    $location = $location['path'].$qu.$ht;
}
else {
    $location = '/index';
}
//для БД всякая хня.
$host = 'mysql.hostinger.ru';
$log = 'u523996525_qalt';
$pas = 'starwars';
$base = 'u523996525_data';
//подключаемся к базе
mysql_connect($host, $log, $pas);
mysql_select_db($base);
//время на сервере на 9 часов отстает от москвы, это не круто
$hoursDiff = 4;
$nowDate = date('Y-m-d', time() + $hoursDiff*3600);
$nowMonth = date('m', time() + $hoursDiff*3600);
$nowTime =date('H:i', time() + $hoursDiff*3600);
$nowDateTime = date('Y-m-d H:i:s', time() + $hoursDiff*3600);
//проверяем, не пора ли определить победителей, довольно говнокодистый кусок, но работает
$checkEvent = mysql_query("SELECT * FROM events WHERE event_end < '$nowDate' AND event_close = '0'");
function selectWinner($select_users_array, $real_winners_array, $hoursDiff) {
    $randomLength = rand(0, count($select_users_array)-1);
    $user_id = $select_users_array[$randomLength];
    if (checkUser($user_id, $real_winners_array, $hoursDiff)) {
        return $user_id;
    }
    else {
        return selectWinner($select_users_array, $real_winners_array, $hoursDiff);
    }
}
function checkUser($check_user_id, $check_winners_array, $hoursDiff) {
    $user_winner = true;
    $checkOldWin = mysql_query("SELECT * FROM winners WHERE user_id = '$check_user_id'");
    if (mysql_num_rows($checkOldWin)) {
        $oldWin_info = mysql_fetch_assoc($checkOldWin);
        $nowDateMinisMonth = date('Y-m-d', time() + $hoursDiff*3600-(31*24*3600));
        if ($oldWin_info['winner_date'] > $nowDateMinisMonth) {
            $user_winner = false;
        }
    }
    if (count($check_winners_array) != 0) {
        for ($i=0; $i<count($check_winners_array); $i+=1) {
            if ($check_winners_array[$i] == $check_user_id) {
                $user_winner = false;
            }
        }
    }
    return $user_winner;
}
if (mysql_num_rows($checkEvent)) {
    $winners_array = array();
    while ($event_info = mysql_fetch_assoc($checkEvent)) {
        $event_id = $event_info['event_id'];
        $users_array = array();
        $checkRequests = mysql_query("SELECT user_id FROM requests WHERE event_id = '$event_id'");
        if (mysql_num_rows($checkRequests)) {
            while ($request_info = mysql_fetch_assoc($checkRequests)) {
                $user_id = $request_info['user_id'];
                $checkUser = mysql_query("SELECT * FROM users WHERE user_id = '$user_id'");
                if (mysql_num_rows($checkUser)) {
                    $user_info = mysql_fetch_assoc($checkUser);
                    $user_length = $user_info['user_rank']*10;
                    for ($i=0; $i<$user_length; $i+=1) {
                        $users_array[] = $user_info['user_id'];
                    }
                }
            }
            shuffle($users_array);
            $winner_answer = selectWinner($users_array, $winners_array, $nowMonth);
            $winners_array[] = $winner_answer;
            $winners_array[] = $event_id;
        }
    }
    for ($i=0; $i<count($winners_array); $i+=2) {
        $user_id = $winners_array[$i];
        $event_id = $winners_array[$i+1];
        $checkUser = mysql_query("SELECT * FROM users WHERE user_id = '$user_id'");
        if (mysql_num_rows($checkUser)) {
            mysql_query("INSERT into winners values (0, '$event_id',  '$user_id', '$nowDate')");
            mysql_query("UPDATE events SET event_close = '1' WHERE event_id = '$event_id'");
            $datetime1 = date_create('2013-09-01');
            $datetime2 = date_create($nowDate);
            $interval = date_diff($datetime1, $datetime2);
            $interval = 1+$interval->format('%m');
            $checkEvent = mysql_query("SELECT * FROM events WHERE event_id = '$event_id'");
            $event_info = mysql_fetch_assoc($checkEvent);
            if ($event_info['event_type'] == '1') {
                $event_type = 'основном розыгрыше ';
            }
            else {
                $event_type = 'дополнительном розыгрыше ';
            }
            $achievement_text = 'Победа в '.$event_type.'"'.$event_info['event_name'].'"!';
            mysql_query("INSERT into achievements values (0, '$interval',  '$achievement_text', '', '$user_id')");
        }
    }
}
else {
    if (date('d', time() + $hoursDiff*3600) == '1') {
        mysql_query("UPDATE users SET user_rank='1'");
        $checkUsers = mysql_query("SELECT * FROM users WHERE user_status = '1' AND user_login != '0000-00-00 00:00:00'");
        if (mysql_num_rows($checkUsers)) {
            while ($row = mysql_fetch_assoc($checkUsers)) {
                $user_date = date_create($row['user_login']);
                $user_date = date_format($user_date, 'Y-m-d');
                if ($user_date == $nowDate) {
                    if ($row['user_rank'] == '1') {
                        $user_id = $row['user_id'];
                        mysql_query("UPDATE users SET user_rank='1.1' WHERE user_id = '$user_id'");
                    }
                }
            }
        }
    }
}
//тут мы проверяем, что нам пришло POST запросом. Логины-разлогины-восстановление пароля, и тд
if (!empty($_POST)) {
    if (isset($_POST['logout'])) {
        unset($_SESSION['username']);
        unset($_SESSION['usermail']);
        session_destroy();
        header('location: '.$location);
        exit;
    }
    $secret = 'мидихлорианы';
    if ($_POST['login'] || $_POST['mail']) {
        if ($_POST['login']) {
            $user_password = $_POST['password'];
            $user_info = '';
            if (isset($_POST['login']) && isset($_POST['password'])) {
                $user_login = $_POST['login'];
                mysql_connect($host, $log, $pas);
                mysql_select_db($base);
                $checkUser = mysql_query("SELECT * FROM users WHERE user_mail = '$user_login'");
                if(mysql_fetch_assoc($checkUser)) {
                    $checkUser = mysql_query("SELECT * FROM users WHERE user_mail = '$user_login'");
                    $user_info = mysql_fetch_assoc($checkUser);
                    $user_password = $_POST['password'];
                    if (strcmp($user_password,$user_info['user_pass'])==0) {
                        $checkUser = mysql_query("SELECT * FROM users WHERE user_mail = '$user_login'");
                        $user_info=mysql_fetch_assoc($checkUser);
                        session_start();
                        $_SESSION['username'] = $user_info['user_name'];
                        $_SESSION['usermail'] = $user_info['user_mail'];
                        header('location: '.$location);
                        exit;
                    }
                    else {
                        $_SESSION['server_answer'] = '<input type="hidden" name="loginned" value="true">';
                        header('location: '.$location);
                        exit;
                    }
                }
                else {
                    $_SESSION['server_answer'] = '<input type="hidden" name="loginned" value="false">';
                    header('location: '.$location);
                    exit;
                }
            }
        }
        else {
            $user_mail = $_POST['mail'];
            $checkUser = mysql_query("SELECT * FROM users WHERE user_mail = '$user_mail'");
            if (mysql_num_rows($checkUser)) {
                $hash = md5($user_mail.rand());
                mysql_query("UPDATE users SET user_pass='$hash' WHERE user_mail = '$user_mail'");
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $headers .= 'From: noreply@free-cheese.com' . "\r\n";
                $mailTo = $user_mail;
                $subject = "Смена пароля";
                $message = 'Вы получили это письмо, т.к. Вы, либо кто-то другой, запросил восстановление пароля от Вашего аккаунта.<br>';
                $message .= 'Если это были не вы - свяжитесь с тех. поддержкой free-cheese.com <a href="mailto:support@free-cheese.com?subject=Чужая смена пароля">support@free-cheese.com</a><br>';
                $message .= 'А если это были вы, то Ваш новый пароль - <b>'.$hash.'</b> <br>Рекомендуем после входа сменить пароль в личном кабинете.';
                mail($mailTo,$subject,$message,$headers);
                $_SESSION['server_answer'] = '<input type="hidden" name="repass" value="true">';
                header('location: '.$location);
                exit;
            }
            else {
                $_SESSION['server_answer'] = '<input type="hidden" name="repass" value="false">';
                header('location: '.$location);
                exit;
            }
        }
    }
    if ($_POST['contentID']) {
        if (isset($_SESSION['usermail'])) {
            $user_mail = $_SESSION['usermail'];
            $checkUser = mysql_query("SELECT * FROM users WHERE user_mail = '$user_mail'");
            if (mysql_num_rows($checkUser)) {
                $user_info = mysql_fetch_assoc($checkUser);
                if ($user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2') {
                    $content_id = $_POST['contentID'];
                    $content_page = $_POST['contentPage'];
                    $content_text = $_POST['contentText'];
                    if ($content_page == 'oneNews' || $content_page == 'oneArticle' || $content_page == 'mainRaffle' || $content_page == 'oneRaffle') {
                        if ($content_page == 'oneNews') {
                            $content_table = 'news';
                            $content_table_text = $content_table.'_text';
                            $content_table_id = $content_table.'_id';
                        }
                        else if ($content_page == 'oneArticle') {
                            $content_table = 'article';
                            $content_table_text = $content_table.'_text';
                            $content_table_id = $content_table.'_id';
                            $content_table = $content_table.'s';
                        }
                        else {
                            $content_table = 'event';
                            $content_table_text = $content_table.'_text';
                            $content_table_id = $content_table.'_id';
                            $content_table = $content_table.'s';
                        }
                        $checkContent = mysql_query("SELECT * FROM $content_table WHERE $content_table_id = '$content_id'");
                        if (mysql_num_rows($checkContent)) {
                            mysql_query("UPDATE $content_table SET $content_table_text = '$content_text' WHERE $content_table_id = '$content_id'");
                            $_SESSION['server_answer'] = '<input type="hidden" name="rewrite" value="true">';
                            header('location: '.$location);
                            exit;
                        }
                    }
                    else {
                        $checkContent = mysql_query("SELECT * FROM contents WHERE content_id = '$content_id'");
                        if (mysql_num_rows($checkContent)) {
                            mysql_query("UPDATE contents SET content_text='$content_text' WHERE content_id = '$content_id'");
                            $_SESSION['server_answer'] = '<input type="hidden" name="rewrite" value="true">';
                            header('location: '.$location);
                            exit;
                        }
                    }
                }
            }
        }
    }
    if (isset($_POST['readingComment'])) {
        $reminder_id = $_POST['readingComment'];
        $checkSuccessReminder = mysql_query("SELECT * FROM reminders WHERE reminder_id = '$reminder_id'");
        if (mysql_num_rows($checkSuccessReminder)) {
            $success_reminder_info = mysql_fetch_assoc($checkSuccessReminder);
            $search_comment = $success_reminder_info['reminder_target'];
            $checkComment = mysql_query("SELECT * FROM comments WHERE comment_id = '$search_comment'");
            $success_comment_info = mysql_fetch_assoc($checkComment);
            if ($success_comment_info['comment_page_id'] != '0') {
                $comment_location = '/'.$success_comment_info['comment_page'].'?id='.$success_comment_info['comment_page_id'];
            }
            else {
                $comment_location = '/'.$success_comment_info['comment_page'];
            }
            mysql_query("UPDATE reminders SET reminder_success='1' WHERE reminder_id = '$reminder_id'");
            $_SESSION['commentPosition'] = '<input type="hidden" value="'.$search_comment.'" id="commentPosition">';
            header('location: '.$comment_location);
            exit();
        }
    }
}
//вот эта херня проверяет, подтвердил пользователь мыло или нет. если нет - ебет его напоминалками.
if (isset($_SESSION['usermail'])) {
    $user_login = $_SESSION['usermail'];
    $checkUser = mysql_query("SELECT * FROM users WHERE user_mail = '$user_login'");
    if (mysql_num_rows($checkUser)) {
        $user_info = mysql_fetch_assoc($checkUser);
        $user_id = $user_info['user_id'];
        $login_date = date_create($user_info['user_login']);
        $login_date = date_format($login_date, 'Y-m-d');
        if ($nowDate > $login_date && $user_info['user_status'] == 1) {
            $user_rank = $user_info['user_rank'] + 0.1;
            mysql_query("UPDATE users SET user_rank='$user_rank' WHERE user_id = '$user_id'");
            if ($user_info['user_privilege'] == 1) {
                require_once ('sitemap.php');
            }
        }
        mysql_query("UPDATE users SET user_login='$nowDateTime' WHERE user_id = '$user_id'");
        if ($user_info['user_status'] != '1') {
            $_SESSION['server_answer'] = '<input type="hidden" name="activated" value="false">';
        }
        else {
            if (isset($_GET['id'])) {
                $mayBeId = (int) $_GET['id'];
                $user_id = $user_info['user_id'];
                $checkRequest = mysql_query("SELECT * FROM requests WHERE user_id = '$user_id' AND event_id = '$mayBeId'");
                if (mysql_num_rows($checkRequest)) {
                    $buttonText = 'Отменить заявку...';
                }
                else {
                    $buttonText = 'Подать заявку!';
                }
            }
        }
    }
}
//тут проверяем комменты, надо ли кому-нить что-нить показать. понятия не имею, как это все будет работать!
$checkComments = mysql_query("SELECT * FROM comments WHERE comment_answer != '0'");
if (mysql_num_rows($checkComments)) {
    while ($oneComment = mysql_fetch_assoc($checkComments)) {
        $reminder_comment = $oneComment['comment_answer'];
        $reminder_target = $oneComment['comment_id'];
        $checkComment = mysql_query("SELECT * FROM comments WHERE comment_id = '$reminder_comment'");
        if (mysql_num_rows($checkComment)) {
            $comment_info = mysql_fetch_assoc($checkComment);
            $reminder_user = $comment_info['user_id'];
            $checkRemind = mysql_query("SELECT * FROM reminders WHERE reminder_target = '$reminder_target' AND reminder_user = '$reminder_user'");
            if (!mysql_num_rows($checkRemind)) {
                mysql_query("INSERT into reminders values (0, '$reminder_target', '$reminder_user', '0')");
            }
        }
    }
}
//а это просто чтоб кнопку победителей активировать, если уже кто-то выиграл. скоро выпилю, а кнопку прям в верстку заебашу
//заодно там поселилась раздача ачивок за победы. правильно она пашет или нет - хз, вроде да, но не факт
$checkWinners = mysql_query("SELECT * FROM winners ORDER BY winner_date DESC");
if (mysql_num_rows($checkWinners)) {
    $winners_button = '<a class="button" href="winners" style="color: lime">Победители</a>';
}
//тут я пишу код для автоматической раздачи ачивок всяких, ибо мне влом писать какое-то рещение для админки
$checkOldUsers = mysql_query("SELECT * FROM users WHERE user_status = '1' AND user_rank >= '2'");
if (mysql_num_rows($checkOldUsers)) {
    while ($row = mysql_fetch_assoc($checkOldUsers)) {
        $user_id = $row['user_id'];
        if ($row['user_rank'] >= 2 && $row['user_rank'] < 3) {
            $achievementNumber = '20';
            $achievement_text = 'Шанс победить уже в 2 раза выше! И это не предел!';
            $achievement_color = 'silver';
        }
        else if ($row['user_rank'] >= 3 && $row['user_rank'] < 4) {
            $achievementNumber = '30';
            $achievement_text = 'Шанс победить уже в 3 раза выше! И это не предел!';
            $achievement_color = 'silver';
        }
        else {
            $achievementNumber = '40';
            $achievement_text = 'Да! Я смог! Я повысил свои шансы на победу в 4 раза!';
            $achievement_color = 'gold';
        }
        $checkAchievement = mysql_query("SELECT * FROM achievements WHERE user_id = '$user_id' AND achievement_number = '$achievementNumber'");
        if (!mysql_num_rows($checkAchievement)) {
            mysql_query("INSERT into achievements values (0, '$achievementNumber',  '$achievement_text', '$achievement_color', '$user_id')");
        }
    }
}
$footerMap = '<span><ul><li><a href="/">Главная</a></li>';
$buttons = '<div class="logo">
                <a href="/"><span class="logoText">free-cheese.com</span></a>
            </div>';
$buttonAddress = "about";
$buttons .= '<a class="button" href="'.$buttonAddress.'">О нас</a>';
$footerMap .= '<li><a href="'.$buttonAddress.'">О нас</a></li>';
$buttonAddress = "raffles";
$buttons .= '<a class="button" href="'.$buttonAddress.'">Розыгрыши</a>'.$winners_button;

$checkEvents = mysql_query("SELECT * FROM events WHERE event_start <= '$nowDate' AND event_end >= '$nowDate' ORDER BY event_type DESC");
$eventsButton = '<ul>';
while ($event_info = mysql_fetch_assoc($checkEvents)) {
    if ($event_info['event_type'] == 1) {
        $event_href = 'mainRaffle?id='.$event_info['event_id'];
    }
    else {
        $event_href = 'oneRaffle?id='.$event_info['event_id'];
    }
    $eventsButton .= '<li><a href="'.$event_href.'">'.$event_info['event_name'].'</a></li>';
}
$eventsButton .= '</ul>';

$footerMap .= '<li><a href="'.$buttonAddress.'">Розыгрыши</a>'.$eventsButton.'</li><li><a href="winners">Победители</a></li>';
$buttonAddress = "news";
$buttons .= '<a class="button" href="'.$buttonAddress.'">Новости</a>';

$row_count = mysql_result(mysql_query("SELECT COUNT(*) FROM news WHERE news_start <= '$nowDate'"), 0);
$dateForSQL = "'$nowDate'";
$query = '(SELECT * FROM news WHERE news_start <= '.$dateForSQL.' LIMIT '.rand(0, $row_count-1).', 1)';
$checkNews = mysql_query($query);
$news_info = mysql_fetch_assoc($checkNews);
$newsButton = '<ul><li><a href="oneNews?id='.$news_info['news_id'].'">'.$news_info['news_name'].'</a></li></ul>';

$footerMap .= '<li><a href="'.$buttonAddress.'">Новости</a>'.$newsButton.'</li>';
$buttonAddress = "articles";
$buttons .= '<a class="button" href="'.$buttonAddress.'">Статьи</a>';

$row_count = mysql_result(mysql_query("SELECT COUNT(*) FROM articles WHERE article_start <= '$nowDate'"), 0);
$query = '(SELECT * FROM articles WHERE article_start <= '.$dateForSQL.' LIMIT '.rand(0, $row_count-1).', 1)';
$checkArticle = mysql_query($query);
$article_info = mysql_fetch_assoc($checkArticle);
$articleButton = '<ul><li><a href="oneArticle?id='.$article_info['article_id'].'">'.$article_info['article_name'].'</a></li></ul>';

$footerMap .= '<li><a href="'.$buttonAddress.'">Статьи</a>'.$articleButton.'</li>';
$buttonAddress = "blog";
$buttons .= '<a class="button" href="'.$buttonAddress.'">Блог</a>';
$footerMap .= '<li><a href="'.$buttonAddress.'">Блог</a></li>';
$buttonAddress = "contacts";
$buttons .= '<a class="button" href="'.$buttonAddress.'">Контакты</a>';
$footerMap .= '<li><a href="'.$buttonAddress.'">Контакты</a></li>';
$buttonAddress = "users";
$buttons .= '<a class="button" href="'.$buttonAddress.'">Users</a>';

$row_count = mysql_result(mysql_query("SELECT COUNT(*) FROM users WHERE user_status = '1' AND user_id != '0'"), 0);
$query = '(SELECT * FROM users WHERE user_status = 1 AND user_id != 0 LIMIT '.rand(0, $row_count-1).', 1)';
$checkUser = mysql_query($query);
$user_footer_info = mysql_fetch_assoc($checkUser);
if ($user_footer_info['user_nick'] != '') {
    $user_label = $user_footer_info['user_nick'];
}
else {
    $user_label = $user_footer_info['user_name'];
}
$userButton = '<ul><li><a href="user?id='.$user_footer_info['user_id'].'">'.$user_label.'</a></li></ul>';

$footerMap .= '<li><a href="'.$buttonAddress.'">Users</a>'.$userButton.'</li>';
$buttonAddress = "social";
$buttons .= '<a class="button" href="'.$buttonAddress.'">Social</a>';
$footerMap .= '<li><a href="'.$buttonAddress.'">Social</a></li>';

$buttonAddress = "http://twitter.com/_Free_Cheese_";
$socialButton = '<td><a href="'.$buttonAddress.'" target="_blank" class="social twitter"></a></td>';
$buttonAddress = "http://instagram.com/freecheesecom/";
$socialButton .= '<td><a href="'.$buttonAddress.'" target="_blank" class="social instagram"></a></td>';
$buttonAddress = "http://vk.com/freecheesecom";
$socialButton .= '<td><a href="'.$buttonAddress.'" target="_blank" class="social vk"></a></td>';

$footerMap .= '</ul></span>';
$footer = '<span>©2013-'.date('Y', time() + $hoursDiff*3600).' <a href="http://fc-gr.com">Free Cheese Group</a></span>';
$footer = $footerMap.$footer;
$server_answer = $_SESSION['server_answer'];

if ($_SESSION['usermail'] != '') {
    $real_user_mail = $_SESSION['usermail'];
    $checkRealUser = mysql_query("SELECT * FROM users WHERE user_mail = '$real_user_mail'");
    $real_user_info = mysql_fetch_assoc($checkRealUser);
}
//а вот тут будем готовить сами оповещения!
if (isset($real_user_info)) {
    $reminder_user_id = $real_user_info['user_id'];
    $checkReminder = mysql_query("SELECT * FROM reminders WHERE reminder_user = '$reminder_user_id' AND reminder_success = '0' ORDER BY reminder_id DESC");
    if (mysql_num_rows($checkReminder)) {
        $reminder_info = mysql_fetch_assoc($checkReminder);
        $reminder_comment_id = $reminder_info['reminder_target'];
        $checkReminderComment = mysql_query("SELECT * FROM comments WHERE comment_id = '$reminder_comment_id'");
        if (mysql_num_rows($checkReminderComment)) {
            $reminder_comment = mysql_fetch_assoc($checkReminderComment);
            $reminder_comment_user = $reminder_comment['user_id'];
            $checkReminderUser = mysql_query("SELECT * FROM users WHERE user_id = '$reminder_comment_user'");
            if (mysql_num_rows($checkReminderUser)) {
                $reminder_comment_user_info = mysql_fetch_assoc($checkReminderUser);
                if ($reminder_comment_user_info['user_nick'] == '') {
                    $reminder_comment_user_label = $reminder_comment_user_info['user_name'];
                }
                else {
                    $reminder_comment_user_label = $reminder_comment_user_info['user_nick'];
                }
                $buttonOnclick = "document.getElementById('unreadComment').className='unreadComment animated fadeOutDownBig'";
                $_SESSION['commentPosition'] = '<div class="unreadComment animated fadeInUpBig" id="unreadComment">
                        <div class="unreadBackground"></div>
                        <div class="userAvatar">
                            <a href="user?id='.$reminder_comment_user_info['user_id'].'">
                                <img src="/images/users/'.$reminder_comment_user_info['user_id'].'.jpg">
                            </a>
                            <span>
                                <a href="user?id='.$reminder_comment_user_info['user_id'].'">'.$reminder_comment_user_label.'</a>
                            </span>
                        </div>
                        <div class="unreadMessageBlock">
                            <h2>Новый ответ на Ваш коментарий</h2>
                            <span>"<span class="commentPreview">'.$reminder_comment['comment_text'].'</span>"</span>
                            <form method="post">
                                <input type="hidden" name="readingComment" value="'.$reminder_info['reminder_id'].'">
                                <input class="inviteButton" value="Прочитать" type="submit" onclick="'.$buttonOnclick.'">
                            </form>
                        </div>
                    </div>';
            }
        }
    }
}
$reminderBlock = $_SESSION['commentPosition'];
//$_SESSION['commentPosition'] = '';