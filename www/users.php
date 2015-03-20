<?php require_once ('phpscripts/server.php');?>
<!DOCTYPE html>
<html>
<head>
    <title>Пользователи | free-cheese.com</title>
    <meta charset='utf-8'>
    <meta name="description" content="История создания free-cheese.com, узнайте историю сайта о розыгрышах и технологиях с самого начала.">
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
            <?php
            if ($user_info['user_privilege'] == 1) {
                $checkUsers = mysql_query("SELECT * FROM users WHERE user_id != '0' ORDER BY user_id DESC");
            }
            else {
                $checkUsers = mysql_query("SELECT * FROM users WHERE user_id != '0' AND user_status = '1' ORDER BY user_id DESC");
            }
            if (mysql_num_rows($checkUsers)) {
                echo '
            <div class="colorHeader yellow">
                <h1>Пользователи (всего: '.mysql_num_rows($checkUsers).')</h1>
            </div>
            <div class="usersBlock">
                ';
                while ($row = mysql_fetch_assoc($checkUsers)) {
                    if ($row['user_nick'] != '') {
                        $user_label = $row['user_nick'];
                    }
                    else {
                        $user_label = $row['user_name'];
                    }
                    if ($row['user_avatar'] == '') {
                        $user_ava = 'images/avatar.png';
                    }
                    else {
                        $user_ava = $row['user_avatar'];
                    }
                    $nowDateTime = date('Y-m-d H:i:s', time() + ($hoursDiff*3600 - 1200));
                    if ($row['user_login'] != '0000-00-00 00:00:00') {
                        if ($nowDateTime <= $row['user_login']) {
                            $user_online = 'style="border: 4px solid green"';
                        }
                        else {
                            $user_online = '';
                        }
                    }
                    else {
                        $user_online = 'style="border: 4px solid #ccc"';
                    }
                    $user_href = 'user?id='.$row['user_id'];
                    if ($row['user_status'] == 1) {
                        if ($row['user_rank'] == '1') {
                            $rank_color = 'style="background-color: gray"';
                        }
                        else {
                            $rank_color = '';
                        }
                        $rank = number_format($row['user_rank'], 1, '.', '');
                        $rank = '<div class="userRank userRankAll" '.$rank_color.'>'.$rank.'</div>';
                    }
                    else {
                        $rank = '';
                    }
                    echo '
                        <div class="oneUser">
                            <div class="oneUserAva" '.$user_online.'><a href="'.$user_href.'"><img src="'.$user_ava.'"></a>'.$rank.'</div>
                            <span><a href="'.$user_href.'">'.$user_label.'</a></span>
                        </div>
                    ';
                }
            echo '</div>';
            }
            else {
                echo '<span style="display: block; text-align: center; margin-bottom: 5px">В системе не зарегистрировано ни одного пользователя О_О</span>';
            }
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