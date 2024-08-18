<?php

include_once '../helpers/DBConnect.php';


function get_orders($order = 'asc')
{
    $conn = connectToDB();
    $data = $conn->query("SELECT * FROM orders ORDER BY id ". strtoupper($order));
    return $data->fetchAll();
}