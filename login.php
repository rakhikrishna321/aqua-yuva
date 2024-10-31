<?php
session_start();
include('admin/include/dbConnect.php');
include('admin/include/helper.php');
if (isset($_SESSION['SESS_USER_TOKEN']) && trim($_SESSION['SESS_USER_TOKEN']) != '') {
    header("location: ../");
}
if (isset($_COOKIE["ME"])) {
    $fcm = $_COOKIE["ME"];

    $qry = $db->prepare("SELECT * FROM users WHERE fcm = '$fcm' AND status = 1");
    $qry->execute();
    if ($qry->rowcount() > 0) {
        $row = $qry->fetch();
        $user_type = $row['user_type'];
        $token = $row['token'];
        if ($user_type == 'user') {
            $_SESSION['SESS_USER_ID'] = $row['id'];
            $_SESSION['SESS_USER_TOKEN'] = $row['token'];
            $_SESSION['SESS_USER_NAME'] = $row['name'];
            $_SESSION['SESS_USER_TYPE'] = $row['user_type'];
            $_SESSION['SESS_USER_EMAIL'] = $row['email'];
            $redirect_to = '../';
        } else {
            $_SESSION['SESS_ADMIN_ID'] = $row['id'];
            $_SESSION['SESS_ADMIN_TOKEN'] = $row['token'];
            $_SESSION['SESS_ADMIN_NAME'] = $row['name'];
            $_SESSION['SESS_ADMIN_TYPE'] = $row['user_type'];
            $_SESSION['SESS_ADMIN_EMAIL'] = $row['email'];
            $redirect_to = '/admin/dashboard.php';
        }

        $fcm = genToken();
        setcookie("ME", $fcm, time() + (86400 * 30), "/");

        $stmt = $db->prepare("UPDATE users SET fcm = :fcm WHERE token = :token");
        $stmt->execute([':fcm' => $fcm, ':token' => $token]);

        $fcm_token = null;
        if (isset($_COOKIE['FCM_TOKEN']) && trim($_COOKIE['FCM_TOKEN']) != '') {
            $fcm_token = $_COOKIE['FCM_TOKEN'];
            $db->prepare("DELETE FROM fcm_token WHERE fcm_token = '$fcm_token'")->execute();

            $stmt = $db->prepare("INSERT INTO fcm_token (token, fcm_token, created_at) VALUES (:token, :fcm_token, :created_at)");
            $stmt->execute([':token' => $token, ':fcm_token' => $fcm_token, ':created_at' => $current_date_time_local]);
        } ?>
        <script>
            window.location.href = '<?php echo $redirect_to ?>';
        </script>
<?php
    } else {
        $err = 'Session expired, please login again.';
    }
} else {
    $err = 'Session expired, please login again.';
}
$err = '';
if (isset($_GET['signout'])) {
    $err = 'Signed out successfully';
} elseif (isset($_GET['expired'])) {
    $err = 'Session expired, please login again.';
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
                        <h2>Login</h2>
                        <div class="breadcrumb__option">
                            <a href="../">Home</a>
                            <span>Login</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="contact-formd spad">
        <div class="container">
            <div class="col-md-6 offset-md-3 border p-5 shadow-lg rounded">
                <form id="login_form" action="/actions/auth.login.php" method="POST" autocomplete="off">
                    <div class="row">
                        <div class="col-12 mb-5 text-center">
                            <img src="assets/img/logo2.png" width="200" alt="">
                        </div>
                        <div class="col-12">
                            <input class="form-control form-control-lg mb-4 shadow" type="email" name="email" placeholder="email address" required>
                        </div>
                        <div class="col-12">
                            <input class="form-control form-control-lg mb-4 shadow mb-2" type="password" id="password" name="password" placeholder="password" required>
                            <label style="cursor: pointer;" class="nonselect"><input type="checkbox" onclick="showpwd('password')">&nbsp;&nbsp;Show Password</label>
                        </div>
                        <div class="col-lg-12 text-right">
                            <button type="submit" class="site-btn btn-lg shadow rounded">LOGIN</button>
                        </div>
                        <div class="col-12 mt-5 pt-5 text-center border-top">
                            <p>NEW HERE?</p>
                            <a href="register.php" class="btn btn-outline-dark">REGISTER NOW</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
    <script>
        <?php if ($err != '') { ?>
            err_msg('<?php echo $err ?>', 3);
        <?php } ?>
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
                            if (result.redirect_to == 'reload') {
                                location.reload();
                            } else {
                                window.location.href = window.location.origin + result.redirect_to;
                            }
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