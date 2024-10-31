<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');
$message = 'Unauthorized action.';
$status = 0;

$token = ($_POST["token"]);
$status2 = ($_POST["status"]);
$agent = ($_POST["agent"]);
if ($agent == '') {
    $agent = null;
}

$created_by = $getRowVal->getRow('token', $token, 'orders')['created_by'];
$cstatus = $getRowVal->getRow('token', $token, 'orders')['status'];
$orderby = $getRowVal->getRow('token', $created_by, 'users')['name'];

$stmt = $db->prepare("UPDATE orders SET status = :status, agent = :agent WHERE token = :token");
$stmt->execute([':status' => $status2, ':agent' => $agent, ':token' => $token]);
if ($status2 == 'DELIVERED') {
    $delivered_at = $current_date_time_local;
    $stmt = $db->prepare("UPDATE orders SET delivered_at = :delivered_at WHERE token = :token");
    $stmt->execute([':delivered_at' => $delivered_at, ':token' => $token]);
}

if ($agent != null) {
    $agent_name = $getRowVal->getRow('token', $agent, 'users')['name'];
    $notification_title = 'ORDER #' . $token;
    $notification = 'Hi ' . ucwords($agent_name) . ', order #' . $token . ' is assigned to you for delivery.';
    $qry2 = $db->prepare("SELECT * FROM fcm_token WHERE token = '$agent'");
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
                "uri": "https://aqua-yuva.krabd.com/admin/dashboard.php"
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
}

$notification_title = 'ORDER #' . $token;
$notification = 'Hi ' . ucwords($orderby) . ', your order status changed from ' . strtoupper($cstatus) . ' to ' . strtoupper($status2) . '.';

$qry2 = $db->prepare("SELECT * FROM fcm_token WHERE token = '$created_by'");
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
                "uri": "https://aqua-yuva.krabd.com/orders.php"
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
$message = 'Updated Successfully';

echo json_encode(array(
    "status" => $status,
    "message" => $message
));
