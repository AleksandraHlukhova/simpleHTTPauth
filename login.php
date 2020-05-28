<?php

// 0) Start sessions at the top of the our script
session_start();
include_once 'function.php';
include_once 'config.php';

if(isset($_POST['btn'])){
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $_SESSION['email'] = $email;
    $_SESSION['pass'] = $pass;
    $_SESSION['errMsg'] = '';

    // 1) validate user email
    emailValid($email, $config['errMsg'][0], $config['redirPath']["logForm"]);
    // 2) check user email 
    passValid($pass, $config['errMsg'][1], $config['redirPath']["logForm"]);

    // get json from dir, transform to array whith JSON_OBJECT_AS_ARRAY!!!!!!!!!
    $users = json_decode(file_get_contents(__DIR__. $config['pathPasswords']), JSON_OBJECT_AS_ARRAY);
    
    // 3) Generte password hash
    $passHash = password_hash($pass, PASSWORD_DEFAULT, $config['costPass']);
    checkHash($passHash, $config['costPass'], $config['errMsg'][2], $config['redirPath']["logForm"]);
                                                                                                
    // 4) Find user account info
    authorisation($email, $users, $pass, $users[$email], $config['newCostPass'], $config['errMsg'][3], $config['redirPath']["logForm"], $config['errMsg'][4], $config['redirPath']["succAuth"], $config['redirPath']["regForm"], $config['pathPasswords']);
}

require_once './view/login-form.php';