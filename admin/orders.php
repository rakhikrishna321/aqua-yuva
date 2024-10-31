<?php
include('include/auth.php');
include('include/dbConnect.php');
include('include/helper.php');
$title = 'CURRENT ORDERS';
if (isset($_GET['old'])) {
    $title = 'DELIVERED/CANCELED ORDERS';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Aqua Admin</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <?php include 'include/header.php'; ?>
    <?php include 'include/sidebar.php'; ?>
    <main id="main" class="main">
        <div class="pagetitle mb-4">
            <h1><?php echo $title ?></h1>
        </div>
        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">
                                <div class="card-body">
                                    <h5 class="card-title">
                                    </h5>
                                    <?php
                                    $qry_cart = $db->prepare("SELECT * FROM orders WHERE department_token = '$user' AND status != 'pending' AND status != 'DELIVERED' AND status != 'CANCELED' ORDER BY id DESC");
                                    if (isset($_GET['old'])) {
                                        $qry_cart = $db->prepare("SELECT * FROM orders WHERE department_token = '$user' AND status = 'DELIVERED' OR status = 'CANCELED' ORDER BY id DESC");
                                    }
                                    $qry_cart->execute();
                                    if ($qry_cart->rowcount() > 0) {
                                        for ($i = 0; $rows = $qry_cart->fetch(); $i++) {
                                            $order_token = $rows['token'];
                                            $order_status = $rows['status'];
                                            $qry_cartc = $db->prepare("SELECT * FROM orders WHERE token = '$order_token'");
                                            $qry_cartc->execute();
                                            $order_details = $qry_cartc->fetch();
                                    ?>
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header p-0">
                                                        <button class="btn btn-block w-100 btn-dark text-left" style="text-align:left;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample<?php echo $i ?>" aria-expanded="false" aria-controls="collapseExample<?php echo $i ?>">
                                                            <p class="small mb-0 text-light">Order #<?php echo $rows['token']; ?></p>
                                                            <?php echo time_convert($rows['created_at']); ?><br>
                                                            Status: <?php echo strtoupper($rows['status']); ?>
                                                        </button>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="collapse" id="collapseExample<?php echo $i ?>">
                                                            <div class="card card-body pt-3">
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
                                                                            <td>
                                                                                <?php echo strtoupper($rows['product_name']) ?>
                                                                            </td>
                                                                            <td>
                                                                                <div class="text-danger small" style="text-decoration: line-through;"><?php echo number_format($rows['mrp'], 2); ?>x<?php echo $rows['qty'] ?></div>
                                                                                <div class="small"><?php echo number_format($rows['rate'], 2); ?>x<?php echo $rows['qty'] ?></div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="text-danger small" style="text-decoration: line-through;"><?php echo number_format($rows['mrp_total'], 2); ?></div>
                                                                                <div class="small"><?php echo number_format($rows['total'], 2); ?></div>
                                                                            </td>
                                                                        </tr>
                                                                    <?php  } ?>
                                                                </table>
                                                                <div class="shoping__checkout mt-1">
                                                                    <p>Cart Total</p>
                                                                    <ul>
                                                                        <li>Subtotal <span class="text-dark">INR <?php echo number_format($order_details['mrp_total'], 2) ?></span></li>
                                                                        <li>Discount <span class="text-dark">INR <?php echo number_format(($order_details['mrp_total'] - $order_details['total']), 2) ?></span></li>
                                                                        <li>Total <span class="text-dark">INR <?php echo number_format($order_details['total'], 2) ?></span></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-12">
                                                                    <p>Deliver to:<br><?php echo $order_details['delivery_address'] ?> - <?php echo $order_details['delivery_pincode'] ?></p>
                                                                    <p>Contact:<br><?php echo $order_details['delivery_contact'] ?></p>
                                                                    <?php if ($order_status != 'CANCELED' && $order_status != 'DELIVERED') { ?>
                                                                        <a href="javascript:void(0);" class="btn btn-success dynamicPopup" data-pop="md" data-url="forms/order.status.php?token=<?php echo $order_token ?>" data-bs-toggle="modal" data-bs-target="#dynamicPopup-md" data-bs-backdrop="static" data-bs-keyboard="false">ORDER STATUS</a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }
                                    } else { ?>
                                        <div class="col-12" style="padding:31vh 1rem;">
                                            <h3 class="text-center text-muted">NO DATA FOUND</h3>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <?php include("include/notify.php"); ?>
    <?php require_once 'include/popup.inc.php'; ?>
    <script src="../assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>