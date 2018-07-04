<?php
require_once 'common.php';
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(
        !empty($_REQUEST['title']) && !empty($_REQUEST['description']) 
        && !empty($_REQUEST['price']) && !empty($_REQUEST['image'])
    ) {

        $title = sanitize($_REQUEST['title']);
        $description = sanitize($_REQUEST['description']);
        $price = sanitize($_REQUEST['price']);

        if (isset($_REQUEST['id'])) {
            edit_product($_REQUEST['id'], $title, $description, $price, $image);
            header("Location: products.php");
            exit();
        } else {
            add_product($title, $description, $price, $image);
            header("Location: products.php");
            exit();
        }
    } 
}
?>
<html>
    <head>
        <link rel="stylesheet" href="css/product.css">
    </head>
    <body>
        <form action="product.php" method="post">
            <fieldset>
                <input type="text" name="title"  autocomplete="off" placeholder="Title">
                <textarea name="description"  placeholder="Description"></textarea>
                <input type="text" name="price"  autocomplete="off" placeholder="Price">
                <input type="file" name="image">
                <input type="submit" value="Save">
            </fieldset>
        </form>
    </body>
</html>