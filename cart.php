<?php
session_start();
include('admin/include/dbConnect.php');
include('admin/include/helper.php');
$user = $_SESSION['SESS_USER_TOKEN'];
$cart_count = 0;
$cart_val = 0;
$qry_cart = $db->prepare("SELECT * FROM orders WHERE created_by = '$user' AND status = 'pending'");
$qry_cart->execute();
$cart_count = $qry_cart->rowcount();
if ($cart_count > 0) {
    $cart_products = $qry_cart->fetch();
    $order_token = $cart_products['token'];
    $cart_val = $cart_products['total'];
    $qry_cart = $db->prepare("SELECT * FROM orders_products WHERE order_token = '$order_token'");
    $qry_cart->execute();
    $cart_count = $qry_cart->rowcount();
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
                        <h2>CART</h2>
                        <div class="breadcrumb__option mb-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="shoping-cart spad">
        <div class="container">
            <?php if ($cart_count > 0) { ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="shoping__cart__table">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="shoping__product">Products</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $rows = $qry_cart->fetch(); $i++) {
                                        $pro = $rows['product'];
                                        $stock = $getRowVal->getRow('token', $pro, 'products')['stock'];
                                    ?>
                                        <tr>
                                            <td class="shoping__cart__item">
                                                <h5><?php echo strtoupper($rows['product_name']) ?></h5>
                                            </td>
                                            <td class="shoping__cart__price">
                                                <div class="text-danger small" style="text-decoration: line-through;"><?php echo number_format($rows['mrp'], 2); ?></div>
                                                <div class="small"><?php echo number_format($rows['rate'], 2); ?></div>
                                            </td>
                                            <td class="shoping__cart__quantity text-center">
                                                <span style="display: inline-block;">
                                                    <select id="<?php echo $rows['product'] ?>" onchange="updatecart('<?php echo $rows['product'] ?>')">
                                                        <option><?php echo $rows['qty'] ?></option>
                                                        <?php
                                                        for ($i2 = 1; $i2 < 6; $i2++) {
                                                            if ($i2 != $rows['qty'] && $i2 <= $stock) {
                                                                echo '<option>' . $i2 . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </span>
                                            </td>
                                            <td class="shoping__cart__total">
                                                <div class="text-danger small" style="text-decoration: line-through;"><?php echo number_format($rows['mrp_total'], 2); ?></div>
                                                <div class="small"><?php echo number_format($rows['total'], 2); ?></div>
                                            </td>
                                            <td class="shoping__cart__item__close">
                                                <span class="icon_close" onclick="deletecart('<?php echo $rows['product'] ?>')"></span>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 offset-lg-6">
                        <div class="shoping__checkout">
                            <h5>Cart Total</h5>
                            <ul>
                                <li>Subtotal <span class="text-dark">INR <?php echo number_format($cart_products['mrp_total'], 2) ?></span></li>
                                <li>Discount <span class="text-dark">INR <?php echo number_format(($cart_products['mrp_total'] - $cart_products['total']), 2) ?></span></li>
                                <li>Total <span class="text-dark">INR <?php echo number_format($cart_products['total'], 2) ?></span></li>
                            </ul>
                            <a href="javascript:void(0);" class="primary-btn dynamicPopup" data-pop="md" data-url="forms/checkout.php" data-toggle="modal" data-target="#dynamicPopup-md" data-backdrop="static" data-keyboard="false">PROCEED TO CHECKOUT</a>
                        </div>
                    </div>
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