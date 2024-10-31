<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');
$message = 'Unauthorized action.';
$status = 0;

$token = genToken();
$name = ($_POST["name"]);
$handled_by = ($_POST["handled_by"]);
$email = ($_POST["email"]);
$phone = ($_POST["phone"]);
$password = ($_POST["password"]);
$created_at = $current_date_time_local;
$user_type = 'department';

$qrydpt = $db->prepare("SELECT * FROM departments WHERE name = '$name'");
$qrydpt->execute();

$qrydpt2 = $db->prepare("SELECT * FROM users WHERE email = '$email'");
$qrydpt2->execute();

if ($qrydpt->rowcount() > 0) {
    $message = "Department name already exist.";
} elseif ($qrydpt2->rowcount() > 0) {
    $message = "Email address already exist.";
} else {

    $stmt = $db->prepare("INSERT INTO departments (token, name, handled_by, email, phone, created_at) VALUES (:token, :name, :handled_by, :email, :phone, :created_at)");
    $stmt->execute([':token' => $token, ':name' => $name, ':handled_by' => $handled_by, ':email' => $email, ':phone' => $phone, ':created_at' => $created_at]);

    $stmt = $db->prepare("INSERT INTO users (token, user_type, name, email, password, created_at) VALUES (:token, :user_type, :name, :email, :password, :created_at)");
    $stmt->execute([':token' => $token, ':user_type' => $user_type, ':name' => $name, ':email' => $email, ':password' => $password, ':created_at' => $created_at]);

    $status = 1;
    $message = 'Added Successfully';
}

echo json_encode(array(
    "status" => $status,
    "message" => $message
));
