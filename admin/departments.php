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
    <div class="pagetitle mb-4">
      <h1>Department Admin</h1>
    </div>
    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">
                    <a class="btn btn-dark dynamicPopup" data-pop="md" data-url="forms/department.create.php" data-bs-toggle="modal" data-bs-target="#dynamicPopup-md" data-bs-backdrop="static" data-bs-keyboard="false" href="javascript:void(0)">
                      ADD NEW
                    </a>
                  </h5>
                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Handled By</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Login</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $qry = $db->prepare("SELECT * FROM departments");
                      $qry->execute();
                      for ($i = 0; $rows = $qry->fetch(); $i++) {
                        $token = $rows['token'];
                      ?>
                        <tr>
                          <td><?php echo $rows['id']; ?></td>
                          <td><?php echo ucwords($rows['name']); ?></td>
                          <td><?php echo ucwords($rows['handled_by']); ?></td>
                          <td><?php echo $rows['phone']; ?></td>
                          <td>
                            <?php echo $rows['email']; ?><br>
                            <?php echo $getRowVal->getRow('token', $token, 'users')['password']; ?>
                          </td>
                          <td class="text-center">
                            <?php
                            if ($rows['status'] == 1) {
                              echo '<span class="btn btn-success btn-sm text-uppercase">Active</span>';
                            } else {
                              echo '<span class="btn btn-danger btn-sm text-uppercase">Hidden</span>';
                            } ?>
                          </td>
                          <td class="text-center">
                            <div class="btn-group">
                              <?php
                              if ($rows['status'] == 1) {
                              ?>
                                <a href="actions/department.status.php?token=<?php echo $token ?>&status=0" class="btn btn-danger btn-sm">
                                  BLOCK
                                </a>
                              <?php
                              } else {
                              ?>
                                <a href="actions/department.status.php?token=<?php echo $token ?>&status=1" class="btn btn-primary btn-sm">
                                  UNBLOCK
                                </a>
                              <?php
                              } ?>
                              <a class="btn btn-dark btn-sm dynamicPopup" data-pop="md" data-url="forms/department.update.php?token=<?php echo $token ?>" data-bs-toggle="modal" data-bs-target="#dynamicPopup-md" data-bs-backdrop="static" data-bs-keyboard="false" href="javascript:void(0)">
                                UPDATE
                              </a>
                            </div>
                          </td>
                        </tr>
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