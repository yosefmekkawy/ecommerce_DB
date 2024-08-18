<?php

include_once '../helpers/DBConnect.php';


function get_categories($order = 'asc')
{
    $conn = connectToDB();
    $data = $conn->query("SELECT * FROM categories ORDER BY id ". strtoupper($order));
    return $data->fetchAll();
}