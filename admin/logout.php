<?php
session_start();
unset($_SESSION['SESS_ADMIN_ID']);
unset($_SESSION['SESS_ADMIN_TOKEN']);
unset($_SESSION['SESS_ADMIN_NAME']);
unset($_SESSION['SESS_ADMIN_TYPE']);
unset($_SESSION['SESS_ADMIN_EMAIL']);
setcookie("ME", "", time() - 3600, "/");
?>
<script>
    window.location.href = '../login.php?signout';
</script>