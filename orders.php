<?php
session_start();
include('admin/include/dbConnect.php');
include('admin/include/helper.php');
$user = $_SESSION['SESS_USER_TOKEN'];
$title = 'CURRENT ORDERS';
if (isset($_GET['old'])) {
    $title = 'PREVIOUS ORDERS';
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
    <section class="breadcrumb-section set-bg" data-setbg="assets/img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2><?php echo $title ?></h2>
                        <div class="breadcrumb__option mb-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="shoping-cart spad">
        <div class="container">
            <?php if (isset($_GET['old'])) { ?>
                <a href="orders.php" class="btn btn-success mb-3">CURRENT ORDERS</a>
            <?php } else { ?>
                <a href="orders.php?old" class="btn btn-success mb-3">PREVIOUS ORDERS</a>
            <?php }
            $qry_cart = $db->prepare("SELECT * FROM orders WHERE created_by = '$user' AND status != 'pending' AND status != 'DELIVERED' AND status != 'CANCELED' ORDER BY id DESC");
            if (isset($_GET['old'])) {
                $qry_cart = $db->prepare("SELECT * FROM orders WHERE created_by = '$user' AND status = 'DELIVERED' OR status = 'CANCELED' ORDER BY id DESC");
            }
            $qry_cart->execute();
            $cart_count = $qry_cart->rowCount();
            if ($cart_count > 0) { ?>
                <div class="row">
                    <?php
                    for ($i = 0; $rows = $qry_cart->fetch(); $i++) {
                        $order_token = $rows['token'];
                        $order_status = $rows['status'];
                        $qry_cartc = $db->prepare("SELECT * FROM orders WHERE token = '$order_token'");
                        $qry_cartc->execute();
                        $cart_products = $qry_cartc->fetch();
                    ?>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header p-0">
                                    <button class="btn btn-block btn-dark text-left" type="button" data-toggle="collapse" data-target="#collapseExample<?php echo $i ?>" aria-expanded="false" aria-controls="collapseExample<?php echo $i ?>">
                                        <p class="small mb-0 text-light">Order #<?php echo $rows['token']; ?></p>
                                        <?php echo time_convert($rows['created_at']); ?><br>
                                        Status: <?php echo strtoupper($rows['status']); ?>
                                    </button>
                                </div>
                                <div class="card-body p-0">
                                    <div class="collapse" id="collapseExample<?php echo $i ?>">
                                        <div class="card card-body">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th class="shoping__product">Products</th>
                                                        <th>Price</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $qry_cart_in = $db->prepare("SELECT * FROM orders_products WHERE order_token = '$order_token'");
                                                $qry_cart_in->execute();
                                                for ($i2 = 0; $rows = $qry_cart_in->fetch(); $i2++) {
                                                ?>
                                                    <tr>
                                                        <td class="shoping__cart__item">
                                                            <?php echo strtoupper($rows['product_name']) ?><br>
                                                            <?php if ($order_status == 'DELIVERED') {
                                                            ?>
                                                                <a href="javascript:void(0);" class="btn btn-warning btn-sm px-5 py-1 dynamicPopup" data-pop="md" data-url="forms/review.php?token=<?php echo ($rows['product']) ?>&product=<?php echo strtoupper($rows['product_name']) ?>" data-toggle="modal" data-target="#dynamicPopup-md" data-backdrop="static" data-keyboard="false">RATE</a>
                                                            <?php
                                                            } ?>
                                                        </td>
                                                        <td class="shoping__cart__price">
                                                            <div class="text-danger small" style="text-decoration: line-through;"><?php echo number_format($rows['mrp'], 2); ?>x<?php echo $rows['qty'] ?></div>
                                                            <div class="small"><?php echo number_format($rows['rate'], 2); ?>x<?php echo $rows['qty'] ?></div>
                                                        </td>
                                                        <td class="shoping__cart__total">
                                                            <div class="text-danger small" style="text-decoration: line-through;"><?php echo number_format($rows['mrp_total'], 2); ?></div>
                                                            <div class="small"><?php echo number_format($rows['total'], 2); ?></div>
                                                        </td>
                                                    </tr>
                                                <?php  } ?>
                                            </table>
                                            <div class="shoping__checkout mt-1">
                                                <h5>Cart Total</h5>
                                                <ul>
                                                    <li>Subtotal <span class="text-dark">INR <?php echo number_format($cart_products['mrp_total'], 2) ?></span></li>
                                                    <li>Discount <span class="text-dark">INR <?php echo number_format(($cart_products['mrp_total'] - $cart_products['total']), 2) ?></span></li>
                                                    <li>Total <span class="text-dark">INR <?php echo number_format($cart_products['total'], 2) ?></span></li>
                                                </ul>
                                            </div>
                                            <?php if ($order_status == 'order placed') { ?>
                                                <a href="javscript:void(0)" class="btn btn-danger  dynamicPopup" data-pop="md" data-url="forms/order.cancel.php?token=<?php echo $order_token ?>" data-toggle="modal" data-target="#dynamicPopup-md" data-backdrop="static" data-keyboard="false">CANCEL ORDER</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php } else { ?>
                <div class="col-md-6 offset-md-3">
                    <img src="assets/img/mtcart.png" alt="">
                </div>
            <?php } ?>
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