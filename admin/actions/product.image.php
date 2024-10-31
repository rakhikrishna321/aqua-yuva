<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');
$message = 'Choose a file to upload.';
$status = 0;

$token = genToken();
$product_token = ($_POST["product_token"]);
$first_img = ($_POST["first_img"]);

if (isset($_FILES['file']['name'])) {
    $filename = $_FILES['file']['name'];

    $target_di = "../../files/";
    if (!file_exists($target_di)) {
        mkdir($target_di, 0777, true);
    }

    $file_path = "files/" . genToken();
    $location = "../../" . $file_path;
    $imageFileType = pathinfo($filename, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);
    $location .= "." . $imageFileType;
    $file_path .= "." . $imageFileType;

    $valid_extensions = array("jpg", "jpeg", "png");

    if (in_array(strtolower($imageFileType), $valid_extensions)) {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {

            if ($first_img == 1) {
                $stmt = $db->prepare("UPDATE product_images SET first_img = 0 WHERE product_token = :product_token");
                $stmt->execute([':product_token' => $product_token]);
            }

            $stmt = $db->prepare("INSERT INTO product_images (token, product_token, file_path, first_img) VALUES (:token, :product_token, :file_path, :first_img)");
            $stmt->execute([':token' => $token, ':product_token' => $product_token, ':file_path' => $file_path, ':first_img' => $first_img]);

            $status = 1;
            $message = 'Photo added.';
        } else {
            $message = 'Cant move file';
        }
    } else {
        $message = '"JPG", "JPG", "PNG" will be accepted';
    }
} else {
    $message = 'Choose a file to upload';
}

echo json_encode(array(
    "status" => $status,
    "message" => $message
));
