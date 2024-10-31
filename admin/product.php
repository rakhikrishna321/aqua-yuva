<?php
include('include/auth.php');
include('include/dbConnect.php');
include('include/helper.php');
$token = $_GET['token'];
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
      <h1>PRODUCT DETAILS</h1>
    </div>
    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  NAME
                </div>
                <div class="card-body pt-3">
                  <?php echo ucwords($getRowVal->getRow('token', $token, 'products')['name']); ?>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  INFORMATION
                </div>
                <div class="card-body pt-3">
                  <?php echo ucfirst($getRowVal->getRow('token', $token, 'products')['description']); ?>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  OTHER SPECIFICATIONS
                </div>
                <div class="card-body pt-3">
                  <?php echo ucfirst($getRowVal->getRow('token', $token, 'products')['specification']); ?>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <div class="card-header">
                  MRP
                </div>
                <div class="card-body pt-3">
                  <?php echo number_format($getRowVal->getRow('token', $token, 'products')['mrp'], 2); ?>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <div class="card-header">
                  SELLING PRICE
                </div>
                <div class="card-body pt-3">
                  <?php echo number_format($getRowVal->getRow('token', $token, 'products')['rate'], 2); ?>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <div class="card-header">
                  STOCK
                </div>
                <div class="card-body pt-3">
                  <?php echo number_format($getRowVal->getRow('token', $token, 'products')['stock']); ?>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  IMAGES
                </div>
                <div class="card-body pt-3">
                  <div class="row">
                    <?php
                    $qry = $db->prepare("SELECT * FROM product_images WHERE product_token = '$token'");
                    $qry->execute();
                    for ($i = 0; $rows = $qry->fetch(); $i++) {
                      $cnm = '';
                      if ($rows['first_img'] == 1) {
                        $cnm = ' shadow-lg border-success';
                      }
                    ?>
                      <div class="col-md-3">
                        <img src="../<?php echo $rows['file_path']; ?>" class="w-100 border <?php echo $cnm ?>" alt="">
                        <a href="javascript:void(0)" onclick="dlt('<?php echo $rows['token'] ?>')" class="btn btn-danger btn-block w-100 rounded-0">DELETE</a>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  ACTIONS
                </div>
                <div class="card-body pt-3">
                  <a class="btn me-2 btn-dark dynamicPopup" data-pop="md" data-url="forms/product.update.php?token=<?php echo $token ?>" data-bs-toggle="modal" data-bs-target="#dynamicPopup-md" data-bs-backdrop="static" data-bs-keyboard="false" href="javascript:void(0)">
                    UPDATE PRODUCT
                  </a>
                  <a class="btn me-2 btn-dark dynamicPopup" data-pop="md" data-url="forms/product.image.php?token=<?php echo $token ?>" data-bs-toggle="modal" data-bs-target="#dynamicPopup-md" data-bs-backdrop="static" data-bs-keyboard="false" href="javascript:void(0)">
                    UPLOAD IMAGE
                  </a>
                  <a class="btn me-2 btn-dark dynamicPopup" data-pop="md" data-url="forms/product.stock.php?token=<?php echo $token ?>" data-bs-toggle="modal" data-bs-target="#dynamicPopup-md" data-bs-backdrop="static" data-bs-keyboard="false" href="javascript:void(0)">
                    UPDATE STOCK
                  </a>
                  <a class="btn me-2 btn-dark dynamicPopup" data-pop="md" data-url="forms/product.pricing.php?token=<?php echo $token ?>" data-bs-toggle="modal" data-bs-target="#dynamicPopup-md" data-bs-backdrop="static" data-bs-keyboard="false" href="javascript:void(0)">
                    UPDATE PRICE
                  </a>
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
  <script>
    function dlt(token) {
      $.ajax({
        type: "POST",
        url: window.location.origin + '/admin/actions/image.delete.php?token=' + token,
        data: '',
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
          let result = JSON.parse(JSON.stringify(data));
          if (result.status == 1) {
            success_msg(result.message, 3);
            setTimeout(function() {
              location.reload();
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
    }
  </script>
</body>

</html>