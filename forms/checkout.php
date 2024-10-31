<?php
session_start();
include('../admin/include/dbConnect.php');
include('../admin/include/helper.php');
$user = $_SESSION['SESS_USER_TOKEN'];

?>
<div class="modal-header">
    <h3 class="modal-title text-uppercase text-center w-100 nf">CHECKOUT</h3>
</div>
<form action="/actions/checkout.php" id="checkout_form" method="POST" autocomplete="off">
    <div class="modal-body" style="max-height: 70vh;overflow:auto;">
        <div class="row">
            <div class="form-group col-md-12">
                <label class="text-uppercase">Delivery Adddress</label>
                <textarea name="delivery_address" class="form-control form-control-lg" rows="6" style="resize: none;" required></textarea>
            </div>
            <div class="form-group col-md-12 mt-3">
                <label class="text-uppercase">Pincode</label>
                <input type="number" name="delivery_pincode" class="form-control form-control-lg" required>
            </div>
            <div class="form-group col-md-12 mt-3">
                <label class="text-uppercase">Contact Number</label>
                <input type="number" name="delivery_contact" class="form-control form-control-lg" required value="<?php echo $getRowVal->getRow('token', $user, 'users')['phone']; ?>">
            </div>
            <div class="form-group col-md-12 mt-3">
                <label class="text-uppercase">Payment</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="exampleRadios1" value="COD" name="payment" checked>
                    <label class="form-check-label" for="exampleRadios1">
                        CASH ON DELIVERY
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="exampleRadios2" value="PAID" name="payment">
                    <label class="form-check-label" for="exampleRadios2">
                        PAY ONLINE
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary px-4 rounded-c" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success px-4 rounded-c" name="submit">Place Order</button>
    </div>
</form>
<script>
    $('#checkout_form').on('submit', function(e) {
        e.preventDefault();

        let target = $('#checkout_form').attr('action');
        let formData = new FormData(document.getElementById("checkout_form"));
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
                        window.location.href = window.location.origin + "/orders.php";
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