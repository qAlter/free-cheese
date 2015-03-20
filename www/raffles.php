<?php require_once ('phpscripts/server.php');?>
<!DOCTYPE html>
<html>
<head>
    <title>Розыгрыши free-cheese.com: главные призы и дополнительные розыгрыши</title>
    <meta charset='utf-8'>
    <meta name="description" content="Розыгыши, подарки, призы, совершенно бесплатно. Нужно только подать заявку.">
    <meta name="keywords" content="Розыгрыши, призы, приз, бесплатно, подарок, подарки, фричиз, бесплатный сыр, халява, розыгрыш, рызыгрываем, подарочный, подарить">
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
                            }                            ?>
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
            <div class="colorHeader green">
                <h1>Действующие розыгрыши</h1>
            </div>
            <?php
            $checkEvents = mysql_query("SELECT * FROM events");
            $raffle_error = '';
            $thisIsIt = '';
            if (mysql_num_rows($checkEvents)) {
                $checkMain = mysql_query("SELECT * FROM events WHERE event_type = '1'");
                if (mysql_num_rows($checkMain)) {
                    while ($row = mysql_fetch_assoc($checkMain)) {
                        if($nowDate >= $row['event_start'] && $nowDate <= $row['event_end']) {
                            $raffle_error = '';
                            $thisIsIt = true;
                            $ruffle_id = $row['event_id'];
                            $raffle_href = "mainRaffle?id=".$ruffle_id;
                            $ruffle_adr = "document.location.assign('".$raffle_href."')";
                            $ruffle_img = $row['event_avatar'];
                            $ruffle_name = $row['event_name'];
                            $ruffle_text = $row['event_text'];
                            echo '<div class="mainRaffle">
                                        <div class="raffleTop">
                                            <div class="raffleTopContent">
                                                <span><a href="'.$raffle_href.'">Основной розыгрыш</a></span>
                                                <button onclick="'.$ruffle_adr.'">Подробнее</button>
                                            </div>
                                        </div>
                                        <a href="'.$raffle_href.'"><img src="'.$ruffle_img.'" alt="Основной розыгрыш"></a>
                                        <span class="rafflePreview">'.$ruffle_text.'</span>
                                        <div class="raffleBottom">
                                            <div class="raffleBottomContent">
                                                <span><a href="'.$raffle_href.'">'.$ruffle_name.'</a></span>
                                            </div>
                                        </div>
                                    </div>';
                        }
                        else {
                            if (!$thisIsIt)
                            $raffle_error = '<span style="display: block; text-align: center; margin-bottom: 5px">В данный момент розыгрыши не проводятся</span>';
                        }
                    }
                }
                $checkOther = mysql_query("SELECT * FROM events WHERE event_type = '0'");
                if (mysql_num_rows($checkOther)) {
                    while ($row = mysql_fetch_assoc($checkOther)) {
                        if($nowDate >= $row['event_start'] && $nowDate <= $row['event_end']) {
                            $raffle_error = '';
                            $ruffle_id = $row['event_id'];
                            $raffle_href = "oneRaffle?id=".$ruffle_id;
                            $ruffle_adr = "document.location.assign('".$raffle_href."')";
                            $ruffle_img = $row['event_avatar'];
                            $ruffle_name = $row['event_name'];
                            $ruffle_text = $row['event_text'];
                            echo '<div class="mainRaffle">
                                        <div class="raffleTop green">
                                            <div class="raffleTopContent">
                                                <span><a href="'.$raffle_href.'">Дополнительный розыгрыш</a></span>
                                                <button onclick="'.$ruffle_adr.'">Подробнее</button>
                                            </div>
                                        </div>
                                        <a href="'.$raffle_href.'"><img src="'.$ruffle_img.'" alt="Дополнительный розыгрыш"></a>
                                        <span class="rafflePreview">'.$ruffle_text.'</span>
                                        <div class="raffleBottom green">
                                            <div class="raffleBottomContent">
                                                <span><a href="'.$raffle_href.'">'.$ruffle_name.'</a></span>
                                            </div>
                                        </div>
                                    </div>';
                        }
                    }
                }
            }
            if (!mysql_num_rows($checkEvents) && !mysql_num_rows($checkOther)) {
                echo '<span style="display: block;text-align: center;">В данный момент розыгрыши не проводятся</span>';
            }
            $checkRaffles = mysql_query("SELECT * FROM events WHERE event_end < '$nowDate' ORDER BY event_start DESC, event_type DESC");
            if (mysql_num_rows($checkRaffles)) {
                echo '<div style="margin-top: 20px" class="colorHeader greenLight"><h1>Завершенные розыгрыши</h1></div>';
                while ($row = mysql_fetch_assoc($checkRaffles)) {
                    $ruffle_id = $row['event_id'];
                    $ruffle_adr = "document.location.assign('".$raffle_href."')";
                    $ruffle_img = $row['event_avatar'];
                    $ruffle_name = $row['event_name'];
                    $ruffle_text = $row['event_text'];
                    if ($row['event_type'] == '1') {
                        $raffle_type = 'Основной розыгрыш';
                        $raffle_color = '';
                        $raffle_href = "mainRaffle?id=".$ruffle_id;
                    }
                    else {
                        $raffle_type = 'Дополнительный розыгрыш';
                        $raffle_color = 'greenLight';
                        $raffle_href = "oneRaffle?id=".$ruffle_id;
                    }
                    echo '<div class="news">
                                        <div class="raffleTop '.$raffle_color.'">
                                            <div class="raffleTopContent">
                                                <span><a href="'.$raffle_href.'">'.$raffle_type.'</a></span>
                                                <button onclick="'.$ruffle_adr.'">Подробнее</button>
                                            </div>
                                        </div>
                                        <a href="'.$raffle_href.'"><img src="'.$ruffle_img.'" alt="'.$raffle_type.'"></a>
                                        <span class="rafflePreview">'.$ruffle_text.'</span>
                                        <div class="raffleBottom '.$raffle_color.'">
                                            <div class="raffleBottomContent">
                                                <span><a href="'.$raffle_href.'">'.$ruffle_name.'</a></span>
                                            </div>
                                        </div>
                                    </div>';
                }
            }
            echo $raffle_error;
            ?>
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