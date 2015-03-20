<?php require_once ('phpscripts/server.php');?>
<!DOCTYPE html>
<html>
<head>
    <title>Ошибка | free-cheese.com</title>
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
                        </td>						<?php echo $socialButton ?>
                    </tr>
                </table>
            </div>
        </div>
        <div class="body">
            <div class="colorHeader yellow">
                <h1>Ошибочка вышла!</h1>
            </div>
            <div class="aboutUs">
                <p>
                    Вы не подтвердили свой E-mail. Проверьте Вашу почту, и перейдите по ссылке в письме. Если письмо еще не пришло,
                    то запаситесь терпением.
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