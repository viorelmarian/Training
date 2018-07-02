<?php
session_start();
require "common.php";

$conn = connect_db($servername, $db_username, $db_password, $database);

    $stmt = $conn->prepare("SELECT * FROM products");
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $stmt->close();
    $_SESSION["products"] = $products;

?>

<html>
    <head>
        <link rel="stylesheet" href="css/index.css">
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    </head>
    <body>
        
        <button id="toCart">Go to cart</button>
        <?php
            foreach ($_SESSION["products"] as $product) {
        ?>

        <div class="product">
            <img src="images/<?php echo $product["image"] ?>" alt="">
            <div class="product_info">
                <h1 id="product_title"><?php echo $product["title"] ?></h1>
                <p id="product_description"><?php echo $product["description"] ?></p>
                <p id="product_price">Price: <?php echo $product["price"] ?> $</p>
                <button onclick="addToCart()">Add to cart</button>
            </div>
        </div>
        
        <?php
            }
        ?>

        <script src="js/index.js"></script>
    </body>

</html>