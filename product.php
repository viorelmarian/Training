<?php
require_once 'common.php';
if (isset($_SESSION['login'])) {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(!empty($_REQUEST['title']) && !empty($_REQUEST['description']) 
        && !empty($_REQUEST['price']) && !empty($_REQUEST['image'])) {
    
            $title = $description = $price = $image ="";
    
            $title = sanitize($_REQUEST['title']);
            $description = sanitize($_REQUEST['description']);
            $price = sanitize($_REQUEST['price']);
             $image = sanitize($_REQUEST['image']);
    
            if (isset($_SESSION['product_id'])) {
                edit_product($_SESSION['product_id'], $title, $description, $price, $image);
                header("Location: products.php");
                exit();
            } else {
                add_product($title, $description, $price, $image);
                header("Location: products.php");
                exit();
            }
        } 
    }
} else {
    header("Location: login.php");
    exit();
}

?>

<html>
    <head>
        <link rel="stylesheet" href="css/product.css">
    </head>
    <body>
        <form action="product.php" method="post" id="product">
            <fieldset>
                <input type="text" name="title" id="title" autocomplete="off" placeholder="Title">
                <textarea name="description" id="description" placeholder="Description"></textarea>
                <input type="text" name="price" id="price" autocomplete="off" placeholder="Price">
                <input type="file" name="image" id="image">
                <input type="submit" value="Save" id="save">
            </fieldset>
        </form>
    </body>
</html>