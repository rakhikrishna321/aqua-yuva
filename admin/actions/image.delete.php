<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');
$message = 'Unauthorized action.';
$status = 0;

$token = $_GET["token"];

$stmt = $db->prepare("DELETE FROM product_images WHERE token = '$token'")->execute();

$status = 1;
$message = 'Deleted Successfully';

echo json_encode(array(
    "status" => $status,
    "message" => $message
));
