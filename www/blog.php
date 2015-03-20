<?php require_once ('phpscripts/server.php');?>
<!DOCTYPE html>
<html>
<head>
    <title>Блог | free-cheese.com</title>
    <meta charset='utf-8'>
    <meta name="description" content="История создания free-cheese.com, узнайте историю сайта о розыгрышах и технологиях с самого начала.">
    <meta name="keywords" content="Розыгрыши, призы, приз, бесплатно, подарок, подарки, фричиз, бесплатный сыр, халява, розыгрыш, рызыгрываем, подарочный, подарить, новости, технологии, гаджеты, freecheese">
    <link href="style/cheese.css" rel="stylesheet">
    <link href="style/animate.css" rel="stylesheet">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <script src="scripts/onReady.js"></script>
    <script src="scripts/preview.js"></script>
    <script src="scripts/messages.js"></script>
    <script src="scripts/blog.js"></script>
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
            <div class="colorHeader red">
                <h1>Блог</h1>
            </div>
            <div class="aboutUs blog">
                <?php
                $checkPosts = mysql_query("SELECT * FROM posts ORDER BY post_date DESC");
                if (!mysql_num_rows($checkPosts)) {
                    echo '<p>В блоге нет ни одной записи</p>';
                }
                else {
                    while ($row = mysql_fetch_assoc($checkPosts)) {
                        $user_id = $row['user_id'];
                        $user_adr = 'user?id='.$user_id;
                        $checkUser = mysql_query("SELECT * FROM users WHERE user_id = '$user_id'");
                        if (mysql_num_rows($checkUser)) {
                            $user_info = mysql_fetch_assoc($checkUser);
                            if ($user_info['user_nick'] != '') {
                                $user_label = $user_info['user_nick'];
                            }
                            else {
                                $user_label = $user_info['user_name'];
                            }
                            $post_date = date_create($row['post_date']);
                            $post_date = date_format($post_date, 'd.m.Y H:i:s');
                            echo '
                                <span>
                                    <p class="blogHeader blue"><b>Запись от '.$post_date.' (<a href="'.$user_adr.'">'.$user_label.'</a>)</b></p>'.$row['post_text'].'
                                </span>
                            ';
                        }
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
<script src="scripts/logForgot.js"></script>
<!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter22298638 = new Ya.Metrika({id:22298638, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/22298638" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-37499878-2', 'free-cheese.com');ga('send', 'pageview');</script>
</body>
</html>