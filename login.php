<?php
require 'common.php';
$username = $password = "";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_POST['username']) && !empty($_POST['password'])) {

        $username = sanitize($_POST['username']);
        $password = sanitize($_POST['password']);

        if ($username == admin_username && $password == admin_password) {
            $_SESSION['login'] = "logged";
            header("Location: products.php");
            exit();
        }
    } 
}  
?>

<html>
    <head>
        <link rel="stylesheet" href="css/login.css">
    </head>
    <body>
        <div>
            <form action="login.php" method="post">
                <fieldset>
                    <input type="text" name="username" placeholder="<?= translate('Username') ?>" autocomplete="off">
                    <input type="password" name="password" placeholder="<?= translate('Password') ?>" autocomplete="off">
                    <input type="submit" value="<?= translate('Login') ?>">
                </fieldset>
            </form>
        </div>
        
    </body>
</html>


