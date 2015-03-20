<?php require_once ('phpscripts/server.php');?>
<!DOCTYPE html>
<html>
<head>
    <title>Победители, которые получили свои призы совершенно бесплатно | Победители free-cheese.com</title>
    <meta charset='utf-8'>
    <meta name="description" content="Пользователи, подавшие заявку на розыгрыш и получившие свой приз от Free-cheese.com.">
    <meta name="Keywords" content="победа, winner, получивший приз, приз, призы, подарки, розыгрыш, розыгрыши, победитель, подарок, подарки, выиграть, выигрывать, разыгрывается приз, бесплатно, совершенно бесплатно, в подарок">
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
                        </td>						<?php echo $socialButton ?>
                    </tr>
                </table>
            </div>
        </div>
        <div class="body">
            <div class="colorHeader blueLight">
                <h1>Победители</h1>
            </div>
            <div class="aboutUs">
                <table class="tableRaffles">
                    <thead>
                        <tr>
                            <td colspan="5">Завершенные розыгрыши</td>
                        </tr>
                        <tr>
                            <td>Тип розыгрыша</td>
                            <td>Название розыгрыша</td>
                            <td>Победитель</td>
                            <td>Дата розыгрыша</td>
                            <td>В розыгрыше участвовало</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $checkWinners = mysql_query("SELECT * FROM winners ORDER BY winner_date DESC, winner_id");
                    if (mysql_num_rows($checkWinners)) {
                        while ($row = mysql_fetch_assoc($checkWinners)) {
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
                            }
                            else {
                                $user_label = $user_id;
                            }
                            $event_id = $row['event_id'];
                            $checkEvent = mysql_query("SELECT * FROM events WHERE event_id = '$event_id'");
                            $event_info = mysql_fetch_assoc($checkEvent);
                            if ($event_info['event_type'] == '1') {
                                $event_label = 'Основной розыгрыш';
                                $event_href = "mainRaffle?id=".$event_id;
                            }
                            else {
                                $event_label = 'Дополнительный розыгрыш';
                                $event_href = "oneRaffle?id=".$event_id;
                            }
                            $winner_date = date_create($row['winner_date']);
                            $winner_date = date_format($winner_date, 'd.m.Y');
                            echo '
                                <tr>
                                    <td>'.$event_label.'</td>
                                    <td><a href="'.$event_href.'">'.$event_info['event_name'].'</a></td>
                                    <td><a href="user?id='.$user_id.'">'.$user_label.'</a></td>
                                    <td>'.$winner_date.'</td>
                                    <td>'.$event_info['event_member'].'</td>
                                </tr>
                            ';
                        }
                    }
                    else {
                        echo '<tr><td colspan="5">Нет завершенных розыгрышей</td></tr>';
                    }
                    ?>
                    </tbody>
                    <tr><td colspan="5">&nbsp;</td></tr>
                    <thead>
                    <tr>
                        <td colspan="5">Текущие розыгрыши</td>
                    </tr>
                    <tr>
                        <td>Тип розыгрыша</td>
                        <td colspan="2">Название розыгрыша</td>
                        <td>Дата окончания</td>
                        <td>Заявок подано</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $checkRaffles = mysql_query("SELECT * FROM events WHERE event_end >= '$nowDate' AND event_start <= '$nowDate' ORDER BY event_start ASC, event_type DESC");
                    if (mysql_num_rows($checkRaffles)) {
                        while ($row = mysql_fetch_assoc($checkRaffles)) {
                            if ($row['event_type'] == 1) {
                                $event_type = 'Основной розыгрыш';
                                $event_adr = 'mainRaffle';
                            }
                            else {
                                $event_type = 'Дополнительный розыгрыш';
                                $event_adr = 'oneRaffle';
                            }
                            $winner_date = date_create($row['event_end']);
                            $winner_date = date_format($winner_date, 'd.m.Y');
                            echo '
                                <tr>
                                    <td>'.$event_type.'</td>
                                    <td colspan="2"><a href="'.$event_adr.'?id='.$row['event_id'].'">'.$row['event_name'].'</td>
                                    <td>'.$winner_date.'</td>
                                    <td>'.$row['event_member'].'</td>
                                </tr>
                            ';
                        }
                    }
                    else {
                        echo '<tr><td></td><td colspan="2">Нет текущих розыгрышей</td><td colspan="2"></td></tr>';
                    }
                    ?>
                    </tbody>
                    <tr><td colspan="5">&nbsp;</td></tr>
                    <thead>
                    <tr>
                        <td colspan="5">Предстоящие розыгрыши</td>
                    </tr>
                    <tr>
                        <td>Тип розыгрыша</td>
                        <td colspan="2">Название розыгрыша</td>
                        <td>Дата начала</td>
                        <td>Дата окончания</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $checkRaffles = mysql_query("SELECT * FROM events WHERE event_start > '$nowDate' ORDER BY event_start ASC , event_type DESC");
                    if (mysql_num_rows($checkRaffles)) {
                        while ($row = mysql_fetch_assoc($checkRaffles)) {
                            if ($row['event_type'] == 1) {
                                $event_type = 'Основной розыгрыш';
                                $event_adr = 'mainRaffle';
                            }
                            else {
                                $event_type = 'Дополнительный розыгрыш';
                                $event_adr = 'oneRaffle';
                            }
                            $winner_date = date_create($row['event_start']);
                            $winner_date = date_format($winner_date, 'd.m.Y');
                            $end_date = date_create($row['event_end']);
                            $end_date = date_format($end_date, 'd.m.Y');
                            if ($real_user_info['user_privilege'] == '1' || $real_user_info['user_privilege'] == '2') {
                                $event_href = '<a href="'.$event_adr.'?id='.$row['event_id'].'">'.$row['event_name'].'</a>';
                            }
                            else {
                                $event_href = $row['event_name'];
                            }
                            echo '
                                <tr>
                                    <td>'.$event_type.'</td>
                                    <td colspan="2">'.$event_href.'</td>
                                    <td>'.$winner_date.'</td>
                                    <td>'.$end_date.'</td>
                                </tr>
                            ';
                        }
                    }
                    else {
                        echo '<tr><td></td><td colspan="2">Предстоящие розыгрыши скоро будут объявлены</td><td colspan="2"></td></tr>';
                    }
                    ?>
                    </tbody>
                </table>
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