<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block">AQUA ADMIN</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <!-- <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-primary badge-number">4</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#">
                    <i class="bi bi-chat-left-text"></i>
                    <span class="badge bg-success badge-number">3</span>
                </a>
            </li> -->
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo ucwords($_SESSION['SESS_ADMIN_NAME']) ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?php echo ucwords($_SESSION['SESS_ADMIN_NAME']) ?></h6>
                        <span><?php echo ucwords($_SESSION['SESS_ADMIN_TYPE']) ?></span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center dynamicPopup" data-pop="md" data-url="forms/password.update.php" data-bs-toggle="modal" data-bs-target="#dynamicPopup-md" data-bs-backdrop="static" data-bs-keyboard="false" href="javascript:void(0)">
                            <i class="bi bi-gear"></i>
                            <span>Update Password</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="logout.php">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>