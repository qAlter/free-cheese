<?php
//короче, тут около 400 строк неоптимизированного дерьма, однако благодаря этому страница ЛК вроде как работает
if (!$_SESSION['username'] && $_GET['id'] == '') {
    header('location: index');
    exit();
}
else {
    $user_page = true;
    $user_mail = $_SESSION['usermail'];
    mysql_connect($host, $log, $pas);
    mysql_select_db($base);
    $checkUser = mysql_query("SELECT * FROM users WHERE user_mail = '$user_mail'");
    $user_info = mysql_fetch_assoc($checkUser);
    if ($user_info['user_privilege'] == '1') {
        if (isset($_POST['userPrivilegeAdmin'])) {
            $user_privilege = $_POST['userPrivilegeAdmin'];
            $user_id = $_POST['userIdAdmin'];
            mysql_query("UPDATE users SET user_privilege='$user_privilege' WHERE user_id = '$user_id'");
            $_SESSION['server_answer'] = '<input type="hidden" name="userDo" value="true">';
            header('location: '.$location);
            exit;
        }
        else if (isset($_POST['userIdAdminDelete'])) {
            $user_id = $_POST['userIdAdminDelete'];
            $checkRequests = mysql_query("SELECT * FROM requests WHERE user_id = '$user_id'");
            if (mysql_num_rows($checkRequests)) {
                while ($row = mysql_fetch_assoc($checkRequests)) {
                    $event_id = $row['event_id'];
                    $checkEvent = mysql_query("SELECT * FROM events WHERE event_id = '$event_id'");
                    if (mysql_num_rows($checkEvent)) {
                        $event_info = mysql_fetch_assoc($checkEvent);
                        $event_member = $event_info['event_member'];
                        $event_member = $event_member-1;
                        mysql_query("UPDATE events SET event_member='$event_member' WHERE event_id = '$event_id'");
                    }
                }
                mysql_query("DELETE FROM requests WHERE user_id = '$user_id'");
            }
            mysql_query("DELETE FROM users WHERE user_id = '$user_id'");
            $path = '/home/u523996525/public_html/images/users/'.$user_id.'.jpg';
            if (file_exists($path)) {
                unlink($path);
            }
            $_SESSION['server_answer'] = '<input type="hidden" name="userDo" value="false">';
            header('location: '.$location);
            exit;
        }
    }
    if ($user_info['user_privilege'] == '2') {
        if (isset($_POST['userPrivilege'])) {
            $user_privilege = $_POST['userPrivilege'];
            if ($user_privilege == '1' || $user_privilege == '2') {
                $user_privilege = '3';
                $moder_id = $user_info['user_id'];
                mysql_query("UPDATE users SET user_privilege='4' WHERE user_id = '$moder_id'");
                $user_id = $_POST['userId'];
                mysql_query("UPDATE users SET user_privilege='$user_privilege' WHERE user_id = '$user_id'");
                $_SESSION['server_answer'] = '<input type="hidden" name="userModDo" value="false">';
                header('location: '.$location);
                exit;
            }
            else {
                $user_id = $_POST['userId'];
                mysql_query("UPDATE users SET user_privilege='$user_privilege' WHERE user_id = '$user_id'");
                $_SESSION['server_answer'] = '<input type="hidden" name="userModDo" value="true">';
                header('location: '.$location);
                exit;
            }
        }
    }
    if ($user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2') {
        $checkEvents = mysql_query("SELECT * FROM events");
        if (isset($_POST['oldEventType'])) {
            $event_id = $_POST['oldEventId'];
            $event_type = $_POST['oldEventType'];
            $event_name = $_POST['oldEventName'];
            $event_text = $_POST['oldEventText'];
            $event_start = $_POST['oldEventStart'];
            $event_end = $_POST['oldEventEnd'];
            $checkEvent = mysql_query("SELECT * FROM events WHERE event_id = '$event_id'");
            $event_info = mysql_fetch_assoc($checkEvent);
            if ($_POST['oldEventAva'] == '') {
                $event_ava = $event_info['event_avatar'];
            }
            else {
                $link = $_POST['oldEventAva'];
                $header = @get_headers($link);
                if (preg_match('|image|', $header['3'])) {
                    $file = file_get_contents($link);
                    file_put_contents('raffle'.$event_id.".jpg", $file);
                    rename('/home/u523996525/public_html/raffle'.$event_id.'.jpg', '/home/u523996525/public_html/images/raffles/'.$event_id.'.jpg');
                    $event_ava = '/images/raffles/'.$event_id.'.jpg';
                }
                else {
                    $event_ava = $event_info['event_avatar'];
                }
            }
            mysql_query("UPDATE events SET event_type='$event_type' WHERE event_id = '$event_id'");
            mysql_query("UPDATE events SET event_name='$event_name' WHERE event_id = '$event_id'");
            mysql_query("UPDATE events SET event_text='$event_text' WHERE event_id = '$event_id'");
            mysql_query("UPDATE events SET event_avatar='$event_ava' WHERE event_id = '$event_id'");
            mysql_query("UPDATE events SET event_start='$event_start' WHERE event_id = '$event_id'");
            mysql_query("UPDATE events SET event_end='$event_end' WHERE event_id = '$event_id'");
            $_SESSION['server_answer'] = '<input type="hidden" name="eventChange" value="true">';
            header('location: '.$location);
            exit;
        }
        else if (isset($_POST['eventType'])) {
            $event_type = $_POST['eventType'];
            $event_name = $_POST['eventName'];
            $event_text = $_POST['eventText'];
            $event_ava = $_POST['eventAva'];
            $event_start = $_POST['eventStart'];
            $event_end = $_POST['eventEnd'];
            if ($event_type != '' && $event_name != '' && $event_text != '' && $event_ava != '' && $event_start != '' && $event_end != '') {
                mysql_query("INSERT into events values (0, '$event_name', '$event_text', '', '$event_start', '$event_end', '0', '$event_type', '0')");
                $event_id = mysql_insert_id();
                $link = $event_ava;
                $header = @get_headers($link);
                if (preg_match('|image|', $header['3'])) {
                    $file = file_get_contents($link);
                    file_put_contents('raffle'.$event_id.".jpg", $file);
                    rename('/home/u523996525/public_html/raffle'.$event_id.'.jpg', '/home/u523996525/public_html/images/raffles/'.$event_id.'.jpg');
                    $event_ava = '/images/raffles/'.$event_id.'.jpg';
                    mysql_query("UPDATE events SET event_avatar='$event_ava' WHERE event_id = '$event_id'");
                    $_SESSION['server_answer'] = '<input type="hidden" name="eventCreate" value="true">';
                    header('location: '.$location);
                    exit;
                }
                else {
                    $_SESSION['server_answer'] = '<input type="hidden" name="eventCreate" value="false">';
                    header('location: '.$location);
                    exit;
                }
            }
            else {
                $_SESSION['server_answer'] = '<input type="hidden" name="eventCreate" value="false">';
                header('location: '.$location);
                exit;
            }
        }
        else if (isset($_POST['deleteEvent'])) {
            $event_id = $_POST['deleteEvent'];
            mysql_query("DELETE FROM events WHERE event_id = '$event_id'");
            $path = '/home/u523996525/public_html/images/raffles/'.$event_id.'.jpg';
            if (file_exists($path)) {
                unlink($path);
            }
            $_SESSION['server_answer'] = '<input type="hidden" name="eventDelete" value="true">';
            header('location: '.$location);
            exit;
        }
        if (isset($_POST['oldPostChange'])) {
            $post_text = $_POST['oldPostChange'];
            $post_id = $_POST['oldPostId'];
            $post_time = $nowDateTime;
            mysql_query("UPDATE posts SET post_text='$post_text' WHERE post_id = '$post_id'");
            mysql_query("UPDATE posts SET post_date='$post_time' WHERE post_id = '$post_id'");
            $_SESSION['server_answer'] = '<input type="hidden" name="postChange" value="true">';
            header('location: '.$location);
            exit;
        }
        else if (isset($_POST['postText'])) {
            $post_text = $_POST['postText'];
            $user_id = $user_info['user_id'];
            $post_time = $nowDateTime;
            if ($post_text != '') {
                mysql_query("INSERT into posts values (0, '$user_id', '$post_time', '$post_text')");
                $_SESSION['server_answer'] = '<input type="hidden" name="postCreate" value="true">';
                header('location: '.$location);
                exit;
            }
            else {
                $_SESSION['server_answer'] = '<input type="hidden" name="postCreate" value="false">';
                header('location: '.$location);
                exit;
            }
        }
        else if (isset($_POST['deletePost'])) {
            $event_id = $_POST['deletePost'];
            mysql_query("DELETE FROM posts WHERE post_id = '$event_id'");
            $_SESSION['server_answer'] = '<input type="hidden" name="postDelete" value="true">';
            header('location: '.$location);
            exit;
        }
    }
    if ($user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2' || $user_info['user_privilege'] == '3') {
        $checkNews = mysql_query("SELECT * FROM news");
        if (isset($_POST['oldNewsName'])) {
            $news_id = $_POST['oldNewsId'];
            $news_name = $_POST['oldNewsName'];
            $news_text = $_POST['oldNewsText'];
            $news_start = $_POST['oldNewsStart'];
            $news_end = $_POST['oldNewsEnd'];
            $checkNews = mysql_query("SELECT * FROM news WHERE news_id = '$news_id'");
            $news_info = mysql_fetch_assoc($checkNews);
            $user_id = $user_info['user_id'];
            if ($_POST['oldNewsAva'] == '') {
                $news_ava = $news_info['news_avatar'];
            }
            else {
                $link = $_POST['oldNewsAva'];
                $header = @get_headers($link);
                if (preg_match('|image|', $header['3'])) {
                    $file = file_get_contents($link);
                    file_put_contents('news'.$news_id.".jpg", $file);
                    rename('/home/u523996525/public_html/news'.$news_id.'.jpg', '/home/u523996525/public_html/images/news/'.$news_id.'.jpg');
                    $news_ava = '/images/news/'.$news_id.'.jpg';
                }
                else {
                    $news_ava = '/images/news.jpg';
                }
            }
            mysql_query("UPDATE news SET news_name='$news_name' WHERE news_id = '$news_id'");
            mysql_query("UPDATE news SET user_id='$user_id' WHERE news_id = '$news_id'");
            mysql_query("UPDATE news SET news_text='$news_text' WHERE news_id = '$news_id'");
            mysql_query("UPDATE news SET news_avatar='$news_ava' WHERE news_id = '$news_id'");
            mysql_query("UPDATE news SET news_start='$news_start' WHERE news_id = '$news_id'");
            mysql_query("UPDATE news SET news_end='$news_end' WHERE news_id = '$news_id'");
            $_SESSION['server_answer'] = '<input type="hidden" name="newsChange" value="true">';
            header('location: '.$location);
            exit;
        }
        else if (isset($_POST['newsName'])) {
            $news_name = $_POST['newsName'];
            $news_text = $_POST['newsText'];
            $news_ava = $_POST['newsAva'];
            $news_start = $_POST['newsStart'];
            $news_end = $_POST['newsEnd'];
            $user_id = $user_info['user_id'];
            if ($news_name != '' && $news_text != '' && $news_start != '' && $news_end != '') {
                mysql_query("INSERT into news values (0, '$user_id',  '$news_name', '$news_text', '', '$news_start', '$news_end')");
                $news_id = mysql_insert_id();
                $none_ava = true;
                if ($news_ava != '') {
                    $link = $news_ava;
                    $header = @get_headers($link);
                    if (preg_match('|image|', $header['3'])) {
                        $file = file_get_contents($link);
                        file_put_contents('news'.$news_id.".jpg", $file);
                        rename('/home/u523996525/public_html/news'.$news_id.'.jpg', '/home/u523996525/public_html/images/news/'.$news_id.'.jpg');
                        $news_ava = '/images/news/'.$news_id.'.jpg';
                        $none_ava = false;
                    }
                }
                if ($none_ava) {
                    $news_ava = '/images/news.jpg';
                }
                mysql_query("UPDATE news SET news_avatar='$news_ava' WHERE news_id = '$news_id'");
                $_SESSION['server_answer'] = '<input type="hidden" name="newsCreate" value="true">';
                header('location: '.$location);
                exit;
            }
            else {
                $_SESSION['server_answer'] = '<input type="hidden" name="newsCreate" value="false">';
                header('location: '.$location);
                exit;
            }
        }
        else if (isset($_POST['deleteNews'])) {
            $news_id = $_POST['deleteNews'];
            mysql_query("DELETE FROM news WHERE news_id = '$news_id'");
            $path = '/home/u523996525/public_html/images/news/'.$news_id.'.jpg';
            if (file_exists($path)) {
                unlink($path);
            }
            $_SESSION['server_answer'] = '<input type="hidden" name="newsDelete" value="true">';
            header('location: '.$location);
            exit;
        }
        if (isset($_POST['articleName'])) {
            $article_name = $_POST['articleName'];
            $article_text = $_POST['articleText'];
            $article_avatars = $_POST['articleAva'];
            $article_start = $_POST['articleStart'];
            $user_id = $user_info['user_id'];
            if ($article_name != '' && $article_text != '' && $article_avatars != '' && $article_start != '') {
                mysql_query("INSERT into articles values (0, '$user_id',  '$article_name', '$article_text', '$article_start')");
                $article_id = mysql_insert_id();
                $path = "/home/u523996525/public_html/images/articles/".$article_id;
                mkdir($path, 0700);
                for ($i=0; $i<count($article_avatars); $i+=1) {
                    $link = $article_avatars[$i];
                    $header = @get_headers($link);
                    if (preg_match('|image|', $header['3'])) {
                        $file = file_get_contents($link);
                        file_put_contents('article'.$article_id."-".$i.".jpg", $file);
                        rename('/home/u523996525/public_html/article'.$article_id.'-'.$i.'.jpg', '/home/u523996525/public_html/images/articles/'.$article_id.'/'.$i.'.jpg');
                        $article_ava = '/images/articles/'.$article_id.'/'.$i.'.jpg';
                        mysql_query("INSERT into avatars values (0, 'article',  '$article_id', '$article_ava')");
                    }
                }
                $_SESSION['server_answer'] = '<input type="hidden" name="articleCreate" value="true">';
                header('location: '.$location);
                exit;
            }
            else {
                $_SESSION['server_answer'] = '<input type="hidden" name="articleCreate" value="false">';
                header('location: '.$location);
                exit;
            }
        }
        else if (isset($_POST['oldArticleId'])) {
            $article_id = $_POST['oldArticleId'];
            $article_name = $_POST['oldArticleName'];
            $article_text = $_POST['oldArticleText'];
            $article_avatars = $_POST['oldArticleAva'];
            $article_start = $_POST['oldArticleStart'];
            if ($article_id != '' && $article_name != '' && $article_text != '' && $article_avatars != '' && $article_start != '') {
                $checkArticle = mysql_query("SELECT * FROM articles WHERE article_id = '$article_id'");
                $article_info = mysql_fetch_assoc($checkArticle);
                $user_id = $user_info['user_id'];
                if ($article_info['user_id'] == $user_id || $user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2') {
                    for ($i=0; $i<count($article_avatars); $i+=1) {
                        $link = $article_avatars[$i];
                        $header = @get_headers($link);
                        if (preg_match('|image|', $header['3'])) {
                            $file = file_get_contents($link);
                            file_put_contents('article'.$article_id."-".$i.".jpg", $file);
                            rename('/home/u523996525/public_html/article'.$article_id.'-'.$i.'.jpg', '/home/u523996525/public_html/images/articles/'.$article_id.'/'.$i.'.jpg');
                            $article_ava = '/images/articles/'.$article_id.'/'.$i.'.jpg';
                            $checkAva = mysql_query("SELECT * FROM avatars WHERE avatar_url = '$article_ava'");
                            if (!mysql_num_rows($checkAva)) {
                                mysql_query("INSERT into avatars values (0, 'article',  '$article_id', '$article_ava')");
                            }
                        }
                    }

                    $checkAvatars = mysql_query("SELECT * FROM avatars WHERE avatar_place = 'article' AND avatar_place_id='$article_id'");
                    if (count($article_avatars) < mysql_num_rows($checkAvatars)) {
                        $new_value_avatars = count($article_avatars);
                        $old_value_avatars = mysql_num_rows($checkAvatars);
                        for ($i=$old_value_avatars; $i>=$new_value_avatars; $i-=1) {
                            $delete_url = '/images/articles/'.$article_id.'/'.$i.'.jpg';
                            mysql_query("DELETE FROM avatars WHERE avatar_place_id = '$article_id' AND avatar_place='article' AND avatar_url='$delete_url'");
                            $delete_url = '/home/u523996525/public_html'.$delete_url;
                            unlink($delete_url);
                        }
                    }
                    mysql_query("UPDATE articles SET article_name='$article_name' WHERE article_id = '$article_id'");
                    mysql_query("UPDATE articles SET user_id='$user_id' WHERE article_id = '$article_id'");
                    mysql_query("UPDATE articles SET article_text='$article_text' WHERE article_id = '$article_id'");
                    mysql_query("UPDATE articles SET article_start='$article_start' WHERE article_id = '$article_id'");
                    $_SESSION['server_answer'] = '<input type="hidden" name="articleChange" value="true">';
                    header('location: '.$location);
                    exit;
                }
                else {
                    $_SESSION['server_answer'] = '<input type="hidden" name="articleChange" value="false">';
                    header('location: '.$location);
                    exit;
                }
            }
            else {
                $_SESSION['server_answer'] = '<input type="hidden" name="articleChange" value="all">';
                header('location: '.$location);
                exit;
            }
        }
        else if (isset($_POST['articleDelete'])) {
            $user_id = $user_info['user_id'];
            $article_id = $_POST['articleDelete'];
            $checkArticle = mysql_query("SELECT * FROM articles WHERE article_id = '$article_id'");
            $article_info = mysql_fetch_assoc($checkArticle);
            if ($article_info['user_id'] == $user_id || $user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2') {
                mysql_query("DELETE FROM articles WHERE article_id = '$article_id'");
                mysql_query("DELETE FROM avatars WHERE avatar_place_id = '$article_id' AND avatar_place='article'");
                $path = '/home/u523996525/public_html/images/articles/'.$article_id.'/';
                removeDirectory($path);
                $_SESSION['server_answer'] = '<input type="hidden" name="articleDelete" value="true">';
                header('location: '.$location);
                exit;
            }
            else {
                $_SESSION['server_answer'] = '<input type="hidden" name="articleDelete" value="false">';
                header('location: '.$location);
                exit;
            }
        }
    }
}
function removeDirectory($dir) {
    if ($objs = glob($dir."/*")) {
        foreach($objs as $obj) {
            is_dir($obj) ? removeDirectory($obj) : unlink($obj);
        }
    }
    rmdir($dir);
}
if (!empty($_POST)) {
    if (isset($_POST['logout'])) {
        unset($_SESSION['username']);
        unset($_SESSION['usermail']);
        session_destroy();
        header('location: index');
        exit();
    }
    if (isset($_POST['nick']) || isset($_POST['ava']) || isset($_POST['pass']) || isset($_POST['userTwit'])) {
        $user_mail = $_SESSION['usermail'];
        $checkUser = mysql_query("SELECT * FROM users WHERE user_mail = '$user_mail'");
        if (mysql_num_rows($checkUser)) {
            $user_info = mysql_fetch_assoc($checkUser);
            $user_id = $user_info['user_id'];
            if ($user_info['user_status'] == '1') {
                if (isset($_POST['nick'])) {
                    $nick = $_POST['nick'];
                    mysql_query("UPDATE users SET user_nick='$nick' WHERE user_mail = '$user_mail'");
                    $_SESSION['server_answer'] = '<input type="hidden" name="nickChange" value="true">';
                    header('location: '.$location);
                    exit;
                }
                else if (isset($_POST['ava'])) {
                    $link = $_POST['ava'];
                    $none_ava = true;
                    if ($link != '') {
                        $header = @get_headers($link);
                        if (preg_match('|image|', $header['3'])) {
                            $file = file_get_contents($link);
                            file_put_contents('user'.$user_id.".jpg", $file);
                            rename('/home/u523996525/public_html/user'.$user_id.'.jpg', '/home/u523996525/public_html/images/users/'.$user_id.'.jpg');
                            $new_user_ava = '/images/users/'.$user_id.'.jpg';
                            $none_ava = false;
                        }
                    }
                    if ($none_ava) {
                        $new_user_ava = '/images/avatar.png';
                    }
                    mysql_query("UPDATE users SET user_avatar='$new_user_ava' WHERE user_id = '$user_id'");
                    $_SESSION['server_answer'] = '<input type="hidden" name="avaChange" value="true">';
                    header('location: '.$location);
                    exit;
                }
                else if (isset($_POST['pass'])) {
                    $pass = $_POST['pass'];
                    mysql_query("UPDATE users SET user_pass='$pass' WHERE user_mail = '$user_mail'");
                    $_SESSION['server_answer'] = '<input type="hidden" name="passChange" value="true">';
                    header('location: '.$location);
                    exit;
                }
                else if (isset($_POST['userTwit'])) {
                    $twit = $_POST['userTwit'];
                    mysql_query("UPDATE users SET user_twit='$twit' WHERE user_mail = '$user_mail'");
                    $_SESSION['server_answer'] = '<input type="hidden" name="twitChange" value="true">';
                    header('location: '.$location);
                    exit;
                }
            }
            else {
                $_SESSION['server_answer'] = '<input type="hidden" name="activatedImportant" value="true">';
                header('location: '.$location);
                exit;
            }
        }
    }
}
if (isset($_GET['act'])) {
    if ($_GET['act'] == true) {
        $_SESSION['server_answer'] = '<input type="hidden" name="activatedAgain" value="true">';
        header('location: user');
        exit;
    }
    else {
        $_SESSION['server_answer'] = '<input type="hidden" name="activatedAgain" value="false">';
        header('location: user');
        exit;
    }
}
if (isset($_GET['id'])) {
    $user_id = (int) $_GET['id'];
    $checkUser = mysql_query("SELECT * FROM users WHERE user_id = '$user_id'");
    if(mysql_num_rows($checkUser)) {
        $user_info = mysql_fetch_assoc($checkUser);
    }
    else {
        header('location: index');
    }
    $real_user_mail = $_SESSION['usermail'];
    $checkRealUser = mysql_query("SELECT * FROM users WHERE user_mail = '$real_user_mail'");
    if(mysql_num_rows($checkUser)) {
        $checkRealUser = mysql_query("SELECT * FROM users WHERE user_mail = '$real_user_mail'");
        $real_user_info = mysql_fetch_assoc($checkRealUser);
        if ($user_info['user_id'] == $real_user_info['user_id']) {
            $user_page = true;
        }
        else {
            $user_page = false;
        }
    }
}
else {
	$user_mail = $_SESSION['usermail'];
    $checkUser = mysql_query("SELECT * FROM users WHERE user_mail = '$user_mail'");
	if(mysql_num_rows($checkUser)) {
        $user_info = mysql_fetch_assoc($checkUser);
    }
    else {
        header('location: index');
    }
}
$rank = number_format($user_info['user_rank'], 1, '.', '');
if ($user_page) {
    $rank_text = '<span>Это ваш UR (UserRank). Он отображает, во сколько раз повышены Ваши шансы на победу. Вы будете получать дополнительные 0.1 балла <b>каждый день, когда Вы заходите на сайт</b> под своим логином.</span>';
}
$user_rank = '
<div class="userRank">'.$rank.$rank_text.'</div>
';
$user_id = $user_info['user_id'];
$checkAchievements = mysql_query("SELECT * FROM achievements WHERE user_id = '$user_id' ORDER BY achievement_id ASC");
$achievements = '';
if (mysql_num_rows($checkAchievements)) {
    while ($row = mysql_fetch_assoc($checkAchievements)) {
        if ($row['achievement_color'] != '') {
            $achievement_color = 'style="background-color: '.$row['achievement_color'].'"';
        }
        else {
            $achievement_color = '';
        }
        $achievements .= '
        <div class="achievements" '.$achievement_color.'>'.$row['achievement_number'].'
            <span>'.$row['achievement_text'].'</span>
        </div>
        ';
    }
}
$server_answer = $_SESSION['server_answer'];