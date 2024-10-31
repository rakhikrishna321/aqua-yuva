<?php
session_start();
include('admin/include/dbConnect.php');
include('admin/include/helper.php');
$product_token = $_GET['token'];
$img = 'assets/img/product/product-1.jpg';
$qry2 = $db->prepare("SELECT * FROM product_images WHERE product_token = '$product_token' AND first_img = 1");
$qry2->execute();
if ($qry2->rowcount() > 0) {
    $rows2 = $qry2->fetch();
    $img = $rows2['file_path'];
}

$qry_main = $db->prepare("SELECT * FROM rating WHERE product = '" . $_GET['token'] . "'");
$qry_main->execute();
$no_of_rating = 0;
$average = 0;
if ($qry_main->rowCount() > 0) {
    $no_of_rating = $qry_main->rowCount();
    $qry = $db->prepare("SELECT sum(rating) FROM rating WHERE product = '" . $_GET['token'] . "'");
    $qry->execute();
    $rows_rating = $qry->fetch();
    $sum_rating = $rows_rating['sum(rating)'];

    $average = 0;
    if ($no_of_rating > 0) {
        $average = $sum_rating / $no_of_rating;
        $average = round($average);
    }
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aqua</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="assets/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="assets/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
</head>

<body>
    <?php include 'include/preloader.php'; ?>
    <?php include 'include/sidemenu.php'; ?>
    <?php include 'include/header.php'; ?>
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large" src="<?php echo $img ?>" alt="">
                        </div>
                        <div class="product__details__pic__slider owl-carousel">
                            <?php
                            $qry2 = $db->prepare("SELECT * FROM product_images WHERE product_token = '$product_token'");
                            $qry2->execute();
                            for ($i = 0; $rows2 = $qry2->fetch(); $i++) {
                            ?>
                                <img data-imgbigurl="<?php echo $rows2['file_path'] ?>" src="<?php echo $rows2['file_path'] ?>" alt="">
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3><?php echo strtoupper($getRowVal->getRow('token', $product_token, 'products')['name']); ?></h3>
                        <div class="product__details__rating">
                            <img src="assets/img/star<?php echo $average ?>.png" width="100px" alt="<?php echo $no_of_rating ?> ratings">
                            <span>(<?php echo $no_of_rating ?> reviews)</span>
                        </div>
                        <div class="product__details__price mb-0" style="text-decoration: line-through;">Rs. <?php echo number_format($getRowVal->getRow('token', $product_token, 'products')['mrp'], 2); ?></div>
                        <div class="product__details__price text-success">Rs. <?php echo number_format($getRowVal->getRow('token', $product_token, 'products')['rate'], 2); ?></div>
                        <p><?php echo $getRowVal->getRow('token', $product_token, 'products')['description'] ?></p>
                        <?php if (isset($_SESSION['SESS_USER_TOKEN'])) {
                            $user = $_SESSION['SESS_USER_TOKEN'];
                            $qry_cart_pro = $db->prepare("SELECT * FROM orders_products WHERE product = '$product_token' AND created_by = '$user' AND status = 0");
                            $qry_cart_pro->execute();
                            if ($qry_cart_pro->rowcount() > 0) {
                        ?>
                                <a href="cart.php" class="primary-btn">GO TO CARD</a>
                            <?php } else { ?>
                                <a href="javascript:void(0)" onclick="addtocart('<?php echo $product_token ?>')" class="primary-btn">ADD TO CARD</a>
                            <?php }
                        } else { ?>
                            <h5>PLEASE <a href="javascript:void();" class="dynamicPopup" data-pop="md" data-url="forms/auth.login.php" data-toggle="modal" data-target="#dynamicPopup-md" data-backdrop="static" data-keyboard="false">LOGIN</a> TO BUY</h5>
                        <?php } ?>
                        <ul>
                            <li><b>Availability</b>
                                <?php if ($getRowVal->getRow('token', $product_token, 'products')['stock'] > 0) {
                                    echo '<span>In Stock</span>';
                                } else {
                                    echo '<span>Out of  Stock</span>';
                                } ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="true">More Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab" aria-selected="false">Reviews <span>(<?php echo $no_of_rating ?>)</span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <?php echo nl2br($getRowVal->getRow('token', $product_token, 'products')['specification']) ?>
                                </div>
                            </div>
                            <div class="tab-pane pt-5" id="tabs-3" role="tabpanel">
                                <?php
                                $qry_main = $db->prepare("SELECT * FROM rating WHERE product = '" . $_GET['token'] . "'");
                                $qry_main->execute();
                                if ($qry_main->rowCount() > 0) {
                                    $no_of_rating = $qry_main->rowCount();
                                    $qry = $db->prepare("SELECT sum(rating) FROM rating WHERE product = '" . $_GET['token'] . "'");
                                    $qry->execute();
                                    $rows_rating = $qry->fetch();
                                    $sum_rating = $rows_rating['sum(rating)'];
                                    $average = 0;
                                    if ($no_of_rating > 0) {
                                        $average = $sum_rating / $no_of_rating;
                                        $average = round($average);
                                    }

                                    for ($i = 0; $rows = $qry_main->fetch(); $i++) {
                                        $rateby = ucwords($getRowVal->getRow('token', $rows['created_by'], 'users')['name']);
                                ?>
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="col-12 text-left transition-3 rounded-c">
                                                    <h5><?php echo $rateby ?></h5>
                                                    <p class="mb-0"><?php echo time_convert($rows['created_at']) ?></p>
                                                    <?php if ($average > 0) { ?>
                                                        <img src="assets/img/star<?php echo $rows['rating'] ?>.png" width="100px" alt="<?php echo $rows['rating'] ?> ratings">
                                                    <?php } ?>
                                                    <p class="mb-0 mt-2">
                                                        <span><?php echo ucfirst($rows['review']) ?></span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <h3 class="text-center mt-5 pt-5 d-block w-100">EMPTY HERE<br>NO REVIEWS FOUND</h3>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include 'include/footer.php'; ?>
    <?php include("admin/include/notify.php"); ?>
    <?php require_once 'include/popup.inc.php'; ?>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.nice-select.min.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/jquery.slicknav.js"></script>
    <script src="assets/js/mixitup.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/main.js"></script>



</body>

</html>