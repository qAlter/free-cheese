<?php require_once ('phpscripts/server.php');?>
<!DOCTYPE html>
<html>
<head>
    <title>Статьи free-cheese.com: подробно о технологиях и подарках</title>
    <meta charset='utf-8'>
    <meta name="description" content="Интересные статьи и анализы. Подробно о современных технологиях, фото и видео о новейших девайсах.">
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
                    </td>
					<?php echo $socialButton ?>
                </tr>
            </table>
        </div>
    </div>
    <div class="body">
        <?php
        $limitOnPage = 5;
        $allArticles = mysql_query("SELECT * FROM articles WHERE article_start <= '$nowDateTime'");
        $article_length = mysql_num_rows($allArticles);
        $allArticles = ceil($article_length/$limitOnPage);
        if (isset($_GET['p']) && $_GET['p']>=0) {
            if ($_GET['p']>$allArticles || $_GET['p']==0) {
                header('location: articles');
                exit();
            }
            $start = ceil((int)$_GET['p']-1);
        }
        else {
            $start = 0;
        }
        $limitStart = $limitOnPage*$start;
        $checkArticles = mysql_query("SELECT * FROM articles WHERE article_start <= '$nowDateTime' ORDER BY article_start DESC LIMIT $limitStart, $limitOnPage");
        if (mysql_num_rows($checkArticles)) {
            echo '
            <div class="colorHeader red">
                <h1>Все статьи (всего: '.$article_length.')</h1>
            </div>
            <div class="articlesBlock">
            ';
            while ($row = mysql_fetch_assoc($checkArticles)) {
                $user_id = $row['user_id'];
                $article_id = $row['article_id'];
                $checkAva = mysql_query("SELECT * FROM avatars WHERE avatar_place_id = '$article_id' AND avatar_place = 'article' ORDER BY avatar_id ASC");
                $ava_info = mysql_fetch_assoc($checkAva);
                $checkUser = mysql_query("SELECT * FROM users WHERE user_id = '$user_id'");
                $user_info = mysql_fetch_assoc($checkUser);
                $article_href = "oneArticle?id=".$row['article_id'];
                $article_adr = "document.location.assign('".$article_href."')";
                if ($user_info['user_nick'] != '') {
                    $user_label = $user_info['user_nick'];
                }
                else {
                    $user_label = $user_info['user_name'];
                }
                $article_date = date_create($row['article_start']);
                $article_date = date_format($article_date, 'd.m.Y H:i:s');
                $text = strip_tags($row['article_text'], '<h1><h2><h3><strong><b>');
                echo '
                        <div class="article">
                            <div class="raffleTop redLight">
                                <div class="raffleTopContent">
                                    <span><a href="'.$article_href.'">'.$row["article_name"].'</a></span>
                                    <button onclick="'.$article_adr.'">Подробнее</button>
                                </div>
                            </div>
                            <table>
                                <tr>
                                    <td>
                                        <a href="'.$article_href.'"><img src="'.$ava_info['avatar_url'].'" alt="'.$row["article_name"].'"></a>
                                    </td>
                                    <td>
                                        <span class="articlePreview">'.$text.'</span>
                                    </td>
                                </tr>
                            </table>
                            <div class="raffleBottom redLight">
                                <div class="raffleBottomContent">
                                    <span><a href="'.$article_href.'">Статья от '.$article_date.'</a> (<a href="user?id='.$user_info['user_id'].'">'.$user_label.'</a>)</span>
                                </div>
                            </div>
                        </div>
                    ';
            }
            echo '</div><div class="newsNavigator">';
            for ($i=0; $i<$allArticles; $i+=1) {
                if ($i == $start) {
                    $news_page = '<span>'.($i+1).'</span>';
                }
                else {
                    $news_page = '<a href="articles?p='.($i+1).'">'.($i+1).'</a>';
                }
                if ($i != $allArticles-1) {
                    $news_page = $news_page.'-';
                }
                echo $news_page;
            }
            echo '</div>';
        }
        else {
            echo '<span style="display: block; text-align: center; margin-bottom: 5px">Еще не добавлено ни одной статьи</span>';
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