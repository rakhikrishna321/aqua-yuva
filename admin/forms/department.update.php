<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');
$token = $_GET['token'];
?>
<div class="modal-header">
    <h3 class="modal-title text-uppercase text-center w-100 nf">CREATE DEPARTMENT</h3>
</div>
<form action="/admin/actions/department.update.php" id="department_create" method="POST" autocomplete="off">
    <input type="hidden" name="token" value="<?php echo $token ?>">
    <div class="modal-body" style="max-height: 70vh;overflow:auto;">
        <div class="row">
            <div class="form-group col-md-12">
                <label class="text-uppercase">Name</label>
                <input type="text" name="name" class="form-control form-control-lg" required value="<?php echo $getRowVal->getRow('token', $token, 'departments')['name']; ?>">
            </div>
            <div class="form-group col-md-12 mt-3">
                <label class="text-uppercase">Handled by</label>
                <input type="text" name="handled_by" class="form-control form-control-lg" required value="<?php echo $getRowVal->getRow('token', $token, 'departments')['handled_by']; ?>">
            </div>
            <div class="form-group col-md-12 mt-3">
                <label class="text-uppercase">Email</label>
                <input type="email" name="email" class="form-control form-control-lg" required value="<?php echo $getRowVal->getRow('token', $token, 'departments')['email']; ?>">
            </div>
            <div class="form-group col-md-12 mt-3">
                <label class="text-uppercase">Contact Number</label>
                <input type="number" name="phone" class="form-control form-control-lg" required value="<?php echo $getRowVal->getRow('token', $token, 'departments')['phone']; ?>">
            </div>
            <div class="form-group col-md-12 mt-3">
                <label class="text-uppercase">Password</label>
                <input type="text" name="password" class="form-control form-control-lg" required value="<?php echo $getRowVal->getRow('token', $token, 'users')['password']; ?>">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary px-4 rounded-c" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success px-4 rounded-c" name="submit">Update</button>
    </div>
</form>
<script>
    $('#department_create').on('submit', function(e) {
        e.preventDefault();
        let target = $('#department_create').attr('action');
        let formData = new FormData(document.getElementById("department_create"));
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
    });
</script>