<?php 
    require_once 'common.php';
    if(isset($_REQUEST['remove'])) {
        if($_REQUEST['remove'] == 'all') {
            unset($_SESSION['cart']);
            array_push($_SESSION['cart'],'0');
            header("Location: cart.php");
            exit();
        } else {
            unset($_SESSION['cart'][$_REQUEST['remove']]);
            header("Location: cart.php");
            exit();
        }
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
        <a href="index.php">
            <button><?= translate('Go to index') ?></button>
        </a>
        <a href="cart.php?remove=all">
            <button><?= translate('Remove all') ?></button>
        </a>
        
        <?php foreach ((array)fetch_products_cart() as $product) : ?>

            <div class="product">
                <img src="images/<?= $product["image"] ?>" alt="">
                <div class="product_info">
                    <h1 id="product_title"><?= $product["title"] ?></h1>
                    <p id="product_description"><?= $product["description"] ?></p>
                    <p id="product_price"><?= translate('Price: ') ?><?= $product["price"] ?> <?= translate('$') ?></p>
                    <a href="cart.php?remove=<?= $product["id"] ?>"><?= translate('Remove') ?></a>
                </div>
            </div>
        
        <?php endforeach; ?>
    </body>

</html>