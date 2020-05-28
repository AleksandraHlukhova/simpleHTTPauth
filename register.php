<?php
session_start();
include_once 'function.php';
include_once 'config.php';

if(isset($_POST['btn'])){
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $passRepeat = $_POST['password-rep'];
    $_SESSION['email'] = $email;
    $_SESSION['pass'] = $pass;
    $_SESSION['pass-rep'] = $passRepeat;
    $_SESSION['errMsg'] = '';

    // 1) validate user email
    emailValid($email, $config['errMsg'][0], $config['redirPath']["regForm"]);

    // 2) check user email 
    passValid($pass, $config['errMsg'][1], $config['redirPath']["regForm"]);

    // get json from dir, transform to array whith JSON_OBJECT_AS_ARRAY!!!!!!!!!
    $users = json_decode(file_get_contents(__DIR__. $config['pathPasswords']), JSON_OBJECT_AS_ARRAY);
    
    // 3) Generte password hash
    $passHash = password_hash($pass, PASSWORD_DEFAULT, $config['costPass']);
    checkHash($passHash, $config['costPass'], $config['errMsg'][2], $config['redirPath']["regForm"]);

    // 4) Find user account info
    passEqual($passRepeat, $passHash, $config['errMsg'][5], $config['redirPath']["regForm"]);
    registration($email, $users, $passRepeat, $passHash, $config['errMsg'][6], $config['redirPath']["index"], $config['redirPath']["logForm"],  __DIR__. $config['pathPasswords']);
}

require_once './view/register-form.php';
