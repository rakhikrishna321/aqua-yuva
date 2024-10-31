<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');
$message = 'Unauthorized action.';
$status = 0;

$token = genToken();
$name = ($_POST["name"]);
$created_by = $_SESSION['SESS_ADMIN_TOKEN'];
if ($_SESSION['SESS_ADMIN_TYPE'] == 'admin') {
    $created_by = 'admin';
}
$email = ($_POST["email"]);
$phone = ($_POST["phone"]);
$password = ($_POST["password"]);
$created_at = $current_date_time_local;
$user_type = 'delivery';

$qrydpt2 = $db->prepare("SELECT * FROM users WHERE email = '$email'");
$qrydpt2->execute();

if ($qrydpt2->rowcount() > 0) {
    $message = "Email address already exist.";
} else {

    $stmt = $db->prepare("INSERT INTO delivery_agents (token, name, created_by, email, phone, created_at) VALUES (:token, :name, :created_by, :email, :phone, :created_at)");
    $stmt->execute([':token' => $token, ':name' => $name, ':created_by' => $created_by, ':email' => $email, ':phone' => $phone, ':created_at' => $created_at]);

    $stmt = $db->prepare("INSERT INTO users (token, user_type, name, email, password, created_at) VALUES (:token, :user_type, :name, :email, :password, :created_at)");
    $stmt->execute([':token' => $token, ':user_type' => $user_type, ':name' => $name, ':email' => $email, ':password' => $password, ':created_at' => $created_at]);

    $status = 1;
    $message = 'Added Successfully';
}

echo json_encode(array(
    "status" => $status,
    "message" => $message
));
