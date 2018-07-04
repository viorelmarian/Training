<?php
require_once 'common.php';
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}


if (isset($_REQUEST['logout'])) {
    unset($_SESSION['login']);
    header("Location: login.php");
    exit();
}

if (isset($_REQUEST['id'])) {
    delete_product($_REQUEST['id']);
}

?>
<html>
    <head>
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
        <a href="product.php">
            <button><?= translate('Add') ?></button>
        </a>
        <a href="products.php?logout=1">
            <button><?= translate('Logout') ?></button>
        </a>
        
        <?php foreach (fetch_products(false) as $product) : ?>

            <div class="product">
                <img src="images/<?= $product["image"] ?>" alt="">
                <div class="product_info">
                    <h1><?= $product["title"] ?></h1>
                    <p><?= $product["description"] ?></p>
                    <p><?= translate('Price: ') ?><?= $product["price"] ?> <?= translate('$') ?></p>
                    <a href="product.php?id=<?= $product["id"] ?>"><?= translate('Edit') ?></a>
                    <a href="products.php?id=<?= $product["id"] ?>"><?= translate('Delete') ?></a>
                </div>
            </div>
        
        <?php endforeach; ?>
    </body>
</html>