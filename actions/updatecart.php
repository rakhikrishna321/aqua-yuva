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
$qty = ($_GET["qty"]);

if ($getRowVal->getRow('token', $product, 'products')['stock'] >= $qty) {

    $qry_cart = $db->prepare("SELECT * FROM orders WHERE created_by = '$user' AND status = 'pending'");
    $qry_cart->execute();
    $cart_products = $qry_cart->fetch();
    $order_token = $cart_products['token'];

    $stmt = $db->prepare("DELETE FROM orders_products WHERE order_token = '$order_token' AND product = '$product'")->execute();

    $token = genToken();
    $product_name = ($getRowVal->getRow('token', $product, 'products')['name']);
    $rate = ($getRowVal->getRow('token', $product, 'products')['rate']);
    $total = $qty * $rate;
    $mrp = ($getRowVal->getRow('token', $product, 'products')['mrp']);
    $mrp_total = $qty * $mrp;

    $stmt = $db->prepare("INSERT INTO orders_products (token, order_token, product, product_name, qty, rate, total, mrp, mrp_total, created_at, created_by) VALUES (:token, :order_token, :product, :product_name, :qty, :rate, :total, :mrp, :mrp_total, :created_at, :created_by)");
    $stmt->execute([':token' => $token, ':order_token' => $order_token, ':product' => $product, ':product_name' => $product_name, ':qty' => $qty, ':rate' => $rate, ':total' => $total, ':mrp' => $mrp, ':mrp_total' => $mrp_total, ':created_at' => $created_at, ':created_by' => $created_by]);

    $qry_orders_products = $db->prepare("SELECT sum(total), sum(mrp_total) FROM orders_products WHERE order_token = '$order_token'");
    $qry_orders_products->execute();
    $rows_orders_products = $qry_orders_products->fetch();

    $total = $rows_orders_products['sum(total)'];
    $mrp_total = $rows_orders_products['sum(mrp_total)'];

    $stmt = $db->prepare("UPDATE orders SET total = :total, mrp_total = :mrp_total WHERE token = :token");
    $stmt->execute([':total' => $total, ':mrp_total' => $mrp_total, ':token' => $order_token]);

    $status = 1;
    $message = 'Cart Updated.';
} else {
    $message = 'Sorry, no stock.';
}
echo json_encode(array(
    "status" => $status,
    "message" => $message
));
