<?php

$config = array(
    "pathPasswords" => "./db.json",
    "costPass" => [
        'cost' => 10,
    ],
    "newCostPass" => [
        'cost' => 11,
    ],
    "errMsg" => [
        0 => 'Введите корректный логин',
        1 => 'Пароль должен содержать не менее 7 знаков',
        2 => 'Системная ошибка, введит пароль еще раз',
        3 => 'Неправильный пароль, введите еще раз',
        4 => "Извините, но пользователь с этим логином не зарегистрирован! Зарегистрируйтесь!",
        5 => 'Пароли не совпадают',
        6 => 'Вы уже зарегистрированы, пожалуйста, авторизируйтесь'
    ],
    "redirPath" => [
        "logForm" => 'Location: ./view/login-form.php',
        "succAuth" => 'Location: ./view/successAuth.php',
        "regForm" => 'Location: ./view/register-form.php',
        "index" => 'Location: ./index.php',
    ]
);