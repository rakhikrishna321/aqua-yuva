<?php
session_start();
include('../admin/include/dbConnect.php');
include('../admin/include/helper.php');
$message = 'Unauthorized action.';
$status = 0;
$email = $_POST['email'];
$password = $_POST['password'];

$qry = $db->prepare("SELECT * FROM users WHERE email = '$email' AND password = '$password' AND status = 1");
$qry->execute();
if ($qry->rowcount() > 0) {
    $row = $qry->fetch();
    $user_type = $row['user_type'];
    $token = $row['token'];
    if ($user_type == 'user') {
        $_SESSION['SESS_USER_ID'] = $row['id'];
        $_SESSION['SESS_USER_TOKEN'] = $row['token'];
        $_SESSION['SESS_USER_NAME'] = $row['name'];
        $_SESSION['SESS_USER_TYPE'] = $row['user_type'];
        $_SESSION['SESS_USER_EMAIL'] = $row['email'];
        $redirect_to = 'reload';

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
        $status = 1;
        $message = 'Login Successful';
    } else {
        $_SESSION['SESS_ADMIN_ID'] = $row['id'];
        $_SESSION['SESS_ADMIN_TOKEN'] = $row['token'];
        $_SESSION['SESS_ADMIN_NAME'] = $row['name'];
        $_SESSION['SESS_ADMIN_TYPE'] = $row['user_type'];
        $_SESSION['SESS_ADMIN_EMAIL'] = $row['email'];
        $redirect_to = '/admin/dashboard.php';

        $fcm = genToken();
        setcookie("ME", $fcm, time() + (86400 * 30), "/");

        $stmt = $db->prepare("UPDATE users SET fcm = :fcm WHERE token = :token");
        $stmt->execute([':fcm' => $fcm, ':token' => $token]);

        $fcm_token = null;
        if (isset($_COOKIE['FCM_TOKEN']) && trim($_COOKIE['FCM_TOKEN']) != '') {
            $fcm_token = $_COOKIE['FCM_TOKEN'];
            $db->prepare("DELETE FROM fcm_token WHERE fcm_token = '$fcm_token'")->execute();

            $stmt = $db->prepare("INSERT INTO fcm_token (token, fcm_token, created_at) VALUES (:token, :fcm_token, :created_at)");
            $stmt->execute([':token' => $token, ':fcm_token' => $fcm_token, ':created_at' => $current_date_time_local]);
        }
        $status = 1;
        $message = 'Login Successful';
    }
} else {
    $message = 'Username or password is wrong! Try Again.';
}

echo json_encode(array(
    "status" => $status,
    "redirect_to" => $redirect_to,
    "message" => $message
));
