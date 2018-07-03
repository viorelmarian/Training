<?php
require_once 'config.php';

session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
    array_push($_SESSION['cart'],'0');
}


function sanitize($data) {
    $data = strip_tags($data);
    return $data;
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
    foreach($array as $key => $value)
        $refs[$key] = &$array[$key];
    return $refs;
    
}

function fetch_products() {
    $conn = connect_db();
    
    $query = "";
    $identifiers = "";
    $variables = "";
    for($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
        $query .= '?, ';
        $identifiers .= 's';
        $variables .= '&$_SESSION["cart"]["' . $i . '"],';
    }
    $query = rtrim($query, ', ');
    $variables = rtrim($variables, ', ');
    $variables = explode(',', $variables);

    $stmt = $conn->prepare("select * from products where id not in (" . $query . ")");

    $param = array($identifiers);

    for($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
        array_push($param, $_SESSION['cart'][$i]);
    }
    call_user_func_array(array($stmt, 'bind_param'), refValues($param));

    $stmt->execute();

    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    return $products;
}

function fetch_products_cart() {
    $conn = connect_db();
    
    $query = "";
    $identifiers = "";
    $variables = "";
    for($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
        $query .= '?, ';
        $identifiers .= 's';
        $variables .= '&$_SESSION["cart"]["' . $i . '"],';
    }
    $query = rtrim($query, ', ');
    $variables = rtrim($variables, ', ');
    $variables = explode(',', $variables);

    $stmt = $conn->prepare("select * from products where id in (" . $query . ")");

    $param = array($identifiers);

    for($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
        array_push($param, $_SESSION['cart'][$i]);
    }
    call_user_func_array(array($stmt, 'bind_param'), refValues($param));

    $stmt->execute();

    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    return $products;
}

function translate($str) {
    return $str;
}