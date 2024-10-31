<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');

$token = ($_GET["token"]);
$status2 = ($_GET["status"]);

$stmt = $db->prepare("UPDATE departments SET status = :status WHERE token = :token");
$stmt->execute([':status' => $status2, ':token' => $token]);

$stmt = $db->prepare("UPDATE users SET status = :status WHERE token = :token");
$stmt->execute([':status' => $status2, ':token' => $token]);

header("location:../departments.php");