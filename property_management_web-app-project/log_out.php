<?php
session_start();
unset($_SESSION['user_name']);
unset($_SESSION['ownerID']);
unset($_SESSION['property_name']);
unset($_SESSION['location']);
// unset($_SESSION['property_name']) ;
// unset($_SESSION['location']);
// redirecting to login page
header("location:login_form.php");









?>