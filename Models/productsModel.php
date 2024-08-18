<?php

include_once '../helpers/DBConnect.php';


function get_products($order = 'asc')
{
    $conn = connectToDB();
    $data = $conn->query("SELECT * FROM products ORDER BY id ". strtoupper($order));
    return $data->fetchAll();
}