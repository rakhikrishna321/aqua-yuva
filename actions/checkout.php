<?php
session_start();
include('../admin/include/dbConnect.php');
include('../admin/include/helper.php');
$user = $_SESSION['SESS_USER_TOKEN'];
$message = 'Unauthorized action.';
$status = 0;
$created_by = $user;
$created_at = $current_date_time_local;
$delivery_address = $_POST['delivery_address'];
$delivery_pincode = $_POST['delivery_pincode'];
$delivery_contact = $_POST['delivery_contact'];
$payment = $_POST['payment'];
$status2 = 'order placed';

$qry_cart = $db->prepare("SELECT * FROM orders WHERE created_by = '$user' AND status = 'pending'");
$qry_cart->execute();
$cart_count = $qry_cart->rowcount();
if ($cart_count == 0) {
    $message = 'Not found!';
} else {
    $cart_products = $qry_cart->fetch();
    $order_token = $cart_products['token'];

    if (strlen($delivery_pincode) != 6) {
        $message = 'Enter a valid pincode.';
    } elseif (strlen($delivery_contact) != 10) {
        $message = 'Enter a valid phone number.';
    } else {
        $qry_cart = $db->prepare("SELECT * FROM orders_products WHERE order_token = '$order_token'");
        $qry_cart->execute();
        for ($i = 0; $rows = $qry_cart->fetch(); $i++) {
            $pro = $rows['product'];
            $qty = $rows['qty'];
            $stock = $getRowVal->getRow('token', $pro, 'products')['stock'] - $qty;

            $stmt = $db->prepare("UPDATE products SET stock = :stock WHERE token = :token");
            $stmt->execute([':stock' => $stock, ':token' => $pro]);
        }

        $qry_cart = $db->prepare("SELECT * FROM orders WHERE created_by = '$user' AND status = 'pending'");
        $qry_cart->execute();
        $cart_products = $qry_cart->fetch();
        $order_token = $cart_products['token'];

        $stmt = $db->prepare("UPDATE orders SET delivery_address = :delivery_address, delivery_pincode = :delivery_pincode, delivery_contact = :delivery_contact, payment = :payment, status = :status WHERE token = :token");
        $stmt->execute([':delivery_address' => $delivery_address, ':delivery_pincode' => $delivery_pincode, ':delivery_contact' => $delivery_contact, ':payment' => $payment, ':status' => $status2, ':token' => $order_token]);

        $db->prepare("UPDATE orders_products SET status = 1 WHERE order_token = '$order_token'")->execute();

        $department_token = $getRowVal->getRow('token', $order_token, 'orders')['department_token'];
        $department = $getRowVal->getRow('token', $department_token, 'users')['name'];

        $notification_title = 'NEW ORDER RECIEVED';
        $notification = 'Hi ' . ucwords($department) . ', you have a new order. tap to know more!';

        $qry2 = $db->prepare("SELECT * FROM fcm_token WHERE token = '$department_token'");
        $qry2->execute();
        for ($i2 = 0; $rows2 = $qry2->fetch(); $i2++) {
            $fcm = $rows2['fcm_token'];
            if ($server == 1) {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{
            "notification": {
                "title": "' . $notification_title . '",
                "body": "' . $notification . '",
                "click_action": "Open_URI",
                "image":""
            },
            "data": {
                "uri": "https://aqua-yuva.krabd.com/admin/orders.php"
            },
            "to": "' . $fcm . '"
        }',
                    CURLOPT_HTTPHEADER => array(
                        'content-type: application/json',
                        'authorization: key=' . $fbkey
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
            }
        }

        $status = 1;
        $message = 'Order Placed';
    }
}

echo json_encode(array(
    "status" => $status,
    "message" => $message
));
