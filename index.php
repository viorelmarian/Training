<?php
require_once 'common.php';

if(isset($_REQUEST['id'])) {
    $_SESSION['cart'][] = $_REQUEST['id'];
}

?>
<html>
    <head>
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
        <a href="cart.php">
            <button><?= translate('Go to cart') ?></button>
        </a>
        
        <?php foreach (fetch_products(false) as $product) : ?>

            <div class="product">
                <img src="images/<?= $product["image"] ?>" alt="">
                <div class="product_info">
                    <h1><?= $product["title"] ?></h1>
                    <p><?= $product["description"] ?></p>
                    <p><?= translate('Price: ') ?><?= $product["price"] ?> <?= translate('$') ?></p>
                    <a href="index.php?id=<?= $product["id"] ?>"><?= translate('Add to cart') ?></a>
                </div>
            </div>
        
        <?php endforeach; ?>
    </body>

</html>