<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth</title>
    <link rel="stylesheet" href="./style/style.css">

</head>

<body>
    <div class="container">
    <h3>If you are a new User, please, Sign up, else Sign in</h3>
    <div class="error-msg"><?= (isset($_SESSION['errMsg'])) ? $_SESSION['errMsg'] : '' ?></div>
        <div class="button-wrap">
            <a href="<?= $_SERVER['PHP_SELF'] ?>?action=register" class="register-btn btn">
                Registration
            </a>
            <a href="<?= $_SERVER['PHP_SELF'] ?>?action=login" class="register-btn btn">
                Sign in
            </a>
        </div>
    </div>
</body>

</html>