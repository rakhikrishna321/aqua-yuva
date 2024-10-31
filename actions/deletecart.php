<?php
session_start();
include('../admin/include/dbConnect.php');
include('../admin/include/helper.php');
$user = $_SESSION['SESS_USER_TOKEN'];
$message = 'Unauthorized action.';
$status = 0;
$created_by = $user;
$created_at = $current_date_time_local;
$product = ($_GET["product"]);

$qry_cart = $db->prepare("SELECT * FROM orders WHERE created_by = '$user' AND status = 'pending'");
$qry_cart->execute();
$cart_products = $qry_cart->fetch();
$order_token = $cart_products['token'];

$stmt = $db->prepare("DELETE FROM orders_products WHERE order_token = '$order_token' AND product = '$product'")->execute();


$qry_orders_products0 = $db->prepare("SELECT * FROM orders_products WHERE order_token = '$order_token'");
$qry_orders_products0->execute();
if ($qry_orders_products0->rowCount() == 0) {
    $stmt = $db->prepare("DELETE FROM orders WHERE created_by = '$user' AND status = 'pending'")->execute();
} else {
    $qry_orders_products = $db->prepare("SELECT sum(total), sum(mrp_total) FROM orders_products WHERE order_token = '$order_token'");
    $qry_orders_products->execute();
    $rows_orders_products = $qry_orders_products->fetch();

    $total = $rows_orders_products['sum(total)'];
    $mrp_total = $rows_orders_products['sum(mrp_total)'];

    $stmt = $db->prepare("UPDATE orders SET total = :total, mrp_total = :mrp_total WHERE token = :token");
    $stmt->execute([':total' => $total, ':mrp_total' => $mrp_total, ':token' => $order_token]);
}
$status = 1;
$message = 'Product removed from the cart.';

echo json_encode(array(
    "status" => $status,
    "message" => $message
));
