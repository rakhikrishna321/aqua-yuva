<div class="pagetitle mb-4">
    <h1>DELIVERIES</h1>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">
                            </h5>
                            <?php
                            $qry_cart = $db->prepare("SELECT * FROM orders WHERE agent = '$user' AND status = 'OUT FOR DELIVERY'");
                            $qry_cart->execute();
                            if ($qry_cart->rowcount() > 0) {
                                for ($i = 0; $rows = $qry_cart->fetch(); $i++) {
                                    $order_token = $rows['token'];
                                    $qry_cartc = $db->prepare("SELECT * FROM orders WHERE token = '$order_token'");
                                    $qry_cartc->execute();
                                    $order_details = $qry_cartc->fetch();
                            ?>
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header p-0">
                                                <button class="btn btn-block w-100 btn-dark text-left" style="text-align:left;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample<?php echo $i ?>" aria-expanded="false" aria-controls="collapseExample<?php echo $i ?>">
                                                    <p class="small mb-0 text-light">Order #<?php echo $rows['token']; ?></p>
                                                    <?php echo time_convert($rows['created_at']); ?><br>
                                                    Status: <?php echo strtoupper($rows['status']); ?>
                                                </button>
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="collapse" id="collapseExample<?php echo $i ?>">
                                                    <div class="card card-body pt-3">
                                                        <table>
                                                            <thead>
                                                                <tr>
                                                                    <th class="shoping__product">Products</th>
                                                                    <th>Price</th>
                                                                    <th>Total</th>
                                                                </tr>
                                                            </thead>
                                                            <?php
                                                            $qry_cart_in = $db->prepare("SELECT * FROM orders_products WHERE order_token = '$order_token'");
                                                            $qry_cart_in->execute();
                                                            for ($i2 = 0; $rows = $qry_cart_in->fetch(); $i2++) {
                                                            ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo strtoupper($rows['product_name']) ?>
                                                                    </td>
                                                                    <td>
                                                                        <div class="text-danger small" style="text-decoration: line-through;"><?php echo number_format($rows['mrp'], 2); ?>x<?php echo $rows['qty'] ?></div>
                                                                        <div class="small"><?php echo number_format($rows['rate'], 2); ?>x<?php echo $rows['qty'] ?></div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="text-danger small" style="text-decoration: line-through;"><?php echo number_format($rows['mrp_total'], 2); ?></div>
                                                                        <div class="small"><?php echo number_format($rows['total'], 2); ?></div>
                                                                    </td>
                                                                </tr>
                                                            <?php  } ?>
                                                        </table>
                                                        <div class="shoping__checkout mt-1">
                                                            <p>Cart Total</p>
                                                            <ul>
                                                                <li>Subtotal <span class="text-dark">INR <?php echo number_format($order_details['mrp_total'], 2) ?></span></li>
                                                                <li>Discount <span class="text-dark">INR <?php echo number_format(($order_details['mrp_total'] - $order_details['total']), 2) ?></span></li>
                                                                <li>Total <span class="text-dark">INR <?php echo number_format($order_details['total'], 2) ?></span></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-12">
                                                            <p>Deliver to:<br><?php echo $order_details['delivery_address'] ?> - <?php echo $order_details['delivery_pincode'] ?></p>
                                                            <p>Contact:<br><?php echo $order_details['delivery_contact'] ?></p>
                                                            <a href="javascript:void(0);" class="btn btn-success dynamicPopup" data-pop="md" data-url="forms/order.status.php?token=<?php echo $order_token ?>" data-bs-toggle="modal" data-bs-target="#dynamicPopup-md" data-bs-backdrop="static" data-bs-keyboard="false">ORDER STATUS</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="col-12" style="padding:31vh 1rem;">
                                    <h3 class="text-center text-muted">NO DATA FOUND</h3>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>