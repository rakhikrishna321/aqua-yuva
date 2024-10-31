<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');
$token = $_GET['token'];
?>
<div class="modal-header">
    <h3 class="modal-title text-uppercase text-center w-100 nf">UPDATE PRODUCT</h3>
</div>
<form action="/admin/actions/product.stock.php" id="product_stock" method="POST" autocomplete="off">
    <input type="hidden" name="token" value="<?php echo $token ?>">
    <div class="modal-body" style="max-height: 70vh;overflow:auto;">
        <div class="row">
            <div class="form-group col-md-12">
                <label class="text-uppercase">Stock</label>
                <input type="number" onClick="this.select();" name="stock" class="form-control form-control-lg" required value="<?php echo $getRowVal->getRow('token', $token, 'products')['stock']; ?>">
            </div>
        </div>
    </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary px-4 rounded-c" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success px-4 rounded-c" name="submit">Save Changes</button>
    </div>
</form>
<script>
    $('#product_stock').on('submit', function(e) {
        e.preventDefault();
        let target = $('#product_stock').attr('action');
        let formData = new FormData(document.getElementById("product_stock"));
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