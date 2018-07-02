<?php

require "config.php";

function sanitize($data) {
    $data = strip_tags($data);
    return $data;
}

function connect_db($servername, $db_username, $db_password, $database) {
    $conn = new mysqli($servername, $db_username, $db_password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}