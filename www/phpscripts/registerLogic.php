<?php
//ну, блять, неужели не понятно, что именно делает этот файл?! серьезно?! и даже идей нет?!
if (isset($_POST['0'])) {
    $user_mail = $_POST['0'];
    $user_mail = addslashes(htmlspecialchars($user_mail, ENT_QUOTES));
    $user_pass = $_POST['1'];
    $user_pass = addslashes(htmlspecialchars($user_pass, ENT_QUOTES));
    $user_pass_again = $_POST['2'];
    $user_pass_again = addslashes(htmlspecialchars($user_pass_again, ENT_QUOTES));
    $user_name = $_POST['3'];
    $user_name = addslashes(htmlspecialchars($user_name, ENT_QUOTES));
    $user_country = $_POST['4'];
    $user_country = addslashes(htmlspecialchars($user_country, ENT_QUOTES));
    $user_city = $_POST['5'];
    $user_city = addslashes(htmlspecialchars($user_city, ENT_QUOTES));
    $user_phone = $_POST['6'];
    $user_phone = addslashes(htmlspecialchars($user_phone, ENT_QUOTES));
    $user_nick = $_POST['7'];
    $user_nick = addslashes(htmlspecialchars($user_nick, ENT_QUOTES));
    $user_avatar = $_POST['8'];
    $user_avatar = addslashes(htmlspecialchars($user_avatar, ENT_QUOTES));
    $error = '';
    if ($user_mail != '' && $user_pass != '' && $user_pass_again != '' && $user_name != '' && $user_country != '' && $user_city != '') {
        if ($user_pass == $user_pass_again) {
            mysql_connect($host, $log, $pas);
            mysql_select_db($base);
            if (preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $user_mail)) {
                $checkMail = mysql_query("SELECT * FROM users WHERE user_mail = '$user_mail'");
                if (!mysql_num_rows($checkMail)) {
                    $checkMail = mysql_fetch_assoc($checkMail);
                    $hash = md5($user_mail.$secret);
                    $new_user = mysql_query("INSERT into users values (0, '$user_mail', '$user_pass', '$user_name', '$user_country', '$user_city', '$user_phone', '$user_nick', '', '', '$hash', 0, 0, 1, '0000-00-00 00:00:00')");
                    if ($new_user) {
                        if ($user_avatar != '') {
                            $last_id = mysql_insert_id();
                            $link = $user_avatar;
                            $file = file_get_contents($link);
                            file_put_contents($last_id.".jpg", $file);
                            rename('/home/u523996525/public_html/'.$last_id.'.jpg', '/home/u523996525/public_html/images/users/'.$last_id.'.jpg');
                            $new_user_ava = '/images/users/'.$last_id.'.jpg';
                            mysql_query("UPDATE users SET user_avatar='$new_user_ava' WHERE user_id = '$last_id'");
                        }
                        $headers = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                        $headers .= 'From: noreply@free-cheese.com' . "\r\n";
                        $mailTo = $user_mail;
                        $subject = "Подтверждение регистарции на сайте";
                        $message = 'Для активации аккаунта пройдите по ссылке <a href="http://free-cheese.com/activation?user='.$hash.'" target="_blank">http://free-cheese.com/activation?user='.$hash.'</a>. <br>';
                        $message .= 'Или просто скопируйте ссылку "http://free-cheese.com/activation?user='.$hash.'" в окно ввода адреса браузера и нажмите enter';
                        mail($mailTo,$subject,$message,$headers);
                    }
                }
                else {
                    $error = 'Этот E-mail уже занят';
                }
            }
            else {
                $error = 'Не похоже на E-mail';
            }
        }
    }
}