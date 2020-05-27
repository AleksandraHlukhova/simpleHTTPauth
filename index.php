<?php

if (isset($_GET['action'])) {
    
    if('register' === $_GET['action']) {
        header('Location: ./view/register-form.php');
    }
    if('login' === $_GET['action']) {
        header('Location: ./view/login-form.php');
    }
}
require_once './view/main.php';