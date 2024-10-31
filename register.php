<?php
session_start();
include('admin/include/dbConnect.php');
include('admin/include/helper.php');
if (isset($_SESSION['SESS_USER_TOKEN']) && trim($_SESSION['SESS_USER_TOKEN']) != '') {
    header("location: ../");
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
    <script src="assets/js/jquery-3.3.1.min.js"></script>
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
                        <h2>Register</h2>
                        <div class="breadcrumb__option">
                            <a href="../">Home</a>
                            <span>Register</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="contact-formd spad">
        <div class="container">
            <div class="col-md-6 offset-md-3 border p-5 shadow-lg rounded">
                <form id="login_form" action="/actions/auth.register.php" method="POST" autocomplete="off">
                    <div class="row">
                        <div class="col-12 mb-5 text-center">
                            <img src="assets/img/logo2.png" width="200" alt="">
                        </div>
                        <div class="col-12">
                            <input class="form-control form-control-lg mb-4 shadow" type="text" name="name" placeholder="Your name" required>
                        </div>
                        <div class="col-12">
                            <input class="form-control form-control-lg mb-4 shadow" type="number" name="phone" placeholder="Your contact number" required>
                        </div>
                        <div class="col-12">
                            <input class="form-control form-control-lg mb-4 shadow" type="email" name="email" placeholder="email address" required>
                        </div>
                        <div class="col-12">
                            <input class="form-control form-control-lg mb-4 shadow mb-2" type="password" id="password" name="password" placeholder="password" required>
                            <label style="cursor: pointer;"><input type="checkbox" onclick="showpwd('password')">&nbsp;&nbsp;Show Password</label>
                        </div>
                        <div class="col-12 text-right mt-4">
                            <button type="submit" class="site-btn btn-lg shadow rounded">REGISTER</button>
                        </div>
                        <div class="col-12 mt-5 pt-5 text-center border-top">
                            <p>ALREADY REGISTERED?</p>
                            <a href="login.php" class="btn btn-outline-dark">LOGIN NOW</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include 'include/footer.php'; ?>
    <?php include("admin/include/notify.php"); ?>
    <?php require_once 'include/popup.inc.php'; ?>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.nice-select.min.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/jquery.slicknav.js"></script>
    <script src="assets/js/mixitup.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        $('#login_form').on('submit', function(e) {
            e.preventDefault();

            let target = $('#login_form').attr('action');
            let formData = new FormData(document.getElementById("login_form"));
            $.ajax({
                type: "POST",
                url: window.location.origin + target,
                data: formData,
                dataType: "JSON",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    let result = JSON.parse(JSON.stringify(data));
                    if (result.status == 1) {
                        success_msg(result.message, 3);
                        setTimeout(function() {
                            window.location.href = window.location.origin + "/";
                        }, 1000);
                    } else {
                        err_msg(result.message, 3);
                    }
                },
                error: function(data) {
                    console.log("error");
                    console.log(data);
                },
            });
        });
    </script>
</body>

</html>