<?php
include('include/auth.php');
include('include/dbConnect.php');
include('include/helper.php');
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
    <?php if ($_SESSION['SESS_ADMIN_TYPE'] == 'delivery') {
      include("include/delivery.dahsbord.php");
    } ?>
    <div class="pagetitle mb-4">
      <h1>Dashboard</h1>
    </div>
    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>
                <div class="card-body">
                  <h5 class="card-title">Recent Sales <span>| Today</span></h5>
                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Department</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Price</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $qry_cart = $db->prepare("SELECT * FROM orders WHERE status != 'pending' LIMIT 100");
                      if ($_SESSION['SESS_ADMIN_TYPE'] == 'department') {
                        $qry_cart = $db->prepare("SELECT * FROM orders WHERE department_token = '$user' AND status != 'DELIVERED' AND status != 'pending'");
                      }
                      $qry_cart->execute();
                      if ($qry_cart->rowcount() > 0) {
                        for ($i = 0; $rows = $qry_cart->fetch(); $i++) {
                          $order_token = $rows['token'];
                          $qry_cartc = $db->prepare("SELECT * FROM orders WHERE token = '$order_token'");
                          $qry_cartc->execute();
                          $order_details = $qry_cartc->fetch();

                          $created_by = ucwords($getRowVal->getRow('token', $rows['created_by'], 'users')['name']);
                      ?>
                          <tr>
                            <th scope="row"><a href="#">#<?php echo $order_details['token'] ?></a></th>
                            <td><?php echo ucwords($getRowVal->getRow('token', $rows['department_token'], 'users')['name']); ?></td>
                            <td><?php echo $created_by ?></td>
                            <td><?php echo $order_details['total'] ?></td>
                            <td><span class="badge border text-dark"><?php echo strtoupper($order_details['status']) ?></span></td>
                          </tr>
                        <?php } ?>
                      <?php } ?>
                    </tbody>
                  </table>

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