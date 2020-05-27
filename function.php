<?php

function emailValid($email){
    return $email = filter_var($email, FILTER_VALIDATE_EMAIL);
}