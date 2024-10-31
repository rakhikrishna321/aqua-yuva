<?php
include('../include/auth.php');
include('../admin/include/dbConnect.php');
include('../admin/include/helper.php');
$message = 'Unauthorized action.';
$status = 0;

$token = ($_POST["token"]);
$status2 = 'CANCELED';

$department_token = $getRowVal->getRow('token', $token, 'orders')['department_token'];
$created_by = $getRowVal->getRow('token', $token, 'orders')['created_by'];
$cstatus = $getRowVal->getRow('token', $token, 'orders')['status'];
$orderby = $getRowVal->getRow('token', $created_by, 'users')['name'];

$stmt = $db->prepare("UPDATE orders SET status = :status WHERE token = :token");
$stmt->execute([':status' => $status2, ':token' => $token]);

$notification_title = 'ORDER #' . $token;
$notification = ucwords($orderby) . ', cancelled the order.';

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
                "uri": "https://aqua-yuva.krabd.com/admin/orders.php?old"
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
$message = 'Order Cancelled Successfully';

echo json_encode(array(
    "status" => $status,
    "message" => $message
));
