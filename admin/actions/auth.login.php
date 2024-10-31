<?php
session_start();
include('../include/dbConnect.php');
include('../include/helper.php');
$message = 'Unauthorized action.';
$status = 0;
$email = $_POST['email'];
$password = $_POST['password'];

$qry = $db->prepare("SELECT * FROM users WHERE email = '$email' AND password = '$password' AND user_type != 'user' AND status = 1");
$qry->execute();
if ($qry->rowcount() > 0) {
    $row = $qry->fetch();
    $token = $row['token'];
    $_SESSION['SESS_ADMIN_ID'] = $row['id'];
    $_SESSION['SESS_ADMIN_TOKEN'] = $row['token'];
    $_SESSION['SESS_ADMIN_NAME'] = $row['name'];
    $_SESSION['SESS_ADMIN_TYPE'] = $row['user_type'];
    $_SESSION['SESS_ADMIN_EMAIL'] = $row['email'];

    $status = 1;
    $message = 'Login Successful';
} else {
    $message = 'Username or password is wrong! Try Again.';
}

echo json_encode(array(
    "status" => $status,
    "message" => $message
));
