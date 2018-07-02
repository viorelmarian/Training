<?php

require "common.php";

$conn = connect_db($servername, $db_username, $db_password, $database);

    $stmt = $conn->prepare("SELECT * FROM products");
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
      }
    var_dump($products);
    $stmt->close();
?>

<html>
    <head>
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
        <div class="product">
            <img src="images/shoes.jpg" alt="">
            <div class="product_info">
                <h1 id="product_title">Shoes</h1>
                <p id="product_description">The best Shoes.</p>
                <p id="product_price">Price: 199.99 $</p>
                <button id="add_product">Add to cart</button>
            </div>
            
        </div>
    </body>

</html>