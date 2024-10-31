<?php
include('../include/auth.php');
include('../admin/include/dbConnect.php');
include('../admin/include/helper.php');
$token = $_GET['token'];
?>
<div class="modal-header">
    <h3 class="modal-title text-uppercase text-center w-100 nf">CANCEL ORDER</h3>
</div>
<form action="/actions/order.cancel.php" id="order_cancel" method="POST" autocomplete="off">
    <input type="hidden" name="token" value="<?php echo $token ?>">
    <div class="modal-body" style="max-height: 70vh;overflow:auto;">
        <div class="row">
            <div class="form-group col-md-12">
                Are you sure?<br>Do you want to cancel the order #<?php echo $token ?>?<br>There is no undo for this action.
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary px-4 rounded-c" data-dismiss="modal">Go back</button>
        <button type="submit" class="btn btn-success px-4 rounded-c" name="submit">Yes, Cancel the Order</button>
    </div>
</form>
<script>
    $('#order_cancel').on('submit', function(e) {
        e.preventDefault();
        let target = $('#order_cancel').attr('action');
        let formData = new FormData(document.getElementById("order_cancel"));
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