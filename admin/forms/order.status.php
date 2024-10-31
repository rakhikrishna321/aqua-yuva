<?php
include('../include/auth.php');
include('../include/dbConnect.php');
include('../include/helper.php');
$token = $_GET['token'];
?>
<div class="modal-header">
    <h3 class="modal-title text-uppercase text-center w-100 nf">UPDATE STATUS</h3>
</div>
<form action="/admin/actions/order.status.php" id="order_status" method="POST" autocomplete="off">
    <input type="hidden" name="token" value="<?php echo $token ?>">
    <input type="hidden" id="cstatus" value="<?php echo $getRowVal->getRow('token', $token, 'orders')['status']; ?>">
    <div class="modal-body" style="max-height: 70vh;overflow:auto;">
        <div class="row">
            <div class="form-group col-md-12">
                <label class="text-uppercase">Order Status</label>
                <select name="status" id="status" class="form-control form-control-lg" onchange="dagent()" required>
                    <option value="<?php echo $getRowVal->getRow('token', $token, 'orders')['status']; ?>"><?php echo strtoupper($getRowVal->getRow('token', $token, 'orders')['status']); ?></option>
                    <?php
                    if ($getRowVal->getRow('token', $token, 'orders')['status'] != 'DELIVERED') {
                        if ($_SESSION['SESS_ADMIN_TYPE'] == 'delivery') { ?>
                            <option>DELIVERED</option>
                        <?php } else { ?>
                            <option>ORDER PLACED</option>
                            <option>TRANSIT</option>
                            <option>OUT FOR DELIVERY</option>
                            <option>CUTTING</option>
                            <option>PROCESSING</option>
                            <option>PACKING</option>
                            <option>DELIVERED</option>
                    <?php }
                    } ?>
                </select>
            </div>
            <div class="form-group col-md-12 mt-3" id="dagent" style="display:none;">
                <label class="text-uppercase">Delivery Agent</label>
                <select name="agent" id="agent" class="form-control form-control-lg">
                    <option value="">Choose</option>
                    <?php
                    $qry = $db->prepare("SELECT * FROM delivery_agents WHERE created_by = '$user' OR created_by = 'admin'");
                    $qry->execute();
                    for ($i = 0; $rows = $qry->fetch(); $i++) {
                    ?>
                        <option value="<?php echo ($rows['token']); ?>"><?php echo ucwords($rows['name']); ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary px-4 rounded-c" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success px-4 rounded-c" name="submit">Update</button>
    </div>
</form>
<script>
    <?php if ($_SESSION['SESS_ADMIN_TYPE'] == 'delivery') { ?>

        function dagent() {
            $("#dagent").hide();
        }
    <?php } else { ?>

        function dagent() {
            let status = $('#status').val();
            console.log(status);
            if (status == 'OUT FOR DELIVERY') {
                $("#dagent").show();
            } else {
                $("#dagent").hide();
            }
        }
    <?php } ?>
    $('#order_status').on('submit', function(e) {
        e.preventDefault();
        let cstatus = $('#cstatus').val();
        let status = $('#status').val();
        let agent = $('#agent').val();
        let target = $('#order_status').attr('action');
        let formData = new FormData(document.getElementById("order_status"));
        if (cstatus == status) {
            err_msg("Please change status", 3);
        } else if (status == 'OUT FOR DELIVERY' && agent == '') {
            err_msg("Choos a delivery agent", 3);
        } else {
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
        }
    });
</script>