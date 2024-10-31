<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <?php if ($_SESSION['SESS_ADMIN_TYPE'] == 'admin') { ?>
            <li class="nav-item">
                <a class="nav-link" href="departments.php">
                    <i class="bi bi-grid"></i>
                    <span>Department Admin</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="delivery-agents.php">
                    <i class="bi bi-grid"></i>
                    <span>Delivery Agents</span>
                </a>
            </li>
        <?php } elseif ($_SESSION['SESS_ADMIN_TYPE'] == 'delivery') { ?>
            <li class="nav-item">
                <a class="nav-link" href="report.php">
                    <i class="bi bi-grid"></i>
                    <span>Daily Report</span>
                </a>
            </li>
        <?php } elseif ($_SESSION['SESS_ADMIN_TYPE'] == 'department') { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#products-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Products</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="products-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="products.php?filter=1">
                            <i class="bi bi-circle"></i><span>Active</span>
                        </a>
                    </li>
                    <li>
                        <a href="products.php?filter=0">
                            <i class="bi bi-circle"></i><span>Hidden</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="products.php?filter=4">
                    <i class="bi bi-grid"></i>
                    <span>Product Pricing</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#stock-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Product Stock</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="stock-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="products.php?filter=2">
                            <i class="bi bi-circle"></i><span>In stock</span>
                        </a>
                    </li>
                    <li>
                        <a href="products.php?filter=3">
                            <i class="bi bi-circle"></i><span>Out of Stock</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#Orders-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Orders</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="Orders-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="orders.php">
                            <i class="bi bi-circle"></i><span>Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="orders.php?old">
                            <i class="bi bi-circle"></i><span>Delivered/Cancelled</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="delivery-agents.php">
                    <i class="bi bi-grid"></i>
                    <span>Delivery Agents</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="report.php">
                    <i class="bi bi-grid"></i>
                    <span>Sales Report</span>
                </a>
            </li>
        <?php } ?>
    </ul>
</aside>