<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="#"><img src="assets/img/logo.png" alt=""></a>
    </div>
    <div class="humberger__menu__cart">
        <?php if (isset($_SESSION['SESS_USER_TOKEN'])) {
            $user = $_SESSION['SESS_USER_TOKEN'];
            $cart_count = 0;
            $cart_val = 0;
            $qry_cart = $db->prepare("SELECT * FROM orders WHERE created_by = '$user' AND status = 'pending'");
            $qry_cart->execute();
            $cart_count = $qry_cart->rowcount();
            if ($cart_count > 0) {
                $cart_products = $qry_cart->fetch();
                $order_token = $cart_products['token'];
                $cart_val = $cart_products['total'];
                $qry_cart = $db->prepare("SELECT * FROM orders_products WHERE order_token = '$order_token'");
                $qry_cart->execute();
                $cart_count = $qry_cart->rowcount();
            }
        ?>
            <ul>
                <li><a href="cart.php"><i class="fa fa-shopping-bag"></i> <span><?php echo $cart_count ?></span></a></li>
            </ul>
            <?php if ($cart_val > 0) { ?>
                <div class="header__cart__price" onClick="location.href='../cart.php'"><span>INR <?php echo number_format($cart_val, 2) ?></span></div>
            <?php } ?>
        <?php } ?>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li><a href="./">Home</a></li>
            <!-- <li><a href="./shop.php">Shop</a></li> -->
            <!-- <li><a href="#">Pages</a>
                <ul class="header__menu__dropdown">
                    <li><a href="./shop-details.html">Shop Details</a></li>
                    <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                    <li><a href="./checkout.html">Check Out</a></li>
                    <li><a href="./blog-details.html">Blog Details</a></li>
                </ul>
            </li>
            <li><a href="./blog.html">Blog</a></li> -->
            <li><a href="./contact.php">Contact</a></li>
            <?php if (isset($_SESSION['SESS_ADMIN_TOKEN'])) { ?>
                <li><a href="./admin/dashboard.php">Dashboard</a></li>
            <?php }
            if (isset($_SESSION['SESS_USER_TOKEN'])) { ?>
                <li><a href="./orders.php">Orders</a></li>
                <li><a href="./logout.php">Log out</a></li>
            <?php } else { ?>
                <li><a href="./login.php">Login</a></li>
                <li><a href="./register.php">Register</a></li>
            <?php } ?>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="header__top__right__social">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-linkedin"></i></a>
        <a href="#"><i class="fa fa-pinterest-p"></i></a>
    </div>
    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i> hello@aqua.com</li>
            <li>Free Shipping for all Orders</li>
        </ul>
    </div>
</div>