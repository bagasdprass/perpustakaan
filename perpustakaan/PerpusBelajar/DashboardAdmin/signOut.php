<?php
session_start();
session_destroy();
header("Location: ../sign/admin/sign_in.php");
exit;
?>