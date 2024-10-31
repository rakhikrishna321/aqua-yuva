<?php
function genToken()
{
    return 't' . sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
}
function genPassword()
{
    return sprintf('%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
}
date_default_timezone_set("Asia/Kolkata");
$current_date_time_local_min = date("Y-m-d", time()) . 'T' . date("h:i", time());
$current_date_time_local = date("Y-m-d H:i:s", time());
$today_local = date("Y-m-d");
$month_local = date("Y-m");
$current_time_local = date("H:i:s", time());
$current_time_local_plus_1 = date('H:i', strtotime('+1 hour', strtotime($current_time_local)));
$current_date_time_local_plus_2 = date('Y-m-d H:i:s', strtotime('+2 hour', strtotime($current_date_time_local)));
date_default_timezone_set('UTC');
$current_date_time = date("Y-m-d H:i:s", time());


function date_convert($date)
{
    $date = date_create($date);
    return date_format($date, "d M Y");
}
function month_convert($date)
{
    $date = date_create($date);
    return date_format($date, "M Y");
}
function time_convert($date)
{
    $date = date_create($date);
    return date_format($date, "d/m/Y h:i A");
}
function time_convert2($date)
{
    $date = date_create($date);
    return date_format($date, "d/m/Y h:i:s A");
}

function time_differenceInSeconds($time)
{
    date_default_timezone_set("Asia/Kolkata");
    $current_date_time_local = date("Y-m-d H:i:s", time());
    $timeFirst  = strtotime($time);
    $timeSecond = strtotime($current_date_time_local);
    $differenceInSeconds = $timeSecond - $timeFirst;
    return $differenceInSeconds;
}
function time_differenceInSeconds_2($time, $time2)
{
    $timeFirst  = strtotime($time);
    $timeSecond = strtotime($time2);
    $differenceInSeconds = $timeSecond - $timeFirst;
    return $differenceInSeconds;
}
function Notify($notification, $email_to)
{
    $to = $email_to;
    $subject = 'Mail from Learn Well';
    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    // More headers
    $headers .= 'From: <learnwell@ewolwe.in>' . "\r\n";
    $mail_sent = mail($to, $subject, $notification, $headers);
    return $mail_sent ? "ss" : "ss2";
}


$key = 'bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=';
function my_encrypt($data, $key)
{
    // Remove the base64 encoding from our key
    $encryption_key = base64_decode($key);
    // Generate an initialization vector
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
    return base64_encode($encrypted . '::' . $iv);
}
function my_decrypt($data, $key)
{
    // Remove the base64 encoding from our key
    $encryption_key = base64_decode($key);
    // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}

class GetValue
{
    private $db;
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }
    public function getRow($col, $colValue, $table)
    {
        $row = 'empty';
        $stmt = $this->db->prepare("SELECT * FROM $table WHERE $col = '$colValue' LIMIT 0,1");
        $stmt->execute();
        if ($stmt->rowcount() == 0) {
            return 'NOTAVAILABLE';
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
    }
}
$getRowVal = new GetValue($db);


function validatePassword($password)
{
    // Minimum length of 8 characters
    if (strlen($password) < 8) {
        return false;
    }

    // At least one uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
        return false;
    }

    // At least one lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
        return false;
    }

    // At least one digit
    if (!preg_match('/\d/', $password)) {
        return false;
    }

    // At least one special character
    if (!preg_match('/[^a-zA-Z\d]/', $password)) {
        return false;
    }

    return true;
}

function validateName($name)
{
    // Remove white spaces from beginning and end of the name
    $name = trim($name);

    // Check if the name contains only letters and spaces
    if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
        return 0;
    }

    // Check if the name is at least 2 characters long
    if (strlen($name) < 2) {
        return 0;
    }

    return 1;
}
function truncate_text($text, $length)
{
    if (strlen($text) > $length) {
        $text = substr($text, 0, $length);
        $text = substr($text, 0, strrpos($text, ' ')) . '...';
    }
    return $text;
}

$fbkey = 'AAAAciR-7qc:APA91bGflSVZ0Wvg7sMKibwvsNi-SKTFHVNZ8kTvAg4VXHvv5og4JAnPrKfzPLiEidFeUXu2M0WGjFQLPcxEmYRaOwEaXiD_cekmmjLTa_22y9TD0EpCXwPRGcM_QB84ZnWMRrAfAjfG';

$iswebview = 0;
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "com.ewolwe.aqua") {
    $iswebview = 1;
}
