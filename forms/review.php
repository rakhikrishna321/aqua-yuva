<?php
session_start();
include('../admin/include/dbConnect.php');
include('../admin/include/helper.php');
$user = $_SESSION['SESS_USER_TOKEN'];
$product = $_GET['token'];

$rating_value = '';
$rating_text = '';
$review = '';
$qry = $db->prepare("SELECT * FROM rating WHERE created_by = '$user' AND product = '$product'");
$qry->execute();
if ($qry->rowCount() > 0) {
    $rows = $qry->fetch();
    $rating_value = $rows['rating'];
    $review = $rows['review'];
    $rating_text = 'Excellent (' . $rating_value . ' stars)';
    if ($rating_value == 4) {
        $rating_text = 'Very Good (' . $rating_value . ' stars)';
    } elseif ($rating_value == 3) {
        $rating_text = 'Good (' . $rating_value . ' stars)';
    } elseif ($rating_value == 2) {
        $rating_text = 'Weak (' . $rating_value . ' stars)';
    } elseif ($rating_value == 1) {
        $rating_text = 'Poor (' . $rating_value . ' stars)';
    }
}
?>
<div class="modal-header">
    <h3 class="modal-title text-uppercase text-center w-100 nf">RATE PRODUCT - <?php echo $_GET['product'] ?></h3>
</div>
<form action="/actions/review.php" id="review_form" method="POST" autocomplete="off">
    <input type="hidden" name="product" value="<?php echo $product; ?>">
    <div class="modal-body" style="max-height: 70vh;overflow:auto;">
        <div class="row">
            <div class="form-group col-md-12">
                <label for="inputAddress" class="col-form-label">Choose rating</label>
                <select name="rating" class="form-control w-100 form-control-lg" placeholder="" required>
                    <?php if ($qry->rowCount() > 0) { ?>
                        <option value="<?php echo $rating_value ?>"><?php echo $rating_text ?></option>
                    <?php } else { ?>
                        <option value="">choose one</option>
                    <?php } ?>
                    <option value="5">Excellent (5 stars)</option>
                    <option value="4">Very Good (4 stars)</option>
                    <option value="3">Good (3 stars)</option>
                    <option value="2">Weak (2 stars)</option>
                    <option value="1">Poor (1 stars)</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12 mb-0">
                <label for="inputAddress" class="col-form-label">Your Review</label>
                <textarea name="review" id="review" rows="8" style="resize:none" class="form-control form-control-lg rounded-c" placeholder="type your review here..." required><?php echo $review ?></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary px-4 rounded-c" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success px-4 rounded-c" name="submit">Submit</button>
    </div>
</form>
<script>
    $('#review_form').on('submit', function(e) {
        e.preventDefault();

        let target = $('#review_form').attr('action');
        let formData = new FormData(document.getElementById("review_form"));
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