<?php 
    session_start();
?>

<html>
    <head>
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
        <a href="cart.php">
            <button id="toCart">Go to cart</button>
        </a>
        
        <?php
            foreach ($_SESSION["prod_in_cart"] as $product) {
        ?>

        <div class="product">
            <img src="images/<?php echo $product["image"] ?>" alt="">
            <div class="product_info">
                <h1 id="product_title"><?php echo $product["title"] ?></h1>
                <p id="product_description"><?php echo $product["description"] ?></p>
                <p id="product_price">Price: <?php echo $product["price"] ?> $</p>
                <form action="index.php" method = "get">
                    <input type="hidden" name="product" value="<?php echo $product["id"]-1 ?>">
                    <input type="submit" value="Add to cart">
                </form>
            </div>
        </div>
        
        <?php
            }
        ?>
    </body>

</html>