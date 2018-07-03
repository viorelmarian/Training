<?php 
require_once 'common.php';

if(isset($_REQUEST['id'])) {
    if($_REQUEST['id'] == 'all') {
        $_SESSION['cart'] = [];
    } else {
        $key = array_search($_REQUEST['id'], $_SESSION['cart']);
        if ($key !== false) {
            unset($_SESSION['cart'][$key]);
        }
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
        <a href="cart.php?id=all">
            <button><?= translate('remove all') ?></button>
        </a>
        
        <?php foreach (fetch_products(true) as $product) : ?>

            <div class="product">
                <img src="images/<?= $product["image"] ?>" alt="">
                <div class="product_info">
                    <h1 id="product_title"><?= $product["title"] ?></h1>
                    <p id="product_description"><?= $product["description"] ?></p>
                    <p id="product_price"><?= translate('Price: ') ?><?= $product["price"] ?> <?= translate('$') ?></p>
                    <a href="cart.php?id=<?= $product["id"] ?>"><?= translate('remove') ?></a>
                </div>
            </div>
        
        <?php endforeach; ?>
    </body>

</html>