<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');
$message = 'Unauthorized action.';
$status = 0;

$token = $_POST["token"];
$mrp = trim($_POST["mrp"]);
$rate = ($_POST["rate"]);
if ($mrp < $rate) {
    $message = "Rate must be greater than selling price";
} else {
    $stmt = $db->prepare("UPDATE products SET mrp = :mrp, rate = :rate WHERE token = :token");
    $stmt->execute([':mrp' => $mrp, ':rate' => $rate, ':token' => $token]);

    $status = 1;
    $message = 'Updated Successfully';
}

echo json_encode(array(
    "status" => $status,
    "message" => $message
));
