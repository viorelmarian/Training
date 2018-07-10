<?php
require_once 'common.php';
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$product_info = [
    'id' => '',
    'title' => '',
    'description' => '',
    'price' => '',
    'image' => ''
];


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_info['title'] = sanitize($_REQUEST['title']);
    $product_info['description'] = sanitize($_REQUEST['description']);
    $product_info['price'] = sanitize($_REQUEST['price']);
    $product_info['image'] = get_product($_REQUEST['id'])['image'];

    $target_dir = "images/";
    $image_err = '';
    $uploadOk = 0;

    if (empty($_FILES["image"]["tmp_name"])) {
        if (!isset($_REQUEST['id']) || !$_REQUEST['id']) {
            $image_err = translate("Image is required");
        }
    } elseif (!getimagesize($_FILES["image"]["tmp_name"])) {
        $image_err= translate("Not an image.");
    } else {
        $product_info['image'] = time() . uniqid(rand()) . "." . pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $product_info['image'])) {
            $product_info['image'] = '';
        } else {
            $uploadOk = 1;
        }
    }    
    
   
    if(
        !$image_err
        && !empty($_REQUEST['title'])
        && !empty($_REQUEST['description']) 
        && !empty($_REQUEST['price'])
    ) {

        if (isset($_REQUEST['id']) && $_REQUEST['id']) {
            $product_info['id'] = $_REQUEST['id'];
            if ($uploadOk) {
                unlink("images/" . get_product($_REQUEST['id'])['image']);
            }
        }

        save_product($product_info);

        header("Location: products.php");
        exit();
} else {
        if (empty($_REQUEST['title'])) {
            $title_err = "Title is required";
        } 
        if (empty($_REQUEST['description'])) {
            $description_err = "Description is required";
        } 
        if (empty($_REQUEST['price'])) {
            $price_err = "Price is required";
        }
    }
} elseif (isset($_REQUEST['id'])) {
    $product_info = get_product($_REQUEST['id']);
}
?>
<html>
    <head>
        <link rel="stylesheet" href="css/product.css">
    </head>
    <body>
        <form action="product.php<?= isset($_REQUEST['id']) ? '?id=' . $_REQUEST['id'] : '' ?>" method="post" enctype="multipart/form-data">
            <fieldset>
                <input type="text" name="title"  autocomplete="off" placeholder="Title" value="<?= $product_info['title'] ?>">
                <p style="color:red"><?= $title_err ?></p>
                <input type="text" name="description"  autocomplete="off" placeholder="Description" value="<?= $product_info['description'] ?>">
                <p style="color:red"><?= $description_err ?></p>
                <input type="text" name="price"  autocomplete="off" placeholder="Price" value="<?= $product_info['price'] ?>">
                <p style="color:red"><?= $price_err ?></p>
                <input type="file" name="image" style="align:left;">
                <br>
                <p style="color:red"><?= $image_err ?></p>
                <br>
                <div class="preview" >
                    <?php if ($product_info['image']) : ?>
                        <img style="width:100px;height:100px;" src="http://shopping.com/images/<?=$product_info['image']?>" alt="">
                    <?php endif; ?>
                </div>
                <input type="submit" value="Save">
            </fieldset>
        </form>
    </body>
</html>