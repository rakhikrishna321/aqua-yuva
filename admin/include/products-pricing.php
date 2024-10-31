<?php
$qry = $db->prepare("SELECT * FROM products WHERE department = '$user'");
$qry->execute();
if ($qry->rowcount() > 0) {
?>
    <table class="table table-borderless datatable">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th class="text-end" scope="col">MRP</th>
                <th class="text-end" scope="col">SELLING PRICE</th>
                <th scope="col" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $rows = $qry->fetch(); $i++) {
                $token = $rows['token'];
            ?>
                <tr>
                    <td><?php echo ucwords($rows['name']); ?></td>
                    <td class="text-end"><?php echo number_format($rows['mrp'],2); ?></td>
                    <td class="text-end"><?php echo number_format($rows['rate'],2); ?></td>
                    <td class="text-center">
                        <a class="btn btn-sm btn-dark dynamicPopup" data-pop="md" data-url="forms/product.pricing.php?token=<?php echo $token ?>" data-bs-toggle="modal" data-bs-target="#dynamicPopup-md" data-bs-backdrop="static" data-bs-keyboard="false" href="javascript:void(0)">
                            UPDATE
                        </a>
                        <a class="btn btn-sm btn-primary" href="product.php?token=<?php echo $token ?>">
                            DETAILS
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <div class="col-12" style="padding:31vh 1rem;">
        <h3 class="text-center text-muted">NO DATA FOUND</h3>
    </div>
<?php } ?>