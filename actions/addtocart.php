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

if ($getRowVal->getRow('token', $product, 'products')['stock'] > 0) {
    $department_token = $getRowVal->getRow('token', $product, 'products')['department'];
    $qry_cart = $db->prepare("SELECT * FROM orders WHERE created_by = '$user' AND status = 'pending'");
    $qry_cart->execute();
    $cart_count = $qry_cart->rowcount();
    if ($cart_count == 0) {
        $order_token = genToken();
        $total = 0;

        $stmt = $db->prepare("INSERT INTO orders (token, total, created_by, created_at, department_token) VALUES (:token, :total, :created_by, :created_at, :department_token)");
        $stmt->execute([':token' => $order_token, ':total' => $total, ':created_by' => $created_by, ':created_at' => $created_at, ':department_token' => $department_token]);
    } else {
        $cart_products = $qry_cart->fetch();
        $order_token = $cart_products['token'];
        $department_token2 = $cart_products['department_token'];
        if ($department_token != $department_token2) {

            echo json_encode(array(
                "status" => $status,
                "message" => "Choose product from " . ucwords($getRowVal->getRow('token', $department_token2, 'departments')['name']) . " department to add to cart."
            ));
            exit();
        }
    }

    $token = genToken();
    $product_name = ($getRowVal->getRow('token', $product, 'products')['name']);
    $qty = 1;
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
    $message = 'Added to cart.';
} else {
    $message = 'Sorry, no stock.';
}
echo json_encode(array(
    "status" => $status,
    "message" => $message
));
