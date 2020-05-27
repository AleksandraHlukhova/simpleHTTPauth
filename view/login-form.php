<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../style/style.css">

</head>

<body>
    <div class="container">
        <h4>Login</h4>
        <h6>Put your credentials to login</h6>
        <form action="../login.php" method="post" enctype="application/x-www-form-urlencoded" class="form">
            <!-- Email -->
            <label for="email">Email</label>
            <input type="email" name="email" class="input-data" id="email"
                value="<?= (isset($_SESSION['email'])) ? $_SESSION['email'] : '' ?>" placeholder="Put your email">
            <!-- Password -->
            <label for="password">Password</label>
            <input type="password" name="password" class="input-data" id="password" value="<?= (isset($_SESSION['pass'])) ? $_SESSION['pass'] : '' ?>" placeholder="Put your password">
            <!-- Submit -->
            <input type="submit" name="btn" class="btn" value="Submit">
        </form>
        <div class="error-msg"><?= (isset($_SESSION['errMsg'])) ? $_SESSION['errMsg'] : '' ?></div>
    </div>
</body>

</html>