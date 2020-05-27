<?php

session_start();
include_once 'function.php';
include_once 'config.php';

// var_dump($_POST['btn-logOut'], $_COOKIE);
//     var_dump($_SESSION);
//     exit;
if(isset($_POST['btn-logOut'])){
    //del var
    $_SESSION = array();
    // session_destroy();
    header("Location: ./index.php");
}