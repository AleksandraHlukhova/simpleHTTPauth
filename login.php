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
    if (!emailValid($email)) {
        // redirect user back to the form
        $_SESSION['errMsg'] = 'Введите корректный логин';
        header('Location: ./view/login-form.php');
        exit;
    }
    // 2) check user email 
    $pass = filter_var($pass, FILTER_DEFAULT);
    if (empty($pass) || mb_strlen($pass) < 7) {
        // redirect user back to the form
        $_SESSION['errMsg'] = 'Пароль должен содержать не менее 7 знаков';
        header('Location: ./view/login-form.php');
        exit;
    }

    // get json from dir, transform to array whith JSON_OBJECT_AS_ARRAY!!!!!!!!!
    $users = json_decode(file_get_contents(__DIR__. $config['pathPasswords']), JSON_OBJECT_AS_ARRAY);
    
    // 3) Generte password hash
    $passHash = password_hash($pass, PASSWORD_DEFAULT, $config['costPass']);
    if (false === $passHash) {
        $_SESSION['errMsg'] = 'Системная ошибка, введит пароль еще раз';
        header('Location: ./view/login-form.php');
        exit;
    }

    // // 4) Find user account info
    if (array_key_exists($email, $users)) {
        if (false === password_verify($pass, $users[$email])) {
            $_SESSION['errMsg'] = 'Неправильный пароль, введите еще раз';
            // back user to the LOGIN form again
            header('Location: ./view/login-form.php');
            exit;
        }
        //check if need to use new algorithm to hash pass
        if (password_needs_rehash($users[$email], PASSWORD_DEFAULT, $config['newCostPass'])) {
            // if yes, create new hash
            $newHash = password_hash($pass, PASSWORD_DEFAULT, $config['newCostPass']);
            $users[$email] = $newHash;
            file_put_contents(
                __DIR__. $config['pathPasswords'], json_encode($users)
            );
        }
        header('Location: ./view/successAuth.php');
    } else {
        $_SESSION['errMsg'] = "Извините, но пользователь с этим логином не зарегистрирован! Зарегистрируйтесь!";
        // back user to the LOGIN form, again
        header('Location: ./view/register-form.php');
    }
}

require_once './view/login-form.php';