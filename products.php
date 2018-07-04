<?php
require_once 'common.php';
if (isset($_SESSION['login'])) {
    if (isset($_REQUEST['add'])) {
        unset($_SESSION['product_id']);
        header("Location: product.php");
        exit();
    }
    if (isset($_REQUEST['logout'])) {
        unset($_SESSION['login']);
        header("Location: login.php");
        exit();
    }
    if (isset($_REQUEST['edit'])) {
        $_SESSION['product_id'] = $_REQUEST['edit'];
        header("location: product.php");
        exit();
    }
    if (isset($_REQUEST['delete'])) {
        delete_product($_REQUEST['delete']);
    }
} else {
    header("Location: login.php");
    exit();
}


?>

<html>
    <head>
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
        <a href="products.php?add=1">
            <button id="toCart"><?= translate('Add') ?></button>
        </a>
        <a href="products.php?logout=1">
            <button id="toCart"><?= translate('Logout') ?></button>
        </a>
        
        <?php foreach (fetch_products(false) as $product) : ?>

            <div class="product">
                <img src="images/<?= $product["image"] ?>" alt="">
                <div class="product_info">
                    <h1 id="product_title"><?= $product["title"] ?></h1>
                    <p id="product_description"><?= $product["description"] ?></p>
                    <p id="product_price"><?= translate('Price: ') ?><?= $product["price"] ?> <?= translate('$') ?></p>
                    <a href="products.php?edit=<?= $product["id"] ?>"><?= translate('Edit') ?></a>
                    <a href="products.php?delete=<?= $product["id"] ?>"><?= translate('Delete') ?></a>
                </div>
            </div>
        
        <?php endforeach; ?>
    </body>
</html>