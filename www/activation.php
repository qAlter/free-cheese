<?php
require_once ('phpscripts/server.php');
if (isset($_GET['user'])) {
    $hash = $_GET['user'];
    $checkUser = mysql_query("SELECT * FROM users WHERE user_hash = '$hash'");
    if(mysql_num_rows($checkUser)) {
        $user_info = mysql_fetch_assoc($checkUser);
        $user_mail = $user_info['user_mail'];
        $secret = 'мидихлорианы';
        if ($hash == md5($user_mail.$secret)) {
            $user_id = $user_info['user_id'];
            mysql_query("UPDATE users SET user_hash='0' WHERE user_id = '$user_id'");
            mysql_query("UPDATE users SET user_status='1' WHERE user_id = '$user_id'");
            $_SESSION['username'] = $user_info['user_name'];
            $_SESSION['usermail'] = $user_info['user_mail'];
            header('location: user?act=true');
            exit();
        }
        else {
            echo '2';
            $_SESSION['server_answer'] = '<input type="hidden" name="activ" value="false">';
        }
    }
    else {
        header('location: index');
        exit();
    }
}
else if (isset($_GET['again'])) {
    $act = $_GET['again'];
    if ($act == true) {
        if (isset($_SESSION['usermail'])) {
            $user_mail = $_SESSION['usermail'];
            $checkUser = mysql_query("SELECT * FROM users WHERE user_mail = '$user_mail'");
            if (mysql_num_rows($checkUser)) {
                $user_info = mysql_fetch_assoc($checkUser);
		        $user_mail = $user_info['user_mail'];
                $secret = 'мидихлорианы';
                $hash = md5($user_mail.$secret);
                mysql_query("UPDATE users SET user_hash='$hash' WHERE user_mail = '$user_mail'");
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $headers .= 'From: noreply@free-cheese.com' . "\r\n";
                $mailTo = $user_mail;
                $subject = "Повторное подтверждение регистарции на сайте";
                $message = 'Для активации аккаунта пройдите по ссылке <a href="http://free-cheese.com/activation?user='.$hash.'" target="_blank">http://free-cheese.com/activation?user='.$hash.'</a>. <br>';
                $message .= 'Или просто скопируйте ссылку "http://free-cheese.com/activation?user='.$hash.'" в окно ввода адреса браузера и нажмите enter';
                mail($mailTo,$subject,$message,$headers);
                $_SESSION['server_answer'] = '<input type="hidden" name="activ" value="true">';
            }
        }
    }
}
else {
    header('location: index');
    exit();
}
$server_answer = $_SESSION['server_answer'];
?>
<html>
<head>
    <meta charset='utf-8'>
    <title>free-cheese.com: Активация</title>
    <link href="style/cheese.css" rel="stylesheet">
    <link href="style/animate.css" rel="stylesheet">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <script src="scripts/onReady.js"></script>
    <script src="scripts/preview.js"></script>
    <script src="scripts/messages.js"></script>
    <style>
        body {
            background-image: url('images/cheese.svg');
            background-position: 50% 50%;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body>
<?php echo $server_answer; $_SESSION['server_answer'] = '' ?>
<!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter22298638 = new Ya.Metrika({id:22298638, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/22298638" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-37499878-2', 'free-cheese.com');ga('send', 'pageview');</script>
</body>
</html>