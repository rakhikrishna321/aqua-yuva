<?php
session_start();
unset($_SESSION['SESS_USER_ID']);
unset($_SESSION['SESS_USER_TOKEN']);
unset($_SESSION['SESS_USER_NAME']);
unset($_SESSION['SESS_USER_TYPE']);
unset($_SESSION['SESS_USER_EMAIL']);
setcookie("ME", "", time() - 3600, "/");
if (isset($_GET['expired'])) {
?>
    <script>
        window.location.href = '../login.php?expired';
    </script>
<?php
} else {
?>
    <script>
        window.location.href = '../login.php?signout';
    </script>
<?php
}
