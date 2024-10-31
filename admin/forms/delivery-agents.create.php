<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');
?>
<div class="modal-header">
    <h3 class="modal-title text-uppercase text-center w-100 nf">CREATE delivery agents</h3>
</div>
<form action="/admin/actions/delivery-agents.create.php" id="department_create" method="POST" autocomplete="off">
    <div class="modal-body" style="max-height: 70vh;overflow:auto;">
        <div class="row">
            <div class="form-group col-md-12">
                <label class="text-uppercase">Name</label>
                <input type="text" name="name" class="form-control form-control-lg" required>
            </div>
            <div class="form-group col-md-12 mt-3">
                <label class="text-uppercase">Email</label>
                <input type="email" name="email" class="form-control form-control-lg" required>
            </div>
            <div class="form-group col-md-12 mt-3">
                <label class="text-uppercase">Contact Number</label>
                <input type="number" name="phone" class="form-control form-control-lg" required>
            </div>
            <div class="form-group col-md-12 mt-3">
                <label class="text-uppercase">Password</label>
                <input type="text" name="password" class="form-control form-control-lg" value="<?php echo rand(); ?>" required>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary px-4 rounded-c" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success px-4 rounded-c" name="submit">Save</button>
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