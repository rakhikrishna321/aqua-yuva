<?php
session_start();
if (!isset($_SESSION['SESS_USER_TOKEN']) || trim($_SESSION['SESS_USER_TOKEN']) == '') {
    if (isset($_COOKIE["ME"])) {
        $fcm = $_COOKIE["ME"];

        $qry = $db->prepare("SELECT * FROM remember_token WHERE fcm_token = '$fcm'");
        $qry->execute();
        if ($qry->rowcount() > 0) {
            $row1 = $qry->fetch();
            $token = $row1['token'];
            $qry2 = $db->prepare("SELECT * FROM users WHERE token = '$fcm' AND status = 1");
            $qry2->execute();
            if ($qry2->rowcount() > 0) {
                $row = $qry2->fetch();
                $_SESSION['SESS_USER_ID'] = $row['id'];
                $_SESSION['SESS_USER_TOKEN'] = $row['token'];
                $_SESSION['SESS_USER_NAME'] = $row['name'];
                $_SESSION['SESS_USER_TYPE'] = $row['user_type'];
                $_SESSION['SESS_USER_EMAIL'] = $row['email'];

                $fcm = genToken();
                setcookie("ME", $fcm, time() + (86400 * 30), "/");
                $db->prepare("DELETE FROM remember_token WHERE fcm_token = '$fcm'")->execute();
        
                $stmt = $db->prepare("INSERT INTO remember_token (token, fcm_token, created_at) VALUES (:token, :fcm_token, :created_at)");
                $stmt->execute([':token' => $token, ':fcm_token' => $fcm, ':created_at' => $current_date_time_local]);

                $fcm_token = null;
                if (isset($_COOKIE['FCM_TOKEN']) && trim($_COOKIE['FCM_TOKEN']) != '') {
                    $fcm_token = $_COOKIE['FCM_TOKEN'];
                    $db->prepare("DELETE FROM fcm_token WHERE fcm_token = '$fcm_token'")->execute();

                    $stmt = $db->prepare("INSERT INTO fcm_token (token, fcm_token, created_at) VALUES (:token, :fcm_token, :created_at)");
                    $stmt->execute([':token' => $token, ':fcm_token' => $fcm_token, ':created_at' => $current_date_time_local]);
                }

                header("location: ../login.php?expired");
            } else {
                header("location: ../login.php?expired");
            }
        } else {
            header("location: ../login.php?expired");
        }
    } else {
        header("location: ../login.php?expired");
    }
}
$user = trim($_SESSION['SESS_USER_TOKEN']);
