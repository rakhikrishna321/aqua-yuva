<?php
session_start();
include('../admin/include/dbConnect.php');
include('../admin/include/helper.php');
$user = $_SESSION['SESS_USER_TOKEN'];
$message = 'Unauthorized action.';
$status = 0;

$token = genToken();
$product = ($_POST["product"]);
$rating = ($_POST["rating"]);
$review = ($_POST["review"]);
$created_at = $current_date_time_local;
$created_by = $user;

$stmt = $db->prepare("DELETE FROM rating WHERE product = '$product' AND created_by = '$created_by'")->execute();

$stmt = $db->prepare("INSERT INTO rating (token, product, rating, review, created_at, created_by) VALUES (:token, :product, :rating, :review, :created_at, :created_by)");
$stmt->execute([':token' => $token, ':product' => $product, ':rating' => $rating, ':review' => $review, ':created_at' => $created_at, ':created_by' => $created_by]);

$status = 1;
$message = 'Rated Successfully';

echo json_encode(array(
    "status" => $status,
    "message" => $message
));