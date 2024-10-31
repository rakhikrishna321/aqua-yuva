<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');
$token = $_GET['token'];
?>
<div class="modal-header">
    <h3 class="modal-title text-uppercase text-center w-100 nf">UPDATE PRODUCT</h3>
</div>
<form action="/admin/actions/product.image.php" id="product_image" method="POST" autocomplete="off">
    <input type="hidden" name="product_token" id="product_token" value="<?php echo $token ?>">
    <div class="modal-body" style="max-height: 70vh;overflow:auto;">
        <div class="row">
            <div class="form-group col-md-12">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="1" id="first_img" name="first_img">
                    <label class="form-check-label" for="first_img">
                        FIRST IMAGE
                    </label>
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="text-uppercase">Choose a file (Size: 1:1)</label>
                <input type="file" name="file" id="file" class="form-control" placeholder="" required>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary px-4 rounded-c" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success px-4 rounded-c" name="submit">Save</button>
    </div>
</form>
<script>
    $('#product_image').on('submit', function(event) {
        event.preventDefault();

        let target = $('#product_image').attr('action');
        var formData = new FormData();
        var files = $('#file')[0].files;
        var checkBox = document.getElementById("first_img");
        formData.append('product_token', $('#product_token').val());
        if (checkBox.checked) {
            formData.append('first_img', 1);
        } else {
            formData.append('first_img', 0);
        }

        console.log(files.length);
        if (files.length > 0) {
            formData.append('file', files[0]);
            $.ajax({
                url: window.location.origin + target,
                type: "POST",
                data: formData,
                dataType: 'JSON',
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
        } else {
            noti('Select a file to upload', 3);
        }
    });
</script>