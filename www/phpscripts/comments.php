<?php
if (isset($_POST['commentLocation'])) {
    if ($_SESSION['usermail'] != '') {
        $user_mail = $_SESSION['usermail'];
        $checkUser = mysql_query("SELECT * FROM users WHERE user_mail = '$user_mail'");
        $user_info = mysql_fetch_assoc($checkUser);
        $commentLocation = $_POST['commentLocation'];
        $commentText = $_POST['commentText'];
        if ($user_info['user_privilege'] != '1') {
            $commentText = addslashes(htmlspecialchars($commentText, ENT_QUOTES));
        }
        $commentLocationID = (int) $_GET['id'];
        $commentDate = $nowDateTime;
        $commentUserID = $user_info['user_id'];
        if ($commentText != '' && $commentLocation != '') {
            $checkReComment = mysql_query("SELECT * FROM comments WHERE comment_text = '$commentText' AND user_id = '$commentUserID' AND comment_page = '$commentLocation' AND comment_page_id = '$commentLocationID'");
            if (!mysql_num_rows($checkReComment)) {
                if (isset($_POST['answerID'])) {
                    $commentAnswer = $_POST['answerID'];
                }
                else {
                    $commentAnswer = 0;
                }
                if (mysql_query("INSERT into comments values (0, '$commentUserID', '$commentLocation', '$commentLocationID', '$commentText', '$commentDate', '$commentAnswer', 0)")) {
                    $_SESSION['server_answer'] = '<input type="hidden" name="comment" value="true">';
                    header('location: '.$location);
                    exit;
                }
                else {
                    $_SESSION['server_answer'] = '<input type="hidden" name="comment" value="false">';
                    header('location: '.$location);
                    exit;
                }
            }
        }
        else {
            $_SESSION['server_answer'] = '<input type="hidden" name="comment" value="false">';
            header('location: '.$location);
            exit;
        }
    }
}
if (isset($_POST['commentID'])) {
    if ($_SESSION['usermail'] != '') {
        $user_mail = $_SESSION['usermail'];
        $checkUser = mysql_query("SELECT * FROM users WHERE user_mail = '$user_mail'");
        $user_info = mysql_fetch_assoc($checkUser);
        $comment_id = $_POST['commentID'];
        $checkComment = mysql_query("SELECT * FROM comments WHERE comment_id = '$comment_id'");
        if (mysql_num_rows($checkComment)) {
            $comment_info = mysql_fetch_assoc($checkComment);
            $commentLocation = $comment_info['comment_page'];
            $commentLocationID = $comment_info['comment_page_id'];
            if (($comment_info['user_id'] == $user_info['user_id']) || ($user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2')) {
                if ($user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2') {
                    mysql_query("DELETE FROM comments WHERE comment_id = '$comment_id'");
                    mysql_query("DELETE FROM comments WHERE comment_answer = '$comment_id'");
                }
                else {
                    mysql_query("UPDATE comments SET comment_delete = '1' WHERE comment_id = '$comment_id'");
                }
                $_SESSION['server_answer'] = '<input type="hidden" name="commentDel" value="true">';
                header('location: '.$location);
                exit;
            }
            else {
                $_SESSION['server_answer'] = '<input type="hidden" name="commentDel" value="no">';
                header('location: '.$location);
                exit;
            }
        }
    }
}
$server_answer = $_SESSION['server_answer'];