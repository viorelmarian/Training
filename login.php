<?php
    session_start();
    require "common.php";
    $username = $password = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(empty($_POST["username"])) {
            header("Location: login.php");
            exit();
        } else {
            $username = sanitize($_POST["username"]);
        }
        if(empty($_POST["password"])) {
            header("Location: login.php");
            exit();
        } else {
            $password = sanitize($_POST["password"]);
        }

    
    
    $conn = connect_db($servername, $db_username, $db_password, $database);

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param('s',$username);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_assoc();
    $stmt->close();
    if($result["password"] == $password)
    {
        header("Location: index.php");
    } else {
        echo "Invalid credentials";
    }


        
    }

    
    
?>

<html>
    <head>
        <link rel="stylesheet" href="css/login.css">
    </head>
    <body>
        <div id="login">
            <form action="login.php" method="post">
                <fieldset>
                    <input id="username" type="text" name="username" placeholder="Username" autocomplete="off">
                    <input id="password" type="password" name="password" placeholder="Password" autocomplete="off">
                    <input id="submit" type="submit" value="Login">
                </fieldset>
            </form>
        </div>
        
    </body>
</html>


