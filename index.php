<?php
session_start();
include('admin/include/dbConnect.php');
include('admin/include/helper.php');
if (!isset($_SESSION['SESS_USER_TOKEN']) || trim($_SESSION['SESS_USER_TOKEN']) == '') {
    if (isset($_COOKIE["ME"])) {
        $fcm = $_COOKIE["ME"];

        $qry = $db->prepare("SELECT * FROM remember_token WHERE fcm_token = '$fcm'");
        $qry->execute();
        if ($qry->rowcount() > 0) {
            $row1 = $qry->fetch();
            $token = $row1['token'];
            $qry2 = $db->prepare("SELECT * FROM users WHERE token = '$fcm' AND status = 1");
            $qry2->execute();
            if ($qry2->rowcount() > 0) {
                $row = $qry2->fetch();
                $_SESSION['SESS_USER_ID'] = $row['id'];
                $_SESSION['SESS_USER_TOKEN'] = $row['token'];
                $_SESSION['SESS_USER_NAME'] = $row['name'];
                $_SESSION['SESS_USER_TYPE'] = $row['user_type'];
                $_SESSION['SESS_USER_EMAIL'] = $row['email'];

                $fcm = genToken();
                setcookie("ME", $fcm, time() + (86400 * 30), "/");
                $db->prepare("DELETE FROM remember_token WHERE fcm_token = '$fcm'")->execute();
        
                $stmt = $db->prepare("INSERT INTO remember_token (token, fcm_token, created_at) VALUES (:token, :fcm_token, :created_at)");
                $stmt->execute([':token' => $token, ':fcm_token' => $fcm, ':created_at' => $current_date_time_local]);

                $fcm_token = null;
                if (isset($_COOKIE['FCM_TOKEN']) && trim($_COOKIE['FCM_TOKEN']) != '') {
                    $fcm_token = $_COOKIE['FCM_TOKEN'];
                    $db->prepare("DELETE FROM fcm_token WHERE fcm_token = '$fcm_token'")->execute();

                    $stmt = $db->prepare("INSERT INTO fcm_token (token, fcm_token, created_at) VALUES (:token, :fcm_token, :created_at)");
                    $stmt->execute([':token' => $token, ':fcm_token' => $fcm_token, ':created_at' => $current_date_time_local]);
                }

                header("location: ../login.php?expired");
            } else {
                header("location: ../login.php?expired");
            }
        } else {
            header("location: ../login.php?expired");
        }
    } else {
        header("location: ../login.php?expired");
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
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Departments</span>
                        </div>
                        <ul>
                            <?php
                            // echo $_COOKIE["ME"];
                            $qry = $db->prepare("SELECT * FROM departments WHERE status = 1");
                            $qry->execute();
                            for ($i = 0; $rows = $qry->fetch(); $i++) {
                            ?>
                                <li><a href="shop.php?department=<?php echo $rows['token'] ?>"><?php echo ucwords($rows['name']) ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="#">
                                <input type="text" placeholder="What do yo u need?">
                                <button type="submit" class="site-btn">SEARCH</button>
                            </form>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5>+91 9846 9898 12</h5>
                                <span>Support 24/7</span>
                            </div>
                        </div>
                    </div>
                    <div class="hero__item set-bg" data-setbg="assets/img/hero/banner.jpg">
                        <div class="hero__text">
                            <!-- <span>FRUIT FRESH</span> -->
                            <h2>Fish <br />100% Fresh</h2>
                            <p>Free Pickup and Delivery Available</p>
                            <?php if (!isset($_SESSION['SESS_USER_TOKEN']) && !isset($_SESSION['SESS_ADMIN_TOKEN'])) { ?>
                                <a href="login.php" class="primary-btn">LOGIN</a>
                            <?php } ?>
                        </div>
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