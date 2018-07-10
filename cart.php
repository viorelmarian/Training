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
    $name = sanitize($_REQUEST['name']);
    $contact = sanitize($_REQUEST['contact']);
    $comments = sanitize($_REQUEST['comments']);
    if(!empty($_POST['name']) && !empty($_POST['contact']) && !empty($_POST['comments'])) {

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
        $message .=
        '<p>' . $name . '</p>
        <p>' . $contact . '</p>
        <p>' . $comments . '</p>'
        ;
        $message .= '</body></html>';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        mail($to, $subject, $message, $headers);

        $_SESSION['cart'] = [];
        $name = $contact = $comments = '';
    } else {
        if(empty($name)) {
            $name_err = "Name is required.";
        } 
        if(empty($contact)) {
            $contact_err = "Contact Information is required.";
        } 
        if(empty($comments)) {
            $comments_err = "Add a comment.";
        }         
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
            <button><?= translate('Remove all') ?></button>
        </a>
        
        <?php foreach (fetch_products(true) as $product) : ?>

            <div class="product">
                <img src="images/<?= $product["image"] ?>" alt="">
                <div class="product_info">
                    <h1><?= $product["title"] ?></h1>
                    <p><?= $product["description"] ?></p>
                    <p><?= translate('Price: ') ?><?= $product["price"] ?> <?= translate('$') ?></p>
                    <a href="cart.php?id=<?= $product["id"] ?>"><?= translate('Remove') ?></a>
                </div>
            </div>
        
        <?php endforeach; ?>

        <form action="cart.php" method="post">
            <fieldset>
                <input type="text" name="name" placeholder="<?= translate('Name') ?>" autocomplete="off" value="<?= $name ?>">
                <p style="color:red"><?= $name_err ?></p>
                <input type="text" name="contact" placeholder="<?= translate('Contact Information') ?>" autocomplete="off" value="<?= $contact ?>">
                <p style="color:red"><?= $contact_err ?></p>
                <input type="text" name="comments" placeholder="<?= translate('Comments') ?>" value="<?= $comments ?>">
                <p style="color:red"><?= $comments_err ?></p>
                <input type="submit" value="<?= translate('Checkout') ?>">
            </fieldset>
        </form>
    </body>

</html>