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
    if (!emailValid($email)) {
        // redirect user back to the form
        $_SESSION['errMsg'] = 'Введите корректный логин';
        header('Location: ./view/register-form.php');
        exit;
    }
    // 2) check user email 
    $pass = filter_var($pass, FILTER_DEFAULT);
    if (empty($pass) || mb_strlen($pass) < 7) {
        // redirect user back to the form
        $_SESSION['errMsg'] = 'Пароль должен содержать не менее 7 знаков';
        header('Location: ./view/register-form.php');
        exit;
    }

    // get json from dir, transform to array whith JSON_OBJECT_AS_ARRAY!!!!!!!!!
    $users = json_decode(file_get_contents(__DIR__. $config['pathPasswords']), JSON_OBJECT_AS_ARRAY);
    
    // 3) Generte password hash
    $passHash = password_hash($pass, PASSWORD_DEFAULT, $config['costPass']);
    // $passRepeatHash = password_hash($passRepeat, PASSWORD_DEFAULT, ['cost => 10']);
    if (false === $passHash) {
        $_SESSION['errMsg'] = 'Системная ошибка, введит пароль еще раз';
        header('Location: ./view/register-form.php');
        exit;
    }
    if (!password_verify($passRepeat, $passHash)) {
        $_SESSION['errMsg'] = 'Пароли не совпадают';
        header('Location: ./view/register-form.php');
        exit;
    }
    if (!array_key_exists($email, $users) && password_verify($passRepeat, $passHash)) {
        //// add user to database
        $users[$email] = $passHash;
        file_put_contents(
             __DIR__. $config['pathPasswords'], json_encode($users)
        );
        header("Location: ./view/login-form.php");
    } else {
        //user is already registred, redirect to auth
        $_SESSION['errMsg'] = 'Вы уже зарегистрированы, пожалуйста, авторизируйтесь';
        header('Location: ./index.php');
    }
}

require_once './view/register-form.php';
