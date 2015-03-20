<?php require_once ('phpscripts/server.php');?>
<!DOCTYPE html>
<html>
<head>
    <title>301 | free-cheese.com</title>
    <meta charset='utf-8'>
    <link href="style/cheese.css" rel="stylesheet">
    <link href="style/animate.css" rel="stylesheet">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <script src="scripts/onReady.js"></script>
    <script src="scripts/preview.js"></script>
    <script src="scripts/messages.js"></script>
</head>
<body>
<?php
if ($user_info['user_privilege'] == '1') {
    //это для рассылки писем тем, кто заявки еще не подал
    /*$checkEvents = mysql_query("SELECT * FROM events");
    if (mysql_num_rows($checkEvents)) {
        $bad_users = array();
        while ($rowEvents = mysql_fetch_assoc($checkEvents)) {
            if($nowDate >= $rowEvents['event_start'] && $nowDate <= $rowEvents['event_end']) {
                $checkUsers = mysql_query("SELECT * FROM users WHERE user_privilege = '0' AND user_status = '1' AND user_city LIKE '%Москва%' AND user_country='Россия'");
                while ($rowUsers = mysql_fetch_assoc($checkUsers)) {
                    $ruffle_id = $rowEvents['event_id'];
                    $user_id = $rowUsers['user_id'];
                    $checkRequests = mysql_query("SELECT * FROM requests WHERE event_id='$ruffle_id' AND user_id='$user_id'");
                    if (!mysql_num_rows($checkRequests)) {
                        $bad_users[] = $user_id;
                    }
                }
            }
        }
        $bad_users = array_unique($bad_users);
        for ($i=0; $i<count($bad_users); $i+=1) {
            $user_id = $bad_users[$i];
            $checkUser =  mysql_query("SELECT * FROM users WHERE user_id = '$user_id'");
            $user_info = mysql_fetch_assoc($checkUser);
            if ($user_info['user_nick'] != '') {
                $user_label = $user_info['user_nick'];
            }
            else {
                $user_label = $user_info['user_name'];
            }
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers .= 'From: noreply@free-cheese.com' . "\r\n";
            $mailTo = $user_info['user_mail'];
            $subject = "Розыгрыши на free-cheese.com, успей подать заявку!";
            $message = '<p>Доброго времени суток, '.$user_label.', мы, коллектив Free-cheese.com, предлагаем Вам подать заявку в текущих розыгрышах! Поддержи наших на олимпиаде!</p>';
            $message .= '<p>В качесве приза для основного розыгрыша на этот раз выбран <b>Термос "Образ Игр"</b> и Вы можете увидеть его по <a href="http://free-cheese.com/mainRaffle?id=39">этой ссылке</a>, а по <a href="http://free-cheese.com/oneRaffle?id=40">этой</a> ссылке Вы попадете на дополнительный розыгрыш, призом которого является <b>Термокружка "Образ Игр"</b></p>';
            $message .= '<p>Спасибо, что Вы с нами, заходите на <a href="http://free-cheese.com/">Free-cheese.com</a>, участвуйте в розыгрышах и выигрывайте, бесплатный сыр только у нас.</p>';
            mail($mailTo,$subject,$message,$headers);
        }
    }
    //Это для рассылки просто всем
    /*$checkUsers = mysql_query("SELECT * FROM users WHERE user_status = '1'");
    if (mysql_num_rows($checkUsers)) {
        while ($user_info = mysql_fetch_assoc($checkUsers)) {
            if ($user_info['user_nick'] != '') {
                $user_label = $user_info['user_nick'];
            }
            else {
                $user_label = $user_info['user_name'];
            }
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers .= 'From: noreply@free-cheese.com' . "\r\n";
            $mailTo = $user_info['user_mail'];
            $subject = "Новый функционал на free-cheese.com";
            $message = '<p>Доброго времени суток, '.$user_label.', Free-cheese.com хочет уведомить Вас, что на нашем сайте будет изменена система определения победителя.</p>';
            $message .= '<p>Для каждого пользователя добавлен новый параметр <b>UR</b>, который значительно повышает Ваши шансы. Подробнее по <a href="http://free-cheese.com/oneArticle?id=33">этой ссылке</a>.</p>';
            $message .= '<p>Спасибо, что Вы с нами, заходите на Free-cheese.com, участвуйте в розыгрышах и выигрывайте, бесплатный сыр только у нас.</p>';
            mail($mailTo,$subject,$message,$headers);
        }
    }*/
}
?>
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
        <div class="colorHeader red">
            <h1>301 ошибка</h1>
        </div>
        <div class="aboutUs">
            <p>
                Видимо, когда-то тут действительно что-то было. Но теперь этого нет :(
            </p>
            <p>
                Попробуйте попытать счастья в другом месте!
                <?php
                echo ' Вы можете перейти на <a href="index">Главную</a>';
                if (isset($_SESSION['username']) == '') {
                    echo '.';
                }
                else {
                    echo ', либо перейти в свой <a href="user">Личный кабинет</a>';
                }
                ?>
            </p>
        </div>
    </div>
    <div class="footer">
        <!--your advert here-->
        <?php echo $footer ?>
    </div>
</div>
<?php echo $reminderBlock ?>
<script src="scripts/logForgot.js"></script>
<!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter22298638 = new Ya.Metrika({id:22298638, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/22298638" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-37499878-2', 'free-cheese.com');ga('send', 'pageview');</script>
</body>
</html>