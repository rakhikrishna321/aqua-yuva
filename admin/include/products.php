<?php
$qry = $db->prepare("SELECT * FROM products WHERE department = '$user' AND status = '$filter'");
$qry->execute();
if ($qry->rowcount() > 0) {
?>
    <table class="table table-borderless datatable">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Department</th>
                <th scope="col">Description</th>
                <th scope="col">Created At</th>
                <th scope="col" class="text-center">Status</th>
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
                    <td><?php echo ucwords($getRowVal->getRow('token', $user, 'departments')['name']); ?></td>
                    <td title="<?php echo ucfirst($rows['description']); ?>"><?php echo truncate_text(ucfirst($rows['description']), 100); ?></td>
                    <td><?php echo time_convert($rows['created_at']); ?></td>
                    <td class="text-center">
                        <?php
                        if ($rows['status'] == 1) {
                            echo '<span class="btn btn-success btn-sm text-uppercase">Active</span>';
                        } else {
                            echo '<span class="btn btn-danger btn-sm text-uppercase">Hidden</span>';
                        } ?>
                    </td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                ACTIONS
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <?php
                                    if ($rows['status'] == 1) {
                                    ?>
                                        <a class="dropdown-item" href="actions/product.status.php?token=<?php echo $token ?>&status=0">
                                            HIDE
                                        </a>
                                    <?php
                                    } else {
                                    ?>
                                        <a class="dropdown-item" href="actions/product.status.php?token=<?php echo $token ?>&status=1">
                                            UNHIDE
                                        </a>
                                    <?php
                                    } ?>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="product.php?token=<?php echo $token ?>">
                                        DETAILS
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item dynamicPopup" data-pop="md" data-url="forms/product.update.php?token=<?php echo $token ?>" data-bs-toggle="modal" data-bs-target="#dynamicPopup-md" data-bs-backdrop="static" data-bs-keyboard="false" href="javascript:void(0)">
                                        UPDATE
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item dynamicPopup" data-pop="md" data-url="forms/product.image.php?token=<?php echo $token ?>" data-bs-toggle="modal" data-bs-target="#dynamicPopup-md" data-bs-backdrop="static" data-bs-keyboard="false" href="javascript:void(0)">
                                        UPLOAD IMAGE
                                    </a>
                                </li>
                            </ul>
                        </div>
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