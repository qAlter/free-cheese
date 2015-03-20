<?php
require_once ('phpscripts/server.php');
if (isset($_SESSION['username']) != '') {
    header('location: index');
    exit();
}
require_once ('phpscripts/registerLogic.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Регистрация | free-cheese.com</title>
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
if (!empty($_POST)) {
    if ($error == '') {
        echo '<input type="hidden" value="true">';
	}
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
                        header('location: index');
                        exit();
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
                    </td>					<?php echo $socialButton ?>
                </tr>
            </table>
        </div>
    </div>
    <div class="body">
        <div class="colorHeader blue">
            <h1>Регистрация</h1>
        </div>
        <div class="aboutUs">
            <p>
                Доводим до Вашего сведения, что необходимо указывать реальную информацию. Профили с ложной информацией будут удалены.
            </p>
        </div>
        <div class="registration important">
            <h2>Данные для авторизации (обязательны)</h2>
            <table>
                <tr>
                    <td>E-mail</td>
                    <td><input type="email" value="<?php echo $user_mail ?>"></td>
                    <td class="error"><?php if ($error != '') { echo $error;} ?></td>
                </tr>
                <tr>
                    <td>Пароль</td>
                    <td><input type="password"></td>
                    <td class="error"></td>
                </tr>
                <tr>
                    <td>Повторите пароль</td>
                    <td><input type="password"></td>
                    <td class="error"></td>
                </tr>
            </table>
        </div>
        <div class="registration important">
            <h2>Данные для доставки (обязательно, т.к. местоположение будет учитываться при первых розыгрышах)</h2>
            <table>
                <tr>
                    <td>Имя</td>
                    <td><input type="text" value="<?php echo $user_name ?>"></td>
                    <td class="error"></td>
                </tr>
                <tr>
                    <td>Страна</td>
                    <td>
                        <select onchange="checkLocation(this)" name="userLocation">
                            <option value="0">Выберите страну...</option>
                            <option value="1">Россия</option>
                            <option value="2">Другая страна</option>
                        </select>
                        <input class="userLocation" type="text" disabled>
                    </td>
                    <td class="error"></td>
                </tr>
                <tr>
                    <td>Город</td>
                    <td>
                        <select onchange="checkLocation(this)" onclick="warning(this)" name="userLocation">
                            <option value="0">Выберите город...</option>
                            <option value="1">Москва</option>
                            <option value="2">Другой город</option>
                        </select>
                        <input class="userLocation" type="text" disabled>
                    </td>
                    <td class="error"></td>
                </tr>
                <tr>
                    <td>Телефон (желательно)</td>
                    <td><input type="tel" value="<?php echo $user_phone ?>"></td>
                    <td class="error"></td>
                </tr>
            </table>
        </div>
        <div class="registration">
            <h2>Данные для профиля (необязательно, можно добавить в личном кабинете позже)</h2>
            <table>
                <tr>
                    <td>Никнейм</td>
                    <td><input type="text" value="<?php echo $user_nick ?>"></td>
                    <td class="error"></td>
                </tr>
                <tr>
                    <td>Аватар</td>
                    <td><input type="text" placeholder="URL" value="<?php echo $user_avatar ?>"></td>
                </tr>
            </table>
        </div>
        <button class="inviteButton registrationButton" onclick="reg(this)">Зарегистрироваться</button>
    </div>
    <div class="footer">
        <!--your advert here-->
        <?php echo $footer ?>
    </div>
</div>
<script src="scripts/logForgot.js"></script>
<script src="scripts/reg.js"></script>
<!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter22298638 = new Ya.Metrika({id:22298638, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/22298638" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-37499878-2', 'free-cheese.com');ga('send', 'pageview');</script>
</body>
</html>