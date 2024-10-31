<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');
$message = 'Unauthorized action.';
$status = 0;

$token = ($_POST["token"]);
$name = ($_POST["name"]);
$handled_by = ($_POST["handled_by"]);
$email = ($_POST["email"]);
$phone = ($_POST["phone"]);
$password = ($_POST["password"]);
$created_at = $current_date_time_local;
$user_type = 'department';

$qrydpt = $db->prepare("SELECT * FROM departments WHERE name = '$name' AND token != '$token'");
$qrydpt->execute();

$qrydpt2 = $db->prepare("SELECT * FROM users WHERE email = '$email' AND token != '$token'");
$qrydpt2->execute();

if ($qrydpt->rowcount() > 0) {
    $message = "Department name already exist.";
} elseif ($qrydpt2->rowcount() > 0) {
    $message = "Email address already exist.";
} else {

    $stmt = $db->prepare("UPDATE departments SET name = :name, handled_by = :handled_by, email = :email, phone = :phone WHERE token = :token");
    $stmt->execute([':name' => $name, ':handled_by' => $handled_by, ':email' => $email, ':phone' => $phone, ':token' => $token]);

    $stmt = $db->prepare("UPDATE users SET name = :name, email = :email, password = :password WHERE token = :token");
    $stmt->execute([':name' => $name, ':email' => $email, ':password' => $password, ':token' => $token]);

    $status = 1;
    $message = 'Updated Successfully';
}

echo json_encode(array(
    "status" => $status,
    "message" => $message
));
