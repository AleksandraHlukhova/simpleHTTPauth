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
    emailValid($email, 'Введите корректный логин', 'Location: ./view/register-form.php');

    // 2) check user email 
    passValid($pass, 'Пароль должен содержать не менее 7 знаков', 'Location: ./view/register-form.php');

    // get json from dir, transform to array whith JSON_OBJECT_AS_ARRAY!!!!!!!!!
    $users = json_decode(file_get_contents(__DIR__. $config['pathPasswords']), JSON_OBJECT_AS_ARRAY);
    
    // 3) Generte password hash
    $passHash = password_hash($pass, PASSWORD_DEFAULT, $config['costPass']);
    checkHash($passHash, $config['costPass'], 'Системная ошибка, введит пароль еще раз', 'Location: ./view/register-form.php');

    // 4) Find user account info
    passEqual($passRepeat, $passHash, 'Пароли не совпадают', 'Location: ./view/register-form.php');
    registration($email, $users, $passRepeat, $passHash, 'Вы уже зарегистрированы, пожалуйста, авторизируйтесь', 'Location: ./index.php', "Location: ./view/login-form.php",  __DIR__. $config['pathPasswords']);
}

require_once './view/register-form.php';
