<?php 
    require_once('auth.php');
    session_unset();
    session_destroy();
    header('location:login.php');
    exit();
?>