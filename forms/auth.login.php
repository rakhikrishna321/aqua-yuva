<?php
include('../admin/include/dbConnect.php');
include('../admin/include/helper.php');
?>
<div class="modal-header">
    <div class="col-12 mb-3 mt-3 text-center">
        <img src="assets/img/logo2.png" width="200" alt="">
    </div>
</div>
<form id="login_form" action="/actions/auth.login.php" method="POST" autocomplete="off">
    <div class="modal-body" style="max-height: 70vh;overflow:auto;">
        <div class="row">
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
            <div class="col-12 mt-5 pt-3 mb-3 text-center border-top">
                <p>NEW HERE?</p>
                <a href="register.php" class="btn btn-outline-dark">REGISTER NOW</a>
            </div>
        </div>
    </div>
</form>
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
                        window.location.href = window.location.origin + "/dashboard.php";
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