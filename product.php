<?php
require_once 'common.php';
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$target_dir = "images/";
$target_file = time().uniqid(rand()) . ".jpg";
$uploadOk = 1;


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $product_info['title'] = sanitize($_REQUEST['title']);
    $product_info['description'] = sanitize($_REQUEST['description']);
    $product_info['price'] = sanitize($_REQUEST['price']);
    $product_info['image'] = $_FILES["image"]["name"];
    
    if (empty($_FILES["image"]["tmp_name"])) {
        $image_err = "Image is required";
    } else {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
    }
    
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        $image_err= "Not an image.";
    }

    if ($uploadOk != 0) {
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $target_file);
    }

    if(
        !empty($_REQUEST['title']) && !empty($_REQUEST['description']) 
        && !empty($_REQUEST['price'] && $uploadOk != 0)
    ) {

        if (($_REQUEST['id']) != "") {
            $old_image = get_product($_REQUEST['id'])['image'];
            unlink("images/" . $old_image);
            edit_product($_REQUEST['id'], $product_info['title'], $product_info['description'], $product_info['price'], $target_file);
            header("Location: products.php");
            exit();
        } else {
            add_product($product_info['title'], $product_info['description'], $product_info['price'], $target_file);
            header("Location: products.php");
            exit();
        }
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
} else {
    if (isset($_REQUEST['id'])) {
        $product_info = get_product($_REQUEST['id']);
    } else {
        $product_info = [];
    }
    
}
?>
<html>
    <head>
        <link rel="stylesheet" href="css/product.css">
    </head>
    <body>
        <form action="product.php?id=<?= $_REQUEST['id'] ?>" method="post" enctype="multipart/form-data">
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
                    <img style="width:100px;height:100px;" src="http://shopping.com/images/<?=$product_info['image']?>" alt="">
                </div>
                <input type="submit" value="Save">
            </fieldset>
        </form>
    </body>
</html>