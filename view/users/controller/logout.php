<?php
session_start();

unset( $_SESSION['auth']);
unset( $_SESSION['userRole']);
unset( $_SESSION['authUser']);

$_SESSION['message'] = "Logout Successful";
$_SESSION['code'] = "Success";
header("Location: ../../../login.php");
exit(0);
?>