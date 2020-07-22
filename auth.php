<?php 
    if(session_status() != PHP_SESSION_ACTIVE){
        session_start();
    }
    if(empty($_SESSION['account_id'])){
        header('location:login.php');
        exit();
    }
?>