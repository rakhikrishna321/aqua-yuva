<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');
$message = 'Unauthorized action.';
$status = 0;

$token = genToken();
$department = $user;
$name = trim($_POST["name"]);
$description = ($_POST["description"]);
$specification = ($_POST["specification"]);
$created_at = $current_date_time_local;
$created_by = $user;

$qrydpt2 = $db->prepare("SELECT * FROM products WHERE name = '$name' AND department = '$department'");
$qrydpt2->execute();
if ($qrydpt2->rowcount() > 0) {
    $message = "Product already exist in your department.";
} else {
    $stmt = $db->prepare("INSERT INTO products (token, department, name, description, specification, created_at, created_by) VALUES (:token, :department, :name, :description, :specification, :created_at, :created_by)");
    $stmt->execute([':token' => $token, ':department' => $department, ':name' => $name, ':description' => $description, ':specification' => $specification, ':created_at' => $created_at, ':created_by' => $created_by]);

    $status = 1;
    $message = 'Added Successfully';
}

echo json_encode(array(
    "status" => $status,
    "message" => $message
));