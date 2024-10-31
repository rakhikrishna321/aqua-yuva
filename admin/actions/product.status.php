<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');

$token = ($_GET["token"]);
$status2 = ($_GET["status"]);

$stmt = $db->prepare("UPDATE products SET status = :status WHERE token = :token");
$stmt->execute([':status' => $status2, ':token' => $token]);

header("location:../products.php?filter=$status2");