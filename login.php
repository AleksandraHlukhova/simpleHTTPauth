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
    emailValid($email, 'Введите корректный логин', 'Location: ./view/login-form.php');
    // 2) check user email 
    passValid($pass, 'Пароль должен содержать не менее 7 знаков', 'Location: ./view/login-form.php');

    // get json from dir, transform to array whith JSON_OBJECT_AS_ARRAY!!!!!!!!!
    $users = json_decode(file_get_contents(__DIR__. $config['pathPasswords']), JSON_OBJECT_AS_ARRAY);
    
    // 3) Generte password hash
    $passHash = password_hash($pass, PASSWORD_DEFAULT, $config['costPass']);
    checkHash($passHash, $config['costPass'], 'Системная ошибка, введит пароль еще раз', 'Location: ./view/login-form.php');
                                                                                                
    // 4) Find user account info
    authorisation($email, $users, $pass, $users[$email], $config['newCostPass'], 'Неправильный пароль, введите еще раз', 'Location: ./view/login-form.php', "Извините, но пользователь с этим логином не зарегистрирован! Зарегистрируйтесь!", 'Location: ./view/successAuth.php','Location: ./view/register-form.php', $config['pathPasswords']);
}

require_once './view/login-form.php';