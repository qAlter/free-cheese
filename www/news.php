<?php require_once ('phpscripts/server.php')?>
<!DOCTYPE html>
<html>
<head>
    <title>Новости free-cheese.com: все о призах, розыгрышах и новинках в мире гаджетов</title>
    <meta charset='utf-8'>
    <meta name="description" content="Последние новости из мира новых технологий и гаджетов от free-cheese.com">
    <meta name="keywords" content="технологии, гаджеты, новости о технологиях, наука, наука и технологии, apple, google, android, ios, последние новости, высокие технологии, призы, подарки">
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
            $limitOnPage = 8;
            $allNews = mysql_query("SELECT * FROM news WHERE news_start <= '$nowDateTime'");
            $news_length = mysql_num_rows($allNews);
            $allNews = ceil($news_length/$limitOnPage);
            if (isset($_GET['p']) && $_GET['p']>=0) {
                if ($_GET['p']>$allNews || $_GET['p']==0) {
                    header('location: news');
                    exit();
                }
                $start = ceil((int)$_GET['p']-1);
            }
            else {
                $start = 0;
            }
            $limitStart = $limitOnPage*$start;
            $checkNews = mysql_query("SELECT * FROM news WHERE news_start <= '$nowDateTime' ORDER BY news_start DESC LIMIT $limitStart, $limitOnPage");
            if (mysql_num_rows($checkNews)) {
                echo '
                <div class="colorHeader blueLight">
                    <h1>Все новости (всего: '.$news_length.')</h1>
                </div>
                <div class="newsBlock">
                ';
                while ($row = mysql_fetch_assoc($checkNews)) {
                    $user_id = $row['user_id'];
                    $checkUser = mysql_query("SELECT * FROM users WHERE user_id = '$user_id'");
                    $user_info = mysql_fetch_assoc($checkUser);
                    $news_href = "oneNews?id=".$row['news_id'];
                    $news_adr = "document.location.assign('".$news_href."')";
                    if ($user_info['user_nick'] != '') {
                        $user_label = $user_info['user_nick'];
                    }
                    else {
                        $user_label = $user_info['user_name'];
                    }
                    $news_date = date_create($row['news_start']);
                    $news_date = date_format($news_date, 'd.m.Y H:i:s');
                    $news_text = strip_tags($row['news_text']);
                    $news_text = substr($news_text, 0, 300);
                    echo '
                        <div class="news">
                            <div class="raffleTop blueLight">
                                <div class="raffleTopContent">
                                    <span class="raffleShortHeader"><a href="'.$news_href.'">'.$row["news_name"].'</a></span>
                                    <button onclick="'.$news_adr.'">Подробнее</button>
                                </div>
                            </div>
                            <a href="'.$news_href.'"><img src="'.$row['news_avatar'].'" alt="'.$row["news_name"].'"></a>
                            <span class="rafflePreview">'.$news_text.'</span>
                            <div class="raffleBottom blueLight">
                                <div class="raffleBottomContent">
                                    <span><a href="'.$news_href.'">Новость от '.$news_date.'</a> (<a href="user?id='.$user_info['user_id'].'">'.$user_label.'</a>)</span>
                                </div>
                            </div>
                        </div>
                    ';
                }
                echo '</div><div class="newsNavigator">';
                for ($i=0; $i<$allNews; $i+=1) {
                    if ($i == $start) {
                        $news_page = '<span>'.($i+1).'</span>';
                    }
                    else {
                        $news_page = '<a href="news?p='.($i+1).'">'.($i+1).'</a>';
                    }
                    if ($i != $allNews-1) {
                        $news_page = $news_page.'-';
                    }
                    echo $news_page;
                }
                echo '</div>';
            }
            else {
                echo '<span style="display: block; text-align: center; margin-bottom: 5px">В данный момент актуальных новостей нет</span>';
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