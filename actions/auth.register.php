<?php
session_start();
include('../admin/include/dbConnect.php');
include('../admin/include/helper.php');
$message = 'Unauthorized action.';
$status = 0;

$token = genToken();
$name = ($_POST["name"]);
$email = ($_POST["email"]);
$phone = ($_POST["phone"]);
$password = ($_POST["password"]);
$created_at = $current_date_time_local;
$user_type = 'user';
$status2 = 1;


$qryusers = $db->prepare("SELECT * FROM users WHERE email = '$email'");
$qryusers->execute();
if ($qryusers->rowcount() > 0) {
    $message = 'Email already registered with us.';
} elseif (validateName($name) == 0) {
    $message = 'Enter a valid name';
} elseif (strlen($phone) != 10) {
    $message = 'Enter a valid phone number.';
} else {
    if (validatePassword($password)) {
        $stmt = $db->prepare("INSERT INTO users (token, user_type, name, email, phone, password, created_at, status) VALUES (:token, :user_type, :name, :email, :phone, :password, :created_at, :status)");
        $stmt->execute([':token' => $token, ':user_type' => $user_type, ':name' => $name, ':email' => $email, ':phone' => $phone, ':password' => $password, ':created_at' => $created_at, ':status' => $status2]);

        $_SESSION['SESS_USER_ID'] = $getRowVal->getRow('token', $token, 'users')['id'];
        $_SESSION['SESS_USER_TOKEN'] = $token;
        $_SESSION['SESS_USER_NAME'] = $name;
        $_SESSION['SESS_USER_TYPE'] = 'user';
        $_SESSION['SESS_USER_EMAIL'] = $email;

        $status = 1;
        $message = 'Registered Successfully';
    } else {
        $message = "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
    }
}

echo json_encode(array(
    "status" => $status,
    "message" => $message
));
