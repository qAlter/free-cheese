<?php
if (empty($_GET['id'])) {
    header('location: news');
    exit();
}
require_once ('phpscripts/server.php');
require_once ('phpscripts/comments.php');
$news_id = (int)$_GET['id'];
$checkNews = mysql_query("SELECT * FROM news WHERE news_id = '$news_id' AND news_start <= '$nowDateTime'");
if (mysql_num_rows($checkNews)) {
    $news_info = mysql_fetch_assoc($checkNews);
    $news_title = $news_info['news_name'].' | Новости free-cheese.com';
    $news_description = strip_tags($news_info['news_text']);
    $news_description = substr($news_description, 0, 300);
    $news_description = '<meta name="description" content="'.$news_description.'">';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $news_title ?></title>
    <?php echo $news_description ?>
    <meta charset='utf-8'>
    <link href="style/cheese.css" rel="stylesheet">
    <link href="style/animate.css" rel="stylesheet">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <script src="scripts/onReady.js"></script>
    <script src="scripts/preview.js"></script>
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
                        </td>
                        <?php echo $socialButton ?>
                    </tr>
                </table>
            </div>
        </div>
        <div class="body">
            <?php
            $news_id = (int)$_GET['id'];
            $checkNews = mysql_query("SELECT * FROM news WHERE news_id = '$news_id' AND news_start <= '$nowDateTime'");
            if (mysql_num_rows($checkNews)) {
                $news_info = mysql_fetch_assoc($checkNews);
                $user_id = $news_info['user_id'];
                $checkUser = mysql_query("SELECT * FROM users WHERE user_id = '$user_id'");
                $user_info = mysql_fetch_assoc($checkUser);
                $news_adr = "document.location.assign('oneNews?id=".$news_info['news_id']."')";
                if ($user_info['user_nick'] != '') {
                    $news_user_label = $user_info['user_nick'];
                }
                else {
                    $news_user_label = $user_info['user_name'];
                }
                $news_date = date_create($news_info['news_start']);
                $news_date = date_format($news_date, 'd.m.Y H:i:s');
                $comment_page_id = (int)$_GET['id'];
                $checkComments = mysql_query("SELECT * FROM comments WHERE comment_page = '$justLocation' AND comment_page_id = '$comment_page_id' AND comment_answer = '0' ORDER BY comment_date ASC");
                $user_mail = $_SESSION['usermail'];
                function makeComment($row, $commentBlock, $location_id, $answer, $justLocation) {
                    $comment_id = $row['comment_id'];
                    $comment_user_id = $row['user_id'];
                    $checkUser = mysql_query("SELECT * FROM users WHERE user_id = '$comment_user_id'");
                    if (mysql_num_rows($checkUser)) {
                        $user_info = mysql_fetch_assoc($checkUser);
                        if ($user_info['user_nick'] != '') {
                            $user_label = $user_info['user_nick'];
                        }
                        else {
                            $user_label = $user_info['user_name'];
                        }
                        if ($user_info['user_avatar'] == '') {
                            $user_ava = 'images/avatar.png';
                        }
                        else {
                            $user_ava = $user_info['user_avatar'];
                        }
                    }
                    else {
                        $user_ava = 'images/users/0.jpg';
                        $user_label = 'Somebody';
                        $comment_user_id = '0';
                    }
                    $user_mail = $_SESSION['usermail'];
                    $checkUser = mysql_query("SELECT * FROM users WHERE user_mail = '$user_mail'");
                    $user_info = mysql_fetch_assoc($checkUser);
                    if (($user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2') || ($user_info['user_id'] == $row['user_id'] && $row['comment_delete'] != 1)) {
                        $deleteComment = '<button onclick="deleteComment(this)">X</button><input type="hidden" value="'.$row['comment_id'].'">';
                    }
                    else {
                        $deleteComment = '';
                    }
                    if ($user_info['user_id'] != $row['user_id'] && isset($user_info['user_id'])) {
                        $answerComment = '<button class="answerButton" onclick="answerComment(this)">Ответить<input type="hidden" value="'.$row['comment_id'].'"></button>';
                    }
                    else {
                        $answerComment = '';
                    }
                    if ($row['comment_delete'] == 0) {
                        $comment_text = $row['comment_text'];
                    }
                    else {
                        $comment_text = '<b>(комментарий удален)</b>';
                    }
                    $comment_date = date_create($row['comment_date']);
                    $comment_date = date_format($comment_date, 'd.m.Y H:i:s');
                    if ($answer) {
                        $user_answer_href = '';
                        $answerClass = 'answerComment';
                        $answerWho = mysql_query("SELECT * FROM comments WHERE comment_id = '$answer'");
                        if (mysql_num_rows($answerWho)) {
                            $answerComment_info = mysql_fetch_assoc($answerWho);
                            $answerUserId = $answerComment_info['user_id'];
                            $userWho = mysql_query("SELECT * FROM users WHERE user_id = '$answerUserId'");
                            if (mysql_num_rows($userWho)) {
                                $user_answer_info = mysql_fetch_assoc($userWho);
                                if ($user_answer_info['user_nick'] == '') {
                                    $user_answer_label = $user_answer_info['user_name'];
                                }
                                else {
                                    $user_answer_label = $user_answer_info['user_nick'];
                                }
                                $user_answer_href = '<a href="user?id='.$answerUserId.'">'.$user_answer_label.'</a>, ';
                            }
                        }
                    }
                    else {
                        $answerClass = '';
                        $user_answer_href = '';
                    }
                    $commentBlock .= '<div class="oneComment '.$answerClass.'">
                                        <div class="userAvatar">
                                            <a href="user?id='.$comment_user_id.'"><img src="'.$user_ava.'"></a>
                                            <span>
                                                <a href="user?id='.$comment_user_id.'">'.$user_label.'</a>
                                            </span>
                                        </div>
                                        <div class="userComment">
                                            <span class="dateComment">'.$comment_date.'</span>
                                            <span>'.$user_answer_href.$comment_text.'</span>
                                        </div>
                                        '.$deleteComment.$answerComment.'
                                    </div>
                                    ';
                    $checkAnswers = mysql_query("SELECT * FROM comments WHERE comment_page = '$justLocation' AND comment_page_id = '$location_id' AND comment_answer='$comment_id' ORDER BY comment_date ASC");
                    if (mysql_num_rows($checkAnswers)) {
                        while ($rowAnswers = mysql_fetch_assoc($checkAnswers)) {
                            $commentAnswer = $rowAnswers['comment_answer'];
                            $commentBlock = makeComment($rowAnswers, $commentBlock, $location_id, $commentAnswer, $justLocation);
                        }
                    }
                    return $commentBlock;
                }
                if (mysql_num_rows($checkComments)) {
                    $commentBlock = '
                                    <div class="colorHeader red">
                                        <h1>Комментарии</h1>
                                    </div>
                                    <div class="commentsBlock">
                                ';
                    while ($row = mysql_fetch_assoc($checkComments)) {
                        $commentBlock = makeComment($row, $commentBlock, $comment_page_id, 0, $justLocation);
                    }
                    $commentBlock .= '</div>';
                }
                else {
                    $commentBlock = '';
                }
                if (isset($_SESSION['username']) != '') {
                    $user_mail = $_SESSION['usermail'];
                    $checkUser = mysql_query("SELECT * FROM users WHERE user_mail = '$user_mail'");
                    $user_info = mysql_fetch_assoc($checkUser);
                    if ($user_info['user_privilege'] != 4) {
                        $commentCreate = '
                                        <div class="colorHeader red">
                                            <h1>Добавить комментарий</h1>
                                        </div>
                                        <div class="newCommentBlock">
                                            <textarea placeholder="Введите Ваш комментарий"></textarea>
                                            <button class="inviteButton" onclick="sendComment(this)">Отправить</button>
                                        </div>
                                    ';
                    }
                    else {
                        $commentCreate = '
                                        <div class="colorHeader red">
                                            <h1>Добавить комментарий</h1>
                                        </div>
                                        <div class="newCommentBlock">
                                            <span>Добавление комментариев не доступно забаненым пользователям</span>
                                        </div>
                                    ';
                    }
                }
                else {
                    $commentCreate = '
                                    <div class="colorHeader red">
                                        <h1>Добавить комментарий</h1>
                                    </div>
                                    <div class="newCommentBlock">
                                        <span>Добавление комментариев доступно только зарегистрированным пользователям</span>
                                    </div>
                                ';
                }
                if ($real_user_info['user_privilege'] == '1') {
                    $redBut = '<button class="rewrite" onclick="changeText(this)"><input type="hidden" value="'.$news_info['news_id'].'"></button>';
                }
                echo '
                <div class="colorHeader blue">
                    <h1>'.$news_info['news_name'].'</h1>
                </div>
                <div class="bodyLeft">
                    <div class="mainRaffle">
                        <img src="'.$news_info['news_avatar'].'" alt="'.$news_info["news_name"].'">
                        <span class="aboutUs">'.$redBut.$news_info['news_text'].'</span>
                        <div class="raffleBottom blue">
                            <div class="raffleBottomContent">
                                <span>Новость от '.$news_date.' (<a href="user?id='.$news_info['user_id'].'">'.$news_user_label.'</a>)</span>
                            </div>
                        </div>
                    </div>
                    '.$commentBlock.$commentCreate.'
                </div>';
            }
            else {
                header('location: news');
                exit();
            }
            ?>
            <div class="bodyRight">
                <?php
                $checkOther = mysql_query("SELECT * FROM events WHERE event_start <= '$nowDate' ORDER BY event_type DESC");
                if (mysql_num_rows($checkOther)) {
                    echo '
                    <div class="colorHeader green">
                        <h1>
                            <a href="raffles">Другие розыгрыши</a>
                        </h1>
                    </div>
                    <div class="secondaryRaffles">
                    ';
                    while ($row = mysql_fetch_assoc($checkOther)) {
                        if($nowDate >= $row['event_start'] && $nowDate <= $row['event_end']) {
                            $other_ruffle_id = $row['event_id'];
                            $other_ruffle_img = $row['event_avatar'];
                            $other_ruffle_name = $row['event_name'];
                            $other_ruffle_type = $row['event_type'];
                            if ($other_ruffle_type == '1') {
                                $other_ruffle_class = 'yellow';
                                $other_ruffle_head = 'Основной розыгрыш';
                                $other_ruffle_site = 'mainRaffle';
                            }
                            else {
                                $other_ruffle_class = '';
                                $other_ruffle_head = 'Дополнительный розыгрыш';
                                $other_ruffle_site = 'oneRaffle';
                            }
                            $other_ruffle_href = $other_ruffle_site."?id=".$other_ruffle_id;
                            $other_ruffle_adr = "document.location.assign('".$other_ruffle_href."')";
                            echo '
                                    <div class="oneRaffle">
                                        <div class="raffleTop '.$other_ruffle_class.'">
                                            <div class="raffleTopContent">
                                                <span><a href="'.$other_ruffle_href.'">'.$other_ruffle_head.'</a></span>
                                                <button onclick="'.$other_ruffle_adr.'">Подробнее</button>
                                            </div>
                                        </div>
                                        <a href="'.$other_ruffle_href.'"><img src="'.$other_ruffle_img.'" alt="'.$other_ruffle_head.'"></a>
                                        <div class="raffleBottom '.$other_ruffle_class.'">
                                            <div class="raffleBottomContent">
                                                <span><a href="'.$other_ruffle_href.'">'.$other_ruffle_name.'</a></span>
                                            </div>
                                        </div>
                                    </div>';
                        }
                    }
                    echo '</div>';
                }
                else {
                    echo '<div class="secondaryRaffles"><span style="display: block; text-align: center; margin-bottom: 5px">В данный момент розыгрыши не проводятся</span></div>';
                }
                ?>
                <?php
                $checkNews = mysql_query("SELECT * FROM news WHERE news_start <= '$nowDateTime' and news_end >= '$nowDate' and news_id != '$news_id' ORDER BY news_start DESC");
                echo '<div class="colorHeader blueLight">
                                <h1>
                                    <a href="news">Новости</a>
                                </h1>
                            </div>
                            <div class="newsBlock">';
                if (mysql_num_rows($checkNews)) {
                    while ($row = mysql_fetch_assoc($checkNews)) {
                        $news_href = "oneNews?id=".$row['news_id'];
                        $news_adr = "document.location.assign('".$news_href."')";
                        $text = strip_tags($row['news_text']);
                        echo '<div class="oneNews">
                                        <div class="newsTop">
                                            <div class="newsTopContent">
                                                <span class="raffleShortHeader"><a href="'.$news_href.'">'.$row["news_name"].'</a></span>
                                                <button onclick="'.$news_adr.'">Подробнее</button>
                                            </div>
                                        </div>
                                        <a href="'.$news_href.'"><img src="'.$row['news_avatar'].'" alt="'.$row["news_name"].'"></a>
                                        <div class="newsBottom">
                                            <div class="newsBottomContent">
                                                <span class="raffleShortPreview">'.$text.'</span>
                                            </div>
                                        </div>
                                    </div>';
                    }
                    echo '</div>';
                }
                else {
                    echo '<span style="display: block; text-align: center; margin-bottom: 5px">В данный момент актуальных новостей нет</span>
                            </div>';
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
<script src="scripts/logForgot.js"></script>
<script src="scripts/comments.js"></script>
<?php
if ($real_user_info['user_privilege'] == '1') {
    echo '<script src="scripts/admin.js"></script><script src="scripts/moderator.js"></script>';
}
else if ($real_user_info['user_privilege'] == '2') {
    echo '<script src="scripts/moderator.js"></script>';
}
?>
<!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter22298638 = new Ya.Metrika({id:22298638, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/22298638" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-37499878-2', 'free-cheese.com');ga('send', 'pageview');</script>
</body>
</html>