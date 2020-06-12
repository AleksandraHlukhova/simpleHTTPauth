<?php

session_start();

if (isset($_GET['action'])) {
    
    if('register' === $_GET['action']) {
        header('Location: ./register.php');
    }
    if('login' === $_GET['action']) {
        header('Location: ./login.php');
    }
}
require_once './view/main.php';