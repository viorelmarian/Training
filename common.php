<?php
require_once 'config.php';

session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


function sanitize($data) {
    return strip_tags($data);
}

function connect_db() {
    $conn = new mysqli(db_servername, db_username, db_password, db_database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function refValues($array){
    
    $refs = array();
    foreach($array as $key => $value) {
        $refs[$key] = &$array[$key];
    }
    return $refs;
    
}

function fetch_products($cart = false) {
    $conn = connect_db();

    if (count($_SESSION['cart']) ) {
        $query = "";
        $identifiers = "";
        for($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
            $identifiers .= 's';
        }

        $stmt = $conn->prepare("select * from products where id " . ($cart ? '' : 'not') . " in (" . implode(',',array_fill(0, count($_SESSION['cart']), '?')) . ")");

        $params = array_merge(array($identifiers), $_SESSION['cart']);

        call_user_func_array(array($stmt, 'bind_param'), refValues($params));
    } elseif ($cart) {
        return [];
    } else {
        $stmt = $conn->prepare("select * from products");
    }

    $stmt->execute();
    
    $products = [];

    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        $products[] = (array)$row;
    }
    
    return $products;
}

function translate($str) {
    return $str;
}

function delete_product($id) {
    $conn = connect_db();
    $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

function edit_product($id, $title, $description, $price, $image) {
    $conn = connect_db();
    $stmt = $conn->prepare("UPDATE products SET title=?, description=?, price=?, image=? WHERE id=? ");
    $stmt->bind_param('ssdsi', $title, $description, $price, $image, $id);
    $stmt->execute();
}

function add_product($title, $description, $price, $image) {
    $conn = connect_db();
    $stmt = $conn->prepare("INSERT INTO `products`(`title`, `description`, `price`, `image`) VALUES (?,?,?,?)");
    $stmt->bind_param('ssds', $title, $description, $price, $image);
    $stmt->execute();
}