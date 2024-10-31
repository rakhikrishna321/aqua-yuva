<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');
$message = 'Unauthorized action.';
$status = 0;

$token = $_POST["token"];
$stock = trim($_POST["stock"]);
if ($stock < 0) {
    $message = "Enter a valid stock";
} else {
    $stmt = $db->prepare("UPDATE products SET stock = :stock WHERE token = :token");
    $stmt->execute([':stock' => $stock, ':token' => $token]);

    $status = 1;
    $message = 'Updated Successfully';
}

echo json_encode(array(
    "status" => $status,
    "message" => $message
));
