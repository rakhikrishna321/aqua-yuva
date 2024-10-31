<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');
$message = 'Unauthorized action.';
$status = 0;

$token = $_POST["token"];
$name = trim($_POST["name"]);
$description = ($_POST["description"]);
$specification = ($_POST["specification"]);

$qrydpt2 = $db->prepare("SELECT * FROM products WHERE name = '$name' AND department = '$department' AND token != '$token'");
$qrydpt2->execute();
if ($qrydpt2->rowcount() > 0) {
    $message = "Product already exist in your department.";
} else {
    $stmt = $db->prepare("UPDATE products SET name = :name, description = :description, specification = :specification WHERE token = :token");
    $stmt->execute([':name' => $name, ':description' => $description, ':specification' => $specification, ':token' => $token]);

    $status = 1;
    $message = 'Updated Successfully';
}

echo json_encode(array(
    "status" => $status,
    "message" => $message
));
