<?php
//а вот эта ебата подключается на страницах розыгрышей
if (isset($_POST['requestRaffle'])) {
    if ($_SESSION['usermail'] != '') {
        $user_mail = $_SESSION['usermail'];
        $checkUser = mysql_query("SELECT * FROM users WHERE user_mail = '$user_mail'");
        $user_info = mysql_fetch_assoc($checkUser);
        if ($user_info['user_status'] == '1' || $user_info['user_privilege'] == '3') {
            if ($user_info['user_privilege'] == '0') {
                if ($user_info['user_country'] == 'Россия' && strpos($user_info['user_city'], 'Москва') !== false) {
                    $user_id = $user_info['user_id'];
                    $raffle_id = (int) $_GET['id'];
                    $check = mysql_query("SELECT * FROM requests WHERE user_id = '$user_id' AND event_id = '$raffle_id'");
                    if (!mysql_num_rows($check) && $_POST['requestRaffle'] == '1') {
                        $check_event = mysql_query("SELECT * FROM events WHERE event_id = '$raffle_id'");
                        $event_info = mysql_fetch_assoc($check_event);
                        $event_members = $event_info['event_member'];
                        $user_id = $user_info['user_id'];
                        $event_members = $event_members + 1;
                        mysql_query("UPDATE events SET event_member='$event_members' WHERE event_id = '$raffle_id'");
                        mysql_query("INSERT into requests values (0, '$raffle_id', '$user_id')");
                        $_SESSION['server_answer'] = '<input type="hidden" name="raffles" value="true">';
                        header('location: '.$location);
                        exit;
                    }
                    else if (mysql_num_rows($check) && $_POST['requestRaffle'] == '0') {
                        $checkEvent = mysql_query("SELECT * FROM events WHERE event_id = '$raffle_id'");
                        if (mysql_num_rows($checkEvent)) {
                            $event_info = mysql_fetch_assoc($checkEvent);
                            $event_member = $event_info['event_member'];
                            $event_member = $event_member-1;
                            mysql_query("UPDATE events SET event_member='$event_member' WHERE event_id = '$raffle_id'");
                        }
                        mysql_query("DELETE FROM requests WHERE user_id = '$user_id' AND event_id = '$raffle_id'");
                        $_SESSION['server_answer'] = '<input type="hidden" name="raffles" value="false">';
                        header('location: '.$location);
                        exit;
                    }
                }
                else {
                    $_SESSION['server_answer'] = '<input type="hidden" name="city" value="true">';
                    header('location: '.$location);
                    exit;
                }
            }
            else {
                if ($user_info['user_privilege'] == '1' || $user_info['user_privilege'] == '2') {
                    $_SESSION['server_answer'] = '<input type="hidden" name="banned" value="false">';
                    header('location: '.$location);
                    exit;
                }
                else {
                    $_SESSION['server_answer'] = '<input type="hidden" name="banned" value="true">';
                    header('location: '.$location);
                    exit;
                }
            }
        }
        else {
            $_SESSION['server_answer'] = '<input type="hidden" name="activated" value="false">';
            header('location: '.$location);
            exit;
        }
    }
    else {
        $_SESSION['server_answer'] = '<input type="hidden" name="login" value="true">';
        header('location: '.$location);
        exit;
    }
}
if (isset($_GET['id'])) {
    $raffle_id = (int) $_GET['id'];
    $user_id = $real_user_info['user_id'];
    $checkRequest = mysql_query("SELECT * FROM requests WHERE user_id = '$user_id' AND event_id = '$raffle_id'");
    if (mysql_num_rows($checkRequest)) {
        $buttonText = 'Отменить заявку...<input id="check" value="0" type="hidden">';
    }
    else {
        $buttonText = 'Подать заявку!<input id="check" value="1" type="hidden">';
    }
}
$server_answer = $_SESSION['server_answer'];