<?php
require_once ('phpscripts/server.php');
require_once ('phpscripts/userLogic.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>
        <?php
        if ($user_info['user_nick'] != '') {
            $header_page = $user_info['user_nick'];
        }
        else {
            $header_page = $user_info['user_name'];
        }
        if ($user_page) {
            echo 'Личный кабинет '.$header_page.' | free-cheese.com';
        }
        else {
            echo $header_page.' | free-cheese.com';
        }
        ?>
    </title>
    <meta charset='utf-8'>
    <link href="style/cheese.css" rel="stylesheet">
    <link href="style/animate.css" rel="stylesheet">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <script src="scripts/onReady.js"></script>
    <script src="scripts/preview.js"></script>
    <script src="scripts/change.js"></script>
    <script src="scripts/messages.js"></script>
</head>
<body>
<?php echo $server_answer; $_SESSION['server_answer'] = '' ?>
    <div class="container">
        <div class="header">
            <?php echo $buttons ?>
            <div class="loginBlock" id="loginBlock">
                <table>
                    <tr>
                        <td>
                            <?php
                            if (isset($_SESSION['username']) == '') {
                                echo '<form action="javascript:next();">
                                          <input type="text" name="email" placeholder="E-mail">
                                      </form>';
                            }
                            ?>
                        </td>
                        <td colspan="3">
                            <?php
                            if (isset($_SESSION['username']) == '') {
                                echo '<a onclick="login()">Вход</a>'.'
                                      <a href="registration">Регистрация</a>
                                      <a onclick="forgot()">Забыли пароль?</a>';
                            }
                            else {
                                echo '<span class="user">
                                          <span>Здравствуйте, </span><a href="user">'.$_SESSION['username'].'</a><br>
                                          <a onclick="logout()">ВЫХОД</a>
                                      </span>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            if (isset($_SESSION['username']) == '') {
                                echo '<form action="javascript:login();">
                                          <input type="password" name="pass" placeholder="Пароль">
                                      </form>';
                            }
                            ?>
                        </td>						<?php echo $socialButton ?>
                    </tr>
                </table>
            </div>
        </div>
        <div class="body">
            <div class="colorHeader yellow">
                <span>
                    <?php
                    if ($user_page) {
                        echo 'Личный кабинет';
                    }
                    else {
                        if ($user_info['user_nick'] != '') {
                            $header_page = 'Профиль '.$user_info['user_nick'];
                        }
                        else {
                            $header_page = 'Профиль '.$user_info['user_name'];
                        }
                        $nowDateTime = date('Y-m-d H:i:s', time() + ($hoursDiff*3600 - 1200));
                        if ($user_info['user_login'] != '0000-00-00 00:00:00') {
                            if ($nowDateTime <= $user_info['user_login']) {
                                $user_online = '<span style="color: black;"> (online)</span>';
                            }
                            else {
                                $login_date = date_create($user_info['user_login']);
                                $login_date = date_format($login_date, 'd.m.Y H:i:s');
                                $user_online = '<span style="color: #aaa;"> ('.$login_date.')</span>';
                            }
                        }
                        echo $header_page.$user_online;
                    }
                    ?>
                </span>
            </div>
            <div class="profile">
                <div class="profileAvatar">
                    <img src="
                        <?php
                        if ($user_info['user_avatar'] == '') {
                            echo 'images/avatar.png';
                        }
                        else {
                            echo $user_info['user_avatar'];
                        }
                        ?>
                    ">
                    <?php
                    if ($user_info['user_status'] == '1') {
                        echo $user_rank;
                    }
                    if ($user_page) {
                        if ($user_info['user_twit'] != '') {
                            echo '<div class="userTwit" style="cursor: pointer" onclick="changeTwit(this)"><span>'.$user_info['user_twit'].'</span></div>';
                        }
                        else {
                            echo '<div class="userTwit" style="cursor: pointer" onclick="changeTwit(this)"><span style="color: gray">Введите статус</span></div>';
                        }
                    }
                    else {
                        if ($user_info['user_twit'] != '') {
                            echo '<div class="userTwit"><span>'.$user_info['user_twit'].'</span></div>';
                        }
                        else {
                            echo '<div class="userTwit"><span style="color: gray">нет статуса</span></div>';
                        }
                    }
                    ?>
                </div>
                <div class="profileData">
                    <span class="profileName"><?php echo $user_info['user_name'];?> <span><?php echo $user_info['user_nick'];?></span>
                        <?php
                        if ($user_info['user_privilege'] == '1')
                            echo '(admin)';
                        else if ($user_info['user_privilege'] == '2')
                            echo '(moderator)';
                        else if ($user_info['user_privilege'] == '3')
                            echo '(writer)';
                        else if ($user_info['user_privilege'] == '4')
                            echo '(banned)';
                        else if ($user_info['user_privilege'] == '0')
                            echo '(user)';
                        ?>
                    </span>
                    <table>
                        <?php
                        if ($user_page) {
                            if ($achievements != '') {
                                echo '
                            <tr>
                                <td>Достижения:</td>
                                <td colspan="4">'.$achievements.'</td>
                            </tr>
                            ';
                            }
                            echo '
                            <tr>
                                <td>Никнейм:</td>
                                <td>'.$user_info['user_nick'].'</td>
                                <td>Сменить</td>
                                <td>
                                    <input type="text" name="nick" placeholder="'.$user_info['user_nick'].'">
                                </td>
                                <td>
                                    <button onclick="changeData(this)">Сменить</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Аватар:</td>
                                <td class="avatarName">';
                                        if ($user_info['user_avatar'] == '') {
                                            echo 'standart';
                                        }
                                        else {
                                            echo $user_info['user_avatar'];
                                        }
                                echo '</td>
                                <td>Сменить</td>
                                <td>
                                    <input type="text" name="ava" placeholder="URL">
                                </td>
                                <td>
                                    <button onclick="changeData(this)">Сменить</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Пароль:</td>
                                <td>******</td>
                                <td>Сменить</td>
                                <td><input type="password" name="pass" placeholder="******"></td>
                                <td><button onclick="changeData(this)">Сменить</button></td>
                            </tr>
                            <tr>
                                <td>E-mail:</td>
                                <td colspan="4">'.$user_info['user_mail'].'</td>
                            </tr>
                        ';
                        }
                        else if ($real_user_info['user_privilege'] == '1') {
                            if (!$user_page && $achievements != '') {
                                echo '
                            <tr>
                                <td>Достижения:</td>
                                <td colspan="4">'.$achievements.'</td>
                            </tr>
                            ';
                            }
                           echo '
                            <tr>
                                <td>E-mail:</td>
                                <td colspan="4">'.$user_info['user_mail'].'</td>
                            </tr>
                           ';
                        }
                        if (!$user_page && $achievements != '' && $real_user_info['user_privilege'] != '1') {
                            echo '
                        <tr>
                            <td>Достижения:</td>
                            <td colspan="4">'.$achievements.'</td>
                        </tr>
                            ';
                        }
                        ?>
                        <tr>
                            <td>Страна:</td>
                            <td colspan="4"><?php echo $user_info['user_country'];?></td>
                        </tr>
                        <tr>
                            <td>Город:</td>
                            <td colspan="4"><?php echo $user_info['user_city'];?></td>
                        </tr>
                        <?php
                        if ($user_info['user_phone'] != '' && ($user_page || $real_user_info['user_privilege'] == '1')) {
                            echo '
                                <tr>
                                    <td>Телефон:</td>
                                    <td colspan="4">'.$user_info['user_phone'].'</td>
                                </tr>
                            ';
                        }
                        ?>
                    </table>
                    <div class="colorHeader red">
                        <span>Заявки на участие</span>
                    </div>
                    <table class="tableRaffles">
                        <thead>
                            <tr>
                                <td>Тип розыгрыша</td>
                                <td>Название розыгрыша</td>
                                <td>Статус Вашей заявки</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $checkEvents = mysql_query("SELECT * FROM events ORDER BY event_start ASC, event_type DESC");
                        if (!mysql_num_rows($checkEvents)) {
                            echo '<tr><td colspan="3">В данный момент розыгрыши не проводятся</td></tr>';
                        }
                        else {
                            while ($row = mysql_fetch_assoc($checkEvents)) {
                                if($nowDate >= $row['event_start'] && $nowDate <= $row['event_end']) {
                                    $ruffle_id = $row['event_id'];
                                    $ruffle_type = $row['event_type'];
                                    if ($ruffle_type == '1') {
                                        $raffle_href = 'mainRaffle';
                                    }
                                    else {
                                        $raffle_href = 'oneRaffle';
                                    }
                                    $ruffle_adr = "document.location.assign('".$raffle_href."?id=".$ruffle_id."')";
                                    $ruffle_name = $row['event_name'];
                                    $user_id = $user_info['user_id'];
                                    if ($ruffle_type == '1') {
                                        $ruffle_header = 'Основной розыгрыш';
                                    }
                                    else {
                                        $ruffle_header = 'Дополнительный розыгрыш';
                                    }
                                    echo '<tr><td>'.$ruffle_header.'</td><td><a onclick="'.$ruffle_adr.'">'.$ruffle_name.'</a></td>';
                                    $checkRequests = mysql_query("SELECT * FROM requests WHERE event_id='$ruffle_id' AND user_id='$user_id'");
                                    if (!mysql_num_rows($checkRequests)) {
                                        $ruffle_status = 'Заявка не отправлена';
                                    }
                                    else {
                                        $ruffle_status = 'Заявка отправлена';
                                    }
                                    echo '<td>'.$ruffle_status.'</td></tr>';
                                }
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <?php
                if ($user_page) {
                    if ($user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2') {
                        echo '<div class="adminPanel" style="height: 45px;">
                                <div class="colorHeader green">
                                    <span>Розыгрыши</span>
                                </div>
                                <table class="adminTable">
                                    <thead>
                                        <tr>
                                            <td>Тип</td>
                                            <td>Название</td>
                                            <td class="adminEventText">Текст</td>
                                            <td>Аватар</td>
                                            <td>Дата начала</td>
                                            <td>Дата конца</td>
                                            <td>Действия</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select name="eventType">
                                                    <option value="1">Основной</option>
                                                    <option value="0">Дополнительный</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="eventName">
                                            </td>
                                            <td>
                                                <textarea name="eventText"></textarea>
                                            </td>
                                            <td><input type="text" name="eventAva" placeholder="URL"></td>
                                            <td><input type="date" name="eventStart"></td>
                                            <td><input type="date" name="eventEnd"></td>
                                            <td>
                                                <button onclick="addEvent(this)">Добавить</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="colorHeader green">
                                    <span>Все розыгрыши</span>
                                </div>
                                <table class="adminTable">
                                    <thead>
                                    <tr>
                                        <td>Тип</td>
                                        <td>ID</td>
                                        <td>Название</td>
                                        <td class="adminEventText">Текст</td>
                                        <td>Аватар</td>
                                        <td class="adminEventDate">Дата начала</td>
                                        <td class="adminEventDate">Дата конца</td>
                                        <td>Участников</td>
                                        <td>Действия</td>
                                    </tr>
                                    </thead>
                                    <tbody>';
                        $checkEvents = mysql_query("SELECT * FROM events");
                        if (!mysql_num_rows($checkEvents)) {
                            echo '<tr><td colspan="9">Нет розыгрышей</td></tr>';
                        }
                        else {
                            while ($row = mysql_fetch_assoc($checkEvents)) {
                                if ($row['event_type'] == '1') {
                                    $event_type = 'Основной';
                                    $event_href = '<a href="mainRaffle?id='.$row["event_id"].'">';
                                }
                                else {
                                    $event_type = 'Дополнительный';
                                    $event_href = '<a href="oneRaffle?id='.$row["event_id"].'">';
                                }
                                echo '
                                    <tr>
                                        <td>'.$event_type.'</td>
                                        <td>'.$row["event_id"].'</td>
                                        <td>'.$event_href.$row["event_name"].'</a></td>
                                        <td>'.$row["event_text"].'</td>
                                        <td class="avatarName">'.$row["event_avatar"].'</td>
                                        <td>'.$row["event_start"].'</td>
                                        <td>'.$row["event_end"].'</td>
                                        <td>'.$row["event_member"].'</td>
                                        <td>
                                            <button onclick="changeEvent(this)">Изменить</button>
                                            <button onclick="deleteEvent(this)">Удалить</button>
                                        </td>
                                    </tr>';
                            }
                        }
                        echo '</tbody>
                            </table>
                        </div>';
                    }
                    if ($user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2' || $user_info['user_privilege'] == '3') {
                        if ($user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2') {
                            $adminArea = '<td>Пользователь</td>';
                        }
                        else {
                            $adminArea = '';
                        }
                        echo '<div class="adminPanel" style="height: 45px;">
                                <div class="colorHeader greenLight">
                                    <span>Новости</span>
                                </div>
                                <table class="adminTable">
                                    <thead>
                                    <tr>
                                        <td>Название</td>
                                        <td class="adminEventText">Текст</td>
                                        <td>Аватар</td>
                                        <td>Дата начала</td>
                                        <td>Дата конца</td>
                                        <td>Действия</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" name="newsName">
                                        </td>
                                        <td>
                                            <textarea name="newsText"></textarea>
                                        </td>
                                        <td><input type="text" name="newsAva" placeholder="URL"></td>
                                        <td><input type="datetime-local" name="newsStart" value="'.$nowDate.'T'.$nowTime.'"></td>
                                        <td><input type="date" name="newsEnd"value="'.date('Y-m-d', time() + $hoursDiff*3600 + 48*3600).'"></td>
                                        <td>
                                            <button onclick="addNews(this)">Добавить</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="colorHeader greenLight">
                                    <span>Все новости</span>
                                </div>
                                <table class="adminTable">
                                    <thead>
                                    <tr>
                                        <td>ID</td>'.$adminArea.'
                                        <td>Название</td>
                                        <td class="adminEventText">Текст</td>
                                        <td>Аватар</td>
                                        <td class="adminEventDate">Дата начала</td>
                                        <td class="adminEventDate">Дата конца</td>
                                        <td>Действия</td>
                                    </tr>
                                    </thead>
                                    <tbody>';
                        if ($user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2') {
                            $checkNews = mysql_query("SELECT * FROM news ORDER BY news_start DESC");
                            $colspan = '8';
                        }
                        else {
                            $user_id = $user_info['user_id'];
                            $checkNews = mysql_query("SELECT * FROM news WHERE user_id = '$user_id' ORDER BY news_start DESC");
                            $colspan = '7';
                        }
                        if (!mysql_num_rows($checkNews)) {
                            echo '<tr><td colspan="'.$colspan.'">Нет новостей</td></tr>';
                        }
                        else {
                            while ($row = mysql_fetch_assoc($checkNews)) {
                                if ($user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2') {
                                    $news_user_id = $row['user_id'];
                                    $checkUser = mysql_query("SELECT * FROM users WHERE user_id = '$news_user_id'");
                                    $news_user_info = mysql_fetch_assoc($checkUser);
                                    if ($user_info['user_nick'] != '') {
                                        $user_label = $news_user_info['user_nick'];
                                    }
                                    else {
                                        $user_label = $news_user_info['user_name'];
                                    }
                                    $adminArea = '<td>'.$user_label.'</td>';
                                }
                                else {
                                    $adminArea = '';
                                }
                                echo '<tr>
                                        <td>'.$row['news_id'].'</td>'.$adminArea.'
                                        <td>'.$row['news_name'].'</td>
                                        <td>'.$row['news_text'].'</td>
                                        <td class="avatarName">'.$row['news_avatar'].'</td>
                                        <td>'.$row['news_start'].'</td>
                                        <td>'.$row['news_end'].'</td>
                                        <td>
                                            <button onclick="changeNews(this)">Изменить</button>
                                            <button onclick="deleteNews(this)">Удалить</button>
                                        </td>
                                    </tr>';
                            }
                            echo '</tbody>
                            </table>
                        </div>';
                        }
                    }
                    if ($user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2' || $user_info['user_privilege'] == '3') {
                        $user_id = $user_info['user_id'];
                        if ($user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2') {
                            $adminArea = '<td>Пользователь</td>';
                            $colspan = '7';
                            $checkArticles = mysql_query("SELECT * FROM articles ORDER BY article_start DESC");
                        }
                        else {
                            $adminArea = '';
                            $colspan = '6';
                            $checkArticles = mysql_query("SELECT * FROM articles WHERE user_id = '$user_id' ORDER BY article_start DESC");
                        }
                        echo '
                        <div class="adminPanel" style="height: 45px;">
                            <div class="colorHeader orange">
                                <span>Статьи</span>
                            </div>
                            <table class="adminTable">
                                <thead>
                                <tr>
                                    <td>Название</td>
                                    <td class="adminEventText">Текст</td>
                                    <td>Картинки</td>
                                    <td>Дата написания</td>
                                    <td>Действия</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <input type="text" name="articleName">
                                    </td>
                                    <td>
                                        <textarea name="articleText" placeholder="HTML коды активны. Для вставки картинки ипользуйте конструкцию (%N%), где N-номер картинки"></textarea>
                                    </td>
                                    <td><input type="text" name="articleAva" placeholder="URL"><button onclick="addArticleAva(this)">Еще</button></td>
                                    <td><input type="datetime-local" name="articleStart" value="'.$nowDate.'T'.$nowTime.'"></td>
                                    <td>
                                        <button onclick="addArticle(this)">Добавить</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="colorHeader orange">
                                <span>Все статьи</span>
                            </div>
                            <table class="adminTable">
                                <thead>
                                <tr>
                                    <td>ID</td>'.$adminArea.'
                                    <td>Название</td>
                                    <td class="adminEventText">Текст</td>
                                    <td>Картинки</td>
                                    <td class="adminEventDate">Дата написания</td>
                                    <td>Действия</td>
                                </tr>
                                </thead>
                                <tbody>
                               ';
                        if (!mysql_num_rows($checkArticles)) {
                            echo '
                                <tr><td colspan="'.$colspan.'">Нет статей</td></tr>
                            ';
                        }
                        else {
                            while ($row = mysql_fetch_assoc($checkArticles)) {
                                $article_id = $row['article_id'];
                                $checkAvatars = mysql_query("SELECT * FROM avatars WHERE avatar_place_id = '$article_id' AND avatar_place = 'article' ORDER BY avatar_id ASC");
                                $avatars = '';
                                if (mysql_num_rows($checkAvatars) > 1) {
                                    while ($rowAva = mysql_fetch_assoc($checkAvatars)) {
                                        $avatars .= $rowAva['avatar_url'].'$<input type="hidden" value="'.$rowAva['avatar_url'].'"><br>';
                                    }
                                }
                                else {
                                    $ava_info = mysql_fetch_assoc($checkAvatars);
                                    $avatars = $ava_info['avatar_url'].'$<input type="hidden" value="'.$ava_info['avatar_url'].'"><br>';
                                }
                                if ($user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2') {
                                    $article_user_id = $row['user_id'];
                                    $checkUser = mysql_query("SELECT * FROM users WHERE user_id = '$article_user_id'");
                                    $article_user_info = mysql_fetch_assoc($checkUser);
                                    if ($user_info['user_nick'] != '') {
                                        $user_label = $article_user_info['user_nick'];
                                    }
                                    else {
                                        $user_label = $article_user_info['user_name'];
                                    }
                                    $adminArea = '<td>'.$user_label.'</td>';
                                }
                                else {
                                    $adminArea = '';
                                }
                                echo '<tr>
                                        <td>'.$row['article_id'].'</td>'.$adminArea.'
                                        <td>'.$row['article_name'].'</td>
                                        <td>'.$row['article_text'].'</td>
                                        <td class="avatarName">'.$avatars.'</td>
                                        <td>'.$row['article_start'].'</td>
                                        <td>
                                            <button onclick="changeArticle(this)">Изменить</button>
                                            <button onclick="deleteArticle(this)">Удалить</button>
                                        </td>
                                    </tr>';
                            }
                        }
                            echo '</tbody>
                            </table>
                        </div>';
                    }
                    if ($user_info['user_privilege'] == '1') {
                        echo '
                            <div class="adminPanel" style="height: 45px;">
                                <div class="colorHeader redLight">
                                    <span>Пользователи</span>
                                </div>
                                <table class="adminTable">
                                    <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>E-mail</td>
                                        <td>Имя</td>
                                        <td>Страна</td>
                                        <td>Город</td>
                                        <td>Телефон</td>
                                        <td>Права доступа</td>
                                        <td>Действия</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                        ';
                        $user_id = $user_info['user_id'];
                        $checkUsers =  mysql_query("SELECT * FROM users WHERE user_id != '$user_id' ORDER BY user_id ASC");
                        if (mysql_num_rows($checkUsers)) {
                            while ($row = mysql_fetch_assoc($checkUsers)) {
                                if ($row['user_privilege'] == '0') {
                                    $user_privilege = 'user';
                                }
                                else if ($row['user_privilege'] == '1') {
                                    $user_privilege = 'admin';
                                }
                                else if ($row['user_privilege'] == '2') {
                                    $user_privilege = 'moderator';
                                }
                                else if ($row['user_privilege'] == '3') {
                                    $user_privilege = 'writer';
                                }
                                else if ($row['user_privilege'] == '4') {
                                    $user_privilege = 'banned';
                                }
                                echo '
                                    <tr>
                                        <td>'.$row['user_id'].'</td>
                                        <td>'.$row['user_mail'].'</td>
                                        <td><a href="user?id='.$row['user_id'].'">'.$row['user_name'].'</a></td>
                                        <td>'.$row['user_country'].'</td>
                                        <td>'.$row['user_city'].'</td>
                                        <td>'.$row['user_phone'].'</td>
                                        <td>'.$user_privilege.'</td>
                                        <td>
                                            <button onclick="changeUserAdmin(this)">Изменить</button>
                                            <button onclick="deleteUserAdmin(this)">Удалить</button>
                                        </td>
                                    </tr>
                                ';
                            }
                        }
                        else {
                            echo '<tr><td colspan="8">Кроме Вас в системе никто не зарегистрирован</td></tr>';
                        }
                        echo '</tbody></table></div>';
                    }
                    else if ($user_info['user_privilege'] == '2') {
                        echo '
                            <div class="adminPanel" style="height: 45px;">
                                <div class="colorHeader redLight">
                                    <span>Пользователи</span>
                                </div>
                                <table class="adminTable">
                                    <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>E-mail</td>
                                        <td>Имя</td>
                                        <td>Страна</td>
                                        <td>Город</td>
                                        <td>Телефон</td>
                                        <td>Права доступа</td>
                                        <td>Действия</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                        ';
                        $user_id = $user_info['user_id'];
                        $checkUsers =  mysql_query("SELECT * FROM users WHERE user_id != '$user_id' and user_privilege > 2 or user_privilege = 0 ORDER BY user_id ASC");
                        if (mysql_num_rows($checkUsers)) {
                            while ($row = mysql_fetch_assoc($checkUsers)) {
                                if ($row['user_privilege'] == '0') {
                                    $user_privilege = 'user';
                                }
                                else if ($row['user_privilege'] == '1') {
                                    $user_privilege = 'admin';
                                }
                                else if ($row['user_privilege'] == '2') {
                                    $user_privilege = 'moderator';
                                }
                                else if ($row['user_privilege'] == '3') {
                                    $user_privilege = 'writer';
                                }
                                else if ($row['user_privilege'] == '4') {
                                    $user_privilege = 'banned';
                                }
                                echo '
                                    <tr>
                                        <td>'.$row['user_id'].'</td>
                                        <td>'.$row['user_mail'].'</td>
                                        <td><a href="user?id='.$row['user_id'].'">'.$row['user_name'].'</a></td>
                                        <td>'.$row['user_country'].'</td>
                                        <td>'.$row['user_city'].'</td>
                                        <td>'.$row['user_phone'].'</td>
                                        <td>'.$user_privilege.'</td>
                                        <td>
                                            <button onclick="changeUser(this)">Изменить</button>
                                        </td>
                                    </tr>
                                ';
                            }
                        }
                        else {
                            echo '<tr><td colspan="8">В системе нет обычных пользователей</td></tr>';
                        }
                        echo '</tbody></table></div>';
                    }
                    if ($user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2') {
                        if ($user_info['user_privilege'] == '1') {
                            $table_header = '
                                <td>Пользователь</td>
                                <td>ID записи</td>
                                <td>Текст записи</td>
                                <td>Действия</td>
                            ';
                        }
                        else {
                            $table_header = '
                                <td>ID записи</td>
                                <td>Текст записи</td>
                                <td>Действия</td>
                            ';
                        }
                        echo '
                            <div class="adminPanel" style="height: 45px;">
                                <div class="colorHeader blueLight">
                                    <span>Блог</span>
                                </div>
                                <table class="adminTable">
                                    <thead>
                                        <tr>
                                            <td>Текст записи</td>
                                            <td>Действия</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <form method="post" id="addPost">
                                                    <textarea class="postArea" name="postText" placeholder="Тэги HTML активированы"></textarea>
                                                </form>
                                            </td>
                                            <td>
                                                <button onclick="addPost(this)">Добавить</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="colorHeader blueLight">
                                    <span>Все записи в блоге</span>
                                </div>
                                <table class="adminTable">
                                    <thead>
                                    <tr>'.$table_header.'</tr>
                                    </thead>
                                    <tbody>
                        ';
                        if ($user_info['user_privilege'] == '1') {
                            $user_id = $user_info['user_id'];
                            $checkPosts = mysql_query("SELECT * FROM posts ORDER BY post_date DESC");
                            if (mysql_num_rows($checkPosts)) {
                                while ($row = mysql_fetch_assoc($checkPosts)) {
                                    $user_id = $row['user_id'];
                                    $checkUser = mysql_query("SELECT * FROM users WHERE user_id = '$user_id'");
                                    if (mysql_num_rows($checkUser)) {
                                        $user_info = mysql_fetch_assoc($checkUser);
                                        if ($user_info['user_nick'] != '') {
                                            $user_label = $user_info['user_nick'];
                                        }
                                        else {
                                            $user_label = $user_info['user_name'];
                                        }
                                        $attention = '';
                                    }
                                    else {
                                        $user_label = 'Удален';
                                        $attention = '<b>(Данная запись не видна на сайте, т.к. она никому не принадлежит)</b>';
                                    }
                                    echo '
                                        <tr>
                                            <td>'.$user_label.'</td>
                                            <td>'.$row['post_id'].'</td>
                                            <td>'.$row['post_text'].' '.$attention.'</td>
                                            <td>
                                                <button onclick="changePost(this)">Изменить</button>
                                                <button onclick="deletePost(this)">Удалить</button>
                                            </td>
                                        </tr>
                                    ';
                                }
                                echo '</tbody></table>';
                            }
                            else {
                                echo '<tr><td colspan="4">Нет записей</td></tr></tbody></table>';
                            }
                        }
                        else {
                            $user_id = $user_info['user_id'];
                            $checkPosts = mysql_query("SELECT * FROM posts WHERE user_id = '$user_id' ORDER BY post_date DESC");
                            if (mysql_num_rows($checkPosts)) {
                                while ($row = mysql_fetch_assoc($checkPosts)) {
                                    echo '
                                    <tr>
                                        <td>'.$row['post_id'].'</td>
                                        <td>'.$row['post_text'].'</td>
                                        <td>
                                            <button onclick="changePost(this)">Изменить</button>
                                            <button onclick="deletePost(this)">Удалить</button>
                                        </td>
                                    </tr>
                                ';
                                }
                                echo '</tbody></table>';
                            }
                            else {
                                echo '<tr><td colspan="3">Нет Ваших записей</td></tr></tbody></table>';
                            }
                        }
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
        <div class="footer">
            <!--your advert here-->
            <?php echo $footer ?>
        </div>
    </div>
<?php echo $reminderBlock ?>
<?php
if ($user_info['user_privilege'] == '1')
    echo '<script src="scripts/admin.js"></script>';
if ($user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2')
    echo '<script src="scripts/moderator.js"></script>';
if ($user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2' || $user_info['user_privilege'] == '3')
    echo '<script src="scripts/writer.js"></script>';
?>
<script src="scripts/logForgot.js"></script>
<!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter22298638 = new Ya.Metrika({id:22298638, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/22298638" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-37499878-2', 'free-cheese.com');ga('send', 'pageview');</script>
</body>
</html>