<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');
?>
<div class="modal-header">
    <h3 class="modal-title text-uppercase text-center w-100 nf">UPDATE PASSWORD</h3>
</div>
<form action="/admin/actions/password.update.php" id="password_update" method="POST" autocomplete="off">
    <div class="modal-body" style="max-height: 70vh;overflow:auto;">
        <div class="row">
            <div class="form-group col-md-12 mt-3">
                <label class="text-uppercase">Current password</label>
                <input type="password" name="cpassword" class="form-control form-control-lg" required>
            </div>
            <div class="form-group col-md-12 mt-3">
                <label class="text-uppercase">New password</label>
                <input type="password" name="npassword" class="form-control form-control-lg" required>
            </div>
            <div class="form-group col-md-12 mt-3">
                <label class="text-uppercase">Re-enter new password</label>
                <input type="password" name="rnpassword" class="form-control form-control-lg" required>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary px-4 rounded-c" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success px-4 rounded-c" name="submit">Save & Logout</button>
    </div>
</form>
<script>
    $('#password_update').on('submit', function(e) {
        e.preventDefault();
        let target = $('#password_update').attr('action');
        let formData = new FormData(document.getElementById("password_update"));
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
                        window.location.href = window.location.origin + result.redirect_to;
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