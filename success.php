<?php

session_start();
include_once 'function.php';
include_once 'config.php';

if(isset($_POST['btn-logOut'])){
    //del var
    $_SESSION = array();
    // session_destroy();
    header("Location: ./index.php");
}