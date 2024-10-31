<?php
session_start();
include('admin/include/dbConnect.php');
include('admin/include/helper.php');
if (isset($_GET['department'])) {
    $department = trim($_GET['department']);
} else {
    header("location:../");
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
    <?php include 'include/header2.php'; ?>
    <section class="breadcrumb-section set-bg" data-setbg="assets/img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2><?php echo ucwords($getRowVal->getRow('token', $department, 'departments')['name']) ?></h2>
                        <div class="breadcrumb__option mb-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <?php
                        $qry = $db->prepare("SELECT * FROM products WHERE department = '$department' AND rate > 0 AND status = 1");
                        $qry->execute();
                        for ($i = 0; $rows = $qry->fetch(); $i++) {
                            $product_token = $rows['token'];
                            $img = 'assets/img/product/product-1.jpg';
                            $qry2 = $db->prepare("SELECT * FROM product_images WHERE product_token = '$product_token' AND first_img = 1");
                            $qry2->execute();
                            if ($qry2->rowcount() > 0) {
                                $rows2 = $qry2->fetch();
                                $img = $rows2['file_path'];
                            }
                        ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item border rounded shadow">
                                    <div class="product__item__pic set-bg" data-setbg="<?php echo $rows2['file_path'] ?>">
                                        <!-- <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul> -->
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="product.php?token=<?php echo $product_token ?>"><?php echo ucwords($rows['name']) ?></a></h6>
                                        <h5>Rs. <?php echo number_format($rows['rate'], 2); ?></h5>
                                        <a href="product.php?token=<?php echo $product_token ?>" class="btn btn-dark btn-sm mt-3 mb-3 px-5">VIEW DETAILS</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include 'include/footer.php'; ?>
    <!-- Js Plugins -->
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