<?php
session_start();
require "config.php";

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

function fetch_products() {
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT * FROM products");
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
