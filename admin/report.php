<?php
include('include/auth.php');
include('include/dbConnect.php');
include('include/helper.php');
$title = '';
if (!isset($_GET['dated'])) {
    header("location:report.php?dated=$today_local");
}
$dated = ($_GET['dated']);
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
                                <div class="card-header">
                                    <form class="col-md-4">
                                        <input type="date" value="<?php echo $dated ?>" name="dated" class="form-control" onchange="this.form.submit()">
                                    </form>
                                </div>
                                <div class="card-body">
                                    <?php
                                    if ($_SESSION['SESS_ADMIN_TYPE'] == 'delivery') {
                                        $qry_cart = $db->prepare("SELECT * FROM orders WHERE status = 'DELIVERED' AND payment = 'COD' AND delivered_at LIKE '$dated%'");
                                        $qry_cart->execute();
                                        if ($qry_cart->rowcount() > 0) {
                                    ?>
                                            <table class="table">
                                                <tr>
                                                    <th>Order #</th>
                                                    <th class="text-end">Amount</th>
                                                </tr>
                                                <?php
                                                $gt = 0;
                                                for ($i = 0; $rows = $qry_cart->fetch(); $i++) {
                                                    $gt += $rows['total'];
                                                ?>
                                                    <tr>
                                                        <td><?php echo $rows['token'] ?></td>
                                                        <td class="text-end"><?php echo number_format($rows['total'], 2) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th class="text-end">TOTAL COD</th>
                                                    <th class="text-end"><?php echo number_format($gt, 2) ?></th>
                                                </tr>
                                            </table>
                                        <?php } else { ?>
                                            <div class="col-12" style="padding:31vh 1rem;">
                                                <h3 class="text-center text-muted">NO DATA FOUND</h3>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php
                                    if ($_SESSION['SESS_ADMIN_TYPE'] == 'department') {
                                        $qry_cart = $db->prepare("SELECT * FROM orders WHERE department_token = '$user' AND status = 'DELIVERED' AND created_at LIKE '$dated%'");
                                        $qry_cart->execute();
                                        if ($qry_cart->rowcount() > 0) {
                                    ?>
                                            <table class="table">
                                                <tr>
                                                    <th>Order #</th>
                                                    <th class="text-end">Amount</th>
                                                </tr>
                                                <?php
                                                $gt = 0;
                                                for ($i = 0; $rows = $qry_cart->fetch(); $i++) {
                                                    $gt += $rows['total'];
                                                ?>
                                                    <tr>
                                                        <td><?php echo $rows['token'] ?></td>
                                                        <td class="text-end"><?php echo number_format($rows['total'], 2) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th class="text-end">TOTAL COD</th>
                                                    <th class="text-end"><?php echo number_format($gt, 2) ?></th>
                                                </tr>
                                            </table>
                                        <?php } else { ?>
                                            <div class="col-12" style="padding:31vh 1rem;">
                                                <h3 class="text-center text-muted">NO DATA FOUND</h3>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
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