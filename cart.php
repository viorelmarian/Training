<?php 
require_once 'common.php';

if (isset($_REQUEST['id'])) {
    if ($_REQUEST['id'] == 'all') {
        $_SESSION['cart'] = [];
    } else {
        $key = array_search($_REQUEST['id'], $_SESSION['cart']);
        if ($key !== false) {
            unset($_SESSION['cart'][$key]);
        }
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_POST['name']) && !empty($_POST['contact']) && !empty($_POST['comments'])) {

        $name = sanitize($_REQUEST['name']);
        $contact = sanitize($_REQUEST['contact']);
        $comments = sanitize($_REQUEST['comments']);

        $to = manager_email;

        $subject = "Ordered Products";

        $message = '<html><body>';
        foreach (fetch_products(true) as $product) {
            $message .= 
            '<br><br>
            <img src="http://' . $_SERVER['SERVER_NAME'] . '/images/' . $product['image'] . '" height="150" width="150" align="left">
            <h1 align="top">' . $product["title"] . '</h1>
            <p>' . $product["description"] . '</p>
            <p>' . translate('Price: ') . $product["price"] . translate('$') . '</p>
            <hr>';
        }
        $message .= '</body></html>';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        mail($to, $subject, $message, $headers);
    }
}
    
?>
<html>
    <head>
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/cart.css">
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

        <form action="cart.php" method="post" id="checkout_form">
            <fieldset>
                <input type="text" name="name" id="name" placeholder="Name" autocomplete="off">
                <input type="text" name="contact" id="contact" placeholder="Contact Information" autocomplete="off">
                <textarea type="text" name="comments" id="comments" placeholder="Comments"></textarea>
                <input type="submit" value="Checkout" id="checkout">
            </fieldset>
        </form>
    </body>

</html>