<?php

include_once 'config.php';

function showError($errMsg){
    $_SESSION['errMsg'] = $errMsg;
}

function emailValid($email, $errMsg, $redirPath){
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (false === $email) {
        // redirect user back to the form
        showError($errMsg);
        header($redirPath);
        exit;
    }
}
function passValid($pass, $errMsg, $redirPath){
    $pass = filter_var($pass, FILTER_DEFAULT);
    if (empty($pass) || mb_strlen($pass) < 7) {
        // redirect user back to the form
        showError($errMsg);
        header($redirPath);
        exit;
    }
}

function checkHash($passHash, $costPass, $errMsg, $redirPath){
    if (false === $passHash) {
        showError($errMsg);
        header($redirPath);
        exit;
    }
}

function checkPassMatchEmail($pass, $hash, $errMsg1, $redirPath1){
    if (false === password_verify($pass, $hash)) {
        showError($errMsg1);
        // back user to the LOGIN form again
        header($redirPath1);
        exit;
    }
}

function pushToDataBase($dbPath, $users){
    file_put_contents(
        $dbPath, json_encode($users)
    );
}
function passRehash($email, $newCostPass, $pass, $users, $dbPath){
    if (password_needs_rehash($hash, PASSWORD_DEFAULT, $newCostPass)) {
        // if yes, create new hash
        $newHash = password_hash($pass, PASSWORD_DEFAULT, $newCostPass);
        $users[$email] = $newHash;
        // file_put_contents(
        //     $dbPath, json_encode($users)
        // );
        pushToDataBase($dbPath, $users);
    }
}
function authorisation($email, $users, $pass, $hash, $newCostPass, $errMsg1, $redirPath1, $errMsg2, $redirPath2, $redirPath3, $dbPath){
    if (array_key_exists($email, $users)) {
        checkPassMatchEmail($pass, $hash, $errMsg1, $redirPath1);
        //check if need to use new algorithm to hash pass
        passRehash($email, $newCostPass, $pass, $users, $dbPath);
        header($redirPath2);
    } else {
        showError($errMsg2);
        // back user to the LOGIN form, again
        header($redirPath3);
    }
}

function passEqual($passRepeat, $passHash, $errMsg, $redirPath){
    if (!password_verify($passRepeat, $passHash)) {
        showError($errMsg);
        header($redirPath);
        exit;
    }
}
function registration($email, $users, $passRepeat, $passHash, $errMsg, $redirPath1, $redirPath2, $dbPath){
    if (!array_key_exists($email, $users) && password_verify($passRepeat, $passHash)) {
        //// add user to database
        $users[$email] = $passHash;
        // file_put_contents(
        //     $dbPath, json_encode($users)
        // );
        pushToDataBase($dbPath, $users);
        header($redirPath2);
    } else {
        //user is already registred, redirect to auth
        showError($errMsg);
        header($redirPath1);
    }
}
