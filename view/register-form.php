<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <div class="container">
        <h4>Register</h4>
        <h6>To register a new accout put your credentials below, please.</h6>
        <form action="../register.php" method="post" enctype="application/x-www-form-urlencoded" class="form">
            <!-- Email -->
            <label for="email">Email</label>
            <input type="email" name="email" class="input-data" id="email" value="<?= (isset($_SESSION['email'])) ? $_SESSION['email'] : '' ?>" placeholder="Put your email">
            <!-- Password -->
            <label for="password">Password</label>
            <input type="password" name="password" class="input-data" id="password" value="<?= (isset($_SESSION['pass'])) ? $_SESSION['pass'] : '' ?>" placeholder="Put your password">
            <label for="password-rep">Repeat password</label>
            <input type="password" name="password-rep" class="input-data" id="password-rep" value="<?= (isset($_SESSION['pass-rep'])) ? $_SESSION['pass-rep'] : '' ?>" placeholder="Repeat your password">
            <!-- Submit -->
            <input type="submit" name="btn" class="btn" value="Submit">
        </form>
        <div class="error-msg"><?= (isset($_SESSION['errMsg'])) ? $_SESSION['errMsg'] : '' ?></div>
    </div>
</body>

</html>