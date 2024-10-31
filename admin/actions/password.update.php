<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');
$message = 'Unauthorized action.';
$status = 0;

$token = $_SESSION['SESS_USER_TOKEN'];
$cpassword = ($_POST["cpassword"]);
$npassword = ($_POST["npassword"]);
$rnpassword = ($_POST["rnpassword"]);

$qryadmn = $db->prepare("SELECT * FROM users WHERE token = '$token' AND password = '$cpassword'");
$qryadmn->execute();
if ($qryadmn->rowcount() > 0) {
    $rowadmn = $qryadmn->fetch();
    $password = $rowadmn['password'];
    if ($password == $cpassword) {
        if (validatePassword($npassword)) {
            if ($npassword == $rnpassword) {
                $stmt = $db->prepare("UPDATE users SET password = :password WHERE token = :token");
                $stmt->execute([':password' => $npassword, ':token' => $token]);

                $status = 1;
                $message = 'Password Updated Successfully';
            } else {
                $message = 'Re-entered new password is not matching!';
            }
        } else {
            $message = "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
        }
    } else {
        $message = 'Current password is wrong!';
    }
} else {
    $message = 'Current password is wrong!';
}

echo json_encode(array(
    "status" => $status,
    "message" => $message,
    "redirect_to" => '/logout.php'
));
